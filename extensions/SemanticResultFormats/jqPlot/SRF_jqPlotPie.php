<?php
/**
 * A query printer for pie charts using the jqPlot JavaScript library.
 *
 * @author Sanyam Goyal
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    die( 'Not an entry point.' );
}

class SRFjqPlotPie extends SMWResultPrinter {
	protected $m_width = 400;
	protected $m_height = 400;
	protected $m_charttitle = " ";
	static protected $m_piechartnum = 1;

	protected function readParameters( $params, $outputmode ) {
		SMWResultPrinter::readParameters( $params, $outputmode );
		if ( array_key_exists( 'width', $this->m_params ) ) {
			$this->m_width = $this->m_params['width'];
		}
		if ( array_key_exists( 'height', $this->m_params ) ) {
			$this->m_height = $this->m_params['height'];
		}
		if ( array_key_exists( 'charttitle', $this->m_params ) ) {
			$this->m_charttitle = $this->m_params['charttitle'];
		} 
	}

    public function getName() {
	return wfMsg( 'srf_printername_jqplotpie' );
    }

    protected function getResultText( $res, $outputmode ) {
	global $smwgIQRunningNumber, $wgOut, $srfgScriptPath, $smwgScriptPath;
	global $wgParser;
	global $srfgJQPlotIncluded;
	
	$wgParser->disableCache();
	// adding scripts - this code may be moved to some other location

	$wgOut->includeJQuery();
	if ( !$srfgJQPlotIncluded ) {
	    $srfgJQPlotIncluded = true;
	    $jqplotScriptSrc = '<script type="text/javascript" src="'.$srfgScriptPath.'/jqPlot/jquery.jqplot.min.js"></script>';    
	    $wgOut->addScript($jqplotScriptSrc);
	}

	$PieScriptSrc = '<script type="text/javascript" src="'.$srfgScriptPath.'/jqPlot/jqplot.pieRenderer.min.js"></script>';
	$wgOut->addScript($PieScriptSrc);

	// CSS file
	$pie_css = array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen",
		'href' => $srfgScriptPath . '/jqPlot/jquery.jqplot.css'
	);
	$wgOut->addLink( $pie_css );
	$this->isHTML = true;

	$t = "";
	$jqplot_data = "";
	// print all result rows
	$first = true;
	$max = 0; // the biggest value. needed for scaling
	while ( $row = $res->getNext() ) {
	    $name = $row[0]->getNextObject()->getShortWikiText();
	    foreach ( $row as $field ) {
		while ( ( $object = $field->getNextObject() ) !== false ) {
		    if ( $object->isNumeric() ) { // use numeric sortkey
			if ( method_exists( $object, 'getValueKey' ) ) {
			    $nr = $object->getValueKey();
			}
			else {
			    $nr = $object->getNumericValue();
			}
			$max = max( $max, $nr );
			if ( $first ) {
			    $first = false;
			    $jqplot_data .= "[[['$name', $nr]";
			} else {
			    $jqplot_data .= ",['$name', $nr]";
			}
					}
				}
			}
		}
		$jqplot_data .= "]]";
		$pieID = 'pie' . self::$m_piechartnum;
		self::$m_piechartnum++;

		$js_pie =<<<END
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery.jqplot.config.enablePlugins = true;
	plot1 = jQuery.jqplot('$pieID', $jqplot_data, {
		title: '$this->m_charttitle',
		seriesDefaults: {
			renderer: jQuery.jqplot.PieRenderer,
			rendererOptions: {
				sliceMargin:2
			}
		},
			legend: { show:true }
	});
});
</script>

END;
		$wgOut->addScript($js_pie);

		$text =<<<END
<div id="$pieID" style="margin-top: 20px; margin-left: 20px; width: {$this->m_width}px; height: {$this->m_height}px;"></div>

END;
		return $text;
	}

	public function getParameters() {
		return array(
			array( 'name' => 'limit', 'type' => 'int', 'description' => wfMsg( 'smw_paramdesc_limit' ) ),
			array( 'name' => 'height', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartheight' ) ),
			array( 'name' => 'charttitle', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_charttitle' ) ),
			array( 'name' => 'width', 'type' => 'int', 'description' => wfMsg( 'srf_paramdesc_chartwidth' ) ),
		);
	}

}
