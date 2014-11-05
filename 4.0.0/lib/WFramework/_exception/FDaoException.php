<?php namespace WRFramework;
/**
 * Classe exception que controla os erros referente as inclusões de arquivos
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-15>
 * @package core
 * @subpackage exception
 */
class FDaoException extends FCoreException{
	
	/**
	 * Dispara o método que cuida da exception gerada
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-12-02>
	 * @since 1.0
	 * 
	 * @param string $strErrorName Nome do método que cuidar� do erro
	 * @param array $arrParams Parâmetros que o método precisa receber
	 */
	public function __construct($strErrorName,$mixParams = null){
		eval('$this->' . $strErrorName . '($mixParams);');
	}
	
	/**
	 * Erro que acontece quando a conexão não é estabelecida com o banco de dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-12-02>
	 * @since 1.0
	 * 
	 * @param mixed $mixParams Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function connectionError($strMessage){
		
		$intCode = 8501;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$arrTrace = $this->getTrace();
		$strAdmMsg = 'ERRO ' . $intCode . ' (FIncludeException) :: '.$strMessage.".\n";
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
}