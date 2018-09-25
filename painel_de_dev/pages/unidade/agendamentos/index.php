<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="iso-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">

		<title>iTechMed - Unidade/Agendamentos</title>

		<!-- CSS Files -->
		<link type="text/css" rel='stylesheet' href='css/font-awesome.css'>
		<link type="text/css" rel='stylesheet' href='css/triskelion.css'>
		<link type="text/css" rel='stylesheet' href='css/itechmed.css'>
                <style>
                    table {
                        font-family: arial, sans-serif;
                        border-collapse: collapse;
                        width: 100%;
                    }

                    td, th {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                    }

                    tr:nth-child(even) {
                        background-color: #d9edf7;
                    }
                </style>
		<!-- CSS Files -->
	</head>

	<body>

	<!-- Menu -->
	<?php require 'main/menu.php'; ?>	
	<!-- Menu -->

	<!-- Modal Login -->
	<?php require 'main/login.php' ?>
	<!-- Modal Login -->

	<!-- Page Header -->
	<div class="page-header" id='page-header'>
	
		<!-- System Header -->
		<?php require 'main/header.php' ?>
		<!-- System Header -->
		
		<!-- Search Header -->
		<?php require 'main/search.php' ?>
		<!-- Search Header -->

	</div>
	<!-- Page Header -->

	<!-- Page Content -->
	<div class="page-content" id="page-content">
	
		<!-- Page Tab -->
		<div class="page-tab" id="tab1">
		
			<!-- Listar -->
			<?php require 'pages/unidade/agendamentos/listar.php' ?>
			<!-- Listar -->

		</div>
		<!-- Page Tab -->

	</div>

	<!-- Page Footer -->
	<div class="page-footer" id="page-footer">iTechMed 2017</div>
	
		<!-- JS Files -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/triskelion.js"></script>
		<script type="text/javascript" src="pages/unidade/agendamentos/index.js"></script>
		<!-- JS Files -->

	</body>

</html>