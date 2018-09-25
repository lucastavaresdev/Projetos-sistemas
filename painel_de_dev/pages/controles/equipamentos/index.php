<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">

		<title>iTechMed - Unidade/Equipamentos</title>

		<!-- CSS Files -->
		<link type="text/css" rel='stylesheet' href='css/font-awesome.css'>
		<link type="text/css" rel='stylesheet' href='css/triskelion.css'>
		<link type="text/css" rel='stylesheet' href='css/itechmed.css'>
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
		<?php require 'main/search_date.php' ?>
		<!-- Search Header -->

	</div>
	<!-- Page Header -->

	<!-- Page Content -->
	<div class="page-content" id="page-content">
	
		<!-- Page Tab -->
		<div class="page-tab" id="tab1">
		
			<!-- Listar -->
			<?php require 'pages/controles/equipamentos/listar.php' ?>
			<!-- Listar -->

		</div>
		<!-- Page Tab -->
				
		<!-- Page Tab -->
		<div class="page-tab hide" id="tab3">

			<!-- Adicionar -->
			<?php require 'pages/controles/equipamentos/controle.php' ?>
			<!-- Adicionar -->

		</div>
		<!-- Page Tab -->

	</div>

	<!-- Page Footer -->
	<div class="page-footer" id="page-footer">iTechMed 2017</div>
	
		<!-- JS Files -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/triskelion.js"></script>
		<script type="text/javascript" src="pages/controles/equipamentos/index.js"></script>
		<!-- JS Files -->

	</body>

</html>