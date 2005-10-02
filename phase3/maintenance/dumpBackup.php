<?php
/**
 * Copyright (C) 2005 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or 
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 */

$originalDir = getcwd();

$optionsWithArgs = array( 'server', 'pagelist', 'start', 'end' );

require_once( 'commandLine.inc' );
require_once( 'SpecialExport.php' );

class BackupDumper {
	var $reportingInterval = 100;
	var $reporting = true;
	var $pageCount = 0;
	var $revCount  = 0;
	var $server    = null; // use default
	var $pages     = null; // all pages
	var $skipHeader = false; // don't output <mediawiki> and <siteinfo>
	var $skipFooter = false; // don't output </mediawiki>
	var $startId    = 0;
	var $endId      = 0;
	var $sink       = null; // Output filters
	
	function BackupDumper( $args ) {
		$this->stderr = fopen( "php://stderr", "wt" );
		$this->sink = $this->processArgs( $args );
	}
	
	/**
	 * @param array $args
	 * @return array
	 * @static
	 */
	function processArgs( $args ) {
		$outputTypes = array(
			'file'  => 'DumpFileOutput',
			'gzip'  => 'DumpGZipOutput',
			'bzip2' => 'DumpBZip2Output',
			'7zip'  => 'Dump7ZipOutput' );
		$filterTypes = array(
			'latest'    => 'DumpLatestFilter',
			'notalk'    => 'DumpNotalkFilter',
			'namespace' => 'DumpNamespaceFilter' );
		$sink = null;
		$sinks = array();
		foreach( $args as $arg ) {
			if( preg_match( '/^--(.+?)(?:=(.+?)(?::(.+?))?)?$/', $arg, $matches ) ) {
				@list( $full, $opt, $val, $param ) = $matches;
				switch( $opt ) {
				case "output":
					if( !is_null( $sink ) ) {
						$sinks[] = $sink;
					}
					if( !isset( $outputTypes[$val] ) ) {
						die( "Unrecognized output sink type '$val'\n" );
					}
					$type = $outputTypes[$val];
					$sink = new $type( $param );
					break;
				case "filter":
					if( is_null( $sink ) ) {
						$this->progress( "Warning: assuming stdout for filter output\n" );
						$sink = new DumpOutput();
					}
					if( !isset( $filterTypes[$val] ) ) {
						die( "Unrecognized filter type '$val'\n" );
					}
					$type = $filterTypes[$val];
					$filter = new $type( $sink, $param );
					
					// references are lame in php...
					unset( $sink );
					$sink = $filter;
					
					break;
				default:
					//die( "Unrecognized dump option'$opt'\n" );
				}
			}
		}
		
		if( is_null( $sink ) ) {
			$sink = new DumpOutput();
		}
		$sinks[] = $sink;
		
		if( count( $sinks ) > 1 ) {
			return new DumpMultiWriter( $sinks );
		} else {
			return $sink;
		}
	}
	
	function dump( $history ) {
		# This shouldn't happen if on console... ;)
		header( 'Content-type: text/html; charset=UTF-8' );
		
		# Notice messages will foul up your XML output even if they're
		# relatively harmless.
		ini_set( 'display_errors', false );
		
		$this->startTime = wfTime();
		
		$dbr =& wfGetDB( DB_SLAVE );
		$this->maxCount = $dbr->selectField( 'page', 'MAX(page_id)', '', 'BackupDumper::dump' );
		$this->startTime = wfTime();
		
		$db =& $this->backupDb();
		$exporter = new WikiExporter( $db, $history, MW_EXPORT_STREAM );
		
		$wrapper = new ExportProgressFilter( $this->sink, $this );
		$exporter->setOutputSink( $wrapper );
		
		if( !$this->skipHeader )
			$exporter->openStream();

		if( is_null( $this->pages ) ) {
			if( $this->startId || $this->endId ) {
				$exporter->pagesByRange( $this->startId, $this->endId );
			} else {
				$exporter->allPages();
			}
		} else {
			$exporter->pagesByName( $this->pages );
		}

		if( !$this->skipFooter )
			$exporter->closeStream();
		
		$this->report( true );
	}
	
