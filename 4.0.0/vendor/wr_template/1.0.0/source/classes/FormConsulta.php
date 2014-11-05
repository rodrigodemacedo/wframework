<?php namespace WRTemplate;

/**
 * Cria um formulário para ser usado em filtros para relatórios
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class FormConsulta{
	
	/**
	 * Campos desta linha
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0.0
	 * @var FormCampo[] $arrFormCampos
	 */
	public $arrFormCampos;
	
	/**
	 * Construtor da classe
	 * 
	 * @param array $arrFormCampos
	 */
	public function __construct(array $arrFormCampos){
		parent::__construct('[table .jTblPanelForm]');
		$this->arrFormCampos = $arrFormCampos;
		die(__FILE__.'::'.__LINE__);
	}
	
	/**
	 * Adiciona mais um campo na linha de campos
	 * 
	 * @access public
	 * @since 1.0.0
	 * @param FormCampo $objFormCampo
	 * @return FormLinha
	 */
	public function addCampo(FormCampo $objFormCampo){
		$this->arrFormCampos[] = $objFormCampo;
		return $this;
	}
	
}