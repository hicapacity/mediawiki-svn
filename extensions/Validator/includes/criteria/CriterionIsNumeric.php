<?php

/**
 * Parameter criterion stating that the value must be a number.
 * 
 * @since 0.4
 * 
 * @file CriterionIsNumeric.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionIsNumeric extends ItemParameterCriterion {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 */
	public function __construct(  ) {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value ) {
		return is_numeric( $value );
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validator_error_must_be_number', 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * @see ItemParameterCriterion::getListErrorMessage
	 */	
	protected function getListErrorMessage( Parameter $parameter, array $invalidItems ) {
		global $wgLang;
		return wfMsgExt( 'validator_list_error_must_be_number', 'parsemag', $wgLang->listToText( $invalidItems ), count( $invalidItems ) );
	}	
	
}