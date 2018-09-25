<?php
//=========================================================================================
//
// Debug: index.php 28/09/31
//
//=========================================================================================

// Headers: Cross-Origin
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Content-Type");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

//iTechBI Config & Functions
require "../config.php";
require "../main/json.php";
require "../main/getpost.php";
require "../main/logs.php";
require "../main/db_mysqli.php";

//Data e Hora do Servidor
$datetime = date('d/m/Y H:i:s');
//debug($datetime, true);

// Verifica se o método é POST ou GET
if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "OPTIONS") {

	MethodPost();

} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

	MethodGet();

} else {

	jsonStatus(2, $_SERVER["REQUEST_METHOD"] . ": O método: não é suportado");

}

//=========================================================================================
// Método POST
//=========================================================================================
function MethodPost() {

	switch(GATEWAY_MODE) {
		case 'TRACKING':
			debug('GATEWAY_MODE: TRACKING');
			TrackingMode();
			break;
		case 'DEBUG':
			debug('GATEWAY_MODE: DEBUG');
			DebugMode();
			break;
		case 'CAPTURA':
			debug('GATEWAY_MODE: CAPTURA');
			CaptureMode();
			break;
		default:
			debug('GATEWAY_MODE: DEFAULT');
			TrackingMode();
	}

}

//=========================================================================================
// Gateway: Tracking Mode
//=========================================================================================
function TrackingMode() {

	//Json
	$json_str = file_get_contents('php://input');
	$json_arr = json_decode($json_str, true);
	//debug($json_str);

	//Verifica se o gateway é válido (JAALEE)
	if (isset($json_arr['route_mac']) && isset($json_arr['devices']) && isset($json_arr['allCount'])) {

		debug("JAALEE GATEWAY");

	} else {

		debug("GATEWAY DESCONHECIDO");
		exit;

	}

	//Mac do Gateway
	$gateway_mac = getdata($json_arr, 'route_mac');
	debug("Gateway: $gateway_mac", $gateway_mac, true);

	// Abre conexão
	$connection = openDB();

		// Verifica se o Gateway está cadastrado na base
		$query = "select
			g.id,
			g.nome,
			g.setorid,
			s.nome as setor,
			s.tracking,
			g.rssi,
			g.timein,
			g.timeout,
			g.trocar
			from gateways g
			inner join setores s on s.id = g.setorid
			where g.mac = '$gateway_mac' and g.ativo = 'Ativo' and s.ativo = 'Ativo'";

		$gateway = query($query, $connection)[0];

		if (count($gateway) != 1) {

			debug("NÃO CADASTRADO NA BASE", $gateway_mac);
			exit;

		}

		//Ultimo Ping
		//$query = "update gateways set log = now() where mac = '$gateway_mac'";
		//$query = "update gateways set delay = if(delay < timediff(now(), log), timediff(now(), log), delay), log = now() where mac = '$gateway_mac'";
		$query = "update gateways set delaydata = if(delay < timediff(now(), log), now(), delaydata), delay = if(delay < timediff(now(), log), timediff(now(), log), delay), log = now() where mac = '$gateway_mac'";
		query($query, $connection)[0];

		$gateway_id = getdata($gateway[0], 'id');
		$gateway_nome = getdata($gateway[0], 'nome');
		$gateway_id_setor = getdata($gateway[0], 'setorid');
		$gateway_setor = getdata($gateway[0], 'setor');
		$gateway_tracking = getdata($gateway[0], 'tracking');
		$gateway_timein = (getdata($gateway[0], 'timein') ?: TIMEIN);
		$gateway_timeout = (getdata($gateway[0], 'timeout') ?: TIMEOUT);
		$gateway_trocar = getdata($gateway[0], 'trocar');
		$gateway_rssi = getdata($gateway[0], 'rssi');
		debug("Nome: '$gateway_nome', Setor: $gateway_setor, Tracking: $gateway_tracking, Time-In: $gateway_timein, Time-Out: $gateway_timeout, Trocar de Setor: $gateway_trocar, RSSI: $gateway_rssi", $gateway_mac);

		if ($gateway_tracking == 'Manual') {
			debug("Tracking Manual", $gateway_mac);
			exit;
		}

		// Fecha movimentações inativas
		if ($gateway_timeout > 0) {

			$query = "update tracking set fechado = now() where checkin is not null and fechado is null and TIMESTAMPDIFF( SECOND, checkout, now()) > timeout";
			$fechadas = query($query, $connection)[0];
			debug("Movimentações fechadas: $fechadas", $gateway_mac);

		}

		// Apaga checkins desnecessários
		if ($gateway_timein > 0) {

			$query = "delete from tracking where fechado is not null and timestampdiff( second, checkin, checkout) < timein";
			$apagadas = query($query, $connection)[0];
			debug("Movimentações apagadas: $apagadas", $gateway_mac);

		}

	//Array de Beacons
	$beacons = getdata($json_arr, 'devices');
	$beacons_count = count($beacons);

	if ($beacons_count > 0) {

		debug("Beacons Encontrados: $beacons_count ", $gateway_mac);

	} else {

		debug("Nenhum Beacon Encontrado", $gateway_mac);
		exit;

	}

	//Verifica todos os beacons no Array
	$i = 0;
	foreach ($beacons as $beacon) {
		$i++;
		$mac	= getdata($beacon, 'mac');
		$data	= getdata($beacon, 'data');
		$rssi	= getdata($beacon, 'rssi');
		
		debug(PHP_EOL . "#$i" . PHP_EOL . "mac: $mac, data: $data, rssi: $rssi", $gateway_mac);
		
		$query = "select * from beacons where ativo = 'Ativo' and mac = '$mac' and (id_equipamento is not null or id_usuario is not null)";
		$beacon = query($query, $connection)[0];

		if (count($beacon) != 1) {

			debug("Beacon não cadastrado ou inativo ", $gateway_mac);
			continue;

		}

		$beacon_id = getdata($beacon[0], 'id');
		$beacon_id_usuario = sqlnull(getdata($beacon[0], 'id_usuario'));
		$beacon_id_equipamento = sqlnull(getdata($beacon[0], 'id_equipamento'));
		$tipo = getdata($beacon[0], 'tipo');
		$temp_min_real = (getdata($beacon[0], 'temp_min_real'));
		$temp_max_real = (getdata($beacon[0], 'temp_max_real'));
		$umid_min_real = (getdata($beacon[0], 'umid_min_real'));
		$umid_max_real = (getdata($beacon[0], 'umid_max_real'));		

		//Verifica se comprimento do parâmetro 'data' possui ao menos 60 caracteres (30 bytes)
		if (strlen($data) >= 60) {

			//Tipo de Beacon
			$type = substr($data, 4, 4);
			debug("Tipo de Beacon: $type", $gateway_mac);

			//Se o tipo for válido, procura pelo UUID, Major e Minor
			if ($type == "061A") {


				$uuid = NormalizeUUID(substr($data, 18, 32));
				$major = hexdec(substr($data, 50, 4));
				$minor = hexdec(substr($data, 54, 4));
				debug("uuid: $uuid, major: $major, minor: $minor", $gateway_mac);

			}

			//Se o tipo for válido, procura pelo UUID e Temperatura
			if (($type == "061B" || $type == "041B") && $tipo == 'Temperatura') {

				$uuid = NormalizeUUID(substr($data, 18, 32));
				
				//Temperatura, Umidade e Bateria dos beacons SHT
				$temp = temperatura($data);				
				$umid = umidade($data);
				$bateria = bateria($data);
				debug("Temperatura: $temp º || Umidade: $umid % || Bateria: $bateria %", $gateway_mac);
				//Temperatura, Umidade e Bateria dos beacons SHT
				
				//Gravar a menor ou maior Temperatura
				if($temp_min_real == '' && $temp_max_real == ''){
					$query = "UPDATE beacons set temp_min_real = '$temp', temp_max_real = '$temp' where id = '$beacon_id'";
					query($query, $connection)[0];
				}
				if($temp < $temp_min_real){
					$temp_min_real = $temp;
					$query = "UPDATE beacons set temp_min_real = '$temp' where id = '$beacon_id'";
					query($query, $connection)[0];
				} else if($temp > $temp_max_real){
					$temp_max_real = $temp;
					$query = "UPDATE beacons set temp_max_real = '$temp' where id = '$beacon_id'";
					query($query, $connection)[0];
				}
				//Gravar a menor ou maior Temperatura
								
				//Gravar a menor ou maior Umidade
				if($umid_min_real == '' && $umid_max_real == ''){
					$query = "UPDATE beacons set umid_min_real = '$umid', umid_max_real = '$umid' where id = '$beacon_id'";
					query($query, $connection)[0];
				}
				if($umid < $umid_min_real){
					$umid_min_real = $umid;
					$query = "UPDATE beacons set umid_min_real = '$umid' where id = '$beacon_id'";
					query($query, $connection)[0];
				} else if($umid > $umid_max_real){
					$umid_max_real = $umid;
					$query = "UPDATE beacons set umid_max_real = '$umid' where id = '$beacon_id'";
					query($query, $connection)[0];
				}
				//Gravar a menor ou maior Umidade

				$query = "UPDATE beacons set temperatura = '$temp', umidade = '$umid', bateria = '$bateria' where id = '$beacon_id'";
				query($query, $connection)[0];

				$query = "SELECT id_beacon, id_equipamento from clima where id_beacon = '$beacon_id' and id_equipamento = $beacon_id_equipamento and timestampdiff(minute, log, now()) < ".INTERVALO;
				$temperatura = count(query($query, $connection));

				if(!$temperatura){
					$query = "INSERT into clima (id_beacon, id_equipamento, id_gateway, temperatura, umidade, temp_min, temp_max, umid_min, umid_max, log, advertise) values ('$beacon_id', $beacon_id_equipamento, null , '$temp', '$umid', $temp_min_real, $temp_max_real, $umid_min_real, $umid_max_real, now(), '$data')";
					query($query, $connection)[0];

					$query = "UPDATE beacons set temp_min_real = null, temp_max_real = null, umid_min_real = null, umid_max_real = null where id = '$beacon_id'";
					query($query, $connection)[0];
				}

			}

		}

		if ($rssi < $gateway_rssi) {

			debug("FORA DO RANGE ", $gateway_mac);
			continue;

		}

		// Fecha movimentação ao trocar de setor
		if ($gateway_trocar == 'Fechar Log') {

			$query = "update tracking set fechado = now() where fechado is null and id_beacon = '$beacon_id' and id_setor != '$gateway_id_setor'";
			query($query, $connection)[0];

		}

		// Verifica se o Gateway e o beacon já possuem um tracking ativo
		$query = "select rssi from tracking where id_setor = '$gateway_id_setor' and id_beacon = '$beacon_id' and checkin is not null and fechado is null";
		$tracking_ativo = count(query($query, $connection));

		//Atualiza o tempo ativo, se existir
		if ($tracking_ativo) {

			$query = "update tracking set checkout = now(), id_gateway = '$gateway_id', rssi = '$rssi', id_usuario = $beacon_id_usuario, id_equipamento = $beacon_id_equipamento, timein = '$gateway_timein', timeout = '$gateway_timeout', id_setor = '$gateway_id_setor' where fechado is null and id_setor = '$gateway_id_setor' and id_beacon = '$beacon_id'";
			query($query, $connection)[0];
			debug("TRACKING ATUALIZADO", $gateway_mac);

		//Começa um novo registro, caso não exista
		} else {

			$query = "insert into tracking (id_gateway, id_setor, id_beacon, rssi, id_usuario, id_equipamento, checkin, timein, checkout, timeout) values('$gateway_id', '$gateway_id_setor', '$beacon_id', '$rssi', $beacon_id_usuario, $beacon_id_equipamento, now(), '$gateway_timein', now(), '$gateway_timeout')";
			query($query, $connection)[0];
			debug("TRACKING GRAVADO", $gateway_mac);

		}
		

	}

	// Fecha conexão
	closeDB($connection);

}

