<?php namespace WRFramework\BootstrapForms;

class HTML{
	
	public static function row(array $arrElementsInRow, $bolFluid = true){
		$strHtml = '<div class="row-fluid">';
		
		foreach ($arrElementsInRow as $strElement){
			$strHtml .= $strElement;
		}
		
		$strHtml .= '</div>';
		
		echo $strHtml;
	}
	
	public static function inputTxt($strLabel, $strNameId, $intPlaces, $strDataTypeAndIcon = "", $strCssInputClass="", $strValue = "", $strMeta = "[]", $strAttributes = ''){
		$strInputType = 'text';
		
		$strHtmlIcon = '';
		if(strpos($strLabel, '[*]') !== false){
			$strCssInputClass .= ' wrv_required';
			$strLabel = str_replace('[*]','*', $strLabel, $i = 1);
		}
		
		if(!preg_match('/^[a-zA-Z0-9]{1}/', $strDataTypeAndIcon)){
			switch (substr($strDataTypeAndIcon, 0,1)) {
				//define um glyphicon
				case '.':
					$strHtmlIcon = '<i class="input-group glyphicon glyphicon-'.substr($strDataTypeAndIcon,1).'"></i>';
					break;
				
				//define o tipo do dado
				case '@':
					//avaliar o tipo
					switch (substr($strDataTypeAndIcon,1)) {
						case 'date':
							$strHtmlIcon = '<i class="glyphicon glyphicon-calendar"></i>';
							$strCssInputClass .= ' wrv_calendar';
							break;
						
						case 'cpf':
							$strHtmlIcon = '1';
							$strCssInputClass .= ' wrv_cpf';
							break;
						
						case 'email':
							$strHtmlIcon = '<i class="glyphicon glyphicon-envelope"></i>';
							$strCssInputClass .= ' wrv_email';
							break;
						
						case 'password':
							$strInputType = 'password';
							$strHtmlIcon = '<i class="glyphicon glyphicon-asterisk"></i>';
							$strCssInputClass .= ' wrv_email';
							break;
						
						case 'passwordConfirm':
							$strInputType = 'password';
							$strHtmlIcon = '<i class="glyphicon glyphicon-asterisk"></i>';
							$strCssInputClass .= ' wrv_email';
							break;
						
						default:
							echo '<pre>'.__FILE__.'('.__LINE__.') **** Class: '.__CLASS__.'::'. __FUNCTION__ . "([...]);\r\n<br />";
							var_dump('Tipo  interno não especificado', substr($strDataTypeAndIcon, 0,1), $strDataTypeAndIcon);
							die;
							break;
					}
					break;
				
					
				default:
					echo '<pre>'.__FILE__.'('.__LINE__.') **** Class: '.__CLASS__.'::'. __FUNCTION__ . "([...]);\r\n<br />";
					var_dump('Tipo não especificado', substr($strDataTypeAndIcon, 0,1), $strDataTypeAndIcon);
					die;
				break;
			}
			
		}else{
			switch ($strDataTypeAndIcon) {
				case 'Aa':
					$strHtmlIcon = '<i class="glyphicon glyphicon-text-height"></i>';
				break;
				
				default:
					$strHtmlIcon = $strDataTypeAndIcon;
				break;
			}
			
		}
		
		//
		//
		//
		
		$arrNameId = explode('#', $strNameId);
		$strId = "";
		if(count($arrNameId) == 1){
			$strHtmlName = 'name="'.$strNameId.'"';
		}else{
			$strHtmlName = 'name="'.$arrNameId[0].'" id="'.$arrNameId[1].'"';
			$strId = $arrNameId[1];
		}
		
		return '
			<div class="form-group col-sm-'.$intPlaces.' has-feedback">
                <label class="control-label" for="'.$strId.'">'.$strLabel.'</label>

                <div class="input-group">
                    <span class="input-group-addon">'.$strHtmlIcon.'</span>
                    <input type="'.$strInputType.'" class="form-control '.$strCssInputClass.'" '.$strHtmlName.' value="'.$strValue.'" '.$strAttributes.'>
                </div>
                <span class="msg help-block">&nbsp;</span>
            </div>
		';
	}
	
	
	public static function textarea($strLabel, $strNameId, $intPlaces, $intRows = 0, $strValue = "", $strCssInputClass=""){
		
		if(strpos($strLabel, '[*]') !== false){
			$strCssInputClass .= ' wrv_required';
			$strLabel = str_replace('[*]','*', $strLabel, $i = 1);
		}
		
		$strRows = ($intRows != 0)?' rows="'.$intRows.'"':'';
		
		$arrNameId = explode('#', $strNameId);
		$strId = "";
		if(count($arrNameId) == 1){
			$strHtmlName = 'name="'.$strNameId.'"';
		}else{
			$strHtmlName = 'name="'.$arrNameId[0].'" id="'.$arrNameId[1].'"';
			$strId = $arrNameId[1];
		}
		
		return '
			<div class="form-group col-sm-'.$intPlaces.' has-feedback">
                <label class="control-label" for="'.$strId.'">'.$strLabel.'</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-text-height"></i></span>
                	<textarea "'.$strRows.'" class="form-control '.$strCssInputClass.'" '.$strHtmlName.'>'.$strValue.'</textarea>
                </div>
                <span class="msg help-block">&nbsp;</span>
            </div>
		';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public static function select($strLabel, $strNameId, $intPlaces, array $arrValues = array('Selecione...'), $strCssInputClass="", $strValSelected = '@@***99**@@'){
		$strHtmlIcon = '';
		if(strpos($strLabel, '[*]') !== false){
			$strCssInputClass .= ' wrv_required';
			$strLabel = str_replace('[*]','*', $strLabel, $i = 1);
		}
		
		$arrNameId = explode('#', $strNameId);
		if(count($arrNameId) == 1){
			$strHtmlName = 'name="'.$strNameId.'"';
		}else{
			$strHtmlName = 'name="'.$arrNameId[0].'" id="'.$arrNameId[1].'"';
		}
		
		$arrHtmlItems = array();
		if(!empty($arrValues)){
			foreach ($arrValues as $strVValue => $strVLabel) {
				if($strVLabel == ''){
					$arrHtmlItems[] = '<option value="">Selecione...</option>';
					
				}else if(strpos($strVLabel, '[#selected]') !== false){
					$strVLabel = str_replace('[#selected]','',$strVLabel);
					$strVValue = (!$strVValue)?'':$strVValue;
					$arrHtmlItems[] = '<option value="'.$strVValue.'" selected="selected">'.$strVLabel.'</option>';
					
				}else if($strVValue == $strValSelected){
					$arrHtmlItems[] = '<option value="'.$strVValue.'" selected="selected">'.$strVLabel.'</option>';
				}else{
					$arrHtmlItems[] = '<option value="'.$strVValue.'">'.$strVLabel.'</option>';
					
				}
				
			}
		}
		
		return ' 		
            <div class="form-group col-sm-'.$intPlaces.'">
                <label class="control-label">'.$strLabel.'</label>
                <div class="input-group">
                	<span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                    <select '.$strHtmlName.' class="form-control input-group-lg '.$strCssInputClass.'">
                        '.implode("\n\t\t\t\t\t\t", $arrHtmlItems).'
                    </select>
                </div>
                <span class="msg help-block">&nbsp;</span>
            </div>
		';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public static function button($strLabel, $strIcon, $strBtnType = 'default', $strClass = '', $intPlaces = false, $strJSFunction = 'javascript:;'){
		if($intPlaces !== false){
			return '
            <div class="form-group col-sm-'.$intPlaces.'">
                <label class="control-label">&nbsp;</label>
                <div class="input-group">
                	<button type="button" class="btn btn-'.$strBtnType.' '.$strClass.' pull-right submit" onclick="'.$strJSFunction.'"><i class="glyphicon glyphicon-'.$strIcon.'"></i> '.$strLabel.'</button>
                </div>
                <span class="msg help-block">&nbsp;</span>
            </div>
		';
		}else{
			return '<button type="submit" class="btn btn-'.$strBtnType.' pull-right submit"><i class="glyphicon glyphicon-'.$strIcon.'"></i> '.$strLabel.'</button>';
		}
	}
	
