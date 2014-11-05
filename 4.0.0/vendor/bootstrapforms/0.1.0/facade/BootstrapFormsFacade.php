<?php
namespace WRFramework;

class BootstrapFormsFacade{
	
	private $strPckgDir;
	
	/**
	 * Método chave pra quando se quer que este módulo disponibilize arquivos js, css, imagem, etc...
	 *
	 * @access public
	 * @author Rodrigo de Macêdo <rodrigo@wr7solutions.com.br>
	 * @param string $strSource
	 * @return string Retorna o conteúdo do recurso
	 */
	public function getPckgSource($strSource){
		$strContent = '';
		switch ($strSource) {
			case 'core_js':
				
				$strFile = $this->strPckgDir.'source/js/bootbox.min.js';
				$fres = fopen($strFile, 'r');
				$strContent .= "\n\n//\n// ... \n//\n\n\n".fread($fres, filesize($strFile));
				fclose($fres);
				
				$strFile = $this->strPckgDir.'source/js/btspForms.js';
				$fres = fopen($strFile, 'r');
				$strContent .= "\n\n//\n// ... \n//\n\n\n".fread($fres, filesize($strFile));
				fclose($fres);
				break;
				
					
			default:
				die("Recurso inv&aacute;lido");
				break;
					
		}
	
		return ($strContent);
	}
	
	public function __construct(){
		$this->strPckgDir = realpath(dirname(__FILE__).'/../').'/';
		require_once $this->strPckgDir.'source/class/HTML.class.php';
	}
}