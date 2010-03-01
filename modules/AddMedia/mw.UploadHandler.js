/**
 * The base upload interface. 
 * 
 * Progress bars for http-copy-by-url uploading.
 * Ifame upload target 
 *
 * This base upload class is optionally extended by Firefogg
 *
 */
mw.addMessages({		
	"mwe-upload-transcoded-status" : "Transcoded",
	"mwe-upload-stats-fileprogress" : "$1 of $2",
	"mwe-upload_completed" : "Your upload is complete",
	"mwe-upload_done" : "<a href=\"$1\">Your upload <i>should be<\/i> accessible<\/a>.",
	"mwe-upload-unknown-size" : "Unknown size",
	"mwe-cancel-confim" : "Are you sure you want to cancel?",
	"mwe-successfulupload" : "Upload successful",
	"mwe-uploaderror" : "Upload error",
	"mwe-uploadwarning" : "Upload warning",
	"mwe-unknown-error" : "Unknown error:",
	"mwe-return-to-form" : "Return to form",
	"mwe-file-exists-duplicate" : "This file is a duplicate of the following file:",
	"mwe-fileexists" : "A file with this name exists already. Please check <b><tt>$1<\/tt><\/b> if you are not sure if you want to change it.",
	"mwe-fileexists-thumb" : "<center><b>Existing file<\/b><\/center>",
	"mwe-ignorewarning" : "Ignore warning and save file anyway",
	"mwe-file-thumbnail-no" : "The filename begins with <b><tt>$1<\/tt><\/b>",
	"mwe-go-to-resource" : "Go to resource page",
	"mwe-upload-misc-error" : "Unknown upload error",	
	"mwe-wgfogg_warning_bad_extension" : "You have selected a file with an unsuported extension (<a href=\"http:\/\/commons.wikimedia.org\/wiki\/Commons:Firefogg#Supported_File_Types\">more information<\/a>).",
	"thumbnail-more" : "Enlarge",
	
	"license-header" : "Licensing",
	"filedesc" : "Summary",
	"filesource" : "Source:",
	"filestatus" : "Copyright status:"
});

var default_bui_options = {
	// Target api to upload to
	'api_url' : null,
	
	// The selected form
	'form' : null,
	
	// Callback for once the upload is done
	'done_upload_cb' : null,
	
	// A selector for the form target
	'form_selector' : null,

	// Default upload mode is 'api'
	'upload_mode' : 'api',
	
	// Callback for modifying form data on submit  
	'onsubmit_cb' : null,
	
	// Equivalent to $wgUseCopyrightUpload in php ( should be set via configuration )
	'useCopyrightUpload' : true,
	
	// Callback which is called when the source name changes
	'selectFileCb': false

};

/**
* Setup upload jQuery binding
*/
( function( $ ) { 
	$.fn.uploadHandler = function( options ) {
		if ( !options ) {
			options = { };
		}
	
		// Add the selector
		options[ 'form_selector' ] = this.selector;			
		
		// Setup the firefogg Firefogg: 
		var myUpload = new mw.UploadHandler( options );
				
		if ( myUpload ) {
			myUpload.setupForm( );
		}
		
		// Update the selecto to include pointer to upload handler 		
		var selectorElement = $j( this.selector ).get( 0 );
		selectorElement[ 'uploadHandler' ] = myUpload;
	}
} )( jQuery );

mw.UploadHandler = function( options ) {
	return this.init( options );
}