	public static function btnSubmit($strLabel, $strIcon, $strBtnType = 'default'){
		return '<button type="submit" class="btn btn-'.$strBtnType.' pull-right submit"><i class="glyphicon glyphicon-'.$strIcon.'"></i> '.$strLabel.'</button>';
	}
	
	public static function btnReset($strLabel, $strIcon, $strBtnType = 'default', $strClass = ''){
		return '<button type="reset" class="btn btn-'.$strBtnType.' pull-right submit '.$strClass.'"><i class="glyphicon glyphicon-'.$strIcon.'"></i> '.$strLabel.'</button>';
	}
	
	
	public static function panelBtnOkCancel($strLabelOk, $strLabelCancel, $strUrlCancel){
		
		return ' 
			&nbsp;
			<div class="form_message"></div>
			
			<div class="col-sm-8">
                <label>&nbsp;</label>
            </div>		
            <div class="col-sm-4">
                <label>&nbsp;</label>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right submit"><i class="glyphicon glyphicon-floppy-disk"></i> '.$strLabelOk.'</button>
                    <button type="reset" class="btn btn-default pull-right" onclick="window.location = \''.$strUrlCancel.'\'"><i class="glyphicon glyphicon-arrow-left"></i> '.$strLabelCancel.'</button> &nbsp;
                </div>
            </div>
		';
	}
	
	
	
	
	public function listOptionsEdit($strEditUrl){
		echo '<a class="glyphicon glyphicon-pencil" href="'.$strEditUrl.'"></a> &nbsp;';
	}
	
	public function listOptionsRemove($strRemoveUrl, $strItemName, $intElementIdToRemove){
		echo '<a class="glyphicon glyphicon-remove" href="javascript: objWRBootstrapForms.listOptionsRemove(\''.$strRemoveUrl.'\', \''.$strItemName.'\', '.$intElementIdToRemove.')"></a> &nbsp;';
	}
	
	public function blankspace($intPlaces){
		return '<div class="form-group col-sm-'.$intPlaces.'">&nbsp;</div>';
	}
}