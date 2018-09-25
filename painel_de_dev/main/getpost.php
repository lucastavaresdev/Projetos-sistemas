<?php
//=========================================================================================
//
// REQUEST_METHOD GET/POST Functions 28/09/2017
//
//=========================================================================================


//=========================================================================================
// Get Data
//=========================================================================================
function get($field) {
	
	if (gettype($field) != 'string') {
		jsonStatus(2, "function post() {, o parâmetro 'field' deve ser uma string");
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] != 'GET') {
		jsonStatus(2, "Método deve ser 'GET'");
		exit;
	}
	
	if (!isset($_GET[$field])) {
		return "";
	}
	
	$str = $_GET[$field];
	
	$str = str_replace("\"", "", $str);
	$str = str_replace("'", "", $str);
	$str = str_replace("\\", "", $str);

	return  $str;

}

//=========================================================================================
// Post Data
//=========================================================================================
function post($field) {

	if (gettype($field) != 'string') {
		jsonStatus(2, "function post() {, o parâmetro 'field' deve ser uma string");
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		jsonStatus(2, "Método deve ser 'POST'");
		exit;
	}

	if (!isset($_POST[$field])) {
		return "";
	}
	
	$str = $_POST[$field];
	
	$str = str_replace("\"", "", $str);
	$str = str_replace("'", "", $str);
	$str = str_replace("\\", "", $str);

	return  $str;

}


//=========================================================================================
// Permisson
//=========================================================================================
function permission($level) {

	if (!isset($_SESSION)) session_start();

	if (isset($_SESSION["permission"])) {

		if ($_SESSION["permission"] < $level ) {

			jsonStatus(1, 'Você não possui permissão para está ação');

		}

	} else {

		jsonStatus(1, 'Não há informações de permissão');

	}

}

function sqlnull($str) {

	return $str ? "'$str'" : 'NULL';

}

//=========================================================================================
// Get Data
//=========================================================================================
function getdata($array, $key, $default = null) {

	$value = $default ?? "";

	if ( (gettype($array) == "array") && (gettype($key) == "string") ) {

		if (isset($array[$key]))
			$value = $array[$key];		

	}

	return $value;

}

?>