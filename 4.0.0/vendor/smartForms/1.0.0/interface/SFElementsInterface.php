<?php
/**
 * Interface de todos os elementos que comp�em a tela
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-22>
 * @package smartForms
 * @subpackage interface
 */
interface SFElementsInterface{
	
	/**
	 * Tag do elemento que identifica seu comportamento
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-22>
	 * @since 1.0
	 * 
	 * @param string $tagName nome da tag do elemento
	 */
	public $tagName;
	
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
	public $id;
	
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
	public $name;
	
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
	public $class;
	
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
	public $attr;
}