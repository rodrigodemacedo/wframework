<?php
namespace WFramework;

class WFramework {
	/**
	 * Atributo contendo a instância do Singleton do Framework
	 *
	 * @access private
	 * @var WFramework
	 */
	private static $objInstance = null;
	private $strRouteGroup;
	private $arrObjRoute;
	private $objRouteNotFound;

	/**
	 * Método construtor da classe
	 *
	 * @access private
	 */
	private function __construct(&$arrConfig) {
		// Inicializando o vetor de rotas
		$this->arrObjRoute = array();
		$this->objRouteNotFound = null;
		$this->strRouteGroup = '';
		
		// Inicializando a session
		session_start();
		
		// Incluindo o FAutoloaderHelper
		$strBaseDir = __DIR__;
		if (substr($strBaseDir, -strlen(__NAMESPACE__)) === __NAMESPACE__) $strBaseDir = substr($strBaseDir, 0, -strlen(__NAMESPACE__));
		
		// Registrando as classes do framework na pilha de autoload
		require $strBaseDir . DIRECTORY_SEPARATOR . 'WFramework/Helper/FAutoloaderHelper.php';
		$this->autoloadRegister(__NAMESPACE__, $strBaseDir);
		
		// Inicializando o FConfig
		FConfig::init($arrConfig);
	}

	/**
	 * Método estático Singleton que retorna uma instância do Framework
	 *
	 * @access public
	 * @return WFramework
	 */
	public static function getInstance(&$arrConfig) {
		if (self::$objInstance == null) {
			self::$objInstance = new WFramework($arrConfig);
		}
		return self::$objInstance;
	}
	
	// Método que registra um diretorio na pilha spl do autoload
	public function autoloadRegister($strNamespace, $strLibDir) {
		$objAutoloader = new Helper\FAutoloaderHelper();
		$objAutoloader->register($strNamespace, $strLibDir);
	}
	
	// Método que define uma rota do tipo GET para a função callback
	public function get($strPattern, $funCallback) {
		$this->arrObjRoute['GET'][] = new Helper\FRouteHelper($this->strRouteGroup . $strPattern, $funCallback);
	}
	
	// Método que define uma rota do tipo POST para a função callback
	public function post($strPattern, $funCallback) {
		$this->arrObjRoute['POST'][] = new Helper\FRouteHelper($this->strRouteGroup . $strPattern, $funCallback);
	}
	
	// Método que define uma rota para o erro 404
	public function notFound($funCallback) {
		$this->objRouteNotFound = new Helper\FRouteHelper('', $funCallback);
	}
	
	// Método que cria um grupo de rotas definidas na callback
	public function group($strPattern, $funCallback) {
		$strRouteGroup = $this->strRouteGroup;
		$this->strRouteGroup .= $strPattern;
		if (is_callable($funCallback)) call_user_func($funCallback);
		$this->strRouteGroup = $strRouteGroup;
	}
	
	// Método que verifica a rota atual
	public function run() {
		// @TODO
		if (is_null($this->objRouteNotFound)) throw new Exeption('Route 404 not defined!');
		$arrRequestUri = parse_url($_SERVER['REQUEST_URI']);
		$strRequestMethod = ($_SERVER['REQUEST_METHOD'] == 'POST') ? 'POST' : 'GET';
		foreach ($this->arrObjRoute[$strRequestMethod] as $objRoute) {
			if ($objRoute->match($arrRequestUri['path'])) {
				$objRoute->callback();
				return;
			}
		}
		$this->objRouteNotFound->callback();
	}

	public function setViewEngine($objTemplateEngine) {
	}

	public function setViewFolder($strFolderName) {
	}
}