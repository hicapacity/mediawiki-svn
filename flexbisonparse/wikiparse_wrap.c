/* ----------------------------------------------------------------------------
 * This file was automatically generated by SWIG (http://www.swig.org).
 * Version 1.3.21
 * 
 * This file is not intended to be easily readable and contains a number of 
 * coding conventions designed to improve portability and efficiency. Do not make
 * changes to this file unless you know what you are doing--modify the SWIG 
 * interface file instead. 
 * ----------------------------------------------------------------------------- */

/*************************************************************** -*- c -*-
 * php4/precommon.swg
 *
 * Rename all exported symbols from common.swg, to avoid symbol
 * clashes if multiple interpreters are included
 *
 ************************************************************************/

#define SWIG_TypeRegister    SWIG_PHP4_TypeRegister
#define SWIG_TypeCheck       SWIG_PHP4_TypeCheck
#define SWIG_TypeCast        SWIG_PHP4_TypeCast
#define SWIG_TypeDynamicCast SWIG_PHP4_TypeDynamicCast
#define SWIG_TypeName        SWIG_PHP4_TypeName
#define SWIG_TypeQuery       SWIG_PHP4_TypeQuery
#define SWIG_TypeClientData  SWIG_PHP4_TypeClientData
#define SWIG_PackData        SWIG_PHP4_PackData 
#define SWIG_UnpackData      SWIG_PHP4_UnpackData 


/***********************************************************************
 * common.swg
 *
 *     This file contains generic SWIG runtime support for pointer
 *     type checking as well as a few commonly used macros to control
 *     external linkage.
 *
 * Author : David Beazley (beazley@cs.uchicago.edu)
 *
 * Copyright (c) 1999-2000, The University of Chicago
 * 
 * This file may be freely redistributed without license or fee provided
 * this copyright message remains intact.
 ************************************************************************/

#include <string.h>

#if defined(_WIN32) || defined(__WIN32__) || defined(__CYGWIN__)
#  if defined(_MSC_VER) || defined(__GNUC__)
#    if defined(STATIC_LINKED)
#      define SWIGEXPORT(a) a
#      define SWIGIMPORT(a) extern a
#    else
#      define SWIGEXPORT(a) __declspec(dllexport) a
#      define SWIGIMPORT(a) extern a
#    endif
#  else
#    if defined(__BORLANDC__)
#      define SWIGEXPORT(a) a _export
#      define SWIGIMPORT(a) a _export
#    else
#      define SWIGEXPORT(a) a
#      define SWIGIMPORT(a) a
#    endif
#  endif
#else
#  define SWIGEXPORT(a) a
#  define SWIGIMPORT(a) a
#endif

#ifdef SWIG_GLOBAL
#  define SWIGRUNTIME(a) SWIGEXPORT(a)
#else
#  define SWIGRUNTIME(a) static a
#endif

