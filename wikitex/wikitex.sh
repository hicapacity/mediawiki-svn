#!/usr/bin/env bash
# WikiTeX: expansible LaTeX module for MediaWiki
# Copyright (C) 2004-5  Peter Danenberg
#
#      WikiTeX is licensed under  the  Open  Software  License
# v. 2.1;  to  view  a  copy  of  this license, see COPYING or
# visit:
#
#      http://www.opensource.org/licenses/osl-2.1.php
# 
# wikitex.sh: shell interface to wikitex.php
# Usage: FILE MODULE OUTPATH
ARGS=3
E_ARGS=2
E_FAIL=1
E_SUC=0
HASH="${1}"
MOD="${2}"
OUT="${3}"
EXT='.png'
CHE='.cache'
MID='.midi'
ERR='<span class="errwikitex">WikiTeX: %s reported a failure.</span><pre>%s</pre>\n';

function wt_error() {
    printf "${ERR}" "${1}" "${2}"
    exit "${3}"
}

(( ${#} >= ${ARGS} )) || wt_error 'wikitex.sh' 'Usage: wikitex.sh HASH MODULE OUTPATH' $E_ARGS

# $PWD is initially the wiki-base; will break if existeth space in path.
cd "$(dirname ${0})/tmp"

# Check cache.
[ -r "${HASH}${CHE}" ] && { cat "${HASH}${CHE}"; exit $E_SUC; }

# Requirement: scribe tmp, read hash.
[ -w '.' ] || wt_error 'wikitex.sh' "I can't scribe <code>${PWD}</code>, baby." $E_FAIL
[ -r "${HASH}" ] || wt_error 'wikitex.sh' "Can't hash, baby." $E_FAIL

# Output image.
function wt_img() {
    STR="$STR"$(printf "<img src=\"%s\" alt=\"${MOD}\" />" "${1}")
}

# Output link.
function wt_anch() {
    STR=$(printf '<a href="%s">%s</a>' "${OUT}${HASH}" "${STR}")
}

function wt_dvipng() {
    wt_exec "dvipng -gamma 1.5 -T tight ${HASH}"
}    

# Generic execution, which allows for error trapping
function wt_exec() {
    PUT=$(${@} 2>&1) || wt_error "${@%%\ *}" "${PUT}" $E_FAIL
}

# Catch-all renderer
function wt_generic() {
    wt_exec "latex --interaction=nonstopmode ${HASH}"
    wt_dvipng
    for i in ${HASH}*${EXT}; do wt_img "${OUT}${i}"; done
    wt_anch
}

function error() {
    STR=$(printf "${ERR}" 'wikitex.php' "$(<"${HASH}")");
}

function go() {
    wt_exec "sgf2tex -twoColumn ${HASH}"
    wt_exec "tex --interaction=nonstopmode ${HASH}"
    wt_dvipng
    for i in ${HASH}*${EXT}; do wt_exec "mogrify -crop +0-24! ${i}"; wt_exec "mogrify -trim ${i}"; wt_img "${OUT}${i}"; done
    wt_anch
}

function graph() {
    wt_exec "dot -Tpng ${HASH} > ${HASH}${EXT}"
    wt_img "${OUT}${HASH}${EXT}"
    wt_anch
}

function music() {
    wt_exec "lilypond --no-pdf --no-ps --png ${HASH}"
    for i in ${HASH}*${EXT}; do wt_exec "mogrify -trim ${i}"; wt_img "${OUT}${i}"; done
    wt_anch
    STR="$STR"$(printf '<a href="%s">[listen]</a>' "${OUT}${HASH}${MID}")
}

function plot() {
    wt_exec "gnuplot ${HASH} > ${HASH}${EXT}"
    wt_img "${OUT}${HASH}${EXT}"
    wt_anch
}

function schem() {
    wt_exec "gschem -o ${HASH}${EXT} -s ../wikitex.schem.scm ${HASH}"
    wt_exec "mogrify -trim ${HASH}${EXT}"
    wt_img "${OUT}${HASH}${EXT}"
    wt_anch
}

# Check for module-specific functions; otherwise resort to generic.
if [[ $(type -t "${MOD}") == 'function' ]]; then
    "${MOD}" "${HASH}" "${OUT}"
else
    wt_generic "${HASH}" "${OUT}"
fi

# Clean up, but not on wt_error; and allow the examination of logs.
find . -name "${HASH}*" ! -name "${HASH}" ! -name "${HASH}*${EXT}" ! -name "${HASH}${MID}" ! -name "${HASH}${CHE}" -exec rm {} \;

# Cache
echo "${STR}" > "${HASH}${CHE}"
echo "${STR}"
