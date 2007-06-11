#!/usr/bin/env perl
#
# This test detect Byte Order Mark (BOM). The char is sometime included at the
# top of files by some text editors to mark them as being UTF-8 encoded.
# They are not stripped by php 5.x and appear at the beginning of our content,
# You want them removed!
# See:
#   http://www.fileformat.info/info/unicode/char/feff/index.htm
#   http://bugzilla.wikimedia.org/show_bug.cgi?id=9954

use strict;
use warnings;

use Test::More;

use File::Find;
use File::Slurp qw< slurp >;

# Files for wich we want to check the BOM char ( 0xFE 0XFF )
my $ext = qr/(?:php|inc)/x ;

my $bomchar = qr/\xef\xbb\xbf/ ;


my @files;

find( sub{ push @files, $File::Find::name if -f && /\.$ext$/ }, '.' );

# Register our files with the test system
plan tests => scalar @files ;

for my $file (@files) {
	my $content = slurp $file ;
	if( $content =~ /$bomchar/ ) {
		ok 0 => "$file got a Byte Order Mark";
	} else {
		ok 1 => "$file BOM less";
	}
}
