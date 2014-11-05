<?php namespace WRFramework;
/**
 * Classe básica que guarda as informações da template da aplicação
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-13>
 * @package core
 * @subpackage class
 */
class FTemplate{
	
	/**
	 * Define o doctype da página
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var string $strDoctype
	 */
	private $strDoctype = '<!DOCTYPE html>';
	
	/**
	 * Define o título da pígina
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var string $strTitlePage
	 */
	private $strTitlePage = '';
	
	/**
	 * Array com as meta tags do header da página.
	 * 
	 * Formato:
	 * <code>
	 * $arrMetaTags = array(
	 * 		//meta #1
	 * 		(object) array(
	 * 			'http-equiv'=>'Content-Type',
	 * 			'content'=>'text/html; charset=iso-8859-1'
	 * 		),
	 * 		
	 * 		//meta #2
	 * 		(object) array(
	 * 			'author'=>'Rodrigo de Macêdo'
	 * 		),
	 * 
	 * 		//meta #3
	 * 		(object) array(
	 * 			'name'=>'Description',
	 * 			'content'=>'Exemplo de meta-tags'
	 * 		),
	 * 
	 * 		//meta #n
	 * 		(object) array(
	 * 			'name'=>'keywords',
	 * 			'content'=>'Sistema, gestão, software, desenvolvimento'
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $arrMetaTags
	 */
	private $arrMetaTags = array();
	
	/**
	 * Array com as tags <code><link /></code> (sem ser de chamada de css) no header da página.
	 * 
	 * Formato:
	 * <code>
	 * $arrTagLink = array(
	 * 		//link #1
	 * 		(object) array(
	 * 			'href'=>'http://arquivo.xml',
	 * 			'rel'=>'alternate',
	 * 			'type'=>'application/rss+xml',
	 * 			'title'=>'RSS'
	 * 		),
	 * 
	 * 		//link #n
	 * 		(object) array(
	 * 			'href'=>'favicon.ico',
	 * 			'rel'=>'shortcut icon'
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $arrTagLink
	 */
	private $arrTagLink = array();
	
	/**
	 * Array com as folhas de estilos.
	 * 
	 * Formato:
	 * <code>
	 * $arrCssFiles = array(
	 * 		//folha de estilos em formato de array. Varre os atributos.
	 * 		(object) array(
	 * 			'href'=> 'http://local/da/folha/de/estilos.css',
	 * 			'rel'=>'stylesheet',
	 * 			'type'=>'text/css'
	 * 		),
	 * 
	 * 		//folha de estilo conditional
	 * 		(object) array(
	 * 			'href'=> 'http://local/da/outra/folha/de/estilos.css',
	 * 			'rel'=>'stylesheet',
	 * 			'type'=>'text/css',
	 * 			'conditional'=>'lt IE 8'
	 * 		),
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $arrCssFiles
	 */
	private $arrCssFiles = array();
	
	/**
	 * Script de estilos de css inline (escritos na pr�pria página).
	 * 
	 * Formato:
	 * <code>
	 * $arrCssInline = array(
	 * 		(object) array(
	 * 			'conditional'=>'',
	 * 			'code'=>'
	 * 				.classeCss1{
	 * 					color: red;
	 * 				}
	 * 
	 * 				#top, #footer{
	 * 					float: left;
	 * 					margin-top: inherit;
	 * 				}
	 * 			'
	 * 		),
	 * 		(object) array(
	 * 			'conditional'=>'IE 7',
	 * 			'code'=>'
	 * 				#content{
	 * 					color: red;
	 * 				}
	 * 			'
	 * 		)
	 * 	);
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $arrCssInline
	 */
	private $arrCssInline = array();
	
	/**
	 * Array com os scripts de JavaScript.
	 * 
	 * Formato:
	 * <code>
	 * $arrJsFiles = array(
	 * 		//script em formato de array. Varre os atributos.
	 * 		array(
	 * 			'src'=>'http://local/da/folha/de/estilos.css',
	 * 			'language'=>'javascript',
	 * 			'type'=>'text/javascript'
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $arrJsFiles
	 */
	private $arrJsFiles = array();
	
