<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">

		<title>iTechMed - Unidade/Usuários</title>

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
		<?php require 'main/search.php' ?>
		<!-- Search Header -->

	</div>
	<!-- Page Header -->

	<!-- Page Content -->
	<div class="page-content" id="page-content">
	
		<!-- Page Tab -->
		<div class="page-tab" id="tab1">
		
			<!-- Listar -->
			<?php require 'pages/unidade/vincular-pac/listar.php' ?>
			<!-- Listar -->

		</div>
		<!-- Page Tab -->
	</div>

<table class="modal" id="vinculo-modal" style="display: none;">
	<tbody>
		<tr>
		<td>
		<!-- Box -->
		<div class="modal-container md">
			<div class="box">

				<!-- Box Header -->
				<div id="box-header2" class="box-header login">
					<i class="fa fa-chain"></i>
					<label>Vinculo</label>
				</div>

				<!-- Box Content -->
				<div class="box-content">				
					<label id="msg"></label>					
				</div>

				<!-- Box Footer -->
				<div class="box-footer login">
					<label id="box-status" class="box-status sm hide">Status</label>
					<div class="button sm" onclick="closeModal('vinculo-modal')">
						<i class="fa fa-times"></i>
						<label>Cancelar</label>
					</div>
					<div class="button sm" id="btnConfirmar">
						<i class="fa fa-link"></i>
						<label>Confirmar</label>
					</div>
				</div>
			</div>
		</div>
		</td>
		</tr>
	</tbody>
</table>
	

	<!-- Page Footer -->
	<div class="page-footer" id="page-footer">iTechMed 2017</div>
	
	<!-- JS Files -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/triskelion.js"></script>
	<script type="text/javascript" src="pages/unidade/vincular-pac/index.js"></script>
	<!-- JS Files -->

	</body>

</html>