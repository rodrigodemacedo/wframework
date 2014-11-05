<?php namespace WRTemplate;

/**
 * Super classe que define todos os objetos HTML
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @version 1.0 <2013-08-26>
 * @package wrtemplate
 * @subpackage classes
 */
class Object{
	
	//
	// CONSTANTS
	//
	
	const ADD_CHILD_PRIMEIRO = 0;
	const ADD_CHILD_SEGUNDO = 1;
	const ADD_CHILD_PENULTIMO = -2;
	const ADD_CHILD_ULTIMO = -1;
	
	//
	// Attributes
	//
	
	/**
	 * Nome do elemento
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string strElementName
	 */
	public $strElementName;
	
	/**
	 * Atributos do objeto HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-26>
	 * @since 1.0
	 * @var array arrAttributes
	 */
	private $arrAttributes = array();
	
	/**
	 * Smartcode de criação do objeto HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-26>
	 * @since 1.0
	 * @var string $strSmartCode
	 */
	private $strSmartCode;
	
	/**
	 * Elementos Filhos
	 * 
	 * @access public
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var Object[] arrChildObjects
	 */
	private $arrChildObjects = array();

	//
	// CONSTRUTOR
	//
	
	protected function __construct(){}
	
	/*
	protected function __construct($strElementSmartCode, array $arrAttributes = array(), array $arrChildObjects = array()){
		$this->setSmartCode($strElementSmartCode);
		
		//definir a tag html do objeto
		SmartCodeParser::parseCodeTypes($this);
		
		//definir os atributos definidos para o objeto
		SmartCodeParser::parseCodeAttr($this);
		
		//em caso de criação de labels, retorna junto
		SmartCodeParser::labelsDetect($this);
		
		//return SmartCodeParser::create($this, $strElementSmartCode, $arrAttributes, $arrChildObjects);
	}
	*/
	//
	// METODOS
	//
	
	/**
	* Retorna um determinado atributo do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return string
	* @throws \WRTemplate\Exception
	*/
	public function getAttr($strAttrNameToFind){
		$strAttrNameToFind = strtolower($strAttrNameToFind);
		if(!isset($this->arrAttributes[$strAttrNameToFind]))
			throw new Exception(6001, $strAttrNameToFind);
		
		return $this->arrAttributes[$strAttrNameToFind];
	}
	
	
	
	/**
	* Adiciona um determinado atributo para o objeto. Se já existir, altera
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return \WRTemplate\Object
	*/
	public function setAttr($strAttrName, $strAttrValue){
		return $this->addAttr($strAttrName, $strAttrValue);
	}
	
	/**
	* Adiciona um determinado atributo para o objeto. Se já existir, altera
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return \WRTemplate\Object
	*/
	public function addAttr($strAttrName, $strAttrValue){
		$strAttrName = strtolower($strAttrName);
		$this->arrAttributes[$strAttrName] = $strAttrValue;
		
		return $this;
	}
	
	/**
	* Remove um determinado atributo para o objeto.
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return \WRTemplate\Object
	*/
	public function removeAttr($strAttrName){
		$strAttrName = strtolower($strAttrName);
		unset($this->arrAttributes[$strAttrName]);
		
		return $this;
	}
	
	/**
	* Define vários atributos para o objeto de uma só vez
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @param string[] Array com os atributos (chave => valor)
	* @return \WRTemplate\Object
	*/
	public function addAttrArray(array $arrAtributos){
		foreach ($arrAtributos as $strAttrName => $strAttrValue) 
			$this->addAttr($strAttrName, $strAttrValue);
		
		return $this;
	}
	
	/**
	* Retorna o atributo ID do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return string
	*/
	public function getId(){
		return $this->getAttr('id');
	}
	
	/**
	* Define o atributo ID do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return \WRTemplate\Object
	*/
	public function setId($strId){
		$this->setAttr('id',$strId);
		return $this;
	}
	
	/**
	* Retorna o atributo NAME do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return string
	*/
	public function getName(){
		return $this->getAttr('name');
	}
	
	/**
	* Define o atributo NAME do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @param string $strName
	* @return \WRTemplate\Object
	*/
	public function setName($strName){
		$this->setAttr('name',$strName);
		return $this;
	}
	
	/**
	* Retorna o atributo CLASS do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @param
	* @return mixed (string ou string[])
	*/
	public function getClass($strClassName = ''){
		die(__FILE__ . '::'.__LINE__);
		/*
		if($strClassName != ''){
			return explode(' ',$strClassName);
		}else{
			return explode(' ',$this->getAttr('class'));
		}
		
		return $this->getAttr('id');
		*/
	}
	
	/**
	* Define o atributo ID do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @param string $strClass
	* @return \WRTemplate\Object
	*/
	public function setClass($strClass){
		$this->setAttr('class',$strClass);
		return $this;
	}
	
