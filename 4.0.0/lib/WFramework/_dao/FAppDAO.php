<?php namespace WRFramework;
/**
 * Todas as DAO's devem herdar desta classe
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-01-20>
 * @package core
 * @subpackage dao
 */
abstract class FAppDAO{
	
	/**
	 * Array de conexões abertas
	 * 	array('dsn_da_conexao' => $objConexao)
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2013-12-02>
	 * @since 1.0
	 * @static
	 *
	 * @var array $arrPoolConnection
	 */
	private static $arrPoolConnection;
	
	/**
	 * Retorna uma instância única de uma conexão
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2014-03-20>
	 * @since 1.0
	 * @return \PDO
	 */
	public static function getInstanceDb($strConexao){
		
		$arrEnvironmentDBVars = FConfig::getAppConfig('db_config');
		$arrDbConfig = $arrEnvironmentDBVars[$strConexao];
		
		switch ($strConexao) {
			case 'sistema':
			default:
				
				/* Connect to an ODBC database using driver invocation */
				$dsn = 'mysql:dbname='.$arrDbConfig['name'].';host='.$arrDbConfig['host'];
				
				if(!isset(self::$arrPoolConnection[$dsn])){
					
					$user = $arrDbConfig['user'];
					$password = $arrDbConfig['pass'];
		
					try{
						$objConnection = new \PDO($dsn, $user, $password);
						$objConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
						if(defined('DB_COLLATION'))
							$objConnection->exec("SET NAMES ".DB_COLLATION);
						
						self::$arrPoolConnection[$dsn] = $objConnection;
						
					}catch(\PDOException $objEx){
						FIncludeHelper::loadClass('fw.core.exception.FDao');
						throw new FDAOException('connectionError',$objEx->getMessage());
					}
				}
		
				break;
		}
		
		return self::$arrPoolConnection[$dsn];
	}
	
	/**
	 * Obriga os filhos a implementar este método, que serve pra pegar a conexão principal da aplicação
	 *
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2014-03-20>
	 * @since 1.0
	 */
	protected abstract function getSysDb();
	
