<?php namespace WRFramework;
/**
 * Classe exception que controla os erros referente a ger�ncia de pacotes
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-15>
 * @package core
 * @subpackage exception
 */
class FPackageException extends FCoreException{
	
	/**
	 * Dispara o método que cuida da exception gerada
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param string $strErrorName Nome do método que cuidar� do erro
	 * @param array $arrParams Parâmetros que o método precisa receber
	 */
	public function __construct($strErrorName,$mixParams = null){
		eval('$this->' . $strErrorName . '($mixParams);');
	}
	
	/**
	 * Caso o nome do pacote requisitado não for encontrado no arquivo de configuração 
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param string $mixParams Nome do pacote procurado no arquivo de configuração package.conf.inc.php
	 */
	public function packageNotLoaded($mixParams){
		$intCode = 8301;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$arrTrace = $this->getTrace();
		$strAdmMsg = 'ERRO ' . $intCode . ' (FPackageException) :: O pacote "' . $mixParams . '" não foi encontrado no arquivo de configuração packages.conf.inc.php';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Caso o arquivo principal do pacote não for encontrado. 
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param string $mixParams nome com diretório completo do arquivo do package que não foi encontrado
	 */
	public function packageFileNotFound($mixParams){
		$intCode = 8302;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$arrTrace = $this->getTrace();
		$strAdmMsg = 'ERRO ' . $intCode . ' (FPackageException) :: O arquivo do pacote "' . $mixParams['package'] . '" não foi encontrado.' . "\nEndere�o do arquivo: " . $mixParams['path'];
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Neste caso, o arquivo do pacote foi encontrado, mas a classe definida no arquivo de configuração não foi encontrado ou deve estar com um nome diferente do definido no arquivo de configuração
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param string $mixParams Nome da classe que não foi encontrada no arquivo principal do package
	 */
	public function packageClassNotExists($mixParams){
		$intCode = 8303;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$arrTrace = $this->getTrace();
		$strAdmMsg = 'ERRO ' . $intCode . ' (FPackageException) :: A classe "' . $mixParams . '" do pacote não consta no arquivo inclu�do para ele.';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
}