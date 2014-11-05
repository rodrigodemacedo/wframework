<?php namespace WRTemplate;

/**
 * Define um formul�rio
 *
 * @author Rodrigo de Mac�do Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class Form extends Container{
	
	/**
	 * Action
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strAction
	 */
	public $strAction;
	
	/**
	 * Target
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strTarget
	 */
	public $strTarget;
	
	/**
	 * Containers com os elementos da tela
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Container[] $arrContainers
	 */
	public $arrContainers = array();
	
	/**
	 * Fun��o javascript que ser� executada antes da execu��o do form
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strJsPreEnvioPost
	 */
	public $strJsPreEnvioPost;
	
	/**
	 * Fun��o javascript que ser� executada depois da execu��o do form
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strJsPosEnvioPost
	 */
	public $strJsPosEnvioPost;
	
	/**
	 * ShortCode dos bot�es de controle (submit, reset cancelar...)
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strBotoesControle
	 */
	public $strBotoesControle;
	
	/**
	 * Envio de fun��o via AJAX ou envio normal
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $bolEnvioViaAjax
	 */
	public $bolEnvioViaAjax = TRUE;
	
	/**
	 * Construtor da classe
	 * 
	 * @param string $strAction
	 * @param array $arrContainers
	 * @param string $strJsPreEnvioPost
	 * @param string $strJsPosEnvioPost
	 */
	public function __construct($strAction, array $arrContainers = array(), $strJsPreEnvioPost, $strJsPosEnvioPost, $strBotoesControle, $bolEnvioViaAjax = TRUE, $strTarget = ''){
		$this->strAction = $strAction;
		$this->setContainers($arrContainers);
		$this->strJsPreEnvioPost = $strJsPreEnvioPost;
		$this->strJsPosEnvioPost = $strJsPosEnvioPost;
		$this->bolEnvioViaAjax = $bolEnvioViaAjax;
		$this->strBotoesControle = $strBotoesControle;
		$this->strTarget = $strTarget;
	}
	

	private function setContainers(array $arrObjContainers = array()){
		if(!empty($arrObjContainers)){
			foreach ($arrObjContainers as $objContainer) {
				if(!is_subclass_of($objContainer, 'WRTemplate\Container'))
					throw new Exception(6013, get_class($objContainer));
			}
		}
		$this->arrContainers = $arrObjContainers;
	}
	
	//
	// RENDERIZA��O DESTA CLASSE
	//
	
	/**
	 * Renderiza o objeto transformando-o em c�digos HTML
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 */
	public function render($intTabIdent){
		
		//cabe�alho do form
		$strHTML  = Config::tabIdent($intTabIdent)."\r\n";
		$strHTML .= Config::tabIdent($intTabIdent)."<!-- FORM_INIT -->\r\n";
		$strHTML .= Config::tabIdent($intTabIdent)."<form class=\"".(($this->bolEnvioViaAjax)?"formEnvioAutomatico":"")."\" action=\"{$this->strAction}\"  target=\"{$this->strTarget}\">\r\n";
		
		//pr� e p�s js
		if(!empty($this->strJsPreEnvioPost))
			$strHTML .= "<input type=\"hidden\" value=\"{$this->strJsPreEnvioPost}\" class=\"__comumjs_submit_preValidacao\">\r\n";
		
		if(!empty($this->strJsPosEnvioPost))
			$strHTML .= "<input type=\"hidden\" value=\"{$this->strJsPosEnvioPost}\" class=\"__comumjs_submit_posValidacao\">\r\n";
		
		//elementos internos
		$arrCtn = $this->arrContainers; 
		if(!empty($arrCtn)){
			//verifica se todos os elementos s�o filhos desta classe
			self::isContainer($arrCtn);
			
			//renderiza os containers
			foreach ($arrCtn as $objContainer) {
				$strHTML .= $objContainer->render($intTabIdent+1);
			}
		}
		
		//inclus�o dos bot�es de controle
		if(!empty($this->strBotoesControle)){
			$arrBotoes = array();
			foreach ($this->strBotoesControle as $strBotao) 
				$arrBotoes[] = HTML::_($strBotao);
			
			$objLinha = new FormLinha(array(new FormCampo("", FormCampo::TAMANHO_RESTANTE, $arrBotoes)));
			
			$strHTML .= $objLinha->render($intTabIdent+1);
		}
		
		//fechamento do form
		$strHTML .= Config::tabIdent($intTabIdent)."\r\n";
		$strHTML .= Config::tabIdent($intTabIdent)."</form> <!-- FORM_FIM -->\r\n";
		
		return $strHTML;
	}
	
}