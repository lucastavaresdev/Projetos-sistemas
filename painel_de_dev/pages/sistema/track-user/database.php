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

	case 'listarAtivos':
		listarAtivos();
	break;
	case 'listarFechados':
		listarFechados();
	break;	
	case 'deletar':
		deletar();
	break;
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Listar Ativos
function listarAtivos() {

	$search = post('search');

	$query = 
	"SELECT
			*       
			from tracking_pacientes_ativo
			where (
				gateway like '%$search%' or
				setor like '%$search%' or
				minor like '%$search%' or
				paciente like '%$search%' 	
				);";

	query($query);

}


// Listar Fechados
function listarFechados() {
	
	$search = post('search');
	$startDate = post('startDate');
	$endDate = post('endDate');
	$limit = (post('limit')) ? post('limit') : '20';

	$query = "SELECT
			t.id,	
			t.gateway,
			g.nome as gateway,
			g.gateway,
			t.id_sala,
			s.nome as setor,
			t.beacon,
			a.nm_paciente as paciente,
			a.cd_aviso_cirurgia as agendamento,
			b.minor,
			t.rssi,
			t.checkin,
			t.checkout,
			timediff(t.checkout, t.checkin) as tempo
			from tracking_pacientes t
			left join setores s on s.id = t.id_sala
			left join gateways g on g.id_sala = t.id_sala
			left join beacons b on b.id = t.beacon
			left join agendamento a on a.cd_aviso_cirurgia = t.id_vinculado
			where
				(
				t.fechado is not null and
				t.id_vinculado is not null and
				t.categoria = 'Paciente'
				)
			and (
				date(t.checkin) >= '$startDate' and
				date(t.checkout) <= '$endDate'
				)
			and (
				s.nome like '%$search%' or
				g.nome like '%$search%' or
				b.minor like '%$search%' or
				a.nm_paciente like '%$search%' 	
				)
			order by t.checkin desc
			limit $limit;";

	query($query)[0];

}

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from beacons where id = '$id'";
	query($query)[0];

}
?>
