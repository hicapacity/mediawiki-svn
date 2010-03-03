/* TemplateEditor module for wikiEditor */
( function( $ ) { $.wikiEditor.modules.templateEditor = {
/**
 * Compatability map
 */
'browsers': {
	// Left-to-right languages
	'ltr': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]]
	},
	// Right-to-left languages
	'rtl': {
		'msie': [['>=', 8]],
		'firefox': [['>=', 3]],
		'opera': [['>=', 10]],
		'safari': [['>=', 4]]
	}
},
/**
 * Core Requirements
 */
'req': [ 'iframe' ],
/**
 * Event handlers
 */
evt: {
	mark: function( context, event ) {
		// Get references to the markers and tokens from the current context
		var markers = context.modules.highlight.markers;
		var tokenArray = context.modules.highlight.tokenArray;
		// Collect matching level 0 template call boundaries from the tokenArray
		var level = 0;
		
		var tokenIndex = 0;
		while ( tokenIndex < tokenArray.length ){
			while ( tokenIndex < tokenArray.length && tokenArray[tokenIndex].label != 'TEMPLATE_BEGIN' ) {
				tokenIndex++;
			}
			//open template
			if ( tokenIndex < tokenArray.length ) {
				var beginIndex = tokenIndex;
				var endIndex = -1; //no match found
				var openTemplates = 1;
				var templatesMatched = false;
				while ( tokenIndex < tokenArray.length - 1 && endIndex == -1 ) {
					tokenIndex++;
					if ( tokenArray[tokenIndex].label == 'TEMPLATE_BEGIN' ) {
						openTemplates++;
					} else if ( tokenArray[tokenIndex].label == 'TEMPLATE_END' ) {
						openTemplates--;
						if ( openTemplates == 0 ) {
							endIndex = tokenIndex;
						} //we can stop looping
					}
				}//while finding template ending
				if ( endIndex != -1 ) {
					markers.push( {
						start: tokenArray[beginIndex].offset,
						end: tokenArray[endIndex].offset,
						type: 'template',
						anchor: 'wrap',
						//splitPs: model.isCollapsible(),
						splitPs: false,
						afterWrap: function( node ) {
							// Generate model
							var model = new $.wikiEditor.modules.templateEditor.fn.model(
								$( node ).text()
							);
							$( node ).data( 'model', model );
							if ( model.isCollapsible() ) {
								$.wikiEditor.modules.templateEditor.fn.wrapTemplate( $( node ) );
							} else {
								$( node ).addClass( 'wikiEditor-template-text' );
							}
						},
						beforeUnwrap: function( node ) {
							if ( $( node ).parent().hasClass( 'wikiEditor-template' ) ) {
								$.wikiEditor.modules.templateEditor.fn.unwrapTemplate( $( node ) );
							}
						},
						onSkip: function( node ) {
							if ( $( node ).data( 'model' ).getText() == $( node ).text() ) {
								// No change
								return;
							}
							// Text changed, regenerate model
							var model = new $.wikiEditor.modules.templateEditor.fn.model(
								$( node ).text()
							);
							$( node ).data( 'model', model );
							
							if ( $( node ).parent().hasClass( 'wikiEditor-template' ) &&
									!model.isCollapsible() ) {
								$.wikiEditor.modules.templateEditor.fn.unwrapTemplate( $( node ) );
							} else if ( !$( node ).parent().hasClass( 'wikiEditor-template' ) &&
									model.isCollapsible() ) {
								$.wikiEditor.modules.templateEditor.fn.wrapTemplate( $( node ) );
							}
						},
						getAnchor: function( ca1, ca2 ) {
							return $( ca1.parentNode ).is( 'span.wikiEditor-template-text' ) ?
								ca1.parentNode : null;
						},
						context: context
					} );
				} else { //else this was an unmatched opening
					tokenArray[beginIndex].label = 'TEMPLATE_FALSE_BEGIN';
					tokenIndex = beginIndex;
				}
			}//if opentemplates
		}
	}
},
/**
 * Regular expressions that produce tokens
 */
