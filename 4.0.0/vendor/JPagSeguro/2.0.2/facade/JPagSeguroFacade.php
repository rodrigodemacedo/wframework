<?php
/**
 * Fachada que controla as solicitações do PagSeguro
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2012-01-13>
 * @package packages
 * @subpackage pagseguro/facade
 */
class JPagSeguroFacade{
	
	/**
	 * Objeto que guarda as configurações pessoais da loja
	 * 
	 *  Atributos:
	 * 		'token'=>'<string do token>',
	 *		'email'=>'<string com o e-mail>',
	 *		'currency'=>'<string com a moeda>', //(BRL, ...)
	 * 
	 * @var stdObject
	 */
	private $objPgsUserConfig;
	
	/**
	 * Define as configurações do PagSeguro
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2012-01-12>
	 * @since 1.0
	 * 
	 * 
	 * @var object Objeto com as configurações da loja que venderá os produtos
	 */
	public function setPagSeguroConfig($objPgsConfig) {
		
		if((!is_object($objPgsConfig)) || (is_null($objPgsConfig))){
			return false;
		}
		
		if((!isset($objPgsConfig->currency)) || (!isset($objPgsConfig->email)) || (!isset($objPgsConfig->token))){
			return false;
		}
		
		$this->objPgsUserConfig = $objPgsConfig;
	}
	
	/**
	 * Retorna uma requisição de pagamento
	 * 
	 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
	 * @access public
	 * @version 1.0 <2011-01-12>
	 * @since 1.0
	 */
	public function getRequisicaoPagamento() {
		
		if(is_null($this->objPgsUserConfig)){
			return false;
		}
		
		// Instantiate a new payment request
		require realpath(dirname(__FILE__).'/../source/libraries/PagSeguroLibrary.php');
		$paymentRequest = new PaymentRequest();
		
		// Sets the currency
		$paymentRequest->setCurrency($this->objPgsUserConfig->currency);
		
		return $paymentRequest;
	}
	
	public function getUrlPagamento(PaymentRequest $paymentRequest){
		if(is_null($this->objPgsUserConfig)){
			return false;
		}
		
		try {
			
			/*
			* #### Crendencials ##### 
			* Substitute the parameters below with your credentials (e-mail and token)
			* You can also get your credentails from a config file. See an example:
			* $credentials = PagSeguroConfig::getAccountCredentials();
			*/			
			$credentials = new AccountCredentials($this->objPgsUserConfig->email, $this->objPgsUserConfig->token);
			
			// Register this payment request in PagSeguro, to obtain the payment URL for redirect your customer.
			$url = $paymentRequest->register($credentials);
			
			return $url;
			
		} catch (PagSeguroServiceException $e) {
			throw new Exception('Erro ao Gerar pagamento.');
		}
	}
	
	public function getPaymentButton($arrButtonConfig){
		FInclude::loadClass('fwPackage.jPagSeguro.controller.JPagSeguro');
		$objController = new jPagSeguroController();
		
		return $objController->getPaymentButton($arrButtonConfig);
	}
	
}
?>