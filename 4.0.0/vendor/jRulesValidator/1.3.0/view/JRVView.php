<?php
namespace WRValidator;
use \WRFramework\FTemplate as FTemplate;

/**
 * Classe View do pacote jRulesValidator
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-26>
 * @package jRulesValidator
 * @subpackage view
 */
class JRVView{
	
	/**
	 * Referência do objeto da template
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-26>
	 * @since 1.0
	 * 
	 * @var FTemplate $objTpl Referência da template da aplicação para inserção dos js e css
	 */
	private $objTpl = null;
	
	/**
	 * Construtor da classe que armazena o objeto da template
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-26>
	 * @since 1.0
	 * 
	 * @param FTemplate $objTpl Referência da template da aplicação para inserção dos js e css
	 */
	public function __construct(FTemplate &$objTpl) {
		$this->objTpl = $objTpl;
	}
	
	/**
	 * Função que carrega o jRulesValidator na tela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-26>
	 * @since 1.0
	 */
	public function initOnForm() {
		$strDir = dirname(__FILE__).'/../tpl/';
		
		$this->objTpl->addCssFile($strDir . 'css/jRulesValidator.css');
		//$this->objTpl->addJsFile($strDir . 'css/jRulesValidator.js');
	}
}