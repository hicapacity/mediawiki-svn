/* @(#) $Header$ */
/* This source code is in the public domain. */
/*
 * Willow: Lightweight HTTP reverse-proxy.
 * wnet: Networking.
 */

#ifndef WNET_H
#define WNET_H

#include <sys/types.h>

#include <netinet/in.h>

struct fde;

#define MAX_FD	8192

typedef int (*fdcb)(struct fde*);
typedef void (*fdwcb)(struct fde*, void*, int);

struct client_data;

struct fde {
	int		 fde_fd;
	fdcb		 fde_read_handler;
	fdcb		 fde_write_handler;
struct	client_data	*fde_cdata;
	void		*fde_rdata;
	void		*fde_wdata;
	char		 fde_straddr[16];
};
extern struct fde fde_table[];

struct client_data {
struct	sockaddr_in	cdat_addr;
};

#define FDE_READ	0x1
#define FDE_WRITE	0x2

void wnet_init(void);
void wnet_run(void);

void wnet_register(int, int, fdcb, void *);
int wnet_open(void);
void wnet_close(int);
void wnet_write(int, void *, size_t, fdwcb, void*);

#endif
