/* @(#) $Header$ */
/* This source code is in the public domain. */
/*
 * Willow: Lightweight HTTP reverse-proxy.
 */

#include <sys/mman.h>

#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include "wlog.h"
#include "wnet.h"
#include "wconfig.h"
#include "willow.h"

int main(argc, argv)
	char *argv[];
{
	wlog_init();
	wlog(WLOG_NOTICE, "Willow: startup");
	wconfig_init(NULL);
	wnet_init();
	whttp_init();

	wnet_run();
	return EXIT_SUCCESS;
}

#ifdef WDEBUG_ALLOC
struct alloc_entry {
	void		*ae_addr;
	int		 ae_freed;
	const char	*ae_freed_file;
	int		 ae_freed_line;
struct	alloc_entry	*ae_next;
};

static struct alloc_entry allocs;

void *
wmalloc(size)
	size_t size;
{
	void		*p;
struct	alloc_entry	*ae;

	if (allocs.ae_next == NULL) {
		int i;
		ae = &allocs;
		for (i = 0; i < 50; ++i) {
			ae->ae_next = malloc(sizeof(struct alloc_entry));
			memset(ae->ae_next, 0, sizeof(struct alloc_entry));
			ae = ae->ae_next;
		}
	}

	if ((p = malloc(size)) == NULL)
		return NULL;

	for (ae = &allocs; ae->ae_next && ae->ae_next->ae_addr; ae = ae->ae_next)
		;

	if ((ae->ae_next = malloc(sizeof(struct alloc_entry))) == NULL) {
		fputs("out of memory\n", stderr);
		abort();
	}

	ae = ae->ae_next;
	memset(ae, 0, sizeof(struct alloc_entry));
	ae->ae_addr = p;
	return p;
}

void
internal_wfree(p, file, line)
	void *p;
	const char *file;
{
struct	alloc_entry	*ae;

	for (ae = allocs.ae_next; ae; ae = ae->ae_next) {
		if (ae->ae_addr == p) {
			if (ae->ae_freed) {
				fprintf(stderr, "wfree: ptr %p already freed @ %s:%d!\n", p, ae->ae_freed_file, ae->ae_freed_line);
				abort();
			}
			ae->ae_freed = 1;
			ae->ae_freed_file = file;
			ae->ae_freed_line = line;
			return;
		}
	}

	fprintf(stderr, "wfree: ptr %p never malloced!\n", p);
	abort();
}
#endif
