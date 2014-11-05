<?php
namespace WFramework\Helper;

/**
 * Classe que codifica um array de variáveis em um Hash String
 * Esta clase foi melhorada para o uso de dados binários
 * Utilizando "json" aumentando a economia do algorítmo
 *
 * @author Marcelo Burégio - marceloburegio@gmail.com
 * @subpackage util
 * @version 3.6
 * @since 23/10/2014 20:34
 */
class FEncriptaHelper {

	/**
	 * Método construtor da classe
	 *
	 * @access private
	 */
	private function __construct() {
	}

	/**
	 * Método que converte um array em uma string codificada
	 *
	 * @access public
	 * @param mixed $mixVars
	 * @param string $strId
	 * @param int $intExpire=0
	 * @param boolean $bolIpSecurity=false
	 * @return boolean
	 */
	public static function encode($mixVars, $strKey, $intExpire = 0, $bolIpSecurity = false) {
		/**
		 * FORMATO
		 * -------------------
		 * HASH|TIME|EXPIRE|VARS
		 * 16 bytes
		 * 4 bytes
		 * 4 bytes
		 * X bytes (X = Bytes Variáveis - Serializados com GZIP)
		 */
		$intTime = time();
		$strIp = ($bolIpSecurity) ? $_SERVER['REMOTE_ADDR'] : "";
		
		// Serializando o array de forma mais econômica
		$strVars = json_encode($mixVars);
		
		// Comprime as variáveis usando o GZip DEFLATE
		$binVars = gzdeflate($strVars);
		
		// Montando o hash de verificação
		$arrPrivKey = \WFramework\FConfig::get('fw.encripta');
		$strHash = $arrPrivKey[0] . $strVars . $arrPrivKey[1] . $intExpire . $arrPrivKey[2] . $strKey . $arrPrivKey[3] . $intTime . $arrPrivKey[4] . $strIp . $arrPrivKey[5];
		
		// Criando o hash completo (HASH|TIME|EXPIRE|VARS)
		return base64_encode(md5($strHash, true) . pack("NN", $intTime, $intExpire) . $binVars);
	}

	/**
	 * Método que converte uma string codificada no array que a gerou
	 * Esse método pode retornar false caso não consiga converter
	 *
	 * @access public
	 * @param string $strHash
	 * @param string $strKey
	 * @param boolean $bolIpSecurity=false
	 * @return boolean
	 */
	public static function decode($strHash, $strKey, $bolIpSecurity = false) {
		
		// Decodificando a string para binário
		$binHash = base64_decode($strHash);
		
		// Verificando o tamanho mínimo do hash
		if (strlen($binHash) > 24) {
			
			// Separando os elementos do hash
			$arrHash = unpack("H32md5/Ntime/Nexpire/A*vars", $binHash);
			
			// Descomprimindo as variáveis usando o GZip INFLATE
			$strVars = @gzinflate($arrHash["vars"]);
			$intExpire = $arrHash["expire"];
			$intTime = $arrHash["time"];
			$strMd5 = $arrHash["md5"];
			$strIp = ($bolIpSecurity) ? $_SERVER['REMOTE_ADDR'] : "";
			
			// Montando o hash de verificação
			$arrPrivKey = \WFramework\FConfig::get('fw.encripta');
			$strHash = $arrPrivKey[0] . $strVars . $arrPrivKey[1] . $intExpire . $arrPrivKey[2] . $strKey . $arrPrivKey[3] . $intTime . $arrPrivKey[4] . $strIp . $arrPrivKey[5];
			
			// Calculando o md5 novamente para validação da integridade da informação
			if (md5($strHash) == $strMd5) {
				
				// Verificando se o tempo de expiração foi atingido
				if ($intExpire != 0 && ($intTime + $intExpire) < time()) return false;
				
				// Retornando a variável
				return json_decode($strVars, true);
			}
		}
		return false;
	}
}