	/**
	 * JavaScript inline (escritos na pr�pria página).
	 * 
	 * Formato:
	 * <code>
	 * $strJsInline = '
	 * 		$(function(){
	 * 			$("#mainMenu").delegate('.menu','click',function(){
	 * 				alert('Menu!');
	 * 			});
	 * 		});		
	 * 	';
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $strJsInline
	 */
	private $strJsInline = '';
	
	/**
	 * Array ou matriz de preenchimento livre com o(s) menu(s) da aplicação. Local reservado para abrigar um array para este fim.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $arrMainMenuApp
	 */
	private $arrMainMenuApp = array();
	
	/**
	 * Conteúdo que será usado no local especificado para despejo de conteúdo no layout. 
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-13>
	 * @since 1.0
	 * 
	 * @var array $strHtmlContent
	 */
	private $strHtmlContent = '';
	
	/**
	 * Códigos em notação JSON que seráo usados para retorno em ajax.
	 * 
	 * Formato:
	 * <code>
	 * 		(object) array(
	 * 			'data'=>'[{nome:"Rodrigo",login:"wrodrigo"},{nome:"Macedo",login:"wmacedo"}]',
	 * 			'utf8'=>TRUE
	 * 		);
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access private
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @var object $strJsonReturnForAjax
	 */
	private $objJsonReturnForAjax;
	
	
	//
	// GETTERS
	//
	
	/**
	 * Retorna o doctype da página. Esta classe possui um padrão que � o seguinte:
	 * <code>
	 * <!DOCTYPE html>
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Retorna o doctype
	 */
	public function getDoctype() {
		return $this->strDoctype;
	}
	
	/**
	 * Retorna o título definido na página
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string T�tulo da página
	 */
	public function getTitlePage() {
		return $this->strTitlePage;
	}
	
	/**
	 * Retorna o array completo com as meta tags.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return array Array completo com os objetos (object) das meta tags
	 */
	public function getAllMetaTags() {
		return $this->arrMetaTags;
	}
	
	/**
	 * Retorna os códigos html das meta tags para serem impressas.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Códigos HTML com as meta tags
	 */
	public function getHtmlMetaTags(){
		$strHtml = '';
		
		foreach ($this->getAllMetaTags() as $objMeta){
			$strHtml .= '<meta ';
			foreach (get_object_vars($objMeta) as $strAttr => $strVar){
				$strHtml .= $strAttr . '="'.$strVar.'" ';
			}
			$strHtml .= "/>\r\n";
		}
		
		return $strHtml;
	}
	
	/**
	 * Retorna o array completo com as tags <code><link /></code>.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return array Array completo com os objetos (object) das tags<code><link /></code>
	 */
	public function getAllTagLinks() {
		return $this->arrTagLink;
	}
	
	/**
	 * Retorna os códigos html das tags <code><link /></code> para serem impressas.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Códigos HTML com as tags <code><link /></code>
	 */
	public function getHtmlTagLinks(){
		return 'meta links';
	}
	
	/**
	 * Retorna um arquivo css dado o parâmetro com seu caminho.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strCssHrefToGet Caminho do arquivo CSS, que � o Índice a ser retornado do array de arquivoss css.
	 * @return object|null Retorna o objeto com os dados do arquivo css ou retorna null se não achar no array o arquivo solicitado
	 */
	public function getCssFile($strCssHrefToGet) {
		$objCssFile = $this->arrCssFiles[0];
		do{
			if($objCssFile->href == $strCssHrefToGet){
				return $objCssFile;
			}
		}while($objCssFile = next($this->arrCssFiles));
		
		return null;
	}
	
	/**
	 * Retorna todos os arquivos css.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return array Array com todos os objetos (object) css
	 */
	public function getAllCssFiles() {
		return $this->arrCssFiles;
	}
	
