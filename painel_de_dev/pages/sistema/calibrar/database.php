<?php
//=========================================================================================
// JSON Header
//=========================================================================================
header("Content-type:application/json;charset=utf-8");

//=========================================================================================
// Require
//=========================================================================================
require "../../../config.php";
require "../../../main/" . DEFAULT_LANGUAGE;
require "../../../main/itechflow.php";
require "../../../main/db_mysqli.php";

// Verifica a presença de uma query
if (!isset($_POST['command'])) {
	jsonStatus(2, 'Nenhum comando encontrado');
	exit;
}

// Verifica qual é a query e direciona para a função
switch($_POST['command']) {

	case 'hardware':
		hardware();
	break;
	case 'tracking':
		tracking();
	break;
	case 'salvarEstabilizador':
		salvarEstabilizador();
	break;
	case 'salvarRssi':
		salvarRssi();
	break;
	case 'salvarAcc':
		salvarAcc();
	break;
	case 'salvarBeacon':
		salvarBeacon();
	break;
	case 'beacons':
		beacons();
	break;
	case 'trackingBeacon':
		trackingBeacon();
	break;
	default:
		jsonStatus(2, "Comando '" . $_POST['command'] . "' desconhecido");
		exit;

}

// Listar Beacons & Gateways
function hardware() {

	$query = "select id, maxrssi, maxacc, stabilizer from gateways;";
	$query .= "select id, model, codigo, power, factor from beacons order by model, cast(codigo as unsigned);";
	query($query);

}

function tracking() {

	$gateway = post('gateway');
	$beacon = post('beacon');

	$query = "select acc, rssi, date_format(datahora, '%d/%m/%Y %H:%i:%s') as datahora from tracking_scan where id = '$gateway.$beacon'";
	query($query);

}

function salvarEstabilizador() {

	$id = post('id');
	$stabilizer = post('stabilizer');

	$query = "update gateways set stabilizer = '$stabilizer' where id = '$id';";
	query($query);

}

function salvarRssi() {

	$id = post('id');
	$maxrssi = post('maxrssi');

	$query = "update gateways set maxrssi = '$maxrssi' where id = '$id';";
	query($query);

}

function salvarAcc() {

	$id = post('id');
	$maxacc = post('maxacc');

	$query = "update gateways set maxacc = '$maxacc' where id = '$id';";
	query($query);

}

// Salvar Beacons
function salvarBeacon() {

	$id = post('id');
	$power = post('power');
	$factor = post('factor');

	$query = "update beacons set power = '$power', factor = '$factor' where id = '$id';";
	query($query);

}

// Listar Beacons
function beacons() {

	$query = "select id, model, codigo, power, factor from beacons order by model, codigo;";
	query($query);

}

// Tracking Beacon
function trackingBeacon() {

	$beacon = post('beacon');

	$query = "select t.gateway, t.beacon, b.model, b.codigo, g.maxrssi, t.rssi, g.maxacc, t.acc, date_format(t.datahora, '%d/%m/%Y %H:%i:%s') as datahora from tracking_scan t
				inner join gateways g on g.id = t.gateway
				inner join beacons b on b.id = t.beacon
				where t.beacon = '$beacon';";

	query($query);

}

?>