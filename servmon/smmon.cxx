#include "smstdinc.hxx"
#include "smutl.hxx"
#include "smmon.hxx"
#include "smtmr.hxx"
#include "smcfg.hxx"
#include "smirc.hxx"

/* this should be in smstdinc, but i'd rather not pollute the entire
   namespace with C crud */
#include <net-snmp/net-snmp-config.h>
#include <net-snmp/net-snmp-includes.h>

#include <mysql/mysql.h>

namespace smmon {

class snmpclient {
public:
	snmpclient(str host_, int port_ = 161)
		: host(host_)
		, port(port_)
		, hostport(b::io::str(b::format("%s:%d") % host_ % port_))
		{}

	b::any getoid(str oidname) {
		snmp_session   session, *ss;
		snmp_pdu      *pdu, *response;
		oid            anoid[MAX_OID_LEN];
		size_t         anoidlen = MAX_OID_LEN;
		variable_list *vars;
		int            status;
	       
		static bool init = false;

		if (!init)
			init_snmp("servmon"), init++;

		snmp_sess_init(&session);
		session.peername = const_cast<char *>(hostport.c_str());
		session.version = SNMP_VERSION_1;
		session.remote_port = port;
		session.community = reinterpret_cast<u_char *>(const_cast<char *>("public"));
		session.community_len = strlen(reinterpret_cast<char const *>(session.community));

		ss = snmp_open(&session);
		if (!ss) {
			snmp_perror("snmp");
			return b::any();
		}

		pdu = snmp_pdu_create(SNMP_MSG_GET);
		read_objid(oidname.c_str(), anoid, &anoidlen);
		snmp_add_null_var(pdu, anoid, anoidlen);
		status = snmp_synch_response(ss, pdu, &response);
		b::any res;
		if (status == STAT_SUCCESS && response->errstat == SNMP_ERR_NOERROR) {
			vars = response->variables;
			if (vars->type == ASN_OCTET_STR) {
				std::string s;
				s.assign(vars->val.string, vars->val.string + vars->val_len);
				res = s;
			} else if (vars->type == 0x41) { /* Counter32 */
				uint32_t i = 0;
				memcpy(&i, vars->val.bitstring, std::max(std::size_t(4), vars->val_len));
				res = i;
			} else if (vars->type == ASN_INTEGER) {
				res = *vars->val.integer;
			}
		} else {
			if (status == STAT_SUCCESS)
				std::cerr << snmp_errstring(response->errstat);
			else
				snmp_sess_perror("snmpget", ss);
		}
		snmp_free_pdu(response);
		snmp_close(ss);
		return res;
	}
		
private:
	std::string host;
	int port;
	std::string hostport;
};

struct mysqlerr : public std::runtime_error {
	mysqlerr(str s) : std::runtime_error(s) {}
};
	
class mysqlclient {
public:
	mysqlclient(str host_, int port_ = 0)
	: host(host_)
	, port(port_)
	, connected(false)
	{}
	
	~mysqlclient() {
		if (connected)
			mysql_close(&connection);
	}
	
	void connect(void) {
		mysql_init(&connection);
		mysql_options(&connection, MYSQL_READ_DEFAULT_GROUP, "servmon");
		unsigned int tm = 5;
		mysql_options(&connection, MYSQL_OPT_CONNECT_TIMEOUT, reinterpret_cast<char const *>(&tm));
		std::string user, pass;
		try {
			user = SMI(smcfg::cfg)->fetchstr("/monit/mysql/username");
			pass = SMI(smcfg::cfg)->fetchstr("/monit/mysql/password");
		} catch (smcfg::nokey&) {
			throw mysqlerr("username/password not specified");
		}
		if (!mysql_real_connect(&connection, host.c_str(), user.c_str(), pass.c_str(),
					NULL, port, NULL, 0)) {
			throw mysqlerr(mysql_error(&connection));
		}
		connected = true;
	}
	typedef std::map<std::string, std::string> row;
	typedef std::vector<row> resultset;
	resultset query(str query) {
		if (!connected) connect();
		int ret = mysql_real_query(&connection, query.c_str(), query.size());
		if (ret) throw mysqlerr(mysql_error(&connection));
		MYSQL_RES *res = mysql_store_result(&connection);
		MYSQL_ROW mr;
		MYSQL_FIELD *fields = mysql_fetch_fields(res);
		resultset resset;
		int numrows = mysql_num_fields(res);
		while (mr = mysql_fetch_row(res)) {
			row r;
			unsigned long *lengths = mysql_fetch_lengths(res);
			for (int i = 0; i < numrows; ++i) {
				std::string cname = fields[i].name;
				std::string data;
				if (mr[i])
					data.assign(mr[i], mr[i] + lengths[i]);
				r[cname] = data;
			}
			resset.push_back(r);
		}
				
		mysql_free_result(res);
		return resset;
	}
	static mysqlclientp forhost(str host) {
		std::map<std::string, mysqlclientp>::iterator it = clients.find(host);
		if (it != clients.end()) return it->second;
		return clients[host] = mysqlclientp(new mysqlclient(host));
	}
private:
	static std::map<std::string, mysqlclientp> clients;
	bool connected;
	
