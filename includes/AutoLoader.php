<?php

/* This defines autoloading handler for whole MediaWiki framework */

ini_set('unserialize_callback_func', '__autoload' );

function __autoload($className) {
	global $wgAutoloadClasses;

	# Locations of core classes
	# Extension classes are specified with $wgAutoloadClasses
	static $localClasses = array(
		# Includes
		'AjaxCachePolicy' => 'includes/AjaxFunctions.php',
		'AjaxDispatcher' => 'includes/AjaxDispatcher.php',
		'AjaxResponse' => 'includes/AjaxResponse.php',
		'AlphabeticPager' => 'includes/Pager.php',
		'AncientPagesPage' => 'includes/SpecialAncientpages.php',
		'APCBagOStuff' => 'includes/BagOStuff.php',
		'ArrayDiffFormatter' => 'includes/DifferenceEngine.php',
		'Article' => 'includes/Article.php',
		'AtomFeed' => 'includes/Feed.php',
		'AuthPlugin' => 'includes/AuthPlugin.php',
		'Autopromote' => 'includes/Autopromote.php',
		'BagOStuff' => 'includes/BagOStuff.php',
		'Block' => 'includes/Block.php',
		'BrokenRedirectsPage' => 'includes/SpecialBrokenRedirects.php',
		'Category' => 'includes/Category.php',
		'Categoryfinder' => 'includes/Categoryfinder.php',
		'CategoryList' => 'includes/Category.php',
		'CategoryPage' => 'includes/CategoryPage.php',
		'CategoryViewer' => 'includes/CategoryPage.php',
		'ChangesList' => 'includes/ChangesList.php',
		'ChannelFeed' => 'includes/Feed.php',
		'ChronologyProtector' => 'includes/LBFactory.php',
		'ConcatenatedGzipHistoryBlob' => 'includes/HistoryBlob.php',
		'ContributionsPage' => 'includes/SpecialContributions.php',
		'CoreParserFunctions' => 'includes/CoreParserFunctions.php',
		'Database' => 'includes/Database.php',
		'DatabaseMysql' => 'includes/Database.php',
		'DatabaseOracle' => 'includes/DatabaseOracle.php',
		'DatabasePostgres' => 'includes/DatabasePostgres.php',
		'DateFormatter' => 'includes/DateFormatter.php',
		'DBABagOStuff' => 'includes/BagOStuff.php',
		'DBLockForm' => 'includes/SpecialLockdb.php',
		'DBObject' => 'includes/Database.php',
		'DBUnlockForm' => 'includes/SpecialUnlockdb.php',
		'DeadendPagesPage' => 'includes/SpecialDeadendpages.php',
		'DependencyWrapper' => 'includes/CacheDependency.php',
		'_DiffEngine' => 'includes/DifferenceEngine.php',
		'DifferenceEngine' => 'includes/DifferenceEngine.php',
		'DiffFormatter' => 'includes/DifferenceEngine.php',
		'Diff' => 'includes/DifferenceEngine.php',
		'_DiffOp_Add' => 'includes/DifferenceEngine.php',
		'_DiffOp_Change' => 'includes/DifferenceEngine.php',
		'_DiffOp_Copy' => 'includes/DifferenceEngine.php',
		'_DiffOp_Delete' => 'includes/DifferenceEngine.php',
		'_DiffOp' => 'includes/DifferenceEngine.php',
		'DisambiguationsPage' => 'includes/SpecialDisambiguations.php',
		'DjVuImage' => 'includes/DjVuImage.php',
		'DoubleRedirectsPage' => 'includes/SpecialDoubleRedirects.php',
		'DoubleReplacer' => 'includes/StringUtils.php',
		'Dump7ZipOutput' => 'includes/Export.php',
		'DumpBZip2Output' => 'includes/Export.php',
		'DumpFileOutput' => 'includes/Export.php',
		'DumpFilter' => 'includes/Export.php',
		'DumpGZipOutput' => 'includes/Export.php',
		'DumpLatestFilter' => 'includes/Export.php',
		'DumpMultiWriter' => 'includes/Export.php',
		'DumpNamespaceFilter' => 'includes/Export.php',
		'DumpNotalkFilter' => 'includes/Export.php',
		'DumpOutput' => 'includes/Export.php',
		'DumpPipeOutput' => 'includes/Export.php',
		'eAccelBagOStuff' => 'includes/BagOStuff.php',
		'EditPage' => 'includes/EditPage.php',
		'EmailConfirmation' => 'includes/SpecialConfirmemail.php',
		'EmailInvalidation' => 'includes/SpecialConfirmemail.php',
		'EmaillingJob' => 'includes/EmaillingJob.php',
		'EmaillingJob' => 'includes/JobQueue.php',
		'EmailNotification' => 'includes/UserMailer.php',
		'EmailUserForm' => 'includes/SpecialEmailuser.php',
		'EnhancedChangesList' => 'includes/ChangesList.php',
		'EnotifNotifyJob' => 'includes/EnotifNotifyJob.php',
		'Exif' => 'includes/Exif.php',
		'ExternalEdit' => 'includes/ExternalEdit.php',
		'ExternalStoreDB' => 'includes/ExternalStoreDB.php',
		'ExternalStoreHttp' => 'includes/ExternalStoreHttp.php',
		'ExternalStore' => 'includes/ExternalStore.php',
		'FakeMemCachedClient' => 'includes/ObjectCache.php',
		'FakeTitle' => 'includes/FakeTitle.php',
		'FauxRequest' => 'includes/WebRequest.php',
		'FeedItem' => 'includes/Feed.php',
		'FewestrevisionsPage' => 'includes/SpecialFewestrevisions.php',
		'FileDeleteForm' => 'includes/FileDeleteForm.php',
		'FileDependency' => 'includes/CacheDependency.php',
		'FileDuplicateSearch' => 'includes/SpecialFileDuplicateSearch.php',
		'FileRevertForm' => 'includes/FileRevertForm.php',
		'FileStore' => 'includes/FileStore.php',
		'FormatExif' => 'includes/Exif.php',
		'FSException' => 'includes/FileStore.php',
		'FSTransaction' => 'includes/FileStore.php',
		'HashBagOStuff' => 'includes/BagOStuff.php',
		'HashtableReplacer' => 'includes/StringUtils.php',
		'HistoryBlobCurStub' => 'includes/HistoryBlob.php',
		'HistoryBlob' => 'includes/HistoryBlob.php',
		'HistoryBlobStub' => 'includes/HistoryBlob.php',
		'HTMLCacheUpdate' => 'includes/HTMLCacheUpdate.php',
		'HTMLCacheUpdateJob' => 'includes/HTMLCacheUpdate.php',
		'HTMLFileCache' => 'includes/HTMLFileCache.php',
		'Http' => 'includes/HttpFunctions.php',
		'_HWLDF_WordAccumulator' => 'includes/DifferenceEngine.php',
		'ImageGallery' => 'includes/ImageGallery.php',
		'ImageHistoryList' => 'includes/ImagePage.php',
		'ImagePage' => 'includes/ImagePage.php',
		'ImageQueryPage' => 'includes/ImageQueryPage.php',
		'ImportStreamSource' => 'includes/SpecialImport.php',
		'ImportStringSource' => 'includes/SpecialImport.php',
		'IncludableSpecialPage' => 'includes/SpecialPage.php',
		'IndexPager' => 'includes/Pager.php',
		'IPBlockForm' => 'includes/SpecialBlockip.php',
		'IP' => 'includes/IP.php',
		'IPUnblockForm' => 'includes/SpecialIpblocklist.php',
		'Job' => 'includes/JobQueue.php',
		'LBFactory' => 'includes/LBFactory.php',
		'LBFactory_Multi' => 'includes/LBFactory_Multi.php',
		'LBFactory_Simple' => 'includes/LBFactory.php',
		'License' => 'includes/Licenses.php',
		'Licenses' => 'includes/Licenses.php',
		'LinkBatch' => 'includes/LinkBatch.php',
		'LinkCache' => 'includes/LinkCache.php',
		'Linker' => 'includes/Linker.php',
		'LinkFilter' => 'includes/LinkFilter.php',
		'LinksUpdate' => 'includes/LinksUpdate.php',
		'ListredirectsPage' => 'includes/SpecialListredirects.php',
		'LoadBalancer' => 'includes/LoadBalancer.php',
		'LoginForm' => 'includes/SpecialUserlogin.php',
		'LogPage' => 'includes/LogPage.php',
		'LogEventsList' => 'includes/LogEventsList.php',
		'LogReader' => 'includes/LogEventsList.php',
		'LogViewer' => 'includes/LogEventsList.php',
		'LonelyPagesPage' => 'includes/SpecialLonelypages.php',
		'LongPagesPage' => 'includes/SpecialLongpages.php',
		'MacBinary' => 'includes/MacBinary.php',
		'MagicWordArray' => 'includes/MagicWord.php',
		'MagicWord' => 'includes/MagicWord.php',
		'MailAddress' => 'includes/UserMailer.php',
		'MappedDiff' => 'includes/DifferenceEngine.php',
		'MathRenderer' => 'includes/Math.php',
		'MediaTransformError' => 'includes/MediaTransformOutput.php',
		'MediaTransformOutput' => 'includes/MediaTransformOutput.php',
		'MediaWikiBagOStuff' => 'includes/BagOStuff.php',
		'MediaWiki_I18N' => 'includes/SkinTemplate.php',
		'MediaWiki' => 'includes/Wiki.php',
		'memcached' => 'includes/memcached-client.php',
		'MessageCache' => 'includes/MessageCache.php',
		'MimeMagic' => 'includes/MimeMagic.php',
		'MIMEsearchPage' => 'includes/SpecialMIMEsearch.php',
		'MostcategoriesPage' => 'includes/SpecialMostcategories.php',
		'MostimagesPage' => 'includes/SpecialMostimages.php',
		'MostlinkedCategoriesPage' => 'includes/SpecialMostlinkedcategories.php',
		'MostlinkedPage' => 'includes/SpecialMostlinked.php',
		'MostrevisionsPage' => 'includes/SpecialMostrevisions.php',
		'MovePageForm' => 'includes/SpecialMovepage.php',
		'MWException' => 'includes/Exception.php',
		'MWNamespace' => 'includes/Namespace.php',
		'MySQLSearchResultSet' => 'includes/SearchMySQL.php',
		'MySQLMasterPos' => 'includes/Database.php',
		'Namespace' => 'includes/NamespaceCompat.php', // Compat
		'NewbieContributionsPage' => 'includes/SpecialNewbieContributions.php',
		'NewPagesPage' => 'includes/SpecialNewpages.php',
		'OldChangesList' => 'includes/ChangesList.php',
		'OutputPage' => 'includes/OutputPage.php',
		'PageArchive' => 'includes/SpecialUndelete.php',
		'PageHistory' => 'includes/PageHistory.php',
		'PageQueryPage' => 'includes/PageQueryPage.php',
		'ParserCache' => 'includes/ParserCache.php',
		'Parser_DiffTest' => 'includes/Parser_DiffTest.php',
		'Parser' => 'includes/Parser.php',
		'Parser_OldPP' => 'includes/Parser_OldPP.php',
		'ParserOptions' => 'includes/ParserOptions.php',
		'ParserOutput' => 'includes/ParserOutput.php',
		'PasswordResetForm' => 'includes/SpecialResetpass.php',
		'PatrolLog' => 'includes/PatrolLog.php',
		'PopularPagesPage' => 'includes/SpecialPopularpages.php',
		'PPDStackElement' => 'includes/Preprocessor_DOM.php',
		'PPDStack' => 'includes/Preprocessor_DOM.php',
		'PPFrame_DOM' => 'includes/Preprocessor_DOM.php',
		'PPFrame' => 'includes/Preprocessor.php',
		'PPNode_DOM' => 'includes/Preprocessor_DOM.php',
		'PPNode' => 'includes/Preprocessor.php',
		'PPTemplateFrame_DOM' => 'includes/Preprocessor_DOM.php',
		'PreferencesForm' => 'includes/SpecialPreferences.php',
		'PrefixSearch' => 'includes/PrefixSearch.php',
		'Preprocessor_DOM' => 'includes/Preprocessor_DOM.php',
		'Preprocessor_Hash' => 'includes/Preprocessor_Hash.php',
		'Preprocessor' => 'includes/Preprocessor.php',
		'Profiler' => 'includes/Profiler.php',
		'ProfilerSimple' => 'includes/ProfilerSimple.php',
		'ProfilerSimpleUDP' => 'includes/ProfilerSimpleUDP.php',
		'ProtectionForm' => 'includes/ProtectionForm.php',
		'ProxyTools' => 'includes/ProxyTools.php',
		'QueryPage' => 'includes/QueryPage.php',
		'QuickTemplate' => 'includes/SkinTemplate.php',
		'RandomPage' => 'includes/SpecialRandompage.php',
		'RawPage' => 'includes/RawPage.php',
		'RCCacheEntry' => 'includes/ChangesList.php',
		'RecentChange' => 'includes/RecentChange.php',
		'RefreshLinksJob' => 'includes/RefreshLinksJob.php',
		'RegexlikeReplacer' => 'includes/StringUtils.php',
		'ReplacementArray' => 'includes/StringUtils.php',
		'Replacer' => 'includes/StringUtils.php',
		'ResultWrapper' => 'includes/Database.php',
		'ReverseChronologicalPager' => 'includes/Pager.php',
		'RevisionDeleteForm' => 'includes/SpecialRevisiondelete.php',
		'RevisionDeleter' => 'includes/SpecialRevisiondelete.php',
		'Revision' => 'includes/Revision.php',
		'RSSFeed' => 'includes/Feed.php',
		'Sanitizer' => 'includes/Sanitizer.php',
		'SearchEngineDummy' => 'includes/SearchEngine.php',
		'SearchEngine' => 'includes/SearchEngine.php',
		'SearchMySQL4' => 'includes/SearchMySQL4.php',
		'SearchMySQL' => 'includes/SearchMySQL.php',
		'SearchOracle' => 'includes/SearchOracle.php',
		'SearchPostgres' => 'includes/SearchPostgres.php',
		'SearchResult' => 'includes/SearchEngine.php',
		'SearchResultSet' => 'includes/SearchEngine.php',
		'SearchUpdate' => 'includes/SearchUpdate.php',
		'SearchUpdateMyISAM' => 'includes/SearchUpdate.php',
		'ShortPagesPage' => 'includes/SpecialShortpages.php',
		'SiteConfiguration' => 'includes/SiteConfiguration.php',
		'SiteStats' => 'includes/SiteStats.php',
		'SiteStatsUpdate' => 'includes/SiteStats.php',
		'Skin' => 'includes/Skin.php',
		'SkinTemplate' => 'includes/SkinTemplate.php',
		'SpecialAllpages' => 'includes/SpecialAllpages.php',
		'SpecialBookSources' => 'includes/SpecialBooksources.php',
		'SpecialMostlinkedtemplates' => 'includes/SpecialMostlinkedtemplates.php',
		'SpecialPage' => 'includes/SpecialPage.php',
		'SpecialPrefixindex' => 'includes/SpecialPrefixindex.php',
		'SpecialRandomredirect' => 'includes/SpecialRandomredirect.php',
		'SpecialSearch' => 'includes/SpecialSearch.php',
		'SpecialVersion' => 'includes/SpecialVersion.php',
		'SqlBagOStuff' => 'includes/BagOStuff.php',
		'SquidUpdate' => 'includes/SquidUpdate.php',
		'Status' => 'includes/Status.php',
		'StringUtils' => 'includes/StringUtils.php',
		'TableDiffFormatter' => 'includes/DifferenceEngine.php',
		'TablePager' => 'includes/Pager.php',
		'ThumbnailImage' => 'includes/MediaTransformOutput.php',
		'TitleDependency' => 'includes/CacheDependency.php',
		'Title' => 'includes/Title.php',
		'TitleListDependency' => 'includes/CacheDependency.php',
		'TransformParameterError' => 'includes/MediaTransformOutput.php',
		'TurckBagOStuff' => 'includes/BagOStuff.php',
		'UncategorizedCategoriesPage' => 'includes/SpecialUncategorizedcategories.php',
		'UncategorizedPagesPage' => 'includes/SpecialUncategorizedpages.php',
		'UncategorizedTemplatesPage' => 'includes/SpecialUncategorizedtemplates.php',
		'UndeleteForm' => 'includes/SpecialUndelete.php',
		'UnifiedDiffFormatter' => 'includes/DifferenceEngine.php',
		'UnlistedSpecialPage' => 'includes/SpecialPage.php',
		'UnusedCategoriesPage' => 'includes/SpecialUnusedcategories.php',
		'UnusedimagesPage' => 'includes/SpecialUnusedimages.php',
		'UnusedtemplatesPage' => 'includes/SpecialUnusedtemplates.php',
		'UnwatchedpagesPage' => 'includes/SpecialUnwatchedpages.php',
		'UploadForm' => 'includes/SpecialUpload.php',
		'UploadFormMogile' => 'includes/SpecialUploadMogile.php',
		'User' => 'includes/User.php',
		'UserMailer' => 'includes/UserMailer.php',
		'UserrightsPage' => 'includes/SpecialUserrights.php',
		'UserRightsProxy' => 'includes/UserRightsProxy.php',
		'WantedCategoriesPage' => 'includes/SpecialWantedcategories.php',
		'WantedPagesPage' => 'includes/SpecialWantedpages.php',
		'WatchedItem' => 'includes/WatchedItem.php',
		'WatchlistEditor' => 'includes/WatchlistEditor.php',
		'WebRequest' => 'includes/WebRequest.php',
		'WebResponse' => 'includes/WebResponse.php',
		'WhatLinksHerePage' => 'includes/SpecialWhatlinkshere.php',
		'WikiError' => 'includes/WikiError.php',
		'WikiErrorMsg' => 'includes/WikiError.php',
		'WikiExporter' => 'includes/Export.php',
		'WikiImporter' => 'includes/SpecialImport.php',
		'WikiRevision' => 'includes/SpecialImport.php',
		'WikiXmlError' => 'includes/WikiError.php',
		'WithoutInterwikiPage' => 'includes/SpecialWithoutinterwiki.php',
		'WordLevelDiff' => 'includes/DifferenceEngine.php',
		'XCacheBagOStuff' => 'includes/BagOStuff.php',
		'XmlDumpWriter' => 'includes/Export.php',
		'Xml' => 'includes/Xml.php',
		'XmlTypeCheck' => 'includes/XmlTypeCheck.php',
		'ZhClient' => 'includes/ZhClient.php',

		# filerepo
		'ArchivedFile' => 'includes/filerepo/ArchivedFile.php',
		'File' => 'includes/filerepo/File.php',
		'FileRepo' => 'includes/filerepo/FileRepo.php',
		'FileRepoStatus' => 'includes/filerepo/FileRepoStatus.php',
		'ForeignDBFile' => 'includes/filerepo/ForeignDBFile.php',
		'ForeignDBRepo' => 'includes/filerepo/ForeignDBRepo.php',
		'ForeignDBViaLBRepo' => 'includes/filerepo/ForeignDBViaLBRepo.php',
		'FSRepo' => 'includes/filerepo/FSRepo.php',
		'Image' => 'includes/filerepo/Image.php',
		'LocalFileDeleteBatch' => 'includes/filerepo/LocalFile.php',
		'LocalFile' => 'includes/filerepo/LocalFile.php',
		'LocalFileRestoreBatch' => 'includes/filerepo/LocalFile.php',
		'LocalRepo' => 'includes/filerepo/LocalRepo.php',
		'OldLocalFile' => 'includes/filerepo/OldLocalFile.php',
		'RepoGroup' => 'includes/filerepo/RepoGroup.php',
		'UnregisteredLocalFile' => 'includes/filerepo/UnregisteredLocalFile.php',

		# Media
		'BitmapHandler' => 'includes/media/Bitmap.php',
		'BmpHandler' => 'includes/media/BMP.php',
		'DjVuHandler' => 'includes/media/DjVu.php',
		'ImageHandler' => 'includes/media/Generic.php',
		'MediaHandler' => 'includes/media/Generic.php',
		'SvgHandler' => 'includes/media/SVG.php',

		# Normal
		'UtfNormal' => 'includes/normal/UtfNormal.php',

		# Templates
		'UsercreateTemplate' => 'includes/templates/Userlogin.php',
		'UserloginTemplate' => 'includes/templates/Userlogin.php',

		# Languages
		'Language' => 'languages/Language.php',

		# API
		'ApiBase' => 'includes/api/ApiBase.php',
		'ApiExpandTemplates' => 'includes/api/ApiExpandTemplates.php',
		'ApiFeedWatchlist' => 'includes/api/ApiFeedWatchlist.php',
		'ApiFormatBase' => 'includes/api/ApiFormatBase.php',
		'ApiFormatDbg' => 'includes/api/ApiFormatDbg.php',
		'ApiFormatFeedWrapper' => 'includes/api/ApiFormatBase.php',
		'ApiFormatJson' => 'includes/api/ApiFormatJson.php',
		'ApiFormatPhp' => 'includes/api/ApiFormatPhp.php',
		'ApiFormatTxt' => 'includes/api/ApiFormatTxt.php',
		'ApiFormatWddx' => 'includes/api/ApiFormatWddx.php',
		'ApiFormatXml' => 'includes/api/ApiFormatXml.php',
		'ApiFormatYaml' => 'includes/api/ApiFormatYaml.php',
		'ApiHelp' => 'includes/api/ApiHelp.php',
		'ApiLogin' => 'includes/api/ApiLogin.php',
		'ApiLogout' => 'includes/api/ApiLogout.php',
		'ApiMain' => 'includes/api/ApiMain.php',
		'ApiOpenSearch' => 'includes/api/ApiOpenSearch.php',
		'ApiPageSet' => 'includes/api/ApiPageSet.php',
		'ApiParamInfo' => 'includes/api/ApiParamInfo.php',
		'ApiParse' => 'includes/api/ApiParse.php',
		'ApiQueryAllImages' => 'includes/api/ApiQueryAllimages.php',
		'ApiQueryAllCategories' => 'includes/api/ApiQueryAllCategories.php',
		'ApiQueryAllLinks' => 'includes/api/ApiQueryAllLinks.php',
		'ApiQueryAllmessages' => 'includes/api/ApiQueryAllmessages.php',
		'ApiQueryAllpages' => 'includes/api/ApiQueryAllpages.php',
		'ApiQueryAllUsers' => 'includes/api/ApiQueryAllUsers.php',
		'ApiQueryBacklinks' => 'includes/api/ApiQueryBacklinks.php',
		'ApiQueryBase' => 'includes/api/ApiQueryBase.php',
		'ApiQueryCategories' => 'includes/api/ApiQueryCategories.php',
		'ApiQueryCategoryMembers' => 'includes/api/ApiQueryCategoryMembers.php',
		'ApiQueryContributions' => 'includes/api/ApiQueryUserContributions.php',
		'ApiQueryExternalLinks' => 'includes/api/ApiQueryExternalLinks.php',
		'ApiQueryExtLinksUsage' => 'includes/api/ApiQueryExtLinksUsage.php',
		'ApiQueryGeneratorBase' => 'includes/api/ApiQueryBase.php',
		'ApiQueryImageInfo' => 'includes/api/ApiQueryImageInfo.php',
		'ApiQueryImages' => 'includes/api/ApiQueryImages.php',
		'ApiQuery' => 'includes/api/ApiQuery.php',
		'ApiQueryInfo' => 'includes/api/ApiQueryInfo.php',
		'ApiQueryLangLinks' => 'includes/api/ApiQueryLangLinks.php',
		'ApiQueryLinks' => 'includes/api/ApiQueryLinks.php',
		'ApiQueryLogEvents' => 'includes/api/ApiQueryLogEvents.php',
		'ApiQueryRandom' => 'includes/api/ApiQueryRandom.php',
		'ApiQueryRecentChanges'=> 'includes/api/ApiQueryRecentChanges.php',
		'ApiQueryRevisions' => 'includes/api/ApiQueryRevisions.php',
		'ApiQuerySearch' => 'includes/api/ApiQuerySearch.php',
		'ApiQuerySiteinfo' => 'includes/api/ApiQuerySiteinfo.php',
		'ApiQueryUserInfo' => 'includes/api/ApiQueryUserInfo.php',
		'ApiQueryUsers' => 'includes/api/ApiQueryUsers.php',
		'ApiQueryWatchlist' => 'includes/api/ApiQueryWatchlist.php',
		'ApiResult' => 'includes/api/ApiResult.php',
		'Services_JSON' => 'includes/api/ApiFormatJson_json.php',
		'Spyc' => 'includes/api/ApiFormatYaml_spyc.php',

		# apiedit branch
		'ApiBlock' => 'includes/api/ApiBlock.php',
		'ApiDelete' => 'includes/api/ApiDelete.php',
		'ApiEditPage' => 'includes/api/ApiEditPage.php',
		'ApiMove' => 'includes/api/ApiMove.php',
		'ApiProtect' => 'includes/api/ApiProtect.php',
		'ApiQueryBlocks' => 'includes/api/ApiQueryBlocks.php',
		'ApiQueryDeletedrevs' => 'includes/api/ApiQueryDeletedrevs.php',
		'ApiRollback' => 'includes/api/ApiRollback.php',
		'ApiUnblock' => 'includes/api/ApiUnblock.php',
		'ApiUndelete' => 'includes/api/ApiUndelete.php',
	);
	
	wfProfileIn( __METHOD__ );
	if ( isset( $localClasses[$className] ) ) {
		$filename = $localClasses[$className];
	} elseif ( isset( $wgAutoloadClasses[$className] ) ) {
		$filename = $wgAutoloadClasses[$className];
	} else {
		# Try a different capitalisation
		# The case can sometimes be wrong when unserializing PHP 4 objects
		$filename = false;
		$lowerClass = strtolower( $className );
		foreach ( $localClasses as $class2 => $file2 ) {
			if ( strtolower( $class2 ) == $lowerClass ) {
				$filename = $file2;
			}
		}
		if ( !$filename ) {
			# Give up
			wfProfileOut( __METHOD__ );
			return;
		}
	}

	# Make an absolute path, this improves performance by avoiding some stat calls
	if ( substr( $filename, 0, 1 ) != '/' && substr( $filename, 1, 1 ) != ':' ) {
		global $IP;
		$filename = "$IP/$filename";
	}
	require( $filename );
	wfProfileOut( __METHOD__ );
}

function wfLoadAllExtensions() {
	global $wgAutoloadClasses;

	# It is crucial that SpecialPage.php is included before any special page 
	# extensions are loaded. Otherwise the parent class will not be available
	# when APC loads the early-bound extension class. Normally this is 
	# guaranteed by entering special pages via SpecialPage members such as 
	# executePath(), but here we have to take a more explicit measure.
	
	require_once( dirname(__FILE__) . '/SpecialPage.php' );
	
	foreach( $wgAutoloadClasses as $class => $file ) {
		if( !( class_exists( $class ) || interface_exists( $class ) ) ) {
			require( $file );
		}
	}
}
