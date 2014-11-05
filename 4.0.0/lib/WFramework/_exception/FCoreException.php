<?php namespace WRFramework;
/**
 * Classe pai de todas as exceptions da aplicação. Todas as classes exceptions filhas devem disparar o único método abaixo.
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-15>
 * @package core
 * @subpackage exception
 */
class FCoreException extends \Exception{
	
	/**
	 * Define os dados da exception lançada, como o c�digo e a mensagem que vai para o usuário
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-15>
	 * @since 1.0
	 * 
	 * @param int $intCode Código do erro levantado
	 * @param string $strUserErrorMsg Mensagem de erro enviada para os usuários da aplicação
	 * @param string $strAdminErrorMsg Mensagem de erro enviada aos desenvolvedores em modo debug.
	 */
	public function setExceptionData($intCode ,$strUserErrorMsg, $strAdminErrorMsg){
		//define o código da exception
		$this->code = $intCode;
		
		//define a mensagem caso esteja em modo debug ou não
		if(FConfig::getAppConfig('app_debugMode')){
			$this->message = '';
			if(FConfig::getAppConfig('app_warningDebugMode'))
				$this->message = ":: DEBUG MODE :: \n\n";
			
			$this->message .= $strAdminErrorMsg;
			
		}else{
			$this->message = $strUserErrorMsg;
		}
		
		//$this->message = ($this->message);
		//$this->message = utf8_decode($this->message);
	}
	
	public function throwExceptionMethod($objException, $arrExceptionsParams){
		
		switch (count($arrExceptionsParams)) {
			case 0:
				$strCallbackMethod = "parent::__construct('ERRO FATAL :: Ocorreu um erro interno. Caso ocorra novamente, favor informe-nos pelo e-mail '" . FConfig::getAppConfig('app_supportMail') . "'.');";
				break;
				
			case 1:
				$strCallbackMethod = '$this->'.$arrExceptionsParams[0].'();';
				break;
			
			default:
				
				$strMethodName = $arrExceptionsParams[0];
				$strParams = "";
				for ($i = 1; $i < count($arrExceptionsParams); $i++) {
					$strParams .= '$arrExceptionsParams['.$i.'], ';
				}
				$strParams = substr($strParams, 0, -2);
				$strCallbackMethod = '$objException->'.$strMethodName.'('.$strParams.');';
				break;
			break;
		}
		//chamar o método da exceção de quem chamou
		eval($strCallbackMethod);
	}
}
?>