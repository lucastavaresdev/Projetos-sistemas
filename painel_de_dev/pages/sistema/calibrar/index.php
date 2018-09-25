<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="utf-8">
		<meta name="mobile-web-app-capable" content="yes">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
		<meta name="theme-color" id="theme-color" content="#252525" />

		<title>ITechFlow - Calibrar</title>

		<!-- CSS Files -->
		<link rel='stylesheet' type="text/css" href='css/itechflow.css'>
		<link rel='stylesheet' type="text/css" href='pages/sistema/calibrar/calibrar.css'>
		<!-- CSS Files -->

	</head>

	<body>

		<div class="container">

			<div class="label">Gateway</div>
			<select class="input" id="gateway" onchange="setGateway(this.value)"/>
				<option value="">Nenhum Gateway encontrado</option>
			</select>

			<div class="label">Beacon</div>
			<select class="input" id="beacon" onchange="setBeacon(this.value)"/>
				<option value="">Nenhum Gateway encontrado</option>
			</select>

			<div class="label" id="datahora">00/00/0000 00:00:00</div>
			<div class="display" onclick="link('calibrar','sistema','rastrear')">
				<div class="row">
					<div class="col center round-left green" id="acc-display">
						<div class="display-font20" id="maxacc">--</div>
						<div class="display-font10">MAX</div>
						<div class="display-font40" id="acc">--</div>
					</div>
					<div class="col center round-right green" id="rssi-display">
						<div class="display-font20" id="maxrssi">--</div>
						<div class="display-font10">MAX</div>
						<div class="display-font40" id="rssi">--</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col col-padding-right">
					<input class="button" type="button" id="salvar-acc" value="Max ACC" onclick="salvarAcc(this)" disabled />
				</div>
				<div class="col col-padding-left">
					<input class="button" type="button" id="salvar-rssi" value="Max RSSI" onclick="salvarRssi(this)" disabled />
				</div>
			</div>

			<div class="label">Estabilizador</div>
			<select class="input" id="stabilizer" onchange="salvarEstabilizador(this)" disabled />
				<option value="0">DESLIGADO</option>
				<option value="1">MÉDIO</option>
				<option value="2">ALTO</option>
			</select>

			<!-- <hr class="hr" />-->

			<div class="row">
				<div class="col col-padding-right">
					<div class="label">Calibração</div>
					<input class="button" type="button" id="salvar-beacon" value="Salvar" onclick="salvarBeacon(this)" disabled />
				</div>
				<div class="col col-padding-left">
					<div class="label">1 Meter RSSI</div>
					<input class="button" type="button" id="power" value="-56" onclick="setPower();" disabled />
				</div>
			</div>

			<div class="metric-display">
				<div class="metric-meter" id="meter"></div>
				<div class="metric-mark" id="pointer"></div>
				<div class="table metric-numbers" id="metric-numbers">
					<div class="tr">
						<div class="td">-10</div>
						<div class="td">-20</div>
						<div class="td">-30</div>
						<div class="td">-40</div>
						<div class="td">-50</div>
						<div class="td">-60</div>
						<div class="td">-70</div>
						<div class="td">-80</div>
						<div class="td">-90</div>
					</div>
					<div class="tr">
						<div class="td" id="-10">0.00</div>
						<div class="td" id="-20">0.00</div>
						<div class="td" id="-30">0.00</div>
						<div class="td" id="-40">0.00</div>
						<div class="td" id="-50">0.00</div>
						<div class="td" id="-60">0.00</div>
						<div class="td" id="-70">0.00</div>
						<div class="td" id="-80">0.00</div>
						<div class="td" id="-90">0.00</div>
					</div>
				</div>
			</div>

			<input class="input" type="range" min="2" max="10" id="factor" value="4" onchange="setFactor(this.value)" oninput="setFactor(this.value)" disabled />

		</div>

		<!-- JS Files -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/itechflow.js"></script>
		<script type="text/javascript" src="pages/sistema/calibrar/index.js"></script>
		<!-- JS Files -->

	</body>

</html>
