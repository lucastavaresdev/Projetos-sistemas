<?php
//=========================================================================================
//
// Sistema/Beacons: database.php 01/10/2017
//
//=========================================================================================

header('Content-Type: application/json');

//iTechBI Config & Functions
require "../../../config.php";
require "../../../main/".DEFAULT_LANGUAGE;
require "../../../main/itechflow.php";
require "../../../main/db_mysqli.php";


// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	savelog('error', REQUEST_METHOD_INVALID . " '" . $_SERVER["REQUEST_METHOD"] . "'", true);
	exit;
}

// Verifica a presença de uma query
if (!isset($_POST['command'])) {
	savelog('error', "Comando Inválido '" . $_SERVER["REQUEST_METHOD"] . "'", true);
	exit;
}

// Verifica qual é a query e direciona para a função
switch($_POST['command']) {

	case 'listar':
		listar();
	break;
	case 'salvar':
		salvar();
	break;
	case 'atualizar':
		atualizar();
	break;
	case 'deletar':
		deletar();
	break;
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Listar
function listar() {
	
	$search = post('search');
	$order = post('order');
	$orientation = post('orientation');

	$query = "select *
				from setores
				where nome like '%$search%' or sigla like '%$search%' or andar like '%$search%'
				order by $order $orientation";
				
	query($query)[0];

}

// Salvar
function salvar() {

	$nome			= post('nome');
	$sigla			= post('sigla');
	$andar			= post('andar');
	$capacidade		= post('capacidade');
	$permanencia	= post('permanencia');
	$tracking		= post('tracking');
	$atendimentos		= post('atendimentos');
	$ativo			= post('ativo');

	$query = "insert into setores (nome, sigla, andar, capacidade, permanencia, tracking, atendimentos, ativo) values('$nome', '$sigla', '$andar', '$capacidade', '$permanencia', '$tracking', '$atendimentos', '$ativo')";
	query($query)[0];

}

// Atualizar
function atualizar() {

	$id 			= post('id');
	$nome			= post('nome');
	$sigla			= post('sigla');
	$andar			= post('andar');
	$capacidade		= post('capacidade');
	$permanencia	= post('permanencia');
	$tracking		= post('tracking');
	$atendimentos		= post('atendimentos');
	$ativo			= post('ativo');

	$query = "update setores set nome = '$nome', sigla = '$sigla', andar = '$andar', capacidade = '$capacidade', permanencia = '$permanencia', tracking = '$tracking', atendimentos = '$atendimentos', ativo = '$ativo' where id = '$id'";
	query($query)[0];

}

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from setores where id = '$id'";
	query($query)[0];

}
?>