<?php namespace WRFramework;

/**
 * Fachada do pacote de validações WRValidate
 *
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2014-06-22>
 * @package package\wrvalidator
 * @subpackage facade
 */
class WRValidatorFacade{
	
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
				$strFile = $this->strPckgDir.'../source/js/WRValidator.js';
				$fres = fopen($strFile, 'r');
				$strContent .= "\n\n//\n// ... \n//\n\n\n".fread($fres, filesize($strFile));
				fclose($fres);
				
				
				$strFile = $this->strPckgDir.'../source/BootstrapValidator/0.4.5/dist/js/bootstrapValidator.min.js';
				$fres = fopen($strFile, 'r');
				$strContent .= "\n\n//\n// Bootstrap Validator 0.4.5 \n//\n\n\n".fread($fres, filesize($strFile));
				fclose($fres);
				
				
				$strFile = $this->strPckgDir.'../source/Bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js';
				$fres = fopen($strFile, 'r');
				$strContent .= "\n\n//\n// Bootstrap Validator 1.3.0 \n//\n\n\n".fread($fres, filesize($strFile));
				fclose($fres);
				
				$strFile = $this->strPckgDir.'../source/Bootstrap-datepicker/1.3.0/js/locales/bootstrap-datepicker.pt-BR.js';
				$fres = fopen($strFile, 'r');
				$strContent .= "\n\n//\n// Bootstrap Validator 1.3.0 \n//\n\n\n".fread($fres, filesize($strFile));
				fclose($fres);
				break;
					
			case 'core_css':
				/*
				$strFile = $this->strPckgDir.'../source/BootstrapValidator/0.4.5/dist/css/bootstrapValidator.min.css';
				$fres = fopen($strFile, 'r');
				$strContent .= fread($fres, filesize($strFile));
				fclose($fres);
				
				$strContent .= "\n\n\n\n\n/*************************\n**************************\n**************************\n**************************\n*************************@/\n\n\n\n\n\n";
				*/
				
				$strFile = $this->strPckgDir.'../source/Bootstrap-datepicker/1.3.0/css/datepicker3.css';
				$fres = fopen($strFile, 'r');
				$strContent .= fread($fres, filesize($strFile));
				fclose($fres);
				break;
					
			default:
				die("Recurso inv&aacute;lido");
				break;
					
		}
	
		return ($strContent);
	}
	
	
	
	/**
	 * Faz a inclusão das classes para serem usadas no sistema
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2014-06-22>
	 * @since 1.0
	 * 
	 */
	public function __construct(){
		$this->strPckgDir = realpath(dirname(__FILE__).'/').'/';
		
		require_once $this->strPckgDir.'../source/WRValidatorException.php';
		require_once $this->strPckgDir.'../source/WRValidatorObject.php';
		require_once $this->strPckgDir.'../source/WRValidatorRules.php';
		require_once $this->strPckgDir.'../source/WRValidatorRun.php';
		require_once $this->strPckgDir.'../source/WRValidatorUtils.php';
	}
	
	/**
	 * Retorna os códigos JS do validador de client-side
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2014-07-01>
	 * @since 1.0
	 *
	 */
	public function getJs(){
		
	}
}