<?php
namespace WRValidator;
use \WRFramework\FIncludeHelper as FInclude;

/**
 * Classe que inicia a chamada do jRulesValidator
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-26>
 * @package jRulesValidator
 * @subpackage facade
 */
class JRVFacade{
	
	/**
	 * Método que carrega o jRulesValidator na tela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-26>
	 * @since 1.0
	 * 
	 * @param FTemplate $objTpl Referência da template da aplicação para inserção dos js e css
	 */
	public function initOnForm(\WRFramework\FTemplate &$objTpl) {
		FInclude::loadClass('fwPackage.jRulesValidator.view.JRV');
		$objView = new JRVView($objTpl);
		$objView->initOnForm();
	}
	
	/**
	 * Obt�m a classe de validação de dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-09>
	 * @since 1.0
	 * 
	 * @param array $arrRules Regras para efetuar a validação
	 * @param string $strLanguage Informa o idioma que o jRulesValidator operar�
	 * 
	 * @return JRValidator Classe que executa a validação dos dados
	 */
	public function getValidator($arrRules, $strLanguage = 'ptbr') {
		//carregar o idioma
		FInclude::loadClass('fwPackage.jRulesValidator.class.JRValidator');
		return new JRValidator($arrRules, $strLanguage);
	}
}