	std::string host;
	int port;
	MYSQL connection;
};
std::map<std::string, mysqlclientp> mysqlclient::clients;
	
xomitr::xomitr() : v(0), l(0) {}
	
uint32_t
xomitr::val(uint32_t newval)
{
	std::time_t then = l;
	if (v == 0) v = newval;
	std::time_t now = std::time(0);
	l = now;
	uint64_t q = v, nv = newval;
	v = nv;
	if (nv < q)
		nv = uint64_t(4294967296LL) + nv;
	return (nv - q) / (now - then);
}
	
void
cfg::initialise(void)
{
	try {
		std::set<std::string> servers = SMI(smcfg::cfg)->fetchlist("/monit/servers");
		FE_TC_AS(std::set<std::string>, servers, i) {
			create_server(*i, SMI(smcfg::cfg)->fetchstr("/monit/server/"+*i+"/type"), false);
		}
	} catch (smcfg::nokey&) {}
	checker *c = new checker();
	c->run();
}

void
cfg::checker::chk1(void)
{
	try {
		b::try_mutex::scoped_try_lock m (chk_m);
		std::map<std::string, serverp>& serverlist = SMI(cfg)->servers();
		for(std::map<std::string, serverp>::const_iterator
			    it = serverlist.begin(), end = serverlist.end(); it != end; ++it) {
			it->second->check();
		}
	} catch (b::lock_error&) {
		std::cerr << "warning: could not lock mutex for check\n";
		return;
	}
}

void
cfg::checker::start(void)
{
	static int lastirc = 0;
	for (;;) {
		int interval = 10, ircinterval = 60;
		try {
			interval = SMI(smcfg::cfg)->fetchint("/monit/interval");
		} catch (smcfg::nokey&) {}
		try {
			ircinterval = SMI(smcfg::cfg)->fetchint("/monit/ircinterval");
		} catch (smcfg::nokey&) {}
		
		sleep(interval);
		chk1();

		/* IRC report */
		std::string rep;
		b::try_mutex::scoped_lock m (chk_m);
		std::map<std::string, serverp>& serverlist = SMI(cfg)->servers();

                /* mysql */
		std::map<std::string, std::string> mysqlreps;
		for(std::map<std::string, serverp>::const_iterator
			    it = serverlist.begin(), end = serverlist.end(); it != end; ++it) {
			if (it->second->type() != "MySQL") continue;
			b::shared_ptr<mysqlserver> s = b::dynamic_pointer_cast<mysqlserver>(it->second);
			mysqlreps[it->first] = "\002" + it->first + "\002: " + s->fmt4irc() + " ";
		}
		/* do master first, then the rest */
		std::string mastername;
		try {
			mastername = SMI(smcfg::cfg)->fetchstr("/monit/mysql/master");
			std::map<std::string,std::string>::iterator it = mysqlreps.find(mastername);
			if (it != mysqlreps.end()) {
				rep += it->second;
				mysqlreps.erase(it);
			}
		} catch (smcfg::nokey&) {}
		for(std::map<std::string,std::string>::iterator it = mysqlreps.begin(),
			    end = mysqlreps.end(); it != end; ++it) {
			rep += it->second;
		}
	       
		/* squids */
		int squidreqs = 0, squidhits = 0;
		for(std::map<std::string, serverp>::const_iterator
			    it = serverlist.begin(), end = serverlist.end(); it != end; ++it) {
			if (it->second->type() != "Squid") continue;
			b::shared_ptr<squidserver> s = b::dynamic_pointer_cast<squidserver>(it->second);
			rep += "\002" + it->first + "\002: ";
			rep += s->fmt4irc() + " ";
			squidreqs += s->rpsv;
			squidhits += s->hpsv;
		}
		float squidperc;
		if (squidhits && squidreqs)
			squidperc = (float(squidhits)/squidreqs)*100;
		else squidperc = 0;
		rep += b::io::str(b::format("\002total:\002 \00311%d\003/\00303%d\003/\0036%.02f%%\003") % squidreqs % squidhits % squidperc);

		std::time_t now = std::time(0);
		if ((now - ircinterval) > lastirc) {
			SMI(smirc::cfg)->conn()->msg(rep);
			lastirc = now;
		}
		
	}
}

void
cfg::squidserver::check(void) {
	snmpclient c(name, 3401);
	uint32_t requests, hits;
	try {
		requests = b::any_cast<uint32_t>(c.getoid("1.3.6.1.4.1.3495.1.3.2.1.1"));
		hits = b::any_cast<uint32_t>(c.getoid("1.3.6.1.4.1.3495.1.3.2.1.2"));
	} catch (b::bad_any_cast&) {
		return;
	}
	rpsv = rps.val(requests);
	hpsv = hps.val(hits);
}

uint32_t
cfg::mysqlserver::getqueries(void)
{
	mysqlclientp client = getconn();
	uint32_t queries;
	try {
		mysqlclient::resultset res = client->query("SHOW STATUS LIKE 'QUESTIONS'");
		if (res.size() < 1) {
			std::cerr << "oh no, didn't get a result\n";
			queries = 0;
		} else {
			try {
				queries = b::lexical_cast<uint32_t>(res[0]["Value"]);
			} catch (b::bad_lexical_cast&) {
				queries = 0;
			}
		}
	} catch (mysqlerr&) { queries = 0; }
	return queries;
}

mysqlclientp
cfg::mysqlserver::getconn(void)
{
	return mysqlclient::forhost(name);
}
	
uint32_t
cfg::mysqlserver::getnumprocesses(void)
{
	mysqlclientp client = getconn();
	mysqlclient::resultset res;
	try {
		res = client->query("SHOW PROCESSLIST");
	} catch (mysqlerr& e) {
		std::cerr << "mysql connection error: " << e.what() << "\n";
		return 0;
	}
	int numproc = 0;
	for (uint i = 0; i < res.size(); ++i) {
		if ((res[i]["User"] != "repl" && res[i]["User"] != "system user") && res[i]["Command"] != "Sleep")
			numproc++;
	}
	return numproc;
}
			
void
cfg::mysqlserver::check(void)
{
	uint32_t queries = getqueries();
	qpsv = qps.val(queries);
	procv = getnumprocesses();
	replag = getreplag();
}

uint64_t
cfg::mysqlserver::getmasterpos(void)
{
	std::string mastername;
	try {
		mastername = SMI(smcfg::cfg)->fetchstr("/monit/mysql/master");
	} catch (smcfg::nokey&) {
		return 0;
	}
	mysqlclientp client = mysqlclient::forhost(mastername);
	mysqlclient::resultset r;
	try {
		r = client->query("SELECT MAX(rc_timestamp) AS ts FROM enwiki.recentchanges");
	} catch (mysqlerr& e) {
		std::cerr << "mysql error: " << e.what() << "\n";
		return 0;
	}
	if (r.size() < 1) return 0;
	return b::lexical_cast<uint64_t>(r[0]["ts"]);
}

uint64_t
cfg::mysqlserver::getmypos(void)
{
	mysqlclientp client = getconn();
	mysqlclient::resultset r;
	try {
		r = client->query("SELECT MAX(rc_timestamp) AS ts FROM enwiki.recentchanges");
	} catch (mysqlerr& e) {
		std::cerr << "mysql error: " << e.what() << "\n";
		return 0;
	}
	if (r.size() < 1) return 0;
	return b::lexical_cast<uint64_t>(r[0]["ts"]);
}

uint64_t
cfg::mysqlserver::getreplag(void)
{
	uint64_t masterpos = getmasterpos(), mypos = getmypos();
	std::cerr << "master pos: " << masterpos << " mypos: " << mypos;
	return masterpos - mypos;
}
	
std::string
cfg::mysqlserver::fmt4irc(void) const
{
	std::string rep = b::io::str(b::format("\00311%d\003/\00303%d\003") % procv % qpsv);
	try {
		if (SMI(smcfg::cfg)->fetchstr("/monit/mysql/master") != name) {
			rep += b::io::str(b::format("/\00306%d\003") % replag);
		}
	} catch (smcfg::nokey&) {}
	return rep;
}
	
std::string
cfg::squidserver::fmt4irc(void) const
{
	float perc;
	if (rpsv && hpsv)
		perc = (float(hpsv)/rpsv)*100;
	else perc = 0;
	std::string rep = b::io::str(b::format("\00311%d\003/\00303%d\003/\0036%.02f%%\003") % rpsv % hpsv % perc);
	return rep;
}

bool
cfg::knowntype(str type)
{
	return type == "squid" || type == "mysql";
}

bool
cfg::server_exists(str serv)
{
	return serverlist.find(serv) != serverlist.end();
}

void
cfg::create_server(str serv, str type, bool addconf)
{
	if (server_exists(serv)) return; /* XXX error? */
	try {
		server* s = server_fortype(type, serv);
		serverlist[serv] = serverp(s);
		if (addconf) {
			SMI(smcfg::cfg)->addlist("/monit/servers", serv);
			SMI(smcfg::cfg)->storestr("/monit/server/"+serv+"/type", type);
		}
	} catch (notype&) {
		/* XXX error? */
		return;
	}
}

cfg::server*
cfg::server_fortype(str type, str name)
{
	if (type == "squid") return new squidserver(name);
	if (type == "mysql") return new mysqlserver(name);
	throw notype();
}
	
} // namespace smmon
