/* @(#) $Id$ */
/* This source code is in the public domain. */
/*
 * Willow: Lightweight HTTP reverse-proxy.
 * wbackend: HTTP backend handling.
 */

#ifndef WBACKEND_H
#define WBACKEND_H

#if defined __SUNPRO_C || defined __DECC || defined __HP_cc
# pragma ident "@(#)$Id$"
#endif

#include <sys/types.h>
#include <netinet/in.h>

#include <string>
using std::string;
#include <vector>
using std::vector;

#include "polycaller.h"

struct fde;

struct backend {
		backend(string const &, string const &, sockaddr *, socklen_t);

	string			 be_name;	/* IP as specified in config	*/
	int	 		 be_port;	/* port number			*/
	sockaddr_storage	 be_addr;	/* socket address		*/
	socklen_t		 be_addrlen;	/* address length		*/
	string			 be_straddr;	/* formatted address		*/
	int	 		 be_dead;	/* 0 if okay, 1 if unavailable	*/
	time_t			 be_time;	/* If dead, time to retry	*/
	uint32_t		 be_hash;	/* constant carp "host" hash	*/
	uint32_t		 be_carp;	/* carp hash for the last url	*/
	float			 be_load;	/* carp load factor		*/
	float			 be_carplfm;	/* carp LFM after calculation	*/

	static uint32_t 	 _carp_hosthash	(string const &);
};

struct backend_cb_data;
struct backend_pool {
	void	add	(string const &, int, int);

	template<typename T>
	int	get	(string const &url, polycaller<backend *, fde *, T> cb, T t) {
		return _get_impl(url, polycallback<backend *, fde *>(cb, t));
	}

	vector<backend *> backends;

	int		 _get_impl	(string const &, polycallback<backend *, fde *>);
	void		 _backend_read	(fde *e, backend_cb_data *);
	struct backend 	*_next_backend	(string const &url);
	void		 _carp_recalc	(string const &url);
	void		 _carp_calc	(void);

	static int	 _becarp_cmp	(backend const *a, backend const *b);
	static uint32_t  _carp_urlhash	(string const &);
};

extern backend_pool gbep;

#endif
