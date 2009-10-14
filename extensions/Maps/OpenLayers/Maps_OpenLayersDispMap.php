<?php

/**
 * Class for handling the display_map parser function with OpenLayers
 *
 * @file Maps_OpenLayersDispMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class MapsOpenLayersDispMap extends MapsBasePointMap {
	
	public $serviceName = MapsOpenLayersUtils::SERVICE_NAME;	
	
	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsOpenLayersZoom, $egMapsOpenLayersPrefix;
		
		$this->defaultParams = MapsOpenLayersUtils::getDefaultParams();
		
		$this->elementNamePrefix = $egMapsOpenLayersPrefix;
		$this->defaultZoom = $egMapsOpenLayersZoom;
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */		
	protected function doMapServiceLoad() {
		global $egOpenLayersOnThisPage;
		
		MapsOpenLayersUtils::addOLDependencies($this->output);
		$egOpenLayersOnThisPage++;
		
		$this->elementNr = $egOpenLayersOnThisPage;
	}	
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */	
	public function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$controlItems = MapsOpenLayersUtils::createControlsString($this->controls);
		
		MapsMapper::enforceArrayValues($this->layers);
		$layerItems = MapsOpenLayersUtils::createLayersStringAndLoadDependencies($this->output, $this->layers);

		MapsUtils::makePxValue($this->width);
		MapsUtils::makePxValue($this->height);	
		
		$this->output .= "<div id='$this->mapName' style='width: $this->width; height: $this->height; background-color: #cccccc;'></div>
		<script type='$wgJsMimeType'> /*<![CDATA[*/
			addLoadEvent(
				initOpenLayer('$this->mapName', $this->centre_lon, $this->centre_lat, $this->zoom, [$layerItems], [$controlItems],[])
			);
		/*]]>*/ </script>";
	}

}