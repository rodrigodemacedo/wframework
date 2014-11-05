<?php
namespace WRValidator;

use \WRFramework\FIncludeHelper as FInclude;
use \WRFramework\FLanguageHelper as FLanguage;
/**
 * Classe que facilita a validação de campos em controladores
 * 
 * @author rodrigo
 * @version 1.1 <2010.07.09>
 *
 */
class JRValidator{
	
	/**
	 * Cont�m um array com as informações de cada campo com suas regras que devem ser validadas
	 * 
	 * @author Rodrigo
	 * @since 1.1
	 * @var array
	 */
	private $arrRules;
	
	/**
	 * True ou false para indicar se algum campo não obedeceu a validação imposta
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @var boolean
	 */
	public $bolHasErrors = false;
	
	/**
	 * Guarda as informações dos campos que não obedeceram a validação imposta
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @var Array
	 */
	private $arrErrorsFounded = array();
	
	/**
	 * Cont�m os tipos de validação poss�veis para serem aplicadas
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @var array
	 */
	private $arrObjValidationTypes = array(
		'req'=> 				'validateRequired',
		'dataType'=> 			'validateDataType',
		'inArray'=> 			'validateInArray',
		'mail'=> 				'validateMail',
		'password'=> 			'validatePassword',
		'date'=> 				'validateDate',
		'dateIsGreaterThan'=> 	'dateIsGreaterThan'
	);
	
	//
	//  CONSTRUCTOR
	//
	
	/**
	 * Cria o objeto e j� adiciona inicialmente uma regra de validação e o tipo de retorno
	 * 
	 * @author Rodrigo
	 * @since 1.1
	 * 
	 * @param array $arrRules
	 */
	public function __construct($arrRules, $strLanguage = 'ptbr'){
		$this->arrRules = $arrRules;
		
		FInclude::loadClass('fw.core.helper.FLanguage');
		FLanguage::getLanguage('fwPackage.jRulesValidator.lang.'.$strLanguage);
	}
	
	//
	// CAPTURA DE DADOS
	//
	
	/**
	 * Array que valida os dados vindos do parâmetro. Ele deve ser um array de object assim:
	 * 
	 * $arrPattern = array(
	 * 		(object) array(
	 * 			'pattern'=>'req|mail|confirm', //Recebe as validações que ser�o impostas ao campo "data"
	 * 			'data'=>'wrodrigo.macedo@msn.com', //campo que receber� o dado a ser validado
	 * 			'fieldName'=>'E-mail', //mensagem de erro caso não seja obedecida a validação
	 * 			'params'=>array('mailConfirm'=>'wrodrigo.macedo@msn.com'), //Array para parâmetros
	 * 			'altErrMsg'=>'Voc� deve fornecer um e-mail v�lido' //mensagem de erro alternativa, caso não queira usar a padrão no caso de erro encontrado
	 * 		)
	 * );
	 * 
	 * @param array $arrPatternWithData
	 * 
	 * @return boolean
	 */
	public function validate(){
		//itera os campos para validação
		foreach ($this->arrRules as $objItemToValidate) {
			//pegar os tipos de validação
			$arrValidationTypesToApply = explode('|',$objItemToValidate->pattern);
			//aplicar todas as validações dos campos
			foreach ($arrValidationTypesToApply as $strValidation) {
				//chamar o método de validação do dado em quest�o
				eval('$this->' . $this->arrObjValidationTypes[$strValidation] . '($objItemToValidate);');
			}
		}
		//pegar as validações
		
		return $this->bolHasErrors;
	}
	
	/**
	 * Adiciona mais um registro de erro na lista por meio do objeto ".jRulesValidator".
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @param array
	 */
	public function addError($objDataWithPattern, $strErrorMsg){
		$this->arrErrorsFounded[] = (object) array('errorMsg' => $strErrorMsg,'objAllData'=>$objDataWithPattern);
		$this->bolHasErrors = true;
	}
	
	/**
	 * Adiciona mais um campo para a validação. Envie o array com os dados que ele ser� validado com os que j� foram enviados anteriormente
	 * 
	 * @author Rodrigo
	 * @since 1.1
	 * @param array
	 */
	public function addRules($arrRules){
		$this->arrRules = array_merge($this->arrRules, $arrRules);
	}
	
