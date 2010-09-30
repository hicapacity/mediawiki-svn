<?php

/**
 * File holding the MapsGoogleMaps3 class.
 *
 * @file Maps_GoogleMaps3.php
 * @ingroup MapsGoogleMaps3
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class holding information and functionallity specific to Google Maps v3.
 * This infomation and features can be used by any mapping feature. 
 * 
 * @since 0.1
 * 
 * @ingroup MapsGoogleMaps3
 * 
 * @author Jeroen De Dauw
 */
class MapsGoogleMaps3 extends MapsMappingService {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6.6
	 */	
	function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'google3', 'googlemap3', 'gmap3', 'gmaps3' )
		);
	}
	
	/**
	 * @see MapsMappingService::addParameterInfo
	 * 
	 * @since 0.7
	 */	
	public function addParameterInfo( array &$params ) {
		global $egMapsGMaps3Type, $egMapsGMaps3Types;
		
		Validator::addOutputFormat( 'gmap3type', array( __CLASS__, 'setGMapType' ) );
		Validator::addOutputFormat( 'gmap3types', array( __CLASS__, 'setGMapTypes' ) );		
		
		$params['type'] = new Parameter(
			'type',
			Parameter::TYPE_STRING,
			$egMapsGMaps3Type,// FIXME: default value should not be used when not present in types parameter.
			array(),
			array(
				new CriterionInArray( self::getTypeNames() ),
			),
			array( 'types' )		
		);

		// TODO
		$params['type']->outputTypes = array( 'gmap3type' => array( 'gmap3type' ) );		
	}
	
	/**
	 * @see iMappingService::getDefaultZoom
	 * 
	 * @since 0.6.5
	 */	
	public function getDefaultZoom() {
		global $egMapsGoogleMaps3Zoom;
		return $egMapsGoogleMaps3Zoom;
	}	
	
	/**
	 * @see MapsMappingService::getMapId
	 * 
	 * @since 0.6.5
	 */
	public function getMapId( $increment = true ) {
		global $egMapsGoogleMaps3Prefix, $egGoogleMaps3OnThisPage;
		
		if ( $increment ) {
			$egGoogleMaps3OnThisPage++;
		}
		
		return $egMapsGoogleMaps3Prefix . '_' . $egGoogleMaps3OnThisPage;
	}	
	
	/**
	 * @see MapsMappingService::createMarkersJs
	 * 
	 * @since 0.6.5
	 */
	public function createMarkersJs( array $markers ) {
		$markerItems = array();
		
		foreach ( $markers as $marker ) {
			$markerItems[] = Xml::encodeJsVar( (object)array(
				'lat' => $marker[0],
				'lon' => $marker[1],
				'title' => $marker[2],
				'label' =>$marker[3],
				'icon' => $marker[4]
			) );
		}
		
		// Create a string containing the marker JS.
		return '[' . implode( ',', $markerItems ) . ']';
	}	
	
	protected static $mapTypes = array(
		'normal' => 'ROADMAP',
		'roadmap' => 'ROADMAP',
		'satellite' => 'SATELLITE',
		'hybrid' => 'HYBRID',
		'terrain' => 'TERRAIN',
		'physical' => 'TERRAIN'
	);
	
	/**
	 * Returns the names of all supported map types.
	 * 
	 * @return array
	 */
	public static function getTypeNames() {
		return array_keys( self::$mapTypes );
	}
	
	/**
	 * Changes the map type name into the corresponding Google Maps API v3 identifier.
	 *
	 * @param string $type
	 * 
	 * @return string
	 */
	public static function setGMapType( &$type, $name, array $parameters ) {
		$type = 'google.maps.MapTypeId.' . self::$mapTypes[ $type ];
	}
	
	/**
	 * Changes the map type names into the corresponding Google Maps API v3 identifiers.
	 * 
	 * @param array $types
	 * 
	 * @return array
	 */
	public static function setGMapTypes( array &$types, $name, array $parameters ) {
		for ( $i = count( $types ) - 1; $i >= 0; $i-- ) {
			self::setGMapType( $types[$i], $name, $parameters );
		}
	}
	
	/**
	 * @see MapsMappingService::getDependencies
	 * 
	 * @return array
	 */
	protected function getDependencies() {
		global $wgLang;
		global $egMapsStyleVersion, $egMapsScriptPath;

		$languageCode = self::getMappedLanguageCode( $wgLang->getCode() );
		
		return array(
			Html::linkedScript( "http://maps.google.com/maps/api/js?sensor=false&language=$languageCode" ),
			Html::linkedScript( "$egMapsScriptPath/includes/services/GoogleMaps3/GoogleMap3Functions.js?$egMapsStyleVersion" ),
		);			
	}
	
	/**
	 * Maps language codes to Google Maps API v3 compatible values.
	 * 
	 * @param string $code
	 * 
	 * @return string The mapped code
	 */
	protected static function getMappedLanguageCode( $code ) {
		$mappings = array(
	         'en_gb' => 'en-gb',// v3 supports en_gb - but wants us to call it en-gb
	         'he' => 'iw',      // iw is googlish for hebrew
	         'fj' => 'fil',     // google does not support Fijian - use Filipino as close(?) supported relative
		);
		
		if ( array_key_exists( $code, $mappings ) ) {
			$code = $mappings[$code];
		}
		
		return $code;
	}
	
}								