	/**
	* Adiciona mais uma classe ao objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return \WRTemplate\Object
	*/
	public function addClass($strClass){
		try{
			$this->setClass($this->getAttr('class').' '.$strClass);
			
		}catch(Exception $objEx){
			$this->addAttr('class', $strClass);
		}
		
		return $this;
	}
	
	
	/**
	* Retorna o atributo STYLE do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return string
	*/
	public function getStyle(){
		die(__FILE__ . '::'.__LINE__);
		/*return $this->getAttr('id');*/
	}
	
	/**
	* Define o atributo STYLE do objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return \WRTemplate\Object
	*/
	public function setStyle($strId){
		die(__FILE__ . '::'.__LINE__);
		/*return $this->setAttr('class',$strId);*/
		return $this;
	}
	
	
	//
	// GETTERS AND SETTERS
	//
	
	/**
	* Retorna o valor do atributo $this->arrAttributes
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return array
	*/
	public function getAttrArray(){
		return $this->arrAttributes;
	}
	
	/**
	* Retorna Objects por meio de uso de códigos facilitadores de criação de objetos HTML.
	* Veja o manual dos elementos e atributos especiais na pasta matriz do projeto (shorttags.txt).
	* 
	* @final
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @param string $strElementCode
	* @param array $arrAttributes
	* @param mixed $child Define os filhos do elemento a ser criado. Pode ser um Object, Object[] ou string contendo outro código facilitador
	* @return Object
	*//*
	public static final function _($strElementCode, array $arrAttributes = array(), $child = false){
		
	}*/
	
	/**
	 * Adiciona um filho ao objeto por padrão na última posição da lista
	 * 
	 * ADD_CHILD_PRIMEIRO
	 * ADD_CHILD_SEGUNDO
	 * 3 - N...
	 * ADD_CHILD_PENULTIMO
	 * ADD_CHILD_ULTIMO
	 * 
	 * @param mixed $objChild
	 * @param int $intPosition
	 */
	public function addChild(Object $objChild, $intPosition = self::ADD_CHILD_ULTIMO){
		
		$intPosition = (int) $intPosition;
		
		//ajuste de inserção do elemento
		if(($intPosition < -2) || (count($this->arrChildObjects) == 0)){
			$intPosition = self::ADD_CHILD_PRIMEIRO;
			
		}else if($intPosition > count($this->arrChildObjects)){
			$intPosition = self::ADD_CHILD_ULTIMO;
			
		}else if(count($this->arrChildObjects) == 1){
			switch ($intPosition) {
				case self::ADD_CHILD_SEGUNDO:
					$intPosition = self::ADD_CHILD_ULTIMO;
					break;
					
				case self::ADD_CHILD_PENULTIMO:
					$intPosition = self::ADD_CHILD_PRIMEIRO;
					break;
			}
		}
		
		if(SmartCodeParser::isChildable($this->strElementName)){
			
			switch ($intPosition) {
				//adiciona o filho novo na primeira posição
				case self::ADD_CHILD_PRIMEIRO:
					$this->arrChildObjects = array_merge(array($objChild),$this->arrChildObjects);
					break;
				
				//adiciona o filho novo na segunda posição
				case self::ADD_CHILD_SEGUNDO:
					$arrFilhos = array($this->arrChildObjects[0],$objChild);
					unset($this->arrChildObjects[0]);
					$this->arrChildObjects = array_merge($arrFilhos,array_values($this->arrChildObjects));
					break;
				
				//adiciona o filho novo na penúltima posição
				case self::ADD_CHILD_PENULTIMO:
				case count($this->arrChildObjects) -1:
					$arrFilhos = array($objChild, $this->arrChildObjects[count($this->arrChildObjects) -1]);
					unset( $this->arrChildObjects[count($this->arrChildObjects) -1]);
					$this->arrChildObjects = array_merge(array_values($this->arrChildObjects), $arrFilhos);
					break;
				
				//adiciona o filho novo na última posição
				case self::ADD_CHILD_ULTIMO:
				case count($this->arrChildObjects):
					$this->arrChildObjects[] = $objChild;
					break;
				
				//caso a posição seja entre a segunda e a penúltima, inserir
				default:
					$this->arrChildObjects = array_values(array_merge(
						array_slice($this->arrChildObjects, 0, $intPosition -1),
						array($objChild),
						array_slice($this->arrChildObjects, $intPosition -1)
					));
					break;
			}
			
		}else{
			throw new Exception(6012,$this->getSmartCode());
		}
	}
	

	//Setters
	
	/**
	* Define o atributo strSmartCode
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @param string $strSmartCode
	* @return Object
	*/
	public function setSmartCode($strSmartCode){
		$this->strSmartCode = $strSmartCode;
		return $this;
	}
	
