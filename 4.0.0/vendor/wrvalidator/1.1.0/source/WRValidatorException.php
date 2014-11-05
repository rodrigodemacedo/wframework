<?php
namespace WRValidator;

/**
 * Respons�vel pelas mensagens de exce��o
 *
 * @author Rodrigo de Mac�do Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 26/08/2013 13:26
 */
class Exception extends \Exception {
	
	/**
	 * Constante que informa se o sistema est� operando em modo debug
	 * 
	 * @var bool
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 */
	const DEBUG_MODE = DEBUG_MODE;
	
	/**
	 * M�todo construtor da classe
	 *
	 * @access public
	 * @param string $strMsg
	 * @param int $intErrorCode
	 */
	public function __construct($intErrorCode, $arrParameters = array()) {
		//if(!is_array($arrParameters))
			//$arrParameters = array($arrParameters);
			
		//parent::__construct($strMsg, $intErrorCode);
		$arrParamVars = array();
		if((is_array($arrParameters)) && (!empty($arrParameters))){
			foreach ($arrParameters as $i => $mixParameter) {
				eval('$parameter_'.$i.' = $mixParameter;');
				eval('$arrParamVars[] = \'$parameter_'.$i.'\';');
			}
		}else{
			$arrParamVars[] = '$arrParameters';
		}
		
		if(!empty($arrParameters)){
			$strFunctionCall = '$this->error_'.$intErrorCode.'('.implode(',', $arrParamVars).');';
		}else{
			$strFunctionCall = '$this->error_'.$intErrorCode.'();';
		}
		
		eval($strFunctionCall);
	}
	
	/**
	 * Erro na checagem de campo obrigat�rio
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5011($strFieldLabel){
		$this->code = 5011;
		$this->message = sprintf('ERRO %d: O campo "%s" � de preenchimento obrigat�rio.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como tipo inteiro
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5012($strFieldLabel){
		$this->code = 5012;
		$this->message = sprintf('ERRO %d: O campo "%s" precisa ser um n�mero inteiro.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como tipo data
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param string $strValue
	 */
	private function error_5013($strFieldLabel, $strValue){
		$this->code = 5013;
		$this->message = sprintf('ERRO %d: O campo "%s" com o valor "%s" n�o � uma data v�lida.',$this->code,$strFieldLabel,$strValue);
	}
	
	/**
	 * A data informada pelo usu�rio deveria ser maior ou igual que a da valida��o
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param string $strUserDateValue
	 * @param string $strComparisonDateValue
	 */
	private function error_5014($strFieldLabel, $strUserDateValue, $strComparisonDateValue){
		$this->code = 5014;
		$this->message = sprintf('ERRO %d: O campo "%s" informado (%s) deve conter uma data maior ou igual a "%s".',$this->code,$strFieldLabel,$strUserDateValue,$strComparisonDateValue);
	}
	
	/**
	 * A data informada pelo usu�rio deveria ser maior que a da valida��o
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param string $strUserDateValue
	 * @param string $strComparisonDateValue
	 */
	private function error_5015($strFieldLabel, $strUserDateValue, $strComparisonDateValue){
		$this->code = 5015;
		$this->message = sprintf('ERRO %d: O campo "%s" informado (%s) deve conter uma data maior a "%s".',$this->code,$strFieldLabel,$strUserDateValue,$strComparisonDateValue);
	}
	
	/**
	 * Erro na checagem de campo como tipo num�rico
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5016($strFieldLabel){
		$this->code = 5016;
		$this->message = sprintf('ERRO %d: O campo "%s" precisa ser um n�mero.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo com quantidade de caracteres maior que permitida
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param int $intMaxFieldLength
	 * @param int $intMaxUserFieldLength
	 */
	private function error_5017($strFieldLabel, $intMaxFieldLength, $intMaxUserFieldLength){
		$this->code = 5017;
		$this->message = sprintf('ERRO %d: O campo "%s" s� pode ter no m�ximo %d caracteres. Foi digitado 1 caractere.',$this->code,$strFieldLabel,$intMaxFieldLength);
		if($intMaxUserFieldLength > 1)
			$this->message = sprintf('ERRO %d: O campo "%s" s� pode ter no m�ximo %d caracteres. Foram digitados %d caracteres.',$this->code,$strFieldLabel,$intMaxFieldLength,$intMaxUserFieldLength);
	}
	
