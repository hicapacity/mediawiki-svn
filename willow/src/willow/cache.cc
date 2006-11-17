/* @(#) $Id$ */
/* This source code is in the public domain. */
/*
 * Willow: Lightweight HTTP reverse-proxy.
 * cache: HTTP entity caching.
 */

#if defined __SUNPRO_C || defined __DECC || defined __HP_cc
# pragma ident "@(#)$Id$"
#endif

#include <utility>
#include <iostream>
using std::make_pair;
using std::ostream;

#include "cache.h"
#include "format.h"
#include "wconfig.h"

namespace db {

template<>
struct marshaller<cachedentity> {
	pair<char const *, uint32_t> marshall(cachedentity const &e) {
		return e.marshall();
	}

	cachedentity *unmarshall(pair<char const *, uint32_t> const &d) {
		return cachedentity::unmarshall(d.first, d.second);
	}
};

} // namespace db

httpcache entitycache;

httpcache::httpcache(void)
	: _cache_mem(0)
	, _env(NULL)
	, _db(NULL)
{
}

httpcache::~httpcache(void)
{
	close();
}

cachedentity *
httpcache::find_cached(imstring const &url, bool create, bool &wasnew)
{
map<imstring, cachedentity *>::iterator it;
cachedentity *ret;

	if (!config.cache_memory)
		return NULL;

	HOLDING(_lock);
	it = _entities.find(url);

	if (it != _entities.end()) {
	ret = it->second;
		/* entity was cached */
		WDEBUG((WLOG_DEBUG, format("[%s] cached, complete=%d") % url % ret->_complete));
		ret->ref();
		wasnew = false;
		_lru.erase(it);
		it->second->reused();
		_lru.insert(it);
		return ret;
	}

	/*
	 * Maybe it's in the disk cache
	 */
	ret = _db->get(url);
	if (ret != NULL) {
		WDEBUG((WLOG_DEBUG, format("found [%s] in disk cache complete %d void %d") 
				% url % ret->complete() % ret->isvoid()));
		ret->ref();
		_lru.insert(_entities.insert(make_pair(url, ret)).first);
		wasnew = false;
		return ret;
	}
	if (_db->error()) {
		wlog(WLOG_WARNING, format("fetching cached data: %s")
			% _db->strerror());
	}

	WDEBUG((WLOG_DEBUG, format("[%s] not cached") % url));
	if (!create)
		return NULL;

	/* need to create new entity */
	ret = new cachedentity(url);
	wasnew = true;
	_lru.insert(_entities.insert(make_pair(url, ret)).first);
	ret->_refs = 2; /* one for _entities and one for the caller */
	return ret;
}

void
httpcache::release(cachedentity *ent)
{
	HOLDING(_lock);
	if (ent->isvoid()) {
		/* don't keep void objects around */
		ent->deref();
	}

	ent->deref();
}

void
httpcache::_remove_unlocked(cachedentity *ent)
{
map<imstring, cachedentity *>::iterator it;
	if ((it = _entities.find(ent->url())) != _entities.end()) {
		_lru.erase(it);
		_entities.erase(it);
	}
}

void
httpcache::_remove(cachedentity *ent)
{
	HOLDING(_lock);
	_remove_unlocked(ent);
}

void
httpcache::cache_mem_reduce(size_t n)
{
	HOLDING(_memlock);
	_cache_mem -= n;
}

bool
httpcache::cache_mem_increase(size_t n, cachedentity *self)
{
	for (;;) {
		{	HOLDING(_memlock);
			if ((long) (_cache_mem + n) <= config.cache_memory)
				break;
		}
	cachedentity		*ent;
		{	HOLDING(_lock);
		lruset::iterator	 it = _lru.begin();
			for (; it != _lru.end(); ++it) {
				ent = (*it)->second;
				if (ent == self)
					continue;
				ent->deref();
				break;
			}
			if (ent == self)
				return false;
		}
	}

	HOLDING(_memlock);
	_cache_mem += n;
	return true;
}

void
httpcache::_swap_out(cachedentity *ent)
{
	WDEBUG((WLOG_DEBUG, format("swapping out %s") % ent->url()));
	if (!_db)
		return;
	_db->put(ent->url(), *ent);
	if (_db->error()) {
		wlog(WLOG_WARNING, format("storing cached data: %s")
			% _db->strerror());
	}
}

bool
httpcache::purge(imstring const &url)
{
map<imstring, cachedentity *>::iterator it;
cachedentity *ent;
	{	HOLDING(_lock);
		it = _entities.find(url);

		if (it == _entities.end()) {
			return false;
		}
		ent = it->second;
		ent->deref();
	}


	return true;
}