#ifdef __cplusplus
extern "C" {
#endif

typedef void *(*swig_converter_func)(void *);
typedef struct swig_type_info *(*swig_dycast_func)(void **);

typedef struct swig_type_info {
  const char             *name;
  swig_converter_func     converter;
  const char             *str;
  void                   *clientdata;
  swig_dycast_func        dcast;
  struct swig_type_info  *next;
  struct swig_type_info  *prev;
} swig_type_info;

#ifdef SWIG_NOINCLUDE

SWIGIMPORT(swig_type_info *) SWIG_TypeRegister(swig_type_info *);
SWIGIMPORT(swig_type_info *) SWIG_TypeCheck(char *c, swig_type_info *);
SWIGIMPORT(void *)           SWIG_TypeCast(swig_type_info *, void *);
SWIGIMPORT(swig_type_info *) SWIG_TypeDynamicCast(swig_type_info *, void **);
SWIGIMPORT(const char *)     SWIG_TypeName(const swig_type_info *);
SWIGIMPORT(swig_type_info *) SWIG_TypeQuery(const char *);
SWIGIMPORT(void)             SWIG_TypeClientData(swig_type_info *, void *);
SWIGIMPORT(char *)           SWIG_PackData(char *, void *, int);
SWIGIMPORT(char *)           SWIG_UnpackData(char *, void *, int);

#else

static swig_type_info *swig_type_list = 0;

/* Register a type mapping with the type-checking */
SWIGRUNTIME(swig_type_info *)
SWIG_TypeRegister(swig_type_info *ti) {
  swig_type_info *tc, *head, *ret, *next;
  /* Check to see if this type has already been registered */
  tc = swig_type_list;
  while (tc) {
    if (strcmp(tc->name, ti->name) == 0) {
      /* Already exists in the table.  Just add additional types to the list */
      if (tc->clientdata) ti->clientdata = tc->clientdata;
      head = tc;
      next = tc->next;
      goto l1;
    }
    tc = tc->prev;
  }
  head = ti;
  next = 0;

  /* Place in list */
  ti->prev = swig_type_list;
  swig_type_list = ti;

  /* Build linked lists */
  l1:
  ret = head;
  tc = ti + 1;
  /* Patch up the rest of the links */
  while (tc->name) {
    head->next = tc;
    tc->prev = head;
    head = tc;
    tc++;
  }
  if (next) next->prev = head;
  head->next = next;
  return ret;
}

/* Check the typename */
SWIGRUNTIME(swig_type_info *) 
SWIG_TypeCheck(char *c, swig_type_info *ty) {
  swig_type_info *s;
  if (!ty) return 0;        /* Void pointer */
  s = ty->next;             /* First element always just a name */
  do {
    if (strcmp(s->name,c) == 0) {
      if (s == ty->next) return s;
      /* Move s to the top of the linked list */
      s->prev->next = s->next;
      if (s->next) {
        s->next->prev = s->prev;
      }
      /* Insert s as second element in the list */
      s->next = ty->next;
      if (ty->next) ty->next->prev = s;
      ty->next = s;
      s->prev = ty;
      return s;
    }
    s = s->next;
  } while (s && (s != ty->next));
  return 0;
}

/* Cast a pointer up an inheritance hierarchy */
SWIGRUNTIME(void *) 
SWIG_TypeCast(swig_type_info *ty, void *ptr) {
  if ((!ty) || (!ty->converter)) return ptr;
  return (*ty->converter)(ptr);
}

/* Dynamic pointer casting. Down an inheritance hierarchy */
SWIGRUNTIME(swig_type_info *) 
SWIG_TypeDynamicCast(swig_type_info *ty, void **ptr) {
  swig_type_info *lastty = ty;
  if (!ty || !ty->dcast) return ty;
  while (ty && (ty->dcast)) {
    ty = (*ty->dcast)(ptr);
    if (ty) lastty = ty;
  }
  return lastty;
}

/* Return the name associated with this type */
SWIGRUNTIME(const char *)
SWIG_TypeName(const swig_type_info *ty) {
  return ty->name;
}

/* Search for a swig_type_info structure */
SWIGRUNTIME(swig_type_info *)
SWIG_TypeQuery(const char *name) {
  swig_type_info *ty = swig_type_list;
  while (ty) {
    if (ty->str && (strcmp(name,ty->str) == 0)) return ty;
    if (ty->name && (strcmp(name,ty->name) == 0)) return ty;
    ty = ty->prev;
  }
  return 0;
}

/* Set the clientdata field for a type */
SWIGRUNTIME(void)
SWIG_TypeClientData(swig_type_info *ti, void *clientdata) {
  swig_type_info *tc, *equiv;
  if (ti->clientdata == clientdata) return;
  ti->clientdata = clientdata;
  equiv = ti->next;
  while (equiv) {
    if (!equiv->converter) {
      tc = swig_type_list;
      while (tc) {
        if ((strcmp(tc->name, equiv->name) == 0))
          SWIG_TypeClientData(tc,clientdata);
        tc = tc->prev;
      }
    }
    equiv = equiv->next;
  }
}

/* Pack binary data into a string */
SWIGRUNTIME(char *)
SWIG_PackData(char *c, void *ptr, int sz) {
  static char hex[17] = "0123456789abcdef";
  int i;
  unsigned char *u = (unsigned char *) ptr;
  register unsigned char uu;
  for (i = 0; i < sz; i++,u++) {
    uu = *u;
    *(c++) = hex[(uu & 0xf0) >> 4];
    *(c++) = hex[uu & 0xf];
  }
  return c;
}

/* Unpack binary data from a string */
SWIGRUNTIME(char *)
SWIG_UnpackData(char *c, void *ptr, int sz) {
  register unsigned char uu = 0;
  register int d;
  unsigned char *u = (unsigned char *) ptr;
  int i;
  for (i = 0; i < sz; i++, u++) {
    d = *(c++);
    if ((d >= '0') && (d <= '9'))
      uu = ((d - '0') << 4);
    else if ((d >= 'a') && (d <= 'f'))
      uu = ((d - ('a'-10)) << 4);
    d = *(c++);
    if ((d >= '0') && (d <= '9'))
      uu |= (d - '0');
    else if ((d >= 'a') && (d <= 'f'))
      uu |= (d - ('a'-10));
    *u = uu;
  }
  return c;
}

#endif

#ifdef __cplusplus
}
#endif

