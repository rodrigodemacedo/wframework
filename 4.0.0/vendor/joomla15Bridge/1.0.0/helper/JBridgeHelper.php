<?php
/**
 * Helpers do JoomlaBridge
 * 
 * @author Rodrigo de Macêdo <wrodrigo.macedo@msn.com>
 * @access public
 * @version 1.0 <2011-11-19>
 * @package packages
 * @subpackage joomla15Bridge/helper
 */
class JBridgeHelper{
	
	public static function sendEmail(){
		
		//$mail = JFactory::getMailer();
		require '/var/www/public_html/_utils/PHPMailer_v5.1/class.phpmailer.php';
		require '/var/www/public_html/_utils/PHPMailer_v5.1/class.smtp.php';
		$mail = new PHPMailer();
		$mail->SMTPDebug = true;
		
		// Define o método de envio
		//$mail->Mailer     = "smtp";
		$mail->IsSMTP();
		 
		// Define que a mensagem poderá ter formatação HTML
		$mail->IsHTML(true); //
		 
		// Define que a codificação do conteúdo da mensagem será utf-8
		$mail->CharSet    = "utf-8";
		 
		// Define que os emails enviadas utilizarão SMTP Seguro tls
		//$mail->SMTPSecure = "tls";
		$mail->SMTPSecure = "ssl";
		 
		// Define que o Host que enviará a mensagem é o Gmail
		//$mail->Host       = "smtp.gmail.com";
		$mail->Host       = "ssl://smtp.gmail.com";
		 
		//Define a porta utilizada pelo Gmail para o envio autenticado
		$mail->Port       = "465";                  
		//$mail->Port       = "465";                  
		 
		// Deine que a mensagem utiliza método de envio autenticado
		$mail->SMTPAuth   = "true";
		
		//$mail->SetLanguage("br", "libs/");
		
		 
		// Define o usuário do gmail autenticado responsável pelo envio
		$mail->Username   = "wrodrigo.macedo@gmail.com";
		//$mail->Username   = "wrodrigo.macedo";
		 
		// Define a senha deste usuário citado acima
		$mail->Password   = "";
		 
		// Defina o email e o nome que aparecerá como remetente no cabeçalho
		$mail->From       = "wrodrigo.macedo@gmail.com";
		$mail->FromName   = "Rodrigo Mail Local";
		 
		// Define o destinatário que receberá a mensagem
		$mail->AddAddress("wrodrigo.macedo@msn.com");
		 
		/*
		Define o email que receberá resposta desta
		mensagem, quando o destinatário responder
		*/
		$mail->AddReplyTo("wrodrigo.macedo@gmail.com", $mail->FromName);
		 
		// Assunto da mensagem
		$mail->Subject    = "Teste de Envio";
		 
		// Toda a estrutura HTML e corpo da mensagem
		$mail->Body       = 'testMessage<hr /><strong>Bold!</strong><br />.';
		
		echo '<pre>'.__FILE__.' (Linha '.__LINE__.") \n";
		var_dump($mail,$mail->Send());
		echo '</pre>';
		die;
		
		
		/*
		//jimport( 'joomla.mail.mail' );
		$objJMail = JFactory::getMailer();
		$objJMail->addRecipient('wrodrigo.macedo@msn.com');
		$objJMail->setBody('testMessage<hr /><strong>Bold!</strong><br />.');
		$objJMail->setSubject("Paceville activity update");
		$objJMail->setSender(JFactory::getConfig()->getValue('config.mailfrom'));
		
		if(JFactory::getConfig()->getValue('config.mailer') == 'smtp'){
			$objJMail->useSMTP(
				JFactory::getConfig()->getValue('config.smtpauth'), 
				JFactory::getConfig()->getValue('config.smtphost'), 
				JFactory::getConfig()->getValue('config.smtpuser'), 
				JFactory::getConfig()->getValue('config.smtppass'), 
				JFactory::getConfig()->getValue('config.smtpsecure'), 
				JFactory::getConfig()->getValue('config.smtpport')
			);
		}else{
			die('Configure o envio do e-mail via SMTP');
		}
		*/
		echo '<pre>'.__FILE__.' (Linha '.__LINE__.") \n";
		var_dump($objJMail->Send());
		echo '</pre>';
		die;
	}
}
?>