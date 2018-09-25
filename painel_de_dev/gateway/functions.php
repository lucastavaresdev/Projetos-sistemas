<?php
//=========================================================================================
//
// 01/06/2018
//
//=========================================================================================

//=========================================================================================
// getGatewayJSON
//=========================================================================================
function getGatewayJSON() {

	$json_str = file_get_contents('php://input');
	$ip = $_SERVER['REMOTE_ADDR'];
	$ip2 = $_SERVER['REMOTE_HOST'];

	if (!$json_str) {
		savelog('error', "getGatewayJSON: Nenhuma informação recebida $ip, $ip2", true);
		exit;
	}

	$json_arr = json_decode($json_str, true);

	if (!$json_arr) {
		savelog('error', "getGatewayJSON: A informação recebida não é um JSON $ip, $ip2, $json_str", true);
		exit;
	}

	if (!isset($json_arr['route_mac']) && isset($json_arr['devices']) && isset($json_arr['allCount'])) {
		savelog('error', "getGatewayJSON: JSON inválido", true);
		exit;
	}

	return $json_arr;

}

//=========================================================================================
// getGatewayMac
//=========================================================================================
function getGatewayMac($json) {

	$mac = $json['route_mac'];

	if ($mac) {

		return $mac;

	} else {

		savelog('error', 'getGatewayMac: Mac não informado', true);
		exit;

	}

}

//=========================================================================================
// getGatewayBeacons
//=========================================================================================
function getGatewayBeacons($json) {

	$beacons = $json['devices'];

	if ($beacons) {

		return $beacons;

	} else {

		return [];

	}

}

//=========================================================================================
// parseBeacon
//=========================================================================================
function parseBeacon($b) {

	if (strlen($b['data']) < 60) return false;

	$beacon['mac']		= $b['mac'];
	$beacon['rssi']		= $b['rssi'];
	$beacon['data']		= $b['data'];
	$beacon['type']		= getBeaconType($b);
	$beacon['model']	= getBeaconModel($b);
	$beacon['uuid']		= getBeaconUUID($b);
	$beacon['major']	= getBeaconMajor($b);
	$beacon['minor']	= getBeaconMinor($b);
	$beacon['temp']		= getBeaconTemp($b);
	$beacon['umid']		= getBeaconUmid($b);
	$beacon['bat']		= getBeaconBattery($b);

	return $beacon;

}

//=========================================================================================
// getBeaconType
//=========================================================================================
function getBeaconType($b) {

	return (strlen($b['data']) >= 8) ? substr($b['data'], 4, 4) : '';

}

//=========================================================================================
// getBeaconType
//=========================================================================================
function getBeaconModel($b) {

	$model = (strlen($b['data']) >= 60) ? substr($b['data'], 58, 2) : false;
	$type = getBeaconType($b);

	switch("$type.$model") {
		case '061A.C5': // 197
			return 'Tag';
			break;
		case '061A.B0': // 176
			return 'Pulseira';
			break;
		case '041B.CB': // 203
			return 'Box';
			break;
		case '061B.CB': // 203
			return 'Sensor';
			break;
		default:
			return 'Desconhecido';
	}

}

//=========================================================================================
// getBeaconUUID
//=========================================================================================
function getBeaconUUID($b) {

	return (strlen($b['data']) >= 50) ? NormalizeUUID(substr($b['data'], 18, 32)) : '';

}

//=========================================================================================
// getBeaconMajor
//=========================================================================================
function getBeaconMajor($b) {

	if (getBeaconType($b) == '061B') return '';
	return (strlen($b['data']) >= 54) ? hexdec(substr($b['data'], 50, 4)) : '';

}

//=========================================================================================
// getBeaconMinor
//=========================================================================================
function getBeaconMinor($b) {

	if (getBeaconType($b) == '061B') {
		return (strlen($b['data']) >= 58) ? hexdec(substr($b['data'], 55, 3)) : '';
	}
	return (strlen($b['data']) >= 58) ? hexdec(substr($b['data'], 54, 4)) : '';

}

//=========================================================================================
// getBeaconTemp
//=========================================================================================
function getBeaconTemp($b) {

	if (getBeaconType($b) != '061B') return '';
	return (strlen($b['data']) >= 56) ? number_format(((hexdec(substr($b['data'], 52, 4)) / 65536) * 175.72 ) - 46.85, 2, '.', '') : '';

}

//=========================================================================================
// getBeaconUmid
//=========================================================================================
function getBeaconUmid($b) {

	if (getBeaconType($b) != '061B') return '';
	return (strlen($b['data']) >= 58) ? number_format(((hexdec(substr($b['data'], 50, 2) . substr($b['data'], 56, 2)) / 65536) * 125 ) - 6, 2, '.', '') : '';

}

//=========================================================================================
// getBeaconBattery
//=========================================================================================
function getBeaconBattery($b) {

	$type = getBeaconType($b);

	if ($type == '061B' || $type == '041B') {
		return (strlen($b['data']) >= 62) ? hexdec(substr($b['data'], 60, 2)) : '';
	} else {
		return '';
	}

}

//=========================================================================================
// ACC - 1 Meter RSSI
//=========================================================================================
function acc($rssi, $power, $fator) {

	return number_format((float)pow(10, (($power - $rssi) / (10 * $fator))), 2, '.', '');

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

?>