<?php
/**
 * Hooks for WikiEditor extension
 * 
 * @file
 * @ingroup Extensions
 */

class WikiEditorHooks {
	
	/* Protected Static Members */
	
	protected static $modules = array(
		
		/* Third-party modules */
		
		'contentCollector' => array(
			'scripts' => 'contentCollector.js',
			'group' => 'ext.wikiEditor',
		),
		
		/* WikiEditor jQuery plugin Resources */
		
		'jquery.wikiEditor' => array(
			'scripts' => 'jquery.wikiEditor.js',
			'styles' => 'jquery.wikiEditor.css',
			'dependencies' => array(
				'jquery.client',
				'jquery.textSelection',
				'jquery.delayedBind',
			),
			'messages' => array(
				'wikieditor-wikitext-tab',
				'wikieditor-loading',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.iframe' => array(
			'scripts' => 'jquery.wikiEditor.iframe.js',
			'dependencies' => array(
				'jquery.wikiEditor',
				'contentCollector',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.dialogs' => array(
			'scripts' => 'jquery.wikiEditor.dialogs.js',
			'styles' => 'jquery.wikiEditor.dialogs.css',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.toolbar',
				'jquery.ui.dialog',
				'jquery.ui.button',
				'jquery.ui.draggable',
				'jquery.ui.resizable',
				'jquery.tabIndex',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.highlight' => array(
			'scripts' => 'jquery.wikiEditor.highlight.js',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.iframe',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.preview' => array(
			'scripts' => 'jquery.wikiEditor.preview.js',
			'styles' => 'jquery.wikiEditor.preview.css',
			'dependencies' => 'jquery.wikiEditor',
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.previewDialog' => array(
			'scripts' => 'jquery.wikiEditor.previewDialog.js',
			'styles' => 'jquery.wikiEditor.previewDialog.css',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.dialogs',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.publish' => array(
			'scripts' => 'jquery.wikiEditor.publish.js',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.dialogs',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.templateEditor' => array(
			'scripts' => 'jquery.wikiEditor.templateEditor.js',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.iframe',
				'jquery.wikiEditor.dialogs',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.templates' => array(
			'scripts' => 'jquery.wikiEditor.templates.js',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.iframe',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.toc' => array(
			'scripts' => 'jquery.wikiEditor.toc.js',
			'styles' => 'jquery.wikiEditor.toc.css',
			'dependencies' => array(
				'jquery.wikiEditor',
				'jquery.wikiEditor.iframe',
				'jquery.ui.draggable',
				'jquery.ui.resizable',
				'jquery.autoEllipsis',
				'jquery.color',
			),
			'group' => 'ext.wikiEditor',
		),
		'jquery.wikiEditor.toolbar' => array(
			'scripts' => 'jquery.wikiEditor.toolbar.js',
			'styles' => 'jquery.wikiEditor.toolbar.css',
			'dependencies' => 'jquery.wikiEditor',
			'group' => 'ext.wikiEditor',
		),
		
		/* WikiEditor Resources */
		
		'ext.wikiEditor' => array(
			'scripts' => 'ext.wikiEditor.js',
			'styles' => 'ext.wikiEditor.css',
			'dependencies' => 'jquery.wikiEditor',
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.dialogs' => array(
			'scripts' => 'ext.wikiEditor.dialogs.js',
			'styles' => 'ext.wikiEditor.dialogs.css',
			'dependencies' => array(
				'ext.wikiEditor',
				'ext.wikiEditor.toolbar',
				'jquery.wikiEditor.dialogs',
				'jquery.suggestions',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.highlight' => array(
			'scripts' => 'ext.wikiEditor.highlight.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'jquery.wikiEditor.highlight',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.preview' => array(
			'scripts' => 'ext.wikiEditor.preview.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'jquery.wikiEditor.preview',
			),
			'messages' => array(
				'wikieditor-preview-tab',
				'wikieditor-preview-changes-tab',
				'wikieditor-preview-loading',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.previewDialog' => array(
			'scripts' => 'ext.wikiEditor.previewDialog.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'jquery.wikiEditor.previewDialog',
			),
			'messages' => array(
				'wikieditor-previewDialog-preference',
				'wikieditor-previewDialog-tab',
				'wikieditor-previewDialog-loading',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.publish' => array(
			'scripts' => 'ext.wikiEditor.publish.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'jquery.wikiEditor.publish',
			),
			'messages' => array(
				'wikieditor-publish-button-publish',
				'wikieditor-publish-button-cancel',
				'wikieditor-publish-dialog-title',
				'wikieditor-publish-dialog-summary',
				'wikieditor-publish-dialog-minor',
				'wikieditor-publish-dialog-watch',
				'wikieditor-publish-dialog-publish',
				'wikieditor-publish-dialog-goback',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.templateEditor' => array(
			'scripts' => 'ext.wikiEditor.templateEditor.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'ext.wikiEditor.highlight',
				'jquery.wikiEditor.templateEditor',
			),
			'messages' => array(
				'wikieditor-template-editor-dialog-title',
				'wikieditor-template-editor-dialog-submit',
				'wikieditor-template-editor-dialog-cancel',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.templates' => array(
			'scripts' => 'ext.wikiEditor.templates.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'ext.wikiEditor.highlight',
				'jquery.wikiEditor.templates',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.toc' => array(
			'scripts' => 'ext.wikiEditor.toc.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'ext.wikiEditor.highlight',
				'jquery.wikiEditor.toc',
			),
			'messages' => array(
				'wikieditor-toc-show',
				'wikieditor-toc-hide',
			),
			'group' => 'ext.wikiEditor',
		),
		'ext.wikiEditor.tests.toolbar' => array(
			'scripts' => 'ext.wikiEditor.tests.toolbar.js',
			'dependencies' => 'ext.wikiEditor.toolbar',
			'group' => 'ext.wikiEditor.tests',
		),
		'ext.wikiEditor.toolbar' => array(
			'scripts' => 'ext.wikiEditor.toolbar.js',
			'dependencies' => array(
				'ext.wikiEditor',
				'jquery.wikiEditor.toolbar',
				'jquery.cookie',
				'jquery.async',
			),
			'messages' => array(
				// This is a mixed bunch that needs to be separated between dialog and toolbar messages, but since the
				// dialog module depends on the toolbar module, it's not an urgent matter
				'wikieditor-toolbar-loading',
				/* Main Section */
				'wikieditor-toolbar-tool-bold',
				'wikieditor-toolbar-tool-bold-example',
				'wikieditor-toolbar-tool-italic',
				'wikieditor-toolbar-tool-italic-example',
				'wikieditor-toolbar-tool-ilink',
				'wikieditor-toolbar-tool-ilink-example',
				'wikieditor-toolbar-tool-xlink',
				'wikieditor-toolbar-tool-xlink-example',
				'wikieditor-toolbar-tool-link',
				'wikieditor-toolbar-tool-link-title',
				'wikieditor-toolbar-tool-link-int',
				'wikieditor-toolbar-tool-link-int-target',
				'wikieditor-toolbar-tool-link-int-target-tooltip',
				'wikieditor-toolbar-tool-link-int-text',
				'wikieditor-toolbar-tool-link-int-text-tooltip',
				'wikieditor-toolbar-tool-link-ext',
				'wikieditor-toolbar-tool-link-ext-target',
				'wikieditor-toolbar-tool-link-ext-text',
				'wikieditor-toolbar-tool-link-insert',
				'wikieditor-toolbar-tool-link-cancel',
				'wikieditor-toolbar-tool-link-int-target-status-exists',
				'wikieditor-toolbar-tool-link-int-target-status-notexists',
				'wikieditor-toolbar-tool-link-int-target-status-invalid',
				'wikieditor-toolbar-tool-link-int-target-status-external',
				'wikieditor-toolbar-tool-link-int-target-status-loading',
				'wikieditor-toolbar-tool-link-int-invalid',
				'wikieditor-toolbar-tool-link-lookslikeinternal',
				'wikieditor-toolbar-tool-link-lookslikeinternal-int',
				'wikieditor-toolbar-tool-link-lookslikeinternal-ext',
				'wikieditor-toolbar-tool-link-empty',
				'wikieditor-toolbar-tool-file',
				'wikieditor-toolbar-tool-file-pre',
				'wikieditor-toolbar-tool-file-example',
				'wikieditor-toolbar-tool-reference',
				'wikieditor-toolbar-tool-reference-title',
				'wikieditor-toolbar-tool-reference-cancel',
				'wikieditor-toolbar-tool-reference-text',
				'wikieditor-toolbar-tool-reference-insert',
				'wikieditor-toolbar-tool-reference-example',
				'wikieditor-toolbar-tool-signature',
				/* Formatting Section */
				'wikieditor-toolbar-section-advanced',
				'wikieditor-toolbar-tool-heading',
				'wikieditor-toolbar-tool-heading-1',
				'wikieditor-toolbar-tool-heading-2',
				'wikieditor-toolbar-tool-heading-3',
				'wikieditor-toolbar-tool-heading-4',
				'wikieditor-toolbar-tool-heading-5',
				'wikieditor-toolbar-tool-heading-example',
				'wikieditor-toolbar-group-format',
				'wikieditor-toolbar-tool-ulist',
				'wikieditor-toolbar-tool-ulist-example',
				'wikieditor-toolbar-tool-olist',
				'wikieditor-toolbar-tool-olist-example',
				'wikieditor-toolbar-tool-indent',
				'wikieditor-toolbar-tool-indent-example',
				'wikieditor-toolbar-tool-nowiki',
				'wikieditor-toolbar-tool-nowiki-example',
				'wikieditor-toolbar-tool-redirect',
				'wikieditor-toolbar-tool-redirect-example',
				'wikieditor-toolbar-tool-big',
				'wikieditor-toolbar-tool-big-example',
				'wikieditor-toolbar-tool-small',
				'wikieditor-toolbar-tool-small-example',
				'wikieditor-toolbar-tool-superscript',
				'wikieditor-toolbar-tool-superscript-example',
				'wikieditor-toolbar-tool-subscript',
				'wikieditor-toolbar-tool-subscript-example',
				'wikieditor-toolbar-group-insert',
				'wikieditor-toolbar-tool-gallery',
				'wikieditor-toolbar-tool-gallery-example',
				'wikieditor-toolbar-tool-newline',
				'wikieditor-toolbar-tool-table',
				'wikieditor-toolbar-tool-table-example-old',
				'wikieditor-toolbar-tool-table-example-cell-text',
				'wikieditor-toolbar-tool-table-example',
				'wikieditor-toolbar-tool-table-example-header',
				'wikieditor-toolbar-tool-table-title',
				'wikieditor-toolbar-tool-table-dimensions-rows',
				'wikieditor-toolbar-tool-table-dimensions-columns',
				'wikieditor-toolbar-tool-table-dimensions-header',
				'wikieditor-toolbar-tool-table-wikitable',
				'wikieditor-toolbar-tool-table-sortable',
				'wikieditor-toolbar-tool-table-insert',
				'wikieditor-toolbar-tool-table-cancel',
				'wikieditor-toolbar-tool-table-example-text',
				'wikieditor-toolbar-tool-table-toomany',
				'wikieditor-toolbar-tool-table-invalidnumber',
				'wikieditor-toolbar-tool-table-zero',
				'wikieditor-toolbar-tool-replace',
				'wikieditor-toolbar-tool-replace-title',
				'wikieditor-toolbar-tool-replace-search',
				'wikieditor-toolbar-tool-replace-replace',
				'wikieditor-toolbar-tool-replace-case',
				'wikieditor-toolbar-tool-replace-regex',
				'wikieditor-toolbar-tool-replace-button-findnext',
				'wikieditor-toolbar-tool-replace-button-replacenext',
				'wikieditor-toolbar-tool-replace-button-replaceall',
				'wikieditor-toolbar-tool-replace-close',
				'wikieditor-toolbar-tool-replace-nomatch',
				'wikieditor-toolbar-tool-replace-success',
				'wikieditor-toolbar-tool-replace-emptysearch',
				'wikieditor-toolbar-tool-replace-invalidregex',
				/* Special Characters Section */
				'wikieditor-toolbar-section-characters',
				'wikieditor-toolbar-characters-page-latin',
				'wikieditor-toolbar-characters-page-latinextended',
				'wikieditor-toolbar-characters-page-ipa',
				'wikieditor-toolbar-characters-page-symbols',
				'wikieditor-toolbar-characters-page-greek',
				'wikieditor-toolbar-characters-page-cyrillic',
				'wikieditor-toolbar-characters-page-arabic',
				'wikieditor-toolbar-characters-page-persian',
				'wikieditor-toolbar-characters-page-hebrew',
				'wikieditor-toolbar-characters-page-bangla',
				'wikieditor-toolbar-characters-page-telugu',
				'wikieditor-toolbar-characters-page-sinhala',
				'wikieditor-toolbar-characters-page-gujarati',
				'wikieditor-toolbar-characters-page-thai',
				'wikieditor-toolbar-characters-page-lao',
				'wikieditor-toolbar-characters-page-khmer',
				/* Help Section */
				'wikieditor-toolbar-section-help',
				'wikieditor-toolbar-help-heading-description',
				'wikieditor-toolbar-help-heading-syntax',
				'wikieditor-toolbar-help-heading-result',
				'wikieditor-toolbar-help-page-format',
				'wikieditor-toolbar-help-page-link',
				'wikieditor-toolbar-help-page-heading',
				'wikieditor-toolbar-help-page-list',
				'wikieditor-toolbar-help-page-file',
				'wikieditor-toolbar-help-page-reference',
				'wikieditor-toolbar-help-page-discussion',
				'wikieditor-toolbar-help-content-bold-description',
				'wikieditor-toolbar-help-content-bold-syntax',
				'wikieditor-toolbar-help-content-bold-result',
				'wikieditor-toolbar-help-content-italic-description',
				'wikieditor-toolbar-help-content-italic-syntax',
				'wikieditor-toolbar-help-content-italic-result',
				'wikieditor-toolbar-help-content-bolditalic-description',
				'wikieditor-toolbar-help-content-bolditalic-syntax',
				'wikieditor-toolbar-help-content-bolditalic-result',
				'wikieditor-toolbar-help-content-ilink-description',
				'wikieditor-toolbar-help-content-ilink-syntax',
				'wikieditor-toolbar-help-content-ilink-result',
				'wikieditor-toolbar-help-content-xlink-description',
				'wikieditor-toolbar-help-content-xlink-syntax',
				'wikieditor-toolbar-help-content-xlink-result',
				'wikieditor-toolbar-help-content-heading1-description',
				'wikieditor-toolbar-help-content-heading1-syntax',
				'wikieditor-toolbar-help-content-heading1-result',
				'wikieditor-toolbar-help-content-heading2-description',
				'wikieditor-toolbar-help-content-heading2-syntax',
				'wikieditor-toolbar-help-content-heading2-result',
				'wikieditor-toolbar-help-content-heading3-description',
				'wikieditor-toolbar-help-content-heading3-syntax',
				'wikieditor-toolbar-help-content-heading3-result',
				'wikieditor-toolbar-help-content-heading4-description',
				'wikieditor-toolbar-help-content-heading4-syntax',
				'wikieditor-toolbar-help-content-heading4-result',
				'wikieditor-toolbar-help-content-heading5-description',
				'wikieditor-toolbar-help-content-heading5-syntax',
				'wikieditor-toolbar-help-content-heading5-result',
				'wikieditor-toolbar-help-content-ulist-description',
				'wikieditor-toolbar-help-content-ulist-syntax',
				'wikieditor-toolbar-help-content-ulist-result',
				'wikieditor-toolbar-help-content-olist-description',
				'wikieditor-toolbar-help-content-olist-syntax',
				'wikieditor-toolbar-help-content-olist-result',
				'wikieditor-toolbar-help-content-file-description',
				'wikieditor-toolbar-help-content-file-syntax',
				'wikieditor-toolbar-help-content-file-result',
				'wikieditor-toolbar-help-content-reference-description',
				'wikieditor-toolbar-help-content-reference-syntax',
				'wikieditor-toolbar-help-content-reference-result',
				'wikieditor-toolbar-help-content-rereference-description',
				'wikieditor-toolbar-help-content-rereference-syntax',
				'wikieditor-toolbar-help-content-rereference-result',
				'wikieditor-toolbar-help-content-showreferences-description',
				'wikieditor-toolbar-help-content-showreferences-syntax',
				'wikieditor-toolbar-help-content-showreferences-result',
				'wikieditor-toolbar-help-content-signaturetimestamp-description',
				'wikieditor-toolbar-help-content-signaturetimestamp-syntax',
				'wikieditor-toolbar-help-content-signaturetimestamp-result',
				'wikieditor-toolbar-help-content-signature-description',
				'wikieditor-toolbar-help-content-signature-syntax',
				'wikieditor-toolbar-help-content-signature-result',
				'wikieditor-toolbar-help-content-indent-description',
				'wikieditor-toolbar-help-content-indent-syntax',
				'wikieditor-toolbar-help-content-indent-result',
			),
			'group' => 'ext.wikiEditor',
		),
	);
	
	protected static $features = array(
		
		/* Beta Features */
		
		'toolbar' => array(
			'preferences' => array(
				// Ideally this key would be 'wikieditor-toolbar'
				'usebetatoolbar' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toolbar-preference',
					'section' => 'editing/beta',
				),
			),
			'requirements' => array(
				'usebetatoolbar' => true,
			),
			'modules' => array(
				'ext.wikiEditor.toolbar',
			),
		),
		'dialogs' => array(
			'preferences' => array(
				// Ideally this key would be 'wikieditor-toolbar-dialogs'
				'usebetatoolbar-cgd' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toolbar-dialogs-preference',
					'section' => 'editing/beta',
				),
			),
			'requirements' => array(
				'usebetatoolbar-cgd' => true,
			),
			'modules' => array(
				'ext.wikiEditor.dialogs',
			),
		),
		
		/* Labs Features */
		
		'templateEditor' => array(
			'preferences' => array(
				'wikieditor-template-editor' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-template-editor-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-template-editor' => true,
			),
			'modules' => array(
				'ext.wikiEditor.templateEditor',
			),
		),
		'templates' => array(
			'preferences' => array(
				'wikieditor-templates' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-templates-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-templates' => true,
			),
			'modules' => array(
				'ext.wikiEditor.templates',
			),
		),
		'addMediaWizard' => array(
			'preferences' => array(
			 	'addmediawizard-gadget' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-addMediaWizard-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'addmediawizard-gadget' => true,
			),
			'modules' => array(
				'ext.wikiEditor.addMediaWizard',
			),
		),
		'preview' => array(
			'preferences' => array(
				'wikieditor-preview' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-preview-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-preview' => true,
			),
			'modules' => array(
				'ext.wikiEditor.preview',
			),
		),
		'previewDialog' => array(
			'preferences' => array(
				'wikieditor-previewDialog' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-previewDialog-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-previewDialog' => true,
			),
			'modules' => array(
				'ext.wikiEditor.previewDialog',
			),
		),
		'publish' => array(
			'preferences' => array(
				'wikieditor-publish' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-publish-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'wikieditor-publish' => true,
			),
			'modules' => array(
				'ext.wikiEditor.publish',
			),
		),
		'toc' => array(
			'preferences' => array(
				// Ideally this key would be 'wikieditor-toc'
			 	'usenavigabletoc' => array(
					'type' => 'toggle',
					'label-message' => 'wikieditor-toc-preference',
					'section' => 'editing/labs',
				),
			),
			'requirements' => array(
				'usenavigabletoc' => true,
			),
			'modules' => array(
				'ext.wikiEditor.toc',
			),
		),
	);
	
	/* Protected Static Methods */
	
	protected static function isEnabled( $name ) {
		global $wgWikiEditorFeatures, $wgUser;
		
		// Features with global set to true are always enabled
		if ( !isset( $wgWikiEditorFeatures[$name] ) || $wgWikiEditorFeatures[$name]['global'] ) {
			return true;
		}
		// Features with user preference control can have any number of preferences to be specific values to be enabled
		if ( $wgWikiEditorFeatures[$name]['user'] ) {
			if ( isset( self::$features[$name]['requirements'] ) ) {
				foreach ( self::$features[$name]['requirements'] as $requirement => $value ) {
					// Important! We really do want fuzzy evaluation here
					if ( $wgUser->getOption( $requirement ) != $value ) {
						return false;
					}
				}
			}
			return true;
		}
		// Features controlled by $wgWikiEditorFeatures with both global and user set to false are awlways disabled 
		return false;
	}
	
	/* Static Methods */
	
	/**
	 * EditPage::showEditForm:initial hook
	 * 
	 * Adds the modules to the edit form
	 * 
	 * @param $toolbar array list of toolbar items
	 */
	public static function editPageShowEditFormInitial( &$toolbar ) {
		global $wgOut;
		
		// Add modules for enabled features
		foreach ( self::$features as $name => $feature ) {
			if ( isset( $feature['modules'] ) && self::isEnabled( $name ) ) {
				$wgOut->addModules( $feature['modules'] );
			}
		}
		return true;
	}
	
	/**
	 * GetPreferences hook
	 * 
	 * Adds WikiEditor-releated items to the preferences
	 * 
	 * @param $out User current user
	 * @param $skin array list of default user preference controls
	 */
	public static function getPreferences( $user, &$defaultPreferences ) {
		global $wgWikiEditorFeatures;
		
		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['preferences'] ) &&
				( !isset( $wgWikiEditorFeatures[$name] ) || $wgWikiEditorFeatures[$name]['user'] )
			) {
				foreach ( $feature['preferences'] as $key => $options ) {
					$defaultPreferences[$key] = $options;
				}
			}
		}
		return true;
	}
	
	/**
	 * MakeGlobalVariablesScript hook
	 * 
	 * Adds enabled/disabled switches for WikiEditor modules
	 */
	public static function makeGlobalVariablesScript( &$vars ) {
		global $wgWikiEditorFeatures;
		
		$configurations = array();
		foreach ( self::$features as $name => $feature ) {
			if (
				isset( $feature['configurations'] ) &&
				( !isset( $wgWikiEditorFeatures[$name] ) || self::isEnabled( $name ) )
			) {
				foreach ( $feature['configurations'] as $configuration ) {
					global $$configuration;
					$configurations[$configuration] = $$configuration;
				}
			}
		}
		if ( count( $configurations ) ) {
			$vars = array_merge( $vars, $configurations );
		}
		return true;
	}
	
	/*
	 * ResourceLoaderRegisterModules hook
	 * 
	 * Adds modules to ResourceLoader
	 */
	public static function resourceLoaderRegisterModules( &$resourceLoader ) {
		global $wgExtensionAssetsPath;
		$localpath = dirname( __FILE__ ) . '/modules';
		$remotepath = "$wgExtensionAssetsPath/WikiEditor/modules";
		foreach ( self::$modules as $name => $resources ) {
			$resourceLoader->register(
				$name, new ResourceLoaderFileModule( $resources, $localpath, $remotepath )
			);
		}
		return true;
	}
}