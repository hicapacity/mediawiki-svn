/*
 * Copyright 2005 Brion Vibber, Kate Turner
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights 
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in 
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * $Id$
 */

#include <sys/types.h>
#include <sys/socket.h>

#include <netinet/in.h>

#include <arpa/inet.h>

#include <iostream>
#include <vector>
#include <string>
#include <exception>
#include <ctime>

#include <boost/format.hpp>
#include <boost/thread.hpp>
#include <boost/bind.hpp>

using std::string;
using std::vector;
using std::cout;
using std::exception;

using boost::format;
using boost::io::str;
using boost::bind;
using boost::thread;
using boost::condition;

typedef boost::mutex bmutex;

string urlencode(string const& s) {
	string result;
	for (string::const_iterator it = s.begin(), end = s.end(); it != end; ++it)
		if ((*it >= 'a' && *it <= 'z') || (*it >= 'A' && *it <= 'Z'))
			result += *it;
		else
			result += str(format("%%%02x") % (unsigned int)(unsigned char)*it);
	return result;
}

double
timenow(void)
{
	struct timeval tp;
	gettimeofday(&tp, NULL);
	return tp.tv_sec + (double(tp.tv_usec) / 1000000);
}
 
string
tdifffmt(double i)
{
	return str(format("%.4f sec.") % i);
}

template<typename ftype, typename ltype>
void with_lock(ltype& lock, ftype& func)
{
	bmutex::scoped_lock l(lock);
	func();
}

template<typename ltype, typename int_t>
void locked_dec(ltype& lock, int_t& v)
{
	bmutex::scoped_lock l(lock);
	--v;
}

class sample_terms {
private:
	static char const *terms[];
	static size_t const numterms;
	static size_t position;
	static bmutex lock;
	
public:
	static string next(void);
};

class benchmark
{
public:
	static void start(vector<string> args)
	{
		benchmark bench("127.0.0.1", 8123, args.empty() ? "entest" : args[0]);
		bench.runs = 100;
		bench.run_sets(10);
		bench.do_report();
	}
	
private:
	string host;
	u_short port;
	string database;
	int runs;
	
	/* Access these only with timeslock held */
	bmutex timeslock;
	vector<double> times;
	int total_requests;
	int total_results;
	double total_time;
	/* -- */
	
	int running_threads;
	bmutex threadlock;
	condition threadcond;
	
	benchmark(string host_, u_short port_, string database_)
	: host(host_)
	, port(port_)
	, database(database_) 
	, total_requests(0)
	, total_results(0)
	, running_threads(0)
	{}
	
	void run_sets(int threads) {
		running_threads = threads;
		
		for(int i = 0; i < threads; i++)
			thread t(bind(&benchmark::run_one, this));

		// Wait for threads to clean up
		{
			bmutex::scoped_lock l(threadlock);
			while (running_threads > 0) {
				threadcond.wait(l);
			}
		}
	}
	
	 void run_one() {
		cout << format("Starting thread w/ %d runs ...\n") % runs;
		for (int i = 0; i < runs; i++)
			do_search(sample_terms::next());

		locked_dec(threadlock, running_threads);
		threadcond.notify_one();
	}
	
	 void do_search(string term) {
		double start = timenow();
		int client;
		if ((client = socket(PF_INET, SOCK_STREAM, IPPROTO_TCP)) == -1) {
			perror("socket");
			exit(1);
		}
		struct sockaddr_in addr;
		memset(&addr, 0, sizeof(addr));
		addr.sin_port = htons(port);
		addr.sin_family = AF_INET;
		addr.sin_addr.s_addr = inet_addr(host.c_str());
		if (connect(client, (struct sockaddr *)&addr, sizeof(addr)) == -1) {
			perror("connect");
			exit(1);
		}
		FILE* f = fdopen(client, "r+");
		
		string encterm = urlencode(term);
		fprintf(f, "%s\nSEARCH\n%s\n", database.c_str(), encterm.c_str());
		fflush(f);
		
		char nresults[50];
		fgets(nresults, sizeof nresults, f);
		nresults[strlen(nresults) - 1] = '\0';
		string num_results = nresults;
		
		vector<string> lines;
		char line[1024];
		while (fgets(line, sizeof line, f))
			lines.push_back(line);
		int num_received = lines.size() - 1;
		
		fclose(f);
		close(client);
		
		double delta = timenow() - start;

		bmutex::scoped_lock l(timeslock);
		cout << format("[%-70s] % 5d/% 5d %s\n")
			% encterm % num_received % num_results % tdifffmt(delta);
		
		times.push_back(delta);
		total_time += delta;
		total_results += num_received;
		++total_requests;
	}
	
