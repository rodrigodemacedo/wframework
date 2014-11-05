<?php namespace WRFramework;
/**
 * Classe exception que controla os erros referente �s inclusões de arquivos
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-15>
 * @package core
 * @subpackage exception
 */
class FIncludeException extends FCoreException{
	
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
	 * Erro que acontece quando um arquivo não � encontrado
	 * 
	 * O parâmetro <code>$mixParams</code> deve estar no seguinte formato:
	 * <code>
	 * 		array(
	 * 			'className'=>'Nome da classe não encontrada',
	 * 			'path'=>'Diretório indicado onde a classe foi procurada'
	 * 		);
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $mixParams Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function fileNotFound($mixParams){
		$intCode = 8201;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$arrTrace = $this->getTrace();
		$strAdmMsg = 'ERRO ' . $intCode . ' (FIncludeException) :: O arquivo não foi encontrado usando a chamada "' . $mixParams['className'] . '" feita pelo arquivo "' . $arrTrace[0]['file'] . '"(' . $arrTrace[0]['line'] . ') no caminho: ' . $mixParams['path'] . ".\n";
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Erro que acontece quando uma classe não � encontrada no arquivo solicitado
	 * 
	 * O parâmetro <code>$mixParams</code> deve estar no seguinte formato:
	 * <code>
	 * 		array(
	 * 			'className'=>'Nome da classe não encontrada',
	 * 			'path'=>'Diretório indicado onde a classe foi procurada'
	 * 		);
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param mixed $mixParams Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function classNotFound($mixParams){
		$intCode = 8202;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$arrTrace = $this->getTrace();
		$strAdmMsg = 'ERRO ' . $intCode . ' (FIncludeException) :: A classe não foi encontrada usando a chamada "' . $mixParams['className'] . '" feita pelo arquivo "' . $arrTrace[0]['file'] . '"(' . $arrTrace[0]['line'] . ') no caminho: ' . $mixParams['path'] . ".\n";
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
}