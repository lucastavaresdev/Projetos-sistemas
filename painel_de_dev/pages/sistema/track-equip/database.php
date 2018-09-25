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
			from tracking_equipamentos_ativo
			where (
				gateway like '%$search%' or
				setor like '%$search%' or
				minor like '%$search%' or
				nome like '%$search%' 	
				);";

	query($query);

}


// Listar Fechados
function listarFechados() {
	
	$search = post('search');
	$limit = (post('limit')) ? post('limit') : '20';

	$query = "SELECT
			t.id,	
			t.id_gateway,
			g.nome as gateway,
			g.mac,
			t.id_setor,
			s.nome as setor,
			t.id_beacon,
			u.nome,
			u.cadastro,
			b.minor,
			t.rssi,
			t.checkin,
			t.checkout,
			timediff(checkout, checkin) as tempo
			from tracking t
			left join setores s on s.id = t.id_setor
			left join gateways g on g.id = t.id_gateway
			left join beacons b on b.id = t.id_beacon
			left join usuarios u on u.id = b.id_usuario
			where 
				(
				fechado is not null and
				t.id_usuario is not null and
				t.id_equipamento is null
				)
			and (
				s.nome like '%$search%' or
				g.nome like '%$search%' or
				b.minor like '%$search%' or
				u.nome like '%$search%' 	
				)
			order by id desc
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
