<?php
namespace WRValidator;

/**
 * Classe que cont�m os m�todos de execu��o da valida��o
 * 
 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
 * @version 1.0.0 15/03/2012 17:34:22
 */
class Run{
	
	/**
	 * Checa se o m�todo/atributo/constante passado para recupera��o do dado do objeto existe e retorna seu valor
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param object $objToValidate
	 * @param string $strAttrName
	 * @throws Exception 5104
	 * @return mixed
	 */
	public static function getValue($objToValidate, $strAttrName){
		$objReflClass = new \ReflectionClass($objToValidate);
		
		//verificar se � um objeto de classe padr�o (standard do php)
		if((get_class($objToValidate) == 'stdClass') && (array_key_exists($strAttrName, get_object_vars($objToValidate)))){
			$arrProperties = get_object_vars($objToValidate);
			return $arrProperties[$strAttrName];
			
		//verifica se possui o m�todo no objeto passado
		}elseif($objReflClass->hasMethod($strAttrName)){
			$objReflMethod = $objReflClass->getMethod($strAttrName);
			$objReflMethod->setAccessible(true);
			return $objReflMethod->invoke($objToValidate,$strAttrName);
				
		//verifica se possui o atributo no objeto passado
		}elseif($objReflClass->hasProperty($strAttrName)){
			$objReflProperty = $objReflClass->getProperty($strAttrName);
			$objReflProperty->setAccessible(true);
			return $objReflProperty->getValue($objToValidate);
			
		//verifica se possui a constante no objeto passado
		}elseif ($objReflClass->hasConstant($strAttrName)){
			return $objReflClass->getConstant($strAttrName);
			
		//verificar se � um m�todo que retorna um outro objeto
		}elseif(strpos($strAttrName, '->') !== FALSE){
			//$strAttrName = 'abc()->bgc()->def()';
			$strAttrName = str_replace('()','',$strAttrName);
			
			$arrCalls = explode('->',$strAttrName);
			
			$mixValue = clone $objToValidate;
			foreach ($arrCalls as $i => $strAttrName) {
				$objReflMethod = $objReflClass->getMethod($strAttrName);
				$objReflMethod->setAccessible(true);
				$mixValue = $objReflMethod->invoke($mixValue);
				if(count($arrCalls) != ($i +1))
					$objReflClass = new \ReflectionClass($mixValue);
					
			}
			
			return $mixValue;
			
		}else{
			throw new Exception(5104,array($objToValidate, $strAttrName));
		}
	}
	
	/**
	 * Valida��o de campo obrigat�rio
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param stdClass $objToValidate
	 * @param string $strAttrName
	 * @param array $arrAttrRules
	 * 
	 * @throws Exception 5011
	 */
	public static function requiredFieldValidation($objToValidate, $strAttrName, $arrAttrRules){
		$mixVariableValue = self::getValue($objToValidate, $strAttrName);
		if (($mixVariableValue == '') || (is_null($mixVariableValue))){
			$strAttrLabel = Rules::getFieldLabel($arrAttrRules);
			throw new Exception(5011,Rules::getFieldLabel($arrAttrRules));
		}
	}
	
	/**
	 * Valida��o de campo com poss�veis valores predefinidos
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param stdClass $objToValidate
	 * @param string $strAttrName
	 * @param array $arrAttrRules
	 * 
	 * @throws Exception 5024
	 */
	public static function possibleValuesValidation($objToValidate, $strAttrName, $arrAttrRules){
		$arrPossibleValues = explode('#@#',Rules::getCustomField('possible_values',$arrAttrRules)->value);
		$strUserVal = self::getValue($objToValidate, $strAttrName);
		if(!in_array($strUserVal,$arrPossibleValues))
			throw new Exception(5024,array(Rules::getFieldLabel($arrAttrRules)));
	}
	
	/**
	 * Valida��o de campo usando express�o regular
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param stdClass $objToValidate
	 * @param string $strAttrName
	 * @param array $arrAttrRules
	 * 
	 * @throws Exception 5025
	 */
	public static function regexValidation($objToValidate, $strAttrName, $arrAttrRules){
		$strUserVal = self::getValue($objToValidate, $strAttrName);
		$objParameters = Rules::getCustomField('apply_regex',$arrAttrRules);
		preg_match($objParameters->value,$strUserVal,$arrMatch);
		if(empty($arrMatch))
			throw new \Exception(NULL,5025);
	}
	
