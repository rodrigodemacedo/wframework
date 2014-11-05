<?php namespace WRTemplate;

/**
 * Cria uma linha para inserção de campos de formulário
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class FormLinha{
	
	/**
	 * Campos desta linha
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0.0
	 * @var FormCampo[] $arrFormCampos
	 */
	private $arrFormCampos;
	
	/**
	 * Atributo ID da linha quando renderizar
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-09-13>
	 * @since 1.0.0
	 * @var string $strId
	 */
	private $strId;
	
	/**
	 * Construtor da classe
	 * 
	 * @param mix $arrFormCampos - Pode ser um array de campos ou somente um campo sem ser array
	 */
	public function __construct($arrFormCampos, $strId = ''){
		if(!is_array($arrFormCampos)){
			$this->arrFormCampos = array($arrFormCampos);
		}else{
			$this->arrFormCampos = $arrFormCampos;
		}
		
		$this->strId = $strId;
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
	
	/**
	 * Renderiza o objeto transformando-o em códigos HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function render($intTabIdent){
		$strHtml  = "\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."<!-- LINHA_INIT -->\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."<div class=\"linha\"".(($this->strId != '')?' id="'.$this->strId.'"':'').">\r\n";
		
		$arrElmts = $this->arrFormCampos;
		if(!empty($arrElmts)){
			foreach ($arrElmts as $objObjeto) {
				if(get_class($objObjeto) != 'WRTemplate\FormCampo'){
					throw new Exception(6015, get_class($objObjeto));
				}
					
				$strHtml .= $objObjeto->render($intTabIdent+1);
			}
		}
		
		$strHtml .= Config::tabIdent($intTabIdent)."\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."	<div class=\"clear\"></div>\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."</div> <!-- LINHA_FIM -->\r\n\n";
		
		return $strHtml;
	}
	
}