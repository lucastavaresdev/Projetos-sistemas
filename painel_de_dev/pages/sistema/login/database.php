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

	case 'login':
		login();
	break;
	case 'logout':
		logout();
	break;
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Login
function login() {

	if (!isset($_SESSION)) session_start();

	$login = post('login');
	$senha = post('senha');

	if (MASTER_USER && MASTER_PASSWORD) {

		if ($login == MASTER_USER && $senha == MASTER_PASSWORD) {

			$_SESSION["userid"] = '0';
			$_SESSION["login"] = 'itech';
			$_SESSION["username"] = 'Desenvolvedor';
			$_SESSION["permission"] = '0';

			jsonStatus(0, "Nome: Desenvolvedor, Permissão: Nível 0", $_SESSION);

		} else {
	
			$query = "select * from usuarios where login = '$login' and senha = '$senha'";
			$connection = openDB();
			$results = query($query, $connection)[0];
			closeDB($connection);
	
			if (count($results) == 1) {

				$id = getdata($results[0], 'id');
				$nome = getdata($results[0], 'nome');
				$permission = getdata($results[0], 'perfil');

				$_SESSION["userid"] = $id;
				$_SESSION["login"] = $login;
				$_SESSION["username"] = $nome;
				$_SESSION["permission"] = $permission;

				jsonStatus(0, "Nome: $nome, Permissão: Nível $permission", $_SESSION);


			} else {
		
				jsonStatus(1, 'Usuário ou senha inválido');

			}

		}
	
	} else {

		jsonStatus(2, 'Configuração inválida do sistema');

	}
	
}

// Logout
function logout() {

	// remove all session variables
	session_unset(); 

	// destroy the session 
	session_destroy();

	jsonStatus(0, 'Logout OK', true);

}

?>