	void do_report() {
		cout << format("Made %d total requests\n") % total_requests;
		cout << format("Received %d total result lines\n") % total_results;
		cout << format("Spent %d total on all requests\n") % tdifffmt(total_time);
		cout << format("Average time per request: %d\n") % tdifffmt((total_time / total_requests));
		cout << format("Average time per result: %d\n") % tdifffmt((total_time / total_results));
		sort(times.begin(), times.end());
		cout << format("Fastest request: %d\n") % tdifffmt(times[0]);
		cout << format("Slowest request: %d\n") % tdifffmt(times[times.size() - 1]);
	}
};

int main(int argc, char *argv[])
{
	benchmark::start(vector<string>(argv + 1, argv + argc));
}


// created on 4/8/2005 at 5:22 PM

char const *sample_terms::terms[] = {
		"1406",
		"new york",
		"cape dagde",
		"Judgement of Solomon",
		"otomi",
		"guitars",
		"Yoshkar-Ola",
		"Halo",
		"Lambert",
		"Shorin Karate",
		"stan musial",
		"donkey punch",
		"herpes",
		"Luigi",
		"emo",
		"pearl harbor",
		"foo",
		"%s",
		"foo",
		"Dextrin",
		"Bob Ross",
		"rocky marciano",
		"stan musial",
		"stock footage",
		"encino",
		"%s",
		"William Golding",
		"fairy tales",
		"Queen of the Night",
		"turquiose",
		"%s",
		"archangel",
		"Yugoslavia",
		"ww1",
		"boron nitride",
		"list of wikis",
		"kongsvinger",
		"carpet beetle",
		"black jewel",
		"black jewel",
		"black jewel",
		"Sauron",
		"AXl Rose",
		"idealism",
		"event horizon",
		"event horizon",
		"moire",
		"list of prime numbers",
		"beetle",
		"methyl isobutyl ketone",
		"carpet beetle",
		"battle raoyale",
		"vienna",
		"birthday boy",
		"orgy",
		"montaigne",
		"methyl isobutyl ketone",
		"boy meets world",
		"augsburger",
		"augsburger",
		"Irving Lambert",
		"maps",
		"stamp act",
		"fuero",
		"Jello Biafra",
		"saleried worker",
		"hornsey",
		"reefer madnes",
		"hprnesey",
		"Cromartie High School",
		"reefer madnes",
		"Cromartie High School",
		"reefer madnes",
		"algeria",
		"reefer madnes",
		"black jewel",
		"reefer madnes",
		"black jewel",
		"Melville",
		"reefer madnes",
		"arman hill",
		"Josef Stalin",
		"name all the pope",
		"hoax",
		"British East India Trading Company",
		"power set",
		"hoax",
		"aurel joliat",
		"Melkor",
		"harford county, maryland",
		"dubai",
		"additives",
		"douglas mc aurthur",
		"banjolele",
		"colorectal",
		"shmyr",
		"megahertz",
		"Roman Catholic",
		"East India Trading Company",
		"Dhalgren",
		"jet stream",
		"Norway",
		"boston tea party",
		".ea",
		"chorizo",
		"Altruism",
		"control experiments",
		"yaoi",
		"Phil",
		"nx bit",
		"Ushakov",
		"las vegas",
		"nx bit",
		"pdf417",
		"tilling",
		"long run probability",
		"Kali",
		"west island",
		"Federation",
		"Strawberry Fields Forever",
		"24 June",
		"Canada",
		"Phil",
		"colorectal cancer",
		"Metallica",
		"mean anomaly",
		"hogans hereos",
		"Mensheviks",
		"colorectal",
		"Largs",
		"National policy",
		"paul wolfowitz",
		"hardcore",
		"property right",
		"file system",
		"PLARO",
		"hogan's hereos",
		"Emerl",
		"The League of Nations",
		"megahertz",
		"Maldoror",
		"celestine",
		"fangorn",
		"hogan's heroes",
		"Maldoror",
		"Maldoror",
		"Maldoror",
		"fangorn",
		"fangorn",
		"hogan's hereos",
		"fangorn",
		"fangorn",
		"fangorn",
		"fangorn",
		"old glory",
		"fangorn",
		"fangorn",
		"fangorn",
		"fangorn",
		"archaelogy",
		"Maldoror",
		"Maldoror",
		"paul erlich",
		"europe",
		"gestalt",
		"largest city area",
		"Maldoror",
		"fusion",
		"black monday",
		"18 string guitar",
		"arthur sullivan",
		"carlos ghosn",
		"peter",
		"metobolic rate",
		"farming",
		"iraq",
		"tilling",
		"flight confirmation",
		"Miss Universe",
		"Maldoror",
		"Docucentric",
		"Maldoror",
		"Maldoror",
		"metobolic rate",
		"koeniggsegg",
		"dance dance revolution",
		"Eisenhower Executive Building",
		"depeche mode",
		"tilling",
		"metobolic rate",
		"celestine V",
		"prisoner of conscience",
		"Fozhou",
		"himmler",
		"Docucentric",
		"Tempest",
		"metobolic rate",
		"hemmingway",
		"diotima",
		"jonestown",
		"koenigsegg",
		"Sir Henry Elliot",
		"koeniggsegg",
		"metobolic rate",
		"metobolic rate",
		"metobolic rate",
		"largest physical city",
		"largest physical city",
		"Fischer",
		"metobolic rate",
		"metobolic rate",
		"metamorphosis",
		"Fuzhou",
		"Gravis",
		"Fozhou",
		"buddy allocator",
		"Fozhou",
		"WSWS",
		"metobolic rate",
		"metobolic rate",
		"archbishop",
		"Eisonhower Executive Building",
		"Dominion",
		"Max Stirner",
		"titmuss",
		"fangorn",
		"mehahertz",
		"fangorn",
		"Job Control Language",
		"Docucentric",
		"dyno",
		"learning",
		"middle age",
		"Yue",
		"nietzche",
		"consumer price index",
		"chechnya",
		"intercourse",
		"Saruman",
		"doraemon",
		"media beauty",
		"thermal expantion of mater+",
		"brian boru",
		"flight confirmation",
		"18 string guitar",
		"capsulitus",
		"thermal expantion of mater+",
		"borda count",
		"F-16",
		"lcsw",
		"Eisonhower Executive Office Building",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"lcsw",
		"Hinduism",
		"Raba",
		"biblical archaeology",
		"Raba",
		"population maps",
		"%s",
		"Raba",
		"peasent",
		"Raba",
		"peasent",
		"liverpool fc",
		"nuclear arms race",
		"cold war",
		"Dominion",
		"Min",
		"maple leaf",
		"anarchism",
		"banjo uke",
		"morrissey",
		"blue jays",
		"thermal expantion of mater+",
		"Ter",
		"capsulitus",
		"Director",
		"chasitity belts",
		"Japanese Constitution",
		"Cardinal",
		"linguine",
		"dynos",
		"liverpool fc",
		"Sauron",
		"wise",
		"canada flag",
		"canada flag",
		"canada flag",
		"canada flag",
		"the deep south",
		"hawk",
		"farlong",
		"Elizabethan era",
		"torii",
		"chinese poetry",
		"scandium",
		"farlong",
		"Islam",
		"farlong",
		"Alaska",
		"chasitity",
		"secret societies",
		"summer",
		"Alabama",
		"matt longwell",
		"population maps",
		"Object Linking and Embedding (OLE)",
		"jesus",
		"undulation sensation",
		"couch rool",
		"masturbation",
		"Sonic X",
		"1972",
		"techno",
		"Goatse",
		"league",
		"banjolin",
		"Object Linking and Embedding (OLE)",
		"distributor",
		"Pierre-Joseph Proudhon",
		"personal stigma's",
		"banjolin",
		"robespierre",
		"MOS",
		"ele",
		"abstinence",
		"undulation sensation",
		"chasitity",
		"YPbPr",
		"Yuexi",
		"Yuexi",
		"Object Linking and Embedding",
		"willow",
		"Object Linking and Embedding (OLE)",
		"Cholestorel",
		"Cholestorel",
		"Cholestorel",
		"flashing",
		"holiness movement",
		"MTA",
		"tanks",
		"matt longwell",
		"valkyries",
		"Cholestorel",
		"Cholestorel",
		"gnp",
		"merkin",
		"azerbaijan",
		"Basketball Dairies",
		"my hero",
		"yacas",
		"YCbCr",
		"gatenby",
		"star wars",
		"sleep",
		"shit hole",
		"jailbait",
		"Scott Bakula",
		"u.s. state flags",
		"multimedia mobile content",
		"creator hyperlink",
		"Scott Bakula",
		"u.s. state flags",
		"u.s. state flags",
		"u.s. state flags",
		"warrior",
		"deviant",
		"Fuck",
		"regret",
		"paper slop",
		"Reggaeton",
		"javac",
		"Church of God 7th Day",
		"royal navy",
		"air jordan",
		"shit hole",
		"light saber",
		"download",
		"slaws",
		"john paul",
		"Cholesterol",
		"ibm",
		"trauma",
		"pope",
		"China",
		"regret",
		"Zora Heale Hurston",
		"Hurston",
		"hyperlink",
		"yng",
		"platinum",
		"creator hyperlink",
		"Cholestorel",
		"billy elliot",
		"slavs",
		"X Window",
		"yang",
		"Atlantic Rowing Challenge",
		"freecell",
		"maryland",
		"PFF",
		"metabolic rate",
		"Undulation Sensation",
		"scene",
		"HAMELET",
		"valinor",
		"linux",
		"Ron Bentley",
		"Egoism",
		"restricted cash",
		"ubuntu linux",
		"1929",
		"phobia",
		"ant",
		"1929",
		"columbus day",
		"Downburst",
		"1900",
		"teaching",
		"WWV",
		"Malta",
		"canon",
		"Undulation Sensation",
		"what is a distributor",
		"page fault frequency",
		"Led Zeppelin",
		"Virgin Islands",
		"Roy Bentley",
		"Alabama",
		"Outer Baldonia",
		"Amped",
		"Pope John Paul II",
		"Oldboy",
		"hacky sack",
		"papal",
		"gatenby",
		"vivaldi",
		"neoclassical",
		"KKK",
		"celibacy",
		"louisiana strawberry festival",
		"Bartolo Colon",
		"Access Control List",
		"trade associations",
		"%s",
		"larry hovis",
		"mercator projection",
		"%s",
		"Philip Dick",
		"calibre",
		"heart worms",
		"&#1589;&#1608;&#1585;&#1587;&#1603;&#1587; &#1605;&#1593; &#1575;&#1604;&#1605;&#1608;&#1602;&#1593;",
		"betty shabazz",
		"tilde",
		"the motorcycle diaries",
		"baileys",
		"Pop Funk",
		"economics",
		"Emmitt Smith",
		"blood test",
		"homeostasis",
		"pope",
		"deterministic",
		"princess dianna",
		"Jesuits",
		"Clark Kent ERvin",
		"Roy Bentley",
		"%s",
		"earth sphere",
		"Charles Kennedy",
		"jay rockefeller",
		"GMAT test",
		"montana",
		"GMAT test",
		"Shimabara Uprising",
		"jay rockefeller",
		"first order logic",
		"athay",
		"Mortal Kombat",
		"Monsenior",
		"Luwian_language",
		"earth",
		"sea otter",
		"coliseum",
		"Clark Kent Ervin",
		"relative dating",
		"largest mass movement of our time",
		"dialectical materialism",
		"Tim Pawlenty",
		"ikarus",
		"George Bush",
		"veil of ignorance",
		"shmyr",
		"iguanas",
		"athay",
		"athay",
		"diesel",
		"LOU REED",
		"fallout (game)",
		"about",
		"Germany",
		"The Planet Smashers",
		"kundera",
		"yugoslavia",
		"Kim Il Sung",
		"great satan",
		"divisible",
		"larry flynt",
		"Ronald Reagan",
		"Remote Procedure Call",
		"shoes",
		"shoes",
		"coagulation",
		"Jamsey",
		"shoes",
		"fuegians",
		"GMAT",
		"fuegians",
		"fuegians",
		"interrobang",
		"GMAT test",
		"fuegians",
		"Yosemite park",
		"fuegians",
		"fuegians",
		"%s",
		"fuegians",
		"balance of trade",
		"fuegians",
		"fuegians",
		"fuegians",
		"fuegians",
		"fuegians",
		"sazae",
		"de medici",
		"fuegians",
		"wwf summerslam 1997",
		"wwf summerslam 1997",
		"wwf summerslam 1997",
		"wwf summerslam 1997",
		"portal",
		"George Carlin",
		"papal",
		"Sergei Soloviev",
		"badass",
		"Sergei Soloviev",
		"Sergei Soloviev",
		"thought experiment",
		"code locality",
		"hierarchy",
		"freedom of information act",
		"bad ass",
		"lithography",
		"balance of trade",
		"rousseau",
		"drummond montana",
		"sales discounts",
		"biggest concentration camps",
		"jail bait",
		"GUI",
		"secretion",
		"Supervolcano",
		"Clarence Thomas",
		"drummond",
		"will smith",
		"Alabama",
		"henry kissinger",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"entropy",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"Applied Materials, Inc.",
		"hyperspace war",
		"morgenthau",
		"morgenthau",
		"Donkey Punch",
		"Parnassian",
		"the dakota",
		"120ms",
		"ernesto guevara de la serna",
		"tendai",
		"bill elliot",
		"when a stranger calls",
		"heartworms",
		"Applied Materials,",
		"when a stranger calls",
		"nx bit",
		"Mau Mau",
		"Cyrillization",
		"furlong",
		"ching",
		"Applied Materials",
		"licensed clinical social worker",
		"gut cherry",
		"sex",
		"ernesto guevara",
		"j robert oppenheimer",
		"Hispanic",
		"nosferatu",
		"ernesto guevara de la serna",
		"Jim Corbet",
		"xmen",
		"when a stranger calls",
		"gary blank",
		"mango",
		"adverbial",
		"james cattell",
		"alveoloar ventilation rate",
		"fiend",
		"ancestor internet",
		"vietnam war",
		"saul bellow",
		"Fourier number",
		"robert oppenheimer",
		"marten",
		"j robert oppenheimer",
		"Trek BBS",
		"C. S. Lewis",
		"technology",
		"Devin Brown",
		"gutt cherry",
		"Fourier number",
		"Menu-Driven Interface",
		"Paris",
		"Love",
		"french resistance",
		"blank",
		"spanish language",
		"gary blank",
		"Jim Corbett",
		"qing",
		"psychology corporation",
		"election of 1948",
		"radio",
		"milzn",
		"jews",
		"Wayne Gretzky",
		"Menu Driven Interface",
		"internet",
		"Anakim",
		"milan kundera",
		"kepler",
		"ancestor internet",
		"pegasus bridge",
		"simpsons",
		"Anakites",
		"christening",
		"RAID server",
		"james cattell",
		"gut cherry tree",
		"steve emerson",
		"SX",
		"Muslim League",
		"markov model",
		"Brave Soul",
		"philo",
		"Exam",
		"burckhardt",
		"Horse Power",
		"Walkabout",
		"mickey mouse",
		"Anschluss",
		"RAID",
		"carpal tunnel syndrome",
		"lupus erythematosis",
		"RAID server",
		"green alga",
		"Kent Flannery",
		"india",
		"carpel tunnel syndrome",
		"malaria",
		"okafor",
		"%s",
		"steven emerson",
		"TrekBBS",
		"lupus",
		"Machiavelli",
		"milan",
		"New York City",
		"e-text",
		"constantine of greece",
		"lupus erythematosis",
		"pope",
		"jacob burckhardt",
		"Scoopes Trail",
		"church of ireland",
		"diaper",
		"Trek BBS",
		"burckhardt",
		"christian bale",
		"markov chain",
		"maiakovski",
		"Tiberias",
		"NaN3",
		"mountain man",
		"Bermuda",
		"pope john paul",
		"jurassic five",
		"doom",
		"hentai",
		"thumb",
		"Brave Soul",
		"Scopes Trail",
		"Me 262",
		"common carrier",
		"Scopes Trail",
		"Scopes Trail",
		"waffle",
		"Rosa Parks",
		"kerik",
		"Josef Mengele",
		"grey woodpecker",
		"Dornier Do 17",
		"london",
		"Vegetarianism",
		"PAKISTAN",
		"whips",
		"distributed systems",
		"theme",
		"ferrari",
		"spybot search and destroy",
		"sawtooth wave",
		"jeff gannon",
		"jellyfish",
		"anal sex",
		"fast disk",
		"Greece",
		"Harold Fraser-Simson",
		"bloodhound gang",
		"Good neighbor policy",
		"kgb",
		"Henry Cabot Lodge",
		"FARC",
		"Coffee",
		"grey woodpecker",
		"cougar",
		"Scoopes Trial",
		"the fox sisters",
		"jeremy clarkson",
		"%s",
		"philadelphia",
		"Ghandi Arrives in India",
		"Ted Hall",
		"RAW",
		"fuck",
		"amphisbaenid",
		"Greek alphabet",
		"wwf summerslam 1997",
		"amphisbaenid",
		"amphisbaenid",
		"laskarina bouboulina",
		"European Union",
		"april 8",
		"amphisbaenid",
		"Cyrillic",
		"amphisbaenid",
		"small liver fluke",
		"amphisbaenid",
		"Palmer Raids",
		"amphisbaenid",
		"Scoopes Trial",
		"falun gong",
		"karl marx",
		"TETAMANZI",
		"alias",
		"Otto von Bismarck",
		"bipolar",
		"bi polar",
		"Pope",
		"lake havasu city",
		"insecticide",
		"genital warts",
		"separation powers",
		"monaco",
		"google gulp",
		"sandrine erdely-sayo",
		"alberT The beaRt",
		"ASL",
		"Ethan Forsythe",
		"no depression",
		"male muscian politicians",
		"alberT The beaR",
		"Nigger",
		"Yugoslavia",
		"ontario progressive conservative",
		"Pope John Paul II",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"%s",
		"ontario progressive conservative",
		"One-T",
		"duct tape",
		"grid cluster",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"alberT The beaR",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"ontario progressive conservative",
		"brazil",
		"ontario progressive conservative",
		"Time Delation",
		"swiss guards",
		"Chris Tomlin",
		"van't hoff equation",
		"brazil",
		"buddism",
		"Chronic Future",
		"apple",
		"Russian indepence",
		"olympic park bombing",
		"once upon a time in china",
		"bbw",
		"ikaria",
		"pavese",
		"company",
		"WP:RFC",
		"The Lions of Savo",
		"rules of attraction",
		"robert crane",
		"antisemitism",
		"porsche",
		"stamps.com",
		"Razim MAhfuz",
		"Suetonius",
		"otto the great",
		"black penis",
		"Indexed colors",
		"Russia",
		"rules of attraction",
		"Someday my prince will come",
		"Spic",
		"humanresaurce",
		"airlines",
		"Major League Baseball",
		"MAhfuz",
		"elia",
		"wong fei hung",
		"vacuum fluxation",
		"boo",
		"glut",
		"PULO",
		"map",
		"catch 22",
		"MAhfuz",
		"RGB",
		"Judgement of Solomon",
		"easton ellis",
		"cyst",
		"vcf",
		"Cambell",
		"maRch oF branDEnBErg",
		"The Weavers",
		"aliens",
		"lawrence",
		"Cambell",
		"Xbox 2",
		"star wars",
		"cat",
		"Soviet Union",
		"tune in",
		"Patterson",
		"sogo shosha",
		"Brandenberg",
		"Race, The Floating Signifier",
		"maRch oF branDEnBErg",
		"max hardcore",
		"wheee",
		"john paul II",
		"Prostatectomy",
		"john paul II",
		"color",
		"Steven Curtis Chapman",
		"john paul II",
		"Yagi",
		"Chris Tomlin",
		"whee",
		"easton ellis",
		"Kite",
		"honeydrippers",
		"%s",
		"Prostatectomy",
		"honeydrippers",
		"vacuum fluctuation",
		"vacuum fluxation",
		"statue of liberty",
		"Donald Williams",
		"JAMESTOWN",
		"apocalyptic",
		"JAMESTOWN",
		"statue of liberty",
		"King Constaintine II",
		"Campbell",
		"candids",
		"candids",
		"candids",
		"candids",
		"candids",
		"candids",
		"kay lenze",
		"candids",
		"candids",
		"candids",
		"candids",
		"candids",
		"candids",
		"ford explorer",
		"candids",
		"jimmy page",
		"cantaloupe receipt",
		"honeydrippers",
		"shreveport, louisiana",
		"Mugabe",
		"auto fellatio",
		"candid",
		"vca",
		"Prostatectomy",
		"capitol",
		"Beatniks",
		"hysteresis",
		"wmba",
		"Ronnie James Dio",
		"Fairbairn",
		"karim",
		"volcom",
		"Charlotte ross"
	};
size_t sample_terms::position = 0;
size_t const sample_terms::numterms = sizeof(sample_terms::terms) / sizeof(*sample_terms::terms);
bmutex sample_terms::lock;
	
string sample_terms::next(void) {
	{
		bmutex::scoped_lock l(lock);
		string next = terms[position];
		if (++position >= numterms)
			position = 0;
		return next;
	}
}
