<?php

namespace WFramework\Controller;

/**
 * Classe que controla o objeto básico da template
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-18>
 * @package core
 * @subpackage controller
 */
class FTemplateController {
	
	/**
	 * Objeto que cont�m as informações básicas de uma template
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-18>
	 * @since 1.0
	 *       
	 * @var FTemplate
	 */
	private static $objTemplate;
	
	/**
	 * Instancia a classe com as informações básicas de uma template
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-18>
	 * @since 1.0
	 *       
	 */
	public static function init() {
		self::$objTemplate = new FTemplate ();
	}
	
	/**
	 * Obt�m o objeto básico da template para alterar as suas caracter�sticas
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-18>
	 * @since 1.0
	 *       
	 * @return FTemplate Objeto básico com as informações fundamentais da template
	 */
	public function getObjTemplate() {
		return self::$objTemplate;
	}
	
	/**
	 * Executa uma GUI e adiciona na template a ser usada
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-19>
	 * @since 1.0
	 *       
	 * @param string $strGuiPath
	 *        	Nome do arquivo com seu caminho a partir do diretório "gui" da template
	 * @param array $arrData
	 *        	Dados que ser�o passados para a gui
	 * @param boolean $bolReturnBuffer
	 *        	False (padrão) se for adicionar direto o processamento na template. True se for retornar o resultado do processamento para ser reprocessado.
	 * @param string $strForceContext
	 *        	Vazio (default) para pegar automaticamente o contexto da execução. Preencha com o contexto (backend,frontend) para for�ar o uso dele nos diretórios da template em execução
	 *        	
	 * @return void|string Não retorna nada se o <code>$bolReturnBuffer</code> for FALSE. Se for TRUE, retorna o resultado do processamento da GUI.
	 */
	public function execGui($strGuiPath, $arrData = array(), $bolReturnBuffer = FALSE, $strForceContext = '') {
		$strFullGuiPath = FConfig::getAppConfig ( 'base_dirActiveTemplate' );
		
		// verificar se foi solicitado a gui de um determinado ambiente
		if (empty ( $strForceContext )) {
			if (FConfig::getAppConfig ( 'sys_isBackend' ) === true) {
				$strFullGuiPath .= 'app-backend/gui/';
			} else {
				$strFullGuiPath .= 'app-frontend/gui/';
			}
		} else {
			switch ($strForceContext) {
				
				case "backend" :
				case "frontend" :
					$strFullGuiPath .= 'app-' . $strForceContext . '/gui/';
					
					break;
				
				case "fw" :
					
					break;
				
				default :
			}
		}
		
		// concatenar o diretório base com o fornecido para a "GUI" a ser aberta
		$strFullGuiPath .= $strGuiPath . '.tpl.php';
		
		// verificar se o arquivo a ser aberto existe
		if (! is_file ( $strFullGuiPath )) {
			FIncludeHelper::loadClass ( 'fw.core.exception.FTemplate' );
			throw new FTemplateException ( 'viewNotFound', array (
					'guiPath' => $strGuiPath,
					'fullGuiPath' => $strFullGuiPath 
			) );
		}
		
		// criar as variáveis somente se $arrVars realmente for um array
		if (is_array ( $arrData )) {
			// instanciar (criar) as variáveis do array
			foreach ( $arrData as $strVarName => $strVarValue ) {
				$$strVarName = $strVarValue;
			}
		}
		
		//
		// EXECUTA A GUI E GUARDA O BUFFER
		//
		
		// segurar o buffer
		ob_start ();
		// incluir o arquivo
		include $strFullGuiPath;
		// obter o buffer
		$strHtmlBuffer = ob_get_contents ();
		// encerra o buffer
		ob_end_clean ();
		
		// retornar ou definir no conte�do da template
		if ($bolReturnBuffer) {
			return $strHtmlBuffer;
		} else {
			$this->getObjTemplate ()->setHtmlContent ( $strHtmlBuffer );
		}
	}
	
