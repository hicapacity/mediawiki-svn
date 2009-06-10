<?php
/**
 * Internationalisation for Usability Initiative Editing Toolbar extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Trevor Parscal
 */
$messages['en'] = array(
	'edittoolbar' => 'Editing Toolbar',
	'edittoolbar-desc' => 'Edit page toolbar with enhanced usability',
	'edittoolbar-preference' => 'Enable enhanced editing toolbar',
	/* Main Section */
	'edittoolbar-tool-format-bold' => 'Bold',
	'edittoolbar-tool-format-bold-example' => 'Bold text',
	'edittoolbar-tool-format-italic' => 'Italic',
	'edittoolbar-tool-format-italic-example' => 'Italic text',
	'edittoolbar-tool-insert-ilink' => 'Internal link',
	'edittoolbar-tool-insert-ilink-example' => 'Link title',
	'edittoolbar-tool-insert-xlink' => 'External link (remember http:// prefix)',
	'edittoolbar-tool-insert-xlink-example' => 'http://www.example.com link title',
	'edittoolbar-tool-insert-file' => 'Embedded file',
	'edittoolbar-tool-insert-file-pre' => '$1File:',
	'edittoolbar-tool-insert-file-example' => 'Example.jpg',
	'edittoolbar-tool-insert-reference' => 'Reference',
	'edittoolbar-tool-insert-reference-example' => 'Insert footnote text here',
	'edittoolbar-tool-insert-signature' => 'Signature and timestamp',
	/* Formatting Section */
	'edittoolbar-section-format' => 'Format',
	'edittoolbar-tool-format-heading' => 'Heading',
	'edittoolbar-tool-format-heading-1' => 'Level 1',
	'edittoolbar-tool-format-heading-2' => 'Level 2',
	'edittoolbar-tool-format-heading-3' => 'Level 3',
	'edittoolbar-tool-format-heading-4' => 'Level 4',
	'edittoolbar-tool-format-heading-5' => 'Level 5',
	'edittoolbar-tool-format-heading-example' => 'Heading text',
	'edittoolbar-group-format-list' => 'List',
	'edittoolbar-tool-format-ulist' => 'Bulleted list',
	'edittoolbar-tool-format-ulist-example' => 'Bulleted list item',
	'edittoolbar-tool-format-olist' => 'Numbered list',
	'edittoolbar-tool-format-olist-example' => 'Numbered list item',
	'edittoolbar-group-format-size' => 'Size',
	'edittoolbar-tool-format-big' => 'Big',
	'edittoolbar-tool-format-big-example' => 'Big text',
	'edittoolbar-tool-format-small' => 'Small',
	'edittoolbar-tool-format-small-example' => 'Small text',
	'edittoolbar-group-format-baseline' => 'Baseline',
	'edittoolbar-tool-format-superscript' => 'Superscript',
	'edittoolbar-tool-format-superscript-example' => 'Superscript text',
	'edittoolbar-tool-format-subscript' => 'Subscript',
	'edittoolbar-tool-format-subscript-example' => 'Subscript text',
	/* Insert Section */
	'edittoolbar-section-insert' => 'Insert',
	'edittoolbar-group-insert-media' => 'Media',
	'edittoolbar-tool-insert-gallery' => 'Picture gallery',
	'edittoolbar-tool-insert-gallery-example' => "File:Example.jpg|Caption1\File:Example.jpg|Caption2",
	'edittoolbar-tool-insert-newline' => 'New line',
	/* Special Characters Section */
	'edittoolbar-section-characters' => 'Special Characters',
	/* Help Section */
	'edittoolbar-section-help' => 'Help',
	'edittoolbar-help-heading-description' => 'Description',
	'edittoolbar-help-heading-syntax' => 'What you type',
	'edittoolbar-help-heading-result' => 'What you get',
	'edittoolbar-help-page-format' => 'Formatting',
	'edittoolbar-help-page-link' => 'Links',
	'edittoolbar-help-page-heading' => 'Headings',
	'edittoolbar-help-page-list' => 'Lists',
	'edittoolbar-help-page-file' => 'Files',
	'edittoolbar-help-page-reference' => 'References',
	'edittoolbar-help-page-discussion' => 'Discussion',
	'edittoolbar-help-content-bold-description' => 'Bold',
	'edittoolbar-help-content-bold-syntax' => "'''Bold text'''",
	'edittoolbar-help-content-bold-result' => '<strong>Bold text</strong>',
	'edittoolbar-help-content-italic-description' => 'Italic',
	'edittoolbar-help-content-italic-syntax' => "'''Italic text'''",
	'edittoolbar-help-content-italic-result' => '<em>Italic text</em>',
	'edittoolbar-help-content-bolditalic-description' => 'Bold &amp; italic',
	'edittoolbar-help-content-bolditalic-syntax' => "'''Bold &amp; italic text'''",
	'edittoolbar-help-content-bolditalic-result' => '<strong><em>Bold &amp; italic text</em></strong>',
	'edittoolbar-help-content-ilink-description' => 'Internal link',
	'edittoolbar-help-content-ilink-syntax' => '[[Page title|Internal link label]]',
	'edittoolbar-help-content-ilink-result' => "<a href='#'>Internal link label</a>",
	'edittoolbar-help-content-xlink-description' => 'External link',
	'edittoolbar-help-content-xlink-syntax' => '[http://www.domain.com External link label]',
	'edittoolbar-help-content-xlink-result' => "<a href='#'>External link label</a>",
	'edittoolbar-help-content-heading1-description' => '1st level heading',
	'edittoolbar-help-content-heading1-syntax' => '= Heading text =',
	'edittoolbar-help-content-heading1-result' => '<h1>Heading text</h1>',
	'edittoolbar-help-content-heading2-description' => '2nd level heading',
	'edittoolbar-help-content-heading2-syntax' => '== Heading text ==',
	'edittoolbar-help-content-heading2-result' => '<h2>Heading text</h2>',
	'edittoolbar-help-content-heading3-description' => '3rd level heading',
	'edittoolbar-help-content-heading3-syntax' => '=== Heading text ===',
	'edittoolbar-help-content-heading3-result' => '<h3>Heading text</h3>',
	'edittoolbar-help-content-heading4-description' => '4th level heading',
	'edittoolbar-help-content-heading4-syntax' => '==== Heading text ====',
	'edittoolbar-help-content-heading4-result' => '<h4>Heading text</h4>',
	'edittoolbar-help-content-heading5-description' => '5th level heading',
	'edittoolbar-help-content-heading5-syntax' => '===== Heading text =====',
	'edittoolbar-help-content-heading5-result' => '<h5>Heading text</h5>',
	'edittoolbar-help-content-ulist-description' => 'Bulleted list',
	'edittoolbar-help-content-ulist-syntax' => '* List item<br />* List item',
	'edittoolbar-help-content-ulist-result' => '<ul><li>List item</li><li>List item</li></ul>',
	'edittoolbar-help-content-olist-description' => 'Numbered list',
	'edittoolbar-help-content-olist-syntax' => '# List item',
	'edittoolbar-help-content-olist-result' => '<ol><li>List item</li><li>List item</li></ol>',
	'edittoolbar-help-content-file-description' => 'Embedded file',
	'edittoolbar-help-content-file-syntax' => '[[File:Wiki.png|thumb|Caption text]]',
	'edittoolbar-help-content-file-result' => "",
	'edittoolbar-help-content-reference-description' => 'Reference',
	'edittoolbar-help-content-reference-syntax' => 'Article text.&lt;ref name="test"&gt;[http://www.example.org Link text], additional text.&lt;/ref&gt;',
	'edittoolbar-help-content-reference-result' => "Aticle text <sup><a href='#'>[1]</a></sup>",
	'edittoolbar-help-content-rereference-description' => 'Additional use of same reference',
	'edittoolbar-help-content-rereference-syntax' => '&lt;ref name=\"test\" /&gt;',
	'edittoolbar-help-content-rereference-result' => "Aticle text <sup><a href='#'>[1]</a></sup>",
	'edittoolbar-help-content-showreferences-description' => 'Display references',
	'edittoolbar-help-content-showreferences-syntax' => '&lt;references /&gt; or {{Reflist}}',
	'edittoolbar-help-content-showreferences-result' => "<ol class='references'><li id='cite_note-test-0'><b><a title='' href='#'>^</a></b> <a rel='nofollow' title='http://www.example.org' class='external text' href='#'>Link text</a>, additional text.</li></ol>",
	'edittoolbar-help-content-signaturetimestamp-description' => 'Signature with timestamp',
	'edittoolbar-help-content-signaturetimestamp-syntax' => '~~~~',
	'edittoolbar-help-content-signaturetimestamp-result' => "<a href='#' title='Special:MyPage'>Username</a> (<a href='#' title='Special:MyTalk'>talk</a>) 15:54, 10 June 2009 (UTC)",
	'edittoolbar-help-content-signature-description' => 'Signature',
	'edittoolbar-help-content-signature-syntax' => '~~~',
	'edittoolbar-help-content-signature-result' => "<a href='#' title='Special:MyPage'>Username</a> (<a href='#' title='Special:MyTalk'>talk</a>)</p>",
	'edittoolbar-help-content-indent-description' => 'Indent',
	'edittoolbar-help-content-indent-syntax' => 'Normal text<br />:Indented text<br />::Indented text',
	'edittoolbar-help-content-indent-result' => 'Normal text<dl><dd>Indented text<dl><dd>Indented text</dd></dl></dd></dl>'
);
