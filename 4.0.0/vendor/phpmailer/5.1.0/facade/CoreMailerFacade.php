<?php
class CoreMailerFacade{
	
	public static $objPhpMailer;
	
	/**
	 * Envia um e-mail autenticado usando o PHP Mailer.
	 * O $arrMails tem a seguinte estrutura:
	 * 
	 * array(
	 * 		'mail' => array(
	 * 			'email1@gmail.com',
	 * 			'Meu nome 2' => 'email2@gmail.com',
	 * 			...
	 * 		),
	 * 
	 * 		'cc' => array(
	 * 			'email1@gmail.com',
	 * 			'Meu nome 2' => 'email2@gmail.com',
	 * 			...
	 * 		),
	 * 
	 * 		'bcc' => array(
	 * 			'email1@gmail.com',
	 * 			'Meu nome 2' => 'email2@gmail.com',
	 * 			...
	 * 		),
	 * 
	 * )
	 * 
	 * 
	 * O $arrMailConfig tem a seguinte estrutura:
	 * array(
	 * 		'smtp_host' 		=> 'email.gmail.com',			//obrigatório
	 * 		'smtp_port' 		=> '587', 						//obrigatório
	 * 		'default_domain' 	=> 'gmail.com',					//opcional
	 * 		'auth_user' 		=> 'wrodrigo.macedo@gmail.com',	//obrigatório
	 * 		'auth_pass' 		=> '*********'					//obrigatório
	 * )
	 * 
	 * @param string $strEmail Destinatário 
	 * @param string $strAssunto Assunto
	 * @param string $strMessage Mensagem
	 * @param array $arrMailConfig Configurações de envio
	 */
	public static function send(array $arrMails, $strSubject, $strMessage, $arrMailConfig, array $arrAttach = array()){
		require_once realpath(dirname(__FILE__).'/../').'/source/class.phpmailer.php';
		
		$objMailer = new PHPMailer();
		
		$objMailer->IsSMTP();
		
		$objMailer->Host = $arrMailConfig["smtp_host"]; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
		$objMailer->Port = $arrMailConfig["smtp_port"]; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
		$objMailer->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
		$objMailer->SMTPSecure = 'ssl'; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
		$objMailer->Username = $arrMailConfig['auth_user']; // Usuário do servidor SMTP (endereço de email)
		$objMailer->Password = $arrMailConfig['auth_pass']; // Senha do servidor SMTP (senha do email usado)
		
		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$objMailer->From = $arrMailConfig['from_mail']; // Seu e-mail
		$objMailer->Sender = $arrMailConfig['from_mail']; // Seu e-mail
		$objMailer->FromName = $arrMailConfig['from_name']; // Seu nome
		
		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		
		foreach ($arrMails['mail'] as $strName => $strEmail){
			
			$strNameValid = (!is_numeric($strName));
			
			if($strNameValid !== false){
				$objMailer->AddAddress($strEmail, $strName);
			}else{
				$objMailer->AddAddress($strEmail);
			}
		}
		
		if(isset($arrMails['cc'])){
			foreach ($arrMails['cc'] as $strName => $strEmail){
			
				$strNameValid = (!is_numeric($strName));
			
				if($strNameValid !== false){
					$objMailer->AddCC($strEmail, $strName);
				}else{
					$objMailer->AddCC($strEmail);
				}
			}
		}
		
		if(isset($arrMails['bcc'])){
			foreach ($arrMails['bcc'] as $strName => $strEmail){
					
				$strNameValid = (!is_numeric($strName));
					
				if($strNameValid !== false){
					$objMailer->AddBCC($strEmail, $strName);
				}else{
					$objMailer->AddBCC($strEmail);
				}
			}
		}
			
		// Define os dados técnicos da Mensagem
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$objMailer->IsHTML(true); // Define que o e-mail será enviado como HTML
		
		if(isset($arrMailConfig['charset']))
			$objMailer->CharSet = $arrMailConfig['charset']; // Charset da mensagem (opcional)
		
		$objMailer->Subject  = $strSubject; // Assunto da mensagem
		$objMailer->Body = $strMessage;
		
		ob_start();
		$bolSent = $objMailer->Send();
		ob_end_clean();
		
		$objMailer->ClearAllRecipients();
		$objMailer->ClearAttachments();
		
		if(!$bolSent)
			throw new \Exception($objMailer->ErrorInfo);
	} 
}