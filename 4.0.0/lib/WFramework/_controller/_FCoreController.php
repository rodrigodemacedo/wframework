<?php

namespace WFramework\Controller;

/**
 * Controlador do WRF que chama o método requisitado da fachada requisitada da aplicação.
 * Aqui é iniciado todo o processo.
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-13>
 * @package core
 * @subpackage controller
 */
class FCoreController {
	
	/**
	 * Faz a iniciação do WRF
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-16>
	 * @since 1.0
	 *       
	 * @param array $arrConfigApp
	 *        	Variável com as configurações da aplicação passadas por referência
	 * @param array $arrConfigPackages
	 *        	Variável com as configurações dos pacotes passadas por referência
	 * @param array $arrConfigVersions
	 *        	Variável com as configurações das versões dos módulos da aplicação passadas por referência
	 * @param array $arrConfigFwVersions
	 *        	Variável com as configurações das versões dos modulos do WRF passadas por referência
	 * @param array $arrFwPackagesVersions
	 *        	Variável com as configurações das versões dos pacotes do WRF passadas por referência
	 * @param array $arrGet
	 *        	Variáveis da Requisição GET
	 * @param array $arrPost
	 *        	Variáveis da Requisição POST
	 * @param array $arrFiles
	 *        	Variáveis da Requisição FILES
	 */
	public static function init(&$arrConfigApp, &$arrPackagesVersions, &$arrModulesVersions, &$arrFwModulesVersions, &$arrFwPackagesVersions, &$arrGet = array(), &$arrPost = array(), &$arrFiles = array()) {
		if (empty ( $_SESSION ))
			session_start ();
			
			// Chamar a classe pai de todas as exceptions
		require $arrConfigApp ['sys_fwModulesDir'] . 'core/' . $arrFwModulesVersions ['core'] . '/exception/FCoreException.php';
		
		// obter e iniciar a classe de configurações da aplicação
		require $arrConfigApp ['sys_fwModulesDir'] . 'core/' . $arrFwModulesVersions ['core'] . '/class/FConfig.class.php';
		require $arrConfigApp ['sys_fwModulesDir'] . 'core/' . $arrFwModulesVersions ['core'] . '/exception/FConfigException.php';
		// Chamar o FIncludeHelper
		require $arrConfigApp ['sys_fwModulesDir'] . 'core/' . $arrFwModulesVersions ['core'] . '/helper/FIncludeHelper.php';
		
		// Guardar as configurações na classe que gerencia isso.
		FConfig::init ( $arrConfigApp, $arrPackagesVersions, $arrModulesVersions, $arrFwModulesVersions, $arrFwPackagesVersions );
		
		// definir dinamicamente alguns diretórios da aplicação
		FConfig::setAppConfig ( 'base_dirBackend', FConfig::getAppConfig ( 'base_dir' ) . 'app-backend/' );
		FConfig::setAppConfig ( 'base_dirFrontend', FConfig::getAppConfig ( 'base_dir' ) . 'app-frontend/' );
		FConfig::setAppConfig ( 'base_dirPackages', FConfig::getAppConfig ( 'base_dir' ) . 'packages/' );
		FConfig::setAppConfig ( 'base_dirTemplates', FConfig::getAppConfig ( 'base_dir' ) . 'templates/' );
		FConfig::setAppConfig ( 'base_dirActiveTemplate', FConfig::getAppConfig ( 'base_dirTemplates' ) . FConfig::getAppConfig ( 'app_templateName' ) . '/' . FConfig::getAppConfig ( 'app_templateVersion' ) . '/' );
		
		FConfig::setAppConfig ( 'base_fullUrl', FConfig::getAppConfig ( 'base_url' ) );
		FConfig::setAppConfig ( 'base_urlPackages', FConfig::getAppConfig ( 'base_url' ) . 'packages/' );
		FConfig::setAppConfig ( 'base_urlTemplates', FConfig::getAppConfig ( 'base_url' ) . 'templates/' );
		FConfig::setAppConfig ( 'base_urlActiveTemplate', FConfig::getAppConfig ( 'base_urlTemplates' ) . FConfig::getAppConfig ( 'app_templateName' ) . '/' . FConfig::getAppConfig ( 'app_templateVersion' ) . '/' );
		
		// apagar as variáveis com as versões, pois agora os valores devem ser obtidos pela classe FConfig
		unset ( $arrConfigApp, $arrPackagesVersions, $arrModulesVersions, $arrFwModulesVersions );
		
		// fazer a inclusão da classe FRequestHelper
		FIncludeHelper::loadClass ( 'fw.core.helper.FRequest' );
		// fazer a inclusão do FPackageHelper
		FIncludeHelper::loadClass ( 'fw.core.helper.FPackage' );
		// fazer a inclusão do FDateHelper
		FIncludeHelper::loadClass ( 'fw.core.helper.FDateTime' );
		// fazer a inclusão do FAppDao
		FIncludeHelper::loadClass ( 'fw.core.dao.FApp' );
		
		// iniciar o controle das querystrings
		FRequestHelper::init ( $arrGet, $arrPost, $arrFiles );
		
		// identificar o ambiente (back ou front-end)
		
		try {
			// verificar se a variável já foi definida
			FConfig::getAppConfig ( 'sys_isBackend' );
		} catch ( FConfigException $e ) {
			if ((FConfig::getAppConfig ( 'sys_onlyBackendApp' )) || (! is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_backendFlag' ) ) ))) {
				FConfig::setAppConfig ( 'sys_isBackend', TRUE );
			} else {
				FConfig::setAppConfig ( 'sys_isBackend', FALSE );
			}
		}
		
		/*
		 * $strServerQuerystring = '';
		 * foreach (FRequestHelper::getAll() as $strChave => $strValor) {
		 * $strServerQuerystring .= $strChave.'='.$strValor.'&';
		 * }
		 * $strServerQuerystring = substr($strServerQuerystring,0,-1);
		 *
		 * //verificar se há querystrings para definir na appConfig "base_fullUrl"
		 * $arrAllQueryStrings = FRequestHelper::getAll();
		 * if (!empty($strServerQuerystring)) {
		 * FConfig::setAppConfig('base_fullUrl',FConfig::getAppConfig('base_fullUrl').'?'.$strServerQuerystring);
		 * }
		 */
		
		// verificar se há querystrings obrigatórias
		$arrRequiredQueryStrings = FConfig::getAppConfig ( 'sys_predefinedQuerystrings' );
		if (! empty ( $arrRequiredQueryStrings )) {
			
			// $arrAllQueryStrings = FRequestHelper::getAll();
			$i = 0;
			foreach ( $arrRequiredQueryStrings as $strQSIndex => $strQSValue ) {
				if ($i == 0) {
					FConfig::setAppConfig ( 'base_fullUrl', FConfig::getAppConfig ( 'base_fullUrl' ) . '?' . $strQSIndex );
				} else {
					FConfig::setAppConfig ( 'base_fullUrl', FConfig::getAppConfig ( 'base_fullUrl' ) . '&' . $strQSIndex );
				}
				
				/*
				 * if(!isset($arrAllQueryStrings[$strQSIndex])){
				 * if(empty($strServerQuerystring)){
				 * $strVarSeparator = '?';
				 * FRequestHelper::set('get', $strQSIndex, $strQSValue);
				 * }else{
				 * $strVarSeparator = '&';
				 * FRequestHelper::set('get', $strQSIndex, $strQSValue);
				 * }
				 *
				 * FConfig::setAppConfig('base_fullUrl',FConfig::getAppConfig('base_fullUrl').$strVarSeparator.$strQSIndex);
				 * if(!empty($strQSValue)){
				 * FConfig::setAppConfig('base_fullUrl',FConfig::getAppConfig('base_fullUrl').'='.$strQSValue);
				 * }
				 *
				 * }
				 */
				$i ++;
			}
		}
	}
	
	/**
	 * Método que roteia as requisições vindas da web para o sistema do tipo full-app.
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-02-12>
	 * @since 1.5
	 */
	public static function routeFullApp() {
		
		// fazer a inclusão do FFacadeInterface
		FIncludeHelper::loadClass ( 'fw.core.interface.FFacade' );
		// fazer a inclusão do FAppController
		FIncludeHelper::loadClass ( 'fw.core.controller.FApp' );
		// fazer a inclusão do FControllerInterface
		FIncludeHelper::loadClass ( 'fw.core.interface.FController' );
		
		// verifica se uma fachada foi solicitada pela requisição
		if ((! is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_facade' ) ) )) && (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_facade' ) ) != '')) {
			$strFacadeName = ucfirst ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_facade' ) ) );
		} else {
			$strFacadeName = ucfirst ( FConfig::getAppConfig ( 'sys_defaultFacade' ) );
		}
		
