<?php namespace WRFramework;
/**
 * Classe view que organiza os dados que v�o para a GUI e depois para a template da aplicação (Revisar como as views ser�o ap�s a mudan�a nas templates)
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-15>
 * @package core
 * @subpackage view
 */
class FCoreView extends FTemplateController{
	
	/**
	 * Avisa na tela que o modo debug est� ativo
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param array $arrConfig configurações que ser�o usadas
	 */
	public static function showDebugModeOn(){
		//colocar a marca do "Debug Mode"
		parent::getObjTemplate()->setHtmlContent('<div class="wrf_debugModeOn" style="text-align: center; font-size: 16px; background-color: #CE0; padding: 5px">:: DEBUG MODE ON ::</div>');
	}
	
	/**
	 * Exibe uma mensagem javascript do tipo alert() e vai para alguma p�gina
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-21>
	 * @since 1.0
	 * 
	 * @param string $strMessage Mensagem a ser exibida
	 * @param string $strAction Action Ação da Fa�ade para onde o sistema ir� ou link completo caso <code>$bolExternalUrl</code> for true
	 * @param boolean $bolExternalUrl Mensagem a ser exibida
	 * @param string $strFacade Mensagem a ser exibida
	 */
	public static function alertMsgAndGoTo($strMessage, $strAction, $bolExternalUrl = FALSE, $strFacade = '') {
		parent::alertMsgAndGoTo($strMessage, $strAction, $bolExternalUrl, $strFacade);
	}
}