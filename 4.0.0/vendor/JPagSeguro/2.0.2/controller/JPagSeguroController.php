<?php
class jPagSeguroController{
	
	/**
	 * 
	 * 		*['receiverEmail'] 				//e-mail do vendedor
	 * 		 ['currency'] 					//moeda
	 * 
	 * 		*['items']['itemId'] 			//id do item no seu sistema
	 * 		*['items']['itemDescription'] 	//descrição do item no seu sistema
	 * 		*['items']['itemAmount'] 		//valor unitário do item no seu sistema
	 * 		*['items']['itemQuantity']		//quantidade do item no seu sistema
	 * 		 ['items']['itemWeight']		//peso do item no seu sistema para cálculo de frete
	 * 		 ['items']['itemShippingCost']	//peso do item no seu sistema para cálculo de frete
	 * 
	 *		 ['reference']					//ID da venda no seu sistema pra referenciar no pagseguro
	 * 		 
	 *		 ['senderName']					//ID da venda no seu sistema pra referenciar no pagseguro
	 *		 ['senderAreaCode']				//ID da venda no seu sistema pra referenciar no pagseguro
	 *		 ['senderPhone']				//ID da venda no seu sistema pra referenciar no pagseguro
	 *		 ['senderEmail']				//ID da venda no seu sistema pra referenciar no pagseguro
	 *
	 *		 ['submit']						//ID da venda no seu sistema pra referenciar no pagseguro
	 * 
	 * 
	 * @param array $arrButtonConfig
	 */
	public function getPaymentButton($arrButtonConfig){
		ob_start();
		?>
		<form method="post" target="pagseguro" action="https://pagseguro.uol.com.br/v2/checkout/payment.html">  
          	<?php 
          		foreach ($arrButtonConfig as $strMainVar => $mixMainValue) {


          			switch ($strMainVar) {

						//
						// ITENS DA COMPRA
						//


          				case 'items':
          					foreach ($arrButtonConfig['items'] as $i => $arrItemInfo):
          						  foreach ($arrItemInfo as $strItemVar => $strItemVal):
          	?><input name="<?php echo $strItemVar.$i?>" type="hidden" value="<?php echo $strItemVal?>"><?php 
          						  	endforeach;
          					endforeach;
          				break;
          				
          				
          				
          				//
          				// BOTÃO SUBMIT
          				//
          				
          				
          				
          				case 'submit':
          	?>
          	<!-- submit do form (obrigatório) -->  
	        <input alt="Pague com PagSeguro" name="submit"  type="image" src="<?php echo $mixMainValue?>"/>
	        <?php 
          				break;
          				
          				
          				
          				
          				//
          				// VARIÁVEIS DIVERSAS
          				//
          				
          				
          				
          				default:
          					?><input name="<?php echo $strMainVar?>" type="hidden" value="<?php echo $mixMainValue?>"><?php 
          				break;
          			}
          		}
          	?>
	          
	</form> 
		<?php 
		
		$strHTMLContent = ob_get_clean();
		return $strHTMLContent;
	}
}