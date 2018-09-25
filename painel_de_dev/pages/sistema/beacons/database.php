<?php
//=========================================================================================
//
// Sistema/Beacons: database.php 01/10/2017
//
//=========================================================================================

// Json
require "../../../main/json.php";

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	jsonStatus(2, "Método deve ser 'POST'");
}

// Verifica a presença de uma query
if (!isset($_POST['command'])) {
	jsonStatus(2, 'Nenhum comando encontrado');
}

//iTechBI Config & Functions
require "../../../config.php";
require "../../../main/logs.php";
require "../../../main/getpost.php";
require "../../../main/db_mysqli.php";

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
	
	$connection = openDB();

	$query = 
	"SELECT
		b.id,
		b.model,
		b.uuid,
		b.beacon,
		b.major,
		b.minor,		
		b.id_vinculado,
		b.categoria,		
		b.temp,
		b.umid,
		b.status
		from beacons b
		where 
		b.model like '%$search%' or 
		b.major like '%$search%' or 
		b.minor like '%$search%' or 
		b.categoria like '%$search%' or 
		b.beacon like '%$search%' 
		order by $order $orientation";

	$results['beacons'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);

}

// Salvar
function salvar() {

	$model			= post('model');
	$beacon			= post('beacon');
	$major  		= post('major');
	$minor			= post('minor');
	$id_vinculado	= post('id_vinculado');
	$categoria		= post('categoria');
	$status			= post('status');

	$query = "insert 
				into beacons 
					(model, 
					beacon,
					major, 
					minor, 
					id_vinculado, 
					categoria,
					status) 
				values
					('$model', 
					$beacon, 
					$major,  
					'$minor', 
					'$id_vinculado', 
					'$categoria',
					$status)";
	query($query)[0];

}

// Atualizar
function atualizar() {

	$id		 		= post('id');
	$model			= post('model');
	$beacon			= post('beacon');
	$major  		= post('major');
	$minor			= post('minor');
	$id_vinculado	= post('id_vinculado');
	$categoria		= post('categoria');
	$status			= post('status');

	$query = "update 
				beacons 
			set 
				model = '$model', 
				beacon = '$beacon', 
				major = '$major', 
				minor = '$minor', 
				id_vinculado = '$id_vinculado', 
				categoria = '$categoria', 
				status = '$status'
			where 
				id = '$id'";
	query($query)[0];

}

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from beacons where id = '$id'";
	query($query)[0];

}
?>