/*
 * php4.swg
 *
 * PHP4 runtime library
 *
 */

#ifdef __cplusplus
extern "C" {
#endif
#include "zend.h"
#include "zend_API.h"
#include "php.h"

/* These TSRMLS_ stuff should already be defined now, but with older php under
   redhat are not... */
#ifndef TSRMLS_D
#define TSRMLS_D
#endif
#ifndef TSRMLS_DC
#define TSRMLS_DC
#endif
#ifndef TSRMLS_C
#define TSRMLS_C
#endif
#ifndef TSRMLS_CC
#define TSRMLS_CC
#endif

#ifdef __cplusplus
}
#endif

/* used to wrap returned objects in so we know whether they are newobject
   and need freeing, or not */
typedef struct _swig_object_wrapper {
  void * ptr;
  int newobject;
} swig_object_wrapper;

/* local scope self_constructors are set to 1 inside function wrappers
   which are also class constructors, so that the php4.swg output typemaps
   know whether or not to wrap returned objects in this_ptr or a new object */
int self_constructor=0;

/* empty zend destructor for types without one */
static ZEND_RSRC_DTOR_FUNC(SWIG_landfill) {};

/* This one makes old swig style string pointers but the php module doesn't
   use these any more.  This is just left here for old times sake and may go */
SWIGRUNTIME(void)
SWIG_MakePtr(char *c, void *ptr, swig_type_info *ty) {
  static char hex[17] = "0123456789abcdef";
  unsigned long p, s;
  char data[32], *r;

  r = data;
  p = (unsigned long) ptr;
  if (p > 0) {
    while (p > 0) {
      s = p & 0xf;
      *(r++) = hex[s];
      p = p >> 4;
    }
    *r = '_';
    while (r >= data) {
      *(c++) = *(r--);
    }
    strcpy (c, ty->name);
  } else {
    strcpy (c, "NULL");
  }
}

SWIGRUNTIME(void)
SWIG_SetPointerChar(char **c, void *ptr, swig_type_info *type) {
   char data[512];

   SWIG_MakePtr(data, ptr, type);
   *c = estrdup(data);
}

#define SWIG_SetPointerZval(a,b,c,d) SWIG_ZTS_SetPointerZval(a,b,c,d, SWIG_module_entry TSRMLS_CC)

SWIGRUNTIME(void)
SWIG_ZTS_SetPointerZval(zval *z, void *ptr, swig_type_info *type, int newobject, zend_module_entry* module_entry TSRMLS_DC) {
  swig_object_wrapper *value=NULL;
  /* No need to call SWIG_MakePtr here! */
  if (type->clientdata) {
    if (! (*(int *)(type->clientdata))) zend_error(E_ERROR, "Type: %s failed to register with zend",type->name);
    value=(swig_object_wrapper *)emalloc(sizeof(swig_object_wrapper));
    value->ptr=ptr;
    value->newobject=newobject;
    ZEND_REGISTER_RESOURCE(z, value, *(int *)(type->clientdata));
    return;
  } else { /* have to deal with old fashioned string pointer?
              but this should not get this far */
    zend_error(E_ERROR, "Type: %s not registered with zend",type->name);
  }
}

/* This old-style routine converts an old string-pointer c into a real pointer
   ptr calling making appropriate casting functions according to ty
   We don't use this any more */
