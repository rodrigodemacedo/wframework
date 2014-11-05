<?php namespace WRFramework;

/**
 * Fachada do pacote de validações WRValidate
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2014-06-22>
 * @package package\wrvalidator
 * @subpackage facade
 */
class WRValidatorFacade{
	
	/**
	 * Faz a inclusão das classes para serem usadas no sistema
	 */
	public function __construct(){
		$strDir = realpath(dirname(__FILE__).'/../source/').'/';
		
		require_once $strDir.'WRValidatorException.php';
		require_once $strDir.'WRValidatorObject.php';
		require_once $strDir.'WRValidatorRules.php';
		require_once $strDir.'WRValidatorRun.php';
		require_once $strDir.'WRValidatorUtils.php';
	}
}