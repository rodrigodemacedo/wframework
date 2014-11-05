<?php namespace WRTemplate;

/**
 * Define os elementos Container, ou seja, suportará a exibição de todos os elementos da tela.
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
abstract class Container{
	
	
	public abstract function render($intTabIdent);
	
	protected function isContainer(array $arrObjContainers){
		
	}
	
}