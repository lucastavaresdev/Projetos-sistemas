<?php
//=========================================================================================
//
// JSON Functions 28/09/2017
//
//=========================================================================================


// JSON Header
header("Content-type:application/json;charset=utf-8");

//=========================================================================================
// JSON Status
//=========================================================================================
function jsonStatus($status, $msg, $data = null) {

	if (gettype($status) != "integer") {

		$json = array("status" => 2, "msg" => "JSON 'status' deve ser uma 'integer'");
		echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		exit;

	// 0-Sucesso 1-Alerta 2-Erro 
	} else if ($status < 0 || $status > 2) {

		$json = array("status" => 2, "msg" => "JSON 'status' permitidos: 0-2");
		echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		exit;

	}

	if (gettype($msg) != "string") {

		$json = array("status" => 2, "msg" => "JSON 'msg' deve ser uma 'string'");
		echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		exit;

	}

	$json = array("status" => $status, "msg" => $msg, "results" => $data);
	echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	exit;

}

//=========================================================================================
// JSON App
//=========================================================================================
function jsonApp($data, $group = null) {

	if (gettype($data) != "array") {

		$json = array("status" => 2, "msg" => "JSON 'data' deve ser uma 'array'");
		echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		exit;

	}

	if (gettype($group) != "string") {

		echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		exit;

	}

	$json[$group] = $data;
	echo json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	exit;

}
?>