	/**
	 * Obt�m uma string com a mensagem de erro, caso haja uma
	 * 
	 */
	public function getErrorMsg(){
		//verificar se h� mais de um erro
		if(count($this->arrErrorsFounded) > 1){
			//se sim, mensagem grande com todos
			$strErrorMsg = sprintf(_LANG_JRV_HAS_ERROR,count($this->arrErrorsFounded));
			foreach ($this->arrErrorsFounded as $objErrorInfo) {
				if(isset($arrErrorInfo->objAllData->altErrMsg)){
					$strErrorMsg .= ' - ' . $arrErrorInfo->objAllData->altErrMsg;
				}else{
					$strErrorMsg .= ' - ' . $objErrorInfo->errorMsg;
				}
				
				$strErrorMsg .= "\n";
			}
		}else if(count($this->arrErrorsFounded) == 1){
			//caso não, mensagem simples
			if(isset($this->arrErrorsFounded[0]->objAllData->altErrMsg)){
				$strErrorMsg = "ERRO: " . $this->arrErrorsFounded[0]->objAllData->altErrMsg;
			}else{
				$strErrorMsg = "ERRO: " . $this->arrErrorsFounded[0]->errorMsg;
			}
		}else{
			$strErrorMsg = "";
		}
		
		return $strErrorMsg;
	}
	
	
	
	//
	// M�TODOS DE VALIDA��O
	//
	
	/**
	 * Valida os campos obrigat�rios.
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @param object $objDataWithPattern Objeto contendo as informações do campo a ser validado
	 */
	public function validateRequired($objDataWithPattern){
		if($objDataWithPattern->data === ''){
			$this->addError($objDataWithPattern,sprintf(_LANG_JRV_REQUIRED_ERROR,$objDataWithPattern->fieldName));
		}
	}
	
	/**
	 * Valida os campos pelo seu tipo. Os tipos podem ser:
	 * 	bol (boolean), int (integer), dbl (double/integer)
	 * 
	 * Pode-se combinar tipos usando o caracter "|", ou seja, bol|int
	 * 
	 * @author Rodrigo
	 * @since 1.0
	 * @param object $objDataWithPattern Objeto contendo as informações do campo a ser validado
	 */
	public function validateDataType($objDataWithPattern){
		
		//pega todos os tipos, caso tenha combinado mais de um
		$arrDataType = explode('|',$objDataWithPattern->params['dataType']);
		$mixData = $objDataWithPattern->data;
		
		//itera os tipos. Para ser verdadeiro, a variável deve ser ao menos um tipo
		foreach ($arrDataType as $strType) {
			switch ($strType) {
				//verifica se o tipo do dado � (ou pode ser) um boolean 
				case 'bol':
					if((!is_bool($mixData)) && (!in_array(strtolower($mixData),array('0','false','1','true')))){
						$this->addError($objDataWithPattern,sprintf(_LANG_JRV_BOOLEAN_ERROR,$objDataWithPattern->fieldName,$mixData));
					}
				break;
				
				//verifica se o tipo do dado � (ou pode ser) um int 
				case 'int':
					$bolInt = false;
					//verifica se � n�mero
					if(is_numeric($mixData)){
						//se for zero, j� � int
						if($mixData == '0'){
							$bolInt = true;
						}else{
							if(strpos($mixData,'.') === false){
								$bolInt = true;
							}
						}
					}
					
					//verificar se não � um iteiro para adicionar o erro 
					if(!$bolInt){
						$this->addError($objDataWithPattern,sprintf(_LANG_JRV_INTEGER_ERROR,$objDataWithPattern->fieldName));
					}
				break;
				
				//verifica se o tipo do dado � (ou pode ser) um double/float 
				case 'dbl':
					if(!is_float($mixData)){
						$this->addError($objDataWithPattern,sprintf(_LANG_JRV_DOUBLE_ERROR,$objDataWithPattern->fieldName,$mixData));
					}
				break;
				
				//verifica se o tipo do dado � (ou pode ser) um n�mero 
				case 'num':
					if(!is_numeric($mixData)){
						$this->addError($objDataWithPattern,sprintf(_LANG_JRV_NUMBER_ERROR,$objDataWithPattern->fieldName));
					}
				break;
			}
		}
	}
	