	/**
	 * Retorna os códigos html das tags que chamam os arquivos css.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Chamada em HTML aos arquivos de css
	 */
	public function getHtmlCssDeclaration(){
		$strHtml = '';
		
		foreach ($this->getAllCssFiles() as $objCss){
			$strHtml .= '<link ';
			foreach (get_object_vars($objCss) as $strAttr => $strVar){
				$strHtml .= $strAttr . '="'.$strVar.'" ';
			}
			$strHtml .= "/>\r\n";
		}
		
		return $strHtml;
	}
	
	/**
	 * Retorna todos os scripts css inline.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return array Array com todos os objetos (object) css
	 */
	public function getAllInlineCss() {
		return $this->arrCssInline;
	}
	
	/**
	 * Retorna a tag style com os códigos css inline
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Códigos css inline
	 */
	public function getCssInlineDeclaration(){
		return 'css inline';
	}
	
	/**
	 * Retorna um arquivo js dado o parâmetro com seu caminho.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strJsSrcToGet Caminho do arquivo JS, que � o Índice a ser retornado do array de arquivos js.
	 * @return object|null Retorna o objeto com os dados do arquivo css ou retorna null se não achar no array o arquivo solicitado
	 */
	public function getJsFile($strJsSrcToGet) {
		$objJsFile = $this->arrJsFiles[0];
		do{
			if($objJsFile->src == $strJsSrcToGet){
				return $objJsFile;
			}
		}while($objJsFile = next($this->arrJsFiles));
		
		return null;
	}
	
	/**
	 * Retorna todos os scripts js inline da página.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return array Array com todos os objetos (object) js
	 */
	public function getAllJsFiles() {
		return $this->arrJsFiles;
	}
	
	/**
	 * Retorna os códigos html das tags que chamam os arquivos js.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Chamada em HTML aos arquivos de js
	 */
	public function getHtmlJsDeclaration(){
		$strHtml = '';
		
		foreach ($this->getAllJsFiles() as $objJs){
			$strHtml .= '<script ';
			foreach (get_object_vars($objJs) as $strAttr => $strVar){
				$strHtml .= $strAttr . '="'.$strVar.'" ';
			}
			$strHtml .= "></script>\r\n";
		}
		
		return $strHtml;
	}
	
	/**
	 * Retorna o script js inline.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Script js inline
	 */
	public function getAllInlineJs() {
		return $this->strJsInline."\n\n";
	}
	
	/**
	 * Retorna os scripts js para ser impresses inline na página
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Códigos js na tag <code><script></code>
	 */
	public function getJsInlineDeclaration(){
		return 'js inline';
	}
	
	/**
	 * Obt�m todos os �tens de menu definidos para serem exibidos no layout.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return array Array com todos os �tens de menu.
	 */
	public function getMainMenuApp() {
		return $this->arrMainMenuApp;
	}
	
	/**
	 * Obt�m as telas de dentro do layout. Os códigos normalmente estar�o em html em um local espec�fico do layout.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Conteúdo a ser despejado no local espec�fico do layout
	 */
	public function getHtmlContent() {
		return $this->strHtmlContent;
	}
	
	/**
	 * Obt�m as telas de dentro do layout. Os códigos normalmente estar�o em html em um local espec�fico do layout.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @return string Códigos
	 */
	public function getJsonAjaxContent() {
		
		if((isset($this->objJsonReturnForAjax->data)) && (isset($this->objJsonReturnForAjax->utf8)) && ($this->objJsonReturnForAjax->utf8 == TRUE)){
			foreach ($this->objJsonReturnForAjax->data as $i => $strDado) {
				$this->objJsonReturnForAjax->data[$i] = utf8_encode($strDado);
			}
		}
		
		return json_encode($this->objJsonReturnForAjax->data);
	}
	
	//
	// SETTERS / ADD's / REMOVES
	//
	
	/**
	 * Define o doctype da página
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strDoctype String com a definição doctype da página
	 */
	public function setDoctype($strDoctype) {
		$this->strDoctype = $strDoctype;
	}
	
	/**
	 * Define o título da página
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strTitlePage String com o título da página
	 */
	public function setTitlePage($strTitlePage) {
		$this->strTitlePage = $strTitlePage;
	}
	
