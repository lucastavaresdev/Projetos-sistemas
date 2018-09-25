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
	case 'pre_desvincular':
		pre_desvincular();
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
		id_agendamento as agendamento,
		data_servico_atual as data_exame,
		nome_paciente as paciente,
		date_format(data_nascimento, '%d-%m-%Y') as data_nascimento,
		date_format(data_nascimento, '%Y-%m-%d') as order_nascimento,
		beacon
		from agendamentos_dia
		where (
			id_agendamento like '%$search%' or
			nome_paciente like '%$search%' or
			beacon like '%$search%'
		)
		order by $order $orientation";

	query($query);

}


// Vincular
function vincular() {

	$beacon		 = post('beacon');
	$agendamento = post('agendamento');

	$query = 
	"UPDATE 
	beacons 
	set 
	id_vinculado = '$agendamento', 
	categoria = 'Paciente'
	WHERE
		codigo = $beacon and 
		id_vinculado is null and
		status = 1;
	INSERT into checklist (agendamento, servico, etapa, ds_etapa, abrev_etapa, hora_agendamento, status)
	SELECT id_agendamento, 
	es.codigo_servico, 
	a.codigo_exame,
	a.descricao_exame, 
	a.codigo_agenda,
	data_agendamento,
	1
	FROM agendamento a 
    left join exame_servico es 
    on es.codigo_exame = a.codigo_exame
    left join servicos s 
    on s.id = es.codigo_servico
	WHERE id_agendamento = '$agendamento';
	INSERT into checkin (agendamento, checkin, status)
	SELECT '$agendamento',
    now(),
    1";
	query($query);

}

// Pré Desvincular
function pre_desvincular() {

	$beacon		 = post('beacon');
	$agendamento = post('agendamento');

	$query = 
	"SELECT 
		* FROM 
		hcor.checklist 
		WHERE agendamento = '$agendamento' and 
		checkout is null";
	query($query);
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