bool
httpcache::open(void)
{
	if (config.cache_master.empty())
		return true;

	_store = new cachedir_data_store;
	
	_env = db::environment::open(config.cache_master);
	if (_env->error()) {
		wlog(WLOG_ERROR, 
			format("cannot open cache master environment \"%s\": %s")
			% config.cache_master % _env->strerror());
		delete _env;
		_env = NULL;
		return false;
	}

	_db = _env->open_database<imstring, cachedentity,
		cachedir_data_store>("objects", _store);
	if (_db->error()) {
		wlog(WLOG_ERROR, 
			format("cannot open cache master database \"%s\": %s")
			% config.cache_master % _db->strerror());
		_env->close();
		delete _env;
		delete _db;
		_env = NULL;
		_db = NULL;
		return false;
	}
	return true;
}

bool
httpcache::create(void)
{
	if (config.cache_master.empty()) {
		wlog(WLOG_ERROR, "no cache master to create");
		return false;
	}

	_store = new cachedir_data_store;
	
	if (mkdir(config.cache_master.c_str(), 0700) < 0) {
		wlog(WLOG_ERROR, format("cannot create cache master \"%s\": %e")
			% config.cache_master);
		return false;
	}
		
	_env = db::environment::create(config.cache_master);
	if (_env->error()) {
		wlog(WLOG_ERROR,
			format("cannot create cache master environmet \"%s\": %s")
			% config.cache_master % _env->strerror());
		delete _env;
		_env = NULL;
		return false;
	}

	_db = _env->create_database<imstring, cachedentity,
		cachedir_data_store>("objects", _store);
	if (_db->error()) {
		wlog(WLOG_ERROR,
			format("cannot create cache master database \"%s\": %s")
			% config.cache_master % _db->strerror());
		_env->close();
		delete _env;
		delete _db;
		_env = NULL;
		_db = NULL;
		return false;
	}
	return true;
}
	
void
httpcache::close(void)
{
	if (_db) {
		_db->close();
		_db = NULL;
	}

	if (_env) {
		_env->close();
		_env = NULL;
	}
}

cachedentity::cachedentity(imstring const &url, size_t hint)
	: _url(url)
	, _data(hint ? hint : 4096)
	, _refs(0)
	, _complete(false)
	, _builthdrs(NULL)
	, _builtsz(0)
	, _void(false)
	, _lastuse(time(0))
	, _expires(0)
	, _modified(0)
{
	WDEBUG((WLOG_DEBUG, format("CACHE: creating cached entity with URL %s")
			% url));
	assert(_url.size());
}

cachedentity::~cachedentity()
{
	entitycache._remove_unlocked(this);
	entitycache.cache_mem_reduce(_data.size());
	delete[] _builthdrs;
}

void
cachedentity::_append(char const *data, size_t size)
{
	if (_void)
		return;

	if ((long) (_data.size() + size) > config.max_entity_size) {
		_void = true;
		return;
	}

	if (!entitycache.cache_mem_increase(size, this)) {
		WDEBUG((WLOG_DEBUG, "object is too large, voiding cache"));
		_void = true;
		return;
	}
	_data.append(data, size);
}

time_t
cachedentity::parse_date(char const *date)
{
struct tm	tm;
	memset(&tm, 0, sizeof(tm));
	if (strptime(date, "%a, %d %b %Y %H:%M:%S GMT", &tm) == NULL)
		return (time_t) -1;
	return mktime(&tm);
}

void
cachedentity::set_complete(void)
{
header	*h;
	WDEBUG((WLOG_DEBUG, format("set_complete: void=%d") % _void));
	if (_void)
		return;
	_headers.remove("transfer-encoding");
	if (!_headers.find("content-length")) {
	char	lenstr[64];
		snprintf(lenstr, sizeof lenstr, "%lu", 
			(unsigned long) _data.size());
		_headers.add("Content-Length", lenstr);
	}

	if ((h = _headers.find("Expires")) != NULL) {
		if ((_expires = parse_date(h->value())) == -1) {
			_expires = time(0);
		}
	} else {
		_expires = 0;
	}

	if ((h = _headers.find("Last-Modified")) != NULL) {
		if ((_modified = parse_date(h->value())) == -1) {
			_modified = time(0);
		}
	} else {
		if ((h = _headers.find("Date")) != NULL) {
			if ((_modified = parse_date(h->value())) == -1) {
				_modified = time(0);
			}
		} else {
			_modified = time(0);
		}
	}

	_lifetime = (time_t) ((time(0) - _modified) * 1.25);
	WDEBUG((WLOG_DEBUG, format("CACHE: object lifetime=%d sec.") % _lifetime));
	revalidated();
	_builthdrs = _headers.build();
	_builtsz = _headers.length();
	_data.finished();
	_complete = true;
	entitycache._swap_out(this);
}

pair<char const *, uint32_t>
cachedentity::marshall(void) const
{
db::marshalling_buffer	buf;
	buf.reserve(
		sizeof(size_t) + _url.size() +
		sizeof(size_t) + _status.size() +
		sizeof(size_t) + _builtsz +
		sizeof(time_t) * 5 +
		sizeof(int) +
		sizeof(uint64_t));
	buf.append<imstring>(_url);
	buf.append<imstring>(_status);
	buf.append<size_t>(_builtsz);
	buf.append_bytes(_builthdrs, _builtsz);
	buf.append<time_t>(_lastuse);
	buf.append<time_t>(_expires);
	buf.append<time_t>(_modified);
	buf.append<time_t>(_lifetime);
	buf.append<time_t>(_revalidate_at);
	buf.append<int>(_cachedir);
	buf.append<uint64_t>(_cachefile);
	return make_pair(buf.buffer(), buf.size());
}

