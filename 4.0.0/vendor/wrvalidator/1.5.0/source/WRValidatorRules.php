<?php
namespace WRValidator;
/**
 * Classe de especifica��o das regras de valida��o dos valores dos atributos dos objetos
 * 
 * @author Rodrigo de Mac�do Ferreira <rferreira@jc.com.br>
 * @version 1.0 15/03/2012 15:34:22
 */
class Rules{
	
	/**
	 * Array dos atributos e suas configura��es e comandos de valida��o 
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var array
	 */
	private $arrAttrRules;
	
	/**
	 * Ignora o tipo definido na classe e valida seu conte�do como int
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_INT = 'type_as int';
	
	/**
	 * Ignora o tipo definido na classe e valida seu tipo e conte�do como int
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_FORCE_INT = 'type_as force_int';
	
	/**
	 * Ignora o tipo definido na classe e valida seu conte�do como int
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_NUMERIC = 'type_as numeric';
	
	/**
	 * Ignora o tipo definido na classe e o valida como string
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_STRING = 'type_as str';
	
	/**
	 * Ignora o tipo definido na classe e o valida como float
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_FLOAT = 'type_as flo';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como e-mail
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_EMAIL = 'type_as email';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como data (somente sendo DateTime e n�o string).
	 * Para validar datas como string, ver typeAsDateStr()
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @see self::typeAsDateStr()
	 * @var string
	 */
	const TYPE_AS_DATE = 'type_as date';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como cpf com ou sem separadores
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_CPF = 'type_as cpf';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como cep. Valida somente o formato.
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_CEP = 'type_as cep';
	
	/**
	 * Campo obrigat�rio
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const REQUIRED = 'required';
	
	/**
	 * Construtor da classe onde se define os atributos com preenchimento obrigat�rios e o array com as valida��es de cada um
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrRequiredAttributesList
	 * @param array $arrValidationRules
	 */
	public function __construct(array $arrRequiredAttributesList, array $arrValidationRules){
		
		foreach ($arrRequiredAttributesList as $strAttrName) {
			$this->addRule($strAttrName, self::REQUIRED);
		}
		
		foreach ($arrValidationRules as $strAttrName => $mixCodeRule) {
			if(is_array($mixCodeRule)){
				foreach ($mixCodeRule as $strCodeRule) {
					$this->addRule($strAttrName, $strCodeRule);
				}
			}elseif(is_string($mixCodeRule)){
				$this->addRule($strAttrName, $mixCodeRule);
			}
		}
	}
	
	/**
	 * Retorna os atributos do objeto e suas regras
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @return array
	 */
	public function getAttrRules(){
		return $this->arrAttrRules;
	}
	
	/**
	 * Adiciona a regra um atributo para que seja verificada
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strAttrName
	 * @param string $strCodeRules
	 */
	private function addRule($strAttrName, $strCodeRule){
		if(!$this->ruleExists($strAttrName, $strCodeRule))
			$this->arrAttrRules[$strAttrName][] = $strCodeRule;
	}
	
	/**
	 * Verifica se uma regra j� existe para um atributo
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strAttrName
	 * @param string $strCodeRules
	 */
	public function ruleExists($strAttrName, $strCodeRule){
		if(isset($this->arrAttrRules[$strAttrName])){
			$arrTmpExternalRule = explode(' ', $strCodeRule,2);
			foreach ($this->arrAttrRules as $strInternalAttrName => $arrRules) {
				foreach ($arrRules as$strRules) {
					$arrTmpInternalRule = explode(' ', $strRules,2);
					if(($arrTmpInternalRule[0] == $arrTmpExternalRule[0]) && ($strInternalAttrName == $strAttrName)){
						return true;
					}
				}
			}
			
			return false;
			
		}else{
			return false;
		}
	}
	
	/**
	 * Define que o campo deve ter no m�ximo n caracteres
	 * 
	 * @static
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param
	 */
	public static function setMaxStringLength($intMaxStringLength){
		return 'max_lenght ' . $intMaxStringLength;
	}
	
	/**
	 * Define o campo string como data e define tamb�m o formato
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFormat Formato da data
	 */
	public static function typeAsDateStr($strFormat = 'Y-m-d H:i:s'){
		return 'type_as date|user_date_format='.$strFormat;
	}
	
	/**
	 * Define o campo como m�ltiplos e-mails e define um separador entre eles, ex: email_1@mail.com ; email_2@mail.com
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strEmailSeparator
	 */
	public static function typeAsMultiEmail($strEmailSeparator = ';'){
		return 'type_as multi_email|separator='.$strEmailSeparator;
	}
	
