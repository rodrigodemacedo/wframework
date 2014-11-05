<?php namespace WRTemplate;

/**
 * Cria umcampo para ser inserido em uma linha (FormLinha)
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class FormCampo{
	
	//
	//
	//
	
	/**
	 * Use para informar que o tamanho do campo é o que restar do espaço da linha
	 * 
	 * @var int
	 */
	const TAMANHO_RESTANTE = 0;
	
	/**
	 * Campos desta linhaTamanho do campo
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0.0
	 * @var int $intTamanho
	 */
	public $intTamanho;
	
	/**
	 * Label do campo
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0.0
	 * @var string $strLabel
	 */
	public $strLabel;
	
	/**
	 * Campos desta linha
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0.0
	 * @var mixed $arrObjetos Pode vir um objeto Object ou um array de objetos
	 */
	public $arrObjetos = array();
	
	/**
	 * Construtor da classe
	 * 
	 * @param string $strLabel
	 * @param int $intTamanho
	 * @param Object[] $arrObjetos
	 */
	public function __construct($strLabel, $intTamanho, $arrObjetos){
		$this->strLabel = $strLabel;
		$this->intTamanho = $intTamanho;
		if(!is_array($arrObjetos)){
			$this->arrObjetos[] = $arrObjetos;
		}else{
			$this->arrObjetos = $arrObjetos;
		}
	}
	
	/**
	 * Renderiza o objeto transformando-o em códigos HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function render($intTabIdent){
		$intTamanho = ($this->intTamanho == self::TAMANHO_RESTANTE)?'x':$this->intTamanho;
		$strHtml  = "\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."<!-- CAMPO_INIT -->\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."<div class=\"campo tamanho{$intTamanho}\">\r\n";
		
		if(!empty($this->strLabel))
			$strHtml .= Config::tabIdent($intTabIdent+1)."<label>{$this->strLabel}</label>\r\n";
		
		$arrElmts = $this->arrObjetos;
		if(!empty($arrElmts)){
			foreach ($arrElmts as $mixObjeto) {
				//$mixObjeto pode ser um Object ou um Array
				if(is_array($mixObjeto)){
					foreach ($mixObjeto as $objObjeto) {
						if(get_class($objObjeto) != 'WRTemplate\Object')
							throw new Exception(6016, get_class($objObjeto));
						
						$strHtml .= $objObjeto->render($intTabIdent+1);
					}
				}else{
					if((!is_object($mixObjeto)) || (get_class($mixObjeto) != 'WRTemplate\Object'))
						throw new Exception(6016, (is_object($mixObjeto)?get_class($mixObjeto):gettype($mixObjeto)));
					
					$strHtml .= $mixObjeto->render($intTabIdent+1);
				}
			}
		}
		
		$strHtml .= Config::tabIdent($intTabIdent)."</div> <!-- CAMPO_FIM -->\r\n";
		
		return $strHtml;
	}
	
}