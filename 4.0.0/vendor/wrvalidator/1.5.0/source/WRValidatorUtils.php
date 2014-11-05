<?php
namespace WRValidator;

/**
 * Classe que contém funções utilitárias que ajudam o WRValidator na sua tarefa
 * 
 * @author Rodrigo de Macêdo <rferreira@jc.com.br>
 * @version 1.0.0 15/03/2012 15:34:22
 */
class Utils{
	
	/*
	public static function convertStrDateToDateTimeWithoutFormat($strDate){
		
		$arrDateParts = explode(' ', $strDate);
		echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 26/07/2012 16:41:27h'."\n<br />";
		var_dump($arrDateParts);
		die;
		
		//aplicar a regex de data
		$strRegexYear1 	= '(\d{2})'; // 12
		$strRegexYear2 	= '((19|20)\d\d)'; // 2012
		$strRegexMonth 	= '(0[1-9]|1[012])';
		$strRegexDay 	= '(0[1-9]|[12]\d|3[01])';
		$strRegexTime 	= '([01]\d|2[0-3])(\:|\.)([0-5]\d)(\:|\.)([0-5]\d)';
		$strRegexSep 	= '(\-|\/|\.)';
		
		
		
		echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 26/07/2012 16:32:27h'."\n<br />";
		var_dump($strDate);
		die;
		$strDate = date('d/m/Y H:i:s');
		
		$arrTmp = explode(' ',$strDate);
		
		preg_match('/(\.|\-|\/)/', $arrTmp[0], $arrMatches);
		if((empty($arrMatches)) || (count($arrMatches) != 2)){
			throw new Exception(5100,$strDate);
		}
		
		$sep = $arrMatches[0];
		$arrDate = explode($sep,$arrTmp[0]);
		
		
		echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 04/04/2012 16:33:48h'."\n<br />";
		var_dump($arrDate);
		die;
		if(strlen($arrDate[0]) == 4){
			$strFormat = (count($arrTmp) == 2)?"Y{$sep}m{$sep}d H:i:s":"Y{$sep}m{$sep}d";
			return DateTime::createFromFormat($strFormat, $strDate);
			
		}else if(strlen($arrDate[2]) == 4){
			$strFormat = (count($arrTmp) == 2)?"d{$sep}m{$sep}Y H:i:s":"Y{$sep}m{$sep}d";
			return DateTime::createFromFormat($strFormat, $strDate);
			
		}else{
			throw new Exception(5101,$strDate);
		}
	}
	*/
	
	/*
	 * VALIDAÇÃO ANTIGA DA DATA
	 * 
	 * 		
	 		//aplicar a regex de data
			$strRegexYear1 	= '(\d{2})'; // 12
			$strRegexYear2 	= '((19|20)\d\d)'; // 2012
			$strRegexMonth 	= '(0[1-9]|1[012])';
			$strRegexDay 	= '(0[1-9]|[12]\d|3[01])';
			$strRegexTime 	= '([01]\d|2[0-3])(\:|\.)([0-5]\d)(\:|\.)([0-5]\d)';
			$strRegexSep 	= '(\-|\/|\.)';
			
			$strFullDateRegex = '/^';
			switch (strlen($mixValue)) {
				// d/m/y | y/m/d
				case 8:
				case 17:
					$strFullDateRegex .= "({$strRegexDay}{$strRegexSep}{$strRegexMonth}{$strRegexSep}{$strRegexYear1})";
					$strFullDateRegex .= "|";
					$strFullDateRegex .= "({$strRegexYear1}{$strRegexSep}{$strRegexMonth}{$strRegexSep}{$strRegexDay})";
					break;
					
				// d/m/Y | Y/m/d
				case 10:
				case 19:
					$strFullDateRegex .= "({$strRegexDay}{$strRegexSep}{$strRegexMonth}{$strRegexSep}{$strRegexYear2})";
					$strFullDateRegex .= "|";
					$strFullDateRegex .= "({$strRegexYear2}{$strRegexSep}{$strRegexMonth}{$strRegexSep}{$strRegexDay})";
					break;
				
				default: 
					//formato inválido 
					throw new \Exception(NULL,5013);
			}
			
			//adicionar a hora à regex
			if ((strlen($mixValue) == 17) || (strlen($mixValue) == 19)) {
				$strFullDateRegex .= "\s{$strRegexTime}";
			}
			
			$strFullDateRegex .= '$/';
		
			//testar
			preg_match($strFullDateRegex, $mixValue, $arrMatches);

			if(empty($arrMatches))
				throw new \Exception(NULL,5013);
	 * 
	 * 
	 * */
}