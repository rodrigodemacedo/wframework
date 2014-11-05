<?php namespace WRTemplate;

/**
 * Painel de elementos
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class Painel extends Container{
	
	/**
	 * Atributo ID do painel
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 * @var string $strId
	 */
	public $strId;
	
	
	/**
	 * Título do painel
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strNomeTela
	 */
	public $strTitulo;
	
	/**
	 * Conjunto de todos os elementos do painel
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Object[] $arrElementos
	 */
	public $arrElementos;
	
	/**
	 * Construtor da classe
	 * 
	 * @param string $strNomeTela
	 * @param Object[] $arrElementos
	 */
	public function __construct($strTitulo, array $arrElementos = array(), $strId = ''){
		$this->strTitulo = $strTitulo;
		$this->arrElementos = $arrElementos;
		$this->strId = $strId;
	}
	
	//
	// RENDERIZAÇÃO DESTA CLASSE
	//
	
	/**
	 * Renderiza o objeto transformando-o em códigos HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function render($intTabIdent){
		$strHtml  = Config::tabIdent($intTabIdent+0)."\r\n";
		$strHtml .= Config::tabIdent($intTabIdent+0)."<!-- PAINEL_INIT -->\r\n";
		$strHtml .= Config::tabIdent($intTabIdent+0)."<div".((!empty($this->strId))?' id="'.$this->strId.'"':'').">\r\n";
		$strHtml .= Config::tabIdent($intTabIdent+1)."<br />\r\n";
		$strHtml .= Config::tabIdent($intTabIdent+1)."<h3 class=\"sep-title\">» {$this->strTitulo}</h3>\r\n";
					
		$arrElmts = $this->arrElementos;
		if(!empty($arrElmts)){
			foreach ($arrElmts as $objObjeto) {
				if((!is_subclass_of($objObjeto, 'WRTemplate\Object')) && (!get_class($objObjeto)))
					throw new Exception(6014, get_class($objObjeto));
					
				$strHtml .= $objObjeto->render($intTabIdent+1);
			}
		}
		
		$strHtml .= Config::tabIdent($intTabIdent+0)."</div> <!-- PAINEL_FIM -->\r\n";
		
		return $strHtml;
	}
	
}