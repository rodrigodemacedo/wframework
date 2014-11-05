<?php
namespace WFramework\Helper;

class FAutoloaderHelper {
	private $strNamespace;
	private $strLibDir;

	public function register($strNamespace, $strLibDir) {
		$this->strNamespace = $strNamespace;
		$this->strLibDir = rtrim($strLibDir, '/\\') . DIRECTORY_SEPARATOR;
		spl_autoload_register(array(
				$this,
				'autoload' 
		));
	}

	private function autoload($strClassName) {
		$strClassName = ltrim($strClassName, '\\');
		
		// Verificando se a chamada pertence a este namespace
		if ($intFirstNsPos = strpos($strClassName, '\\')) {
			if ($this->strNamespace == substr($strClassName, 0, $intFirstNsPos)) {
				
				// Carregando as classes que compoem o PSR-0
				$strFileName = $this->strLibDir;
				$strNamespace = '';
				if ($intLastNsPos = strrpos($strClassName, '\\')) {
					$strNamespace = substr($strClassName, 0, $intLastNsPos);
					$strClassName = substr($strClassName, $intLastNsPos + 1);
					$strFileName .= str_replace('\\', DIRECTORY_SEPARATOR, $strNamespace) . DIRECTORY_SEPARATOR;
				}
				$strFileName .= str_replace('_', DIRECTORY_SEPARATOR, $strClassName) . '.php';
				// @TODO
				if (!file_exists($strFileName)) throw new \Exception('Class ' . $strClassName . ' not found!');
				require $strFileName;
			}
		}
	}
}