<?php

namespace WFramework\Helper;

/**
 * Classe que ajuda com operações das DAO's
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2013-12-03>
 * @package core
 * @subpackage class
 */
class FDaoHelper {
	
	/**
	 * Constante que retorna o formato de data/hora no formato portugu�s Brasileiro (d/m/Y)
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @final
	 *
	 * @access public
	 * @version 1.0 <2011-02-26>
	 * @since 1.0
	 *       
	 * @var string BR_DATE
	 */
	const BR_DATE = 'd/m/Y';
	
	/**
	 * Retorna a statement preparada
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2013-12-03>
	 *         
	 * @param
	 *        	PDO objPdo Obj PDO que será usado
	 * @param string $strSql
	 *        	SQL que será preparada
	 * @param mixed $objectToSql
	 *        	Objeto usado para preparo
	 * @param array $arrManualIndexes
	 *        	Array com as variáveis
	 *        	
	 * @return PDO PDO statement prepared
	 */
	public static function getPdoPreparedStatement(\PDO &$objPdo, $strSql, $objectToSql, array $arrManualIndexes = array()) {
		// try to get the class attrs to prepare
		preg_match_all ( '/(\:[\w_]*)(\s|\W)/', $strSql, $arrMatches );
		
		if (empty ( $arrMatches ))
			return false;
		
		$arrAllParams = $arrManualIndexes;
		
		$arrSqlPrepVars = $arrMatches [1];
		
		foreach ( $arrSqlPrepVars as $strProperty ) {
			$arrMethodTmp = explode ( '__', $strProperty );
			try {
				$objReflMethod = new \ReflectionMethod ( get_class ( $objectToSql ), $arrMethodTmp [1] );
				eval ( '$arrAllParams[$strProperty] = $objectToSql->' . $arrMethodTmp [1] . '();' );
			} catch ( \ReflectionException $objEx ) {
				return false;
			}
		}
		
		$objStatement = $objPdo->prepare ( $strSql );
		$objStatement->execute ( $arrAllParams );
		
		return $objStatement;
	}
}
?>