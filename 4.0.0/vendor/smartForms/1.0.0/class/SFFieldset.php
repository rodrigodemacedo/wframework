<?php
/**
 * Controla o elemento HTML "<code><fieldset></fieldset></code>"
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-22>
 * @package smartforms
 * @subpackage class
 */
class SFFieldset extends SFElement{
	
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
	public $tagName = 'label';
	
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
	public $strLegend = '';
}
?>