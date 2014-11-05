<?php

namespace WFramework\Controller;

/**
 * Todos os controladores da aplicação devem estender desta classe
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-20>
 * @package core
 * @subpackage controller
 */
class FAppController {
	
	//
	// ATRIBUTOS
	//
	
	/**
	 * DAO que o controller pode usar ou não
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 *       
	 * @var FAppDao $objDao
	 */
	private $objDao;
	
	//
	// CONTROLADOR
	//
	
	/**
	 * Construtor da classe que por padrão ser� usado ao inv�s do construtor das classes filhas
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 *       
	 * @param FAppDao $objDao
	 *        	Objeto do tipo FAppDao ou filhos para troca de mensagens com a base de dados
	 */
	public function __construct(FAppDao $objDao = null) {
		$this->setDao ( $objDao );
	}
	
	//
	// GETTERS AND SETTERS
	//
	
	/**
	 * Retorna a DAO ou filhos para troca de mensagens com a base de dados
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 *       
	 * @return FAppDao Retorno do objeto do tipo FAppDao ou filhos para troca de mensagens com a base de dados
	 */
	public function getDao() {
		return $this->objDao;
	}
	
	/**
	 * Define a DAO ou filhos para troca de mensagens com a base de dados
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 *       
	 * @param FAppDao $objDao
	 *        	Objeto do tipo FAppDao ou filhos para troca de mensagens com a base de dados
	 */
	public function setDao(FAppDao $objDao = null) {
		$this->objDao = $objDao;
	}
}