		// verifica se o método da chamada foi passado
		if ((! is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_action' ) ) ) && (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_action' ) ) != ''))) {
			$strFacadeMethod = FRequestHelper::get ( FConfig::getAppConfig ( 'sys_action' ) );
		} else {
			$strFacadeMethod = FConfig::getAppConfig ( 'sys_defaultAction' );
			;
		}
		
		if ((FConfig::getAppConfig ( 'sys_onlyBackendApp' )) || (FConfig::getAppConfig ( 'sys_isBackend' ) === TRUE)) {
			FIncludeHelper::loadClass ( 'backend.core.facade.' . $strFacadeName );
		} else {
			FIncludeHelper::loadClass ( 'frontend.core.facade.' . $strFacadeName );
		}
		
		// chamar a classe gerenciadora da template
		FIncludeHelper::loadClass ( 'fw.core.class.FTemplate' );
		FIncludeHelper::loadClass ( 'fw.core.controller.FTemplate' );
		FIncludeHelper::loadClass ( 'fw.core.interface.FTemplate' );
		
		// iniciar as operações com as templates
		FTemplateController::init ();
		
		// Criar a nova fachada requisitada
		$strFacadeName .= 'Facade';
		
		//
		if (! class_exists ( $strFacadeName )) {
			$strFacadeName = FConfig::getAppConfig ( 'sys_namespace' ) . '\\' . $strFacadeName;
			if (! class_exists ( $strFacadeName )) {
				FIncludeHelper::loadClass ( 'fw.core.exception.FIncludeException' );
				throw new FIncludeException ( 'classNotFound', array (
						'className' => $strFacadeName,
						'path' => ' :: not specified ::' 
				) );
			}
		}
		
		$objFacade = new $strFacadeName ();
		
		// verificar se a tarefa existe na fachada
		$arrMethodList = get_class_methods ( $strFacadeName );
		
		$objExMethodNotFound = null;
		
		if (! in_array ( $strFacadeMethod, $arrMethodList )) {
			try {
				FIncludeHelper::loadClass ( 'fw.core.exception.FRouter' );
				throw new FRouterException ( 'methodNotFound', array (
						'className' => $strFacadeName,
						'methodName' => $strFacadeMethod 
				) );
			} catch ( FRouterException $objEx ) {
				$objExMethodNotFound = $objEx;
				FRequestHelper::set ( 'get', 'errorCode', $objEx->getCode () );
				FRequestHelper::set ( 'get', 'errorMsg', $objEx->getMessage () );
				FRequestHelper::set ( 'get', 'actionGoTo', FConfig::getAppConfig ( 'base_url' ) );
				FRequestHelper::set ( 'get', 'labelGoTo', 'Home' );
			}
		}
		
		// se o modo debug estiver ativo e o no_html não for chamado ou não estiver em modo ajax, mostrar na tela o aviso
		if (FConfig::getAppConfig ( 'app_debugMode' )) {
			error_reporting ( E_ALL );
			if ((is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_ajxMode' ) ) )) && (FConfig::getAppConfig ( 'sys_isBackend' )) && (FConfig::getAppConfig ( 'app_warningDebugMode' ))) {
				FIncludeHelper::loadClass ( 'fw.core.view.FCore' );
				FCoreView::showDebugModeOn ();
			}
		} else {
			// não mostrar nenhum erro na tela
			error_reporting ( 0 );
		}
		
		// verificar se a requisição é ajax ou não
		if (is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_ajxMode' ) ) )) {
			
			//
			// REQUISIÇÃO NORMAL, SEM SER AJAX
			//
			
			try {
				// chamar, antes de tudo, um método da fachada requisitada
				$objFacade->initBefore ();
				
				// Executar a tarefa requisitada para a view requisitada, onde a template é alimentada para exibição
				if (is_null ( $objExMethodNotFound )) {
					$objFacade->{$strFacadeMethod} ();
				} else {
					$objFacade->showErrors ();
				}
				
				// chamar, depois do da façade, um outro método
				$objFacade->initAfter ();
			} catch ( FDaoException $objEx ) {
				$arrData = array (
						'strMessage' => utf8_decode ( $objEx->getMessage () ),
						'intErrorCode' => $objEx->getCode () 
				);
			}
			
			// chamar a classe gerenciadora da template
			FIncludeHelper::loadClass ( 'template.' . FConfig::getAppConfig ( 'app_templateName' ) );
			
			// instanciar a classe da template
			$strTplClassName = FConfig::getAppConfig ( 'app_templateMainClass' );
			$objTemplate = new $strTplClassName ();
			$objTemplate->execute ();
		} else {
			
			// O "no_html" deve estar ativo também
			if ((is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_noHtmlFlag' ) ) )) || (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_noHtmlFlag' ) ) == '')) {
				FIncludeHelper::loadClass ( 'fw.core.exception.FRouter' );
				throw new FRouterException ( 'executingAjaxWithoutNoHtmlCommand' );
			}
			
			//
			// REQUISIÇÃO EM AJAX
			//
			
			try {
				
				// chamar, antes de tudo, um método da fachada requisitada
				$objFacade->initBeforeAjax ();
				
				// Executar a tarefa requisitada para a view requisitada, onde a template é alimentada para exibição
				if (is_null ( $objExMethodNotFound )) {
					$objFacade->{$strFacadeMethod} ();
				} else {
					$arrData = array ();
					try {
						FIncludeHelper::loadClass ( 'fw.core.exception.FRouter' );
						throw new FRouterException ( 'methodNotFound', array (
								'className' => $strFacadeName,
								'methodName' => $strFacadeMethod 
						) );
					} catch ( FRouterException $objEx ) {
						$arrData ['strMessage'] = utf8_decode ( $objEx->getMessage () );
						$arrData ['intErrorCode'] = $objEx->getCode ();
					}
					
					FTemplateController::getObjTemplate ()->setJsonReturnForAjax ( $arrData );
					$objFacade->showErrors ();
				}
				
				// chamar, depois do da façade, um outro método
				$objFacade->initAfterAjax ();
			} catch ( FDaoException $objEx ) {
				$arrData = array (
						'strMessage' => utf8_decode ( $objEx->getMessage () ),
						'intErrorCode' => $objEx->getCode () 
				);
				FTemplateController::getObjTemplate ()->setJsonReturnForAjax ( $arrData );
			} catch ( \Exception $objEx ) {
				$arrData = array (
						'strMessage' => utf8_decode ( $objEx->getMessage () ),
						'intErrorCode' => $objEx->getCode () 
				);
				FTemplateController::getObjTemplate ()->setJsonReturnForAjax ( $arrData );
			}
			
			// chamar a classe gerenciadora da template
			FIncludeHelper::loadClass ( 'template.' . FConfig::getAppConfig ( 'app_templateName' ) );
			
			// instanciar a classe da template
			$strTplClassName = FConfig::getAppConfig ( 'app_templateMainClass' );
			$objTemplate = new $strTplClassName ();
			$objTemplate->executeAjax ();
		}
	}
	
	/**
	 * Método que roteia as requisições vindas da web para o sistema do tipo mini-app.
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-02-12>
	 * @since 1.5
	 */
	public static function routeMiniApp() {
		
		// fazer a inclusão do FFacadeInterface
		FIncludeHelper::loadClass ( 'fw.core.interface.FController' );
		
		// verifica se um controlador foi solicitado pela requisição
		if ((! is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_controller' ) ) )) && (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_controller' ) ) != '')) {
			$strControllerName = ucfirst ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_controller' ) ) );
		} else {
			if (FConfig::getAppConfig ( 'sys_isBackend' ) === TRUE) {
				$strControllerName = ucfirst ( FConfig::getAppConfig ( 'sys_defaultController' ) );
			} else {
				$strControllerName = ucfirst ( FConfig::getAppConfig ( 'sys_defaultFrontendController' ) );
			}
		}
		
		// verifica se uma fachada foi solicitada pela requisição
		if ((! is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_package' ) ) )) && (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_package' ) ) != '')) {
			$strPackageName = strtolower ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_package' ) ) );
		} else {
			$strPackageName = strtolower ( $strControllerName );
		}
		
		// verifica se o método da chamada foi passado
		if ((! is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_action' ) ) ) && (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_action' ) ) != ''))) {
			$strControllerMethod = FRequestHelper::get ( FConfig::getAppConfig ( 'sys_action' ) );
		} else {
			$strControllerMethod = FConfig::getAppConfig ( 'sys_defaultAction' );
			;
		}
		
		// chamar a classe gerenciadora da template
		FIncludeHelper::loadClass ( 'fw.core.class.FTemplate' );
		FIncludeHelper::loadClass ( 'fw.core.controller.FTemplate' );
		FIncludeHelper::loadClass ( 'fw.core.interface.FTemplate' );
		
		// fazer a inclusão do FAppController
		FIncludeHelper::loadClass ( 'fw.core.controller.FMiniApp' );
		
		if (FConfig::getAppConfig ( 'sys_isBackend' ) === TRUE) {
			FIncludeHelper::loadClass ( 'backend.' . $strPackageName . '.controller.' . $strControllerName );
		} else {
			FIncludeHelper::loadClass ( 'frontend.' . $strPackageName . '.controller.' . $strControllerName );
		}
		
		// iniciar as operações com as templates
		FTemplateController::init ();
		
		// fazer a inclusão do controlador do fw
		FIncludeHelper::loadClass ( 'fw.core.controller.FMiniApp' );
		
		// Criar o controlador requisitado
		$strControllerName .= 'Controller';
		$objController = new $strControllerName ();
		
		// verificar se a tarefa existe na fachada
		$arrMethodList = get_class_methods ( $strControllerName );
		if (! in_array ( $strControllerMethod, $arrMethodList )) {
			FIncludeHelper::loadClass ( 'fw.core.exception.FRouter' );
			throw new FRouterException ( 'methodNotFound', array (
					'className' => $strControllerName,
					'methodName' => $strControllerMethod 
			) );
		}
		
		// se o modo debug estiver ativo e o no_html não for chamado ou não estiver em modo ajax, mostrar na tela o aviso
		if (FConfig::getAppConfig ( 'app_debugMode' )) {
			ini_set ( "display_errors", "ON" );
			error_reporting ( E_ALL );
			
			if ((is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_ajxMode' ) ) )) && (FConfig::getAppConfig ( 'sys_isBackend' )) && (FConfig::getAppConfig ( 'app_warningDebugMode' ))) {
				FIncludeHelper::loadClass ( 'fw.core.view.FCore' );
				FCoreView::showDebugModeOn ();
			}
		} else {
			// não mostrar nenhum erro na tela
			error_reporting ( 0 );
		}
		
		// pega o nome do controller padrão e o ambiente
		if (FConfig::getAppConfig ( 'sys_isBackend' ) === TRUE) {
			$strDefaultControllerName = FConfig::getAppConfig ( 'sys_defaultController' ) . 'Controller';
			$strDefaultControllerNameInclude = FConfig::getAppConfig ( 'sys_defaultController' );
			$strAmbient = 'backend';
		} else {
			$strDefaultControllerName = FConfig::getAppConfig ( 'sys_defaultFrontendController' ) . 'Controller';
			$strDefaultControllerNameInclude = FConfig::getAppConfig ( 'sys_defaultFrontendController' );
			$strAmbient = 'frontend';
		}
		
		FIncludeHelper::loadClass ( $strAmbient . '.' . strtolower ( $strDefaultControllerNameInclude ) . '.controller.' . $strDefaultControllerNameInclude );
		$objDefaultController = new $strDefaultControllerName ();
		
		// verificar se a requisição é ajax ou não
		if (is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_ajxMode' ) ) )) {
			
			//
			// REQUISIÇÃO NORMAL, SEM SER AJAX
			//
			
			// chamar, antes de tudo, um método da fachada requisitada
			$objDefaultController->initBefore ();
			
			// Executar a tarefa requisitada para a view requisitada, onde a template é alimentada para exibição
			$objController->{$strControllerMethod} ();
			
			// chamar, depois do da façade, um outro método
			$objDefaultController->initAfter ();
			
			// chamar a classe gerenciadora da template
			FIncludeHelper::loadClass ( 'template.' . FConfig::getAppConfig ( 'app_templateName' ) );
			
			// instanciar a classe da template
			$strTplClassName = FConfig::getAppConfig ( 'app_templateMainClass' );
			$objTemplate = new $strTplClassName ();
			
			$objTemplate->execute ();
		} else {
			// O "no_html" deve estar ativo também
			if ((is_null ( FRequestHelper::get ( FConfig::getAppConfig ( 'sys_noHtmlFlag' ) ) )) || (FRequestHelper::get ( FConfig::getAppConfig ( 'sys_noHtmlFlag' ) ) == '')) {
				FIncludeHelper::loadClass ( 'fw.core.exception.FRouter' );
				throw new FRouterException ( 'executingAjaxWithoutNoHtmlCommand' );
			}
			
			//
			// REQUISIÇÃO EM AJAX
			//
			
			// chamar, antes de tudo, um método da fachada requisitada
			$objDefaultController->initBeforeAjax ();
			
			// Executar a tarefa requisitada para a view requisitada, onde a template é alimentada para exibição
			$objController->{$strControllerMethod} ();
			
			// chamar, depois do da façade, um outro método
			$objDefaultController->initAfterAjax ();
			
			// chamar a classe gerenciadora da template
			FIncludeHelper::loadClass ( 'template.' . FConfig::getAppConfig ( 'app_templateName' ) );
			
			// instanciar a classe da template
			$strTplClassName = FConfig::getAppConfig ( 'app_templateMainClass' );
			$objTemplate = new $strTplClassName ();
			
			$objTemplate->executeAjax ();
		}
	}
}