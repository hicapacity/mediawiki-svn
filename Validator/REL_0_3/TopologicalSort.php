<?php

/**
 * Sorts a series of dependency pairs in linear order.
 *
 * Based on http://blog.metafoundry.com/2007/09/topological-sort-in-php.html
 *
 * usage:
 * $t = new TopologicalSort($dependency_pairs);
 * $load_order = $t->doSort();
 *
 * where dependency_pairs is in the form:
 * $name => (depends on) $value
 * 
 * @author Eddie Haber
 * @author Jeroen De Dauw
 * 
 * TODO: fix conventions further
 * TODO: include/load class
 * TODO: Use in revised version of Validator class
 */
class TopologicalSort {
	
	private $nodes = array();
	private $nodeNames = array();
	
	/**
	 * Dependency pairs are a list of arrays in the form
	 * $name => $val where $key must come before $val in load order.
	 */
	function TopologicalSort( $dependencies = array(), $parse = true ) {
		$this->nodeNames = array_keys( $dependencies );
		
		if ( $parse ) {
			$dependencies = $this->parseDependencyList( $dependencies );
		}
		
		// turn pairs into double-linked node tree
		foreach ( $dependencies as $key => $dpair ) {
			list ( $module, $dependency ) = each ( $dpair );
			if ( !isset( $this->nodes[$module] ) ) $this->nodes[$module] = new TSNode( $module );
			if ( !isset( $this->nodes[$dependency] ) ) $this->nodes[$dependency] = new TSNode( $dependency );
			if ( !in_array( $dependency, $this->nodes[$module]->children ) ) $this->nodes[$module]->children[] = $dependency;
			if ( !in_array( $module, $this->nodes[$dependency]->parents ) ) $this->nodes[$dependency]->parents[] = $module;
		}
	}
	
	/**
	 * Perform Topological Sort.
	 *
	 * @return sorted array
	 */
	public function doSort() {
		$nodes = $this->nodes;
			
		// get nodes without parents
		$root_nodes = array_values( $this->getRootNodes( $nodes ) );
		
		// begin algorithm
		$sorted = array();
		while ( count( $nodes ) > 0 ) {
			// check for circular reference
			if ( count( $root_nodes ) == 0 ) return false;
				
				
			// remove this node from root_nodes
			// and add it to the output
			$n = array_pop( $root_nodes );
			$sorted[] = $n->name;
			
			// for each of its  children
			// queue the new node finally remove the original
			for ( $i = count( $n->children ) - 1; $i >= 0; $i -- ) {
				$childnode = $n->children[$i];
				// remove the link from this node to its
				// children ($nodes[$n->name]->children[$i]) AND
				// remove the link from each child to this
				// parent ($nodes[$childnode]->parents[?]) THEN
				// remove this child from this node
				unset( $nodes[$n->name]->children[$i] );
				$parent_position = array_search ( $n->name, $nodes[$childnode]->parents );
				unset( $nodes[$childnode]->parents[$parent_position] );
				// check if this child has other parents
				// if not, add it to the root nodes list
				if ( !count( $nodes[$childnode]->parents ) ) {
					array_push( $root_nodes, $nodes [$childnode] );
				}
			}
			
			// nodes.Remove(n);
			unset( $nodes[$n->name] );
		}
		
		$looseNodes = array();

		// Return the result with the loose nodes (items with no dependencies) appended.
		foreach( $this->nodeNames as $name ) {
			if ( !in_array( $name, $sorted ) ) {
				$looseNodes[] = $name;
			}
		}
		
		return array_merge( $sorted, $looseNodes );
	}
	
	/**
	 * Returns a list of node objects that do not have parents
	 *
	 * @param array $nodes array of node objects
	 * 
	 * @return array of node objects
	 */
	private function getRootNodes( array $nodes ) {
		$output = array ();
		
		foreach ( $nodes as $name => $node ) {
			if ( !count ( $node->parents ) ) {
				$output[$name] = $node;
			}
		}
				
		return $output;
	}
	
	/**
	 * Parses an array of dependencies into an array of dependency pairs
	 *
	 * The array of dependencies would be in the form:
	 * $dependency_list = array(
	 *  "name" => array("dependency1","dependency2","dependency3"),
	 *  "name2" => array("dependencyA","dependencyB","dependencyC"),
	 *  ...etc
	 * );
	 *
	 * @param array $dlist Array of dependency pairs for use as parameter in doSort method
	 * 
	 * @return array
	 */
	private function parseDependencyList( array $dlist = array() ) {
		$output = array();
		
		foreach ( $dlist as $name => $dependencies ) {
			foreach ( $dependencies as $d ) {
				array_push ( $output, array ( $d => $name ) );
			}
		}
			
		return $output;
	}
}

/**
 * Node class for Topological Sort Class
 */
class TSNode {
	public $name;
	public $children = array();
	public $parents = array();
	
	public function TSNode( $name = '' ) {
		$this->name = $name;
	}
}