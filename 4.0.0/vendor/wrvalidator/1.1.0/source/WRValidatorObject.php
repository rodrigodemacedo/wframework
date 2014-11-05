<?php
namespace WRValidator;
/**
 * Classe Validadora de atributos de objetos
 * 
 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
 * @version 1.0.0 15/03/2012 15:34:22
 */
class Object{
	
	/**
	 * Objeto com os dados a serem validados
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var object
	 */
	private $objToValidate;
	
	/**
	 * Objeto com as regras a serem aplicadas
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var WRValidator\Rules
	 */
	private $objRules;
	
	/**
	 * O array que armazena as mensagens de erros das valida��es
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var string
	 */
	private $arrStrErrorMessages = array();
	
	/**
	 * Se TRUE, indica que ao primeiro erro detectado p�ra a verifica��o e j� responde. Se false, acumula as mensagens e retorna um array com elas.
	 * Padr�o: FALSE
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var boolean
	 */
	public $bolStopOnFirstError = FALSE;
	
	/**
	 * Informa se foi encontrado algum erro na valida��o
	 * 
	 * @access public
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @var boolean
	 */
	public $bolHasErrors = FALSE;
	
	/**
	 * Passe o objeto a ser validado e o objeto WRValidator\Rules com as suas valida��es
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @param object $objToValidate
	 * @param WRValidator\Rules $objRules
	 */
	public function __construct($objToValidate, Rules $objRules){
		$this->objToValidate = $objToValidate;
		$this->objRules = $objRules;
		$this->setAttrLabelsByTheirComment();
	}
	
	/**
	 * Verifica se as configura��es feitas pelo programador est�o corretas e consistentes
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 */
	public function compileRules(){
		$arrAttrRules = $this->getRules()->getAttrRules();
		
		foreach ($arrAttrRules as $strAttrName => $arrRules) :
			
			//com isso, � validado a obten��o do valor no objeto passado para valida��o. Caso n�o consiga, j� levant a exception
			$strAttrValue = Run::getValue($this->objToValidate, $strAttrName);
			
			foreach ($arrRules as $strCodeRule) :
				$arrTmpCodeRules = explode(' ', $strCodeRule,2);
				try{
					switch ($arrTmpCodeRules[0]) {
						
						//n�o h� pre-requisitos
						case Rules::REQUIRED:		break;
						
						//n�o h� pre-requisitos
						case 'type_as': 			break;
						
						//n�o h� pre-requisitos
						case 'date_greater_than':	break;
						
						//n�o h� pre-requisitos
						case 'max_lenght':			break;
						
						//pre-requisitos na chamada do m�todo setPossibleValues()
						case 'possible_values':		break;
						
						//Normalmente entram aqui os erros que n�o possuem mensagens padr�o para o usu�rio. Assim, nas regras
						//o programador deve obrigat�riamente inserir a mensagem que vai enviar par o usu�rio
						case 'apply_regex': 
							$objRequiredRule = Rules::getCustomField('error_msg', $arrRules);
							if($objRequiredRule === false)
								throw new Exception(5102,array("Um erro interno ocorreu durante a valida��o dos dados. Contacte seu administrador.","Para usar a valida��o regex no campo \"{$strAttrName}\", voc� deve definir manualmente nas regras do campo a ser validado uma mensagem de erro."));
							
					}
				}catch(Exception $objEx){
					throw $objEx;
				}
				
			endforeach;
		endforeach;
	}
	
