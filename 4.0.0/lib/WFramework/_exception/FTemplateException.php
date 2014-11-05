<?php namespace WRFramework;
/**
 * Classe exception que controla os erros referente �s GUI e Templates
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-19>
 * @package core
 * @subpackage exception
 */
class FTemplateException extends FCoreException{
	
	/**
	 * Disparar o método que cuida da exception gerada
	 * 
	 * @param string $strErrorName Nome do método que cuida do erro
	 * @param array $arrParams Parâmetros que o método precisa receber
	 */
	public function __construct($strErrorName,$mixParams = null){
		eval('$this->' . $strErrorName . '($mixParams);');
	}
	
	/**
	 * Erro que acontece quando uma GUI não é encontrada
	 * 
	 * O parâmetro <code>$mixParams</code> deve estar no seguinte formato:
	 * <code>
	 * 		array(
	 * 			'guiPath'=>'GUI fornecida para o FTemplateController',
	 * 			'fullGuiPath'=>'Diretório completo onde a "GUI" foi procurada e não foi encontrada'
	 * 		);
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-19>
	 * @since 1.0
	 * 
	 * @param mixed $arrInfo Parâmetro contendo os dados necess�rios para o envio da mensagem de erro
	 */
	public function viewNotFound($arrInfo){
		$intCode = 8101;
		$strUsrMsg = 'ERRO FATAL (' . $intCode . ') :: A template solicitada não foi encontrada. Caso ocorra novamente, favor informe-nos pelo e-mail ' . FConfig::getAppConfig('app_supportMail') . '.';
		$strAdmMsg = 'ERRO FATAL ' . $intCode . ' (FTemplateException) :: A "GUI" ("'.$arrInfo['guiPath'].'") não foi encontrada no diretório: "'.$arrInfo['fullGuiPath'].'"';
		
		//definir os dados da exceção
		$this->setExceptionData($intCode, $strUsrMsg, $strAdmMsg);
	}
}
?>