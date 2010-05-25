/**
 * This plugin provides a way to build a wiki-text editing user interface around a textarea.
 * 
 * @example To intialize without any modules:
 * 		$j( 'div#edittoolbar' ).wikiEditor();
 * 
 * @example To initialize with one or more modules, or to add modules after it's already been initialized:
 * 		$j( 'textarea#wpTextbox1' ).wikiEditor( 'addModule', 'toolbar', { ... config ... } );
 * 
 */
( function( $ ) {

/**
 * Global static object for wikiEditor that provides generally useful functionality to all modules and contexts.
 */
$.wikiEditor = {
	/**
	 * For each module that is loaded, static code shared by all instances is loaded into this object organized by
	 * module name. The existance of a module in this object only indicates the module is available. To check if a
	 * module is in use by a specific context check the context.modules object.
	 */
	'modules': {},
	/**
	 * In some cases like with the iframe's HTML file, it's convienent to have a lookup table of all instances of the
	 * WikiEditor. Each context contains an instance field which contains a key that corrosponds to a reference to the
	 * textarea which the WikiEditor was build around. This way, by passing a simple integer you can provide a way back
	 * to a specific context.
	 */
	'instances': [],
	/**
	 * For each browser name, an array of conditions that must be met are supplied in [operaton, value]-form where
	 * operation is a string containing a JavaScript compatible binary operator and value is either a number to be
	 * compared with $.browser.versionNumber or a string to be compared with $.browser.version. If a browser is not
	 * specifically mentioned, we just assume things will work.
	 */
	'browsers': {
		// Left-to-right languages
		'ltr': {
			// The toolbar layout is broken in IE6
			'msie': [['>=', 7]],
			// Layout issues in FF < 2
			'firefox': [['>=', 2]],
			// Text selection bugs galore - this may be a different situation with the new iframe-based solution
			'opera': [['>=', 9.6]],
			// jQuery minimums
			'safari': [['>=', 3]],
			'chrome': [['>=', 3]],
			'blackberry': false,
			'ipod': false,
			'iphone': false
		},
		// Right-to-left languages
		'rtl': {
			// The toolbar layout is broken in IE 7 in RTL mode, and IE6 in any mode
			'msie': [['>=', 8]],
			// Layout issues in FF < 2
			'firefox': [['>=', 2]],
			// Text selection bugs galore - this may be a different situation with the new iframe-based solution
			'opera': [['>=', 9.6]],
			// jQuery minimums
			'safari': [['>=', 3]],
			'chrome': [['>=', 3]],
			'blackberry': false,
			'ipod': false,
			'iphone': false
		}
	},
	/**
	 * Path to images - this is a bit messy, and it would need to change if this code (and images) gets moved into the
	 * core - or anywhere for that matter...
	 */
	'imgPath' : wgScriptPath + '/extensions/UsabilityInitiative/images/wikiEditor/',
	/**
	 * Checks the current browser against the browsers object to determine if the browser has been black-listed or not.
	 * Because these rules are often very complex, the object contains configurable operators and can check against
	 * either the browser version number or string. This process also involves checking if the current browser is amung
	 * those which we have configured as compatible or not. If the browser was not configured as comptible we just go on
	 * assuming things will work - the argument here is to prevent the need to update the code when a new browser comes
	 * to market. The assumption here is that any new browser will be built on an existing engine or be otherwise so
	 * similar to another existing browser that things actually do work as expected. The merrits of this argument, which
	 * is essentially to blacklist rather than whitelist are debateable, but at this point we've decided it's the more
	 * "open-web" way to go.
	 * @param module Module object, defaults to $.wikiEditor
	 */
	'isSupported': function( module ) {
		// Fallback to the wikiEditor browser map if no special map is provided in the module
		var mod = module && 'browsers' in module ? module : $.wikiEditor;
		// Check for and make use of cached value and early opportunities to bail
		if ( typeof mod.supported !== 'undefined' ) {
			// Cache hit
			return mod.supported;
		}
		// Check if we have any compatiblity information on-hand for the current browser
		if ( !( $.browser.name in mod.browsers[$( 'body' ).is( '.rtl' ) ? 'rtl' : 'ltr'] ) ) {
			// Assume good faith :) 
			return mod.supported = true;
		}
		// Check over each browser condition to determine if we are running in a compatible client
		var browser = mod.browsers[$( 'body' ).is( '.rtl' ) ? 'rtl' : 'ltr'][$.browser.name];
		if ( typeof browser != 'object' ) {
			return mod.supported = false;
		}
		for ( var condition in browser ) {
			var op = browser[condition][0];
			var val = browser[condition][1];
			if ( val === false ) {
				return mod.supported = false;
			} else if ( typeof val == 'string' ) {
				if ( !( eval( '$.browser.version' + op + '"' + val + '"' ) ) ) {
					return mod.supported = false;
				}
			} else if ( typeof val == 'number' ) {
				if ( !( eval( '$.browser.versionNumber' + op + val ) ) ) {
					return mod.supported = false;
				}
			}
		}
		// Return and also cache the return value - this will be checked somewhat often
		return mod.supported = true;
	},
	/**
	 * Checks if a module has a specific requirement
	 * @param module Module object
	 * @param requirement String identifying requirement
	 */
	'isRequired': function( module, requirement ) {
		if ( typeof module['req'] !== 'undefined' ) {
			for ( req in module['req'] ) {
				if ( module['req'][req] == requirement ) {
					return true;
				}
			}
		}
		return false;
	},
	/**
	 * Provides a way to extract messages from objects. Wraps the mw.usability.getMsg() function, which
	 * may eventually become a wrapper for some kind of core MW functionality.
	 * 
	 * @param object Object to extract messages from
	 * @param property String of name of property which contains the message. This should be the base name of the
	 * property, which means that in the case of the object { this: 'that', fooMsg: 'bar' }, passing property as 'this'
	 * would return the raw text 'that', while passing property as 'foo' would return the internationalized message
	 * with the key 'bar'.
	 */
	'autoMsg': function( object, property ) {
		// Accept array of possible properties, of which the first one found will be used
		if ( typeof property == 'object' ) {
			for ( var i in property ) {
				if ( property[i] in object || property[i] + 'Msg' in object ) {
					property = property[i];
					break;
				}
			}
		}
		if ( property in object ) {
			return object[property];
		} else if ( property + 'Msg' in object ) {
			if ( typeof object[property + 'Msg' ] == 'object' ) {
				// [ messageKey, arg1, arg2, ... ]
				return mw.usability.getMsg.apply( mw.usability, object[property + 'Msg' ] );
			} else {
				return mw.usability.getMsg( object[property + 'Msg'] );
			}
		} else {
			return '';
		}
	},
	/**
	 * Provieds a way to extract a property of an object in a certain language, falling back on the property keyed as
	 * 'default'. If such key doesn't exist, the object itself is considered the actual value, which should ideally
	 * be the case so that you may use a string or object of any number of strings keyed by language with a default.
	 * 
	 * @param object Object to extract property from
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoLang': function( object, lang ) {
		return object[lang || wgUserLanguage] || object['default'] || object;
	},
	/**
	 * Provieds a way to extract the path of an icon in a certain language, automatically appending a version number for
	 * caching purposes and prepending an image path when icon paths are relative.
	 * 
	 * @param icon Icon object from e.g. toolbar config
	 * @param path Default icon path, defaults to $.wikiEditor.imgPath
	 * @param lang Language code, defaults to wgUserLanguage
	 */
	'autoIcon': function( icon, path, lang ) {
		var src = $.wikiEditor.autoLang( icon, lang );
		path = path || $.wikiEditor.imgPath;
		// Prepend path if src is not absolute
		if ( src.substr( 0, 7 ) != 'http://' && src.substr( 0, 8 ) != 'https://' && src[0] != '/' ) {
			src = path + src;
		}
		return src + '?' + wgWikiEditorIconVersion;
	}
};

/**
 * jQuery plugin that provides a way to initialize a wikiEditor instance on a textarea.
 */
$.fn.wikiEditor = function() {

// Skip any further work when running in browsers that are unsupported
if ( !$j.wikiEditor.isSupported() ) {
	return $(this);
}

/* Initialization */

// The wikiEditor context is stored in the element's data, so when this function gets called again we can pick up right
// where we left off
var context = $(this).data( 'wikiEditor-context' );
// On first call, we need to set things up, but on all following calls we can skip right to the API handling
if ( !context || typeof context == 'undefined' ) {
	
	// Star filling the context with useful data - any jQuery selections, as usual should be named with a preceding $
	context = {
		// Reference to the textarea element which the wikiEditor is being built around
		'$textarea': $(this),
		// Container for any number of mutually exclusive views that are accessible by tabs
		'views': {},
		// Container for any number of module-specific data - only including data for modules in use on this context
		'modules': {},
		// General place to shouve bits of data into
		'data': {},
		// Unique numeric ID of this instance used both for looking up and differentiating instances of wikiEditor
		'instance': $.wikiEditor.instances.push( $(this) ) - 1,
		// Array mapping elements in the textarea to character offsets
		'offsets': null,
		// Cache for context.fn.htmlToText()
		'htmlToTextMap': {},
		// The previous HTML of the iframe, stored to detect whether something really changed.
		'oldHTML': null,
		// Same for delayedChange()
		'oldDelayedHTML': null,
		// The previous selection of the iframe, stored to detect whether the selection has changed
		'oldDelayedSel': null,
		// Saved selection state for IE
		'savedSelection': null,
		// Stack of states in { html: [string] } form
		'history': [],
		// Current history state position - this is number of steps backwards, so it's always -1 or less
		'historyPosition': -1,
		/// The previous historyPosition, stored to detect if change events were due to an undo or redo action
		'oldDelayedHistoryPosition': -1
	};
	
	/*
	 * Externally Accessible API
	 * 
	 * These are available using calls to $j(selection).wikiEditor( call, data ) where selection is a jQuery selection
	 * of the textarea that the wikiEditor instance was built around.
	 */
	
	context.api = {
		/**
		 * Activates a module on a specific context with optional configuration data.
		 * 
		 * @param data Either a string of the name of a module to add without any additional configuration parameters,
		 * or an object with members keyed with module names and valued with configuration objects.
		 */
		'addModule': function( context, data ) {
			var modules = {};
			if ( typeof data == 'string' ) {
				modules[data] = {};
			} else if ( typeof data == 'object' ) {
				modules = data;
			}
			for ( var module in modules ) {
				// Check for the existance of an available / supported module with a matching name and a create function
				if ( typeof module == 'string' && $.wikiEditor.isSupported( $.wikiEditor.modules[module] ) ) {
					// Extend the context's core API with this module's own API calls
					if ( 'api' in $.wikiEditor.modules[module] ) {
						for ( var call in $.wikiEditor.modules[module].api ) {
							// Modules may not overwrite existing API functions - first come, first serve
							if ( !( call in context.api ) ) {
								context.api[call] = $.wikiEditor.modules[module].api[call];
							}
						}
					}
					// Activate the module on this context
					if ( 'fn' in $.wikiEditor.modules[module] && 'create' in $.wikiEditor.modules[module].fn ) {
						// Add a place for the module to put it's own stuff
						context.modules[module] = {};
						// Tell the module to create itself on the context
						$.wikiEditor.modules[module].fn.create( context, modules[module] );
					}
				}
			}
		}
	};
	
	/* 
	 * Event Handlers
	 * 
	 * These act as filters returning false if the event should be ignored or returning true if it should be passed
	 * on to all modules. This is also where we can attach some extra information to the events.
	 */
	
	context.evt = {
		/**
		 * Filters change events, which occur when the user interacts with the contents of the iframe. The goal of this
		 * function is to both classify the scope of changes as 'division' or 'character' and to prevent further
		 * processing of events which did not actually change the content of the iframe.
		 */
		'keydown': function( event ) {
			switch ( event.which ) {
				case 90: // z
				case 89: // y
					if ( event.which == 89 && !$.browser.msie ) { 
						// only handle y events for IE
						return true;
					} else if ( ( event.ctrlKey || event.metaKey ) && context.history.length ) {
						// HistoryPosition is a negative number between -1 and -context.history.length, in other words
						// it's the number of steps backwards from the latest state.
						var newPosition;
						if ( event.shiftKey || event.which == 89 ) {
							// Redo
							newPosition = context.historyPosition + 1;
						} else {
							// Undo
							newPosition = context.historyPosition - 1;
						}
						// Only act if we are switching to a valid state
						if ( newPosition >= ( context.history.length * -1 ) && newPosition < 0 ) {
							// Make sure we run the history storing code before we make this change
							context.fn.updateHistory( context.oldDelayedHTML != context.$content.html() );
							context.oldDelayedHistoryPosition = context.historyPosition;
							context.historyPosition = newPosition;
							// Change state
							// FIXME: Destroys event handlers, will be a problem with template folding
							context.$content.html(
								context.history[context.history.length + context.historyPosition].html
							);
							context.fn.purgeOffsets();
							if( context.history[context.history.length + context.historyPosition].sel ) {
								context.fn.setSelection( { 
									start: context.history[context.history.length + context.historyPosition].sel[0],
									end: context.history[context.history.length + context.historyPosition].sel[1]
								} );
							}
						}
						// Prevent the browser from jumping in and doing its stuff
						return false;
					}
					break;
					// Intercept all tab events to provide consisten behavior across browsers
					// Webkit browsers insert tab characters by default into the iframe rather than changing input focus
				case 9: //tab
						// if any modifier keys are pressed, allow the browser to do it's thing
						if ( event.ctrlKey || event.altKey || event.shiftKey ) { 
							return true;
						} else {
							var $tabindexList = $j( '[tabindex]:visible' ).sort( function( a, b ) {
								return a.tabIndex - b.tabIndex;
							} );
							for( var i=0; i < $tabindexList.length; i++ ) {
								if( $tabindexList.eq( i ).attr('id') == context.$iframe.attr( 'id' ) ) {
									$tabindexList.get( i + 1 ).focus();
									break;
								}
							}
							return false;
						}
					break;
				 case 86: //v
					 if ( event.ctrlKey && $.browser.msie ) {
						 //paste, intercepted for IE
						 context.evt.paste( event );
					 }
					 break;
			}
			return true;
		},
		'change': function( event ) {
			event.data.scope = 'division';
			var newHTML = context.$content.html();
			if ( context.oldHTML != newHTML ) {
				context.fn.purgeOffsets();
				context.oldHTML = newHTML;
				event.data.scope = 'realchange';
			}
			// Never let the body be totally empty
			if ( context.$content.children().length == 0 ) {
				context.$content.append( '<p></p>' );
			}
			return true;
		},
		'delayedChange': function( event ) {
			event.data.scope = 'division';
			var newHTML = context.$content.html();
			if ( context.oldDelayedHTML != newHTML ) {
				context.oldDelayedHTML = newHTML;
				event.data.scope = 'realchange';
				// Surround by <p> if it does not already have it
				var cursorPos = context.fn.getCaretPosition();
				var t = context.fn.getOffset( cursorPos[0] );
				if ( ! $.browser.msie && t && t.node.nodeName == '#text' && t.node.parentNode.nodeName.toLowerCase() == 'body' ) {
					$( t.node ).wrap( "<p></p>" );
					context.fn.purgeOffsets();
					context.fn.setSelection( { start: cursorPos[0], end: cursorPos[1] } );
				}
			}
			context.fn.updateHistory( event.data.scope == 'realchange' );
			return true;
		},
		'cut': function( event ) {
			setTimeout( function() {
				context.$content.find( 'br' ).each( function() {
					if ( $(this).parent().is( 'body' ) ) {
						$(this).wrap( $( '<p></p>' ) );
					}
				} );
			}, 100 );
			return true;
		},
		'paste': function( event ) {
			// Save the cursor position to restore it after all this voodoo
			var cursorPos = context.fn.getCaretPosition();
			if ( !context.$content.text() ) {
				context.$content.empty();
			}
			var oldLength = context.fn.getContents().length;
			
			context.$content.find( '*' ).addClass( 'wikiEditor' );
			if ( $.layout.name !== 'webkit' ) {
				context.$content.addClass( 'pasting' );
			}
			setTimeout( function() {
				// Kill stuff we know we don't want
				context.$content.find( 'script,style,img,input,select,textarea,hr,button,link,meta' ).remove();
				// This is just downright strange - but if we do this on nodes with text nodes, it fixes allot of
				// space collapsing issues at element boundries
				context.$content.find( '*' ).each( function() {
					if ( $(this).children().length == 0 && this.childNodes.length > 0 ) {
						$(this).text( $(this).text() );
					}
				} );
				// MS Word + webkit
				context.$content.find( 'p:not(.wikiEditor) p:not(.wikiEditor)' )
					.each( function(){
						var outerParent = $(this).parent();
						outerParent.replaceWith( outerParent.childNodes );
					} );

				// Unwrap the span found in webkit copies (Apple Richtext)
				if ( ! $.browser.msie ) {
					context.$content.find( 'span.Apple-style-span' ).each( function() {
						$(this).replaceWith( this.childNodes );
					} );
				}
				
				var $selection = context.$content.find( ':not(.wikiEditor)' );
				var newElementHTML = '' ;
				var $markElement = null;
				while ( $selection.length && $selection.length > 0 ) {
					var $currentElement = $selection.eq( 0 );
						
					//go up till we find the first pasted element
					while ( !$currentElement.parent().is( 'body' ) && !$currentElement.parent().is( '.wikiEditor' ) ) {
						$currentElement = $currentElement.parent();
					}
					//go to the previous element till we find the first pasted element
					while ( $currentElement[0] != null && 
							$currentElement[0].previousSibling != null && 
							!$( $currentElement[0].previousSibling ).hasClass( 'wikiEditor' ) ) {
						$currentElement = $( $currentElement[0].previousSibling );
					}
					
					// we're going to collect and sanitize all the pasted content and then insert it at $markElement 
					var currentHTML = '';
					if ( $currentElement[0].nodeName == '#text' ) { 
						//if it is a text node then just append it
						currentHTML = $currentElement[0].nodeValue;
					} else {
						currentHTML = $currentElement.html();
						// First remove all new lines
						currentHTML = currentHTML.replace( /\r?\n/g, '');
						//replace all forms of <p> tags with a \n. All other tags get removed.
						currentHTML = currentHTML.replace(/(<[\s]*p[^>]*>)|(<[\s]*\/p[^>]*>)|(<[\s]*p[^\/>]*\/>)/gi, '\n');
						// Replace all forms of html tags that should end up in their own <p>
						currentHTML = currentHTML.replace(/(<[\s]*p[^>]*>)|(<[\s]*\/p[^>]*>)|(<[\s]*p[^\/>]*\/>)|(<[\s]*h[\d][^>]*>)|(<[\s]*h[\d][^\/>]*\/>)/gi, '\n');
						currentHTML = currentHTML.replace(/(<[^>]*>)|(<[^\>]*\>)/gi, '');
						currentHTML += '\n';
					}
					newElementHTML += currentHTML;
					
					if ( $markElement == null ) {
						$markElement = $( '<div></div>' ).addClass( 'wikiEditor' ).insertAfter( $currentElement );
                    }
					$currentElement.remove();
					$selection = context.$content.find( ':not(.wikiEditor)' );
				}
				
				//now put a <p> around each line of pasted content
				var pieces = newElementHTML.split( '\n' );
				var $newElement;
				for ( var i = 0; i < pieces.length; i++ ) {
					$newElement = $( '<p></p>' );
					if ( pieces[i] ) {
						$newElement.text( pieces[i] );
					} else {
						$newElement.html( '<br>' );
					}
					
					$newElement.insertAfter( $markElement );
					if (i == 0 ) {
						$markElement.remove();
					}
					$markElement = $newElement;
				}


				context.$content.find( '.wikiEditor' ).removeClass( 'wikiEditor' );
				if ( $.layout.name !== 'webkit' ) {
					context.$content.removeClass( 'pasting' );
				}
				
				
				// Restore cursor position
				context.fn.purgeOffsets();
				var newLength = context.fn.getContents().length;
				var restoreTo = cursorPos[0] + newLength - oldLength;
				if ( restoreTo > newLength ) {
					restoreTo = newLength;
				}
				context.fn.setSelection( { start: restoreTo, end: restoreTo } );
			}, 0 );
			return true;
		},
		'ready': function( event ) {
			// Initialize our history queue
			context.history.push( { 'html': context.$content.html(), 'sel':  context.fn.getCaretPosition() } );
			return true;
		}
	};
	
	/* Internal Functions */
	
	context.fn = {
		/**
		 * Executes core event filters as well as event handlers provided by modules.
		 */
		'trigger': function( name, event ) {
			// Event is an optional argument, but from here on out, at least the type field should be dependable
			if ( typeof event == 'undefined' ) {
				event = { 'type': 'custom' };
			}
			// Ensure there's a place for extra information to live
			if ( typeof event.data == 'undefined' ) {
				event.data = {};
			}
			// Allow filtering to occur
			if ( name in context.evt ) {
				if ( !context.evt[name]( event ) ) {
					return false;
				}
			}
			
			var returnFromModules = null; //they return null by default
			// Pass the event around to all modules activated on this context
			for ( var module in context.modules ) {
				if (
					module in $.wikiEditor.modules &&
					'evt' in $.wikiEditor.modules[module] &&
					name in $.wikiEditor.modules[module].evt
				) {
					var ret = $.wikiEditor.modules[module].evt[name]( context, event );
					if (ret != null) {
						//if 1 returns false, the end result is false
						if( returnFromModules == null ) {
							returnFromModules = ret; 
						} else {
							returnFromModules = returnFromModules && ret;
						} 
					}
				}
			}
			if ( returnFromModules != null ) {
				return returnFromModules;
			} else {
				return true;
			}
		},
		/**
		 * Adds a button to the UI
		 */
		'addButton': function( options ) {
			// Ensure that buttons and tabs are visible
			context.$controls.show();
			context.$buttons.show();
			return $( '<button />' )
				.text( $.wikiEditor.autoMsg( options, 'caption' ) )
				.click( options.action )
				.appendTo( context.$buttons );
		},
		/**
		 * Adds a view to the UI, which is accessed using a set of tabs. Views are mutually exclusive and by default a
		 * wikitext view will be present. Only when more than one view exists will the tabs will be visible.
		 */
		'addView': function( options ) {
			// Adds a tab
			function addTab( options ) {
				// Ensure that buttons and tabs are visible
				context.$controls.show();
				context.$tabs.show();
				// Return the newly appended tab
				return $( '<div></div>' )
					.attr( 'rel', 'wikiEditor-ui-view-' + options.name )
					.addClass( context.view == options.name ? 'current' : null )
					.append( $( '<a></a>' )
						.attr( 'href', '#' )
						.mousedown( function() {
							// No dragging!
							return false;
						} )
						.click( function( event ) {
							context.$ui.find( '.wikiEditor-ui-view' ).hide();
							context.$ui.find( '.' + $(this).parent().attr( 'rel' ) ).show();
							context.$tabs.find( 'div' ).removeClass( 'current' );
							$(this).parent().addClass( 'current' );
							$(this).blur();
							if ( 'init' in options && typeof options.init == 'function' ) {
								options.init( context );
							}
							event.preventDefault();
							return false;
						} )
						.text( $.wikiEditor.autoMsg( options, 'title' ) )
					)
					.appendTo( context.$tabs );
			}
			// Automatically add the previously not-needed wikitext tab
			if ( !context.$tabs.children().size() ) {
				addTab( { 'name': 'wikitext', 'titleMsg': 'wikieditor-wikitext-tab' } );
			}
			// Add the tab for the view we were actually asked to add
			addTab( options );
			// Return newly appended view
			return $( '<div></div>' )
				.addClass( 'wikiEditor-ui-view wikiEditor-ui-view-' + options.name )
				.hide()
				.appendTo( context.$ui );
		},
		'highlightLine': function( $element, mode ) {
			if ( !$element.is( 'p' ) ) {
				$element = $element.closest( 'p' );
			}
			$element.css( 'backgroundColor', '#AACCFF' );
			setTimeout( function() { $element.animate( { 'backgroundColor': 'white' }, 'slow' ); }, 100 );
			setTimeout( function() { $element.css( 'backgroundColor', 'white' ); }, 1000 );
		},
		'htmlToText': function( html ) {
			// This function is slow for large inputs, so aggressively cache input/output pairs
			if ( html in context.htmlToTextMap ) {
				return context.htmlToTextMap[html];
			}
			var origHTML = html;
			
			// We use this elaborate trickery for cross-browser compatibility
			// IE does overzealous whitespace collapsing for $( '<pre />' ).html( html );
			// We also do <br> and easy cases for <p> conversion here, complicated cases are handled later
			html = html
				.replace( /\r?\n/g, "" ) // IE7 inserts newlines before block elements
				.replace( /&nbsp;/g, " " ) // We inserted these to prevent IE from collapsing spaces
				.replace( /\<br[^\>]*\>\<\/p\>/gi, '</p>' ) // Remove trailing <br> from <p>
				.replace( /\<\/p\>\s*\<p[^\>]*\>/gi, "\n" ) // Easy case for <p> conversion
				.replace( /\<br[^\>]*\>/gi, "\n" ) // <br> conversion
				.replace( /\<\/p\>(\n*)\<p[^\>]*\>/gi, "$1\n" )
				// Un-nest <p> tags
				.replace( /\<p[^\>]*\><p[^\>]*\>/gi, '<p>' )
				.replace( /\<\/p\><\/p\>/gi, '</p>' );
			// Save leading and trailing whitespace now and restore it later. IE eats it all, and even Firefox
			// won't leave everything alone
			var leading = html.match( /^\s*/ )[0];
			var trailing = html.match( /\s*$/ )[0];
			html = html.substr( leading.length, html.length - leading.length - trailing.length );
			var $pre = $( '<pre>' + html + '</pre>' );
			$pre.find( '.wikiEditor-noinclude' ).each( function() { $( this ).remove(); } );
			// Convert tabs, <p>s and <br>s back
			$pre.find( '.wikiEditor-tab' ).each( function() { $( this ).text( "\t" ); } );
			$pre.find( 'br' ).each( function() { $( this ).replaceWith( "\n" ); } );
			// Converting <p>s is wrong if there's nothing before them, so check that.
			// .find( '* + p' ) isn't good enough because textnodes aren't considered
			$pre.find( 'p' ).each( function() {
				var text =  $( this ).text();
				// If this <p> is preceded by some text, add a \n at the beginning, and if
				// it's followed by a textnode, add a \n at the end
				// We need the traverser because there can be other weird stuff in between
				
				// Check for preceding text
				var t = new context.fn.rawTraverser( this.firstChild, this, $pre.get( 0 ), true ).prev();
				while ( t && t.node.nodeName != '#text' && t.node.nodeName != 'BR' && t.node.nodeName != 'P' ) {
					t = t.prev();
				}
				if ( t ) {
					text = "\n" + text;
				}
				
				// Check for following text
				t = new context.fn.rawTraverser( this.lastChild, this, $pre.get( 0 ), true ).next();
				while ( t && t.node.nodeName != '#text' && t.node.nodeName != 'BR' && t.node.nodeName != 'P' ) {
					t = t.next();
				}
				if ( t && !t.inP && t.node.nodeName == '#text' && t.node.nodeValue.charAt( 0 ) != '\n'
						&& t.node.nodeValue.charAt( 0 ) != '\r' ) {
					text += "\n";
				}
				$( this ).text( text );
			} );
			var retval;
			if ( $.browser.msie ) {
				// IE aggressively collapses whitespace in .text() after having done DOM manipulation,
				// but for some crazy reason this does work. Also convert \r back to \n
				retval = $( '<pre>' + $pre.html() + '</pre>' ).text().replace( /\r/g, '\n' );
			} else {
				retval = $pre.text();
			}
			return context.htmlToTextMap[origHTML] = leading + retval + trailing;
		},
		/**
		 * Get the first element before the selection that's in a certain class
		 * @param classname Class to match. Defaults to '', meaning any class
		 * @param strict If true, the element the selection starts in cannot match (default: false)
		 * @return jQuery object or null if unknown
		 */
		'beforeSelection': function( classname, strict ) {
			if ( typeof classname == 'undefined' ) {
				classname = '';
			}
			var e = null, offset = null;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var selection = context.$iframe[0].contentWindow.getSelection();
				// On load, webkit seems to not have a valid selection
				if ( selection.baseNode !== null ) {
					// Start at the selection's start and traverse the DOM backwards
					// This is done by traversing an element's children first, then the element itself, then its parent
					e = selection.getRangeAt( 0 ).startContainer;
					offset = selection.getRangeAt( 0 ).startOffset;
				} else {
					return null;
				}
				
				// When the cursor is on an empty line, Opera gives us a bogus range object with
				// startContainer=endContainer=body and startOffset=endOffset=1
				var body = context.$iframe[0].contentWindow.document.body;
				if ( $.browser.opera && e == body && offset == 1 ) {
					return null;
				}
			}
			if ( !e && context.$iframe[0].contentWindow.document.selection ) {
				// IE
				// Because there's nothing like range.startContainer in IE, we need to do a DOM traversal
				// to find the element the start of the selection is in
				var range = context.$iframe[0].contentWindow.document.selection.createRange();
				// Set range2 to the text before the selection
				var range2 = context.$iframe[0].contentWindow.document.body.createTextRange();
				// For some reason this call throws errors in certain cases, e.g. when the selection is
				// not in the iframe
				try {
					range2.setEndPoint( 'EndToStart', range );
				} catch ( ex ) {
					return null;
				}
				var seekPos = context.fn.htmlToText( range2.htmlText ).length;
				var offset = context.fn.getOffset( seekPos );
				e = offset ? offset.node : null;
				offset = offset ? offset.offset : null;
				if ( !e ) {
					return null;
				}
			}
			if ( e.nodeName != '#text' ) {
				// The selection is not in a textnode, but between two non-text nodes
				// (usually inside the <body> between two <br>s). Go to the rightmost
				// child of the node just before the selection
				var newE = e.firstChild;
				for ( var i = 0; i < offset - 1 && newE; i++ ) {
					newE = newE.nextSibling;
				}
				while ( newE && newE.lastChild ) {
					newE = newE.lastChild;
				}
				e = newE || e;
			}
			
			// We'd normally use if( $( e ).hasClass( class ) in the while loop, but running the jQuery
			// constructor thousands of times is very inefficient
			var classStr = ' ' + classname + ' ';
			while ( e ) {
				if ( !strict && ( !classname || ( ' ' + e.className + ' ' ).indexOf( classStr ) != -1 ) ) {
					return $( e );
				}
				var next = e.previousSibling;
				while ( next && next.lastChild ) {
					next = next.lastChild;
				}
				e = next || e.parentNode;
				strict = false;
			}
			return $( [] );
		},
		/**
		 * Object used by traverser(). Don't use this unless you know what you're doing
		 */
		'rawTraverser': function( node, inP, ancestor, skipNoinclude ) {
			this.node = node;
			this.inP = inP;
			this.ancestor = ancestor;
			this.skipNoinclude = skipNoinclude;
			this.next = function() {
				var p = this.node;
				var nextInP = this.inP;
				while ( p && !p.nextSibling ) {
					p = p.parentNode;
					if ( p == this.ancestor ) {
						// We're back at the ancestor, stop here
						p = null;
					}
					if ( p && p.nodeName == "P" ) {
						nextInP = null;
					}
				}
				p = p ? p.nextSibling : null;
				if ( p && p.nodeName == "P" ) {
					nextInP = p;
				}
				do {
					// Filter nodes with the wikiEditor-noinclude class
					// Don't use $( p ).hasClass( 'wikiEditor-noinclude' ) because
					// $() is slow in a tight loop
					if ( this.skipNoinclude ) {
						while ( p && ( ' ' + p.className + ' ' ).indexOf( ' wikiEditor-noinclude ' ) != -1 ) {
							p = p.nextSibling;
						}
					}
					if ( p && p.firstChild ) {
						p = p.firstChild;
						if ( p.nodeName == "P" ) {
							nextInP = p;
						}
					}
				} while ( p && p.firstChild );
				// Instead of calling the rawTraverser constructor, inline it. This avoids function call overhead
				return p ? { 'node': p, 'inP': nextInP, 'ancestor': this.ancestor,
						'skipNoinclude': this.skipNoinclude, 'next': this.next, 'prev': this.prev } : null;
			};
			this.prev = function() {
				var p = this.node;
				var prevInP = this.inP;
				while ( p && !p.previousSibling ) {
					p = p.parentNode;
					if ( p == this.ancestor ) {
						// We're back at the ancestor, stop here
						p = null;
					}
					if ( p && p.nodeName == "P" ) {
						prevInP = null;
					}
				}
				p = p ? p.previousSibling : null;
				if ( p && p.nodeName == "P" ) {
					prevInP = p;
				}
				do {
					// Filter nodes with the wikiEditor-noinclude class
					// Don't use $( p ).hasClass( 'wikiEditor-noinclude' ) because
					// $() is slow in a tight loop
					if ( this.skipNoinclude ) {
						while ( p && ( ' ' + p.className + ' ' ).indexOf( ' wikiEditor-noinclude ' ) != -1 ) {
							p = p.previousSibling;
						}
					}
					if ( p && p.lastChild ) {
						p = p.lastChild;
						if ( p.nodeName == "P" ) {
							prevInP = p;
						}
					}
				} while ( p && p.lastChild );
				// Instead of calling the rawTraverser constructor, inline it. This avoids function call overhead
				return p ? { 'node': p, 'inP': prevInP, 'ancestor': this.ancestor,
						'skipNoinclude': this.skipNoinclude, 'next': this.next, 'prev': this.prev } : null;
			};
		},
		/**
		 * Get an object used to traverse the leaf nodes in the iframe DOM. This traversal skips leaf nodes
		 * inside an element with the wikiEditor-noinclude class. This basically wraps rawTraverser
		 *
		 * @param start Node to start at
		 * @return Traverser object, use .next() or .prev() to get a traverser object referring to the
		 *  previous/next node
		 */
		'traverser': function( start ) {
			// Find the leftmost leaf node in the tree
			var startNode = start.jquery ? start.get( 0 ) : start;
			var node = startNode;
			var inP = node.nodeName == "P" ? node : null;
			do {
				// Filter nodes with the wikiEditor-noinclude class
				// Don't use $( p ).hasClass( 'wikiEditor-noinclude' ) because
				// $() is slow in a tight loop
				while ( node && ( ' ' + node.className + ' ' ).indexOf( ' wikiEditor-noinclude ' ) != -1 ) {
					node = node.nextSibling;
				}
				if ( node && node.firstChild ) {
					node = node.firstChild;
					if ( node.nodeName == "P" ) {
						inP = node;
					}
				}
			} while ( node && node.firstChild );
			return new context.fn.rawTraverser( node, inP, startNode, true );
		},
		'getOffset': function( offset ) {
			if ( !context.offsets ) {
				context.fn.refreshOffsets();
			}
			if ( offset in context.offsets ) {
				return context.offsets[offset];
			}
			// Our offset is not pre-cached. Find the highest offset below it and interpolate
			// We need to traverse the entire object because for() doesn't traverse in order
			// We don't do in-order traversal because the object is sparse
			var lowerBound = -1;
			for ( var o in context.offsets ) {
				var realO = parseInt( o );
				if ( realO < offset && realO > lowerBound) {
					lowerBound = realO;
				}
			}
			if ( !( lowerBound in context.offsets ) ) {
				// Weird edge case: either offset is too large or the document is empty
				return null;
			}
			var base = context.offsets[lowerBound];
			return context.offsets[offset] = {
				'node': base.node,
				'offset': base.offset + offset - lowerBound,
				'length': base.length,
				'lastTextNode': base.lastTextNode
			};
		},
		'purgeOffsets': function() {
			context.offsets = null;
		},
		'refreshOffsets': function() {
			context.offsets = [ ];
			var t = context.fn.traverser( context.$content );
			var pos = 0, lastTextNode = null;
			while ( t ) {
				if ( t.node.nodeName != '#text' && t.node.nodeName != 'BR' ) {
					t = t.next();
					continue;
				}
				var nextPos = t.node.nodeName == '#text' ? pos + t.node.nodeValue.length : pos + 1;
				var nextT = t.next();
				var leavingP = t.node.nodeName == '#text' && t.inP && nextT && ( !nextT.inP || nextT.inP != t.inP );
				context.offsets[pos] = {
					'node': t.node,
					'offset': 0,
					'length': nextPos - pos + ( leavingP ? 1 : 0 ),
					'lastTextNode': lastTextNode
				};
				if ( leavingP ) {
					// <p>Foo</p> looks like "Foo\n", make it quack like it too
					// Basically we're faking the \n character much like we're treating <br>s
					context.offsets[nextPos] = {
						'node': t.node,
						'offset': nextPos - pos,
						'length': nextPos - pos + 1,
						'lastTextNode': lastTextNode
					};
				}
				pos = nextPos + ( leavingP ? 1 : 0 );
				if ( t.node.nodeName == '#text' ) {
					lastTextNode = t.node;
				}
				t = nextT;
			}
		},
		'saveSelection': function() {
			if ( !$.browser.msie ) {
				// Only IE needs this
				return;
			}
			if ( typeof context.$iframe != 'undefined' ) {
				context.$iframe[0].contentWindow.focus();
				context.savedSelection = context.$iframe[0].contentWindow.document.selection.createRange();
			} else {
				context.$textarea.focus();
				context.savedSelection = document.selection.createRange();
			}
		},
		'restoreSelection': function() {
			if ( !$.browser.msie || context.savedSelection === null ) {
				return;
			}
			if ( typeof context.$iframe != 'undefined' ) {
				context.$iframe[0].contentWindow.focus();
			} else {
				context.$textarea.focus();
			}
			context.savedSelection.select();
			context.savedSelection = null;
		},
		/**
		 * Update the history queue
		 *
		 * @param htmlChange pass true or false to inidicate if there was a text change that should potentially
		 * 	be given a new history state. 
		 */
		'updateHistory': function( htmlChange ) {
			var newHTML = context.$content.html();
			var newSel = context.fn.getCaretPosition();
			// Was text changed? Was it because of a REDO or UNDO action? 
			if (
				context.history.length == 0 ||
				( htmlChange && context.oldDelayedHistoryPosition == context.historyPosition )
			) {
				context.oldDelayedSel = newSel;
				// Do we need to trim extras from our history? 
				// FIXME: this should really be happing on change, not on the delay
				if ( context.historyPosition < -1 ) {
					//clear out the extras
					context.history.splice( context.history.length + context.historyPosition + 1 );
					context.historyPosition = -1;
				}
				context.history.push( { 'html': newHTML, 'sel': newSel } );
				// If the history has grown longer than 10 items, remove the earliest one
				while ( context.history.length > 10 ) {
					context.history.shift();
				}
			} else if ( context.oldDelayedSel != newSel ) {
				// If only the selection was changed, update it
				context.oldDelayedSel = newSel;
				context.history[context.history.length + context.historyPosition].sel = newSel;
			}
			// synch our old delayed history position until the next undo/redo action
			context.oldDelayedHistoryPosition = context.historyPosition;
		},
		/**
		 * Sets up the iframe in place of the textarea to allow more advanced operations
		 */
		'setupIframe': function() {
			context.$iframe = $( '<iframe></iframe>' )
				.attr( {
					'frameBorder': 0,
					'border': 0,
					'tabindex': 1,
					'src': wgScriptPath + '/extensions/UsabilityInitiative/js/plugins/jquery.wikiEditor.html?' +
						'instance=' + context.instance + '&ts=' + ( new Date() ).getTime() + '&is=content',
					'id': 'wikiEditor-iframe-' + context.instance
				} )
				.css( {
					'backgroundColor': 'white',
					'width': '100%',
					'height': context.$textarea.height(),
					'display': 'none',
					'overflow-y': 'scroll',
					'overflow-x': 'hidden'
				} )
				.insertAfter( context.$textarea )
				.load( function() {
					// Internet Explorer will reload the iframe once we turn on design mode, so we need to only turn it
					// on during the first run, and then bail
					if ( !this.isSecondRun ) {
						// Turn the document's design mode on
						context.$iframe[0].contentWindow.document.designMode = 'on';
						// Let the rest of this function happen next time around
						if ( $.browser.msie ) {
							this.isSecondRun = true;
							return;
						}
					}
					// Get a reference to the content area of the iframe
					context.$content = $( context.$iframe[0].contentWindow.document.body );
					// Add classes to the body to influence the styles based on what's enabled
					for ( module in context.modules ) {
						context.$content.addClass( 'wikiEditor-' + module );
					}
					// If we just do "context.$content.text( context.$textarea.val() )", Internet Explorer will strip
					// out the whitespace charcters, specifically "\n" - so we must manually encode text and append it
					// TODO: Refactor this into a textToHtml() function
					var html = context.$textarea.val()
						// We're gonna use &esc; as an escape sequence
						.replace( /&esc;/g, '&esc;esc;' )
						// Escape existing uses of <p>, </p>, &nbsp; and <span class="wikiEditor-tab"></span>
						.replace( /\<p\>/g, '&esc;&lt;p&gt;' )
						.replace( /\<\/p\>/g, '&esc;&lt;/p&gt;' )
						.replace(
							/\<span class="wikiEditor-tab"\>\<\/span\>/g,
							'&esc;&lt;span&nbsp;class=&quot;wikiEditor-tab&quot;&gt;&lt;/span&gt;'
						)
						.replace( /&nbsp;/g, '&esc;&amp;nbsp;' );
					// We must do some extra processing on IE to avoid dirty diffs, specifically IE will collapse
					// leading spaces - browser sniffing is not ideal, but executing this code on a non-broken browser
					// doesn't cause harm
					if ( $.browser.msie ) {
						html = html.replace( /\t/g, '<span class="wikiEditor-tab"></span>' );
						if ( $.browser.versionNumber <= 7 ) {
							// Replace all spaces matching &nbsp; - IE <= 7 needs this because of its overzealous
							// whitespace collapsing
							html = html.replace( / /g, "&nbsp;" );
						} else {
							// IE8 is happy if we just convert the first leading space to &nbsp;
							html = html.replace( /(^|\n) /g, "$1&nbsp;" );
						}
					}
					// Use a dummy div to escape all entities
					// This'll also escape <br>, <span> and &nbsp; , so we unescape those after
					// We also need to unescape the doubly-escaped things mentioned above
					html = $( '<div />' ).text( '<p>' + html.replace( /\r?\n/g, '</p><p>' ) + '</p>' ).html()
						.replace( /&amp;nbsp;/g, '&nbsp;' )
						// Allow <p> tags to survive encoding
						.replace( /&lt;p&gt;/g, '<p>' )
						.replace( /&lt;\/p&gt;/g, '</p>' )
						// And <span class="wikiEditor-tab"></span> too
						.replace(
							/&lt;span( |&nbsp;)class=("|&quot;)wikiEditor-tab("|&quot;)&gt;&lt;\/span&gt;/g,
							'<span class="wikiEditor-tab"></span>'
						)
						// Empty <p> tags need <br> tags in them 
						.replace( /<p><\/p>/g, '<p><br></p>' )
						// Unescape &esc; stuff
						.replace( /&amp;esc;&amp;amp;nbsp;/g, '&amp;nbsp;' )
						.replace( /&amp;esc;&amp;lt;p&amp;gt;/g, '&lt;p&gt;' )
						.replace( /&amp;esc;&amp;lt;\/p&amp;gt;/g, '&lt;/p&gt;' )
						.replace(
							/&amp;esc;&amp;lt;span&amp;nbsp;class=&amp;quot;wikiEditor-tab&amp;quot;&amp;gt;&amp;lt;\/span&amp;gt;/g,
							'&lt;span class="wikiEditor-tab"&gt;&lt;\/span&gt;'
						)
						.replace( /&amp;esc;esc;/g, '&amp;esc;' );
					context.$content.html( html );
					
					// Reflect direction of parent frame into child
					if ( $( 'body' ).is( '.rtl' ) ) {
						context.$content.addClass( 'rtl' ).attr( 'dir', 'rtl' );
					}
					// Activate the iframe, encoding the content of the textarea and copying it to the content of iframe
					context.$textarea.attr( 'disabled', true );
					context.$textarea.hide();
					context.$iframe.show();
					// Let modules know we're ready to start working with the content
					context.fn.trigger( 'ready' );
					// Only save HTML now: ready handlers may have modified it
					context.oldHTML = context.oldDelayedHTML = context.$content.html();
					//remove our temporary loading
					/* Disaling our loading div for now
					$( '.wikiEditor-ui-loading' ).fadeOut( 'fast', function() {
						$( this ).remove();
					} );
					*/
					// Setup event handling on the iframe
					$( context.$iframe[0].contentWindow.document )
						.bind( 'keydown', function( event ) {
							event.jQueryNode = context.fn.getElementAtCursor();
							return context.fn.trigger( 'keydown', event );
							
						} )
						.bind( 'keyup', function( event ) {
							event.jQueryNode = context.fn.getElementAtCursor();
							return context.fn.trigger( 'keyup', event );
						} )
						.bind( 'keypress', function( event ) {
							event.jQueryNode = context.fn.getElementAtCursor();
							return context.fn.trigger( 'keypress', event );
						} )
						.bind( 'paste', function( event ) {
							return context.fn.trigger( 'paste', event );
						} )
						.bind( 'cut', function( event ) {
							return context.fn.trigger( 'cut', event );
						} )
						.bind( 'keyup paste mouseup cut encapsulateSelection', function( event ) {
							return context.fn.trigger( 'change', event );
						} )
						.delayedBind( 250, 'keyup paste mouseup cut encapsulateSelection', function( event ) {
							context.fn.trigger( 'delayedChange', event );
						} );
				} );
			// Attach a submit handler to the form so that when the form is submitted the content of the iframe gets
			// decoded and copied over to the textarea
			context.$textarea.closest( 'form' ).submit( function() {
				context.$textarea.attr( 'disabled', false );
				context.$textarea.val( context.$textarea.textSelection( 'getContents' ) );
			} );
			/* FIXME: This was taken from EditWarning.js - maybe we could do a jquery plugin for this? */
			// Attach our own handler for onbeforeunload which respects the current one
			context.fallbackWindowOnBeforeUnload = window.onbeforeunload;
			window.onbeforeunload = function() {
				context.$textarea.val( context.$textarea.textSelection( 'getContents' ) );
				if ( context.fallbackWindowOnBeforeUnload ) {
					return context.fallbackWindowOnBeforeUnload();
				}
			};
		},
		
		/*
		 * Compatibility with the $.textSelection jQuery plug-in. When the iframe is in use, these functions provide
		 * equivilant functionality to the otherwise textarea-based functionality.
		 */
		
		'getElementAtCursor': function() {
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var selection = context.$iframe[0].contentWindow.getSelection();
				if ( selection.rangeCount == 0 ) {
					// We don't know where the cursor is
					return $( [] );
				}
				var sc = selection.getRangeAt( 0 ).startContainer;
				if ( sc.nodeName == "#text" ) sc = sc.parentNode;
				return $( sc );
			} else if ( context.$iframe[0].contentWindow.document.selection ) { // should come last; Opera!
				// IE
				var selection = context.$iframe[0].contentWindow.document.selection.createRange();
				return $( selection.parentElement() );
			}
		},
		
		/**
		 * Gets the complete contents of the iframe (in plain text, not HTML)
		 */
		'getContents': function() {
			// For <p></p>, .html() returns <p>&nbsp;</p> in IE
			// This seems to convince IE while not affecting display
			var html;
			if ( $.browser.msie ) {
				// Don't manipulate the iframe DOM itself, causes cursor jumping issues
				var $c = $( context.$content.get( 0 ).cloneNode( true ) );
				$c.find( 'p' ).each( function() {
					if ( $(this).html() == '' ) {
						$(this).replaceWith( '<p></p>' );
					}
				} );
				html = $c.html();
			} else {
				html = context.$content.html();
			}
			return context.fn.htmlToText( html );
		},
		/**
		 * Gets the currently selected text in the content
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'getSelection': function() {
			var retval;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				retval = context.$iframe[0].contentWindow.getSelection();
				if ( $.browser.opera ) {
					// Opera strips newlines in getSelection(), so we need something more sophisticated
					if ( retval.rangeCount > 0 ) {
						retval = context.fn.htmlToText( $( '<pre />' )
								.append( retval.getRangeAt( 0 ).cloneContents() )
								.html()
						);
					} else {
						retval = '';
					}
				}
			} else if ( context.$iframe[0].contentWindow.document.selection ) { // should come last; Opera!
				// IE
				retval = context.$iframe[0].contentWindow.document.selection.createRange();
			}
			if ( typeof retval.text != 'undefined' ) {
				// In IE8, retval.text is stripped of newlines, so we need to process retval.htmlText
				// to get a reliable answer. IE7 does get this right though
				// Run this fix for all IE versions anyway, it doesn't hurt
				retval = context.fn.htmlToText( retval.htmlText );
			} else if ( typeof retval.toString != 'undefined' ) {
				retval = retval.toString();
			}
			return retval;
		},
		/**
		 * Inserts text at the begining and end of a text selection, optionally inserting text at the caret when
		 * selection is empty.
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'encapsulateSelection': function( options ) {
			var selText = $(this).textSelection( 'getSelection' );
			var selTextArr;
			var collapseToEnd = false;
			var selectAfter = false;
			var setSelectionTo = null;
			var pre = options.pre, post = options.post;
			if ( !selText ) {
				selText = options.peri;
				selectAfter = true;
			} else if ( options.peri == selText.replace( /\s+$/, '' ) ) {
				// Probably a successive button press
				// strip any extra white space from selText
				selText = selText.replace( /\s+$/, '' );
				// set the collapseToEnd flag to ensure our selection is collapsed to the end before any insertion is done
				collapseToEnd = true;
				// set selectAfter to true since we know we'll be populating with our default text
				selectAfter = true;
			} else if ( options.replace ) {
				selText = options.peri;
			} else if ( selText.charAt( selText.length - 1 ) == ' ' ) {
				// Exclude ending space char
				// FIXME: Why?
				selText = selText.substring( 0, selText.length - 1 );
				post += ' ';
			}
			if ( options.splitlines ) {
				selTextArr = selText.split( /\n/ );
			}

			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var range = context.$iframe[0].contentWindow.getSelection().getRangeAt( 0 );
				// if our test above indicated that this was a sucessive button press, we need to collapse the 
				// selection to the end to avoid replacing text 
				if ( collapseToEnd ) {
					// Make sure we're not collapsing ourselves into a BR tag
					if ( range.endContainer.nodeName == 'BR' ) {
						range.setEndBefore( range.endContainer );
					}
					range.collapse( false );
				}
				if ( options.ownline ) {
					// We need to figure out if the cursor is at the start or end of a line
					var atStart = false, atEnd = false;
					var body = context.$content.get( 0 );
					if ( range.startOffset == 0 ) {
						// Start of a line
						// FIXME: Not necessarily the case with syntax highlighting or
						// template collapsing
						atStart = true;
					} else if ( range.startContainer == body ) {
						// Look up the node just before the start of the selection
						// If it's a <BR>, we're at the start of a line that starts with a
						// block element; if not, we're at the end of a line
						var n = body.firstChild;
						for ( var i = 0; i < range.startOffset - 1 && n; i++ ) {
							n = n.nextSibling;
						}
						if ( n && n.nodeName == 'BR' ) {
							atStart = true;
						} else {
							atEnd = true;
						}
					}
					if ( ( range.endOffset == 0 && range.endContainer.nodeValue == null ) ||
							( range.endContainer.nodeName == '#text' &&
									range.endOffset == range.endContainer.nodeValue.length ) ||
							( range.endContainer.nodeName == 'P' && range.endContainer.nodeValue == null ) ) {
						atEnd = true;
					}
					if ( !atStart ) {
						pre  = "\n" + options.pre;
					}
					if ( !atEnd ) {
						post += "\n";
					}
				}
				var insertText = "";
				if ( options.splitlines ) {
					for( var j = 0; j < selTextArr.length; j++ ) {
						insertText = insertText + pre + selTextArr[j] + post;
						if( j != selTextArr.length - 1 ) {
							insertText += "\n";
						}
					}
				} else {
					insertText = pre + selText + post;
				}
				var insertLines = insertText.split( "\n" );
				range.extractContents();
				// Insert the contents one line at a time - insertNode() inserts at the beginning, so this has to happen
				// in reverse order
				// Track the first and last inserted node, and if we need to also track where the text we need to select
				// afterwards starts and ends
				var firstNode = null, lastNode = null;
				var selSC = null, selEC = null, selSO = null, selEO = null, offset = 0;
				for ( var i = insertLines.length - 1; i >= 0; i-- ) {
					firstNode = context.$iframe[0].contentWindow.document.createTextNode( insertLines[i] );
					range.insertNode( firstNode );
					lastNode = lastNode || firstNode;
					var newOffset = offset + insertLines[i].length;
					if ( !selEC && post.length <= newOffset ) {
						selEC = firstNode;
						selEO = selEC.nodeValue.length - ( post.length - offset );
					}
					if ( selEC && !selSC && pre.length >= insertText.length - newOffset ) {
						selSC = firstNode;
						selSO = pre.length - ( insertText.length - newOffset );
					}
					offset = newOffset;
					if ( i > 0 ) {
						firstNode = context.$iframe[0].contentWindow.document.createElement( 'br' );
						range.insertNode( firstNode );
						newOffset = offset + 1;
						if ( !selEC && post.length <= newOffset ) {
							selEC = firstNode;
							selEO = 1 - ( post.length - offset );
						}
						if ( selEC && !selSC && pre.length >= insertText.length - newOffset ) {
							selSC = firstNode;
							selSO = pre.length - ( insertText.length - newOffset );
						}
						offset = newOffset;
					}
				}
				if ( firstNode ) {
					context.fn.scrollToTop( $( firstNode.parentNode ) );
				}
				if ( selectAfter ) {
					setSelectionTo = {
						startContainer: selSC,
						endContainer: selEC,
						start: selSO,
						end: selEO
					};
				} else if  ( lastNode ) {
					setSelectionTo = {
						startContainer: lastNode,
						endContainer: lastNode,
						start: lastNode.nodeValue.length,
						end: lastNode.nodeValue.length
					};
				}
			} else if ( context.$iframe[0].contentWindow.document.selection ) {
				// IE
				context.$iframe[0].contentWindow.focus();
				var range = context.$iframe[0].contentWindow.document.selection.createRange();
				if ( options.ownline && range.moveStart ) {
					// Check if we're at the start of a line
					// If not, prepend a newline
					var range2 = context.$iframe[0].contentWindow.document.selection.createRange();
					range2.collapse();
					range2.moveStart( 'character', -1 );
					// FIXME: Which check is correct?
					if ( range2.text != "\r" && range2.text != "\n" && range2.text != "" ) {
						pre = "\n" + pre;
					}
					
					// Check if we're at the end of a line
					// If not, append a newline
					var range3 = context.$iframe[0].contentWindow.document.selection.createRange();
					range3.collapse( false );
					range3.moveEnd( 'character', 1 );
					if ( range3.text != "\r" && range3.text != "\n" && range3.text != "" ) {
						post += "\n";
					}
				}
				// if our test above indicated that this was a sucessive button press, we need to collapse the
				// selection to the end to avoid replacing text
				if ( collapseToEnd ) {
					range.collapse( false );
				}
				// TODO: Clean this up. Duplicate code due to the pre-existing browser specific structure of this
				// function
				var insertText = "";
				if ( options.splitlines ) {
					for( var j = 0; j < selTextArr.length; j++ ) {
						insertText = insertText + pre + selTextArr[j] + post;
						if( j != selTextArr.length - 1 ) {
							insertText += "\n"; 
						}
					}
				} else {
					insertText = pre + selText + post;
				}
				// TODO: Maybe find a more elegant way of doing this like the Firefox code above?
				range.pasteHTML( insertText
						.replace( /\</g, '&lt;' )
						.replace( />/g, '&gt;' )
						.replace( /\r?\n/g, '<br />' )
				);
				if ( selectAfter ) {
					range.moveStart( 'character', -post.length - selText.length );
					range.moveEnd( 'character', -post.length );
					range.select();
				}
			}
			
			if ( setSelectionTo ) {
				context.fn.setSelection( setSelectionTo );
			}
			// Trigger the encapsulateSelection event (this might need to get named something else/done differently)
			$( context.$iframe[0].contentWindow.document ).trigger(
				'encapsulateSelection', [ pre, options.peri, post, options.ownline, options.replace ]
			);
			return context.$textarea;
		},
		/**
		 * Gets the position (in resolution of bytes not nessecarily characters) in a textarea
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'getCaretPosition': function( options ) {
			var startPos = null, endPos = null;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				var selection = context.$iframe[0].contentWindow.getSelection();
				if ( selection.rangeCount == 0 ) {
					// We don't know where the cursor is
					return [ 0, 0 ];
				}
				var sc = selection.getRangeAt( 0 ).startContainer, ec = selection.getRangeAt( 0 ).endContainer;
				var so = selection.getRangeAt( 0 ).startOffset, eo = selection.getRangeAt( 0 ).endOffset;
				if ( sc.nodeName == 'BODY' ) {
					// Grab the node just before the start of the selection
					var n = sc.firstChild;
					for ( var i = 0; i < so - 1 && n; i++ ) {
						n = n.nextSibling;
					}
					sc = n;
					so = 0;
				}
				if ( ec.nodeName == 'BODY' ) {
					var n = ec.firstChild;
					for ( var i = 0; i < eo - 1 && n; i++ ) {
						n = n.nextSibling;
					}
					ec = n;
					eo = 0;
				}
				
				// Make sure sc and ec are leaf nodes
				while ( sc.firstChild ) {
					sc = sc.firstChild;
				}
				while ( ec.firstChild ) {
					ec = ec.firstChild;
				}
				// Make sure the offsets are regenerated if necessary
				context.fn.getOffset( 0 );
				var o;
				for ( o in context.offsets ) {
					if ( startPos === null && context.offsets[o].node == sc ) {
						// For some wicked reason o is a string, even though
						// we put it in as an integer. Use ~~ to coerce it too an int
						startPos = ~~o + so - context.offsets[o].offset;
					}
					if ( startPos !== null && context.offsets[o].node == ec ) {
						endPos = ~~o + eo - context.offsets[o].offset;
						break;
					}
				}
			} else if ( context.$iframe[0].contentWindow.document.selection ) {
				// IE
				// FIXME: This is mostly copypasted from the textSelection plugin
				var d = context.$iframe[0].contentWindow.document;
				var postFinished = false;
				var periFinished = false;
				var postFinished = false;
				var preText, rawPreText, periText;
				var rawPeriText, postText, rawPostText;
				// Depending on the document state, and if the cursor has ever been manually placed within the document
				// the following call such as setEndPoint can result in nasty errors. These cases are always cases
				// in which the start and end points can safely be assumed to be 0, so we will just try our best to do
				// the full process but fall back to 0.
				try {
					// Create range containing text in the selection
					var periRange = d.selection.createRange().duplicate();
					// Create range containing text before the selection
					var preRange = d.body.createTextRange();
					// Move the end where we need it
					preRange.setEndPoint( "EndToStart", periRange );
					// Create range containing text after the selection
					var postRange = d.body.createTextRange();
					// Move the start where we need it
					postRange.setEndPoint( "StartToEnd", periRange );
					// Load the text values we need to compare
					preText = rawPreText = preRange.text;
					periText = rawPeriText = periRange.text;
					postText = rawPostText = postRange.text;
					/*
					 * Check each range for trimmed newlines by shrinking the range by 1
					 * character and seeing if the text property has changed. If it has
					 * not changed then we know that IE has trimmed a \r\n from the end.
					 */
					do {
						if ( !postFinished ) {
							if ( preRange.compareEndPoints( "StartToEnd", preRange ) == 0 ) {
								postFinished = true;
							} else {
								preRange.moveEnd( "character", -1 )
								if ( preRange.text == preText ) {
									rawPreText += "\r\n";
								} else {
									postFinished = true;
								}
							}
						}
						if ( !periFinished ) {
							if ( periRange.compareEndPoints( "StartToEnd", periRange ) == 0 ) {
								periFinished = true;
							} else {
								periRange.moveEnd( "character", -1 )
								if ( periRange.text == periText ) {
									rawPeriText += "\r\n";
								} else {
									periFinished = true;
								}
							}
						}
						if ( !postFinished ) {
							if ( postRange.compareEndPoints("StartToEnd", postRange) == 0 ) {
								postFinished = true;
							} else {
								postRange.moveEnd( "character", -1 )
								if ( postRange.text == postText ) {
									rawPostText += "\r\n";
								} else {
									postFinished = true;
								}
							}
						}
					} while ( ( !postFinished || !periFinished || !postFinished ) );
					startPos = rawPreText.replace( /\r\n/g, "\n" ).length;
					endPos = startPos + rawPeriText.replace( /\r\n/g, "\n" ).length;
				} catch( e ) {
					startPos = endPos = 0;
				}
			}
			return [ startPos, endPos ];
		},
		/**
		 * Sets the selection of the content
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 *
		 * @param start Character offset of selection start
		 * @param end Character offset of selection end
		 * @param startContainer Element in iframe to start selection in. If not set, start is a character offset
		 * @param endContainer Element in iframe to end selection in. If not set, end is a character offset
		 */
		'setSelection': function( options ) {
			var sc = options.startContainer, ec = options.endContainer;
			sc = sc && sc.jquery ? sc[0] : sc;
			ec = ec && ec.jquery ? ec[0] : ec;
			if ( context.$iframe[0].contentWindow.getSelection ) {
				// Firefox and Opera
				var start = options.start, end = options.end;
				if ( !sc || !ec ) {
					var s = context.fn.getOffset( start );
					var e = context.fn.getOffset( end );
					sc = s ? s.node : null;
					ec = e ? e.node : null;
					start = s ? s.offset : null;
					end = e ? e.offset : null;
					// Don't try to set the selection past the end of a node, causes errors
					// Just put the selection at the end of the node in this case
					if ( sc != null && sc.nodeName == '#text' && start > sc.nodeValue.length ) {
						start = sc.nodeValue.length - 1;
					}
					if ( ec != null && ec.nodeName == '#text' && end > ec.nodeValue.length ) {
						end = ec.nodeValue.length - 1;
					}
				}
				if ( !sc || !ec ) {
					// The requested offset isn't in the offsets array
					// Give up
					return context.$textarea;
				}
				
				var sel = context.$iframe[0].contentWindow.getSelection();
				while ( sc.firstChild && sc.nodeName != '#text' ) {
					sc = sc.firstChild;
				}
				while ( ec.firstChild && ec.nodeName != '#text' ) {
					ec = ec.firstChild;
				}
				var range = context.$iframe[0].contentWindow.document.createRange();
				range.setStart( sc, start );
				range.setEnd( ec, end );
				sel.removeAllRanges();
				sel.addRange( range );
				context.$iframe[0].contentWindow.focus();
			} else if ( context.$iframe[0].contentWindow.document.body.createTextRange ) {
				// IE
				var range = context.$iframe[0].contentWindow.document.body.createTextRange();
				if ( sc ) {
					range.moveToElementText( sc );
				}
				range.collapse();
				range.moveEnd( 'character', options.start );
				
				var range2 = context.$iframe[0].contentWindow.document.body.createTextRange();
				if ( ec ) {
					range2.moveToElementText( ec );
				}
				range2.collapse();
				range2.moveEnd( 'character', options.end );
				
				// IE does newline emulation for <p>s: <p>foo</p><p>bar</p> becomes foo\nbar just fine
				// but <p>foo</p><br><br><p>bar</p> becomes foo\n\n\n\nbar , one \n too many
				// Correct for this
				var matches, counted = 0;
				// while ( matches = range.htmlText.match( regex ) && matches.length <= counted ) doesn't work
				// because the assignment side effect hasn't happened yet when the second term is evaluated
				while ( matches = range.htmlText.match( /\<\/p\>(\<br[^\>]*\>)+\<p\>/gi ) ) {
					if ( matches.length <= counted )
						break;
					range.moveEnd( 'character', matches.length );
					counted += matches.length;
				}
				range2.moveEnd( 'character', counted );
				while ( matches = range2.htmlText.match( /\<\/p\>(\<br[^\>]*\>)+\<p\>/gi ) ) {
					if ( matches.length <= counted )
						break;
					range2.moveEnd( 'character', matches.length );
					counted += matches.length;
				}

				range2.setEndPoint( 'StartToEnd', range );
				range2.select();
			}
			return context.$textarea;
		},
		/**
		 * Scroll a textarea to the current cursor position. You can set the cursor position with setSelection()
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 */
		'scrollToCaretPosition': function( options ) {
			context.fn.scrollToTop( context.fn.getElementAtCursor(), true );
		},
		/**
		 * Scroll an element to the top of the iframe
		 * DO NOT CALL THIS DIRECTLY, use $.textSelection( 'functionname', options ) instead
		 *
		 * @param $element jQuery object containing an element in the iframe
		 * @param force If true, scroll the element even if it's already visible
		 */
		'scrollToTop': function( $element, force ) {
			var html = context.$content.closest( 'html' ),
				body = context.$content.closest( 'body' ),
				parentHtml = $( 'html' ),
				parentBody = $( 'body' );
			var y = $element.offset().top;
			if ( !$.browser.msie && ! $element.is( 'body' ) ) {
				y = parentHtml.scrollTop() > 0 ? y + html.scrollTop() - parentHtml.scrollTop() : y;
				y = parentBody.scrollTop() > 0 ? y + body.scrollTop() - parentBody.scrollTop() : y;
			}
			var topBound = html.scrollTop() > body.scrollTop() ? html.scrollTop() : body.scrollTop(),
				bottomBound = topBound + context.$iframe.height();
			if ( force || y < topBound || y > bottomBound ) {
					html.scrollTop( y );
					body.scrollTop( y );
				}
			$element.trigger( 'scrollToTop' );
		},
		/**
		 * Save scrollTop and cursor position for IE.
		 */
		'saveStuffForIE': function() {
			// Only need this for IE in textarea mode
			if ( !$.browser.msie || context.$iframe )
				return;
			var IHateIE = {
				'scrollTop' : context.$textarea.scrollTop(),
				'pos': context.$textarea.textSelection( 'getCaretPosition', { startAndEnd: true } )
			};
			context.$textarea.data( 'IHateIE', IHateIE );
		},
		/**
		 * Restore scrollTo and cursor position for IE.
		 */
		'restoreStuffForIE': function() {
			// Only need this for IE in textarea mode
			if ( !$.browser.msie || context.$iframe )
				return;
			var IHateIE = context.$textarea.data( 'IHateIE' );
			if ( !IHateIE )
				return;
			context.$textarea.scrollTop( IHateIE.scrollTop );
			context.$textarea.textSelection( 'setSelection', { start: IHateIE.pos[0], end: IHateIE.pos[1] } );
			context.$textarea.data( 'IHateIE', null );
		}
	};
	
	/*
	 * Base UI Construction
	 * 
	 * The UI is built from several containers, the outer-most being a div classed as "wikiEditor-ui". These containers
	 * provide a certain amount of "free" layout, but in some situations procedural layout is needed, which is performed
	 * as a response to the "resize" event.
	 */
	
	// Assemble a temporary div to place over the wikiEditor while it's being constructed
	/* Disabling our loading div for now
	var $loader = $( '<div></div>' )
		.addClass( 'wikiEditor-ui-loading' )
		.append( $( '<span>' + mw.usability.getMsg( 'wikieditor-loading' ) + '</span>' )
			.css( 'marginTop', context.$textarea.height() / 2 ) );
	*/
	// Encapsulate the textarea with some containers for layout
	context.$textarea
	/* Disabling our loading div for now
		.after( $loader )
		.add( $loader )
	*/
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-view wikiEditor-ui-view-wikitext' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-left' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-bottom' ) )
		.wrapAll( $( '<div></div>' ).addClass( 'wikiEditor-ui-text' ) );
	// Get references to some of the newly created containers
	context.$ui = context.$textarea.parent().parent().parent().parent().parent();
	context.$wikitext = context.$textarea.parent().parent().parent().parent();
	// Add in tab and button containers
	context.$wikitext
		.before(
			$( '<div></div>' ).addClass( 'wikiEditor-ui-controls' )
				.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-tabs' ).hide() )
				.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-buttons' ) )
		)
		.before( $( '<div style="clear:both;"></div>' ) );
	// Get references to some of the newly created containers
	context.$controls = context.$ui.find( '.wikiEditor-ui-buttons' ).hide();
	context.$buttons = context.$ui.find( '.wikiEditor-ui-buttons' );
	context.$tabs = context.$ui.find( '.wikiEditor-ui-tabs' );
	// Clear all floating after the UI
	context.$ui.after( $( '<div style="clear:both;"></div>' ) );
	// Attach a right container
	context.$wikitext.append( $( '<div></div>' ).addClass( 'wikiEditor-ui-right' ) );
	// Attach a top container to the left pane
	context.$wikitext.find( '.wikiEditor-ui-left' ).prepend( $( '<div></div>' ).addClass( 'wikiEditor-ui-top' ) );
	// Setup the intial view
	context.view = 'wikitext';
	// Trigger the "resize" event anytime the window is resized
	$( window ).resize( function( event ) { context.fn.trigger( 'resize', event ); } );
}

/* API Execution */

// Since javascript gives arguments as an object, we need to convert them so they can be used more easily
var args = $.makeArray( arguments );

// Dynamically setup the Iframe when needed when adding modules
if ( typeof context.$iframe === 'undefined' && args[0] == 'addModule' && typeof args[1] != 'undefined' ) {
	var modules = args[1];
	if ( typeof modules != "object" ) {
		modules = {};
		modules[args[1]] = '';
	}
	for ( module in modules ) {
		// Only allow modules which are supported (and thus actually being turned on) affect this decision
		if ( module in $.wikiEditor.modules && $.wikiEditor.isSupported( $.wikiEditor.modules[module] ) &&
				$.wikiEditor.isRequired( $.wikiEditor.modules[module], 'iframe' ) ) {
			context.fn.setupIframe();
			break;
		}
	}
}

// There would need to be some arguments if the API is being called
if ( args.length > 0 ) {
	// Handle API calls
	var call = args.shift();
	if ( call in context.api ) {
		context.api[call]( context, typeof args[0] == 'undefined' ? {} : args[0] );
	}
}

// Store the context for next time, and support chaining
return $(this).data( 'wikiEditor-context', context );

}; } )( jQuery );