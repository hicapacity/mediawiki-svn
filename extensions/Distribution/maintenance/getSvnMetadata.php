<?php

/**
 * This script scrapes the WMF SVN repo for package meta-data and stores it
 * so it can be queried via the API.
 *
 * Usage:
 *  no parameters
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
 *
 * @author Jeroen De Dauw
 * 
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../../../maintenance/Maintenance.php' );

class GetSvnMetadata extends Maintenance {
	
	/**
	 * @var array or false
	 */
	protected $extensionList = false;
	
	/**
	 * @see Maintenance::execute
	 * 
	 * @since 0.1
	 */	
	public function __construct() {
		parent::__construct();
		
		$this->mDescription = "Scrapes the WMF SVN repo for package meta-data and stores it so it can be queried via the API.";
	}
	
	/**
	 * @see Maintenance::execute
	 * 
	 * @since 0.1
	 */
	public function execute() {
		$dbr = wfGetDB( DB_SLAVE );
		
		$extensions = $this->getExtensionList();
		
		$this->output( "..." );
	}
	
	/**
	 * Goes through a local checkout of the svn repository and returns a list
	 * with all found extensions. Based on getExtensionList from ExtensionDistributor.
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected function getExtensionList() {
		global $wgExtDistWorkingCopy, $wgExtDistBranches;

		if ( $this->extensionList !== false ) {
			return $this->extensionList;
		}

		$this->extensionList = array();
		
		foreach ( $wgExtDistBranches as $branchPath => $branch ) {
			$wc = "$wgExtDistWorkingCopy/$branchPath/extensions";
			$dir = opendir( $wc );
			
			if ( !$dir ) {
				return array();
			}

			$this->extensionList[$branchPath] = array();
			
			while ( false !== ( $file = readdir( $dir ) ) ) {
				if ( substr( $file, 0, 1 ) == '.' 
					|| !is_dir( "$wc/$file" )
					|| file_exists( "$wc/$file/NO-DIST" ) ) {
						continue;
				}

				$this->extensionList[$branchPath][] = $file;
			}
			
			natcasesort( $this->extensionList[$branchPath] );
		}
		
		return $this->extensionList;
	}	
	
}

$maintClass = "GetSvnMetadata";
require_once( DO_MAINTENANCE );