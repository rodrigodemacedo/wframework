<?php namespace WRFramework;
/**
 * Interface que baseia todas as façades da aplicação
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-16>
 * @package core
 * @subpackage interface
 */
interface FFacadeInterface{
	
	/**
	 * Método que � executado sempre em todas as execuções sem ser do tipo AJAX do WRF, por�m ANTES do roteamento para a aplicação.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-16>
	 * @since 1.0
	 * 
	 */
	public function initBefore();
	
	/**
	 * Método que � executado sempre em todas as execuções do tipo AJAX do WRF, por�m ANTES do roteamento para a aplicação.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-17>
	 * @since 1.0
	 * 
	 */
	public function initBeforeAjax();
	
	/**
	 * Método que � executado sempre em todas as execuções sem ser AJAX do WRF, por�m DEPOIS do roteamento para a aplicação.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-16>
	 * @since 1.0
	 * 
	 */
	public function initAfter();
	
	/**
	 * Método que � executado sempre em todas as execuções do tipo AJAX do WRF, por�m DEPOIS do roteamento para a aplicação.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-17>
	 * @since 1.0
	 * 
	 */
	public function initAfterAjax();
	
	/**
	 * Método que � chamado quando nenhum outro controlador � não � mencionado, ou seja, mostra a tela principal da aplicação
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 */
	public function showIndex();
	
	/**
	 * Exibe a tela de erros, caso ocorra um.
	 * 
	 * get: string $errorMsg Mensagem do erro a ser apresentado
	 * get: int $errorCode C�digo do arro a ser apresentado
	 * get: string $actionGoTo Informe uma action ou um link completo de para onde o sistema deve ir quando o erro ocorrer. Se for action, digite seu nome. Se for link, não esque�a do "http://"
	 * get: string $labelGoTo Se o $actionGoTo estiver definido, defina tamb�m o label do bot�o que disparar� a ação
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-05>
	 * @since 1.0
	 *
	 */
	public function showErrors();
	
	/**
	 * Escreva o comportamento diante de um erro em um processo ajax
	 * 
	 * get: int $errorCode C�digo do erro a ser apresentado
	 * get: int $msg Mensagem a ser apresentada
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-05>
	 * @since 1.0
	 *
	 */
	public function showErrorsAjax();
}