//=========================================================================================
// Gateway: Debug Mode
//=========================================================================================
function DebugMode() {

	//Json
	$json_str = file_get_contents('php://input');
	$json_arr = json_decode($json_str, true);
	debug($json_str);

	//Verifica se o gateway é válido (JAALEE)
	if (isset($json_arr['route_mac']) && isset($json_arr['devices']) && isset($json_arr['allCount'])) {

		debug("JAALEE GATEWAY");

	} else {

		debug("GATEWAY DESCONHECIDO");
		exit;

	}

	//Mac do Gateway
	$gateway_mac = getdata($json_arr, 'route_mac');
	debug("Gateway: $gateway_mac");
	
	// Abre conexão
	$connection = openDB();

		if (CHECKOUT_TIME > 0) {

			// Fecha movimentações inativas
			$query = "update tracking_debug set fechado = now() where checkin is not null and fechado is null and TIMESTAMPDIFF( SECOND, checkout, now()) > " . CHECKOUT_TIME;
			$fechadas = query($query, $connection)[0];
			debug("Movimentações fechadas: $fechadas");

		}

		if (CHECKIN_TIME > 0) {

			// Apaga checkins desnecessários
			$query = "delete from tracking_debug where fechado is not null and timestampdiff( second, checkin, checkout) < " . CHECKIN_TIME;
			$apagadas = query($query, $connection)[0];
			debug("Movimentações apagadas: $apagadas");

		}

	//Array de Beacons
	$beacons = getdata($json_arr, 'devices');
	$beacons_count = count($beacons);

	if ($beacons_count > 0) {

		debug("Beacons Encontrados: $beacons_count");

	} else {

		debug("Nenhum Beacon Encontrado");
		exit;

	}

	//Verifica todos os beacons no Array
	$i = 1;
	foreach ($beacons as $beacon) {

		$mac	= getdata($beacon, 'mac');
		$data	= getdata($beacon, 'data');
		$rssi	= getdata($beacon, 'rssi');
		debug(PHP_EOL . "#$i" . PHP_EOL . "mac: $mac, data: $data, rssi: $rssi");

		// Verifica se o Gateway e o beacon já possuem um tracking ativo
		$query = "select rssi from tracking_debug where gateway = '$gateway_mac' and beacon = '$mac' and checkin is not null and fechado is null";
		$tracking_ativo = count(query($query, $connection));

		if ($tracking_ativo) {

			$query = "update tracking_debug set checkout = now(), rssi = '$rssi' where fechado is null and gateway = '$gateway_mac' and beacon = '$mac'";
			query($query, $connection)[0];
			debug("TRACKING ATUALIZADO");

		} else {

			$query = "insert into tracking_debug (gateway, beacon, rssi, checkin, checkout) values('$gateway_mac', '$mac', '$rssi', now(), now())";
			query($query, $connection)[0];
			debug("TRACKING GRAVADO");

		}

		//Verifica se comprimento do parâmetro 'data' possui ao menos 60 caracteres (30 bytes)
		if (strlen($data) >= 60) {

			//Tipo de Beacon
			$type = substr($data, 4, 4);
			debug("Tipo de Beacon: $type");

			//Se o tipo for válido, procura pelo UUID, Major e Minor
			if ($type == "061A") {

				$uuid = NormalizeUUID(substr($data, 18, 32));
				$major = hexdec(substr($data, 50, 4));
				$minor = hexdec(substr($data, 54, 4));
				debug("uuid: $uuid, major: $major, minor: $minor");

			}

		}

		$i++;

	}

	// Fecha conexão
	closeDB($connection);

}