	/**
	 * Adiciona mais uma meta tag para a página.
	 * 
	 * Formato:
	 * <code>
	 * 		//um array onde cada posição indexada será um atributo da tag
	 * 		array(
	 * 			'http-equiv'=>'Content-Type',
	 * 			'content'=>'text/html; charset=iso-8859-1'
	 * 		)
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param array $arrMetaData Array com os atributos e valores da meta tag
	 */
	public function addMetaTag($arrMetaData) {
		if(is_array($arrMetaData)){
			$this->arrMetaTags[] = (object) $arrMetaData;
		}else if(is_object($arrMetaData)){
			$this->arrMetaTags[] = $arrMetaData;
		}
	}
	
	/**
	 * Define o array completo de meta tags para a página.
	 * 
	 * Formato:
	 * <code>
	 * $arrMetaTags = array(
	 * 		//meta #1
	 * 		(object) array(
	 * 			'http-equiv'=>'Content-Type',
	 * 			'content'=>'text/html; charset=iso-8859-1'
	 * 		),
	 * 		
	 * 		//meta #2
	 * 		(object) array(
	 * 			'author'=>'Rodrigo de Macêdo'
	 * 		),
	 * 
	 * 		//meta #3
	 * 		(object) array(
	 * 			'name'=>'Description',
	 * 			'content'=>'Exemplo de meta-tags'
	 * 		),
	 * 
	 * 		//meta #n
	 * 		(object) array(
	 * 			'name'=>'keywords',
	 * 			'content'=>'Sistema, gest�o, software, desenvolvimento'
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param array $arrObjMetaData Array com os objetos, onde cada um será um meta data.
	 */
	public function setMetaTags($arrObjMetaData) {
		$this->arrMetaTags = $arrObjMetaData;
	}
	
	/**
	 * Adiciona mais uma tag <code><link /></code> para o header da página.
	 * 
	 * Formato:
	 * <code>
	 * 		//um array onde cada posição indexada será um atributo da tag
	 * 		array(
	 * 			'href'=>'http://arquivo.xml',
	 * 			'rel'=>'alternate',
	 * 			'type'=>'application/rss+xml',
	 * 			'title'=>'RSS'
	 * 		)
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param array $arrLinkData Array com os atributos e valores da tag link
	 */
	public function addTagLink($arrLinkData) {
		if(is_array($arrLinkData)){
			$this->arrTagLink[] = (object) $arrLinkData;
		}else if(is_object($arrMetaData)){
			$this->arrTagLink[] = $arrLinkData;
		}
	}
	
	/**
	 * Define o array completo de tags <code><link /></code> para o header da página.
	 * 
	 * Formato:
	 * <code>
	 * $arrTagLink = array(
	 * 		//link #1
	 * 		(object) array(
	 * 			'href'=>'http://arquivo.xml',
	 * 			'rel'=>'alternate',
	 * 			'type'=>'application/rss+xml',
	 * 			'title'=>'RSS'
	 * 		),
	 * 
	 * 		//link #n
	 * 		(object) array(
	 * 			'href'=>'favicon.ico',
	 * 			'rel'=>'shortcut icon'
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param array $arrObjTagLink Array com os objetos, onde cada um será um meta data.
	 */
	public function setTagLinks($arrObjTagLink) {
		$this->arrTagLink = $arrObjTagLink;
	}
	
