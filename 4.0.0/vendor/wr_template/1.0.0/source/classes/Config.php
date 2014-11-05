<?php namespace WRTemplate;

/**
 * Defini��es das configura��es de execu��o
 *
 * @author Rodrigo de Mac�do Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 28/08/2013 13:26
 */
class Config{
	
	/**
	 * Caractere de s�mbolo de campo obrigat�rio
	 * 
	 * @author Rodrigo de Mac�do <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-08-28>
	 * @since 1.0
	 * @var string $strSimboloCampoObrigatorio
	 */
	private $strSimboloCampoObrigatorio = '*';
	
	public static function tabIdent($intTabIdentQuantity){
		$strTabIdent = '';
		for ($i = 0; $i < $intTabIdentQuantity; $i++) {
			$strTabIdent .= "\t";
		}
		
		return $strTabIdent;
	}
}