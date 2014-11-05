<?php namespace WRTemplate;

/**
 * Exibe uma tabela de dados, lista de dados vindo de consulta a banco
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class TabelaDados{
	
	/**
	 * TRUE para que a primeira coluna da tabela seja um checkbox para selecionar dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-29>
	 * @since 1.0
	 * @var boolean $bolSelecionavel
	 */
	private $bolSelecionavel = FALSE;
	
	/**
	 * Array de strings com o cabecalho
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-29>
	 * @since 1.0
	 * @var string[] $arrCabecalho
	 */
	private $arrCabecalho;
	
	/**
	 * Valores (dados) da tabela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-29>
	 * @since 1.0
	 * @var string[] $arrValores
	 */
	private $arrValores;
	
	/**
	 * Construtor da classe
	 * 
	 * @param boolean $bolSelecionavel
	 * @param string[] $arrCabecalho
	 * @param string[] $arrValores
	 */
	public function __construct($bolSelecionavel = FALSE, array $arrCabecalho, array $arrValores = array()){
		$this->strNomeTela = $strNomeTela;
		$this->arrElementosDaTela = $arrElementosDaTela;
		$this->objConfiguracoes = $objConfiguracoes;
	}
	
}