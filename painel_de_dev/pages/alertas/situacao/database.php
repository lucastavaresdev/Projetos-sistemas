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
				t.id,
				t.id_equipamento,
				e.nome,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,				
				e.setor as id_setor_origem,
				s_or.nome as setor_origem,
				t.id_setor as id_setor_atual,
				s_at.nome as setor_atual,
				t.checkout,
				t.tempo,
				e.situacao
				FROM
					(SELECT 
						max(id) as id,
						max(id_gateway) as id_gateway,
						max(id_equipamento) as id_equipamento, 
						timediff( max(checkout), max(checkin)) as tempo,
						max(checkout) as checkout,
						max(id_setor) as id_setor
						FROM cmc.tracking
						group by id_equipamento) as t
					LEFT JOIN setores s_at
					on s_at.id = t.id_setor
					LEFT JOIN equipamentos e 
					on e.id = t.id_equipamento
					LEFT JOIN setores s_or 
					on s_or.id = e.setor
				WHERE 
					(e.situacao <> 'Disponível')
				AND
				(
					e.nome LIKE '%$search%' OR
					e.marca LIKE '%$search%' OR
					e.modelo LIKE '%$search%' OR
					e.serie LIKE '%$search%' OR
					e.patrimonio LIKE '%$search%' OR
					e.situacao LIKE '%$search%' OR
					s_or.nome LIKE '%$search%' OR
					s_at.nome LIKE '%$search%'
				)
				order by $order $orientation";

	$results['resultados'] = query($query, $connection)[0];
	jsonStatus(0, '', $results);

}


?>