	/**
	 * Valida��o de tipo do campo
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param stdClass $objToValidate
	 * @param string $strAttrName
	 * @param array $arrAttrRules
	 * 
	 * @throws Exception 5012 INT
	 * @throws Exception 5013 DATE
	 * @throws Exception 5016 NUMERIC
	 * @throws Exception 5018 FLOAT
	 * @throws Exception 5019 E-MAIL
	 * @throws Exception 5020 MULTI E-MAIL
	 * @throws Exception 5022 CPF
	 * @throws Exception 5023 CEP
	 */
	public static function typeValidation($objToValidate, $strAttrName, $arrAttrRules){
		
		$mixVariableValue = self::getValue($objToValidate, $strAttrName);
		$objFieldType = Rules::getFieldType($arrAttrRules);
		
		try{
			//testar os tipos
			switch ('type_as '.trim($objFieldType->value)) {
				
				//
				// SIMPLE VERIFICATIONS
				//
				
				case Rules::TYPE_AS_INT: 			self::typeValidationAsInt($mixVariableValue); break;
				case Rules::TYPE_AS_NUMERIC: 		self::typeValidationAsNumeric($mixVariableValue); break;
				case Rules::TYPE_AS_FLOAT:			self::typeValidationAsFloat($mixVariableValue); break;
				case Rules::TYPE_AS_EMAIL:			self::typeValidationAsEmail($mixVariableValue); break;
				case Rules::TYPE_AS_CPF:			self::typeValidationAsCpf($mixVariableValue); break;
				case Rules::TYPE_AS_CEP:			self::typeValidationAsCep($mixVariableValue); break;
				
				//
				// HARD VERIFICATIONS
				//
				
				case Rules::TYPE_AS_DATE:
					$objField = Rules::getFieldType($arrAttrRules);
					
					if(isset($objField->params) && (isset($objField->params->user_date_format)))
						self::typeValidationAsDate($mixVariableValue,$objField->params->user_date_format); 
					else
						self::typeValidationAsDate($mixVariableValue); 
					
					break;
					
				case 'type_as multi_email':
					$objField = Rules::getFieldType($arrAttrRules);	
					self::typeValidationAsMultiEmail($mixVariableValue, $objField->params->separator,Rules::getFieldLabel($arrAttrRules));
					break;
			}
			
		}catch(\Exception $objEx){
			//tratamento final da exception, se precisar
			switch ($objEx->getCode()) {
				case 5020:
					$strAttrLabel = Rules::getFieldLabel($arrAttrRules);
					//A mensagem da exception ($objEx->getMessage()) cont�m o e-mail incorreto na lista dentre todos os que foram passados
					throw new Exception($objEx->getCode(),array(Rules::getFieldLabel($arrAttrRules),$objEx->getMessage()));
				break;
				
				default:
					$strAttrLabel = Rules::getFieldLabel($arrAttrRules);
					throw new Exception($objEx->getCode(),array(Rules::getFieldLabel($arrAttrRules),$mixVariableValue));
				break;
			}
		}
	}
	
	/**
	 * Valida��o de tipo do campo como INT
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * 
	 * @throws Exception 5012
	 */
	private static function typeValidationAsInt($strValue){
		if((!is_numeric($strValue)) || (strpos($strValue, '.') !== false)){
			throw new \Exception(NULL,5012);
		}
	}
	
	/**
	 * Valida��o de tipo do campo como FLOAT
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * 
	 * @throws Exception 5018
	 */
	private static function typeValidationAsFloat($strValue){
		//ver se j� de cara � float
		if(!is_float($strValue)){
			//tenta ver se ainda tem o formato de float
			//self::regexValidation($objToValidate, $strAttrName, $arrAttrRules)
			preg_match('/^(\-)?([0-9]*)(\.){1}([0-9]*)(e|E)*(\-|\+)?([0-9]+)$/', (string) $strValue,$arrIsFloat);
			if(empty($arrIsFloat))
				//realmente n�o � float
				throw new \Exception(NULL,5018);
		}
	}
	
