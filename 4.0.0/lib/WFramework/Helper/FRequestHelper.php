<?php
namespace WFramework\Helper;

class FRequestHelper {
	private $arrRoute;
	private $arrPost;
	private $arrGet;
	private $arrFiles;

	public function __construct($arrRoute = array()) {
		$this->arrRoute = (is_array($arrRoute)) ? $arrRoute : array();
		$this->arrPost = (is_array($_POST)) ? $_POST : array();
		$this->arrGet = (is_array($_GET)) ? $_GET : array();
		$this->arrFiles = (is_array($_FILES)) ? $_FILES : array();
		
		// apagando os dados vindos da requisição
		$_POST = array();
		$_GET = array();
		$_FILES = array();
	}
	
	// Retorna um parametro que pode ter sido enviado via URL, POST ou GET (nesta ordem)
	public function param($strKey = null, $mixDefaultValue = null) {
		$arrParam = $this->arrRoute + $this->arrPost + $this->arrGet;
		if (!is_null($strKey)) {
			return (isset($arrParam[$strKey])) ? $arrParam[$strKey] : $mixDefaultValue;
		}
		return $arrParam;
	}
	
	// Força o retorno de um parametro ser um numero inteiro
	public function paramInt($strKey, $mixDefaultValue = null) {
		$mixVal = $this->param($strKey, $mixDefaultValue);
		return (!is_null($mixVal)) ? (int) $mixVal : $mixVal;
	}
	
	// Método que popula automaticamente um objeto com os dados submetidos
	public function populate($obj) {
		$arrParam = $this->arrRoute + $this->arrPost + $this->arrGet;
		foreach ($arrParam as $strKey => $strValue) {
			$strMethod = 'set' . ucfirst($strKey);
			if (is_callable(array(
					$obj,
					$strMethod 
			))) $obj->$strMethod($strValue);
		}
		return $obj;
	}
	
	// Método que recupera um cookie
	public function cookie($strKey = null) {
		if (!is_null($strKey)) {
			return (isset($_COOKIE[$strKey])) ? $_COOKIE[$strKey] : null;
		}
		return $_COOKIE;
	}
	
	// Método que obtem o IP real do cliente por meio de proxies (inclusive)
	public function ip() {
		$strKeys = array(
				'X_FORWARDED_FOR',
				'HTTP_X_FORWARDED_FOR',
				'CLIENT_IP' 
		);
		foreach ($strKeys as $strKey) {
			if (isset($_SERVER[$strKey])) return $_SERVER[$strKey];
		}
		return $_SERVER['REMOTE_ADDR'];
	}
	
	// Método que retorna o protocolo utilizado na comunicacao
	public function protocol() {
		return (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
	}
	
	// Método que retorna o UserAgent do cliente
	public function userAgent() {
		return (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}
	
	// Método que retorna a URL Referrer
	public function referrer() {
		return (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
	}
	
	// Método que retorna o path acessado
	public function path() {
		return (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
	}
	
	// Método que verifica se o request veio por um ajax
	public function isAjax() {
		return (isset($_SERVER['X_REQUESTED_WITH']) && $_SERVER['X_REQUESTED_WITH'] === 'XMLHttpRequest') ? true : false;
	}
	
	// Método que armazena para a próxima chamada do FRequest possuir uma mensagem flash
	public function setFlashMsg($strType, $strMessage) {
		$_SESSION['_fw.wframework.flash'] = array(
				'type' => $strType,
				'message' => $strMessage 
		);
	}
}