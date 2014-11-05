<?php
/**
 * Classe que implementa alguns métodos da classes JDatabase do joomla
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-02-11>
 * @package joomla15Bridge
 * @subpackage class
 */
class JBridgeMySQL {
	
	/**
	 * Objeto JDatabaseMysql do joomla!
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-11>
	 * @since 1.0
	 * 
	 * @var JDatabaseMysql $objJDBMysql
	 */
	private $objJDBMysql;
	
	/**
	 * Construtor da classe
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-11>
	 * @since 1.0
	 *
	 * @param JDatabaseMysql $objJDBMysql Objeto JDatabaseMysql do joomla!
	 */
	public function __construct(JDatabaseMysql &$objJDBMysql) {
		$this->objJDBMysql =& $objJDBMysql;
	}
	
	/**
	 * Repassa a chamada do método ao objeto JDatabaseMysql, caso o método não exista nesta classe.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-11>
	 * @since 1.0
	 *
	 * @param String $strMethod Nome do método chamado
 	 * @param array $arrArguments Argumentos do método chamado
	 *
	 * @return mixed Resposta do método, pode retornar ou não
	 */
	public function __call($strMethod, $arrArguments) {
		//preparar os argumentos para passar para o banco de dados
		$strCall = "";
		for ($i = 0; $i < count($arrArguments); $i++) {
			$strCall .= '$arrArguments['.$i.'], ';
		}
		
		//preparar a chamada;
		$strCall = '$mixReturn = $this->objJDBMysql->$strMethod('.substr($strCall,0,-2).');';
		//executar
		eval($strCall);
		//se houver retorno...
		if(!is_null($mixReturn)){
			//... retornar
			return $mixReturn;
		}
	}
	
	/**
	 * Reimplementa o método BeginTrans() do JDatabase
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-11>
	 * @since 1.0
	 */
	public function BeginTrans() {
		$this->objJDBMysql->setQuery("START TRANSACTION;");
		$this->objJDBMysql->query();
	}
	
	/**
	 * Reimplementa o método RollbackTrans() do JDatabase
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-11>
	 * @since 1.0
	 */
	public function RollbackTrans() {
		$this->objJDBMysql->setQuery("ROLLBACK;");
		$this->objJDBMysql->query();
	}
	
	/**
	 * Reimplementa o método CommitTrans() do JDatabase
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-11>
	 * @since 1.0
	 */
	public function CommitTrans() {
		$this->objJDBMysql->setQuery("COMMIT;");
		$this->objJDBMysql->query();
	}
}