cachedentity *
cachedentity::unmarshall(char const *d, uint32_t s)
{
cachedentity		*ret;
db::marshalling_buffer	 buf(d, s);
imstring		 url;
char			*hdrbuf;
size_t			 bufsz;
	if (!buf.extract<imstring>(url))
		return NULL;
	WDEBUG((WLOG_DEBUG, format("unmarshall: URL [%s], len %d")
			% url % url.size()));
	ret = new cachedentity(url);
	if (!buf.extract<imstring>(ret->_status)) {
		delete ret;
		return NULL;
	}

	if (!buf.extract<size_t>(bufsz)) {
		delete ret;
		return NULL;
	}

	ret->_builthdrs = new char[bufsz + 1];
	ret->_builtsz = bufsz;
	if (!buf.extract_bytes(ret->_builthdrs, bufsz)) {
		delete ret;
		return NULL;
	}

	if (!buf.extract<time_t>(ret->_lastuse)) {
		delete ret;
		return NULL;
	}

	if (!buf.extract<time_t>(ret->_expires)) {
		delete ret;
		return NULL;
	}

	if (!buf.extract<time_t>(ret->_modified)) {
		delete ret;
		return NULL;
	}

	if (!buf.extract<time_t>(ret->_lifetime)) {
		delete ret;
		return NULL;
	}

	if (!buf.extract<time_t>(ret->_revalidate_at)) {
		delete ret;
		return NULL;
	}
	
	if (!buf.extract<int>(ret->_cachedir)) {
		delete ret;
		return NULL;
	}
	
	if (!buf.extract<uint64_t>(ret->_cachefile)) {
		delete ret;
		return NULL;
	}
	
	ret->_refs = 1;
	/*
	 * An incomplete or void entity will never be written to the disk cache.
	 */
	ret->_complete = true;
	ret->_void = false;
	return ret;
}

bool
cachedentity::loadcachefile(void)
{
cachefile	*f;
struct stat	 sb;
	if ((f = entitycache.get_cachefile(_cachefile)) == NULL)
		return false;
	return _data.loadfile(f->file(), f->size());
}

bool
cachedentity::savecachefile(cachefile *f)
{
ostream	&sm = f->file();
	assert(f);
	WDEBUG((WLOG_DEBUG, format("CACHE: writing cached data to %s")
			% f->filename()));
	if (!sm.write(_data.ptr(), _data.size())) {
		wlog(WLOG_WARNING, format("writing cached data to %s: %e")
				% f->filename());
		return false;
	}
	_cachefile = f->filenum();
	return true;
}

pair<char const *, uint32_t>
cachedir_data_store::store(cachedentity &o)
{
db::marshaller<cachedentity>	m;
pair<char const *, uint32_t>	ret;
	assert(o.complete() && !o.isvoid());
	
	WDEBUG((WLOG_DEBUG, format("CACHE: storing %s") % o.url()));
	
	ret = m.marshall(o);
	/*
	 * Write the cached data to the cachedir.
	 */
cachefile	*f = nextfile();
	o.savecachefile(f);
	ret = m.marshall(o);
	delete f;
	return ret;
}

cachedentity *
cachedir_data_store::retrieve(pair<char const *, uint32_t> const &d)
{
db::marshaller<cachedentity>	m;
cachedentity	*ent;
	/*
	 * Read the cached data from the cachedir.
	 */
	WDEBUG((WLOG_DEBUG, "CACHE: unmarshalling a cached entity"));
	ent = m.unmarshall(d);
	if (ent == NULL)
		return NULL;
	WDEBUG((WLOG_DEBUG, format("CACHE: loading cache data for %s") % ent->url()));
	ent->loadcachefile();
	return ent;
}

cachefile *
cachedir_data_store::nextfile(void)
{
	return cachedir->nextfile();
}

cachefile *
a_cachedir::open(uint64_t num)
{
imstring	path = (format("%s/%d") % _path % num).str();
	return new cachefile(path, num, false);
}

cachefile *
a_cachedir::nextfile(void)
{
int		n = _curfnum++;
imstring	path = (format("%s/%d") % _path % n).str();
	return new cachefile(path, n, true);
}	

void
cachefile::write(char const *buf, size_t n)
{
	_file.write(buf, n);
}

cachefile *
httpcache::get_cachefile(uint64_t num)
{
	return _store->open(num);
}

cachefile *
cachedir_data_store::open(uint64_t num)
{
	return cachedir->open(num);
}

a_cachedir::a_cachedir(imstring const &path)
	: _path(path)
{
	assert(_path.size());
}

cachedir_data_store::cachedir_data_store(void)
{
	assert(config.cachedirs.size());
	cachedir = new a_cachedir(config.cachedirs[0].dir);
}