mw.UploadHandler.prototype = {
	
	// The form data to be submitted
	formData: {}, 
	
	// Upload warning session key, for continued uploads 
	warnings_sessionkey: false,
	
	// If chunks uploading is supported
	chunks_supported: true,
	
	// If the existing form should be used to post to the api
	// Since file selection can't be "moved" we have to use the existing
	// form and just submit it to a different target  
	form_post_override: false,
	
	// http copy by url mode flag
	http_copy_upload : null,
	
	// If the upload action is done
	action_done: false,
	
	// Edit token for upload
	editToken: false,

	// The DOM node for the upload form
	form: false,
	
	/**
	 * Object initialization
	 * @param {Object} options BaseUpload options see default_bui_options
	 */
	init: function( options ) {
		if ( !options )
			options = {};
		$j.extend( this, default_bui_options, options );
		
		// Set a api_url if unset
		if( !this.api_url ) {
			this.api_url = mw.getLocalApiUrl();
		}		
		
		// We can't pass around actual function refrences since sometimes the interface
		// is seperated via iframe #hash messege communication.		
		if( options.ui  ){
			this.ui = options.ui;
		} else { 					
			// Setup the default DialogInterface UI
			this.ui = new mw.DialogInterface();
		}		
		
		// Setup ui uploadHandler pointer
		this.ui.uploadHandler = this;
		
		mw.log( "init mvUploadHandler:: " + this.api_url + ' interface: ' + this.ui );
	},
	
	/**
	 * Set up the upload form, register onsubmit handler.
	 * May remap it to use the API field names.
	 */
	setupForm: function() {
		mw.log( "Base::setupForm::" );
		var _this = this;
		
		// Set up the local pointer to the edit form:
		this.form = this.getForm();		
		
		if ( !this.form ) {
			mw.log( "Upload form not found!" );
			return;
		}		

		// Set up the orig_onsubmit if not set:
		if ( typeof( this.orig_onsubmit ) == 'undefined' && this.form.onsubmit ) {
			this.orig_onsubmit = this.form.onsubmit;
		}
		
		// Set up the submit action:
		$j( this.form ).submit( function() {	
			mw.log( "FORM SUBMIT::" );
			/*var data = $j( this ).serializeArray();
			for ( var i = 0; i < data.length; i++ ) {
				mw.log( $j( data[i] ).attr('name') + ' : ' + $j(data[i]).val() );
			}*/
			return _this.onSubmit();
		} );
	},

	/**
	 * onSubmit handler for the upload form
	 */
	onSubmit: function() {
		var _this = this;
		mw.log( 'Base::onSubmit:' );
		
		// Run the original onsubmit (if not run yet set flag to avoid excessive chaining)
		if ( typeof( this.orig_onsubmit ) == 'function' ) {
			if ( ! this.orig_onsubmit() ) {
				//error in orig submit return false;
				return false;
			}
		}		
		
		// Call the onsubmit_cb option if set:
		if( this.onsubmit_cb && typeof this.onsubmit_cb == 'function' ) {
			this.onsubmit_cb();
		}				
		
		// Remap the upload form to the "api" form:
		this.remapFormToApi();
		
		// Check for post action override	
		if ( this.form_post_override ) {
			mw.log( 'form_post_override is true, do ordinary form submit' );
			return true;
		}		
		mw.log(" about to run try / catch " );
		// Put into a try catch so we are sure to return false:		
		try {
			// Startup interface dispatch dialog
			_this.ui.setup( { 'title' : gM( 'mwe-upload-in-progress' ) } );
						
			mw.log('ui.setup done ' );
			
			// Drop down the #p-search z-index so its not ontop
			$j( '#p-search' ).css( 'z-index', 1 );

			var _this = this;
			
			_this.detectUploadMode( function( mode ) {
				mw.log("detectUploadMode callback" );
				_this.upload_mode = mode;
				_this.doUpload();
			} );
		} catch( e ) {
			mw.log( '::error in this.ui or doUpload ' + e );
		}

		// Don't submit the form we will do the post in ajax
		return false;
	},

	/**
	 * Determine the correct upload mode.
	 *
	 * If this.upload_mode is autodetect, this runs an API call to find out if MW
	 * supports uploading. It then sets the upload mode when this call returns.
	 *
	 * When done detecting, or if detecting is unnecessary, it calls the callback 
	 * with the upload mode as the first parameter.
	 *
	 * @param {Function} callback Function called once upload mode is detected
	 */
	detectUploadMode: function( callback ) {
		var _this = this;
		mw.log( 'detectUploadMode::' +  _this.upload_mode );
		//debugger;
		// Check the upload mode
		if ( _this.upload_mode == 'detect_in_progress' ) {
			// Don't send another request, wait for the pending one.
		} else if ( !_this.isCopyUpload() ) {
			callback( 'post' );
		} else if ( _this.upload_mode == 'autodetect' ) {
			mw.log( 'detectUploadMode::' + _this.upload_mode + ' api:' + _this.api_url );
			if( !_this.api_url ) {
				mw.log( 'Error: can\'t autodetect mode without api url' );
				return;
			}

			// Don't send multiple requests
			_this.upload_mode = 'detect_in_progress';

			// FIXME: move this to configuration and avoid this API request
			mw.getJSON( _this.api_url, { 'action' : 'paraminfo', 'modules' : 'upload' }, function( data ) {
				if ( typeof data.paraminfo == 'undefined'
					|| typeof data.paraminfo.modules == 'undefined' )
				{
					return mw.log( 'Error: bad api results' );
				}
				if ( typeof data.paraminfo.modules[0].classname == 'undefined' ) {
					mw.log( 'Autodetect Upload Mode: \'post\' ' );
					_this.upload_mode = 'post';
					callback( 'post' );
				} else {
					mw.log( 'Autodetect Upload Mode: api ' );
					_this.upload_mode = 'api';
					// Check to see if chunks are supported
					for ( var i in data.paraminfo.modules[0].parameters ) {
						var pname = data.paraminfo.modules[0].parameters[i].name;
						if( pname == 'enablechunks' ) {
							mw.log( 'this.chunks_supported = true' );
							_this.chunks_supported = true;
							break;
						}
					}
					callback( 'api' );
				}
			} );
		} else if ( _this.upload_mode == 'api' ) {
			callback( 'api' );
		} else if ( _this.upload_mode == 'post' ) {
			callback( 'post' );
		} else {
			mw.log( 'Error: unrecongized upload mode: ' + _this.upload_mode );
		}
	},

	/**
	 * Do an upload, with the mode given by this.upload_mode	 
	 */
	doUpload: function() {		
		// Note "api" should be called "http_copy_upload" and /post/ should be "form_upload" 		
		if ( this.upload_mode == 'api' ) {
			this.doApiCopyUpload();
		} else if ( this.upload_mode == 'post' ) {
			this.doPostUpload();
		} else {
			mw.log( 'Error: unrecongized upload mode: ' + this.upload_mode );
		}
	},

	/**
	 * Change the upload form so that when submitted, it sends a request to
	 * the MW API.
	 *
	 * This is rather ugly, but solutions are constrained by the fact that 
	 * file inputs can't be moved around or recreated after the user has 
	 * selected a file in them, which they may well do before DOM ready.
	 *
	 * It is also constrained by upload form hacks on commons.
	 */
	remapFormToApi: function() {
		var _this = this;
		//
		mw.log("remapFormToApi:: " + this.api_url + ' form: ' + this.form);
		
		if ( !this.api_url ) {
			mw.log( 'Error: no api url target' ); 
			return false;
		}
		var $form = $j( this.form_selector );		

		// Set the form action
		try {
			$form.attr('action', _this.api_url);
		} catch( e ) {
			mw.log( "IE sometimes errors out when you change the action" );
		}

		// Add API action
		if ( $form.find( "[name='action']" ).length == 0 ) {
			$form.append( 
				$j('<input />')
				.attr({ 
					'type': "hidden",
					'name' : "action", 
					'value' : "upload"
				})
			)
		}

		// Add JSON response format
		if ( $form.find( "[name='format']" ).length == 0 ) {
			$form.append( 
				$j( '<input />' )
				.attr({
					'type' : "hidden",
					'name' : "format",
					'value' : "jsonfm"
				})
			) 
		}

		// Map a new hidden form
		$form.find( "[name='wpUploadFile']" ).attr( 'name', 'file' );
		$form.find( "[name='wpDestFile']" ).attr( 'name', 'filename' );
		$form.find( "[name='wpUploadDescription']" ).attr( 'name', 'comment' );
		$form.find( "[name='wpEditToken']" ).attr( 'name', 'token' );
		$form.find( "[name='wpIgnoreWarning']" ).attr( 'name', 'ignorewarnings' );
		$form.find( "[name='wpWatchthis']" ).attr( 'name', 'watch' );
		
		//mw.log( 'comment: ' + $form.find( "[name='comment']" ).val() );
	},	

	/**
	 * Returns true if the current form has copy upload selected, false otherwise.
	 */
	isCopyUpload: function() {	
		if ( $j( '#wpSourceTypeFile' ).length ==  0
			|| $j( '#wpSourceTypeFile' ).get( 0 ).checked )
		{
			this.http_copy_upload = false;
		} else if ( $j('#wpSourceTypeURL').get( 0 ).checked ) {
			this.http_copy_upload = true;
		}
		return this.http_copy_upload;
	},

	/**
	 * Do an upload by submitting the form
	 */
	doPostUpload: function() {
		var _this = this;
		var $form = $j( _this.form );
		mw.log( 'mvBaseUploadHandler.doPostUpload' );
		
		// Issue a normal post request
		// Get the token from the page
		_this.editToken = $j( "#wpEditToken" ).val();

		// TODO check for sendAsBinary to support Firefox/HTML5 progress on upload		
		this.ui.setLoading();

		// Add the iframe
		_this.iframeId = 'f_' + ( $j( 'iframe' ).length + 1 );
		//IE only works if you "create element with the name" ( not jquery style buildout )
		var iframe;
		try {
		  iframe = document.createElement( '<iframe name="' + _this.iframeId + '">' );
		} catch (ex) {
		  iframe = document.createElement('iframe');
		}		
		
		$j( "body" ).append( 
			$j( iframe )
			.attr({
				'src':'javascript:false;',
				'id':_this.iframeId,
				'name':  _this.iframeId
			}) 
			.css('display', 'none')
		);


		// Set the form target to the iframe
		$form.attr( 'target', _this.iframeId );		

		// Set up the completion callback
		$j( '#' + _this.iframeId ).load( function() {
			_this.processIframeResult( $j( this ).get( 0 ) );
		});			
		
		// Do post override
		_this.form_post_override = true;
						
		$form.submit();
	},

	/**
	 * Do an upload by submitting an API request
	 */
	doApiCopyUpload: function() {
		mw.log( 'mvBaseUploadHandler.doApiCopyUpload' );
		mw.log( 'doHttpUpload (no form submit) ' );
		
		var httpUpConf = {
			'url'       : $j( '#wpUploadFileURL' ).val(),
			'filename'  : $j( '#wpDestFile' ).val(),
			'comment'   : this.getUploadDescription(),
			'watch'     : ( $j( '#wpWatchthis' ).is( ':checked' ) ) ? 'true' : 'false',
			'ignorewarnings': ($j('#wpIgnoreWarning' ).is( ':checked' ) ) ? 'true' : 'false'
		}
		//check for editToken
		this.editToken = $j( "#wpEditToken" ).val();
		this.doHttpUpload( httpUpConf );
	},
	
	/**
	* Get the upload description, append the license if available
	*
	* NOTE: wpUploadDescription should be a configuration option. 
	*
	* @return {String} 
	* 	value of wpUploadDescription 
	*/
	getUploadDescription: function() {
		//Special case of upload.js commons hack: 
		var comment_value = $j( '#wpUploadDescription' ).val();
		if(  comment_value == '' ) {
			comment_value = $j( "[name='wpUploadDescription']").val();
		}
		mw.log( 'getUploadDescription:: base:' + comment_value + ' ucr:' + this.useCopyrightUpload );
		// Set license, copyStatus, source if available ( generally not available SpecialUpload needs some refactoring ) 
		if ( this.useCopyrightUpload ) {
			var license = ( $j("[name='wpLicense']").length ) ? $j("[name='wpLicense']").val() : '';
			var copyStatus = ( $j("[name='wpUploadCopyStatus']" ).length ) ? $j("[name='wpUploadCopyStatus']" ).val() : '';
			var source =  ( $j("[name='wpSource']").length ) ? $j("[name='wpSource']").val() : '';
			
			// Run the JS equivalent of SpecialUpload.php getInitialPageText	
			comment_value = this.getCommentText( comment_value, license, copyStatus, source  );
		}
		mw.log( 'getCommentText:: new val:' + comment_value  );
		return comment_value;
	},
	
	/**
	* Get the comment text ( port of getInitialPageText from SpecialUpload.php
	* We only copy part of the check where useCopyrightUpload is enabled as
	* to not conflict with other js rewrites. 
	*   
	* @param {String} comment Comment string
	* @param {String} license License key 
	* @param {String} copyStatus the copyright status field
	* @param {String} source The source filed			
	*/
	getCommentText: function( comment, license, copyStatus, source ) {					
		var licensetxt = '';
		if ( license != '' ) {
			licensetxt = '== ' + gM( 'license-header' ) + " ==\n" + '{{' + license + '}}' + "\n";
		}
		pageText = '== ' + gM( 'filedesc' ) + " ==\n" + comment + "\n";
		if( copyStatus ){
			pageText +=  '== ' + gM( 'filestatus' ) + " ==\n" + copyStatus + "\n" +
						licensetxt;
		}
		if( source ){
			pageText += '== ' + gM( 'filesource' ) + " ==\n" . source ;
		}
		return pageText;
	},

	/**
	 * Process the result of the form submission, returned to an iframe.
	 * This is the iframe's onload event.
	 *
	 * @param {Element} iframe iframe to extract result from 
	 */
	processIframeResult: function( iframe ) {
		var _this = this;
		var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;
		// Fix for Opera 9.26
		if ( doc.readyState && doc.readyState != 'complete' ) {
			return;
		}
		// Fix for Opera 9.64
		if ( doc.body && doc.body.innerHTML == "false" ) {
			return;
		}
		var response;
		if ( doc.XMLDocument ) {
			// The response is a document property in IE
			response = doc.XMLDocument;
		} else if ( doc.body ) {
			// Get the json string
			json = $j( doc.body ).find( 'pre' ).text();
			//mw.log( 'iframe:json::' + json_str + "\nbody:" + $j( doc.body ).html() );
			if ( json ) {
				response = window["eval"]( "(" + json + ")" );
			} else {
				response = {};
			}
		} else {
			// Response is a xml document
			response = doc;
		}
		// Process the API result
		_this.processApiResult( response );
	},

	/**
	 * Do a generic action=upload API request and monitor its progress
	 */
	doHttpUpload: function( params ) {
		var _this = this;
		// Get a clean setup of the interface dispatch 
		this.ui.setup( {'title': gM('mwe-upload-in-progress') } );					

		// Set the interface dispatch to loading ( in case we don't get an update for some time )
		this.ui.setLoading();		

		// Set up the request
		var request = {
			'action'        : 'upload',
			'asyncdownload' : true // Do async download
		};

		// Add any parameters specified by the caller
		for ( key in params ) {
			if ( !request[key] ) {
				request[key] = params[key];
			}
		}

		// Add the edit token (if available)
		if( !_this.editToken && _this.api_url ) {
			mw.log( 'Error:doHttpUpload: missing token' );
		} else {
			request['token'] =_this.editToken;
		}

		// Reset the done with action flag
		_this.action_done = false;
		
		// Do the api request:
		mw.getJSON(_this.api_url, request, function( data ) {
			_this.processApiResult( data );
		});
	},

	/**
	 * Start periodic checks of the upload status using XHR
	 */
	doAjaxUploadStatus: function() {
		var _this = this;

		// Set up interface dispatch to display for status updates:
		this.ui.setup( {'title': gM('mwe-upload-in-progress') } );					
		
		this.upload_status_request = {
			'action'     : 'upload',
			'httpstatus' : 'true',
			'sessionkey' : _this.upload_session_key
		};
		
		// Add token if present
		if ( this.editToken )
			this.upload_status_request['token'] = this.editToken;

		// Trigger an initial request (subsequent ones will be done by a timer)
		this.onAjaxUploadStatusTimer();
	},

	/**
	 * This is called when the timer which separates XHR requests elapses.
	 * It starts a new request.
	 */
	onAjaxUploadStatusTimer: function() {
		var _this = this;
		//do the api request:
		mw.getJSON( this.api_url, this.upload_status_request, function ( data ) {
			_this.onAjaxUploadStatusResponse( data );
		} );
	},

	/**
	 * Called when a response to an upload status query is available.
	 * Starts the timer for the next upload status check.
	 */
	onAjaxUploadStatusResponse: function( data ) {
		var _this = this;
		// Check if we are done
		if ( data.upload['apiUploadResult'] ) {
			//update status to 100%
			_this.ui.updateProgress( 1 );
			//see if we need JSON
			mw.load( [
				'JSON'
			], function() {
				var apiResult = {};
				try {
					apiResult = JSON.parse( data.upload['apiUploadResult'] ) ;
				} catch ( e ) {
					//could not parse api result
					mw.log( 'errro: could not parse apiUploadResult:' + e );
				}
				_this.processApiResult( apiResult );
			});
			return ;
		}

		// Update status:
		if ( data.upload['content_length'] && data.upload['loaded'] ) {
			// We have content length we can show percentage done:
			var fraction = data.upload['loaded'] / data.upload['content_length'];
			// Update the status:
			_this.ui.updateProgress( fraction,  data.upload['loaded'],  data.upload['content_length'] );				
		} else if ( data.upload['loaded'] ) {
			_this.ui.updateProgress( 1, data.upload['loaded'] );
			mw.log( 'just have loaded ( no content length: ' + data.upload['loaded'] );			
		}
		
		// We got a result: set timeout to 100ms + your server update
		// interval (in our case 2s)
		var timeout = 2100;
		setTimeout( function() {
			_this.onAjaxUploadStatusTimer();
		}, timeout );
	},

	/**
	 * Returns true if an action=upload API result was successful, false otherwise
	 */
	isApiSuccess: function( apiRes ) {
		if ( apiRes.error || ( apiRes.upload && apiRes.upload.result == "Failure" ) ) {
			return false;
		}
		if ( apiRes.upload && apiRes.upload.error ) {
			return false;
		}
		if ( apiRes.upload && apiRes.upload.warnings ) {
			return false;
		}
		return true;
	},
	

	/**
	 * Process the result of an action=upload API request. Display the result
	 * to the user.
	 * 
	 * @param {Object} apiRes Api result object
	 * @return {Boolean}
	 * 	false if api error
	 *  true if success & interface has been updated
	 */
	processApiResult: function( apiRes ) {
		var _this = this;
		mw.log( 'processApiResult::' + JSON.stringify( apiRes )	);
				
		if ( !_this.isApiSuccess( apiRes ) ) {
		
			// Set the local warnings_sessionkey for warnings			
			if ( apiRes.upload && apiRes.upload.sessionkey ) {
				_this.warnings_sessionkey = apiRes.upload.sessionkey;				
			}
			
			// Error detected, show it to the user
			_this.ui.showApiError( apiRes );
			
			return false;
		}
		
		// See if we have a session key without warning
		if ( apiRes.upload && apiRes.upload.upload_session_key ) {
			// Async upload, do AJAX status polling
			_this.upload_session_key = apiRes.upload.upload_session_key;
			_this.doAjaxUploadStatus();
			mw.log( "set upload_session_key: " + _this.upload_session_key );
			return true;
		}

		if ( apiRes.upload && apiRes.upload.imageinfo && apiRes.upload.imageinfo.descriptionurl ) {							
			// Call the completion callback if available.
			if ( _this.done_upload_cb && typeof _this.done_upload_cb == 'function' ) {
				mw.log( "call done_upload_cb" );
				
				// This overrides our normal completion handling so we close the
				// dialog immediately.
				_this.ui.close();
				_this.done_upload_cb( apiRes.upload );
				return true;
			}
			
			// Else pass off the api Success to interface:
			_this.ui.showApiSuccess( apiRes );	
			return true;
		}
	},
	
	/**
	* Receives upload interface "action" requests from the "ui" 
	* 
	* For example ignorewarning 
	*/
	uploadHandlerAction : function( action ){
		mw.log( "UploadHandler :: action:: " + action  + ' sw: ' + this.warnings_sessionkey );
		switch( action ){
			case 'ignoreWarnings':
				this.ignoreWarningsSubmit();
			break;
			case 'disableFormPostOverride':
				this.form_post_override = false;
			break;
			default: 
				mw.log( "Error reciveUploadAction:: unkown action: " + action );
			break;
		}
	},
	
	/**
	* Do ignore warnings submit.
	* 
	* Must have set warnings_sessionkey
	*/
	ignoreWarningsSubmit: function( ) {
		var _this = this;
		// Check if we have a stashed key:
		if ( _this.warnings_sessionkey !== false ) {
			//set to "loading"
			$j( '#upProgressDialog' ).html( mw.loading_spinner() );
			//setup request:
			var request = {
				'action': 'upload',
				'sessionkey': _this.warnings_sessionkey,
				'ignorewarnings': 1,
				'filename': $j( '#wpDestFile' ).val(),
				'token' :  _this.editToken,
				'comment' : _this.getUploadDescription()
			};
			//run the upload from stash request
			mw.getJSON(_this.api_url, request, function( data ) {
					_this.processApiResult( data );
			} );
		} else {
			mw.log( 'No session key re-sending upload' )
			//do a stashed upload
			$j( '#wpIgnoreWarning' ).attr( 'checked', true );
			$j( _this.editForm ).submit();
		}
	},
	
	/**
	 * Get the default title of the progress window
	 */
	getProgressTitle: function() {
		return gM( 'mwe-upload-in-progress' );
	},

	/**
	 * Get the DOMNode of the form element we are rewriting.
	 * Returns false if it can't be found.
	 */
	getForm: function() {
	
		if ( this.form_selector && $j( this.form_selector ).length != 0 ) {
			return $j( this.form_selector ).get( 0 );
		} else {
			mw.log( "mvBaseUploadHandler.getForm(): no form_selector" );
			return false;
		}
	}	

};

