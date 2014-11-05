<?php namespace WRFramework;
/**
 * Classe exception que controla os erros referente as configurações do sistema
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-09-13>
 * @package core
 * @subpackage exception
 */
class FConfigException extends FCoreException{
	
	/**
	 * Dispara o método que cuida da exception gerada
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $null Vem vários parâmetros, onde o primeiro é o nome do método desta classe a ser chamado e os demais são os parâmetros deste método
	 */
	public function __construct(){
		parent::throwExceptionMethod($this,func_get_args());
	}
	
	/**
	 * Erro que acontece quando um arquivo não é encontrado
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $strModuleName Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function appModuleNotFound($strModuleName){
		$intCode = 8501;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO ' . $intCode . ' (FConfigException) :: O módulo solicitado ("'.$strModuleName.'") não foi especificado no arquivo de configuração dos módulos e suas versões (modules.conf.inc.php).';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Erro que acontece quando uma entrada no config da aplicação não é encontrada
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $strConfigName Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function appConfigNotFound($strConfigName){
		$intCode = 8502;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO ' . $intCode . ' (FConfigException) :: A entrada no appConfig ("'.$strConfigName.'") não foi especificado no arquivo de configuração app.conf.inc.php da aplicação.';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Erro que acontece quando um pacote não é encontrado
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0M
	 * 
	 * @param mixed $strPackageName Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function appPackageNotFound($strPackageName){
		$intCode = 8503;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO ' . $intCode . ' (FConfigException) :: O pacote solicitado ("'.$strPackageName.'") não foi especificado no arquivo de configuração dos pacotes e suas versões (packages.conf.inc.php).';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Erro que acontece quando um arquivo não � encontrado
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $strModuleName Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function fwModuleNotFound($strModuleName){
		$intCode = 8504;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO ' . $intCode . ' (FConfigException) :: O módulo solicitado do FW ("'.$strModuleName.'") não foi especificado no arquivo de configuração dos módulos e suas versões (fw.modules.conf.inc.php).';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Erro que acontece quando um pacote não é encontrado
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $strPackageName Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function fwPackageNotFound($strPackageName){
		$intCode = 8505;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO ' . $intCode . ' (FConfigException) :: O pacote solicitado do FW ("'.$strPackageName.'") não foi especificado no arquivo de configuração dos pacotes e suas versões (fw.packages.conf.inc.php).';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Erro que acontece quando uma entrada no config do framework não é encontrada
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 *
	 * @param mixed $strConfigName Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function fwConfigNotFound($strConfigName){
		$intCode = 8506;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO ' . $intCode . ' (FConfigException) :: A entrada no appConfig ("'.$strConfigName.'") não foi especificado no arquivo de configuração fw.packages.conf.inc.php.';
	
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
}