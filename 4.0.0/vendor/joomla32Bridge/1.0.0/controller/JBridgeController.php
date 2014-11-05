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
 * @subpackage joomla32Bridge/controller
 */
class JBridgeController{
	
	
	
	/**
	 * Define as configurações do componente joomla na aplicação
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-16>
	 * @since 1.0
	 */
	public function setConfigsJoomlaInApplication() {
		$arrUri = explode('?', JFactory::getURI()->toString());
		$strFullUriAdm = str_replace('/index.php','/',$arrUri[0]).'administrator/';
		$strFullUri = str_replace('/administrator/','/',$strFullUriAdm);
		$strFullUriAdm = str_replace('/administrator/administrator/','/administrator/',$strFullUriAdm);
		
		FConfig::setAppConfig('cms_componentName', FRequestHelper::get('option'));
		FConfig::setAppConfig('cms_urlAdmin', $strFullUriAdm);
		FConfig::setAppConfig('cms_urlSite', $strFullUri);
		
		//definir as URL's que o FCore não conseguiu pois o "base_url" não foi definido nas configurações, mas sim por aqui
		FConfig::setAppConfig('base_url', $strFullUriAdm);
		FConfig::setAppConfig('base_fullUrl', $strFullUriAdm.'?option='.FConfig::getAppConfig('cms_componentName'));
		FConfig::setAppConfig('base_urlPackages',  $strFullUriAdm.'components/'.FRequestHelper::get('option').'/'.FConfig::getAppConfig('app_version').'/packages/');
		FConfig::setAppConfig('base_urlTemplates', $strFullUriAdm.'components/'.FRequestHelper::get('option').'/'.FConfig::getAppConfig('app_version').'/templates/');
		FConfig::setAppConfig('base_urlActiveTemplate', FConfig::getAppConfig('base_urlTemplates') . FConfig::getAppConfig('app_templateName').'/'.FConfig::getAppConfig('app_templateVersion').'/');
		
		//
		$arrTmp = FConfig::getAppConfig('sys_predefinedQuerystrings');
		$arrTmp['option'] = FConfig::getAppConfig('cms_componentName');
		FConfig::setAppConfig('sys_predefinedQuerystrings',$arrTmp);
		
		//checar se o joomla est� no backend ou no front-end do joomla e definir a variavel do config
		$objJApp =& JFactory::getApplication();
		if($objJApp->isAdmin()){
			FConfig::setAppConfig('sys_isBackend', TRUE);
		}else{
			FConfig::setAppConfig('sys_isBackend', FALSE);
		}
	}
	
	public function checaExistenciaUsuario($intUserId){
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.dao.JBridge');
		$objJBDao = new JBridgeDao();
		
		return $objJBDao->checaExistenciaUsuario($intUserId);
	}
	
	public function ativarUsuario($strCBActivation){
		FIncludeHelper::loadClass('fwPackage.joomla32Bridge.dao.JBridge');
		$objJBDao = new JBridgeDao();
		
		return $objJBDao->ativarUsuario($strCBActivation);
	}
}