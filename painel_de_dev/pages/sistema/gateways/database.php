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
		g.id,
		g.gateway,		
		s.nome as setor,
		g.maxrssi,
		g.timein,
		g.timeout,
		g.datahora,
		g.maxdelay,
		g.maxdelay_datahora,
		g.status,
		g.id_sala
		FROM 
		gateways g
		left join
		setores s 
		on s.id = g.id_sala
		where 
		g.gateway like '%$search%' or
		s.nome like '%$search%'
		order by $order $orientation";

	$results['gateways'] = query($query, $connection)[0];

	$query = "select id, concat (sigla, ' | ', nome) as nome from setores order by nome";
	$results['setores'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);

}

// Salvar
function salvar() {

	$id_sala	= post('id_sala');
	$gateway	= post('gateway');
	$rssi		= post('rssi');
	$timein		= post('timein');
	$timeout	= post('timeout');
	$status		= post('status');

	$query = "insert into gateways (id_sala, gateway, rssi, timein, timeout, status) values('$id_sala', '$gateway', '$rssi', '$timein', '$timeout', '$status')";
	query($query)[0];

}

// Atualizar
function atualizar() {

	$id 		= post('id');
	$id_sala	= post('id_sala');
	$gateway	= post('gateway');
	$maxrssi	= post('maxrssi');
	$timein		= post('timein');
	$timeout	= post('timeout');
	$status		= post('status');

	$query = "update gateways set id_sala = '$id_sala', gateway = '$gateway', maxrssi = '$maxrssi', timein = '$timein', timeout = '$timeout', status = '$status' where id = '$id'";
	query($query)[0];

}

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from gateways where id = '$id'";
	query($query)[0];

}
?>