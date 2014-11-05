<?php
namespace WRValidator;

/**
 * Responsável pelas mensagens de exceção
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 26/08/2013 13:26
 */
class Exception extends \Exception {
	
	/**
	 * Constante que informa se o sistema está operando em modo debug
	 * 
	 * @var bool
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 */
	const DEBUG_MODE = DEBUG_MODE;
	
	/**
	 * Método construtor da classe
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
	 * Erro na checagem de campo obrigatório
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5011($strFieldLabel){
		$this->code = 5011;
		$this->message = sprintf('ERRO %d: O campo "%s" é de preenchimento obrigatório.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como tipo inteiro
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5012($strFieldLabel){
		$this->code = 5012;
		$this->message = sprintf('ERRO %d: O campo "%s" precisa ser um número inteiro.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como tipo data
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param string $strValue
	 */
	private function error_5013($strFieldLabel, $strValue){
		$this->code = 5013;
		$this->message = sprintf('ERRO %d: O campo "%s" com o valor "%s" não é uma data válida.',$this->code,$strFieldLabel,$strValue);
	}
	
	/**
	 * A data informada pelo usuário deveria ser maior ou igual que a da validação
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * A data informada pelo usuário deveria ser maior que a da validação
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * Erro na checagem de campo como tipo numérico
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5016($strFieldLabel){
		$this->code = 5016;
		$this->message = sprintf('ERRO %d: O campo "%s" precisa ser um número.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo com quantidade de caracteres maior que permitida
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param int $intMaxFieldLength
	 * @param int $intMaxUserFieldLength
	 */
	private function error_5017($strFieldLabel, $intMaxFieldLength, $intMaxUserFieldLength){
		$this->code = 5017;
		$this->message = sprintf('ERRO %d: O campo "%s" só pode ter no máximo %d caracteres. Foi digitado 1 caractere.',$this->code,$strFieldLabel,$intMaxFieldLength);
		if($intMaxUserFieldLength > 1)
			$this->message = sprintf('ERRO %d: O campo "%s" só pode ter no máximo %d caracteres. Foram digitados %d caracteres.',$this->code,$strFieldLabel,$intMaxFieldLength,$intMaxUserFieldLength);
	}
	
	/**
	 * Erro na checagem de campo como tipo fração
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5018($strFieldLabel){
		$this->code = 5018;
		$this->message = sprintf('ERRO %d: O campo "%s" precisa ser uma fração.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como tipo e-mail
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5019($strFieldLabel){
		$this->code = 5019;
		$this->message = sprintf('ERRO %d: O campo "%s" não está com um valor válido. Formato correto: email@exemplo.com',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como múltiplos e-mails
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 * @param string $strWrongEmail
	 */
	private function error_5020($strFieldLabel, $strWrongEmail){
		$this->code = 5020;
		$this->message = sprintf('ERRO %d: O campo "%s" possui um e-mail inválido (%s). Formato correto: email@exemplo.com',$this->code,$strFieldLabel,$strWrongEmail);
	}
	
	/**
	 * Erro na checagem de campo como CPF. Validar formato e DV.
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5022($strFieldLabel){
		$this->code = 5022;
		$this->message = sprintf('ERRO %d: O campo "%s" possui um valor inválido.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo como CEP. Validar somente o formato com ou sem os símbolos dos separadores.
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5023($strFieldLabel){
		$this->code = 5023;
		$this->message = sprintf('ERRO %d: O campo "%s" possui um CEP inválido.',$this->code,$strFieldLabel);
	}
	
	/**
	 * Erro na checagem de campo que conté possíveis valores, porém o que o usuário escolheu não atende nenhum deles
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFieldLabel
	 */
	private function error_5024($strFieldLabel){
		$this->code = 5024;
		$this->message = sprintf('ERRO %d: O campo "%s" não foi escolhido corretamente.',$this->code,$strFieldLabel);
	}
	

	
	//
	// OTHERS EXCEPTIONS
	//
	
	
	
	/**
	 * Exceção que é levantada quando a função Util::convertStrDateToDateTimeWithoutFormat não reconhece o dado para conversão
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strValue
	 */
	private function error_5100($strValue){
		$this->code = 5100;
		$this->message = sprintf('ERRO %d: O valor "%s" não pode ser reconhecido como uma data válida para conversão.',$this->code,$strValue);
	}
	
	/**
	 * Exceção que é levantada quando a função Util::convertStrDateToDateTimeWithoutFormat não pode converter automaticamente o valor passado
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strValue
	 */
	private function error_5101($strValue){
		$this->code = 5101;
		$this->message = sprintf('ERRO %d: O valor "%s" não pode ser convertido automaticamente.',$strValue);
	}
	
	/**
	 * Exceção que é levantada quando a criação da regra de validação dinamicamente ou pelo programador não foi aplicada corretamente
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * Exceção que é levantada quando a validação detecta algum valor incorreto de acordo com as regras de validação imposta
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $arrErrorMessages
	 */
	private function error_5103($arrErrorMessages){
		$strErro = implode("\n", $arrErrorMessages);
		
		$this->code = 5103;
		$this->message = $strErro;
	}
	
	/**
	 * A classe de validação não conseguiu pegar algum valor de algum atributo da classe
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param object $objClass
	 * @param string $strAttrOrMethodName
	 */
	private function error_5104($objClass, $strAttrOrMethodName){
		$this->code = 5104;
		if(!self::DEBUG_MODE){
			$this->message = sprintf('ERRO %d: Validação dos dados: O valor não pôde ser obtido para teste de validação',$this->code);
		}else{
			$this->message = sprintf('ERRO %d: Não existe "%s" na classe "%s"',$this->code,$strAttrOrMethodName,get_class($objClass));
		}
	}
	
}
?>