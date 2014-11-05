<?php
/**
 * Controlador que lida com consultas de objetos na base de dados
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-02-04>
 * @package SmartDao
 * @subpackage controller
 */
class SDSelectController {
	
	/**
	 * Faz a coleta de todos os objetos da base de dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-04>
	 * @since 1.0
	 *
	 * @return array Todos os objetos da consulta
	 */
	public function getAll() {
		;
	}
	
	//retorna um objeto pela sua primeira chave definida
	public function getByKey($mixVal);
	
	/**
	 * Obt�m um objeto pelas suas chaves. Especifique-as
	 * 
	 * $arrConfig = array(
	 * 		'key'=> array('value','isRequired')
	 * 		'id' => array('98',true)
	 * 		'email' => array('your@email.com',false);
	 * )
	 * 
	 * @param array $arrConfig
	 */
	public function getByKeys($arrConfig);
	
	/**
	 * 
	 * Um n�mero inteiro significando a quantidade de registros
	 * @param unknown_type $intLimit
	 */
	public function setLimit($intLimitMax, $intLimitStart = false){}
	//define os atributos da classe que ser�o trazidos da base de dados ao inv�s de trazer todos
	public function setOnlyAttrToGet($arrOnlyAttributesToReturn){}
	//define a ordenação dos objetos
	public function setOrder($strOrder){}
	//define o agrupamento
	public function setGroup($strGroup){}
}
?>