/* @(#) $Header$ */
#include "smstdinc.hxx"
#include "smlog.hxx"
#include "smirc.hxx"
#include "smthr.hxx"

namespace smlog {

namespace {
	struct loglsnd : smthr::daemon {
		loglsnd(void) {
		}
		void start(void) {
			smnet::lsnrp s (new smnet::lsnr(smnet::unix));
			std::remove("/tmp/servmon.log");
			s->node("/tmp/servmon.log");
			try {
				s->lsn();
			} catch (smnet::sckterr& e) {
				SMI(log)->logmsg(0, std::string("Listen failed for log socket: ") + e.what());
				return;
			}
			boost::function<void(smnet::scktp, int)> f =
				boost::bind(&loglsnd::newc, this, _1, _2);
			SMI(smnet::smpx)->add(f, static_pointer_cast<smnet::sckt>(s), smnet::smpx::srd);
		}
		void newc(smnet::scktp sckt_, int) {
			smnet::lsnrp s = dynamic_pointer_cast<smnet::lsnr>(sckt_);
			try {
				smnet::clntp c = s->wt_acc();
				boost::function<void(smnet::scktp, int)> f =
					boost::bind(&loglsnd::cdata, this, _1, _2);
				SMI(smnet::smpx)->add(f, static_pointer_cast<smnet::sckt>(c), smnet::smpx::srd);
			} catch (smnet::sckterr& e) {
				SMI(log)->logmsg(0, std::string("Accept failed for log socket: ") + e.what());
			}
		}
		void cdata(smnet::scktp s_, int) {
			smnet::clntp c = dynamic_pointer_cast<smnet::clnt>(s_);
			std::vector<u_char> data;
			std::string levs;
			std::string msg;
			try {
				c->rd(data);
			} catch (smnet::sckterr&) {
				goto errout;
			}
			msg.assign(data.begin(), data.end());
			levs = smutl::car(msg);
			if (levs.empty()) {
				SMI(log)->logmsg(0, "Malformed log message from socket");
				goto errout;
			}
			while (!msg.empty() and msg[0] == ' ')
				msg.erase(msg.begin());
			if (msg.empty()) {
				SMI(log)->logmsg(0, "Malformed log message from socket");
				goto errout;
			}
			int lev;
			try {
				lev = lexical_cast<int>(levs);
			} catch (bad_lexical_cast&) {
				goto errout;
			}
			if (lev < 0 || lev > 16)
				goto errout;
			SMI(log)->logmsg(lev, msg);
		  errout:
			SMI(smnet::smpx)->rm(c);
		}
	};
} // anonymous namespace

void
log::initialise(void)
{
	(new loglsnd)->run();
}
	
void
log::logmsg(int irclvl, str message)
{
	std::string fmt = b::io::str(b::format("%% %s -- %s") % timestamp() % message);
	std::cout << fmt << '\n';

	if (irclvl)
		SMI(smirc::cfg)->conn()->msg(irclvl, fmt);
}

void
log::debug(dbg_t func, str message)
{
	if (!debugset(func)) return;
	logmsg(0, message);
}
	
std::string
log::timestamp(void)
{
	char buf[256];
	struct tm now;
	std::time_t nowt = std::time(0);
	gmtime_r(&nowt, &now);
	strftime(buf, sizeof buf, "%d-%b-%Y %H:%M:%S", &now);
	return buf;
}

bool
log::debugset(dbg_t f)
{
	return debugs.find(f) != debugs.end();
}

void
log::dodebug(dbg_t f)
{
	debugs.insert(f);
}

void
log::dontdebug(dbg_t f)
{
	debugs.erase(f);
}

} // namespace smlog
