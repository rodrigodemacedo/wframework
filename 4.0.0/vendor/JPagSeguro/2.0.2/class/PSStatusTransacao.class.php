<?php
class PSStatusTransacao{
	public $LISTA = array(
		1 => 'Aguardando Pagto',
		2 => 'Em Análise',
		3 => 'Aprovado',
		4 => 'Completo',
		7 => 'Cancelado'
	);
	
	const AGUARDANDO = 'Aguardando Pagto';
	const ANALISE = 'Em Análise';
	const APROVADO = 'Aprovado';
	const COMPLETO = 'Completo';
	const CANCELADO = 'Cancelado';
	
	const ID_AGUARDANDO = 1;
	const ID_ANALISE = 2;
	const ID_APROVADO = 3;
	const ID_COMPLETO = 4;
	const ID_CANCELADO = 7;
	
}
?>