	/**
	* Retorna o atributo strSmartCode
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-26>
	* @since 1.0
	* @return string
	*/
	public function getSmartCode(){
		return $this->strSmartCode;
	}
	
	 /**
	 * Método que compara um objeto passado por parametro com o próprio objeto.
	 * O segundo parâmetro é opcional, sendo um array com os gets do objeto que se deseja comparar. 
	 * Não informá-lo implica na comparação de todos os Attributes.
	 * 
	 * @final
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-08-26>
	 * @since 1.0
	 * @param Object $objCompare
	 * @param array $arrGettersToCompare Array com os gets do objeto que se deseja comparar. Não informar implica na comparação de todos os Attributes.
	 * @return boolean
	 */
	public final function equals(Object $objCompare, array $arrGettersToCompare = array()) {
		//todos os métodos da classe que podem ser usados para comparação
		$arrObjGets = array(
			(object) array("get"=>"getAttributes","type"=>"arr")
		
		);
		
		//caso for passado o "$arrGettersToCompare", então somnte estes métodos serão comparados
		if(!empty($arrGettersToCompare)){
			$arrTmpGets = $arrObjGets;
			foreach ($arrTmpGets as $j => $tmpGets) {
				foreach ($arrGettersToCompare as $tmpCompare) 
					if($tmpGets->get == $tmpCompare)
						continue 2;
				
				unset($arrObjGets[$j]);
			}
		}
		
		sort($arrObjGets);
		
		foreach ($arrObjGets as $objGet) {
			$mixTmpGet = $objGet->get;
			$mixValorThis = $this->$mixTmpGet();
			$mixValorOther = $objCompare->$mixTmpGet();
			
			$strType = $objGet->type;
			if(strlen($objGet->type) != 3)
				$strType = substr($objGet->type,0,3);
			
			switch ($strType){
				case "int":
				case "str":
				case "bol":
				case "arr":
				case "flt":
					if($mixValorThis != $mixValorOther)
						return false;
						
					break;
					
				case "obj":
					
					if((!is_null($mixValorThis)) && (!$mixValorThis->equals($mixValorOther))){
						return false;
						
					}else if((is_null($mixValorThis)) && (!is_null($objCompare))){
						return false;
						
					}
					
					break;
						
				case "arrObj": //array de objetos, por segurança, não são comparados
					if((is_array($mixValorThis)) && (is_array($mixValorOther))){
						if((!empty($mixValorThis)) && (!empty($mixValorOther))){
							foreach ($mixValorThis as $i => $valor) 
								return $valor->equals($mixValorOther[$i]);
							
						}else{
							return false;
						}
					}else{
						return false;
					}
					
					break;
					
				default:
			}
		}
		
		return true;
	}
	
	/**
	 * Renderiza o objeto transformando-o em códigos HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-09>
	 * @since 1.0
	 */
	public function render($intTabIdent){
		if(($this->strElementName == 'label_label-interno')){
			//echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 20/09/2013 11:49:40h'."\n<br />";
			//var_dump($this);
			//die;
		}
		
		$strHtml  = "\r\n";
		$strHtml .= Config::tabIdent($intTabIdent)."<".$this->strElementName;
		
		//array de atributos
		$arrAttr = $this->getAttrArray();
		if(!empty($arrAttr))
			$arrAttr = $this->getAttrArray();
		
		//valor do objeto HTML
		/*
		$strValor = '';
		if(isset($arrAttr['value'])){
			$strValor = $arrAttr['value'];
			unset($arrAttr['value']);
		}
		*/
		if($this->strElementName == 'string'){
			return trim($arrAttr['value']);
		}
		
		//inserir os atributos
		foreach ($arrAttr as $attrName => $attrVal) 
			$strHtml .= ' '.$attrName.'="'.$attrVal.'"';
		
		//ver se tem fechar a tag
		//if((SmartCodeParser::isChildable($this->strElementName)) && ($this->strElementName != 'option')){
		if(SmartCodeParser::isChildable($this->strElementName)){
			$strHtml .= ">";
			
			if(!empty($this->arrChildObjects))
				foreach ($this->arrChildObjects as $objChild) 
					$strHtml .= $objChild->render($intTabIdent+1);
			
			$strHtml .= "\r\n".Config::tabIdent($intTabIdent)."</{$this->strElementName}>\r\n";
			
		}else{
			if(!empty($strValor))
				$strHtml .= " value=\"{$strValor}\"";
			$strHtml .= " />\r\n";
		}
		
		return $strHtml;
	}
	
}

/**
Classe: Object
Namespace: WRTemplate
Description: Super classe que define todos os objetos HTML
Author: Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
Package: wrtemplate
SubPackage: classes

1 Attributes nesta classe.

Atributos do objeto HTML,Attributes,arr;
*/