	/**
	 * Adiciona uma nova folha de estilo para a página. Se o primeiro parâmetro for string, uma nova folha de estilos � inserida de forma padrão. Se for array, deve obedecer o formato abaixo.
	 * 
	 * Formato:
	 * <code>
	 * $arrCssFiles = array(
	 * 		//folha de estilos em formato de array. Varre os atributos.
	 * 		(object) array(
	 * 			'href'=> 'http://local/da/folha/de/estilos.css', 
	 * 			'rel'=>'stylesheet', //opcional (padrão)
	 * 			'type'=>'text/css', //opcional (padrão)
	 * 			'conditional'=>'lt IE 8' //opcional (padrão: vazio)
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string|array $mixHrefOrFileInfo Se for string, � o href. Se for array, deve ter o formato conforme descrição deste método
	 * @param string $strCondition Representa chamada a folha de estilo condicionada a um determinado browser. Preencha (lt IE 8, IE 7...). S� poder� ser preenchido opcionalmente se @param $mixHrefOrFileInfo for string.
	 * 
	 * @return boolean Retorna um boolean indicando sucesso na operação
	 */
	public function addCssFile($mixHrefOrFileInfo, $strCondition = FALSE, $strAmbient = '') {
		switch (gettype($mixHrefOrFileInfo)) {
			case 'string':
				$strFullUrl = FConfig::getAppConfig('base_urlActiveTemplate');
				
				switch ($strAmbient) {
					
					case 'backend':
						$strFullUrl .= 'app-backend/css/';
						break;
						
					case 'frontend':
						$strFullUrl .= 'app-frontend/css/';
						break;
						
					case '':
					default:
						if(FConfig::getAppConfig('sys_isBackend')){
							$strFullUrl .= 'app-backend/css/';
						}else{
							$strFullUrl .= 'app-frontend/css/';
						}
						break;
				}
				
				$strFullUrl .= $mixHrefOrFileInfo;
				$arrTmp = array('href'=>$strFullUrl,'rel'=>'stylesheet', 'type'=>'text/css');
				if($strCondition !== FALSE){
					$arrTmp['condition'] = strtoupper(trim(preg_replace('/\s{2,}/',' ',$strCondition)));
				}
				
				$this->arrCssFiles[] = (object) $arrTmp;
			break;
			
			case 'array':
				if(!isset($mixHrefOrFileInfo['rel'])){
					$mixHrefOrFileInfo['rel'] = 'stylesheet';
				}
				if(!isset($mixHrefOrFileInfo['type'])){
					$mixHrefOrFileInfo['type'] = 'text/css';
				}
				if(isset($mixHrefOrFileInfo['condition'])){
					$mixHrefOrFileInfo['condition'] = strtoupper(trim(preg_replace('/\s{2,}/',' ',$mixHrefOrFileInfo['condition'])));
				}
				
				//
				$this->arrCssFiles[] = (object) $mixHrefOrFileInfo;
			break;
			
			default:
				return FALSE;
			;
		}
		
		return TRUE;
	}
	
	/**
	 * Adiciona uma declaração inline de uma folha de estilo para a página.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strStylesCssDeclaration Declaração CSS (styles).
	 * @param string $strCondition Se o estilo for condicionado a um determinado browser, insira sua regra (lt IE 8, IE 7...).
	 */
	public function addCssDeclaration($strStylesCssDeclaration, $strCondition = FALSE) {
		$strCondition = strtoupper(trim(preg_replace('/\s{2,}/',' ',$strCondition)));
		foreach ($this->arrCssInline as $objCssDeclaration) {
			if($objCssDeclaration->condition == $strCondition){
				$objCssDeclaration->code .= "\n\n\n".$strStylesCssDeclaration;
			}
		}
		
		$this->arrCssInline[] = (object) array('condition'=>$strCondition, 'code'=>$strStylesCssDeclaration);
	}
	
