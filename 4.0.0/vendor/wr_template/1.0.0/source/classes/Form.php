<?php namespace WRTemplate;

/**
 * Define um formulário
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class Form extends Container{
	
	/**
	 * Action
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strAction
	 */
	public $strAction;
	
	/**
	 * Target
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strTarget
	 */
	public $strTarget;
	
	/**
	 * Containers com os elementos da tela
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Container[] $arrContainers
	 */
	public $arrContainers = array();
	
	/**
	 * Função javascript que será executada antes da execução do form
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strJsPreEnvioPost
	 */
	public $strJsPreEnvioPost;
	
	/**
	 * Função javascript que será executada depois da execução do form
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strJsPosEnvioPost
	 */
	public $strJsPosEnvioPost;
	
	/**
	 * ShortCode dos botões de controle (submit, reset cancelar...)
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strBotoesControle
	 */
	public $strBotoesControle;
	
	/**
	 * Envio de função via AJAX ou envio normal
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
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
		
		//cabeçalho do form
		$strHTML  = Config::tabIdent($intTabIdent)."\r\n";
		$strHTML .= Config::tabIdent($intTabIdent)."<!-- FORM_INIT -->\r\n";
		$strHTML .= Config::tabIdent($intTabIdent)."<form class=\"".(($this->bolEnvioViaAjax)?"formEnvioAutomatico":"")."\" action=\"{$this->strAction}\"  target=\"{$this->strTarget}\">\r\n";
		
		//pré e pós js
		if(!empty($this->strJsPreEnvioPost))
			$strHTML .= "<input type=\"hidden\" value=\"{$this->strJsPreEnvioPost}\" class=\"__comumjs_submit_preValidacao\">\r\n";
		
		if(!empty($this->strJsPosEnvioPost))
			$strHTML .= "<input type=\"hidden\" value=\"{$this->strJsPosEnvioPost}\" class=\"__comumjs_submit_posValidacao\">\r\n";
		
		//elementos internos
		$arrCtn = $this->arrContainers; 
		if(!empty($arrCtn)){
			//verifica se todos os elementos são filhos desta classe
			self::isContainer($arrCtn);
			
			//renderiza os containers
			foreach ($arrCtn as $objContainer) {
				$strHTML .= $objContainer->render($intTabIdent+1);
			}
		}
		
		//inclusão dos botões de controle
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