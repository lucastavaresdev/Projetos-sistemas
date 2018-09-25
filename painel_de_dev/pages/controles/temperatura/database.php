<?php
//=========================================================================================
//
// Sistema/Beacons: database.php 01/10/2017
//
//=========================================================================================
session_start();

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
	case 'relatorio':
		relatorio();
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
	$startDate = post('startDate');
	$endDate = post('endDate');
	$order = post('order');
	$orientation = post('orientation');

	$connection = openDB();

	$query = "SELECT 
				tr.id_beacon,
				tr.id_gateway,
				b.mac,
				e.nome,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,
				tr.id_setor as id_setor_atual,
				s_at.nome as setor_atual,
				b.temperatura,
				b.umidade,
				b.bateria
				FROM 
                (select
					max(id) as id
					from tracking
					group by id_equipamento) as t
				inner join tracking tr
				on tr.id = t.id                
				inner join setores s_at 
				on s_at.id = tr.id_setor
				inner join beacons b 
				on b.id = tr.id_beacon
				inner join equipamentos e 
				on e.id = b.id_equipamento
				where (
					b.tipo = 'Temperatura'
				)
				and
				(
						e.nome like '%$search%' or
						e.marca like '%$search%' or
						e.modelo like '%$search%' or
						e.serie like '%$search%' or
						e.patrimonio like '%$search%'
					)
				order by $order $orientation
				";

	$results['temperatura'] = query($query, $connection)[0];


	jsonStatus(0, '', $results);
}

// Relatório
function relatorio() {
	
	$search = post('search');
	$startDate = post('startDate');
	$endDate = post('endDate');
	$order = post('order');
	$orientation = post('orientation');
	$connection = openDB();

	$query = "SELECT 
				t.id,
				t.id_beacon,
				t.id_gateway,
				b.mac,
				e.nome,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,
				t.temperatura,
                b.umid_min,
                b.umid_max,
				t.umidade,
				t.log,
				b.temp_min,
                b.temp_max,
				b.umid_min,
                b.umid_max
				FROM clima t
				inner join beacons b 
				on b.id = t.id_beacon
				inner join equipamentos e 
				on e.id = b.id_equipamento
				where (
					b.tipo = 'Temperatura'
				)
				and
				(
						e.nome like '%$search%' or
						e.marca like '%$search%' or
						e.modelo like '%$search%' or
						e.serie like '%$search%' or
						e.patrimonio like '%$search%' or
						t.id_beacon like '%$search%'
					)
				and
				(
					date(t.log) between '$startDate' and '$endDate'
				)
				order by $order $orientation
				";

	$results['relatorio'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);
}

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from equipamentos where id = '$id'";
	query($query)[0];

}
?>