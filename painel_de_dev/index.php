<?php

if (!isset($_SESSION)) session_start();

if (!isset($_SESSION["login"]) || !isset($_SESSION["username"]) || !isset($_SESSION["permission"])) {

	if ( $_SERVER["REQUEST_METHOD"] == "GET") {
		
		// $group = (isset($_GET["g"])) ? $_GET["g"] : null;
		// $session = isset($_GET["s"]) ? $_GET["s"] : null;
		// $page = isset($_GET["p"]) ?  $_GET["p"] : null;

		require "pages/sistema/login/index.php";
		exit;

	}

} else {

	if ( $_SERVER["REQUEST_METHOD"] == "GET") {

		if (isset($_GET["g"]) && isset($_GET["s"]) && isset($_GET["p"])) {

			$group = $_GET["g"];
			$session = $_GET["s"];
			$page = $_GET["p"];

			require "pages/$group/$session/$page.php";

		} else if (isset($_GET["g"]) && isset($_GET["s"])) {

			$group = $_GET["g"];
			$session = $_GET["s"];
			$page = "index";

			require "pages/$group/$session/$page.php";

		} else {

			require "pages/controles/temperatura/index.php";

		}

	}

}

?>