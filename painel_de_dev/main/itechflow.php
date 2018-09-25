<?php
//=========================================================================================
//
// 31/05/2018
//
//=========================================================================================

//=========================================================================================
// Get
//=========================================================================================
function get($value) {

	if ( isset($_GET[$value]) ) {

		return $_GET[$value];

	} else {

		return false;

	}

}

//=========================================================================================
// Post
//=========================================================================================
function post($value) {

	if ( isset($_POST[$value]) ) {

		return $_POST[$value];

	} else {

		return false;

	}

}

//=========================================================================================
// Session
//=========================================================================================
function session($value) {

	if ( isset($_SESSION[$value]) ) {

		return $_SESSION[$value];

	} else {

		return false;

	}

}

//=========================================================================================
// JSON Status
//=========================================================================================
function jsonStatus($status, $msg, $data = null) {

	$json = array("status" => $status, "msg" => $msg, "results" => $data);
	echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	exit;

}

//=========================================================================================
// JSON Response
//=========================================================================================
function jsonResponse($status = 0, $msg = "", $results = []) {

	$json = array("status" => $status, "msg" => $msg, "results" => $results);
	return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

}

//=========================================================================================
// Save Log
//=========================================================================================
function savelog($filename, $line, $append = false) {

	if (!file_exists("_logs/")) {
		mkdir("_logs/", 0700);
	}

	if (gettype($filename) == 'string' && $line) {

		$datetime = date('d/m/Y H:i:s');

		if ($append)
			file_put_contents('_logs/' . $filename . '.txt',   "$datetime - $line" . PHP_EOL, FILE_APPEND);
		else
			file_put_contents('_logs/' . $filename . '.txt',   "$datetime - $line" . PHP_EOL);

	}

}

//=========================================================================================
// Save file
//=========================================================================================
function savefile($filename, $line, $append = false) {

	if (!file_exists("_logs/")) {
		mkdir("_logs/", 0700);
	}

	if (gettype($filename) == 'string' && $line) {

		if ($append)
			file_put_contents("_logs/" . $filename, $line . PHP_EOL, FILE_APPEND);
		else
			file_put_contents("_logs/" . $filename, $line . PHP_EOL);

	}

}

//=========================================================================================
//Database Log
//=========================================================================================
function dblog($string, $clean = null) {

	$filename = 'database_log_' . date('YmdH') . '.txt';
	$datetime = date('d/m/Y H:i:s') . ' ';

	$BOM = "\xEF\xBB\xBF"; // UTF-8

	if (gettype($string) == 'string') {

		if ($clean) {

			file_put_contents($filename, $BOM . $datetime . $string . PHP_EOL);

		} else {

			file_put_contents($filename, $datetime . $string . PHP_EOL, FILE_APPEND);

		}

	} else {

		file_put_contents($filename, 'dblog(string, clean) {: O primeiro parâmetro não é uma string' . PHP_EOL, FILE_APPEND);

	}

}

//=========================================================================================
// Date from DD/MM/AAAA to AAAA-MM-DD
//=========================================================================================
function str2date($str) {

	if (gettype($str) != "string") {

		jsonStatus(2, "Necessário informar a data");

	}

	if (strlen($str) != 10) {

		jsonStatus(2, "A data deve estar no formato DD/MM/AAAA");

	}

	if (count($arr = explode("/", $str)) != 3) {

		jsonStatus(2, "A data deve estar no formato DD/MM/AAAA");

	}

	$dia = $arr[0]; $mes = $arr[1]; $ano = $arr[2];

	if (strlen($dia) != 2) {

		jsonStatus(2, "O 'dia' deve ser informado com 2 caractéres");

	}

	if (strlen($mes) != 2) {

		jsonStatus(2, "O 'mês' deve ser informado com 2 caractéres");

	}

	if (strlen($ano) != 4) {

		jsonStatus(2, "O 'ano' deve ser informado com 4 caractéres");

	}
	
	if (!is_numeric($dia) || !is_numeric($mes) || !is_numeric($ano)) {

		jsonStatus(2, "A data deve contém apenas números separados por '/'");

	}

	return "$ano-$mes-$dia";

}

?>