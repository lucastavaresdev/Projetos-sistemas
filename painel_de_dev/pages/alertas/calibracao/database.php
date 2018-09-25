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
				c.id,
				e.id as id_equipamento,
				e.nome,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,
				e.calibracao,
				c.calibracao_ultima,
				c.calibracao_ultima + interval e.calibracao day as calibracao_proxima,
				datediff(c.calibracao_ultima + interval e.calibracao day, now()) as calibracao_dias,
				c.id_usuario,
				c.observacao,
				e.situacao,
				e.ativo,
				e.setor as setorid,
				s.sigla as setor_origem,
				s.predio as predio_origem,
				s.andar as andar_origem,    	
				t.setor,
				s2.sigla as setor_destino,
				s2.predio as predio_destino,
				s2.andar as andar_destino,	
				t.tempo,    
				t.checkout	
					from equipamentos e
					left join (
						select
							max(id) as id,
							max(id_usuario) as id_usuario,
							max(id_equipamento) as id_equipamento,
							max(calibracao_ultima) as calibracao_ultima,
							max(observacao) as observacao
							from calibracoes
							group by id_equipamento
					) c on c.id_equipamento = e.id
					left join setores s
					on s.id = e.setor
					left join (
						select 
							max(id_equipamento) as id_equipamento,
							timediff( max(checkout), max(checkin)) as tempo,
							max(checkout) as checkout,
							max(t.id_setor) as setor
							from tracking t
							group by id_equipamento
					) t on t.id_equipamento = e.id
					left join setores s2
					on s2.id = t.setor
				WHERE
					c.calibracao_ultima <> 'null'
				AND
				(
					(c.calibracao_ultima + interval e.calibracao day) between curdate() and (curdate() + interval 15 day) or
					(c.calibracao_ultima + interval e.calibracao day) <= curdate()
				)
				order by $order $orientation";

	$results['resultados'] = query($query, $connection)[0];
	jsonStatus(0, '', $results);

}


?>