<?php
/**
 * Classe que gerencia as views do JBridge.
 * 
 * As classes da barra de ferramentas são:
 * 
 * ** menu icons **
 * .icon-16-archive 		{ background-image: url(../images/menu/icon-16-archive.png); }
 * .icon-16-article 		{ background-image: url(../images/menu/icon-16-article.png); }
 * .icon-16-category 	{ background-image: url(../images/menu/icon-16-category.png); }
 * .icon-16-checkin 		{ background-image: url(../images/menu/icon-16-checkin.png); }
 * .icon-16-component	{ background-image: url(../images/menu/icon-16-component.png); }
 * .icon-16-config 		{ background-image: url(../images/menu/icon-16-config.png); }
 * .icon-16-content 		{ background-image: url(../images/menu/icon-16-content.png); }
 * .icon-16-cpanel 		{ background-image: url(../images/menu/icon-16-cpanel.png); }
 * .icon-16-default 		{ background-image: url(../images/menu/icon-16-default.png); }
 * .icon-16-frontpage 	{ background-image: url(../images/menu/icon-16-frontpage.png); }
 * .icon-16-help			{ background-image: url(../images/menu/icon-16-help.png); }
 * .icon-16-info 			{ background-image: url(../images/menu/icon-16-info.png); }
 * .icon-16-install 		{ background-image: url(../images/menu/icon-16-install.png);}
 * .icon-16-language 	{ background-image: url(../images/menu/icon-16-language.png);}
 * .icon-16-logout 		{ background-image: url(../images/menu/icon-16-logout.png);}
 * .icon-16-massmail 	{ background-image: url(../images/menu/icon-16-massmail.png); }
 * .icon-16-media 		{ background-image: url(../images/menu/icon-16-media.png);}
 * .icon-16-menu 			{ background-image: url(../images/menu/icon-16-menu.png); }
 * .icon-16-menumgr 		{ background-image: url(../images/menu/icon-16-menumgr.png); }
 * .icon-16-messages 	{ background-image: url(../images/menu/icon-16-messages.png); }
 * .icon-16-module 		{ background-image: url(../images/menu/icon-16-module.png); }
 * .icon-16-plugin 		{ background-image: url(../images/menu/icon-16-plugin.png); }
 * .icon-16-section 		{ background-image: url(../images/menu/icon-16-section.png); }
 * .icon-16-static 		{ background-image: url(../images/menu/icon-16-static.png); }
 * .icon-16-stats 		{ background-image: url(../images/menu/icon-16-stats.png); }
 * .icon-16-themes 		{ background-image: url(../images/menu/icon-16-themes.png); }
 * .icon-16-trash 		{ background-image: url(../images/menu/icon-16-trash.png); }
 * .icon-16-user 			{ background-image: url(../images/menu/icon-16-user.png); }
 * 
** toolbar icons **
 * .icon-32-send 			{ background-image: url(../images/toolbar/icon-32-send.png); }
 * .icon-32-delete 		{ background-image: url(../images/toolbar/icon-32-delete.png); }
 * .icon-32-help 			{ background-image: url(../images/toolbar/icon-32-help.png); }
 * .icon-32-cancel 		{ background-image: url(../images/toolbar/icon-32-cancel.png); }
 * .icon-32-config 		{ background-image: url(../images/toolbar/icon-32-config.png); }
 * .icon-32-apply 		{ background-image: url(../images/toolbar/icon-32-apply.png); }
 * .icon-32-back			{ background-image: url(../images/toolbar/icon-32-back.png); }
 * .icon-32-forward		{ background-image: url(../images/toolbar/icon-32-forward.png); }
 * .icon-32-save 			{ background-image: url(../images/toolbar/icon-32-save.png); }
 * .icon-32-edit 			{ background-image: url(../images/toolbar/icon-32-edit.png); }
 * .icon-32-copy 			{ background-image: url(../images/toolbar/icon-32-copy.png); }
 * .icon-32-move 			{ background-image: url(../images/toolbar/icon-32-move.png); }
 * .icon-32-new 			{ background-image: url(../images/toolbar/icon-32-new.png); }
 * .icon-32-upload 		{ background-image: url(../images/toolbar/icon-32-upload.png); }
 * .icon-32-assign 		{ background-image: url(../images/toolbar/icon-32-publish.png); }
 * .icon-32-html 			{ background-image: url(../images/toolbar/icon-32-html.png); }
 * .icon-32-css 			{ background-image: url(../images/toolbar/icon-32-css.png); }
 * .icon-32-menus 			{ background-image: url(../images/toolbar/icon-32-menu.png); }
 * .icon-32-publish 		{ background-image: url(../images/toolbar/icon-32-publish.png); }
 * .icon-32-unpublish 	{ background-image: url(../images/toolbar/icon-32-unpublish.png);}
 * .icon-32-restore		{ background-image: url(../images/toolbar/icon-32-revert.png); }
 * .icon-32-trash 		{ background-image: url(../images/toolbar/icon-32-trash.png); }
 * .icon-32-archive 		{ background-image: url(../images/toolbar/icon-32-archive.png); }
 * .icon-32-unarchive 	{ background-image: url(../images/toolbar/icon-32-unarchive.png); }
 * .icon-32-preview 		{ background-image: url(../images/toolbar/icon-32-preview.png); }
 * .icon-32-default 		{ background-image: url(../images/toolbar/icon-32-default.png); }
 * 
** header icons **
 * .icon-48-generic 		{ background-image: url(../images/header/icon-48-generic.png); }
 * .icon-48-checkin 		{ background-image: url(../images/header/icon-48-checkin.png); }
 * .icon-48-cpanel 		{ background-image: url(../images/header/icon-48-cpanel.png); }
 * .icon-48-config 		{ background-image: url(../images/header/icon-48-config.png); }
 * .icon-48-module 		{ background-image: url(../images/header/icon-48-module.png); }
 * .icon-48-menu 			{ background-image: url(../images/header/icon-48-menu.png); }
 * .icon-48-menumgr 		{ background-image: url(../images/header/icon-48-menumgr.png); }
 * .icon-48-trash 		{ background-image: url(../images/header/icon-48-trash.png); }
 * .icon-48-user	 		{ background-image: url(../images/header/icon-48-user.png); }
 * .icon-48-inbox 		{ background-image: url(../images/header/icon-48-inbox.png); }
 * .icon-48-msgconfig 	{ background-image: url(../images/header/icon-48-message_config.png); }
 * .icon-48-langmanager { background-image: url(../images/header/icon-48-language.png); }
 * .icon-48-mediamanager{ background-image: url(../images/header/icon-48-media.png); }
 * .icon-48-plugin 	{ background-image: url(../images/header/icon-48-plugin.png); }
 * .icon-48-help_header { background-image: url(../images/header/icon-48-help_header.png); }
 * .icon-48-impressions { background-image: url(../images/header/icon-48-stats.png); }
 * .icon-48-browser 		{ background-image: url(../images/header/icon-48-stats.png); }
 * .icon-48-searchtext 	{ background-image: url(../images/header/icon-48-stats.png); }
 * .icon-48-thememanager{ background-image: url(../images/header/icon-48-themes.png); }
 * .icon-48-massemail 	{ background-image: url(../images/header/icon-48-massemail.png); }
 * .icon-48-frontpage 	{ background-image: url(../images/header/icon-48-frontpage.png); }
 * .icon-48-sections 	{ background-image: url(../images/header/icon-48-section.png); }
 * .icon-48-addedit 		{ background-image: url(../images/header/icon-48-article-add.png); }
 * .icon-48-article 		{ background-image: url(../images/header/icon-48-article.png); }
 * .icon-48-categories 	{ background-image: url(../images/header/icon-48-category.png); }
 * .icon-48-install 		{ background-image: url(../images/header/icon-48-extension.png); }
 * .icon-48-dbbackup		{ background-image: url(../images/header/icon-48-backup.png); }
 * .icon-48-dbrestore 	{ background-image: url(../images/header/icon-48-dbrestore.png); }
 * .icon-48-dbquery 		{ background-image: url(../images/header/icon-48-query.png); }
 * .icon-48-systeminfo 	{ background-image: url(../images/header/icon-48-info.png); }
 * .icon-48-massemail 	{ background-image: url(../images/header/icon-48-massmail.png); }
 * 
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-20>
 * @package joomla15Interface
 * @subpackage view
 */