	/**
	 * Erro na checagem de campo como tipo fra��o
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5018($strFieldLabel){
		$this->code = 5018;
		$this->message = sprintf('ERRO %d: O campo "%s" precisa ser uma fra��o.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como tipo e-mail
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5019($strFieldLabel){
		$this->code = 5019;
		$this->message = sprintf('ERRO %d: O campo "%s" n�o est� com um valor v�lido. Formato correto: email@exemplo.com',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como m�ltiplos e-mails
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param string $strWrongEmail
	 */
	private function error_5020($strFieldLabel, $strWrongEmail){
		$this->code = 5020;
		$this->message = sprintf('ERRO %d: O campo "%s" possui um e-mail inv�lido (%s). Formato correto: email@exemplo.com',$this->code,$strFieldLabel,$strWrongEmail);
	}
	
	/**
	 * Erro na checagem de campo como CPF. Validar formato e DV.
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5022($strFieldLabel){
		$this->code = 5022;
		$this->message = sprintf('ERRO %d: O campo "%s" possui um valor inv�lido.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como CEP. Validar somente o formato com ou sem os s�mbolos dos separadores.
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5023($strFieldLabel){
		$this->code = 5023;
		$this->message = sprintf('ERRO %d: O campo "%s" possui um CEP inv�lido.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo que cont� poss�veis valores, por�m o que o usu�rio escolheu n�o atende nenhum deles
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5024($strFieldLabel){
		$this->code = 5024;
		$this->message = sprintf('ERRO %d: O campo "%s" n�o foi escolhido corretamente.',$this->code,$strFieldLabel);
	}
	

	
	//
	// OTHERS EXCEPTIONS
	//
	
	
	
	/**
	 * Exce��o que � levantada quando a fun��o Util::convertStrDateToDateTimeWithoutFormat n�o reconhece o dado para convers�o
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strValue
	 */
	private function error_5100($strValue){
		$this->code = 5100;
		$this->message = sprintf('ERRO %d: O valor "%s" n�o pode ser reconhecido como uma data v�lida para convers�o.',$this->code,$strValue);
	}
	
	/**
	 * Exce��o que � levantada quando a fun��o Util::convertStrDateToDateTimeWithoutFormat n�o pode converter automaticamente o valor passado
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strValue
	 */
	private function error_5101($strValue){
		$this->code = 5101;
		$this->message = sprintf('ERRO %d: O valor "%s" n�o pode ser convertido automaticamente.',$strValue);
	}
	
	/**
	 * Exce��o que � levantada quando a cria��o da regra de valida��o dinamicamente ou pelo programador n�o foi aplicada corretamente
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strValue
	 */
	private function error_5102($strMensagem, $strAdminMessage){
		$this->code = 5102;
		if(!self::DEBUG_MODE){
			$this->message =  sprintf('ERRO %d: %s',$this->code,$strMensagem);
		}else{
			$this->message = sprintf('ERRO %d: %s',$this->code,$strAdminMessage);
		}
	}
	
	/**
	 * Exce��o que � levantada quando a valida��o detecta algum valor incorreto de acordo com as regras de valida��o imposta
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $arrErrorMessages
	 */
	private function error_5103($arrErrorMessages){
		$strErro = implode("\n", $arrErrorMessages);
		
		$this->code = 5103;
		$this->message = $strErro;
	}
	
	/**
	 * A classe de valida��o n�o conseguiu pegar algum valor de algum atributo da classe
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param object $objClass
	 * @param string $strAttrOrMethodName
	 */
	private function error_5104($objClass, $strAttrOrMethodName){
		$this->code = 5104;
		if(!self::DEBUG_MODE){
			$this->message = sprintf('ERRO %d: Valida��o dos dados: O valor n�o p�de ser obtido para teste de valida��o',$this->code);
		}else{
			$this->message = sprintf('ERRO %d: N�o existe "%s" na classe "%s"',$this->code,$strAttrOrMethodName,get_class($objClass));
		}
	}
	
}
?>