	/**
	 * Define que a data do atributo passado seja maior (ou igual, se preferir) que a data informada. 
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param \DateTime $objDate Data a ser comparada com a data do atributo do seu objeto
	 * @param boolean $bolIncludingTheDate [default: true] Informe "true" caso queira incluir a data atual. Nesse caso, avalia-se a "data maior ou igual que" e n�o s� a "data maior que".
	 * @param string $strFormat [default: 'Y-m-d H:i:s'] Formato da data que est� no atributo do seu objeto, em caso de estar em string e n�o em DateTime. Segue o mesmo padr�o do php @see date()
	 */
	public static function dateGreaterThan(\DateTime $objDate, $bolIncludingTheDate = true, $strFormat = 'Y-m-d H:i:s'){
		$strIncludingTheDate = ($bolIncludingTheDate)?'1':'0';
		return 'date_greater_than '.$objDate->format('Y-m-d H:i:s').'|compare_date_format=Y-m-d H:i:s|user_date_format='.$strFormat.'|equals='.$strIncludingTheDate;
	}
	
	/**
	 * Define os valores (string) v�lidos poss�veis para o atributo. V�rios valores podem se passados por par�metro indefinidamente. 
	 * Pode passar v�rias strings por par�metro ou um �nico par�metro como o array de valores poss�veis.
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 */
	public static function setPossibleValues(){
		//verificar se h� somente strings ou numericos nos par�metros
		foreach (func_get_args() as $mixArgs)
			if((!is_string($mixArgs)) && (!is_numeric($mixArgs)))
				throw new Exception(5102,array("Um erro interno ocorreu durante a valida��o dos dados. Contacte seu administrador.","Para definir poss�veis valores, estes devem ser somente string ou n�meros"));
		
		if(func_num_args() != 1){
			$strPossibleValues = implode('#@#', func_get_args());
		}else{
			$strPossibleValues = implode('#@#', func_get_arg(0));
		}
		
		return 'possible_values '.$strPossibleValues;
	}
	
	/**
	 * Define uma mensagem de erro personalizada caso a valida��o d� errado
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strError
	 */
	public static function setErrorMsg($strError){
		return 'error_msg '.$strError;
	}
	
	/**
	 * Aplica uma express�o regular no valor do atributo para ver se est� no formato adequado.
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strRegex Express�o regular
	 * @param string $strModifier [default: ''] Modificadores de express�o regular
	 */
	public static function applyRegex($strRegex, $strModifier = ''){
		return 'apply_regex /'.$strRegex.'/'.$strModifier;
	}
	
	/**
	 * Define o nome do campo para que ele seja usado nas mensagens de erro, caso necess�rio
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strRegex
	 */
	public static function setFieldLabel($strFieldLabel){
		return 'field_label '.$strFieldLabel;
	}
	
	/**
	 * Obt�m uma regra do array de regras passadas no par�metro
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrAttrRules
	 */
	public static function getCustomField($strField, array $arrAttrRules){
		
		foreach ($arrAttrRules as $strRule) {
			$arrTmp = explode(' ', $strRule,2);
			
			if($arrTmp[0] == $strField){
				$arrReturn['field'] = $strField;
				
				//os typos no array abaixo n�o ter�o par�metros
				if(in_array($strField,array('apply_regex'))){
					$arrReturn['value'] = $arrTmp[1];
					return (object) $arrReturn;
				}
				
				$arrValues = explode('|',$arrTmp[1]);
				$arrReturn['value'] = $arrValues[0];
				unset($arrValues[0]);
				
				$arrParams = array();
				if(!empty($arrValues) > 0){
					foreach ($arrValues as $strVal) {
						$arrTmp2 = explode('=', $strVal);
						$arrParams[$arrTmp2[0]] = $arrTmp2[1];
					}
					$arrReturn['params'] = (object) $arrParams;
				}
				
				return (object) $arrReturn;
			}
		}
		
		return false;
	}
	
	/**
	 * Obt�m o label do campo. Ou pelo coment�rio ou se passado via regra
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrAttrRules
	 */
	public static function getFieldLabel(array $arrAttrRules){
		//verificar se foi passado o label do campo nas regras de valida��o
		$objCustomField = self::getCustomField('field_label', $arrAttrRules);
		if($objCustomField !== false){
			return self::getCustomField('field_label', $arrAttrRules)->value;
		}else{
			throw new Exception(5102,array('O label obrigat�rio do campo de valida��o n�o foi definido na configura��o das regras de valida��o do objeto a ser validado.','O programador n�o passou o label de algum campo'));
		}
	}
	
	/**
	 * Obt�m o tipo do campo definido nas regras de valida��o.
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrAttrRules
	 */
	public static function getFieldType(array $arrAttrRules){
		//verificar se foi passado o label do bot�o nas regras de valida��o
		return self::getCustomField('type_as', $arrAttrRules);
	}
}
?>