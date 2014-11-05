<?php namespace WRTemplate;

/**
 * Classe responsável por iniciar todo o processo de criação da tela
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class Tela{
	
	/**
	 * Nome da Tela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strNomeTela
	 */
	private $strNomeTela;
	
	/**
	 * Definições de configurações
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Config $objConfiguracoes
	 */
	private $objConfig;
	
	/**
	 * Conjunto de todos containers da tela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Container[] $arrElementosDaTela
	 */
	private $arrElementosDaTela;
	
	/**
	 * Construtor da classe
	 * 
	 * @param string $strNomeTela
	 * @param Container[] $arrElementosDaTela
	 * @param Config $objConfiguracoes
	 */
	public function __construct($strNomeTela, array $arrElementosDaTela = array(), Config $objConfiguracoes = NULL ){
		$this->strNomeTela = $strNomeTela;
		$this->arrElementosDaTela = $arrElementosDaTela;
		$this->objConfig = $objConfiguracoes;
	}
	
	/**
	 * Retorna o nome da tela que será exibido
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function getNome(){
		return $this->strNomeTela;
	}
	
	/**
	 * Retorna os elementos da tela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function getContainers(){
		return $this->arrElementosDaTela;
	}
	
	/**
	 * Depois da tela montda e os elementos inseridos, chama-se este método de renderização da tela para que ela seja convertida em HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function render(){
		RenderTela::render($this);
	}
	
}