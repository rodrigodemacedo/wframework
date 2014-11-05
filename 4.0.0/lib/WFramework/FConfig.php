<?php
namespace WFramework;

/**
 * Classe que gerencia as variáveis de configuração da aplicação, pacotes, versões de módulos da aplicação e do WRF
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-13>
 * @package core
 * @subpackage class
 */
class FConfig {
	/**
	 * Guarda todas as configurações da aplicação
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 *
	 * @var array
	 */
	private static $arrConfig = array();

	/**
	 * Define um novo array de configurações
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * @see self::$arrConfig
	 *
	 * @param array $arrConfig configurações que serão usadas
	 */
	public static function init(&$arrConfig) {
		self::$arrConfig = $arrConfig;
		$arrConfig = null;
	}

	/**
	 * Adiciona uma nova entrada nas configurações da aplicação
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * @see self::$arrConfig
	 *
	 * @param string $strKey Chave (nome) da nova entrada de dados
	 * @param mix $mixVal Valor da nova entrada de dados
	 */
	public static function set($strKey, $mixVal) {
		self::$arrConfig[$strKey] = $mixVal;
	}

	/**
	 * Retorna um valor da chave de configurações da aplicação
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 *
	 * @access public
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * @see self::$arrConfig
	 *
	 * @param string $strKey Chave da configuração requerida
	 *
	 * @return string Retorna o valor do índice solicitado do arquivo de configurações
	 */
	public static function get($strKey) {
		if (!isset(self::$arrConfig[$strKey])) throw new Exception\FConfigException('appConfigNotFound', $strKey);
		return self::$arrConfig[$strKey];
	}
}
