<?php

/**
 * This file contains the /element/ class needed by xml2tree.php
 * to create a tree which is then converted into DocBook XML
 */

class element {
	var $name = '';
	var $attrs = array ();
	var $children = array ();
	
	# Temporary variables for link tags
	var $link_target = "" ;
	var $link_trail = "" ;
	var $link_parts = array () ;
	
	# Variables only used by $tree root
	var $list = array () ;
	var $opentags = array () ;
	var $sections = array () ;
	
	/**
	 * Parse the children ... why won't anybody think of the children?
	 */
	function sub_parse(& $tree) {
		$ret = '' ;
		$temp = "" ;
		foreach ($this->children as $key => $child) {
			if (is_string($child)) {
				$temp .= $child ;
			} elseif ($child->name != 'ATTRS') {
				$ret .= $this->add_temp_text ( $temp )  ;
				$sub = $child->parse ( $tree ) ;
				if ( $this->name == 'LINK' ) {
					if ( $child->name == 'TARGET' ) $this->link_target = $sub ;
					else if ( $child->name == 'PART' ) $this->link_parts[] = $sub ;
					else if ( $child->name == 'TRAIL' ) $this->link_trail = $sub ;
				}
				$ret .= $sub ;
			}
		}
		return $ret . $this->add_temp_text ( $temp ) ;
	}
	
	function fix_text ( $s ) {
		$s = html_entity_decode ( $s ) ;
		filter_named_entities ( $s ) ;
		$s = str_replace ( "&" , "&amp;" , $s ) ;
		return $s ;
	}
	
	function add_temp_text ( &$temp ) {
		$s = $temp ;
		$temp = "" ;
		return $this->fix_text ( $s ) ;
	}
	
	function ensure_new ( $tag , &$tree , $opttag = "" ) {
		if ( $opttag == "" ) { # Catching special case (currently, <section>)
			foreach ( $tree->opentags AS $o ) {
				if ( $o == $tag ) return "" ; # Already open
			}
		}
		array_push ( $tree->opentags , $tag ) ;
		if ( $opttag == "" ) return "<{$tag}>\n" ;
		else return $opttag ;
	}
	
	function close_last ( $tag , &$tree ) {
		$found = false ;
		foreach ( $tree->opentags AS $o ) {
			if ( $o == $tag ) $found = true ;
		}
		if ( !$found ) return "" ; # Already closed
		$ret = "\n" ;
		while ( 1 ) {
			$o = array_pop ( $tree->opentags ) ;
			$ret .= "</{$o}>\n" ;
			if ( $o == $tag ) return $ret ;
		}
	}
	
	function handle_link ( &$tree ) {
		global $content_provider ;
		$ret = "" ;
		$sub = $this->sub_parse ( $tree ) ;
		$link = "" ;
		if ( isset ( $this->attrs['TYPE'] ) AND strtolower ( $this->attrs['TYPE'] ) == 'external' ) {
			#if ( $sub != "" ) $link .= $sub . " " ;
			#    <ulink url="http://www.ora.com/catalog/tex/"><citetitle>Making TeXWork</citetitle></ulink>
			$href = $this->attrs['HREF'] ;
			if ( trim ( $sub ) == "" ) {
				$sub = $href ;
				$sub = explode ( '://' , $sub , 2 ) ;
				$sub = explode ( '/' , array_pop ( $sub ) , 2 ) ;
				$sub = array_shift ( $sub ) ;
			}
			$link = "<ulink url=\"{$href}\"><citetitle>{$sub}</citetitle></ulink>" ;
			#$link .= '[' . $this->attrs['HREF'] . ']' ;
		} else {
			if ( count ( $this->link_parts ) > 0 ) $link = array_pop ( $this->link_parts ) ;
			$link_text = $link ;
			if ( $link == "" ) $link = $this->link_target ;
			$link .= $this->link_trail ;
			
			$ns = $content_provider->get_namespace_id ( $this->link_target ) ;
			
			
			if ( $ns == 6 ) { # Surround image text with newlines
				$nstext = explode ( ":" , $this->link_target , 2 ) ;
				$nstext = array_shift ( $nstext ) ;
				$link = "(" . $nstext . ":" . $link . ")" ;
			} else if ( $ns == -9 ) { # Adding space to interlanguage link
				$sub = $this->link_target ;
				$nstext = explode ( ":" , $sub , 2 ) ;
				$name = array_pop ( $nstext ) ;
				$nstext = array_shift ( $nstext ) ;

				$href = "http://{$nstext}.wikipedia.org/wiki/" . urlencode ( $name ) ;
				$link = "<ulink url=\"{$href}\"><citetitle>{$sub}</citetitle></ulink>" ;

				#$link = $link . " " ;
			} else if ( $ns == -8 ) { # Adding newline to category link
				if ( $link_text == "!" || $link_text == '*' ) $link = "" ;
				else $link = " ({$link})" ;
				$link = "" . $this->link_target . $link . "" ;
			} else {
				$link = "<literal>{$link}</literal>" ;
			}
		}
		$ret .= $link ;
		return $this->fix_text ( $ret ) ;
	}
	