	/**
	 * Valida��o de tipo do campo como NUMERIC
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * 
	 * @throws Exception 5016
	 */
	private static function typeValidationAsNumeric($strValue){
		try {
			//verifica se � int
			self::typeValidationAsInt($strValue);
			
		}catch(\Exception $e){
			try {
				//se n�o for, verifica se � float
				self::typeValidationAsFloat($strValue);
				
			}catch(\Exception $e){
				throw new \Exception(NULL,5016);
			}
		}
	}
	
	/**
	 * Valida��o de tipo do campo como DATE
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * @param string $strFormat (default: false)
	 * 
	 * @throws Exception 5013
	 */
	
	private static function typeValidationAsDate($mixValue, $strFormat = false){
		if((gettype($mixValue) == 'object') && (get_class($mixValue) == 'DateTime')){
			return true;
			
		}else if(gettype($mixValue) == 'string'){
			$objDate = \DateTime::createFromFormat($strFormat, $mixValue);
			if($objDate !== false)
				return true;
		}
		
		throw new \Exception(NULL,5013);
	}
	
	/**
	 * Valida��o de campo com quantidade limitada de caractere
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param stdClass $objToValidate
	 * @param string $strAttrName
	 * @param array $arrAttrRules
	 * 
	 * @throws Exception 5017
	 */
	public static function maxLenghValidation($objToValidate, $strAttrName, $arrAttrRules){
		$strValue = self::getValue($objToValidate, $strAttrName);
		$arrParameters = Rules::getCustomField('max_lenght',$arrAttrRules);
		
		if(strlen($strValue) > $arrParameters->value)
			throw new Exception(5017,array(Rules::getFieldLabel($arrAttrRules),$arrParameters->value,strlen($strValue)));
	}

	/**
	 * Valida��o de campo data usu�rio maior que data refer�ncia 
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param stdClass $objToValidate
	 * @param string $strAttrName
	 * @param array $arrAttrRules
	 * 
	 * @throws Exception 5014 >=
	 * @throws Exception 5015 >
	 */
	public static function dateGreaterThanValidation($objToValidate, $strAttrName, $arrAttrRules){
		
		$mixUserDate = self::getValue($objToValidate, $strAttrName);
		$objGreaterThanParameters = Rules::getCustomField('date_greater_than',$arrAttrRules);
		
		//verificar se passou o tipo do dado como data. Se n�o passou, define.
		if(Rules::getFieldType($arrAttrRules) === false){
			if((is_object($mixUserDate)) && (get_class($mixUserDate) == 'DateTime')){
				$arrAttrRules[] = Rules::TYPE_AS_DATE;
			}else{
				$arrAttrRules[] = Rules::typeAsDateStr($objGreaterThanParameters->params->user_date_format);
			}
		}
		
		//validar se � data v�lida
		self::typeValidation($objToValidate, $strAttrName, $arrAttrRules);
		
		//verifica se a data do objeto do usu�rio j� � um DateTime
		if((is_object($mixUserDate)) && (get_class($mixUserDate) == 'DateTime')){
			$objUserDate = $mixUserDate;
			
		}else{
			//
			$objUserDate = \DateTime::createFromFormat($objGreaterThanParameters->params->user_date_format, $mixUserDate);
			if($objUserDate === false)
				throw new Exception(5013,array(Rules::getFieldLabel($arrAttrRules),$mixUserDate));
				
		}
		
		//criar o DateTime de compara��o
		$objDateGreaterThan = \DateTime::createFromFormat($objGreaterThanParameters->params->compare_date_format, $objGreaterThanParameters->value);
		
		//
		// GARANTIDO QUE A DATA DE COMPARA��O E A DATA DO OBJETO DO USU�RIO � UM DATETIME, FAZER A COMPARA��O
		//
		
		//processando a compara��o usando o > e o >=
		if(($objGreaterThanParameters->params->equals == 1) && ($objUserDate < $objDateGreaterThan)){
			$arrExParams = array(Rules::getFieldLabel($arrAttrRules),$objUserDate->format('d/m/Y'),$objDateGreaterThan->format('d/m/Y'));
			throw new Exception(5014, $arrExParams);
			
		}elseif(($objGreaterThanParameters->params->equals == 0) && ($objUserDate <= $objDateGreaterThan)){
			$arrExParams = array(Rules::getFieldLabel($arrAttrRules),$objUserDate->format('d/m/Y'),$objDateGreaterThan->format('d/m/Y'));
			throw new Exception(5015, $arrExParams);
			
		}
	}
	
