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
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Listar
function listar() {
	
	$search = post('search');
	$order = post('order');
	$orientation = post('orientation');
	
	$connection = openDB();

	$query = "SELECT 
				tr.id,
				tr.id_equipamento,
				e.nome,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,
				e.setor as id_setor_origem,
				s_or.nome as setor_origem,
				tr.id_setor as id_setor_atual,
				s_at.nome as setor_atual,
				tr.checkout,
				timediff(checkout, checkin) as tempo
				FROM (select
						max(id) as id
						from tracking
						group by id_equipamento) as t
					inner join tracking tr
					on tr.id = t.id
					inner join setores s_at 
					on s_at.id = tr.id_setor
					inner join equipamentos e
					on e.id = tr.id_equipamento
					inner join setores s_or
					on s_or.id = e.setor
				WHERE 
					(e.setor <> tr.id_setor) 
				AND
				(
					e.nome LIKE '%$search%' OR
					e.marca LIKE '%$search%' OR
					e.modelo LIKE '%$search%' OR
					e.serie LIKE '%$search%' OR
					e.patrimonio LIKE '%$search%' OR
					s_or.nome LIKE '%$search%' OR
					s_at.nome LIKE '%$search%'
				)
				order by $order $orientation";

	$results['resultados'] = query($query, $connection)[0];
	jsonStatus(0, '', $results);

}


?>