	/* 
	 * Parse the tag
	 */
	function parse ( &$tree ) {
		global $content_provider ;
		$ret = '';
		$tag = $this->name ;
		$close_emphasis = false ;
		
		if ( $tag == 'SPACE' ) {
			return ' ' ; # Speedup
		} else if ( $tag == 'ARTICLES' ) {
			# dummy, to prevent default action to be called
		} else if ( $tag == 'ARTICLE' ) {
			$ret .= "<article>\n";
			$header = "" ;
			if ( isset ( $this->attrs["TITLE"] ) ) {
				$title = $this->attrs["TITLE"] ;
				$ret .= "<title>" . $title . "</title>\n" ;
			}
			if ( $header != "" ) {
				$ret .= "<artheader>\n" . $header . "</artheader>\n";
			}
		} else if ( $tag == 'LINK' ) {
			return $this->handle_link ( $tree ) ; # Shortcut
		} else if ( $tag == 'HEADING' ) {
			$level = count ( $tree->sections ) ;
			$wanted = $this->attrs["LEVEL"] ;
			$ret .= $this->close_last ( "para" , $tree ) ;
			while ( $level >= $wanted ) {
				$x = array_pop ( $tree->sections ) ;
				if ( $x == 1 ) {
					$ret .= $this->close_last ( "section" , $tree ) ;
				}
				$level-- ;
			}
			while ( $level < $wanted ) {
				$level++ ;
				if ( $level < $wanted ) {
					array_push ( $tree->sections , 0 ) ;
				} else {
					$ret .= $this->ensure_new ( "section" , $tree , "<section>" ) ;
					array_push ( $tree->sections , 1 ) ;
				}
			}
			$ret .= "<title>" ;
		} else if ( $tag == 'PARAGRAPH' ) {
			$ret .= $this->close_last ( "para" , $tree ) ;
			$ret .= $this->ensure_new ( "para" , $tree ) ;
		} else if ( $tag == 'LIST' ) {
			$ret .= $this->close_last ( "para" , $tree ) ;
			$list_type = strtolower ( $this->attrs['TYPE'] ) ;
			if ( $list_type == 'bullet' || $list_type == 'ident' ) $ret .= '<itemizedlist mark="opencircle">' ;
			else if ( $list_type == 'numbered' ) $ret .= '<orderedlist numeration="arabic">' ;
		} else if ( $tag == 'LISTITEM' ) {
			$ret .= $this->close_last ( "para" , $tree ) ;
			$ret .= "<listitem>\n" ;
			$ret .= $this->ensure_new ( "para" , $tree ) ;
		} else if ( $tag == 'BOLD' || $tag == 'XHTML:STRONG' || $tag == 'XHTML:B' ) {
			$ret .= $this->ensure_new ( "para" , $tree ) ;
			$ret .= '<emphasis role="bold">' ;
			$close_emphasis = true ;
		} else if ( $tag == 'ITALICS' || $tag == 'XHTML:EM' || $tag == 'XHTML:I' ) {
			$ret .= $this->ensure_new ( "para" , $tree ) ;
			$ret .= '<emphasis>' ;
			$close_emphasis = true ;
		} else { # Default : normal text
			$ret .= $this->ensure_new ( "para" , $tree ) ;
		}
		
		# Get the sub-items
		$ret .= $this->sub_parse ( $tree ) ;
		
		if ( $tag == 'LIST' ) {
			$ret .= $this->close_last ( "para" , $tree ) ;
			if ( $list_type == 'bullet' || $list_type == 'ident' ) $ret .= "</itemizedlist>\n" ;
			else if ( $list_type == 'numbered' ) $ret .= "</orderedlist>\n" ;
		} else if ( $tag == 'LISTITEM' ) {
			$ret .= $this->close_last ( "para" , $tree ) ;
			$ret .= "</listitem>\n" ;
		} else if ( $close_emphasis ) {
			$ret .= '</emphasis>' ;
		} else if ( $tag == 'HEADING' ) {
			$ret .= "</title>\n" ;
		} else if ( $tag == 'ARTICLE' ) {
			$ret .= $this->close_last ( "section" , $tree ) ;
			$ret .= $this->close_last ( "para" , $tree ) ;
			$ret .= "</article>";
		}
		
		return $ret;
	}
}

require_once ( "./xml2tree.php" ) ; # Uses the "element" class defined above

?>
