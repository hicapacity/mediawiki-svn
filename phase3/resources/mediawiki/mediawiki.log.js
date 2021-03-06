/*
 * Implementation for mediaWiki.log stub
 */

/**
 * Log output to the console.
 * 
 * In the case that the browser does not have a console available, one is created by appending a
 * <div> element to the bottom of the body and then appending a <div> element to that for each
 * message.
 *
 * @author Michael Dale <mdale@wikimedia.org>
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @param {string} string Message to output to console
 */
mediaWiki.log = function( string ) {
	// Allow log messages to use a configured prefix		
	if ( mw.config.exists( 'mw.log.prefix' ) ) {
		string = mw.config.get( 'mw.log.prefix' ) + string;		
	}
	// Try to use an existing console
	if ( typeof window.console !== 'undefined' && typeof window.console.log == 'function' ) {
		window.console.log( string );
	} else {
		// Show a log box for console-less browsers
		var $log = jQuery( '#mw_log_console' );
		if ( !$log.length ) {
			$log = jQuery( '<div id="mw_log_console"></div>' )
				.css( {
					'position': 'absolute',
					'overflow': 'auto',
					'z-index': 500,
					'bottom': '0px',
					'left': '0px',
					'right': '0px',
					'height': '150px',
					'background-color': 'white',
					'border-top': 'solid 1px #DDDDDD'
				} )
				.appendTo( jQuery( 'body' ) );
		}
		$log.append(
			jQuery( '<div></div>' )
				.text( string )
				.css( {
					'border-bottom': 'solid 1px #DDDDDD',
					'font-size': 'small',
					'font-family': 'monospace',
					'padding': '0.125em 0.25em'
				} )
		);
	}
};
