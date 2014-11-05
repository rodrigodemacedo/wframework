<?php namespace WRFramework;
/**
 * Classe exception que controla os erros referente ao roteador do WRF
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-15>
 * @package core
 * @subpackage exception
 */
class FRouterException extends FCoreException{
	
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
	 * Controla o erro de classe não encontrada
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param string $strClassPathName Nome da classe que não foi encontrada para ser exibida em modo debug
	 */
	public function classNotFound($strClassPathName){
		$intCode = 8001;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Você tentou ir para um local do sistema que não existe. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO FATAL ' . $intCode . " (FRouterException) :: Classe não encontrada. \n\"" . $strClassPathName . '"';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Dispara um erro quando um método não � encontrado numa classe.
	 * 
	 * O parâmetro <code>$mixParams</code> deve estar no seguinte formato:
	 * <code>
	 * 		array(
	 * 			'className'=>'Nome da classe onde o método foi procurado',
	 * 			'methodName'=>'Nome do método procurado'
	 * 		);
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param array $arrDataException Um array com o nome da classe e o nome do método que não foi encontrado
	 */
	public function methodNotFound($arrDataException){
		$intCode = 8002;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: Você tentou ir para um local do sistema que não existe. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO FATAL ' . $intCode . ' (FRouterException) :: O método "' . $arrDataException['className'] . '->' . $arrDataException['methodName'] . '()" não existe.';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
	
	/**
	 * Dispara um erro quando o WRF faz uma requisição ajax sem que o no_html tamb�m esteja ativo.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-19>
	 * @since 1.0
	 */
	public function executingAjaxWithoutNoHtmlCommand(){
		$intCode = 8003;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: O sistema tentou executar uma operação de forma inv�lida. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO FATAL ' . $intCode . ' (FRouterException) :: Uma requisição ajax foi iniciada sem que o \'GET["' . FConfig::getAppConfig('sys_noHtmlFlag') . '"] = true\' esteja definido tamb�m.';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
}
?>