	/**
	 * Roda a valida��o executando as valida��es configuradas para o objeto
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @throws \WRValidator\Exception
	 */
	public function run(){
		//checa se as configura��es inseridas pelo programador est�o corretas
		$this->compileRules();
		
		//obt�m todos os campos juntamente com todas as suas regras que foram definidas pelo programador
		$arrAttrRules = $this->getRules()->getAttrRules();
		
		//itera estes campos
		foreach ($arrAttrRules as $strAttrName => $arrRules) :
			
			//pega o valor do atributo da itera��o
			$strAttrValue = Run::getValue($this->objToValidate, $strAttrName);
			
			//se o valor do atributo for vazio e ele n�o for obrigat�rio, ent�o n�o h� o que validar. Passa pra o pr�ximo campo
			if((($strAttrValue == '') || (is_null($strAttrValue)) || (empty($strAttrValue))) && (!in_array(Rules::REQUIRED, $arrRules)))
				continue;
			
			//itera as regras do campo da itera��o
			foreach ($arrRules as $strCodeRule) :
			
				//gera um array com a regra e os par�metros desta regra.
				$arrTmpCodeRules = explode(' ', $strCodeRule,2);
				try{
					//cada campo a ser validado, conforme passado pelo programador, passa pelas opera��es de valida��o abaixo
					//$arrTmpCodeRules[0] cont�m a valida��o
					switch ($arrTmpCodeRules[0]) {
						
						//valida��o de campos requeridos
						case Rules::REQUIRED: 		Run::requiredFieldValidation		($this->objToValidate,$strAttrName,$arrRules); break;
						//valida��o de tipos de campos
						case 'type_as': 			Run::typeValidation					($this->objToValidate,$strAttrName,$arrRules); break;
						//valida��o de data maior que (ou igual a) 
						case 'date_greater_than': 	Run::dateGreaterThanValidation		($this->objToValidate,$strAttrName,$arrRules); break;
						//valida��o de string com numero de caractere maior que permitido
						case 'max_lenght': 			Run::maxLenghValidation				($this->objToValidate,$strAttrName,$arrRules); break;
						//valida��o onde o campo deve tes um dos valores definidos num array
						case 'possible_values': 	Run::possibleValuesValidation		($this->objToValidate,$strAttrName,$arrRules); break;
						//aplica uma express�o regular e verifica se foi satisfeito com o valor passado
						case 'apply_regex': 		Run::regexValidation				($this->objToValidate,$strAttrName,$arrRules); break;
						
					}
				}catch(Exception $objEx){
					
					//
					//ERROS NA EXECU��O DA FERRAMENTA, E N�O NOS DADOS INCORRETOS DA VALIDA��O ENVIADOS PELO USU�RIO
					//
					
					switch ($objEx->getCode()) {
						
						//este erro tem que subir. N�o � falha na verifica��o, mas sim na execu��o.
						case 5104: throw $objEx; break;
						
						//erros na verifica��o dos dados
						default:
							$this->arrStrErrorMessages[] = $objEx->getMessage();
							$this->bolHasErrors = true;
						break;
					}
					
					//se esta diretriva for verdadeira, o script para de validar ao encontrar o primeiro erro
					if($this->bolStopOnFirstError)
						throw $objEx;
						
				}catch(\Exception $objEx){
					//Normalmente entram aqui os erros que n�o possuem mensagens padr�o para o usu�rio. Assim, nas regras
					//o programador deve obrigat�riamente inserir a mensagem que vai enviar par o usu�rio
					switch ($objEx->getCode()) {
						//erro em express�o regular
						case 5025:
							//usar a mensagem de erro definida para este campo
							$this->arrStrErrorMessages[] = Rules::getCustomField('error_msg', $arrRules)->value;
							$this->bolHasErrors = true;
							
						break;
					}
				}
			endforeach;
		endforeach;
		
		if($this->bolHasErrors){
			if($this->bolStopOnFirstError){
				
			}
			
			throw new Exception(5103,array($this->arrStrErrorMessages));
		}
	}
	
	/**
	 * Retorna o objeto que cont�m as regras de valida��o
	 * 
	 * @access private
	 * @author Rodrigo de Mac�do <rferreira@jc.com.br>
	 * @since 1.0.0
	 * @return WRValidator\Rules
	 */
	public function getRules(){
		return $this->objRules;
	}
	
	private function setAttrLabelsByTheirComment(){
		return true;
		/*
		foreach ($this->getRules()->getAttrRules() as $strAttrName => $arrRules) {
			if($this->getRules()->ruleExists($strAttrName, 'field_label'))
				continue;
			
			//procurar o label do atributo
			$objClassRefl = new \ReflectionClass($this->objToValidate);
			
			if($objClassRefl->hasProperty($strAttrName)){
				$objPropRefl = $objClassRefl->getProperty($strAttrName);
				
			}else if($objClassRefl->hasMethod($strAttrName)){
				$objMethodRefl = $objClassRefl->getMethod($strAttrName);
				$arrDocComment = explode("\n",$objMethodRefl->getDocComment());
				echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 16/03/2012 11:24:53h'."\n<br />";
				var_dump($arrDocComment);
				die;
				
			}else{
				echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 16/03/2012 11:24:35h'."\n<br />";
				var_dump(true);
				die;
			}
			echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 16/03/2012 11:22:15h'."\n<br />";
			var_dump($objClassRefl->getProperty($strAttrName));
			die;
		}
		*/
	}
}
?>