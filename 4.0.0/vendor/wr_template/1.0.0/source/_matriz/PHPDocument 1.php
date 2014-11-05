<?php
//configurações da tela
$objWRTemplate = new WRTemplate\Tela("Cadastrar Workflow");

//form de consula dos clientes
$objWRTemplate->addContainer(new \WRTemplate\Form(
	'modulo/pagina',			//Action
	array(						//Elementos
	
	),
	'',							//preEnvioPost
	'popularDadosAssinante'		//posEnvioPost
));