	/**
	 * Procurar se um determinado valor consta dentre os permitidos
	 * 
	 * @author Rodrigo
	 * @access public
	 * @version 1.0 <2011-02-09>
	 * @since 1.0
	 * 
	 * @param object $objDataWithPattern Objeto contendo as informações do campo a ser validado
	 */
	public function validateInArray($objDataWithPattern){
		if(!in_array($objDataWithPattern->data,$objDataWithPattern->params['inArray'])){
			$this->addError($objDataWithPattern,sprintf(_LANG_JRV_IN_ARRAY_ERROR,$objDataWithPattern->fieldName,implode(',',$objDataWithPattern->params['inArray'])));
		}
	}
	
	/**
	 * Valida os campos do tipo date
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-09>
	 * @since 1.0
	 * 
	 * @param object $objDataWithPattern Objeto contendo as informações do campo a ser validado
	 */
	public function validateDate($objDataWithPattern) {
		$arrOthersPatterns = explode('|', $objDataWithPattern->pattern);
		if($objDataWithPattern->data != ''){
			//detectar separador
			$strSep = $objDataWithPattern->data[2];
			$arrDate = explode($strSep, $objDataWithPattern->data);
			
			if(is_numeric($strSep)){
				//aaaa-mm-dd
				$bolValidDate = @checkdate($arrDate[1], $arrDate[2], $arrDate[0]);
			}else{
				//dd-mm-aaaa
				$bolValidDate = @checkdate($arrDate[1], $arrDate[0], $arrDate[2]);
			}
			
			if(!$bolValidDate){
				$this->addError($objDataWithPattern,sprintf(_LANG_JRV_VALIDATE_DATE_ERROR,$objDataWithPattern->fieldName));
				return false;
			}
		}else{
			if(in_array('req', $arrOthersPatterns)){
				//caso a data esteja vazia e o "req" estiver presente, retorna false e dispara uma mensagem de erro.
				$this->addError($objDataWithPattern,sprintf(_LANG_JRV_VALIDATE_DATE_ERROR,$objDataWithPattern->fieldName));
			}
			
			//data vazia, por quest�o de controle, retorna false, porem não exibe mensagem de erro nenhuma
			return false;
		}
		return true;
	}
	
	/**
	 * Avalia se uma determinada data � maior que outra.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-09>
	 * @since 1.0
	 *
	 * @param object $objDataWithPattern Objeto contendo as informações do campo a ser validado
	 */
	public function dateIsGreaterThan($objDataWithPattern) {
		$objDataWithPattern2 = clone $objDataWithPattern;
		$objDataWithPattern2->data = $objDataWithPattern->params['dateIsGreaterThan']['date'];
		$objDataWithPattern2->fieldName = $objDataWithPattern->params['dateIsGreaterThan']['fieldName'];
		unset($objDataWithPattern2->params);
		
		//se as duas datas forem v�lidas, validar
		if(($this->validateDate($objDataWithPattern)) && ($this->validateDate($objDataWithPattern2))){
			
			//
			// PEGAR O TIMESTAMP DA DATA 1
			//
			
			//detectar separador
			$strSep = $objDataWithPattern->data[2];
			$arrDate = explode($strSep, $objDataWithPattern->data);
			
			if(is_numeric($strSep)){
				//aaaa-mm-dd
				$intDatata1 = strtotime($objDataWithPattern->data[2]);
			}else{
				//dd-mm-aaaa
				$intDatata1 = strtotime($arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0]);
				$bolValidDate = checkdate($arrDate[1], $arrDate[0], $arrDate[2]);
			}
			
			//
			// PEGAR O TIMESTAMP DA DATA 2
			//
			
			//detectar separador
			$strSep = $objDataWithPattern2->data[2];
			$arrDate = explode($strSep, $objDataWithPattern2->data);
			
			if(is_numeric($strSep)){
				//aaaa-mm-dd
				$intDatata2 = strtotime($objDataWithPattern2->data[2]);
			}else{
				//dd-mm-aaaa
				$intDatata2 = strtotime($arrDate[2].'-'.$arrDate[1].'-'.$arrDate[0]);
				$bolValidDate = checkdate($arrDate[1], $arrDate[0], $arrDate[2]);
			}
			
			//
			// COMPARAR
			//
			
			if($intDatata1 < $intDatata2){
				$this->addError($objDataWithPattern,sprintf(_LANG_JRV_DATE_GREATER_THAN_ERROR,$objDataWithPattern->fieldName, $objDataWithPattern2->fieldName));
			}
			
			return $intDatata1 > $intDatata2;
			
		}else{
			
		}
	}
}
?>