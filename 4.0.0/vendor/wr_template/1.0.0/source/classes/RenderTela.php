<?php namespace WRTemplate;

/**
 * Classe que gerencia a renderização da tela
 *
 * @author Rodrigo de Macêdo Ferreira <rferreira@jc.com.br>
 * @package wr_template
 * @subpackage class
 * @version 1.0
 * @since 06/09/2013 13:26
 */
class RenderTela{
	
	/**
	 * Código HTML a ser lido pelo navegador
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 * @var string $strHTMLCode
	 */
	public static $strHTMLCode = '';
	
	/**
	 * Depois da tela montada e os elementos inseridos, chama-se este método de renderização da tela para que ela seja convertida em HTML
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-09-06>
	 * @since 1.0
	 * @param Tela $objTela Tela a ser renderizada
	 */
	public static function render(Tela $objTela, $bolEcho = true, $intTabIdent = 2){
		
		self::$strHTMLCode  = "\r\n";
		self::$strHTMLCode .= Config::tabIdent($intTabIdent)."<!-- TELA_INIT -->\r\n";
		self::$strHTMLCode .= Config::tabIdent($intTabIdent)."<div id=\"corpo\">\r\n";
		self::$strHTMLCode .= Config::tabIdent($intTabIdent)."	<h2 class=\"titulo\">{$objTela->getNome()}</h2>\r\n\n";
		self::$strHTMLCode .= Config::tabIdent($intTabIdent)."	<!-- CONTEUDO_INIT -->\r\n";
		self::$strHTMLCode .= Config::tabIdent($intTabIdent)."	<div class=\"conteudo\">\r\n";
		
		$arrObjContainers = $objTela->getContainers(); 
		if(!empty($arrObjContainers)){
			foreach ($arrObjContainers as $objContainer) {
				self::$strHTMLCode .= $objContainer->render($intTabIdent+2);
			}
		}
		self::$strHTMLCode .= '
			</div> <!-- CONTEUDO_FIM -->
		
		</div> <!-- TELA_FIM -->
		
		<div class="clear"></div>
		';
		
		if($bolEcho){
			//imprime na tela o html renderizado de todos os elementos
			echo self::$strHTMLCode;
			return '';
		}else{
			//retorna o html renderizado de todos os elementos
			return self::$strHTMLCode;
		}	
	}
	
	
}