	/**
	 * Remove uma folha de estilo do array de css files.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strHref Caminho absoluto do arquivo css para se remover
	 * 
	 * @return boolean Retorna TRUE se conseguiu remover. FALSE em caso contrário.
	 */
	public function removeCssFile($strHref, $strAmbient = '') {
		if($strAmbient == ''){
			$strFullUrl = FConfig::getAppConfig('base_urlActiveTemplate');
			if(FConfig::getAppConfig('sys_isBackend')){
				$strFullUrl .= 'app-backend/css/';
			}else{
				$strFullUrl .= 'app-backend/css/';
			}
			
			$strFullUrl .= $strHref;
		}
		$intQtd = count($this->arrCssFiles);
		for ($i = 0 ; $i < $intQtd ; $i++) {
			if($this->arrCssFiles[$i]->href == $strFullUrl){
				unset($this->arrCssFiles[$i]);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/** ************************************************************************************** */
	
	

	/**
	 * Adiciona um novo script js para a página. Se o primeiro parâmetro for string, um novo script � inserido de forma padrão. Se for array, deve obedecer o formato abaixo.
	 * 
	 * Formato:
	 * <code>
	 * $arrJsFiles = array(
	 * 		//script em formato de array. Varre os atributos.
	 * 		array(
	 * 			'src'=>'http://local/da/folha/de/estilos.css',
	 * 			'type'=>'text/javascript'  //optional
	 * 		)
	 * );
	 * </code>
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string|array $mixSrcOrFileInfo Se for string, é o src. Se for array, deve ter o formato conforme descrição deste método
	 * 
	 * @return boolean Retorna um boolean indicando sucesso na operação
	 */
	public function addJsFile($mixSrcOrFileInfo, $strAmbient = '') {
		switch (gettype($mixSrcOrFileInfo)) {
			case 'string':
				$strFullUrl = FConfig::getAppConfig('base_urlActiveTemplate');
				
				switch ($strAmbient) {
					
					case 'backend':
						$strFullUrl .= 'app-backend/js/';
						break;
						
					case 'frontend':
						$strFullUrl .= 'app-frontend/js/';
						break;
						
					case '':
					default:
						if(FConfig::getAppConfig('sys_isBackend')){
							$strFullUrl .= 'app-backend/js/';
						}else{
							$strFullUrl .= 'app-frontend/js/';
						}
						break;
				}
				
				$strFullUrl .= $mixSrcOrFileInfo;
				$objTmp = (object) array('src'=>$strFullUrl, 'type'=>'text/javascript');
				
				$this->arrJsFiles[] = $objTmp;
			break;
			
			case 'array':
				if(!isset($mixSrcOrFileInfo['type'])){
					$mixSrcOrFileInfo['type'] = 'text/javascript';
				}
				
				//
				$this->arrJsFiles[] = (object) $mixSrcOrFileInfo;
			break;
			
			default:
				return FALSE
			;
		}
		
		return TRUE;
	}
	
	/**
	 * Adiciona uma declaração inline de um script js para a página.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strScriptJsDeclaration Declaração na linguagem JavaScript.
	 */
	public function addJsDeclaration($strScriptJsDeclaration) {
		$this->strJsInline .= "\n\n\n".$strScriptJsDeclaration;
	}
	
	/**
	 * Remove um script js do array de js files.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strSrc Caminho absoluto do arquivo js para se remover
	 * 
	 * @return boolean Retorna TRUE se conseguiu remover. FALSE em caso contrário.
	 */
	public function removeJsFile($strSrc) {
		$intQtd = count($this->arrJsFiles);
		for ($i = 0 ; $i < $intQtd ; $i++) {
			if($this->arrJsFiles[$i]->src == $strSrc){
				unset($this->arrJsFiles[$i]);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/**
	 * Define o menu da aplicação que o layout usará
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param array $arrMainMenuApp
	 */
	public function setMainMenuApp($arrMainMenuApp) {
		$this->arrMainMenuApp = $arrMainMenuApp;
	}
	
	/**
	 * Define o conteúdo que será usado no local especificado para despejo no layout. Você pode definir um conteúdo ou acrescentar.
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param string $strHtmlContent Conteúdo em código HTML
	 * @param string $strHtmlContent Conteúdo em código HTML
	 */
	public function setHtmlContent($strHtmlContent, $bolAppend = TRUE) {
		if($bolAppend){
			$this->strHtmlContent .= "\n".$strHtmlContent;
		}else{
			$this->strHtmlContent = $strHtmlContent;
		}
	}
	
	/**
	 * Define o retorno em notação JSON para respostas em ajax
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * 
	 * @access public
	 * @version 1.0 <2011-01-14>
	 * @since 1.0
	 * 
	 * @param array $arrData Array com os dados a serem retornados. Índice como variável e valor como seu próprio valor.
	 * @param boolean $bolUtf8Encode Verdadeiro para codificar os dados como utf8.
	 */
	public function setJsonReturnForAjax($arrData, $bolUtf8Encode = true) {
		$this->objJsonReturnForAjax = (object) array('data'=> $arrData, 'utf8' => $bolUtf8Encode);
	}
}
?>