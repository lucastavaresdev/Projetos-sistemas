<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="utf-8">
		<meta name="mobile-web-app-capable" content="yes">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
		<meta name="theme-color" id="theme-color" content="#252525" />

		<title>ITechFlow - Rastrear</title>

		<!-- CSS Files -->
		<link rel='stylesheet' type="text/css" href='css/itechflow.css'>
		<link rel='stylesheet' type="text/css" href='pages/sistema/calibrar/calibrar.css'>
		<!-- CSS Files -->

	</head>

	<body>

		<div class="container">

			<div class="label">Beacon</div>
			<select class="input" id="beacon"/>
				<option value="">Nenhum Beacon encontrado</option>
			</select>
			
			<div id="beacon-list"></div>

			<input class="button" type="button" value="Voltar" onclick="link('sistema','menu')" />

			<!-- <hr class="hr" />-->

		</div>

		<!-- JS Files -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/itechflow.js"></script>
		<script type="text/javascript" src="pages/sistema/calibrar/rastrear.js"></script>
		<!-- JS Files -->

	</body>

</html>