//=========================================================================================
// Gateway: Capture Mode
//=========================================================================================
function CaptureMode() {

	//Json
	$json_str = file_get_contents('php://input');
	$json_arr = json_decode($json_str, true);
	debug($json_str);

	//Verifica se o gateway é válido (JAALEE)
	if (isset($json_arr['route_mac']) && isset($json_arr['devices']) && isset($json_arr['allCount'])) {

		debug("JAALEE GATEWAY");

	} else {

		debug("GATEWAY DESCONHECIDO");
		exit;

	}

	//Mac do Gateway
	$gateway_mac = getdata($json_arr, 'route_mac');
	debug("Gateway: $gateway_mac");

	// Abre conexão
	$connection = openDB();

		//Grava no banco
		$query = "insert into gateways (nome, mac, rssi, status) values('$gateway_mac', '$gateway_mac', '-70', 'Ativado')";
		query($query, $connection, 'skip_errors');

	//Array de Beacons
	$beacons = getdata($json_arr, 'devices');
	$beacons_count = count($beacons);

	if ($beacons_count > 0) {

		debug("Beacons Encontrados: $beacons_count");

	} else {

		debug("Nenhum Beacon Encontrado");
		exit;

	}

	//Verifica todos os beacons no Array
	$i = 1;
	foreach ($beacons as $beacon) {

		$mac	= getdata($beacon, 'mac');
		$data	= getdata($beacon, 'data');
		$rssi	= getdata($beacon, 'rssi');
		debug(PHP_EOL . "#$i" . PHP_EOL . "mac: $mac, data: $data, rssi: $rssi");

		//Verifica se comprimento do parâmetro 'data' possui ao menos 60 caracteres (30 bytes)
		if (strlen($data) >= 60) {

			//Tipo de Beacon
			$type = substr($data, 4, 4);
			debug("Tipo de Beacon: $type");

			//Se o tipo for válido, procura pelo UUID, Major e Minor
			if ($type == "061A") {

				$uuid = NormalizeUUID(substr($data, 18, 32));
				$major = hexdec(substr($data, 50, 4));
				$minor = hexdec(substr($data, 54, 4));
				debug("uuid: $uuid, major: $major, minor: $minor");

			}

			//Grava no banco
			$query = "insert into beacons (nome, mac, major, minor, status) values('$mac', '$mac', '$major', '$minor', 'Ativado')";
			query($query, $connection, 'skip_errors');

		} else {

			//Grava no banco
			//$query = "insert into beacons (nome, mac, status) values('$mac', '$mac', 'Ativado')";
			//query($query, $connection, 'skip_errors');

		}

		$i++;

	}

	// Fecha conexão
	closeDB($connection);

}

