// Init Page
function init() {

	//setFactor();
	requestBeacons();

}

// Request Beacons
function requestBeacons() {

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'beacons'
		},
		success: listarBeacons
	}

	ajaxRequest(setup);

}

// Listar Beacons
function listarBeacons(data) {

	if (data && data.length == 1 && data[0].length > 0) {

		_data = data[0];

		var beaconInput = document.getElementById("beacon");
		var html = "<option value=''>Selecione</option>\n";

		for (var i = 0; i < data[0].length; i++) {
				html +=  "<option <option value='" + i + "'>" + data[0][i].model + " " + data[0][i].codigo + "</option>\n";
		}

		beaconInput.innerHTML = html;

		startScan();

	}

}

// Start Scan
function startScan() {

	var beacon = document.getElementById("beacon");

	setInterval(function() {

		if (beacon.value) {

			requestScan(_data[beacon.value].id);

		}

	}, 2000);

}

// Request Scan
function requestScan(beacon) {

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'trackingBeacon',
			beacon: beacon
		},
		success: updateScan
	}

	ajaxRequest(setup);

}

// Update Scan
function updateScan(data) {

	var lista = document.getElementById('beacon-list');

	if (data && data[0].length > 0) {

		var html = "";

		for (var i=0; i < data[0].length; i++ ) {

			var acc = parseFloat(data[0][i].acc);
			var maxacc = parseFloat(data[0][i].maxacc);
			var accClass = (acc > maxacc) ? 'beacon-metric-red' : 'beacon-metric-green';

			var rssi = parseFloat(data[0][i].rssi);
			var maxrssi = parseFloat(data[0][i].maxrssi);
			var rssiClass = (rssi < maxrssi) ? 'beacon-metric-red' : 'beacon-metric-green';

			html += "<div class='beacon-list'>";
			html += "<div class='beacon-info'>";
			html += "<div class='beacon-info-line'>";
			html += "Gateway " + data[0][i].gateway;
			html += "</div>";
			html += "<div class='beacon-info-line'>";
			html += "Setor: -- Sala: --";
			html += "</div>";
			html += "<div class='beacon-info-data'>";
			html += data[0][i].datahora;
			html += "</div>";
			html += "</div>";
			html += "<div class='beacon-metric " + accClass + "'>";
			html += "<div class='beacon-metric-small'>";
			html += maxacc.toFixed(2);
			html += "</div>";
			html += "<div class='beacon-metric-label'>";
			html += "ACC";
			html += "</div>";
			html += "<div class='beacon-metric-big'>";
			html += acc.toFixed(2);
			html += "</div>";
			html += "</div>";
			html += "<div class='beacon-metric " + rssiClass + " round-right'>";
			html += "<div class='beacon-metric-small'>";
			html += data[0][i].maxrssi;
			html += "</div>";
			html += "<div class='beacon-metric-label'>";
			html += "RSSI";
			html += "</div>";
			html += "<div class='beacon-metric-big'>";
			html += data[0][i].rssi;
			html += "</div>";
			html += "</div>";
			html += "</div>";

		}

		lista.innerHTML = html;

	} else {

		lista.innerHTML = "";

	}

	return;

	if (rawData[0][0])
		var data = rawData[0][0];
	else {
		var rssi = document.getElementById('rssi');
			rssi.innerText = '--';
		var acc = document.getElementById('acc');
			acc.innerText = '--';
		return;
	}

	var acc = document.getElementById('acc');
	var accValue = parseFloat(data.acc);
		acc.innerText = accValue.toFixed(2);

	var accDisplay = document.getElementById('acc-display');
	var maxaccValue = parseFloat(document.getElementById('maxacc').innerText);

	if (accValue > maxaccValue) {

		accDisplay.classList.add("red");
		accDisplay.classList.remove("green");

	} else {

		accDisplay.classList.add("green");
		accDisplay.classList.remove("red");

	}

	var rssi = document.getElementById('rssi');
	var rssiValue = parseInt(data.rssi);
		rssi.innerText = rssiValue;

	var rssiDisplay = document.getElementById('rssi-display');
	var maxrssiValue = parseInt(document.getElementById('maxrssi').innerText);

	if (rssiValue < maxrssiValue) {

		rssiDisplay.classList.add("red");
		rssiDisplay.classList.remove("green");

	} else {

		rssiDisplay.classList.add("green");
		rssiDisplay.classList.remove("red");

	}
		
	var pointer = document.getElementById('pointer');
		pointer.style.width = (data.rssi * -1) + "%";


	var maxrssi = document.getElementById('maxrssi');

}

function setGateway(i) {

	if (i) {

		var maxrssi = document.getElementById('maxrssi');
			maxrssi.innerText = _data[0][i].maxrssi;

		
			maxacc.innerText = parseFloat(_data[0][i].maxacc).toFixed(2);

		var stabilizer = document.getElementById('stabilizer');
			stabilizer.value = _data[0][i].stabilizer;

	}

	setUI();

}

function setBeacon(i) {

	if (i) {

		var power = document.getElementById('power');
			power.value = _data[1][i].power;
			
		var meter = document.getElementById('meter');
			meter.style.width = (_data[1][i].power * -1) + "%";

		var factor = document.getElementById('factor');	
			factor.value = _data[1][i].factor;

			setFactor();

	}

	setUI();


}

