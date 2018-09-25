<?php
//=========================================================================================
//
// Log Functions 28/09/2017
//
//=========================================================================================


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
// Debug Log
//=========================================================================================
function debug($string, $mac = null, $clean = null) {

	$BOM = "\xEF\xBB\xBF"; // UTF-8
	$nome;

	if($mac != null){
		$nome = 'logs/'.$mac.".txt";

		if (gettype($string) == 'string') {

			if ($clean) {

				file_put_contents($nome, $BOM . $string. PHP_EOL);

			} else {

				file_put_contents($nome, $string. PHP_EOL, FILE_APPEND);

			}

		} else {

			file_put_contents($nome, 'debug(string, clean) {: O primeiro parâmetro não é uma string' . PHP_EOL, FILE_APPEND);

		}

	}

}
?>