class JBridgeToolbarView extends FTemplateController{
	
	/**
	 * �ndice de armazenamento da toolbar para identific�-la na hora de adicionar o action
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @static
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @var int $intIndexBtnAdd �ndice (ordem de armazenamento)
	 */
	public static $intIndexBtnAdd = 0;
	
	/**
	 * Adiciona um t�tulo � barra de ferramentas
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @param string $strTitulo t�tulo da Barra de ferramentas
	 * @param string $strIco Caminho do �cone da barra de ferramentas. Se for da template Khepri (header/), informar somente o nome da imagem.
	 */
	public function addTitle($strTitulo, $strIco = false) {
		if($strIco == false){
			$strIco = 'generic.png';
		}
		if(class_exists('JToolBarHelper'))
			JToolBarHelper::title( JText::_( '<label>'.$strTitulo.'</label>' ), $strIco );
	}
	
	/**
	 * Adiciona um bot�o � barra de ferramentas
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @param string $strLabel Label descritivo do item
	 * @param string $strDescription Descrição curta do que a ação faz
	 * @param string|stdClass $mixAction String: Ação que a aplicação vai fazer ao usar o bot�o - stdClass: Objeto com os atributos de link para a app do tipo mini
	 * @param string $strIcon Caminho do �cone da barra de ferramentas. Se for da template Khepri (toolbar/), informar somente o nome da imagem.
	 * @param boolean $bolIsJsFunction Entende a action como um comando js
	 */
	public function addButon($strLabel, $strDescription, $mixAction, $strIcon, $bolIsJsFunction) {
		//verificar se o action � string ou object
		if(is_object($mixAction)){
			//se o package não vier, pega o mesmo nome do controlador. Essa regra se aplica a todo o WRF
			if(!isset($mixAction->strPckg)){
				$mixAction->strPckg = $mixAction->strCtrl;
			}
		
			//configurar o controller
			$strAction = parent::generateMiniAppUrl($mixAction->strPckg, $mixAction->strCtrl, $mixAction->strAction);
			
		}else{
			//string
			$strAction = $mixAction;
		}
		
		JToolBarHelper::custom('', $strIcon, $strIcon, $strLabel, false, false);
		if(!$bolIsJsFunction){
			parent::getObjTemplate()->addJsDeclaration('
				jQuery(function(){
					var objTmp_'.self::$intIndexBtnAdd.' = jQuery("div#toolbar table.toolbar tr td:eq(' . self::$intIndexBtnAdd . ') a.toolbar");
					objTmp_'.self::$intIndexBtnAdd.'.attr("onclick","");	
					objTmp_'.self::$intIndexBtnAdd.'.attr("href","?option=' . FConfig::getAppConfig('cms_componentName') . '&' . $strAction . '");	
					objTmp_'.self::$intIndexBtnAdd.'.find("span").removeAttr("title");	
					objTmp_'.self::$intIndexBtnAdd.'.attr("title","' . $strDescription . '");
				});
			');
		}else{
			parent::getObjTemplate()->addJsDeclaration('
				jQuery(function(){
					var objTmp_'.self::$intIndexBtnAdd.' = jQuery("div#toolbar table.toolbar tr td:eq(' . self::$intIndexBtnAdd . ') a.toolbar");
					objTmp_'.self::$intIndexBtnAdd.'.attr("onclick","");	
					objTmp_'.self::$intIndexBtnAdd.'.find("span").removeAttr("title");	
					objTmp_'.self::$intIndexBtnAdd.'.attr("title","' . $strDescription . '");
					
					objTmp_'.self::$intIndexBtnAdd.'.live("click",function(){
						'.$strAction.';
					});
				});
			');
		}
		
		self::$intIndexBtnAdd++;
	}
}