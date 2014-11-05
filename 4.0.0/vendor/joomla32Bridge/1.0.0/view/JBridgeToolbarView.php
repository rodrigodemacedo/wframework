<?php
use WRFramework\FTemplateController as FTemplateController;
use WRFramework\FIncludeHelper as FIncludeHelper;
use WRFramework\FRequestHelper as FRequestHelper;
use WRFramework\FConfig as FConfig;

/**
 * Classe que gerencia as views do JBridge.
 * 
 * As classes da barra de ferramentas são:
 * 
 * ** menu icons **
 * 
.btn 
.btn-large 
.btn-small
.btn-mini 
.btn-block 
.btn-primary
.btn-warning
.btn-danger
.btn-success
.btn-info
.btn-inverse


.icon-joomla
.icon-chevron-up:before, .icon-uparrow:before, .icon-arrow-up:before 
.icon-chevron-right:before, .icon-rightarrow:before, .icon-arrow-right:before 
.icon-chevron-down:before, .icon-downarrow:before, .icon-arrow-down:before 
.icon-chevron-left:before, .icon-leftarrow:before, .icon-arrow-left:before 
.icon-arrow-first:before 
.icon-arrow-last:before 
.icon-arrow-up-2:before 
.icon-arrow-right-2:before
.icon-arrow-down-2:before
.icon-arrow-left-2:before 
.icon-arrow-up-3:before
.icon-arrow-right-3:before
.icon-arrow-down-3:before
.icon-arrow-left-3:before
.icon-menu-2:before
.icon-arrow-up-4:before
.icon-arrow-right-4:before
.icon-arrow-down-4:before
.icon-arrow-left-4:before
.icon-share:before, .icon-redo:before {
    content: "\'";
}
.icon-undo:before {
    content: ";
}
.icon-forward-2:before {
    content: "";
}
.icon-backward-2:before, .icon-reply:before {
    content: "";
}
.icon-unblock:before, .icon-refresh:before, .icon-redo-2:before {
    content: "l";
}
.icon-undo-2:before {
    content: "";
}
.icon-move:before {
    content: "z";
}
.icon-expand:before {
    content: "f";
}
.icon-contract:before {
    content: "g";
}
.icon-expand-2:before {
    content: "h";
}
.icon-contract-2:before {
    content: "i";
}
.icon-play:before {
    content: "";
}
.icon-pause:before {
    content: "";
}
.icon-stop:before {
    content: "";
}
.icon-previous:before, .icon-backward:before {
    content: "|";
}
.icon-next:before, .icon-forward:before {
    content: "{";
}
.icon-first:before {
    content: "}";
}
.icon-last:before {
    content: "";
}
.icon-play-circle:before {
    content: "";
}
.icon-pause-circle:before {
    content: "";
}
.icon-stop-circle:before {
    content: "";
}
.icon-backward-circle:before {
    content: "";
}
.icon-forward-circle:before {
    content: "";
}
.icon-loop:before {
    content: "";
}
.icon-shuffle:before {
    content: "";
}
.icon-search:before {
    content: "S";
}
.icon-zoom-in:before {
    content: "d";
}
.icon-zoom-out:before {
    content: "e";
}
.icon-apply:before, .icon-edit:before, .icon-pencil:before {
    content: "+";
}
.icon-pencil-2:before {
    content: ",";
}
.icon-brush:before {
    content: ";
}
.icon-save-new:before, .icon-plus-2:before {
    content: "]";
}
.icon-ban-circle:before, .icon-minus-sign:before, .icon-minus-2:before {
    content: "^";
}
.icon-delete:before, .icon-remove:before, .icon-cancel-2:before {
    content: "I";
}
.icon-publish:before, .icon-save:before, .icon-ok:before, .icon-checkmark:before {
    content: "G";
}
.icon-new:before, .icon-plus:before {
    content: "*";
}
.icon-plus-circle:before {
    content: "";
}
.icon-minus:before, .icon-not-ok:before {
    content: "K";
}
.icon-minus-circle:before {
    content: "";
}
.icon-unpublish:before, .icon-cancel:before {
    content: "J";
}
.icon-cancel-circle:before {
    content: "";
}
.icon-checkmark-2:before {
    content: "";
}
.icon-checkmark-circle:before {
    content: "";
}
.icon-info:before {
    content: "";
}
.icon-info-2:before, .icon-info-circle:before {
    content: "";
}
.icon-question:before, .icon-question-sign:before, .icon-help:before {
    content: "E";
}
.icon-question-2:before, .icon-question-circle:before {
    content: "";
}
.icon-notification:before {
    content: "";
}
.icon-notification-2:before, .icon-notification-circle:before {
    content: "";
}
.icon-pending:before, .icon-warning:before {
    content: "H";
}
.icon-warning-2:before, .icon-warning-circle:before {
    content: "";
}
.icon-checkbox-unchecked:before {
    content: "=";
}
.icon-checkin:before, .icon-checkbox:before, .icon-checkbox-checked:before {
    content: ">";
}
.icon-checkbox-partial:before {
    content: "?";
}
.icon-square:before {
    content: "";
}
.icon-radio-unchecked:before {
    content: "";
}
.icon-radio-checked:before, .icon-generic:before {
    content: "";
}
.icon-circle:before {
    content: "";
}
.icon-signup:before {
    content: "";
}
.icon-grid:before, .icon-grid-view:before {
    content: "X";
}
.icon-grid-2:before, .icon-grid-view-2:before {
    content: "Y";
}
.icon-menu:before {
    content: "Z";
}
.icon-list:before, .icon-list-view:before {
    content: "1";
}
.icon-list-2:before {
    content: "";
}
.icon-menu-3:before {
    content: "";
}
.icon-folder-open:before, .icon-folder:before {
    content: "-";
}
.icon-folder-close:before, .icon-folder-2:before {
    content: ".";
}
.icon-folder-plus:before {
    content: "";
}
.icon-folder-minus:before {
    content: "";
}
.icon-folder-3:before {
    content: "";
}
.icon-folder-plus-2:before {
    content: "";
}
.icon-folder-remove:before {
    content: "";
}
.icon-file:before {
    content: "";
}
.icon-file-2:before {
    content: "";
}
.icon-file-add:before, .icon-file-plus:before {
    content: ")";
}
.icon-file-remove:before, .icon-file-minus:before {
    content: "";
}
.icon-file-check:before {
    content: "";
}
.icon-file-remove:before {
    content: "";
}
.icon-save-copy:before, .icon-copy:before {
    content: "";
}
.icon-stack:before {
    content: "";
}
.icon-tree:before {
    content: "";
}
.icon-tree-2:before {
    content: "";
}
.icon-paragraph-left:before {
    content: "";
}
.icon-paragraph-center:before {
    content: "";
}
.icon-paragraph-right:before {
    content: "";
}
.icon-paragraph-justify:before {
    content: "";
}
.icon-screen:before {
    content: "";
}
.icon-tablet:before {
    content: "";
}
.icon-mobile:before {
    content: "";
}
.icon-box-add:before {
    content: "Q";
}
.icon-box-remove:before {
    content: "R";
}
.icon-download:before {
    content: "";
}
.icon-upload:before {
    content: "";
}
.icon-home:before {
    content: "!";
}
.icon-home-2:before {
    content: "";
}
.icon-out-2:before, .icon-new-tab:before {
    content: "";
}
.icon-out-3:before, .icon-new-tab-2:before {
    content: "";
}
.icon-link:before {
    content: "";
}
.icon-picture:before, .icon-image:before {
    content: "/";
}
.icon-pictures:before, .icon-images:before {
    content: "0";
}
.icon-palette:before, .icon-color-palette:before {
    content: "";
}
.icon-camera:before {
    content: "U";
}
.icon-camera-2:before, .icon-video:before {
    content: "";
}
.icon-play-2:before, .icon-video-2:before, .icon-youtube:before {
    content: "V";
}
.icon-music:before {
    content: "W";
}
.icon-user:before {
    content: "\"";
}
.icon-users:before {
    content: "";
}
.icon-vcard:before {
    content: "m";
}
.icon-address:before {
    content: "p";
}
.icon-share-alt:before, .icon-out:before {
    content: "&";
}
.icon-enter:before {
    content: "";
}
.icon-exit:before {
    content: "";
}
.icon-comment:before, .icon-comments:before {
    content: "$";
}
.icon-comments-2:before {
    content: "%";
}
.icon-quote:before, .icon-quotes-left:before {
    content: "`";
}
.icon-quote-2:before, .icon-quotes-right:before {
    content: "a";
}
.icon-quote-3:before, .icon-bubble-quote:before {
    content: "";
}
.icon-phone:before {
    content: "";
}
.icon-phone-2:before {
    content: "";
}
.icon-envelope:before, .icon-mail:before {
    content: "M";
}
.icon-envelope-opened:before, .icon-mail-2:before {
    content: "N";
}
.icon-unarchive:before, .icon-drawer:before {
    content: "O";
}
.icon-archive:before, .icon-drawer-2:before {
    content: "P";
}
.icon-briefcase:before {
    content: "";
}
.icon-tag:before {
    content: "";
}
.icon-tag-2:before {
    content: "";
}
.icon-tags:before {
    content: "";
}
.icon-tags-2:before {
    content: "";
}
.icon-options:before, .icon-cog:before {
    content: "8";
}
.icon-cogs:before {
    content: "7";
}
.icon-screwdriver:before, .icon-tools:before {
    content: "6";
}
.icon-wrench:before {
    content: ":";
}
.icon-equalizer:before {
    content: "9";
}
.icon-dashboard:before {
    content: "x";
}
.icon-switch:before {
    content: "";
}
.icon-filter:before {
    content: "T";
}
.icon-purge:before, .icon-trash:before {
    content: "L";
}
.icon-checkedout:before, .icon-lock:before, .icon-locked:before {
    content: "#";
}
.icon-unlock:before {
    content: "";
}
.icon-key:before {
    content: "_";
}
.icon-support:before {
    content: "F";
}
.icon-database:before {
    content: "b";
}
.icon-scissors:before {
    content: "";
}
.icon-health:before {
    content: "j";
}
.icon-wand:before {
    content: "k";
}
.icon-eye-open:before, .icon-eye:before {
    content: "<";
}
.icon-eye-close:before, .icon-eye-blocked:before, .icon-eye-2:before {
    content: "";
}
.icon-clock:before {
    content: "n";
}
.icon-compass:before {
    content: "o";
}
.icon-broadcast:before, .icon-connection:before, .icon-wifi:before {
    content: "";
}
.icon-book:before {
    content: "";
}
.icon-lightning:before, .icon-flash:before {
    content: "y";
}
.icon-print:before, .icon-printer:before {
    content: "";
}
.icon-feed:before {
    content: "q";
}
.icon-calendar:before {
    content: "C";
}
.icon-calendar-2:before {
    content: "D";
}
.icon-calendar-3:before {
    content: "";
}
.icon-pie:before {
    content: "w";
}
.icon-bars:before {
    content: "v";
}
.icon-chart:before {
    content: "u";
}
.icon-power-cord:before {
    content: "2";
}
.icon-cube:before {
    content: "3";
}
.icon-puzzle:before {
    content: "4";
}
.icon-attachment:before, .icon-paperclip:before, .icon-flag-2:before {
    content: "r";
}
.icon-lamp:before {
    content: "t";
}
.icon-pin:before, .icon-pushpin:before {
    content: "s";
}
.icon-location:before {
    content: "c";
}
.icon-shield:before {
    content: "";
}
.icon-flag:before {
    content: "5";
}
.icon-flag-3:before {
    content: "";
}
.icon-bookmark:before {
    content: "";
}
.icon-bookmark-2:before {
    content: "";
}
.icon-heart:before {
    content: "";
}
.icon-heart-2:before {
    content: "";
}
.icon-thumbs-up:before {
    content: "[";
}
.icon-thumbs-down:before {
    content: "\\";
}
.icon-unfeatured:before, .icon-asterisk:before, .icon-star-empty:before {
    content: "@";
}
.icon-star-2:before {
    content: "A";
}
.icon-featured:before, .icon-default:before, .icon-star:before {
    content: "B";
}
.icon-smiley:before, .icon-smiley-happy:before {
    content: "";
}
.icon-smiley-2:before, .icon-smiley-happy-2:before {
    content: "";
}
.icon-smiley-sad:before {
    content: "";
}
.icon-smiley-sad-2:before {
    content: "";
}
.icon-smiley-neutral:before {
    content: "";
}
.icon-smiley-neutral-2:before {
    content: "";
}
.icon-cart:before {
    content: "";
}
.icon-basket:before {
    content: "";
}
.icon-credit:before {
    content: "";
}
.icon-credit-2:before {
    content: "";
}
.icon-edit:before {
    color: #2F96B4;
}
.icon-publish:before, .icon-save:before, .icon-ok:before, .icon-save-new:before, .icon-save-copy:before, .btn-toolbar .icon-copy:before {
    color: #51A351;
}
.icon-unpublish:before, .icon-not-ok:before, .icon-eye-close:before, .icon-ban-circle:before, .icon-minus-sign:before, .btn-toolbar .icon-cancel:before {
    color: #BD362F;
}
.icon-featured:before, .icon-default:before, .icon-pending:before {
    color: #F89406;
}
 * 
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-20>
 * @package joomla32Interface
 * @subpackage view
 */
