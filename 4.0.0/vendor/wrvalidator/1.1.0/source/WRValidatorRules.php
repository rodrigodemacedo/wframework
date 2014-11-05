<?php
namespace WRValidator;
/**
 * Classe de especificação das regras de validação dos valores dos atributos dos objetos
 * 
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @version 1.0 15/03/2012 15:34:22
 */
class Rules{
	
	/**
	 * Array dos atributos e suas configurações e comandos de validação 
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var array
	 */
	private $arrAttrRules;
	
	/**
	 * Ignora o tipo definido na classe e valida seu conteúdo como int
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_INT = 'type_as int';
	
	/**
	 * Ignora o tipo definido na classe e valida seu tipo e conteúdo como int
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_FORCE_INT = 'type_as force_int';
	
	/**
	 * Ignora o tipo definido na classe e valida seu conteúdo como int
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_NUMERIC = 'type_as numeric';
	
	/**
	 * Ignora o tipo definido na classe e o valida como string
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_STRING = 'type_as str';
	
	/**
	 * Ignora o tipo definido na classe e o valida como float
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_FLOAT = 'type_as flo';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como e-mail
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_EMAIL = 'type_as email';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como data (somente sendo DateTime e não string).
	 * Para validar datas como string, ver typeAsDateStr()
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @see self::typeAsDateStr()
	 * @var string
	 */
	const TYPE_AS_DATE = 'type_as date';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como cpf com ou sem separadores
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_CPF = 'type_as cpf';
	
	/**
	 * Ignora o tipo definido na classe e o valida o campo como cep. Valida somente o formato.
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const TYPE_AS_CEP = 'type_as cep';
	
	/**
	 * Campo obrigatório
	 * 
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	const REQUIRED = 'required';
	
	/**
	 * Construtor da classe onde se define os atributos com preenchimento obrigatórios e o array com as validações de cada um
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strAttrName
	 * @param string $strCodeRules
	 */
	private function addRule($strAttrName, $strCodeRule){
		if(!$this->ruleExists($strAttrName, $strCodeRule))
			$this->arrAttrRules[$strAttrName][] = $strCodeRule;
	}
	
	/**
	 * Verifica se uma regra já existe para um atributo
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * Define que o campo deve ter no máximo n caracteres
	 * 
	 * @static
	 * @access private
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param
	 */
	public static function setMaxStringLength($intMaxStringLength){
		return 'max_lenght ' . $intMaxStringLength;
	}
	
	/**
	 * Define o campo string como data e define também o formato
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strFormat Formato da data
	 */
	public static function typeAsDateStr($strFormat = 'Y-m-d H:i:s'){
		return 'type_as date|user_date_format='.$strFormat;
	}
	
	/**
	 * Define o campo como múltiplos e-mails e define um separador entre eles, ex: email_1@mail.com ; email_2@mail.com
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
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
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param \DateTime $objDate Data a ser comparada com a data do atributo do seu objeto
	 * @param boolean $bolIncludingTheDate [default: true] Informe "true" caso queira incluir a data atual. Nesse caso, avalia-se a "data maior ou igual que" e não só a "data maior que".
	 * @param string $strFormat [default: 'Y-m-d H:i:s'] Formato da data que está no atributo do seu objeto, em caso de estar em string e não em DateTime. Segue o mesmo padrão do php @see date()
	 */
	public static function dateGreaterThan(\DateTime $objDate, $bolIncludingTheDate = true, $strFormat = 'Y-m-d H:i:s'){
		$strIncludingTheDate = ($bolIncludingTheDate)?'1':'0';
		return 'date_greater_than '.$objDate->format('Y-m-d H:i:s').'|compare_date_format=Y-m-d H:i:s|user_date_format='.$strFormat.'|equals='.$strIncludingTheDate;
	}
	
	/**
	 * Define os valores (string) válidos possíveis para o atributo. Vários valores podem se passados por parâmetro indefinidamente. 
	 * Pode passar várias strings por parâmetro ou um único parâmetro como o array de valores possíveis.
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 */
	public static function setPossibleValues(){
		//verificar se há somente strings ou numericos nos parâmetros
		foreach (func_get_args() as $mixArgs)
			if((!is_string($mixArgs)) && (!is_numeric($mixArgs)))
				throw new Exception(5102,array("Um erro interno ocorreu durante a validação dos dados. Contacte seu administrador.","Para definir possíveis valores, estes devem ser somente string ou números"));
		
		if(func_num_args() != 1){
			$strPossibleValues = implode('#@#', func_get_args());
		}else{
			$strPossibleValues = implode('#@#', func_get_arg(0));
		}
		
		return 'possible_values '.$strPossibleValues;
	}
	
	/**
	 * Define uma mensagem de erro personalizada caso a validação dê errado
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strError
	 */
	public static function setErrorMsg($strError){
		return 'error_msg '.$strError;
	}
	
	/**
	 * Aplica uma expressão regular no valor do atributo para ver se está no formato adequado.
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strRegex Expressão regular
	 * @param string $strModifier [default: ''] Modificadores de expressão regular
	 */
	public static function applyRegex($strRegex, $strModifier = ''){
		return 'apply_regex /'.$strRegex.'/'.$strModifier;
	}
	
	/**
	 * Define o nome do campo para que ele seja usado nas mensagens de erro, caso necessário
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param string $strRegex
	 */
	public static function setFieldLabel($strFieldLabel){
		return 'field_label '.$strFieldLabel;
	}
	
	/**
	 * Obtém uma regra do array de regras passadas no parâmetro
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrAttrRules
	 */
	public static function getCustomField($strField, array $arrAttrRules){
		
		foreach ($arrAttrRules as $strRule) {
			$arrTmp = explode(' ', $strRule,2);
			
			if($arrTmp[0] == $strField){
				$arrReturn['field'] = $strField;
				
				//os typos no array abaixo não terão parâmetros
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
	 * Obtém o label do campo. Ou pelo comentário ou se passado via regra
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrAttrRules
	 */
	public static function getFieldLabel(array $arrAttrRules){
		//verificar se foi passado o label do campo nas regras de validação
		$objCustomField = self::getCustomField('field_label', $arrAttrRules);
		if($objCustomField !== false){
			return self::getCustomField('field_label', $arrAttrRules)->value;
		}else{
			throw new Exception(5102,array('O label obrigatório do campo de validação não foi definido na configuração das regras de validação do objeto a ser validado.','O programador não passou o label de algum campo'));
		}
	}
	
	/**
	 * Obtém o tipo do campo definido nas regras de validação.
	 * 
	 * @static
	 * @access public
	 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param array $arrAttrRules
	 */
	public static function getFieldType(array $arrAttrRules){
		//verificar se foi passado o label do botão nas regras de validação
		return self::getCustomField('type_as', $arrAttrRules);
	}
}
?>