SWIGRUNTIME(int)
SWIG_ConvertPtr_(char *c, void **ptr, swig_type_info *ty) {
   register int d;
   unsigned long p;
   swig_type_info *tc;

   if(c == NULL) {
   	*ptr = 0;
	return 0;
   }

   p = 0;
   if (*c != '_') {
    *ptr = (void *) 0;
    if (strcmp(c,"NULL") == 0) {
	return 0;
    } else {
	goto type_error;
    }
  }

    c++;
    /* Extract hex value from pointer */
    while ((d = *c)) {
      if ((d >= '0') && (d <= '9'))
        p = (p << 4) + (d - '0');
      else if ((d >= 'a') && (d <= 'f'))
        p = (p << 4) + (d - ('a'-10));
      else
        break;
      c++;
    }
    *ptr = (void *) p;
	
    if(ty) {
	tc = SWIG_TypeCheck(c,ty);
	if(!tc) goto type_error;
	*ptr = SWIG_TypeCast(tc, (void*)p);
    }
    return 0;

type_error:

    return -1;
}

/* This is a new pointer conversion routine
   Taking the native pointer p (which would have been converted from the old
   string pointer) and it's php type id, and it's type name (which also would
   have come from the old string pointer) it converts it to ptr calling 
   appropriate casting functions according to ty
   Sadly PHP has no API to find a type name from a type id, only from an instance
   of a resource of the type id, so we have to pass type_name as well.
   The two functions which might call this are:
   SWIG_ZTS_ConvertResourcePtr which gets the type name from the resource
   and the registered zend destructors for which we have one per type each
   with the type name hard wired in. */
SWIGRUNTIME(int)
SWIG_ZTS_ConvertResourceData(void * p, int type, const char *type_name, void **ptr, swig_type_info *ty TSRMLS_DC) {
  swig_type_info *tc;

  if (ty) {
    if (! type_name) {  
      /* can't convert p to ptr type ty if we don't know what type p is */
      return -1;
    } else {
      /* convert and cast p from type_name to ptr as ty
         Need to sort out const-ness, can SWIG_TypeCast really not take a const? */
      tc = SWIG_TypeCheck((char *)type_name,ty);
      if (!tc) return -1;
      *ptr = SWIG_TypeCast(tc, (void*)p);
    }
  } else {
    /* They don't care about the target type, so just pass on the pointer! */
    *ptr = (void *) p;
  }
  return 0;
}

/* This function fills ptr with a pointer of type ty by extracting the pointer
   and type info from the resource in z.  z must be a resource
   It uses SWIG_ZTS_ConvertResourceData to do the real work. */
SWIGRUNTIME(int)
SWIG_ZTS_ConvertResourcePtr(zval *z, void **ptr, swig_type_info *ty TSRMLS_DC) {
  swig_object_wrapper *value;
  void *p;
  int type;
  char *type_name;

  value = (swig_object_wrapper *) zend_list_find(z->value.lval,&type);
  p = value->ptr;
  if (type==-1) return -1;

  type_name=zend_rsrc_list_get_rsrc_type(z->value.lval);

  return SWIG_ZTS_ConvertResourceData(p,type,type_name,ptr,ty TSRMLS_CC);
}

/* But in fact SWIG_ConvertPtr is the native interface for getting typed
   pointer values out of zvals.  We need the TSRMLS_ macros for when we
   make PHP type calls later as we handle php resources */
#define SWIG_ConvertPtr(a,b,c) SWIG_ZTS_ConvertPtr(a,b,c TSRMLS_CC)

/* We allow passing of a STRING or RESOURCE pointing to the object
   or an OBJECT whose _cPtr is a string or resource pointing to the object
   STRING pointers are very depracated */
SWIGRUNTIME(int)
SWIG_ZTS_ConvertPtr(zval *z, void **ptr, swig_type_info *ty TSRMLS_DC) {
   char *c;
   zval *val;
   
   if(z == NULL) {
	*ptr = 0;
	return 0;
   }

   if (z->type==IS_OBJECT) {
     zval ** _cPtr;
     if (zend_hash_find(HASH_OF(z),"_cPtr",sizeof("_cPtr"),(void**)&_cPtr)==SUCCESS) {
       /* Don't co-erce to string if it isn't */
       if ((*_cPtr)->type==IS_STRING) c = Z_STRVAL_PP(_cPtr);
       else if ((*_cPtr)->type==IS_RESOURCE) {
         return SWIG_ZTS_ConvertResourcePtr(*_cPtr,ptr,ty TSRMLS_CC);
       } else goto type_error; /* _cPtr was not string or resource property */
     } else goto type_error; /* can't find property _cPtr */
   } else if (z->type==IS_RESOURCE) {
     return SWIG_ZTS_ConvertResourcePtr(z,ptr,ty TSRMLS_CC);
   } else if (z->type==IS_STRING) {
     c = Z_STRVAL_P(z); 
     return SWIG_ConvertPtr_(c,ptr,ty);
   } else goto type_error;

type_error:

    return -1;
}


