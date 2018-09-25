<?php
//=========================================================================================
//
// 01/06/2018
//
//=========================================================================================

//=========================================================================================
// ITechFlow Config & Functions
//=========================================================================================
require "../config.php";
require "../main/" . DEFAULT_LANGUAGE;
require "../main/itechflow.php";
require "../main/db_mysqli.php";
require "functions.php";

//=========================================================================================
// Verifica se o método é POST ou GET
//=========================================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	MethodPost();

} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

	MethodGet();

} else {

	savelog('error', REQUEST_METHOD_INVALID . " '" . $_SERVER["REQUEST_METHOD"] . "'", true);
	exit;

}

//=========================================================================================
// Método POST
//=========================================================================================
function MethodPost() {

	ProductionMode();

}

//=========================================================================================
// Método GET
//=========================================================================================
function MethodGet() {

}

//=========================================================================================
// Production Mode
//=========================================================================================
function ProductionMode() {

	//=========================================================================================
	// GATEWAY SCAN
	//=========================================================================================
	
	$json		= getGatewayJSON();
	$gateway	= getGatewayMac($json);
	$ip			= $_SERVER['REMOTE_ADDR'];
	$beacons	= getGatewayBeacons($json);
	$devices	= count($beacons);

	$logHeader = PHP_EOL . PHP_EOL;
	$logHeader .= "Gateway: $gateway" . PHP_EOL;
	$logHeader .= "Devices: $devices" . PHP_EOL;

	$log = PHP_EOL;
	$log .= "---------------------------------------------" . PHP_EOL;
	$log .= "Gateway: $gateway" . PHP_EOL;
	$log .= "---------------------------------------------" . PHP_EOL;
	$log .= "Devices: $devices" . PHP_EOL;

	// Open DB Connection
	$connection = openDB();

	// Update Gateway
	$query = "update gateways set devices = '$devices', maxdelay_datahora = if (maxdelay < timediff(now(), datahora), now(), maxdelay_datahora), maxdelay = if (maxdelay < timediff(now(), datahora), timediff(now(), datahora), maxdelay), datahora = now(), ip = '$ip' where gateway = '$gateway';";
	$updateGateway = query($query, $connection)[0];

	// Insert Gateway
	if (!$updateGateway) {

		$gateway_default_status = (GATEWAY_DEFAULT_STATUS == 1) ? 1 : 0;
		$gateway_default_maxrssi = (GATEWAY_DEFAULT_MAXRSSI >= -128 && GATEWAY_DEFAULT_MAXRSSI <= -1) ? GATEWAY_DEFAULT_MAXRSSI : -1;
		$gateway_default_maxacc = (GATEWAY_DEFAULT_MAXACC >= 0) ? GATEWAY_DEFAULT_MAXACC : 4;
		$gateway_default_stabilizer = (GATEWAY_DEFAULT_STABILIZER >= 0 && GATEWAY_DEFAULT_STABILIZER <= 2) ? GATEWAY_DEFAULT_STABILIZER : 0;

		$query = "insert into gateways (id, gateway, devices, maxrssi, maxacc, stabilizer, adicionado, datahora, maxdelay_datahora, status, ip) VALUES ('$gateway', '$gateway', '$devices', '$gateway_default_maxrssi', '$gateway_default_maxacc', '$gateway_default_stabilizer', now(), now(), now(), '$gateway_default_status', '$ip') on duplicate key update datahora = now();";
		query($query, $connection, false);

		$log .= "action: insert" . PHP_EOL;
		$log .= "gateway_default_status: $gateway_default_status" . PHP_EOL;
		$log .= "gateway_default_maxrssi: $gateway_default_maxrssi" . PHP_EOL;
		$log .= "gateway_default_stabilizer: $gateway_default_stabilizer" . PHP_EOL;

	} else {

		$log .= "action: update" . PHP_EOL;
	}

	// Get Gateway Config
	$query = "select maxrssi, maxacc, stabilizer, timein, timeout, garbage, id_sala, status from gateways where gateway = '$gateway';";
	$gatewayConfig = query($query, $connection)[0];

	if (!$gatewayConfig) {

		$log .= "config: not found" . PHP_EOL;

		savelog($gateway, $log);
		exit;

	}
	
	$status		= $gatewayConfig[0]['status'];
	$maxrssi	= intval($gatewayConfig[0]['maxrssi']);
	$maxacc		= intval($gatewayConfig[0]['maxacc']);
	$maxacc		= number_format((float)$gatewayConfig[0]['maxacc'], 2, '.', '');
	$stabilizer	= intval($gatewayConfig[0]['stabilizer']);
	$timein		= intval($gatewayConfig[0]['timein']);
	$timeout	= intval($gatewayConfig[0]['timeout']);
	$garbage	= $gatewayConfig[0]['garbage'];
	$id_sala	= $gatewayConfig[0]['id_sala'];	

	$logHeader .= "Status: $status" . PHP_EOL . PHP_EOL;

	$log .= "status: $status" . PHP_EOL;
	$log .= "maxrssi: $maxrssi" . PHP_EOL;
	$log .= "maxacc: $maxacc" . PHP_EOL;
	$log .= "stabilizer: $stabilizer" . PHP_EOL;
	$log .= "timein: $timein" . PHP_EOL;
	$log .= "timeout: $timeout" . PHP_EOL;
	$log .= "garbage: $garbage" . PHP_EOL;
	$log .= "id_sala: $id_sala" . PHP_EOL . PHP_EOL;

	if (!$status) {

		$log .= "-- quit --" . PHP_EOL;
		$log .= "status: 0" . PHP_EOL;
		savelog($gateway, $logHeader . $log);
		exit;

	}

	//=========================================================================================
	// BEACON SCAN
	//=========================================================================================

	$i = 1;
	foreach ($beacons as $_b) {

		$b = parseBeacon($_b);

		if (!$b) continue;

		$beacon	= $b['mac'];
		$rssi	= intval($b['rssi']);
		$type	= $b['type'];
		$model	= $b['model'];
		$uuid	= $b['uuid'];
		$major	= $b['major'];
		$minor	= $b['minor'];
		$temp	= $b['temp'];
		$umid	= $b['umid'];
		$bat	= $b['bat'];
		$data	= $b['data'];

		$log .= "---------------------------------------------" . PHP_EOL;
		$log .= "Beacon: $beacon" . PHP_EOL;
		$log .= "---------------------------------------------" . PHP_EOL;
		$log .= "model: $model" . PHP_EOL;
		$log .= "mac: $beacon" . PHP_EOL;
		$log .= "uuid: $uuid" . PHP_EOL;
		$log .= "major: $major" . PHP_EOL;
		$log .= "minor: $minor" . PHP_EOL;
		$log .= "rssi: $rssi (real)" . PHP_EOL;
		$log .= "type: $type" . PHP_EOL;
		$log .= "temp: $temp" . PHP_EOL;
		$log .= "umid: $umid" . PHP_EOL;
		$log .= "bat: $bat" . PHP_EOL;
		$log .= "adv: $data" . PHP_EOL;

		// Update Beacon		
		$query = "update beacons set type = '$type', model = '$model', uuid = '$uuid', major = '$major', minor = '$minor', temp = '$temp', umid = '$umid', bat = '$bat', data = '$data', datahora = now() where beacon = '$beacon';";
		$updateBeacon = query($query, $connection)[0];

		// Insert Beacon
		if (!$updateBeacon) {

			$beacon_default_status = (BEACON_DEFAULT_STATUS == 1) ? 1 : 0;
			$beacon_default_power = (BEACON_DEFAULT_POWER >= -128 && BEACON_DEFAULT_POWER <= -1) ? BEACON_DEFAULT_POWER : -56;
			$beacon_default_factor = (BEACON_DEFAULT_FACTOR >= 2 && BEACON_DEFAULT_FACTOR <= 10) ? BEACON_DEFAULT_FACTOR : 8;

			//Trava uuid
			if($uuid != 'EBEFD083-70A2-47C8-9837-E7B5634DF524')
				continue;

			$query = "insert into beacons (id, beacon, codigo, type, model, uuid, major, minor, power, factor, temp, umid, bat, data, adicionado, datahora, status) VALUES ('$beacon', '$beacon', '$minor', '$type', '$model', '$uuid', '$major', '$minor', '$beacon_default_power', '$beacon_default_factor', '$temp', '$umid', '$bat', '$data', now(), now(), '$beacon_default_status') on duplicate key update datahora = now();";
			query($query, $connection, false);

			$log .= "action: insert" . PHP_EOL;
			$log .= "beacon_default_status: $beacon_default_status" . PHP_EOL;
			$log .= "beacon_default_power: $beacon_default_power" . PHP_EOL;
			$log .= "beacon_default_factor: $beacon_default_factor" . PHP_EOL;

		} else {

			$log .= "action: update" . PHP_EOL;

		}

		// Get Beacon Config
		$query = "select b.id_vinculado, b.status, b.categoria, b.codigo, b.power, b.factor, t.rssi, t.rssi_buffer from beacons b left join tracking_scan t on t.id = '$gateway.$beacon' where b.beacon = '$beacon'";
		$beaconConfig = query($query, $connection)[0];

		if (!$beaconConfig) {

			$log .= "-- skip --" . PHP_EOL;
			$log .= "config not found" . PHP_EOL . PHP_EOL;
			continue;

		}

		$status			= $beaconConfig[0]['status'];
		$codigo			= $beaconConfig[0]['codigo'];
		$id_vinculado	= $beaconConfig[0]['id_vinculado'];
		$categoria		= $beaconConfig[0]['categoria'];
		$power			= intval($beaconConfig[0]['power']);
		$factor			= intval($beaconConfig[0]['factor']);
		$rssi_buffer3   = intval($beaconConfig[0]['rssi_buffer'] ?: $rssi);
		$rssi_buffer2	= intval($beaconConfig[0]['rssi'] ?: $rssi);
		$rssi_buffer1	= $rssi;

		$log .= "status: $status" . PHP_EOL;
		$log .= "codigo: $codigo" . PHP_EOL;
		$log .= "id_vinculado: $id_vinculado" . PHP_EOL;
		$log .= "categoria: $categoria" . PHP_EOL;
		$log .= "power: $power" . PHP_EOL;
		$log .= "factor: $factor" . PHP_EOL;
		$log .= "rssi_buffer3: $rssi_buffer3" . PHP_EOL;
		$log .= "rssi_buffer2: $rssi_buffer2" . PHP_EOL;
		$log .= "rssi_buffer1: $rssi_buffer1" . PHP_EOL;

	//=========================================================================================
	//TRACKING SCAN
	//=========================================================================================

		// High
		if ($stabilizer == 2) {

			$rssi = intval(($rssi_buffer3 + $rssi_buffer2 + $rssi_buffer1) / 3);
			$rssi_buffer = $rssi_buffer2;

		// Medium
		} else if ($stabilizer == 1) {

			$rssi = intval(($rssi_buffer2 + $rssi_buffer1) / 2);
			$rssi_buffer = $rssi_buffer2;

		// Low
		} else {

			$rssi_buffer = $rssi_buffer1;

		}

		// Acurracy By 1 Meter Rssi
		$acc = acc($rssi, $power, $factor);

		$log .= "---" . PHP_EOL;
		$log .= "rssi: $rssi (final)" . PHP_EOL;
		$log .= "acc: $acc" . PHP_EOL . PHP_EOL;

		$logHeader .= "Beacon: $beacon $model $codigo status: $status | power:$power rssi:$rssi acc:$acc | major: $major minor: $minor | temp: $temp umid: $umid bat: $bat" . PHP_EOL;

		// Update Tracking Scan
		$query = "update tracking_scan set rssi = '$rssi', rssi_buffer = '$rssi_buffer', acc = '$acc', datahora = now() where id = '$gateway.$beacon';";
		$updateScan = query($query, $connection)[0];

		if (!$updateScan) {

			$query = "insert into tracking_scan (id, gateway, beacon, rssi, rssi_buffer, acc, datahora) VALUES ('$gateway.$beacon', '$gateway', '$beacon', '$rssi', '$rssi', '$acc', now()) on duplicate key update datahora = now()";
			query($query, $connection, false);

		}

	//=========================================================================================
	// PRODUCTION - SETUP
	//=========================================================================================

		if (!$id_sala) {

			$log .= "-- skip --" . PHP_EOL;
			$log .= "id_sala: (none)" . PHP_EOL . PHP_EOL;
			continue;

		}

		if (!$id_vinculado) {

			$log .= "-- skip --" . PHP_EOL;
			$log .= "id_vinculado: (none)" . PHP_EOL . PHP_EOL;
			continue;

		}

		if (GATEWAY_RANGE_TYPE == 'ACC') {

			if ($acc > $maxacc) {
				$log .= "-- skip --" . PHP_EOL;
				$log .= "Out of range: $acc > $maxacc" . PHP_EOL . PHP_EOL;
				continue;
			}

		} else {

			if ($rssi < $maxrssi) {
				$log .= "-- skip --" . PHP_EOL;
				$log .= "Out of range: $rssi < $maxrssi" . PHP_EOL . PHP_EOL;
				continue;
			}

		}

		switch($categoria) {

			case 'Paciente':
				$tracking = 'tracking_pacientes';
				break;
			case 'Médico':
				$tracking = 'tracking_medicos';
				break;
			case 'Colaborador':
				$tracking = 'tracking_colaboradores';
				break;
			case 'Equipamento':
				$tracking = 'tracking_equipamentos';
				break;
			default:
				$tracking = "";
		}

		if (!$tracking) {

			$log .= "-- skip --" . PHP_EOL;
			$log .= "categoria: $categoria" . PHP_EOL . PHP_EOL;
			continue;

		}

	//=========================================================================================
	// PRODUCTION - LOCATION
	//=========================================================================================
 
		$query = "select id, id_sala, TIMESTAMPDIFF(SECOND, checkout, now()) as timegap from $tracking where fechado is null and beacon = '$beacon';";
		$beaconLocation = query($query, $connection)[0];
		$uniqueid = "$gateway-$beacon-" . date("YmdHis");

		if (!$beaconLocation) {

			$query = "insert into $tracking (id, gateway, beacon, rssi, id_sala, id_vinculado, categoria, checkin, checkout, timeout, garbage) values ('$uniqueid', '$gateway', '$beacon', '$rssi', '$id_sala', '$id_vinculado', '$categoria', now(), now(), '$timeout', '$garbage') on duplicate key update checkout = now();";
			query($query, $connection, false);

		} else {

			$_id		= $beaconLocation[0]['id'];
			$_id_sala	= $beaconLocation[0]['id_sala'];
			$_timegap 	= intval($beaconLocation[0]['timegap']);

			if ($_id_sala == $id_sala) {

				$query = "update $tracking set gateway = '$gateway', checkout = now(), timeout = $timeout, garbage = $garbage where id = '$_id';";
				query($query, $connection);

			} else {

				if ($_timegap >= $timein) {

					$query = "update $tracking set checkout = now(), fechado = now(), timeout = $timeout, garbage = $garbage where id = '$_id';";
					$query .= "insert into $tracking (id, gateway, beacon, id_sala, id_vinculado, categoria, checkin, checkout, timeout, garbage) values ('$uniqueid', '$gateway', '$beacon', '$id_sala', '$id_vinculado', '$categoria', now(), now(), '$timeout', '$garbage') on duplicate key update checkout = now();";
					query($query, $connection, false);

				}

			}

		}

	}

	//=========================================================================================
	// CLOSE BY TIME OUT
	//=========================================================================================

	$query = "update tracking_pacientes set fechado = now() where fechado is null and timeout > 0 and TIMESTAMPDIFF(SECOND, checkout, now()) >= timeout;";
	$query .= "update tracking_medicos set fechado = now() where fechado is null and timeout > 0 and TIMESTAMPDIFF(SECOND, checkout, now()) >= timeout;";
	$query .= "update tracking_equipamentos set fechado = now() where fechado is and timeout > 0 null and TIMESTAMPDIFF(SECOND, checkout, now()) >= timeout;";
	$query .= "update tracking_colaboradores set fechado = now() where fechado is and timeout > 0 null and TIMESTAMPDIFF(SECOND, checkout, now()) >= timeout;";

	//=========================================================================================
	// DELETE BY GARBAGE
	//=========================================================================================

	$query .= "delete from tracking_pacientes where fechado is not null and garbage > 0 and TIMESTAMPDIFF(SECOND, checkout, now()) <= garbage;";
	$query .= "delete from tracking_medicos where fechado is not null and garbage > 0 and TIMESTAMPDIFF(SECOND, checkout, now()) <= garbage;";
	$query .= "delete from tracking_equipamentos where fechado is not and garbage > 0 null and TIMESTAMPDIFF(SECOND, checkout, now()) <= garbage;";
	$query .= "delete from tracking_colaboradores where fechado is not and garbage > 0 null and TIMESTAMPDIFF(SECOND, checkout, now()) <= garbage;";

	$results = query($query, $connection)[0];

	closeDB($connection);

	savelog($gateway, $logHeader . $log);

}

?>