// jQuery plugins

( function( $ ) {

	/**
	 * Check the upload destination filename for conflicts and show a conflict
	 * error message if there is one
	 * @selector (jquery selector) The target destination name to check for conflits  
	 * @param {Object} options Options that define: 
	 * 		warn_target target for display of warning
	 * 		api_url Api url to check for destination
	 */
	$.fn.doDestCheck = function( options ) {
		var _this = this;
		mw.log( 'doDestCheck::' + _this.selector );

		// Set up option defaults
		if ( !options.warn_target ) {
			options.warn_target = '#wpDestFile-warning';
		}
		
		if( ! options.api_url ) {
			options.api_url = mw.getLocalApiUrl();
		}		

		// Add the wpDestFile-warning row ( if in mediaWiki upload page )
		if ( $j( options.warn_target  ).length == 0 ) {
			$j( '#mw-htmlform-options tr:last' )
				.after( 
				$j('<tr />' )
				.append( '<td />' )
				.append( '<td />' )
					.attr('id', 'wpDestFile-warning')
				);
		}
		mw.log( 'past dest');
		// Remove any existing warning
		$j( options.warn_target ).empty();

		// Show the AJAX spinner
		$j( _this.selector ).after( 
			$j('<div />')			
			.attr({
				'id' : "mw-spinner-wpDestFile",				
			})
			.loadingSpinner()
		);		
		// Setup the request
		var request =  {
			'titles': 'File:' + $j( _this.selector ).val(),
			'prop':  'imageinfo',
			'iiprop': 'url|mime|size',
			'iiurlwidth': 150
		};		
				
		// Do the destination check ( on the local wiki )
		mw.getJSON( options.api_url, request, function( data ) {
				// Remove spinner
				$j( '#mw-spinner-wpDestFile' ).remove();
				
				if ( !data || !data.query || !data.query.pages ) {
					// Ignore a null result
					return;
				}

				if ( data.query.pages[-1] ) {
					// No conflict found
					return;
				}
				for ( var page_id in data.query.pages ) {
					if ( !data.query.pages[ page_id ].imageinfo ) {
						continue;
					}

					// Conflict found, show warning
					if ( data.query.normalized ) {
						var ntitle = data.query.normalized[0].to;
					} else {
						var ntitle = data.query.pages[ page_id ].title
					}
					var img = data.query.pages[ page_id ].imageinfo[0];
					$j( options.warn_target  ).html(
						gM( 'mwe-fileexists', ntitle ) +
						'<div class="thumb tright">' +
						'<div ' +
							'style="width: ' + ( parseInt( img.thumbwidth ) + 2 ) + 'px;" ' +
							'class="thumbinner">' +
						'<a ' +
							'title="' + ntitle + '" ' +
							'class="image" ' +
							'href="' + img.descriptionurl + '">' +
						'<img ' +
							'width="' + img.thumbwidth + '" ' +
							'height="' + img.thumbheight + '" ' +
							'border="0" ' +
							'class="thumbimage" ' +
							'src="' + img.thumburl + '" ' +
							'alt="' + ntitle + '"/>' +
						'</a>' +
						'<div class="thumbcaption">' +
						'<div class="magnify">' +
						'<a title="' + gM('thumbnail-more') + '" class="internal" ' +
							'href="' + img.descriptionurl +'">' +
						'<img border="0" width="15" height="11" alt="" ' +
							'src="' + mw.getConfig( 'images_path' ) + 'magnify-clip.png" />' +
						'</a>' +
						'</div>' +
						gM( 'mwe-fileexists-thumb' ) +
						'</div>' +
						'</div>' +
						'</div>'
					);
				}
			}
		);
	}
})( jQuery );
