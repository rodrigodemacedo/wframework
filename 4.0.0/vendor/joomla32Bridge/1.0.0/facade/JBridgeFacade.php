<?php
use WRFramework\FIncludeHelper as FIncludeHelper;
use WRFramework\FRequestHelper as FRequestHelper;
use WRFramework\FConfig as FConfig;

/**
 * Controlador do WRF que chama o método requisitado da fachada requisitada da aplicação. Aqui � iniciado todo o processo.
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-16>
 * @package packages
 * @subpackage joomla32Bridge/facade
 */
class JBridgeFacade{
	
	
	
	/**
	 * Define as configurações do componente joomla na aplicação
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-16>
	 * @since 1.0
	 */
	public function setConfigsJoomlaInApplication() {
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.controller.JBridge');
		
		$objController = new JBridgeController();
		$objController->setConfigsJoomlaInApplication();
	}
	
	
	//
	// AÇÕES PARA CONFIGURAÇÃO DA BARRA DE FERRAMENTAS DO JOOMLA!
	//
	
		
	/**
	 * Adiciona um título à barra de ferramentas
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @param string $strTitulo t�tulo da Barra de ferramentas
	 * @param string $strIco Caminho do �cone da barra de ferramentas. Se for da template Khepri (header/), informar somente o nome da imagem.
	 */
	public function addToolbarTitle($strTitulo, $strIco = false) {
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.view.JBridgeToolbar');
		$objView = new JBridgeToolbarView();
		$objView->addTitle($strTitulo, $strIco);
	}
	
	/**
	 * Adiciona um bot�o � barra de ferramentas
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @param string $strLabel Label descritivo do item
	 * @param string $strDescription Descrição curta do que a ação faz
	 * @param string $strBootstrapType Tipo do botão no bootstrap (btn-[])
	 * @param string|stdClass $mixAction String: Ação que a aplicação vai fazer ao usar o bot�o - stdClass: Objeto com os atributos de link para a app do tipo mini
	 * @param string $strBootstrapIcon Ícone do bootstrap
	 * @param boolean $bolIsJsFunction Entende a action como um comando js
	 */
	public function addToolbarButton($strLabel, $strDescription, $strBootstrapType, $mixAction, $strBootstrapIcon, $bolIsJsFunction = false) {
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.view.JBridgeToolbar');
		$objView = new JBridgeToolbarView();
		$objView->addButon($strLabel, $strDescription, $strBootstrapType, $mixAction, $strBootstrapIcon, $bolIsJsFunction);
	}
	
	/**
	 * Obtém o objeto do joomla que controla a interação com a base de dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @version 1.0 <2011-02-04>
	 * @since 1.0
	 * 
	 * @return JDatabaseMySQL DBO do Joomla!
	 */
	public function getDBO() {
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.dao.JBridge');
		$objTmp = new JBridgeDAO();
		
		return $objTmp->getDbo();
	}
	
	/**
	 * Retorna um boleano informando se o usuário está logado ou não
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @version 1.0 <2011-10-26>
	 * @since 1.0
	 * 
	 * @return boolean
	 */
	public function checaUsuarioLogado(){
		if(JFactory::getUser()->id != 0){
			return JFactory::getUser()->id;
		}else{
			return false;
		}
	}
	
	/**
	 * Retorna um boleano informando se o usuário existe ou não
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @version 1.0 <2011-11-20>
	 * @since 1.0
	 * 
	 * @return boolean
	 */
	public function checaExistenciaUsuario($intUserId){
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.controller.JBridge');
		$objJBController = new JBridgeController();
		
		return $objJBController->checaExistenciaUsuario($intUserId);
	}
	
	public function ativarUsuario($strCBActivation){
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.controller.JBridge');
		$objJBController = new JBridgeController();
		
		return $objJBController->ativarUsuario($strCBActivation);
	}
}
?>