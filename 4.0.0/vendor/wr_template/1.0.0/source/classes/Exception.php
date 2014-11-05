<?php namespace WRTemplate;
/**
 * Classe de exceção
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @version 1.0 <2013-08-26>
 * @package wrtemplate
 * @subpackage classes
 */
class Exception extends \Exception{
	
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
	 * Um atributo foi procurado e não foi encontrado em um Object (elemento) 
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strAttribute
	 */
	private function error_6001($strAttribute){
		$this->code = 6001;
		$this->message = sprintf('ERRO %d: O atributo "%s" não foi encontrado.',$this->code,$strAttribute);
	}
	
	/**
	 * Um smartcode foi fornecido, porém seu tipo/nome não pôde ser identificado 
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strSmartCode
	 */
	private function error_6010($strSmartCode){
		$this->code = 6010;
		$this->message = sprintf('ERRO %d: O elemento HTML no smartcode não pôde ser identificado usando o código "%s".',$this->code, $strSmartCode);
	}
	
	/**
	 * Um smartcode não definido foi usado 
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strSmartCode
	 */
	private function error_6011($strSmartCode){
		$this->code = 6011;
		$this->message = sprintf('ERRO %d: O smartcode "%s" não existe.',$this->code, $strSmartCode);
	}
	
	/**
	 * Quando se tenta adicionar filhos a elementos HTML que não pode tê-los
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strSmartCode
	 */
	private function error_6012($strSmartCode){
		$this->code = 6012;
		$this->message = sprintf('ERRO %d: O elemento não pode ter filhos: %s.',$this->code, $strSmartCode);
	}
	
	/**
	 * Quando um filho de form não for Container
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strWrongClassName
	 */
	private function error_6013($strWrongClassName){
		$this->code = 6013;
		$this->message = sprintf('ERRO %d: Somente objetos do tipo Container pode ser fornecido para um Form. Um objeto "%s" foi fornecido.',$this->code, $strWrongClassName);
	}
	
	/**
	 * Quando um filho de Painel não for Object
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strWrongClassName
	 */
	private function error_6014($strWrongClassName){
		$this->code = 6014;
		$this->message = sprintf('ERRO %d: Somente objetos do tipo Object pode ser fornecido para um Panel. Um objeto "%s" foi fornecido.',$this->code, $strWrongClassName);
	}
	
	/**
	 * Quando um filho tem que ser FormCampo
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strWrongClassName
	 */
	private function error_6015($strWrongClassName){
		$this->code = 6015;
		$this->message = sprintf('ERRO %d: Somente objetos do tipo FormCampo pode ser fornecido para este elemento. Um objeto "%s" foi fornecido.',$this->code, $strWrongClassName);
	}
	
	/**
	 * Quando um filho tem que ser Object
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strWrongClassName
	 */
	private function error_6016($strWrongClassName){
		$this->code = 6016;
		$this->message = sprintf('ERRO %d: Somente objetos do tipo Object pode ser fornecido para este elemento. Um objeto "%s" foi fornecido.',$this->code, $strWrongClassName);
	}
}