	/**
	 * Valida��o de tipo do campo como E-MAIL
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * 
	 * @throws Exception 5019
	 */
	private static function typeValidationAsEmail($strValue){
		preg_match('/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)*(\.[\w]{2,4})$/', (string) $strValue,$arrIsMail);
		if(empty($arrIsMail))
			throw new \Exception(NULL,5019);
	}
	
	/**
	 * Valida��o de tipo do campo como CEP
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * 
	 * @throws Exception 5023
	 */
	private static function typeValidationAsCep($strValue){
		//tentar verificar se vem no formato completo com pontua��o
		preg_match('/^(\d){2}\.(\d){3}\-(\d){3}$/',$strValue,$arrMatch);
		if(empty($arrMatch)){
			//caso n�o, verificar se veio somente n�meros e h� sete deles
			$intMatch = preg_replace('/[^0-9]/', '', $strValue);
			if((strlen($strValue) != 7) || (strlen($strMatch) != 7))
				throw new \Exception(NULL,5023);
			
		}
	}
	
	/**
	 * Valida��o de tipo do campo como CPF
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * 
	 * @throws Exception 5022
	 */
	private static function typeValidationAsCpf($strValue){
		$cpf = $strValue;
		
		//
		// CÓDIGO OBTIDO EM: http://codigofonte.uol.com.br/codigo/php/validacao/funcao-php-para-validar-cpf
		//
		
		//Etapa 1: Cria um array com apenas os digitos num�ricos, isso permite receber o cpf em diferentes formatos como "000.000.000-00", "00000000000", "000 000 000 00" etc...
		$j=0;
		$num = array();
		for($i=0; $i<(strlen($cpf)); $i++){
			if(is_numeric($cpf[$i]))
				{
					$num[$j]=$cpf[$i];
					$j++;
				}
		}
		
		//Etapa 2: Conta os d�gitos, um cpf v�lido possui 11 d�gitos num�ricos.
		if(count($num)!=11){
			$isCpfValid=false;
		}
		//Etapa 3: Combina��es como 00000000000 e 22222222222 embora n�o sejam cpfs reais resultariam em cpfs v�lidos ap�s o calculo dos d�gitos verificares e por isso precisam ser filtradas nesta parte.
		else
			{
				for($i=0; $i<10; $i++)
					{
						if ($num[0]==$i && $num[1]==$i && $num[2]==$i && $num[3]==$i && $num[4]==$i && $num[5]==$i && $num[6]==$i && $num[7]==$i && $num[8]==$i)
							{
								$isCpfValid=false;
								break;
							}
					}
			}
		//Etapa 4: Calcula e compara o primeiro d�gito verificador.
		if(!isset($isCpfValid))
			{
				$j=10;
				for($i=0; $i<9; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);	
				$resto = $soma%11;			
				if($resto<2)
					{
						$dg=0;
					}
				else
					{
						$dg=11-$resto;
					}
				if($dg!=$num[9])
					{
						$isCpfValid=false;
					}
			}
		//Etapa 5: Calcula e compara o segundo d�gito verificador.
		if(!isset($isCpfValid))
			{
				$j=11;
				for($i=0; $i<10; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);
				$resto = $soma%11;
				if($resto<2)
					{
						$dg=0;
					}
				else
					{
						$dg=11-$resto;
					}
				if($dg!=$num[10])
					{
						$isCpfValid=false;
					}
				else
					{
						$isCpfValid=true;
					}
			}
			
		//Etapa 6: Retorna o Resultado em um valor booleano.
		
		if(!$isCpfValid)
			throw new \Exception(NULL,5022);
	
	}
	
	/**
	 * Valida��o de tipo do campo como MULTI E-MAIL
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * 
	 * @param string $strValue
	 * @param string $strMultiEmailSeparator
	 * @param string $strFieldLabel
	 * 
	 * @throws Exception 5020
	 */
	private static function typeValidationAsMultiEmail($strValue, $strMultiEmailSeparator, $strFieldLabel){
		$arrEmails = array_map('trim', explode($strMultiEmailSeparator,$strValue));
		foreach ($arrEmails as $strEmail) {
			try{
				self::typeValidationAsEmail($strEmail);
				
			}catch(\Exception $e){
				throw new \Exception($strEmail,5020);
			}
		}
	}
}
?>