<?php
/**
 * Fachada do pacote SmartDAO
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-02-04>
 * @package smartDao
 * @subpackage facade
 */
class SDFacade {
	
	/**
	 * Atributo que guarda o mapeamento das classes da aplicação
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access private
	 * @version 1.0 <2011-02-04>
	 * @since 1.0
	 *
	 * @var array $objMap
	 */
	private static $objMap;
	
	/**
	 * Inicializa o pacote SmartDAO
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-04>
	 * @since 1.0
	 */
	public function __construct() {
		//chamar o arquivo de configuração da aplica�ao executada
		$objConfig = FConfig::getPckgConfig('smartDao');
		require_once FConfig::getAppConfig('base_dirPackages').'smartDao/'.$objConfig->version.'/inc/map.inc.php';
		
		echo '<pre>'.__FILE__.' (Linha '.__LINE__.") \n";
		var_dump($arrMap);
		echo '</pre>';
		die;
	}
	
	/**
	 * Obt�m o objeto que executa consultas ao banco de dados
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-02-04>
	 * @since 1.0
	 *
	 * @param String $strObjectClassName Nome da classe que a consulta rodar�
	 *
	 * @return SDSelectController Retorna uma inst�ncia do controlador que lida com consultas
	 */
	public  function doSelect($strObjectClassName) {
		;
	}
}