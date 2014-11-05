<?php namespace WRTemplate;

/**
 * Classe responsável por transformar um Object em HTML
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class SmartCodeParser{
	
	/**
	 * Tags especiais que ajudam na escrita dos códigos HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-27>
	 * @since 1.0
	 * @var array $arrSpecialTags
	 */
	private $arrSpecialTags = array(
		"inputtext",
		"inputbutton",
		"checkbox",
		"file",
		"hidden",
		"password",
		"radio",
		"reset",
		"cancelback",
		"submit"
	);
	
	/**
	 * Atributos especiais
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-27>
	 * @since 1.0
	 * @var array $arrSpecialAttributes
	 */
	private $arrSpecialAttributes = array(
		//todos os elementos possuem
		'#'=>			array('*'),								//id
		'@'=>			array('*'),								//name
		'#@'=>			array('*'),								//id e name
		'@#'=>			array('*'),								//id e name
		'.'=>			array('*'),								//class
		'$'=>			array('*'),								//valor/conteúdo
		'§'=>			array('*'),								//style
		
		//para alguns elementos
		//'grp'=>			array('option'),					//grupo de options no select
		'selected'=>	array('option'),						//atributo selected="selected"
		'checked'=>		array('checkbox','radio','input'),		//atributo checked="checked"
		'label'=>		array('option','checkbox','radio'),		//adiciona um label em um checkbox ou radio
		'label_'=>		array('checkbox','radio'),				//adiciona um label em um checkbox ou radio
		'multiple'=>	array('select')							//adiciona o atributo multiple="multiple" em um select
	);
	
	/**
	 * Tags HTML que são single, ou seja, não tem seu par de fechamento
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-27>
	 * @since 1.0
	 * @var array $arrSingleTags
	 */
	private static $arrSingleTags = array(
		"a",
		"br",
		"hr",
		"img",
		"input",
		"area",
		"base",
		"basefont",
		"col",
		"embed",
		"source"
	);
	
	/**
	* Verifica se este um determinado objeto pode ter elementos filhos
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access protected
	* @version 1.0 <2013-08-28>
	* @since 1.0
	* @param string $strElement
	* @return boolean
	*/
	public static function isChildable($strElement){
		return !in_array($strElement, self::$arrSingleTags);
	}
	
	
	/**
	* Processa os códigos facilitadores de criação de objetos HTML.
	* Veja o manual dos elementos e atributos especiais na pasta matriz do projeto (shorttags.txt).
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-27>
	* @since 1.0
	* @param string $strElementCode
	* @param array $arrAttributes
	* @param mixed $child Define os filhos do elemento a ser criado. Pode ser um Object, Object[] ou string contendo outro código facilitador
	* @return array
	*/
	public static function create(Object &$objObject, $strElementCode, array $arrAttributes, $child){
		
		return $objObject;
	}
	
	/**
	* Identifica os tipos dos elementos HTML presente no smartcode e define no objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-29>
	* @since 1.0
	* @param Object $objObject
	* @param string $strElementCode
	*/
	public static function parseCodeTypes(Object &$objObject){
		
		//obter o nome da tag criada
		preg_match('/^\[([\w-]*)/', $objObject->getSmartCode(),$arrMatches);
		
		if(!isset($arrMatches[1])){
			$objObject->setSmartCode('[string $"'.$objObject->getSmartCode().'"]');
			preg_match('/^\[([\w-]*)/', $objObject->getSmartCode(), $arrMatches);
			//throw new Exception(6010,$strElementCode);
		}
		
		$strElementName = $arrMatches[1];
		
		switch ($strElementName) {
			case "inputdate":
				$objObject->addClass('campo_data');
				
			case "inputtext":
				$objObject->strElementName = 'input';
				$objObject->addAttr('type','text');
				break;
				
			case "inputbutton":
				$objObject->strElementName = 'input';
				$objObject->addAttr('type','button');
				break;
				
			case "checkbox":
			case "file":
			case "hidden":
			case "password":
			case "radio":
			case "submit":
			case "reset":
				$objObject->strElementName = 'input';
				$objObject->addAttr('type',$strElementName);
				break;
				
			case "cancelback":
				$objObject->strElementName = 'input';
				$objObject->addAttr('type','button');
				$objObject->addClass('cancelback');
				break;
			
			case "string":
				$objObject->strElementName = $strElementName;
				break;
				
			default:
				$objObject->strElementName = $strElementName;
				//smartcode não existe
				//throw new Exception(6011,$strElementName);
			break;
		}
	}
	
	/**
	* Identifica os atributos dos elementos HTML presente no smartcode e define no objeto
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-29>
	* @since 1.0
	* @param Object $objObject
	* @param string $strElementCode
	*/
	public static function parseCodeAttr(Object &$objObject, array $arrExtraAttr = array()){
		$strElementCode = $objObject->getSmartCode();
		
		//
		// TRATAR OS ATRIBUTOS id, name e class
		//
		
		preg_match_all('/(\#|\@|\#\@|\@\#|\.)([\w-]+?)(\s|\])/', $strElementCode,$arrMatchesAttr1);
		if(!empty($arrMatchesAttr1[0])){
			foreach ($arrMatchesAttr1[1] as $i => $strAttrCode) {
				$strValor = trim($arrMatchesAttr1[2][$i]);
				switch ($strAttrCode) {
					case '#':
						$objObject->setAttr('id', $strValor);
						break;
					
					case '@':
						$objObject->setAttr('name', $strValor);
						break;
					
					case '#@':
					case '@#':
						$objObject->setAttr('id', $strValor)->setAttr('name', $strValor);
						break;
					
					case '.':
						$objObject->addClass($arrMatchesAttr1[2][$i]);
						break;
				}
			}
		}
		
		//
		// TRATAR OS ATRIBUTOS valor, styles e grupo de options
		//
		
		preg_match_all('/(\$|\§|grp)\"(.*?)\"(\s|\])/', $strElementCode,$arrMatchesAttr2);
		if(!empty($arrMatchesAttr2[0])){
			foreach ($arrMatchesAttr2[1] as $i => $strAttrCode) {
				$strValor = $arrMatchesAttr2[2][$i];
				switch ($strAttrCode) {
					case '$':
						$objObject->setAttr('value', $strValor);
						break;
					
					case '§':
						$objObject->setAttr('style', $strValor);
						break;
					
					case 'grp':
						$objObject->addAttr('grp', $strValor);
						break;
					
				}
			}
		}
		
		
		//
		// TRATAR OS LABELS
		//
		
		preg_match_all('/[^_]label\"(.*?)\"(\s|\])/', $strElementCode,$arrMatchesAttr3);
		if(!empty($arrMatchesAttr3[0])){
			foreach ($arrMatchesAttr3[1] as $strAttrCode) {
				$objObject->setAttr('label', $arrMatchesAttr3[1][0]);
			}
		}
		
		//
		// TRATAR OS LABELS COM CLASSE
		//
		
		preg_match_all('/label_([\w-]+?)\"(.*?)\"(\s|\])/', $strElementCode,$arrMatchesAttr4);
		if(!empty($arrMatchesAttr4[0])){
			foreach ($arrMatchesAttr4[1] as $strAttrCode) {
				$objObject->setAttr('label_class_name', $arrMatchesAttr4[1][0]);
				$objObject->setAttr('label_value', $arrMatchesAttr4[2][0]);
			}
		}
		
		//
		// TRATAR OS atalhos de alguns atributos
		//
		
		preg_match_all('/(disabled|readonly|selected|checked)/', $strElementCode,$arrMatchesAttr5);
		if(!empty($arrMatchesAttr5[0])){
			foreach ($arrMatchesAttr5[1] as $i => $strAttrCode) {
				$strValor = $arrMatchesAttr5[1][$i];
				switch ($strAttrCode) {
					case 'disabled':
					case 'readonly':
					case 'selected':
					case 'checked':
						$objObject->setAttr($strValor, $strValor);
						break;
				}
			}
		}
		
		//
		// TRATAR OS OUTROS ATRIBUTOS
		//
		
		preg_match_all('/[^_](maxlength)\"(.*?)\"(\s|\])/', $strElementCode,$arrMatchesAttr6);
		if(!empty($arrMatchesAttr6[0])){
			foreach ($arrMatchesAttr6[1] as $strAttrCode) {
				$objObject->setAttr($arrMatchesAttr6[1][0], $arrMatchesAttr6[2][0]);
			}
		}
		
		
		
		//
		// ADICIONAR OS ATRIBUTOS EXTRAS
		//
		
		if(!empty($arrExtraAttr)){
			foreach ($arrExtraAttr as $strAttrName => $strAttrVal) 
				$objObject->addAttr($strAttrName, $strAttrVal);
			
		}
		
	}
	
	/**
	* Identifica elementos com labels e os cria
	* 
	* @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	* @access public
	* @version 1.0 <2013-08-29>
	* @since 1.0
	* @param Object $objObject
	* @return Object
	*/
	public static function labelsDetect($objObject){
		
		try{
			$strLabel = $objObject->getAttr('label');
			$objObject->removeAttr('label');

			if(self::isChildable($objObject->strElementName)){
			//if($objObject->strElementName == 'option'){
				$objObject->addChild(HTML::_($strLabel));
				//$objObject->addAttr('label_'.$objObject->strElementName, $strLabel);
				return $objObject;
				
			}else{
				$objLabel = HTML::_('[label $"'.$strLabel.'"]');
				$objLabel->addChild($objObject);
				return $objLabel;
			}
			
		}catch(Exception $objEx){/* não tem o atributo label*/}
		
		try{
			$strLabelClassName = $objObject->getAttr('label_class_name');
			$strLabelValue = $objObject->getAttr('label_value');
			$objObject->removeAttr('label_class_name')->removeAttr('label_value');
			
			if($objObject->strElementName == 'option'){
				$objObject->addChild(HTML::_($strLabelValue));
				$objObject->setAttr('class', $strLabelClassName);
				return $objObject;
				
			}else{
				$objLabel = HTML::_('[label .'.$strLabelClassName.' label"'.$strLabelValue.'"]');
				$objLabel->addChild($objObject);
				return $objLabel;
			}
			
			return $objLabel;
			
		}catch(Exception $objEx){/* não tem o atributo label_class_name*/}
		
		return $objObject;
	}
}