function setUI() {

	var salvarRssi = document.getElementById('salvar-rssi');
	var salvarAcc = document.getElementById('salvar-acc');
	var stabilizer = document.getElementById('stabilizer');
	var power = document.getElementById('power');
	var factor = document.getElementById('factor');
	var salvarBeacon = document.getElementById('salvar-beacon');

	var gateway = document.getElementById('gateway').value;
	var beacon = document.getElementById('beacon').value;
	var action;

	if (gateway && beacon) 	action = false;
	else action = true;

	salvarRssi.disabled =
	salvarAcc.disabled =
	stabilizer.disabled =
	power.disabled =
	factor.disabled =
	salvarBeacon.disabled = action;

}

function setFactor() {

	var metric;
	var mark;
	var rssi;
	var factor = parseInt(document.getElementById('factor').value);
	var power = parseInt(document.getElementById('power').value);

	for (rssi=-10; rssi >= -90; rssi -= 10) {

		metric = parseFloat(Math.pow(10, ((power - rssi) / (10 * factor)))).toFixed(2);
		mark = document.getElementById(rssi);
		mark.innerText = metric;

	}

}

function setPower() {

	var rssi = parseInt(document.getElementById('rssi').innerText);
	if (isNaN(rssi)) return;

	var power = document.getElementById('power');
		power.value = rssi;

	var meter = document.getElementById('meter');
		meter.style.width = (rssi * -1) + "%";

	setFactor();

}

function salvarEstabilizador(_this) {

	if (!_this) return;

	var gateway = document.getElementById("gateway");
	if (!gateway) return;

	var id = _data[0][gateway.value].id;
	if (!id) return;

	var stabilizer = document.getElementById('stabilizer').value;
	if (!stabilizer || isNaN(stabilizer)) return;

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'salvarEstabilizador',
			stabilizer: stabilizer,
			id: id
		},
		before: function() { _this.disabled = true },
		after: function() { _this.disabled = false },
		success: function() { _data[0][gateway.value].stabilizer = stabilizer; }
	}

	ajaxRequest(setup);

}

function salvarRssi(_this) {

	if (!_this) return;

	var gateway = document.getElementById("gateway");
	if (!gateway) return;

	var id = _data[0][gateway.value].id;
	if (!id) return;

	var rssi = document.getElementById('rssi').innerText;
	if (!rssi || isNaN(rssi)) return;

	var maxrssi = document.getElementById("maxrssi");

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'salvarRssi',
			maxrssi: rssi,
			id: id
		},
		before: function() { _this.disabled = true; },
		after: function() { _this.disabled = false; },
		success: function() { _data[0][gateway.value].maxrssi = rssi; maxrssi.innerText = rssi; }
	}

	ajaxRequest(setup);

}

function salvarAcc(_this) {

	if (!_this) return;

	var gateway = document.getElementById("gateway");
	if (!gateway) return;

	var id = _data[0][gateway.value].id;
	if (!id) return;

	var acc = document.getElementById('acc').innerText;
	if (!acc || isNaN(acc)) return;

	var maxracc = document.getElementById("maxacc");

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'salvarAcc',
			maxacc: acc,
			id: id
		},
		before: function() { _this.disabled = true },
		after: function() { _this.disabled = false },
		success: function() { _data[0][gateway.value].maxacc = acc; maxacc.innerText = acc }
	}

	ajaxRequest(setup);

}

function salvarBeacon(_this) {

	if (!_this) return;

	var beacon = document.getElementById("beacon");
	if (!beacon) return;

	var id = _data[1][beacon.value].id;
	if (!id) return;

	var power = document.getElementById('power').value;
	if (!power || isNaN(power) ) return;

	var factor = document.getElementById('factor').value;
	if (!factor || isNaN(factor)) return;

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'salvarBeacon',
			power: power,
			factor: factor,
			id: id
		},
		before: function() { _this.disabled = true },
		after: function() { _this.disabled = false },
		success: function() { _data[1][beacon.value].power = power; _data[1][beacon.value].factor = factor; }
	}

	ajaxRequest(setup);

}

// ==========================================================================
// Ajax Core
// ==========================================================================

function ajaxRequest(setup) {

	if (!setup || typeof setup != 'object' || !setup.url || !setup.data) return;

	var before = setup.before || ajaxBefore;
	var after = setup.after || ajaxAfter;
	var successs = setup.success || ajaxSuccess;
	var warning = setup.warning || ajaxWarning;
	var error = setup.error || ajaxError;

	$.ajax({

		url: setup.url,
		method: 'POST',
		cache: false,
		dataType: 'json',
		data: setup.data,
		beforeSend: function() {
			before();
		},
		error: function(data) {
			error(data);
		},
		success: function(data) {
			after();

			switch(data.status) {
				case 0:
					successs(data.results, setup.data);
					break;
				case 1:
					warning(data.msg);
					break;
					case 2:
					error(data.msg);
					break;
				default:
					error(data);
			}

		}

	});

}

function ajaxBefore() {

}

function ajaxAfter() {

}

function ajaxSuccess(results, data) {

	console.log(data);
	console.log(results);

}

function ajaxWarning(data) {

	console.warn(data);

}

function ajaxError(data) {

	if (data.responseText) console.error(data.responseText);
	else console.error(data);

}