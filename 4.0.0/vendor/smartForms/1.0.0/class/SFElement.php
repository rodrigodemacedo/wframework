<?php
/**
 * Objeto que d� in�cio � construção de uma tela
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-22>
 * @package smartforms
 * @subpackage class
 */
class SFElement implements SFElementInterface{
	
	/**
	 * Atributo "id" do elemento HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $id Atributo "id" do elemento HTML
	 */
	public $id = '';
	
	/**
	 * Atributo "name" do elemento HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $name Atributo "name" do elemento HTML
	 */
	public $name = '';
	
	/**
	 * Atributo "class" do elemento HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $class Atributo "class" do elemento HTML
	 */
	public $class = '';
	
	/**
	 * Outros atributos do elemento HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $attr Outros atributos do elemento HTML. Ex: 'for="idDoElmt" checked="checked"'...
	 */
	public $attr = '';
	
	/**
	 * �rea interna onde outros elementos são abrigados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @var SFElementInterface[] $arrObjIntraElements Conjunto de elementos armazenados para futura exibição.
	 * 
	 */
	public $arrObjIntraElements;
	
	/**
	 * Construtor da classe
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $id Atributo "id" do HTML
	 * @param string $name Atributo "name" do HTML
	 * @param string $class Atributo "class" do HTML
	 * @param string $attr Atributo "attr" do HTML
	 * @param string $objIntraElements Elementos internos a este elemento
	 */
	public function __construct($id, $name, $class, $attr, $objIntraElements) {
		$this->id = $id;
		$this->name = $name;
		$this->class = $class;
		$this->attr = $attr;
		$this->arrObjIntraElements = $arrObjIntraElements;
	}
	
	/**
	 * Adiciona um elemento dentro deste elemento
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param param_type param_name param_description
	 * 
	 * @return class_func_return_type class_func_return_description
	 */
	public function pushElement(SFElementsInterface $objElement) {
		$this->arrObjIntraElements[] = $objElement;
	}
}
?>