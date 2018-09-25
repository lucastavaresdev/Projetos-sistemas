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
	case 'vincular':
		vincular();
	break;
	case 'desvincular':
		desvincular();
	break;
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Listar
function listar() {
	
	$search = post('search');
	$order = post('order');
	$orientation = post('orientation');	

	$query =
	"SELECT 
		e.id, 
		e.nome, 
		e.marca,
		e.modelo,
		b.beacon
		FROM equipamentos e
		left join beacons b
		on b.id_vinculado = e.id
		and b.categoria = 'Equipamento'
		where (
			e.id like '%$search%' or
			e.nome like '%$search%' or
			e.marca like '%$search%' or
			e.modelo like '%$search%' or
			b.beacon like '%$search%'
		)
		order by $order $orientation";

	query($query);

}


// Vincular
function vincular() {

	$beacon		 = post('beacon');
	$equipamento = post('equipamento');

	$query = 
	"UPDATE 
		beacons 
		set 
		id_vinculado = '$equipamento', 
		categoria = 'Equipamento'
		where
		codigo = $beacon and 
		id_vinculado is null and
		status = 1";
	query($query);

}

// Desvincular
function desvincular() {

	$beacon		 = post('beacon');
	$equipamento = post('equipamento');

	$query = 
	"UPDATE 
		beacons 
		set 
		id_vinculado = null, 
		categoria = null
		where
		beacon = '$beacon' and 
		id_vinculado = '$equipamento'";

	query($query);
}

?>