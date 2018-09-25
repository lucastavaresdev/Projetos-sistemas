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

	$query = "SELECT *
				from usuarios
				where nome like '%$search%' or cadastro like '%$search%' or sexo like '%$search%' or login like '%$search%'
				order by $order $orientation";
	query($query);

}

// Salvar
function salvar() {

	$nome		= post('nome');
	$sexo		= post('sexo');
	$cadastro	= post('cadastro');
	$perfil		= post('perfil');
	$login		= post('login');
	$senha		= post('senha');
	$ativo		= post('ativo');

	$query = "insert into usuarios (nome, sexo, cadastro, perfil, ativo, login, senha) values('$nome', '$sexo', '$cadastro', '$perfil', '$ativo', '$login', '$senha')";
	query($query)[0];

}

// Atualizar
function atualizar() {

	$id 		= post('id');
	$nome		= post('nome');
	$sexo		= post('sexo');
	$cadastro	= post('cadastro');
	$perfil		= post('perfil');
	$login		= post('login');
	$senha		= post('senha');
	$ativo		= post('ativo');

	$query = "update usuarios set nome = '$nome', sexo = '$sexo', cadastro = '$cadastro', perfil = '$perfil', ativo = '$ativo', login = '$login', senha = '$senha' where id = '$id'";
	query($query)[0];

}

// Deletar
function deletar() {

	$id = post('id');

	$query = "delete from usuarios where id = '$id'";
	query($query)[0];

}
?>