exp: [
	{ 'regex': /{{/, 'label': "TEMPLATE_BEGIN" },
	{ 'regex': /}}/, 'label': "TEMPLATE_END", 'markAfter': true }
],
/**
 * Configuration 
 */
cfg: {
},
/**
 * Internally used functions
 */
fn: {
	/**
	 * Creates template form module within wikieditor
	 * @param context Context object of editor to create module in
	 * @param config Configuration object to create module from
	 */
	create: function( context, config ) {
		// Initialize module within the context
		context.modules.templateEditor = {};
	},
	/**
	 * Turns a simple template wrapper (really just a <span>) into a complex one
	 * @param $wrapper Wrapping <span>
	 */
	wrapTemplate: function( $wrapper ) {
		var model = $wrapper.data( 'model' );
		var context = $wrapper.data( 'marker' ).context;
		
		var $template = $wrapper
			.wrap( '<span class="wikiEditor-template"></span>' )
			.addClass( 'wikiEditor-template-text wikiEditor-nodisplay' )
			.parent()
			.addClass( 'wikiEditor-template-collapsed' )
			.data( 'model', model );
		
		var $templateName = $( '<span />' )
			.addClass( 'wikiEditor-template-name wikiEditor-noinclude' )
			.text( model.getName() )
			.mousedown( toggleWikiTextEditor )
			.prependTo( $template );
		
		var $templateExpand = $( '<span />' )
			.addClass( 'wikiEditor-template-expand wikiEditor-noinclude wikiEditor-template-expand-collapsed' )
			.mousedown( toggleWikiTextEditor )
			.prependTo( $template );
		
		var $templateDialog = $( '<span />' )
			.addClass( 'wikiEditor-template-dialog wikiEditor-noinclude wikiEditor-template-dialog-collapsed' )
			.mousedown( function() { createDialog( $template ); return false; } )
			.insertAfter( $templateName );

		function toggleWikiTextEditor() {
			context.fn.purgeOffsets();
			var $template = $( this ).closest( '.wikiEditor-template' );
			$template
				.toggleClass( 'wikiEditor-template-expanded' )
				.toggleClass( 'wikiEditor-template-collapsed' );
			var $templateExpand = $template.find('.wikiEditor-template-expand');
			var $templateDialog = $template.find('.wikiEditor-template-dialog');
			var $wikitext = $template.children( '.wikiEditor-template-text' );
			
			$templateExpand
				.toggleClass('wikiEditor-template-expand-collapsed')
				.toggleClass('wikiEditor-template-expand-expanded');
			$templateDialog
				.toggleClass('wikiEditor-template-dialog-collapsed')
				.toggleClass('wikiEditor-template-dialog-expanded');
			
			$wikitext.toggleClass( 'wikiEditor-nodisplay' );
			
			//if we just collapsed this
			if( $template.hasClass( 'wikiEditor-template-collapsed' ) ) {
				var model = new $.wikiEditor.modules.templateEditor.fn.model(
					$template.children( '.wikiEditor-template-text' ).text()
				);
				$template.children( '.wikiEditor-template-text' ).data( 'model', model );
				$template.children( '.wikiEditor-template-name' ).text( model.getName() );
			} else { //we just expanded this
				$wikitext.text( $template.children( '.wikiEditor-template-text' ).data( 'model' ).getText() );
			}
			
			return false;
		};
		
		var dialog = {
			'titleMsg': 'wikieditor-template-editor-dialog-title',
			'id': 'wikiEditor-template-dialog',
			'html': '\
				<fieldset>\
					<div class="wikiEditor-template-dialog-title" />\
					<div class="wikiEditor-template-dialog-fields" />\
				</fieldset>',
			init: function() {
				$(this).find( '[rel]' ).each( function() {
					$(this).text( mw.usability.getMsg( $(this).attr( 'rel' ) ) );
				} );
			},
			dialog: {
				width: 600,
				height: 400,
				dialogClass: 'wikiEditor-toolbar-dialog',
				buttons: {
					'wikieditor-template-editor-dialog-submit': function() {
						// More user feedback
						var $templateDiv = $( this ).data( 'templateDiv' );
						context.fn.highlightLine( $templateDiv );
						
						var $templateText = $templateDiv.children( '.wikiEditor-template-text' );
						var templateModel = $templateText.data( 'model' );
						$( this ).find( '.wikiEditor-template-dialog-field-wrapper input' ).each( function() {
							templateModel.setValue( $( this ).data( 'name' ), $( this ).val() );
						});
						//keep text consistent
						$templateText.text( templateModel.getText() );
						
						$( this ).dialog( 'close' );
					}
				},
				open: function() {
					var $templateDiv = $( this ).data( 'templateDiv' );
					var $templateText = $templateDiv.children( '.wikiEditor-template-text' );
					var templateModel = $templateText.data( 'model' );
					// Update the model if we need to
					if ( templateModel.getText() != $templateText.text() ) {
						templateModel = new $.wikiEditor.modules.templateEditor.fn.model( $templateText.text() );
						$templateText.data( 'model', templateModel );
					}
					
					// Build the table
					// TODO: Be smart and recycle existing table
					var params = templateModel.getAllInitialParams();
					var $fields = $( this ).find( '.wikiEditor-template-dialog-fields' ).empty();
					// Do some bookkeeping so we can recycle existing rows
					var $rows = $fields.find( '.wikiEditor-template-dialog-field-wrapper' );
					for ( var paramIndex in params ) {
						var param = params[paramIndex];
						if ( typeof param.name == 'undefined' ) {
							// param is the template name, skip it
							continue;
						}
						
						var paramText = typeof param == 'string' ?
							param.name.replace( /[\_\-]/g, ' ' ) :
							param.name;
						var paramVal = templateModel.getValue( param.name );
						if ( $rows.length > 0 ) {
							// We have another row to recycle
							var $row = $rows.eq( 0 );
							$row.children( 'label' ).text( paramText );
							$row.children( 'input' ).val( paramVal );
							$rows = $rows.not( $row );
						} else {
							// Create a new row
							var $paramRow = $( '<div />' )
								.addClass( 'wikiEditor-template-dialog-field-wrapper' );
							$( '<label />' )
								.text( paramText )
								.appendTo( $paramRow );
							$( '<input />' )
								.data( 'name', param.name )
								.val( paramVal )
								.appendTo( $paramRow );
							$fields.append( $paramRow );
						}
						// Remove any leftover rows
						$rows.remove();
					}
				}
			}
		};
		
		function createDialog( $templateDiv ) {
			// Lazy-create the dialog at this time
			context.$textarea.wikiEditor( 'addDialog', { 'templateEditor': dialog } );
			$( '#' + dialog.id )
				.data( 'templateDiv', $templateDiv )
				.dialog( 'open' );
		}
	},
	/**
	 * Turn a complex template wrapper back into a simple one
	 * @param $wrapper Wrapping <span>
	 */
	unwrapTemplate: function( $wrapper ) {
		$wrapper.parent().replaceWith( $wrapper );
	},
	
	/**
	 * Gets templateInfo node from templateInfo extension, if it exists
	 */
	getTemplateInfo: function ( templateName ) {
		var templateInfo = '';
		// TODO: API call here
		// FIXME: This setup won't work very well with the async nature of grabbing the template info
		return $( templateInfo );
	},
	
	/**
	 * Builds a template model from given wikitext representation, allowing object-oriented manipulation of the contents
	 * of the template while preserving whitespace and formatting.
	 * 
	 * @param wikitext String of wikitext content
	 */
	model: function( wikitext ) {
		
		/* Private members */
		
		var collapsible = true;
		
		/* Private Functions */
		
		/**
		 * Builds a Param object.
		 * 
		 * @param name
		 * @param value
		 * @param number
		 * @param nameIndex
		 * @param equalsIndex
		 * @param valueIndex
		 */
		function Param( name, value, number, nameIndex, equalsIndex, valueIndex ) {
			this.name = name;
			this.value = value;
			this.number = number;
			this.nameIndex = nameIndex;
			this.equalsIndex = equalsIndex;
			this.valueIndex = valueIndex;
		}
		/**
		 * Builds a Range object.
		 * 
		 * @param begin
		 * @param end
		 */
		function Range( begin, end ) {
			this.begin = begin;
			this.end = end;
		}
		/**
		 * Set 'original' to true if you want the original value irrespective of whether the model's been changed
		 * 
		 * @param name
		 * @param value
		 * @param original
		 */
		function getSetValue( name, value, original ) {
			var valueRange;
			var rangeIndex;
			var retVal;
			if ( isNaN( name ) ) {
				// It's a string!
				if ( typeof paramsByName[name] == 'undefined' ) {
					// Does not exist
					return "";
				}
				rangeIndex = paramsByName[name];
			} else {
				// It's a number!
				rangeIndex = parseInt( name );
			}
			if ( typeof params[rangeIndex]  == 'undefined' ) {
				// Does not exist
				return "";
			}
			valueRange = ranges[params[rangeIndex].valueIndex];
			if ( typeof valueRange.newVal == 'undefined' || original ) {
				// Value unchanged, return original wikitext
				retVal = wikitext.substring( valueRange.begin, valueRange.end );
			} else {
				// New value exists, return new value
				retVal = valueRange.newVal;
			}
			if ( value != null ) {
				ranges[params[rangeIndex].valueIndex].newVal = value;
			}
			return retVal;
		};
		
		/* Public Functions */
		
		/**
		 * Get template name
		 */
		this.getName = function() {
			if( typeof ranges[templateNameIndex].newVal == 'undefined' ) {
				return wikitext.substring( ranges[templateNameIndex].begin, ranges[templateNameIndex].end );
			} else {
				return ranges[templateNameIndex].newVal;
			}
		};
		/**
		 * Set template name (if we want to support this)
		 * 
		 * @param name
		 */
		this.setName = function( name ) {
			ranges[templateNameIndex].newVal = name;
		};
		/**
		 * Set value for a given param name / number
		 * 
		 * @param name
		 * @param value
		 */
		this.setValue = function( name, value ) {
			return getSetValue( name, value, false );
		};
		/**
		 * Get value for a given param name / number
		 * 
		 * @param name
		 */
		this.getValue = function( name ) {
			return getSetValue( name, null, false );
		};
		/**
		 * Get original value of a param
		 * 
		 * @param name
		 */
		this.getOriginalValue = function( name ) {
			return getSetValue( name, null, true );
		};
		/**
		 * Get a list of all param names (numbers for the anonymous ones)
		 */
		this.getAllParamNames = function() {
			return paramsByName;
		};
		/**
		 * Get the initial params
		 */
		this.getAllInitialParams = function(){
			return params;
		}
		/**
		 * Get original template text
		 */
		this.getOriginalText = function() {
			return wikitext;
		};
		/**
		 * Get modified template text
		 */
		this.getText = function() {
			newText = "";
			for ( i = 0 ; i < ranges.length; i++ ) {
				if( typeof ranges[i].newVal == 'undefined' ) {
					newText += wikitext.substring( ranges[i].begin, ranges[i].end );
				} else {
					newText += ranges[i].newVal;
				}
			}
			return newText;
		};
		
		this.isCollapsible = function() {
			return collapsible;
		}
		
		/**
		 *  Update ranges if there's been a change in one or more 'segments' of the template.
		 *  Removes adjustment function so adjustment is only made once ever.
		 */

		this.updateRanges = function() {
			var adjustment = 0;
			for (var i = 0 ; i < ranges.length; i++ ) {
				ranges[i].begin += adjustment;
				if( typeof ranges[i].adjust != 'undefined' ) {
					adjustment += ranges[i].adjust();
					// NOTE: adjust should be a function that has the information necessary to calculate the length of
					// this 'segment'
					delete ranges[i].adjust;
				}
				ranges[i].end += adjustment;
			}
		};
		
		//not collapsing "small" templates
		if ( wikitext.length < 20 ) {
			collapsible = false;
		}
		// Whitespace* {{ whitespace* nonwhitespace:
		if ( wikitext.match( /\s*{{\s*\S*:/ ) ) {
			collapsible = false; // is a parser function
		}
		/*
		 * Take all template-specific characters that are not particular to the template we're looking at, namely {|=},
		 * and convert them into something harmless, in this case 'X'
		 */
		// Get rid of first {{ with whitespace
		var sanatizedStr = wikitext.replace( /{{/, "  " );
		// Replace end
		endBraces = sanatizedStr.match( /}}\s*$/ );
		if ( endBraces ) {
			sanatizedStr = sanatizedStr.substring( 0, endBraces.index ) + "  " +
				sanatizedStr.substring( endBraces.index + 2 );
		}
		
		//treat HTML comments like whitespace
		while ( sanatizedStr.indexOf( '<!' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '<!' );
			endIndex = sanatizedStr.indexOf('-->') + 3;
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /\S/g , ' ' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		
		// Match the open braces we just found with equivalent closing braces note, works for any level of braces
		while ( sanatizedStr.indexOf( '{{' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '{{' ) + 1;
			openBraces = 2;
			endIndex = startIndex;
			while ( (openBraces > 0)  && (endIndex < sanatizedStr.length) ) {
				var brace = sanatizedStr[++endIndex];
				openBraces += brace == '}' ? -1 : brace == '{' ? 1 : 0;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /[{}|=]/g , 'X' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		//links, images, etc, which also can nest
		while ( sanatizedStr.indexOf( '[[' ) != -1 ) {
			startIndex = sanatizedStr.indexOf( '[[' ) + 1;
			openBraces = 2;
			endIndex = startIndex;
			while ( (openBraces > 0)  && (endIndex < sanatizedStr.length) ) {
				var brace = sanatizedStr[++endIndex];
				openBraces += brace == ']' ? -1 : brace == '[' ? 1 : 0;
			}
			sanatizedSegment = sanatizedStr.substring( startIndex,endIndex ).replace( /[\[\]|=]/g , 'X' );
			sanatizedStr =
				sanatizedStr.substring( 0, startIndex ) + sanatizedSegment + sanatizedStr.substring( endIndex );
		}
		
		/*
		 * Parse 1 param at a time
		 */
		var ranges = [];
		var params = [];
		var templateNameIndex = 0;
		var doneParsing = false;
		oldDivider = 0;
		divider = sanatizedStr.indexOf( '|', oldDivider );
		if ( divider == -1 ) {
			divider = sanatizedStr.length;
			doneParsing = true;
			collapsible = false; //zero params
		}
		nameMatch = sanatizedStr.substring( 0, divider ).match( /[^\s]/ );
		if ( nameMatch != null ) {
			ranges.push( new Range( 0 ,nameMatch.index ) ); //whitespace and squiggles upto the name
			nameEndMatch = sanatizedStr.substring( 0 , divider ).match( /[^\s]\s*$/ ); //last nonwhitespace character
			templateNameIndex = ranges.push( new Range( nameMatch.index,
				nameEndMatch.index + 1 ) );
			templateNameIndex--; //push returns 1 less than the array
			ranges[templateNameIndex].old = wikitext.substring( ranges[templateNameIndex].begin,
				ranges[templateNameIndex].end );
		} else {
			ranges.push(new Range(0,0));
			ranges[templateNameIndex].old = "";
		}
		params.push( ranges[templateNameIndex].old ); //put something in params (0)
		/*
		 * Start looping over params
		 */
		var currentParamNumber = 0;
		var valueEndIndex = ranges[templateNameIndex].end;
		var paramsByName = [];
		while ( !doneParsing ) {
			currentParamNumber++;
			oldDivider = divider;
			divider = sanatizedStr.indexOf( '|', oldDivider + 1 );
			if ( divider == -1 ) {
				divider = sanatizedStr.length;
				doneParsing = true;
			}
			currentField = sanatizedStr.substring( oldDivider+1, divider );
			if ( currentField.indexOf( '=' ) == -1 ) {
				// anonymous field, gets a number
				valueBegin = currentField.match( /\S+/ ); //first nonwhitespace character
				if( valueBegin == null ){ //ie
					continue;
				}
				valueBeginIndex = valueBegin.index + oldDivider+1;
				valueEnd = currentField.match( /[^\s]\s*$/ ); //last nonwhitespace character
				if( valueEnd == null ){ //ie
					continue;
				}
				valueEndIndex = valueEnd.index + oldDivider + 2;
				ranges.push( new Range( ranges[ranges.length-1].end,
					valueBeginIndex ) ); //all the chars upto now
				nameIndex = ranges.push( new Range( valueBeginIndex, valueBeginIndex ) ) - 1;
				equalsIndex = ranges.push( new Range( valueBeginIndex, valueBeginIndex ) ) - 1;
				valueIndex = ranges.push( new Range( valueBeginIndex, valueEndIndex ) ) - 1;
				params.push( new Param(
					currentParamNumber,
					wikitext.substring( ranges[valueIndex].begin, ranges[valueIndex].end ),
					currentParamNumber,
					nameIndex,
					equalsIndex,
					valueIndex
				) );
				paramsByName[currentParamNumber] = currentParamNumber;
			} else {
				// There's an equals, could be comment or a value pair
				currentName = currentField.substring( 0, currentField.indexOf( '=' ) );
				// Still offset by oldDivider - first nonwhitespace character
				nameBegin = currentName.match( /\S+/ );
				if ( nameBegin == null ) {
					// This is a comment inside a template call / parser abuse. let's not encourage it
					currentParamNumber--;
					continue;
				}
				nameBeginIndex = nameBegin.index + oldDivider + 1;
				// Last nonwhitespace and non } character
				nameEnd = currentName.match( /[^\s]\s*$/ );
				if( nameEnd == null ){ //ie
					continue;
				}
				nameEndIndex = nameEnd.index + oldDivider + 2;
				// All the chars upto now 
				ranges.push( new Range( ranges[ranges.length-1].end, nameBeginIndex ) );
				nameIndex = ranges.push( new Range( nameBeginIndex, nameEndIndex ) ) - 1;
				currentValue = currentField.substring( currentField.indexOf( '=' ) + 1);
				oldDivider += currentField.indexOf( '=' ) + 1;
				// First nonwhitespace character
				valueBegin = currentValue.match( /\S+/ );
				if( valueBegin == null ){ //ie
					continue;
				}
				valueBeginIndex = valueBegin.index + oldDivider + 1;
				// Last nonwhitespace and non } character
				valueEnd = currentValue.match( /[^\s]\s*$/ );
				if( valueEnd == null ){ //ie
					continue;
				}
				valueEndIndex = valueEnd.index + oldDivider + 2;
				// All the chars upto now
				equalsIndex = ranges.push( new Range( ranges[ranges.length-1].end, valueBeginIndex) ) - 1;
				valueIndex = ranges.push( new Range( valueBeginIndex, valueEndIndex ) ) - 1;
				params.push( new Param(
					wikitext.substring( nameBeginIndex, nameEndIndex ),
					wikitext.substring( valueBeginIndex, valueEndIndex ),
					currentParamNumber,
					nameIndex,
					equalsIndex,
					valueIndex
				) );
				paramsByName[wikitext.substring( nameBeginIndex, nameEndIndex )] = currentParamNumber;
			}
		}
		// The rest of the string
		ranges.push( new Range( valueEndIndex, wikitext.length ) );
		
		// Save vars
		this.ranges = ranges;
		this.wikitext = wikitext;
		this.params = params;
		this.paramsByName = paramsByName;
		this.templateNameIndex = templateNameIndex;
	} //model
} 
}; } )( jQuery );
