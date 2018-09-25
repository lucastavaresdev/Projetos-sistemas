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
	
	$connection = openDB();

	$query = 
	"SELECT 
		b.id,
		b.minor,
		b.id_vinculado,
		a.nome_paciente,
		a.data_servico_atual as dt_agendamento
		FROM hcor.beacons b
		left join agendamento a
		on b.id_vinculado = a.id_agendamento
		where 
		b.categoria = 'Paciente' and
		(
			b.model like '%$search%' or 
			b.major like '%$search%' or 
			b.minor like '%$search%' or 
			b.categoria like '%$search%' or 
			b.id_vinculado like '%$search%' or 
			b.beacon like '%$search%' or
			a.nome_paciente like '%$search%' or
			a.data_servico_atual like '%$search%'
		)
		group by id_agendamento
		order by $order $orientation";

	$results['beacons'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);

}

// Desvincular
function desvincular() {

	$beacon		 = post('beacon');
	$agendamento = post('agendamento');

	$query = 
	"UPDATE 
	beacons 
	set 
	ID_VINCULADO = NULL, 
	CATEGORIA = NULL
	WHERE
		BEACON = '$beacon' AND 
		ID_VINCULADO = '$agendamento' AND
		STATUS = 1;
	UPDATE 
	checkin
	set checkout = now()
	WHERE 
		agendamento = '$agendamento' AND
		checkout is null;
	UPDATE
	tracking_pacientes
	set fechado = now()
	WHERE 
		id_vinculado = '$agendamento' AND
		fechado is null;";
	query($query);
}

?>
