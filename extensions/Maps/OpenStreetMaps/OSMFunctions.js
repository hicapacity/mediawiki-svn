/* 
 * @file OSMFunctions.js
 * @ingroup Maps
 *
 * @author Harry Wood, Jens Frank, Grant Slater, Raymond Spekking, Jeroen De Dauw and others 
 *
 * @description
 *
 * Javascript functions for OSM optimized Open Layers functionallity in Maps and it's extensions
 *
 * This defines what happens when <slippymap> tag is placed in the wikitext
 * 
 * We show a map based on the lat/lon/zoom data passed in. This extension brings in
 * the OpenLayers javascript, to show a slippy map.
 * 
 * Usage example:
 * <slippymap lat=51.485 lon=-0.15 z=11 w=300 h=200 layer=osmarender></slippymap>
 * 
 * Tile images are not cached local to the wiki.
 * To acheive this (remove the OSM dependency) you might set up a squid proxy,
 * and modify the requests URLs here accordingly.
 * 
 * This file should be placed in the mediawiki 'extensions' directory
 * ...and then it needs to be 'included' within LocalSettings.php
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
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */

var slippymaps = new Array();
var mapId = 0;
var layer = null;

if (false) { // wgSlippyMapSlippyByDefault
	addOnloadHook(slippymap_init);
}
	
function slippymap_init() {
	for(keyName in slippymaps) {
		slippymaps[keyName].init();
	}
}
	
function slippymap_map(mapId, mapParams) {
	var self = this;
	this.mapId = mapId;
	
	for (key in mapParams)
		this[key] = mapParams[key];
		
	/*
	var buttonsPanel = new OpenLayers.Control.Panel( { displayClass: "buttonsPanel" } );
	buttonsPanel.addControls([	new OpenLayers.Control.Button({
									title: wgSlippyMapButtonCode,
									displayClass: "getWikiCodeButton",
									trigger: function() { self.getWikicode(); }
								}), 
								new OpenLayers.Control.Button({
									title: wgSlippyMapResetview,
									displayClass: "resetButton",
									trigger: function() { self.resetPosition(); }
								})
							]);
							*/

	this.mapOptions = { controls: [ new OpenLayers.Control.Navigation(),
                                  	new OpenLayers.Control.ArgParser(),
                                  	new OpenLayers.Control.Attribution(),
                                  	/* buttonsPanel */ ]                                  
                      };

	/* Add the zoom bar control, except if the map is only little */
	if (this.height > 320)
		this.mapOptions.controls.push(new OpenLayers.Control.PanZoomBar());
	else if (this.height > 140)
		this.mapOptions.controls.push(new OpenLayers.Control.PanZoom());	
}

slippymap_map.prototype.init = function() {
	/* Swap out against the preview image */
	var previewImage = document.getElementById('mapPreview' + this.mapId);	
	if (previewImage)
		previewImage.style.display = 'none';

	this.map = this.osm_create(this.mapId, this.lon, this.lat, this.zoom);
	
	if (this.marker) {
		var markers = new OpenLayers.Layer.Markers( "Markers" );
		this.map.addLayer(markers);
		var icon = OpenLayers.Marker.defaultIcon();
		markers.addMarker(new OpenLayers.Marker(new OpenLayers.LonLat(this.lon, this.lat).transform(new OpenLayers.Projection('EPSG:4326'), this.map.getProjectionObject()), icon));
	}
}

slippymap_map.prototype.osm_create = function(mapId, lon, lat, zoom) {
	var osmLayer;
	var map = new OpenLayers.Map(mapId, this.mapOptions /* all provided for by OSM.js */);
	
	if (this.layer == 'osm-like') {
		osmLayer = new OpenLayers.Layer.OSM("meh", 'http://cassini.toolserver.org/tiles/osm-like/' + this.locale + '/${z}/${x}/${y}.png');
    }
	
	map.addLayers([osmLayer]);
	map.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection('EPSG:4326'), map.getProjectionObject()), zoom);
	return map;
}

slippymap_map.prototype.resetPosition = function() {
	this.map.setCenter(new OpenLayers.LonLat(this.lon, this.lat).transform(new OpenLayers.Projection('EPSG:4326'), this.map.getProjectionObject()), this.zoom);
}

slippymap_map.prototype.getWikicode = function() {
	LL = this.map.getCenter().transform(this.map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	Z = this.map.getZoom();
	size = this.map.getSize();
	
	prompt(
	    wgSlippyMapCode,
	    "<slippymap lat=" + LL.lat + " lon=" + LL.lon + " zoom=" + Z + " width=" + size.w + " height=" + size.h + " mode=" + this.mode + " layer=" + this.layer + (this.marker == 0 ? "" : " marker=" + this.marker) + " />"
	);
}