/* -------- TYPES TABLE (BEGIN) -------- */

static swig_type_info *swig_types[1];

/* -------- TYPES TABLE (END) -------- */

/* header section */
/*
  +----------------------------------------------------------------------+
  | PHP version 4.0                                                      |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group             |
  +----------------------------------------------------------------------+
  | This source file is subject to version 2.02 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available at through the world-wide-web at                           |
  | http://www.php.net/license/2_02.txt.                                 |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Authors:                                                             |
  |                                                                      |
  +----------------------------------------------------------------------+
 */
#define SWIG_init	initwikiparse

#define SWIG_name	"wikiparse"
#ifdef __cplusplus
extern "C" {
#endif
#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_wikiparse.h"
#ifdef __cplusplus
}
#endif


 	const char *wikiparse_do_parse ( const char *input );

/* class entry subsection */


/* entry subsection */
/* Every non-class user visible function must have an entry here */
function_entry wikiparse_functions[] = {
	ZEND_NAMED_FE(wikiparse_do_parse,
		_wrap_wikiparse_do_parse, NULL)
	{NULL, NULL, NULL}
};

zend_module_entry wikiparse_module_entry = {
#if ZEND_MODULE_API_NO > 20010900
    STANDARD_MODULE_HEADER,
#endif
    "wikiparse",
    wikiparse_functions,
    PHP_MINIT(wikiparse),
    PHP_MSHUTDOWN(wikiparse),
    PHP_RINIT(wikiparse),
    PHP_RSHUTDOWN(wikiparse),
    PHP_MINFO(wikiparse),
#if ZEND_MODULE_API_NO > 20010900
    NO_VERSION_YET,
#endif
    STANDARD_MODULE_PROPERTIES
};
zend_module_entry* SWIG_module_entry = &wikiparse_module_entry;


/* -------- TYPE CONVERSION AND EQUIVALENCE RULES (BEGIN) -------- */


static swig_type_info *swig_types_initial[] = {
0
};


/* -------- TYPE CONVERSION AND EQUIVALENCE RULES (END) -------- */

/* vdecl subsection */
/* end vdecl subsection */
/* wrapper section */
ZEND_NAMED_FUNCTION(_wrap_wikiparse_do_parse) {
    char *arg1 ;
    char *result;
    zval **args[2];
    int argbase=0 ;
    
    if (this_ptr && this_ptr->type==IS_OBJECT) {
        /* fake this_ptr as first arg (till we can work out how to do it better */
        argbase++;
    }
    if(((ZEND_NUM_ARGS() + argbase )!= 1) || (zend_get_parameters_array_ex(1-argbase, args)!= SUCCESS)) {
        WRONG_PARAM_COUNT;
    }
    
    
    convert_to_string_ex(((0<argbase)?(&this_ptr):(args[0-argbase])));
    arg1 = (char *) Z_STRVAL_PP(((0<argbase)?(&this_ptr):(args[0-argbase])));
    
    result = (char *)wikiparse_do_parse((char const *)arg1);
    
    
    ZVAL_STRING(return_value,result, 1);
    
}






/* end wrapper section */
/* init section */
#ifdef __cplusplus
extern "C" {
#endif
ZEND_GET_MODULE(wikiparse)
#ifdef __cplusplus
}
#endif

PHP_MSHUTDOWN_FUNCTION(wikiparse)
{
    return SUCCESS;
}
PHP_MINIT_FUNCTION(wikiparse)
{
    int i;
    for (i = 0; swig_types_initial[i]; i++) {
        swig_types[i] = SWIG_TypeRegister(swig_types_initial[i]);
    }
/* oinit subsection */
CG(active_class_entry) = NULL;
/* end oinit subsection */

    return SUCCESS;
}
PHP_RINIT_FUNCTION(wikiparse)
{
/* cinit subsection */
/* end cinit subsection */

/* vinit subsection */
/* end vinit subsection */

    return SUCCESS;
}
PHP_RSHUTDOWN_FUNCTION(wikiparse)
{
    return SUCCESS;
}
PHP_MINFO_FUNCTION(wikiparse)
{
}
/* end init section */
