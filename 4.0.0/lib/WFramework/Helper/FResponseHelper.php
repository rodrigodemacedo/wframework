<?php
namespace WFramework\Helper;

class FResponseHelper {
	private $arrFlashMsg;

	public function __construct() {
		// Carregando a mensagem Flash da session
		if (isset($_SESSION['_fw.wframework.flash'])) {
			$this->arrFlashMsg = $_SESSION['_fw.wframework.flash'];
			unset($_SESSION['_fw.wframework.flash']);
		}
	}
	
	// Define um HTTP Code para ser enviado pelo servidor
	public function setStatus($intStatus) {
		$this->checkHeadersSent();
		$intStatus = (int) $intStatus;
		header(':', true, $intStatus);
		return $this;
	}
	
	// Define um novo cookie para o usuario
	public function cookie($strName, $strValue, $intExpire = 0, $strDomain = '') {
		$this->checkHeadersSent();
		$inExpire = time() + $intExpire;
		$strPath = '/';
		if (strlen($strDomain) > 0) $strDomain = '.' . ltrim($strDomain, '.');
		if (!setcookie($strName, $strValue, $inExpire, $strPath, $strDomain, false, true)) throw new Exception("Cookie cannot be created!");
		return $this;
	}
	
	// Remove o cookie setado
	public function clearCookie($strName, $strDomain = '') {
		$this->checkHeadersSent();
		$inExpire = time() - 3600;
		$strPath = '/';
		if (strlen($strDomain) > 0) $strDomain = '.' . ltrim($strDomain, '.');
		if (!setcookie($strName, $strValue, $inExpire, $strPath, $strDomain, false, true)) throw new Exception("Cookie cannot be deleted!");
		return $this;
	}
	
	// Redireciona o cliente
	public function redirect($strDestinationUrl) {
		$this->checkHeadersSent();
		$this->setStatus(302);
		header('Location: ' . $strDestinationUrl);
	}
	
	// Envia um array para o browser no formato json com UTF-8
	public function json($mixValue) {
		$this->checkHeadersSent();
		header('Content-Type: application/json');
		echo json_encode($this->arrayMapUtf8($mixValue), JSON_FORCE_OBJECT);
	}
	
	// Envia um arquivo com os headers corretos e sem cache
	public function sendFile($strPath) {
		$this->checkHeadersSent();
		
		// Validando se o arquivo anexo existe e se é possível ler o mesmo
		if (!file_exists($strPath)) throw new Exception('The path \'' . $strPath . '\' does not exists!');
		elseif (!is_file($strPath)) throw new Exception('The path \'' . $strPath . '\' is not a file!');
		elseif (!is_readable($strPath)) throw new Exception('The file \'' . $strPath . '\' is not readable!');
		
		// Tamanho do arquivo e extensão
		$arrPath = pathinfo($strPath);
		$strExtension = (!empty($arrPath['extension'])) ? strtolower($arrPath['extension']) : '';
		
		// Determinando o Content-Type do arquivo
		$strContentType = '';
		switch ($strExtension) {
			case 'pdf':
				$strContentType = 'application/pdf';
				break;
			case 'exe':
				$strContentType = 'application/octet-stream';
				break;
			case 'zip':
				$strContentType = 'application/zip';
				break;
			case 'doc':
			case 'docx':
				$strContentType = 'application/msword';
				break;
			case 'xls':
			case 'xlsx':
				$strContentType = 'application/vnd.ms-excel';
				break;
			case 'ppt':
			case 'pptx':
				$strContentType = 'application/vnd.ms-powerpoint';
				break;
			case 'gif':
				$strContentType = 'image/gif';
				break;
			case 'png':
				$strContentType = 'image/png';
				break;
			case 'jpeg':
			case 'jpg':
				$strContentType = 'image/jpg';
				break;
			default:
				$strContentType = 'application/force-download';
		}
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: ' . $strContentType);
		header('Content-Disposition: attachment; filename="' . $arrPath['basename'] . '";');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($strPath));
		set_time_limit(0);
		readfile($strPath);
	}
	
	// Renderiza um template passar por parametro
	public function render($strTemplate) {
		// @TODO
		echo $this->arrFlashMsg['type'];
		echo $this->arrFlashMsg['message'];
	}
	
	// Método que verifica se os Headers ja foram enviados ao cliente
	private function checkHeadersSent() {
		// @TODO
		if (headers_sent()) throw new Exception('Headers already sent!');
	}
	
	// Metodo auxiliar que mapeia o UTF8 encode em todos os valores de um array
	private function arrayMapUtf8($mixValue) {
		if (is_array($mixValue)) {
			foreach ($mixValue as $strKey => $value)
				$mixValue[$strKey] = $this->arrayMapUtf8($mixValue[$strKey]);
		}
		else
			$mixValue = utf8_encode($mixValue);
		return $mixValue;
	}
}