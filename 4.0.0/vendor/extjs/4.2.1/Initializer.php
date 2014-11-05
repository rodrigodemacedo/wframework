<?php
namespace ExtJS;
class Initializer{
	
	public function __construct(){
		echo '<pre>'.__FILE__.' (Linha '.__LINE__.")\nChamada: ".__CLASS__."::".__FUNCTION__."() \n";
		var_dump(true);
		echo '</pre>';
		die;
	}
	
	public function getArrJsInfo($strPackageUrl){
		return array('src'=>$strPackageUrl.'source/ext-all.js');
	}
	
	public function getArrCssInfo($strPackageUrl){
		return array('href'=>$strPackageUrl.'source/ext-all.js');
	}
}