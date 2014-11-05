<?php namespace WRFramework;
interface FTemplateInterface{
	
	/**
	 * Executa a template em modo ajax.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-18>
	 * @since 1.0
	 * 
	 */
	public function executeAjax();
	
	/**
	 * Executa a template.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-18>
	 * @since 1.0
	 * 
	 */
	public function execute();
}
?>