	/**
	 * Exibe uma mensagem javascript do tipo alert() e vai para alguma p�gina
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-21>
	 * @since 1.0
	 *       
	 * @param string $strMessage
	 *        	Mensagem a ser exibida
	 * @param string $strAction
	 *        	Action Ação da Fa�ade para onde o sistema ir� ou link completo caso <code>$bolExternalUrl</code> for true
	 * @param boolean $bolExternalUrl
	 *        	Mensagem a ser exibida
	 * @param string $strFacade
	 *        	Mensagem a ser exibida
	 */
	public static function alertMsgAndGoTo($strMessage, $strAction = '', $bolExternalUrl = FALSE, $strFacade = '') {
		if ($bolExternalUrl == FALSE) {
			
			$strLink = FConfig::getAppConfig ( 'base_url' ) . '?';
			
			if ($strFacade != '') {
				$strLink .= '&' . FConfig::getAppConfig ( 'sys_facade' ) . '=' . $strFacade;
			}
			
			if ($strAction != '') {
				$strLink .= '&' . FConfig::getAppConfig ( 'sys_action' ) . '=' . $strAction;
			} else {
				$strLink .= '&' . FConfig::getAppConfig ( 'sys_action' ) . '=' . FConfig::getAppConfig ( 'sys_defaultAction' );
			}
		} else {
			$strLink = $strAction;
		}
		
		$strLink = str_replace ( '?&', '?', $strLink );
		
		self::getObjTemplate ()->addJsDeclaration ( '
			//alertMsgAndGoTo
			jQuery(function(){
				' . ((! empty ( $strMessage )) ? 'alert("' . $strMessage . '");' : '') . '
				window.location = "' . $strLink . '";
			});
		' );
	}
	
	/**
	 * Retorna uma url vinda do config juntamente com as urls que d�o destino � aplicação par ir para algum local.
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-02-14>
	 * @since 1.0
	 *       
	 * @param string $strPackage
	 *        	Nome do pacote onde a aplicação ir�
	 * @param string $strController
	 *        	Nome do controlador que processar� a requisição
	 * @param string $strAction
	 *        	Nome do action onde a aplicação executar�
	 * @param string $strConfigUrlVar
	 *        	Nome da entrada de configuração referente � URL que voc� usar� (opcional)
	 *        	
	 * @return string URL processada
	 */
	public static function generateMiniAppUrl($strPackage = false, $strController = false, $strAction = false, $strConfigUrlVar = false) {
		
		// configurar o controller
		if ($strController !== false) {
			$strController = $strController;
		} else {
			$strController = FConfig::getAppConfig ( 'sys_defaultController' );
		}
		$strActionLink = '&' . FConfig::getAppConfig ( 'sys_controller' ) . '=' . $strController;
		
		// configurar o package
		if ($strPackage !== false) {
			$strActionLink .= '&' . FConfig::getAppConfig ( 'sys_package' ) . '=' . $strPackage;
		} else {
			$strActionLink .= '&' . FConfig::getAppConfig ( 'sys_package' ) . '=' . $strController;
		}
		
		// configurar o action
		if ($strAction !== false) {
			$strActionLink .= '&' . FConfig::getAppConfig ( 'sys_action' ) . '=' . $strAction;
		} else {
			$strActionLink .= '&' . FConfig::getAppConfig ( 'sys_action' ) . '=' . FConfig::getAppConfig ( 'sys_defaultAction' );
		}
		
		// adicionar uma entrada no config para preceder na action
		if ($strConfigUrlVar !== false)
			$strActionLink = FConfig::getAppConfig ( $strConfigUrlVar ) . $strActionLink;
		
		return $strActionLink;
	}
	
	/**
	 * Retorna uma url vinda do config juntamente com as urls que dão destino a aplicação par ir para algum local.
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-02-14>
	 * @since 1.0
	 *       
	 * @param string $strAction
	 *        	Método da fachada que será executado
	 * @param string $strFacadeName
	 *        	Nome da façade a ser chamada. Não preencher para usar o nome do pacote como nome da façade
	 *        	
	 * @return string URL processada
	 */
	public static function generateFullAppUrl($strAction, $strPackage = '', $strFacadeName = '') {
		
		// configurar o controller
		if ($strPackage == '') {
			$strPackage = 'core';
		}
		
		if ($strFacadeName == '') {
			$strFacadeName = FConfig::getAppConfig ( 'sys_defaultFacade' );
		}
		
		$strActionLink = FConfig::getAppConfig ( 'sys_action' ) . '=' . $strAction;
		
		// configurar o package
		if ($strPackage !== 'core') {
			// $strActionLink .= '&'.FConfig::getAppConfig('sys_package') . '='. $strPackage;
			echo '<pre>' . __FILE__ . ' (Linha ' . __LINE__ . ")\nChamada: " . __CLASS__ . "::" . __FUNCTION__ . "() \n";
			var_dump ( 'não implementado' );
			echo '</pre>';
			die ();
		}
		
		// configurar a façade
		if ($strFacadeName !== FConfig::getAppConfig ( 'sys_defaultFacade' )) {
			$strActionLink .= '&' . FConfig::getAppConfig ( 'sys_facade' ) . '=' . $strFacadeName;
		}
		
		$strFullBaseUrl = preg_replace ( '/\&' . FConfig::getAppConfig ( 'sys_action' ) . '\=(\w+)/', '', FConfig::getAppConfig ( 'base_fullUrl' ) );
		if (strpos ( FConfig::getAppConfig ( 'base_fullUrl' ), '?' ) === FALSE) {
			return $strFullBaseUrl . '?' . $strActionLink;
		} else {
			return $strFullBaseUrl . '&' . $strActionLink;
		}
	}
}