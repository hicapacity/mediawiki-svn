<?php
/**
 * mvpcf, a MediaWiki skin
 * Version .01
 * Made for MediaWiki 1.12
 * By Michael Dale, dale@kevcom.com,
 * in collaboration with Partipipatory culture foundation
 *  (
 * 
 * Local settings that affect this skin (in LocalSettings.php):
 * $wgDefaultSkin       change to "mvpcf" to use as your default skin
 * $wgSitename          this is displayed as the site name
 
 * @package MediaWiki
 * @subpackage Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @addtogroup Skins
 */
class SkinMvpcf extends SkinTemplate {
	/** Using monobook. */
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'mvpcf';
		$this->stylename = 'mvpcf';
		$this->template  = 'MvpcfTemplate';
	}
}


/**
 * @todo document
 * @addtogroup Skins
 */
class MvpcfTemplate extends QuickTemplate {
	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgUser, $wgTitle, $wgRequest;
		$this->user_skin = $wgUser->getSkin();

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();
		//set up template variables: 
		$this->data['showjumplinks']=false;
		$this->data['tagline']=false;		
		$this->get_head_html();
		if($wgTitle->getNamespace()== NS_MAIN &&
		   $wgTitle->getDBkey()=='Main_Page' &&
		   $wgRequest->getText( 'action', 'view' )=='view'){
			$this->get_splash_page_html();
		}else{
			$this->get_base_body_html();
		}		
		$this->get_footer_html();
	}
	function get_personal_portlet(){
		?>
		<div class="portlet" id="p-personal">
			<h5><?php $this->msg('personaltools') ?></h5>
			<div class="pBody">
				<ul>
			<?php foreach($this->data['personal_urls'] as $key => $item) { ?>
					<li id="pt-<?php echo Sanitizer::escapeId($key) ?>"<?php
						if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
					echo htmlspecialchars($item['href']) ?>"<?php echo $this->user_skin->tooltipAndAccesskey('pt-'.$key) ?><?php
					if(!empty($item['class'])) { ?> class="<?php
					echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
					echo htmlspecialchars($item['text']) ?></a></li>
			<?php } ?>
				</ul>
			</div>
		</div>
		<?php
	}
	function get_splash_page_html(){
		global $wgScript; 
		?>	
	<body id="frontPage">
	<div id="frontPageTop">
		<?php $this->get_personal_portlet()?>
		<div id="searchSplash">
			<div class="logo"><a href="#"><img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/logo.png" alt="Metavid" /></a></div>
			<p class="tagline">The Open Video archive of the US Congress</p>
			<?php $this->get_search_html(); ?>			
		</div><!--searchSplash-->
	</div><!--frontPageTop-->	
	<div id="frontPageContent">
		<h2>Today's Popular Searches</h2>
		<ul class="popularSearches">
			<li><a href="#">Barack Obama</a></li>
			<li><a href="#">Health Care</a></li>
			<li><a href="#">Gas Tax</a></li>
			<li><a href="#">Hillary Clinton</a></li>

			<li><a href="#">John McCain</a></li>
			<li><a href="#">Iraq War</a></li>
			<li class="last_li"><a href="#">Appropriations</a></li>
		</ul>
		
		<h2>Today's Popular Clips</h2>
		<ul class="popularClips">
			<li>
				<img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/img1.jpg" alt="Clip Image" />
				<span class="title"><a href="#">Sen. Barack Obama (D-IL)</a></span>
				<span class="description">Senate Floor - June 3, 2008</span>
				<span class="keywords">keywords: <a href="#">war</a>, <a href="#">iraq</a>, <a href="#">budget</a></span>
			</li>		
			<li>
				<img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/img1.jpg" alt="Clip Image" />
				<span class="title"><a href="#">Sen. Barack Obama (D-IL)</a></span>
				<span class="description">Senate Floor - June 3, 2008</span>
				<span class="keywords">keywords: <a href="#">war</a>, <a href="#">iraq</a>, <a href="#">budget</a></span>

			</li>			
			<li>
				<img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/img1.jpg" alt="Clip Image" />
				<span class="title"><a href="#">Sen. Barack Obama (D-IL)</a></span>
				<span class="description">Senate Floor - June 3, 2008</span>
				<span class="keywords">keywords: <a href="#">war</a>, <a href="#">iraq</a>, <a href="#">budget</a></span>

			</li>			
			<li class="last_li">
				<img src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/img1.jpg" alt="Clip Image" />
				<span class="title"><a href="#">Sen. Barack Obama (D-IL)</a></span>
				<span class="description">Senate Floor - June 3, 2008</span>
				<span class="keywords">keywords: <a href="#">war</a>, <a href="#">iraq</a>, <a href="#">budget</a></span>

			</li>
		</ul>
	</div>	 
	</body>
	<?php
	}
	function get_search_html(){		
		global $wgScript, $wgPageName, $wgTitle;
		//set approporiate javascript to flag advanced search 
		?>		
		<div class="form_search_row">
				<form id="mv_media_search" method="get" action="<?php echo $wgScript ?>/Special:MediaSearch">
					<input type="hidden" id="mvsel_t_0" name="f[0][t]" value="match">
								
					<input type="text" class="searchField" name="f[0][v]" id="search_field" />
					<button class="grey_button" type="submit"><span>&nbsp;&nbsp; Video Search &nbsp;&nbsp;</span></button>
					<a href="#" class="advanced_search_tag">advanced search</a>
				</form>				
				<div id="p-cactions" class="portlet">
					<h5><?php $this->msg('views') ?></h5>
					<div class="pBody">
						<ul>
				<?php			foreach($this->data['content_actions'] as $key => $tab) { ?>
							 <li id="ca-<?php echo Sanitizer::escapeId($key) ?>"<?php
								 	if($tab['class']) { ?> class="<?php echo htmlspecialchars($tab['class']) ?>"<?php }
								 ?>><a href="<?php echo htmlspecialchars($tab['href']) ?>"<?php echo $this->user_skin->tooltipAndAccesskey('ca-'.$key) ?>><?php
								 echo htmlspecialchars($tab['text']) ?></a></li>
				<?php			 } ?>
						</ul>
					</div>
				</div>
			</div>
			
			<div id="suggestions" style="display:none">
				<div id="suggestionsTop"></div>
				<div id="suggestionsInner" class="suggestionsBox">										
				</div><!--suggestionsInner-->
				<div id="suggestionsBot"></div>
			</div><!--suggestions-->
		</div>		
		<?php
	}
	function get_base_body_html(){	
		global $wgScript;
?>
<body <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload']) { ?>onload="<?php     $this->text('body_onload')     ?>"<?php } ?>
 class="mediawiki <?php $this->text('nsclass') ?> <?php $this->text('dir') ?> <?php $this->text('pageclass') ?>">
	<div id="globalWrapper">
	<div id="searchHeader">
			<div class="logo2">
				<a href="<?php echo $wgScript ?>">
				<img alt="Metavid" src="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/images/logo2.png"/>
				</a>
				<p class="tagline2">Video archive of the US Congress</p>
			</div>		
	<?php $this->get_search_html(); ?>
	</div>	
	<div id="column-content">
	<div id="content">
		<a name="top" id="top"></a>
		<?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
		<h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>
		<div id="bodyContent">
			<?php if($this->data['tagline']){?><h3 id="siteSub"><?php $this->msg('tagline') ?></h3><? } ?>
			<div id="contentSub"><?php $this->html('subtitle') ?></div>
			<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
			<?php if($this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html('newtalk')  ?></div><?php } ?>
			<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
			<!-- start content -->
			<?php $this->html('bodytext') ?>
			<?php if($this->data['catlinks']) { ?><div id="catlinks"><?php       $this->html('catlinks') ?></div><?php } ?>
			<!-- end content -->
			<div class="visualClear"></div>
		</div>
	</div>
		</div>
		<!--  <div id="column-one">-->
	
	<?php $this->get_personal_portlet() ?>
	<div class="portlet" id="p-logo">
		<a style="background-image: url(<?php $this->text('logopath') ?>);" <?php
			?>href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>"<?php
			echo $this->user_skin->tooltipAndAccesskey('n-mainpage') ?>></a>
	</div>
	<script type="<?php $this->text('jsmimetype') ?>"> if (window.isMSIE55) fixalpha(); </script>
	<?php foreach ($this->data['sidebar'] as $bar => $cont) { ?>
	<div class='portlet' id='p-<?php echo Sanitizer::escapeId($bar) ?>'<?php echo $this->user_skin->tooltip('p-'.$bar) ?>>
		<h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
		<div class='pBody'>
			<ul>
<?php 			foreach($cont as $key => $val) { ?>
				<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
					if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $this->user_skin->tooltipAndAccesskey($val['id']) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div>
	<?php } ?>

	<div class="portlet" id="p-tb">
		<h5><?php $this->msg('toolbox') ?></h5>
		<div class="pBody">
			<ul>
<?php
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"<?php echo $this->user_skin->tooltipAndAccesskey('t-whatlinkshere') ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"<?php echo $this->user_skin->tooltipAndAccesskey('t-recentchangeslinked') ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 		}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"<?php echo $this->user_skin->tooltipAndAccesskey('t-trackbacklink') ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
		if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
					?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
					echo htmlspecialchars($feed['href']) ?>"<?php echo $this->user_skin->tooltipAndAccesskey('feed-'.$key) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
					<?php } ?></li><?php
		}

		foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) {
				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"<?php echo $this->user_skin->tooltipAndAccesskey('t-'.$special) ?>><?php $this->msg($special) ?></a></li>
<?php		}
		}

		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>"<?php echo $this->user_skin->tooltipAndAccesskey('t-print') ?>><?php $this->msg('printableversion') ?></a></li><?php
		}

		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"<?php echo $this->user_skin->tooltipAndAccesskey('t-permalink') ?>><?php $this->msg('permalink') ?></a></li><?php
		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"<?php echo $this->user_skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
		}

		wfRunHooks( 'MonoBookTemplateToolboxEnd', array( &$this ) );