	/**
	 * Processa os parâmetros de consulta.
	 * O parâmetro <var>$arrArrParameter</var> conterá array com os valores também em array preenchidos com:
	 *
	 * array(
	 * 		//campo da tabela que será usado na condição
	 * 		"campo" => "com_data_cadastro",
	 * 		//valor a ser comparado
	 * 		"valor" => '23/07/1986',
	 * 		//ação que será feita com o valor em relação ao campo
	 * 		"acao" => "equals"
	 * );
	 *
	 * A ação conterá os seguintes valores:
	 *
	 * 		in [IN()] Função IN do SQL ANSI
	 * 		not in [NOT IN()] Negação da função IN
	 * 		equal [=] Comparativo de igualdade
	 * 		like [like] Comparativo de cadeia de caracteres em qualquer parte do texto
	 * 		%like [%like] Comparativo de cadeia de caracteres terminando com ...
	 * 		like% [like%] Comparativo de cadeia de caracteres começando com...
	 * 		gt [>] Comparativo de superioridade (greather than)
	 * 		gte [>=] Comparativo de superioridade com igualdade (greather than equals)
	 * 		lt [<] Comparativo de inferioridade (less than)
	 * 		lte [<=] Comparativo de inferioridade com igualdade (less than equals)
	 *
	 *
	 * @param array $arrArrParameter Conjunto de condições a serem aplicadas
	 * @param \PDO $objPDO Objeto que auxilia no escapamento das variáveis
	 *
	 * @return string Retorna a string SQL com a condição a ser aplicada
	 */
	public function setArrParameterToSql(array $arrArrParameter, \PDO $objPDO){
		
		$strSql 		= "";
		$strComplemento = "";
		$arrAcaotoComando["in"] = "in";
		$arrAcaotoComando["not in"] = "not in";
		$arrAcaotoComando["equal"] = "=";
		$arrAcaotoComando["different"] = "<>";
		$arrAcaotoComando["gt"] = ">";
		$arrAcaotoComando["gte"] = ">=";
		$arrAcaotoComando["lt"] = "<";
		$arrAcaotoComando["lte"] = "<=";
		$arrAcaotoComando["between"] = "between";
		
		foreach ($arrArrParameter as $arrParameter) {
			//tratado somente nos repositórios
			if(isset($arrParameter["join"])) continue;
				
			$strOperation = (!isset($arrParameter['operation']))?' AND ':' '.$arrParameter['operation'].' ';
				
			$bolCastNumerico = false;
			
			// Verifica se a consulta é para todos os registros
			if (is_string($arrParameter["valor"]) && strtolower($arrParameter["valor"]) == "todos") {
				/* Pegando o nome do banco que esta conectado */
				$arrDriveConnection = $objPDO->getAvailableDrivers();
				$strDriveConnection = $arrDriveConnection[0];
				// Limitando o resultado dos registros da tabela
				if ($strDriveConnection == "mysql") $strSql .= "limit 0, 20";
			}
			else {
				switch ($arrParameter["acao"]) {
						
					//
					// IN
					//
					case "in":
						foreach($arrParameter["valor"] as $mixValor) {
								
							if (is_string($mixValor)) $strComplemento .= $objPDO->quote($mixValor) . ',';
							else {
								$strComplemento .= $mixValor . ',';
								$bolCastNumerico = true;
							}
						}
						$strComplemento = substr($strComplemento, 0, -1);
						//
						$strSql .= " {$strOperation} " . $arrParameter["campo"] . " " . $arrParameter["acao"] . " (" . $strComplemento .")\r\n";
	
						break;
	
	
					//
					// NOT IN
					//
					case "not in":
						foreach($arrParameter["valor"] as $strValor) {
							if (is_string($strValor)) $strComplemento .= "'" . $strValor . "'" . ',';
							else $strComplemento .= $strValor . ',';
						}
						$strComplemento = substr($strComplemento, 0, -1);
						$strSql .=" {$strOperation} " . $arrParameter["campo"] . " " . $arrParameter["acao"] . " (" . $objPDO->quote($strComplemento) .")\r\n";
						break;
							
			
					//
					// EQUAL
					//
					
					case "equal":
					case "different":
						if (is_array($arrParameter["valor"])) throw new Exception("Esta operação necessida que os valores sejam do Tipo: \r\nInteger, Float, Boolean ou String.");
	
						switch ($arrParameter["valor"]) {
							case 'NULL':
								$arrParameter["valor"] = ' IS NULL';
								break;
								
							case 'NOT NULL':
								$arrParameter["valor"] = ' IS NOT NULL';
								break;
				
							default:
								$arrParameter["valor"] = " {$arrAcaotoComando[$arrParameter["acao"]]} ".$objPDO->quote($arrParameter["valor"]);
							}
	
						if (empty($arrParameter["condicao"]))
							$strSql .=" {$strOperation} " . $arrParameter["campo"] . @$arrParameter["valor"] ."\r\n";
						else 
							$strSql .= $arrParameter["condicao"] . " " . $arrParameter["campo"] . @$arrParameter["valor"] ."\r\n";
						
						break;
								
								
						//
						// LIKE, %LIKE E LIKE%
						//
						
						case "like":
							$strLikeVal = '%'.@$arrParameter["valor"].'%';
	
						case "%like":
						if(!isset($strLikeVal))
							$strLikeVal = '%'.@$arrParameter["valor"];
									
						case "like%":
							if(!isset($strLikeVal))
								$strLikeVal = @$arrParameter["valor"].'%';
										
							$strSql .=" {$strOperation} " . $arrParameter["campo"] . " LIKE " . $objPDO->quote($strLikeVal) ."\r\n";
							
							unset($strLikeVal);
							
							break;
													
													
						//
						// GT, GTE, LT, LTE
						//
									
													
						case "gt":
							$strAcao = '>';
						case "gte":
							if(!isset($strAcao))
								$strAcao = '>=';
						case "lt":
							if(!isset($strAcao))
								$strAcao = '<';
						case "lte":
							if(!isset($strAcao))
								$strAcao = '<=';
								
							$strCondicao = $strOperation;
							if(isset($arrParameter["condicao"]))
								$strCondicao = $arrParameter["condicao"];

							$strSql .= " {$strCondicao} " . $arrParameter["campo"] . " {$strAcao} " . $objPDO->quote($arrParameter["valor"]) ."\r\n";

							unset($strAcao);

							break;
	
						
						case "between":
							$strSql .= " {$strOperation} " . $arrParameter["campo"] . " between " . $arrParameter["valor"] ."\r\n";
							break;

						default:
							throw new \Exception('Falha ao montar a query pelo '.HOME_NAMESPACE.'\\'.__CLASS__.'::'.__FUNCTION__.'()');
							break;
				}
			}
			//$strSql .=" AND " . $arrParameter["campo"] . " " . $arrParameter["acao"] . $objPDO->quote($arrParameter["valor"]) ."\r\n";
		}
	
		return $strSql;
	}
	
}

?>