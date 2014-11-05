<?php namespace WRTemplate;

/**
 * Painel duplo de elementos
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class PainelDuplo extends Container{
	
	/**
	 * Objeto com o painel esquerdo
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Painel $strTituloEsquerda
	 */
	public $objPainelEsquerdo;
	
	/**
	 * Objeto com o painel direito
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Painel $strTituloDireito
	 */
	public $objPainelDireito;
	
	/**
	 * Construtor da classe
	 * 
	 * @param Painel $objPainelEsquerdo
	 * @param Painel $objPainelDireito
	 */
	public function __construct(Painel $objPainelEsquerdo, Painel $objPainelDireito){
		$this->objPainelEsquerdo = $objPainelEsquerdo;
		$this->objPainelDireito = $objPainelDireito;
	}
	
}