	function &backupDb() {
		global $wgDBadminuser, $wgDBadminpassword;
		global $wgDBname;
		$db =& new Database( $this->backupServer(), $wgDBadminuser, $wgDBadminpassword, $wgDBname );
		$timeout = 3600 * 24;
		$db->query( "SET net_read_timeout=$timeout" );
		$db->query( "SET net_write_timeout=$timeout" );
		return $db;
	}
	
	function backupServer() {
		global $wgDBserver;
		return $this->server
			? $this->server
			: $wgDBserver;
	}

	function reportPage() {
		$this->pageCount++;
		$this->report();
	}
	
	function revCount() {
		$this->revCount++;
	}
	
	function report( $final = false ) {
		if( $final xor ( $this->pageCount % $this->reportingInterval == 0 ) ) {
			$this->showReport();
		}
	}
	
	function showReport() {
		if( $this->reporting ) {
			$delta = wfTime() - $this->startTime;
			$now = wfTimestamp( TS_DB );
			if( $delta ) {
				$rate = $this->pageCount / $delta;
				$revrate = $this->revCount / $delta;
				$portion = $this->pageCount / $this->maxCount;
				$eta = $this->startTime + $delta / $portion;
				$etats = wfTimestamp( TS_DB, intval( $eta ) );
			} else {
				$rate = '-';
				$revrate = '-';
				$etats = '-';
			}
			global $wgDBname;
			$this->progress( "$now: $wgDBname $this->pageCount, ETA $etats ($rate pages/sec $revrate revs/sec)" );
		}
	}
	
	function progress( $string ) {
		fwrite( $this->stderr, $string . "\n" );
	}
}

class ExportProgressFilter extends DumpFilter {
	function ExportProgressFilter( &$sink, &$progress ) {
		parent::DumpFilter( $sink );
		$this->progress = $progress;
	}

	function writeClosePage( $string ) {
		parent::writeClosePage( $string );
		$this->progress->reportPage();
	}
	
	function writeRevision( $rev, $string ) {
		parent::writeRevision( $rev, $string );
		$this->progress->revCount();
	}
}

$dumper = new BackupDumper( $argv );

if( isset( $options['quiet'] ) ) {
	$dumper->reporting = false;
}
if( isset( $options['report'] ) ) {
	$dumper->reportingInterval = intval( $options['report'] );
}
if( isset( $options['server'] ) ) {
	$dumper->server = $options['server'];
}

if ( isset( $options['pagelist'] ) ) {
	$olddir = getcwd();
	chdir( $originalDir );
	$pages = file( $options['pagelist'] );
	chdir( $olddir );
	if ( $pages === false ) {
		print "Unable to open file {$options['pagelist']}\n";
		exit;
	}
	$pages = array_map( 'trim', $pages );
	$dumper->pages = array_filter( $pages, create_function( '$x', 'return $x !== "";' ) );
}

if( isset( $options['start'] ) ) {
	$dumper->startId = intval( $options['start'] );
}
if( isset( $options['end'] ) ) {
	$dumper->endId = intval( $options['end'] );
}
$dumper->skipHeader = isset( $options['skip-header'] );
$dumper->skipFooter = isset( $options['skip-footer'] );

if( isset( $options['full'] ) ) {
	$dumper->dump( MW_EXPORT_FULL );
} elseif( isset( $options['current'] ) ) {
	$dumper->dump( MW_EXPORT_CURRENT );
} else {
	$dumper->progress( <<<END
This script dumps the wiki page database into an XML interchange wrapper
format for export or backup.

XML output is sent to stdout; progress reports are sent to stderr.

Usage: php dumpBackup.php <action> [<options>]
Actions:
  --full      Dump complete history of every page.
  --current   Includes only the latest revision of each page.

Options:
  --quiet     Don't dump status reports to stderr.
  --report=n  Report position and speed after every n pages processed.
              (Default: 100)
  --server=h  Force reading from MySQL server h
  --start=n   Start from page_id n
  --end=n     Stop before page_id n (exclusive)
  --skip-header Don't output the <mediawiki> header
  --skip-footer Don't output the </mediawiki> footer
END
);
}

?>
