<?php namespace WRTemplate;

/**
 * Criador de Objetos HTML
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class HTML extends Object{
	
	public static function _($strElementSmartCode, array $arrAttributes = array(), array $arrChildObjects = array()){
		$objCreate = new Object();
		
		$objCreate->setSmartCode($strElementSmartCode);
		
		//definir a tag html do objeto
		SmartCodeParser::parseCodeTypes($objCreate);
		
		//definir os atributos definidos para o objeto
		SmartCodeParser::parseCodeAttr($objCreate, $arrAttributes);
		
		//em caso de criação de labels, retorna junto
		$objCreate = SmartCodeParser::labelsDetect($objCreate);
		
		foreach ($arrChildObjects as $objChild) 
			$objCreate->addChild($objChild);
		
		return $objCreate;
	}
}