?>
			</ul>
		</div>
	<!--  </div>   (close column-one -->
<?php
		if( $this->data['language_urls'] ) { ?>
	<div id="p-lang" class="portlet">
		<h5><?php $this->msg('otherlanguages') ?></h5>
		<div class="pBody">
			<ul>
<?php		foreach($this->data['language_urls'] as $langlink) { ?>
				<li class="<?php echo htmlspecialchars($langlink['class'])?>"><?php
				?><a href="<?php echo htmlspecialchars($langlink['href']) ?>"><?php echo $langlink['text'] ?></a></li>
<?php		} ?>
			</ul>
		</div>
	</div>
<?php	} ?>
		</div><!-- end of the left (by default at least) column -->
			<div class="visualClear"></div>
			<div id="footer">
<?php
		if($this->data['poweredbyico']) { ?>
				<div id="f-poweredbyico"><?php $this->html('poweredbyico') ?></div>
<?php 	}
		if($this->data['copyrightico']) { ?>
				<div id="f-copyrightico"><?php $this->html('copyrightico') ?></div>
<?php	}

		// Generate additional footer links
?>
			<ul id="f-list">
<?php
		$footerlinks = array(
			'lastmod', 'viewcount', 'numberofwatchingusers', 'credits', 'copyright',
			'privacy', 'about', 'disclaimer', 'tagline',
		);
		foreach( $footerlinks as $aLink ) {
			if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
<?php 		}
		}
?>
			</ul>
		</div>
		
	<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
</div>
<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>

-->
<?php endif; ?>
</body><?php
	wfRestoreWarnings();
	} // end of execute() method

	function get_head_html(){		
		?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php 
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>		
		<style type="text/css" media="screen, projection">/*<![CDATA[*/			
			@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/style.css";
		/*]]>*/</style>			
						
		<!--[if lt IE 7]>
			<link rel="stylesheet" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/ie_styles.css" type="text/css" media="screen" />
		<![endif]-->

		<!--[if lt IE 7]><script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
		<meta http-equiv="imagetoolbar" content="no" /><![endif]-->
		
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>
                
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
<?php	if($this->data['jsvarurl'  ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss'   ]) { ?>
		<style type="text/css"><?php $this->html('pagecss'   ) ?></style>
<?php	}
		if($this->data['usercss'   ]) { ?>
		<style type="text/css"><?php $this->html('usercss'   ) ?></style>
<?php	}
		if($this->data['userjs'    ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
		<!-- Head Scripts -->
<?php $this->html('headscripts') ?>
	</head>	
	<?php
	}
	function get_footer_html(){
		?>
		</html>
		<?php
	}
	
} // end of class
?>