class JBridgeToolbarView extends FTemplateController{
	
	/**
	 * índice de armazenamento da toolbar para identificá-la na hora de adicionar o action
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
	 * Adiciona um título é barra de ferramentas
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @param string $strTitulo título da Barra de ferramentas
	 * @param string $strIco Caminho do �cone da barra de ferramentas. Se for da template Khepri (header/), informar somente o nome da imagem.
	 */
	public function addTitle($strTitulo, $strIco = false) {
		if($strIco == false){
			$strIco = 'generic.png';
		}
		if(class_exists('JToolBarHelper'))
			JToolBarHelper::title( JText::_( $strTitulo ), $strIco );
	}
	
	/**
	 * Adiciona um botão é barra de ferramentas
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-20>
	 * @since 1.0
	 * 
	 * @param string $strLabel Label descritivo do item
	 * @param string $strDescription Descrição curta do que a ação faz
	 * @param string $strBootstrapType Tipo do botão no bootstrap (btn-[])
	 * @param string|stdClass $mixAction String: Ação que a aplicação vai fazer ao usar o bot�o - stdClass: Objeto com os atributos de link para a app do tipo mini
	 * @param string $strBootstrapIcon Ícone do bootstrap
	 * @param boolean $bolIsJsFunction Entende a action como um comando js
	 */
	public function addButon($strLabel, $strDescription, $strBootstrapType, $mixAction, $strBootstrapIcon, $bolIsJsFunction = false) {
		//verificar se o action é string ou object
		if(is_object($mixAction)){
			//se o package não vier, pega o mesmo nome do controlador. Essa regra se aplica a todo o WRF
			if(!isset($mixAction->strPckg)){
				$mixAction->strPckg = $mixAction->strCtrl;
			}
		
			//configurar o controller
			$strAction = parent::generateMiniAppUrl($mixAction->strPckg, $mixAction->strCtrl, $mixAction->strAction, 'cms_urlAdminComponentPV');
			
			
		}else{
			//string
			$strAction = $mixAction;
		}
		
		//verificar ícone branco
		$strIconColorClass = '';
		if(in_array($strBootstrapType,array('success')))
			$strIconColorClass = 'icon-white';
		
		$jsBSIcon = '';
		if($strBootstrapType != '')
			$jsBSIcon = "btn-{$strBootstrapType}";
		
		if(!$bolIsJsFunction){
			parent::getObjTemplate()->addJsDeclaration('
				jQuery(function(){
					var btn_'.self::$intIndexBtnAdd.' = jQuery("<button>")
						.html("<span class=\"icon-'.$strBootstrapIcon.' '.$strIconColorClass.'\"></span> '.$strLabel.'")
						.addClass("btn btn-small '.$jsBSIcon.'")
						.click(function(){
							window.location = "'.($strAction).'"
						});
					jQuery("#toolbar").append(btn_'.self::$intIndexBtnAdd.');
				});
			');
		}else{
			parent::getObjTemplate()->addJsDeclaration('
				jQuery(function(){
					var btn_'.self::$intIndexBtnAdd.' = jQuery("<button>")
						.html("<span class=\"icon-'.$strBootstrapIcon.' '.$strIconColorClass.'\"></span> '.$strLabel.'")
						.addClass("btn btn-small '.$jsBSIcon.'")
						.click(function(){
							'.($strAction).';
						});
					jQuery("#toolbar").append(btn_'.self::$intIndexBtnAdd.');
				});
			');
		}
		self::$intIndexBtnAdd++;
	}
}