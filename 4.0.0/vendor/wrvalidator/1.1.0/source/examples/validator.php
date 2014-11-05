<?php
require '../WRValidatorException.php';
require '../WRValidatorObject.php';
require '../WRValidatorRules.php';
require '../WRValidatorRun.php';
require '../WRValidatorUtils.php';


class Exemplo{
	
	private $id;
	private $nome;
	private $bonus;
	private $email_pessoal;
	private $emails_alt;
	private $data_admissao;
	private $data_demissao;
	private $data_nascimento;
	private $data_nascimento_pai;
	private $cpf;
	private $cep;
	private $turno;
	private $telefone_regex;
	
	public function __construct($id, $nome, $bonus, $email_pessoal, $emails_alt, $data_admissao, $data_demissao, $data_nascimento, $data_nascimento_pai, $cpf, $cep, $turno, $telefone_regex){
		$this->id = $id;
		$this->nome = $nome;
		$this->bonus = $bonus;
		$this->email_pessoal = $email_pessoal;
		$this->emails_alt = $emails_alt;
		$this->data_admissao = $data_admissao;
		$this->data_demissao = $data_demissao;
		$this->data_nascimento = $data_nascimento;
		$this->data_nascimento_pai = $data_nascimento_pai;
		$this->cpf = $cpf;
		$this->cep = $cep;
		$this->turno = $turno;
		$this->telefone_regex = $telefone_regex;
	}
	
	public function getId(){return $this->id;}
	public function getNome(){return $this->nome;}
	public function getBonus(){return $this->bonus;}
	
}

$objDateGT = new DateTime('2001/01/01 12:01:09');

$objToValidate = new Exemplo(
	//1,
	//'Rodrigo de Macêdo',
	'',
	'',
	'',//'-1.2e-2',
	'wrodrigo.macedo@msn.com',
	'wrodrigo.macedo@msn.com; wrodrigo.macedo@gmail.com',
	new DateTime(),//$objDateGT,
	'2001/07/22',
	'23/07/1956',
	new DateTime(),
	'432.539.544-04',
	'25.224-566',
	'manha',
	'081 3222.5222'
);

$objDateGT = new DateTime('2001/01/01 12:01:09');


/** ------------------------------------------------------- **/
try{
	
	$objValidator = new WRValidator\Object($objToValidate, new WRValidator\Rules(
		//lista de atributos obrigatórios
		array(
			'getId','getNome'
		),
		
		//regras de validação
		array(
			'getId' => array(
				WRValidator\Rules::setFieldLabel('Identificador'),
				WRValidator\Rules::TYPE_AS_INT
			),
			'getNome' => array(
				WRValidator\Rules::setFieldLabel('Nome do Recurso'),
				WRValidator\Rules::setMaxStringLength(17)
			),
			'bonus' => array(
				WRValidator\Rules::setFieldLabel('Bônus'),
				WRValidator\Rules::TYPE_AS_NUMERIC,
				WRValidator\Rules::REQUIRED
			),
			'email_pessoal' => array(
				WRValidator\Rules::setFieldLabel('E-mail Pessoal'),
				WRValidator\Rules::TYPE_AS_EMAIL
			),
			'emails_alt' => array(
				WRValidator\Rules::setFieldLabel('E-mail Pessoal'),
				WRValidator\Rules::typeAsMultiEmail(';') //separador dos e-mails
			),
			'data_admissao' => array(
				WRValidator\Rules::setFieldLabel('Data de Admissão'),
				WRValidator\Rules::TYPE_AS_DATE, //se for DateTime, valida só com isso
				//WRValidator\Rules::typeAsDateStr('d/m/Y'), //se a data for uma string, precisa informar o formato para validação
				WRValidator\Rules::dateGreaterThan($objDateGT)
			),
			'data_demissao' => array(
				WRValidator\Rules::setFieldLabel('Data de Demissão'),
				WRValidator\Rules::dateGreaterThan($objDateGT,true,'Y/m/d')
			),
			'data_nascimento' => array(
				WRValidator\Rules::setFieldLabel('Data de Nascimento'),
				WRValidator\Rules::typeAsDateStr('d/m/Y'), //se a data for uma string, precisa informar o formato para validação
			),
			'data_nascimento_pai' => array(
				WRValidator\Rules::setFieldLabel('Data de Nascimento do Pai'),
				WRValidator\Rules::TYPE_AS_DATE, //se for DateTime, valida só com isso
			),
			'cpf' => array(
				WRValidator\Rules::setFieldLabel('CPF'),
				WRValidator\Rules::TYPE_AS_CPF
			),
			'cep' => array(
				WRValidator\Rules::setFieldLabel('CEP'),
				WRValidator\Rules::TYPE_AS_CEP
			),
			'turno' => array(
				WRValidator\Rules::setFieldLabel('Turno de Trabalho'),
				WRValidator\Rules::setPossibleValues('manha','tarde','noite','dia_todo'),
				WRValidator\Rules::setErrorMsg('Você deve selecionar uma das opções: Manhã, Tarde, Noite ou O Dia Todo'),
			),
			//
			// DEPOIS CRIAR UM FORMATO DE TELEFONE
			//
			'telefone_regex' => array(
				WRValidator\Rules::setFieldLabel('Telefone Regex'),
				WRValidator\Rules::applyRegex('^(\(\d{3}\)|\d{3})(|\s)(\d{4})(\.|\-|\s)(\d{4})$'), // (099) 9999.9999 ou (099) 9999-9999
				WRValidator\Rules::setErrorMsg('O campo "Telefone Regex" está incorreto')
			)
		)
	));
			
	//
	// TESTES
	//
	
	//$objValidator->bolStopOnFirstError = true;
	$objValidator->run();
	
}catch(WRValidator\Exception $objEx){
	
	echo '<pre>'.__FILE__.':'.__LINE__.' - '.__CLASS__.'::'.__FUNCTION__.'() | rferreira - 03/04/2012 10:01:25h'."\n<br />";
	var_dump($objEx->getMessage(),'<hr>',$objToValidate,'<hr>',$objEx,'<hr>',$objEx->getTraceAsString());
	die;
	
	throw new Exception($objEx->getMessage());
}