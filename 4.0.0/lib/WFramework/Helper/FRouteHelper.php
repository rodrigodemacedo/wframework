<?php
namespace WFramework\Helper;

class FRouteHelper {
	private $strPattern;
	private $funCallback;
	private $bolCaseSensitive;
	private $arrParamNames;
	private $arrParam;

	public function __construct($strPattern, $funCallback, $bolCaseSensitive = true) {
		$this->setPattern($strPattern)->setCallback($funCallback)->setCaseSensitive($bolCaseSensitive);
		
		// Limpando os arrays dos parametros
		$this->arrParamNames = array();
		$this->arrParam = array();
	}

	public function getPattern() {
		return $this->strPattern;
	}

	public function setPattern($strPattern) {
		$this->strPattern = $strPattern;
		return $this;
	}

	public function getCallback() {
		$this->funCallback;
	}

	public function setCallback($funCallback) {
		// @TODO
		if (!is_callable($funCallback)) throw new Exception('Callback function must be callable');
		$this->funCallback = $funCallback;
		return $this;
	}

	public function getCaseSensitive() {
		return $this->bolCaseSensitive;
	}

	public function setCaseSensitive($bolCaseSensitive) {
		$this->bolCaseSensitive = $bolCaseSensitive;
		return $this;
	}

	public function match($strRequestUri) {
		// Limpando os arrays dos parametros
		$this->arrParamNames = array();
		$this->arrParam = array();
		
		// Substituindo os parametros do tipo :NOME para a regexp ([^/]+)
		$strRegexp = preg_replace_callback('#:([\w]+)#', array(
				$this,
				'matchesCallback' 
		), $this->strPattern);
		
		// A ultima barra do endereco eh opcional
		if (substr($this->strPattern, -1) === '/') $strRegexp .= '?';
		
		$strRegexp = '#^' . $strRegexp . '$#';
		if (!$this->bolCaseSensitive) $strRegexp .= 'i';
		if (!preg_match($strRegexp, $strRequestUri, $arrParamValues)) return false;
		
		foreach ($this->arrParamNames as $strParamName) {
			if (isset($arrParamValues[$strParamName])) {
				$this->arrParam[$strParamName] = urldecode($arrParamValues[$strParamName]);
			}
		}
		return true;
	}

	private function matchesCallback($arrParamName) {
		$this->arrParamNames[] = $arrParamName[1];
		return '(?P<' . $arrParamName[1] . '>[^/]+)';
	}

	public function callback() {
		call_user_func($this->funCallback, new FRequestHelper($this->arrParam), new FResponseHelper());
	}
}
