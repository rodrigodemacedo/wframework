<?php namespace WRTemplate;

/**
 * Classe respons�vel por iniciar todo o processo de cria��o da tela
 *
 * @author Rodrigo de Mac�do Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class Tela{
	
	/**
	 * Nome da Tela
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strNomeTela
	 */
	private $strNomeTela;
	
	/**
	 * Defini��es de configura��es
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Config $objConfiguracoes
	 */
	private $objConfig;
	
	/**
	 * Conjunto de todos containers da tela
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
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
	 * Retorna o nome da tela que ser� exibido
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
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
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function getContainers(){
		return $this->arrElementosDaTela;
	}
	
	/**
	 * Depois da tela montda e os elementos inseridos, chama-se este m�todo de renderiza��o da tela para que ela seja convertida em HTML
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function render(){
		RenderTela::render($this);
	}
	
}