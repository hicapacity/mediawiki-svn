<?php
/**
 * @file
 * @ingroup Language
 * @ingroup SMWLanguage
 * @author Siebrand Mazeland
 */

/*
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) die();

global $smwgIP;
include_once( $smwgIP . 'languages/SMW_Language.php' );

/**
 * Dutch language labels for important SMW labels (namespaces, datatypes,...).
 *
 * @author Siebrand Mazeland
 * @ingroup SMWLanguage
 * @ingroup Language
 */
class SMWLanguageNl extends SMWLanguage {

protected $m_DatatypeLabels = array(
	'_wpg' => 'Pagina', // name of page datatype
	'_str' => 'String',  // name of the string type
	'_txt' => 'Tekst',  // name of the text type
	'_cod' => 'Code',  // name of the (source) code type
	'_boo' => 'Booleans',  // name of the boolean type
	'_num' => 'Getal', // name for the datatype of numbers
	'_geo' => 'Geographische coördinaat', // name of the geocoord type
	'_tem' => 'Temperatuur',  // name of the temperature type
	'_dat' => 'Datum',  // name of the datetime (calendar) type
	'_ema' => 'E-mail',  // name of the email type
	'_uri' => 'URL',  // name of the URL type
	'_anu' => 'Annotatie URI',  // name of the annotation URI type (OWL annotation property)
	'_tel' => 'Telephone number',  // name of the telephone (URI) type //TODO: translate
	'_rec' => 'Record', // name of record data type //TODO: translate
);

protected $m_DatatypeAliases = array(
	'URI'                   => '_uri',
	'Integer'               => '_num',
	'Float'                 => '_num',
	'Opsomming'             => '_str',
);

protected $m_SpecialProperties = array(
	// always start upper-case
	'_TYPE' => 'Heeft type',
	'_URI'  => 'Equivalent URI',
	'_SUBP' => 'Subeigenschap van',
	'_SUBC' => 'Subcategory of', // TODO: translate
	'_UNIT' => 'Weergaveeenheden',
	'_IMPO' => 'Geïmporteerd uit',
	'_CONV' => 'Komt overeen met',
	'_SERV' => 'Verleent dienst',
	'_PVAL' => 'Geldige waarde',
	'_MDAT' => 'Wijzigingsdatum',
	'_ERRP' => 'Has improper value for', // TODO: translate
	'_LIST' => 'Has fields', // TODO: translate
);

protected $m_Namespaces = array(
	SMW_NS_PROPERTY       => 'Eigenschap',
	SMW_NS_PROPERTY_TALK  => 'Overleg_eigenschap',
	SMW_NS_TYPE           => 'Type',
	SMW_NS_TYPE_TALK      => 'Overleg_type',
	SMW_NS_CONCEPT        => 'Concept',
	SMW_NS_CONCEPT_TALK   => 'Overleg_concept'
);

protected $m_months = array( 'januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december' );

protected $m_monthsshort = array( "jan", "feb", "mar", "apr", "mei", "jun", "jul", "aug", "sep", "okt", "nov", "dec" );

}
