/*
 * Legacy emulation for the now depricated skins/common/IEFixes.js
 * 
 * Internet Explorer JavaScript fixes
 */

( function( $, mw ) {

/* Support */

/**
 * Expand links for printing
 */
String.prototype.hasClass = function( classWanted ) {
	var classArr = this.split(/\s/);
	for ( var i = 0; i < classArr.length; i++ ) {
		if ( classArr[i].toLowerCase() == classWanted.toLowerCase() ) {
			return true;
		}
	}
	return false;
}

/* Extension */

$.extend( true, mw.legacy, {
	
	/* Global Variables */
	
	'isMSIE55': ( window.showModalDialog && window.clipboardData && window.createPopup ),
	'doneIETransform': null,
	'doneIEAlphaFix': null,
	'expandedURLs': null,
	
	/* Functions */
	
	'hookit': function() {
		if ( !mw.legacy.doneIETransform && document.getElementById && document.getElementById( 'bodyContent' ) ) {
			mw.legacy.doneIETransform = true;
			mw.legacy.relativeforfloats();
			mw.legacy.fixalpha();
		}
	},
	/**
	 * Fixes PNG alpha transparency
	 */
	'fixalpha': function( logoId ) {
		// bg
		if ( mw.legacy.isMSIE55 && !mw.legacy.doneIEAlphaFix ) {
			var plogo = document.getElementById( logoId || 'p-logo' );
			if ( !plogo ) {
				return;
			}
			var logoa = plogo.getElementsByTagName( 'a' )[0];
			if ( !logoa ) {
				return;
			}
			var bg = logoa.currentStyle.backgroundImage;
			var imageUrl = bg.substring( 5, bg.length - 2 );
			mw.legacy.doneIEAlphaFix = true;
			if ( imageUrl.substr( imageUrl.length - 4 ).toLowerCase() == '.png' ) {
				var logospan = logoa.appendChild( document.createElement( 'span' ) );
				logoa.style.backgroundImage = 'none';
				logospan.style.filter = 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=' + imageUrl + ')';
				logospan.style.height = '100%';
				logospan.style.position = 'absolute';
				logospan.style.width = logoa.currentStyle.width;
				logospan.style.cursor = 'hand';
				// Center image with hack for IE5.5
				if ( document.documentElement.dir == 'rtl' ) {
					logospan.style.right = '50%';
					logospan.style.setExpression( 'marginRight', '"-" + (this.offsetWidth / 2) + "px"' );
				} else {
					logospan.style.left = '50%';
					logospan.style.setExpression( 'marginLeft', '"-" + (this.offsetWidth / 2) + "px"' );
				}
				logospan.style.top = '50%';
				logospan.style.setExpression( 'marginTop', '"-" + (this.offsetHeight / 2) + "px"' );
				var linkFix = logoa.appendChild( logoa.cloneNode() );
				linkFix.style.position = 'absolute';
				linkFix.style.height = '100%';
				linkFix.style.width = '100%';
			}
		}
	},
	/*
	 * Fixes IE6 disappering float bug
	 */
	'relativeforfloats': function() {
		var bc = document.getElementById( 'bodyContent' );
		if ( bc ) {
			var tables = bc.getElementsByTagName( 'table' );
			var divs = bc.getElementsByTagName( 'div' );
		}
		mw.legacy.setrelative( tables );
		mw.legacy.setrelative( divs );
	},
	'setrelative': function ( nodes ) {
		var i = 0;
		while ( i < nodes.length ) {
			if( ( ( nodes[i].style.float && nodes[i].style.float != ( 'none' ) ||
				( nodes[i].align && nodes[i].align != ( 'none' ) ) ) &&
				( !nodes[i].style.position || nodes[i].style.position != 'relative' ) ) )
			{
				nodes[i].style.position = 'relative';
			}
			i++;
		}
	},
	'onbeforeprint': function() {
		mw.legacy.expandedURLs = [];
		var contentEl = document.getElementById( 'content' );
		if ( contentEl ) {
			var allLinks = contentEl.getElementsByTagName( 'a' );
			for ( var i = 0; i < allLinks.length; i++ ) {
				if ( allLinks[i].className.hasClass( 'external' ) && !allLinks[i].className.hasClass( 'free' ) ) {
					var expandedLink = document.createElement( 'span' );
					var expandedText = document.createTextNode( ' (' + allLinks[i].href + ')' );
					expandedLink.appendChild( expandedText );
					allLinks[i].parentNode.insertBefore( expandedLink, allLinks[i].nextSibling );
					mw.legacy.expandedURLs[i] = expandedLink;
				}
			}
		}
	},
	'onafterprint': function() {
		for ( var i = 0; i < mw.legacy.expandedURLs.length; i++ ) {
			if ( mw.legacy.expandedURLs[i] ) {
				mw.legacy.expandedURLs[i].removeNode( true );
			}
		}
	}
} );

/* Initialization */

$( document ).ready( function() {
	mw.legacy.hookit();
} );

} )( jQuery, mediaWiki );