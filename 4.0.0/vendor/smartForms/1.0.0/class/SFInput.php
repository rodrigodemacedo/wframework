<?php
/**
 * Controla o elemento HTML "<code><input></input></code>"
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-22>
 * @package smartforms
 * @subpackage class
 */
class SFInput extends SFElement{
	
	/**
	 * Tag do elemento que identifica seu comportamento
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $tagName Nome da tag do elemento
	 */
	public $tagName = 'input';
	
	/**
	 * Legenda do fieldset
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $strLegend Legenda do fieldset
	 */
	public $value = '';
	
	
	
	/**
	 * Construtor do elemento
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
	 * @param string $value Atributo "value" do HTML
	 */
	public function __construct($id, $name, $class, $attr, $objIntraElements, $value) {
		parent::__construct($id, $name, $class, $attr, $objIntraElements);
		$this->value = $value;
	}
}
?>