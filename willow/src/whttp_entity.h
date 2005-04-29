/* @(#) $Header$ */
/* This source code is in the public domain. */
/*
 * Willow: Lightweight HTTP reverse-proxy.
 * whttp_entity: HTTP entity handling.
 */

#ifndef WHTTP_ENTITY
#define WHTTP_ENTITY

#ifdef __SUNPRO_C
# pragma ident "@(#)$Header$"
#endif

#ifdef THREADED_IO
# include <pthread.h>
#endif

#include "whttp.h"

#define ENT_SOURCE_BUFFER	1
#define ENT_SOURCE_FDE		2
#define ENT_SOURCE_NONE		3
#define ENT_SOURCE_FILE		4

#define REQTYPE_GET	0
#define REQTYPE_POST	1
#define REQTYPE_HEAD	2
#define REQTYPE_TRACE	3
#define REQTYPE_OPTIONS	4
#define REQTYPE_INVALID	-1

#define MAX_HEADERS	64	/* maximum # of headers to allow	*/

struct http_entity;
struct http_client;

typedef void (*header_cb)(struct http_entity *, void *, int);
typedef void (*cache_callback)(const char *, size_t, void *);

#define HDR_ALLOCED	1

struct header_list {
const	char		*hl_name;
const	char		*hl_value;
struct	header_list	*hl_next;
struct	header_list	*hl_tail;
	int		 hl_len;
	int		 hl_num;
	int		 hl_flags;
};

struct http_entity {
	union {
		/* response-only data */
		struct {
			int		 status;
			const char	*status_str;	
		} response;
		/* request-only data */
		struct {
			int	 reqtype;
			char	*path;
			char	*host;	/* HTTP Host: header */
		} request;
	}		 he_rdata;
	
struct	header_list	 he_headers;
	int		 he_source_type;
	
	union {
		/* buffer data */
		struct {
			const char	*addr;
			int		 len;
		}		 buffer;
		/* sendfile data */
		struct {
			int	fd;
			size_t	size;
			off_t	off;
		}		 fd;
		/* fde data */
		struct fde	*fde;
	}		 he_source;

	struct {
		int	 cachable:1;
		int	 response:1;
		int	 error:1;
	}		 he_flags;

	/*
	 * If you want a callback when each piece of data is written, set this.  
	 * This only works when sending from an FDE, not when using a buffer 
	 * (if you use a buffer, you already have the data...)
	 */
	cache_callback	 he_cache_callback;
	void		*he_cache_callback_data;
	
	/*
	 * This is internal to whttp_entity.  Don't touch it.
	 */
	void		*_he_cbdata;
	header_cb	 _he_func;
	char		*_he_hdrbuf;
	char		 _he_rdbuf[8192]; /* does this really need to be here? */
struct	fde		*_he_target;
	int		 _he_state;
	pthread_t	 _he_thread;
};

void entity_read_headers(struct http_entity *, header_cb, void *);
void entity_send(struct fde *, struct http_entity *, header_cb, void *);
void entity_free(struct http_entity *);

void header_add(struct header_list *, const char *, const char *);

void header_free(struct header_list *);
char *header_build(struct header_list *);
void header_remove(struct header_list *, struct header_list *);
void header_dump(struct header_list *, int);
int header_undump(struct header_list *, int, off_t *);

#endif
