#!/usr/bin/python
# -*- coding: utf-8 -*-
'''
Copyright (C) 2010 by Diederik van Liere (dvanliere@gmail.com)
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details, at
http://www.fsf.org/licenses/gpl.html
'''

__author__ = '''\n'''.join(['Diederik van Liere (dvanliere@gmail.com)', ])
__author__email = 'dvanliere at gmail dot com'
__date__ = '2010-10-21'
__version__ = '0.1'

'''
This file contains settings that are used for constructing and analyzing
the datasets as part of the Editor Dynamics and Anti-Vandalism projects.
'''


from multiprocessing import cpu_count
import os
import sys
import platform

#Setting up the environment
ops = {platform.win32_ver: 'Windows',
      platform.linux_distribution: 'Linux',
      platform.mac_ver: 'OSX'}
for op in ops:
    if op() != ('', '', '') and op() != ('', ('', '', ''), ''):
        OS = ops[op]

WORKING_DIRECTORY = os.getcwd()#[:-9]
IGNORE_DIRS = ['wikistats', 'zips']

dirs = [name for name in os.listdir(WORKING_DIRECTORY) if os.path.isdir(os.path.join(WORKING_DIRECTORY, name))]
for subdirname in dirs:
    if not subdirname.startswith('.') and subdirname not in IGNORE_DIRS:
        sys.path.append(os.path.join(WORKING_DIRECTORY, subdirname))


#General settings

# Valid values are 'stand-alone' and 'hadoop'
RUN_MODE = 'stand_alone'

# If true then some more detailed debug information is collected
DEBUG = True

#If True then it will display a progress bar on the console.
PROGRESS_BAR = True

#Date format as used by Erik Zachte
DATE_FORMAT = '%Y-%m-%d'

# Timestamp format as generated by the MediaWiki dumps
DATETIME_FORMAT = '%Y-%m-%dT%H:%M:%SZ'

#This section contains configuration variables for the different file locations.

# Location where to write xml chunks
XML_FILE_LOCATION = 'C:/wikimedia/'

# Input file
XML_FILE = 'C:/Source_Files/enwiki-20100916-stub-meta-history.xml'

# This is the place where error messages are stored for debugging purposes
ERROR_MESSAGE_FILE_LOCATION = WORKING_DIRECTORY + '/errors/'

DATABASE_FILE_LOCATION = WORKING_DIRECTORY + '/data/database/'

BINARY_OBJECT_FILE_LOCATION = WORKING_DIRECTORY + '/data/objects/'

DATASETS_FILE_LOCATION = WORKING_DIRECTORY + '/datasets/'

#This section contains configuration variables for parsing / encoding and
#working with the XML files.

# ==64Mb, see http://hadoop.apache.org/common/docs/r0.20.0/hdfs_design.html#Large+Data+Sets for reason
MAX_XML_FILE_SIZE = 67108864

ENCODING = 'utf-8'

# Name space, do not change as this works for Mediawiki wikis
NAME_SPACE = 'http://www.mediawiki.org/xml/export-0.4/'

#Multiprocess settings used to parallelize workload
#Change this to match your computers configuration (RAM / CPU)
NUMBER_OF_PROCESSES = cpu_count() * 1

#Extensions of ascii files, this is used to determine the filemode to use 
ASCII = ['txt', 'csv', 'xml', 'sql']

WP_DUMP_LOCATION = 'http://download.wikimedia.org'

LANGUAGE_MAPPING = {
'English': '/enwiki/latest/',
'Russian': '/ruwiki/latest/',
'German': '/dewiki/latest',
}