//=========================================================================================
// Método GET
//=========================================================================================
function MethodGet() {

	header('Location: home.php');
	exit;

}

//=========================================================================================
// Normalize UUID
//=========================================================================================
function NormalizeUUID($uuid) {

	$new_uuid = $uuid;

	if (gettype($uuid) == "string") {

		$length = strlen($uuid);

		if (strlen($uuid) == 36) {

			//$new_uuid = mb_strtoupper($uuid);
			$new_uuid = $uuid;

		} else if (strlen($uuid) == 32) {

			$group1 = substr($uuid, 0, 8);
			$group2 = substr($uuid, 8, 4);
			$group3 = substr($uuid, 12, 4);
			$group4 = substr($uuid, 16, 4);
			$group5 = substr($uuid, 20, 12);

			//$new_uuid = mb_strtoupper($group1 . "-" . $group2 . "-" . $group3 . "-" . $group4 . "-" . $group5);
			$new_uuid = $group1 . "-" . $group2 . "-" . $group3 . "-" . $group4 . "-" . $group5;

		} else {

			JsonStatus(2, "NormalizeUUID: O comprimento do parâmetro deve ser 28 ou 32");

		}

	} else {

		JsonStatus(2, "NormalizeUUID: O parâmetro deve ser do tipo 'string'");

	}

	return  $new_uuid;

}

//=========================================================================================
// Temperatura
//=========================================================================================
function temperatura($uuid) {

	$data = $uuid;

	$temp = hexdec(substr($data, 52, 4));
	$temp = (($temp / 65536) * 175.72 ) - 46.85;
	$temp = number_format($temp, 2, '.', '');

	return $temp;
	
/* 	$umid = hexdec(substr($data, 50, 2) . substr($data, 56, 2));
	$umid = (($umid / 65536) * 125 ) - 6;
	$umid = number_format($umid, 2, '.', '');
	debug("Umidade: $umid %", $gateway_mac); */

}

//=========================================================================================
// Umidade
//=========================================================================================
function umidade($uuid) {

	$data = $uuid;

	$umid = hexdec(substr($data, 50, 2) . substr($data, 56, 2));
	$umid = (($umid / 65536) * 125 ) - 6;
	$umid = number_format($umid, 2, '.', '');
	
	return $umid;

}


//=========================================================================================
// Bateria
//=========================================================================================
function bateria($uuid) {
	
	$data = $uuid;

	$bateria = hexdec(substr($data, 60, 2));
	
	return $bateria;

}


?>