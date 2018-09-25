// Init Page
function init() {

	setFactor();
	requestBeaconGateway();

}

// Request Beacons & Gateways
function requestBeaconGateway() {

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'hardware'
		},
		success: listarBeaconGateway
	}

	ajaxRequest(setup);

}

// Listar Beacons & Gateways
function listarBeaconGateway(data) {

	if (data.length == 2) {

		_data = data;

		var gateways = data[0];
		var beacons = data[1];

		if (gateways.length > 0 && beacons.length > 0) {

			var gatewayInput = document.getElementById("gateway");
			var beaconInput = document.getElementById("beacon");

			var gHtml, bHtml;
				gHtml = bHtml = "<option value=''>Selecione</option>\n";

			for (var i = 0; i < gateways.length; i++) {
				gHtml +=  "<option value='" + i + "'>" + gateways[i].id + "</option>\n";
			}

			for (var i = 0; i < beacons.length; i++) {
				bHtml +=  "<option value='" + i + "'>" + beacons[i].model + " " + beacons[i].codigo + "</option>\n";
			}

			gatewayInput.innerHTML = gHtml;
			beaconInput.innerHTML = bHtml;

			gatewayInput.disabled = false;
			beaconInput.disabled = false;

			startScan();

		}

	}

}

// Start Scan
function startScan() {

	var gateway = document.getElementById("gateway");
	var beacon = document.getElementById("beacon");

	setInterval(function() {

		if (gateway.value && beacon.value) {

			requestScan(_data[0][gateway.value].id, _data[1][beacon.value].id);

		}

	}, 2000);

}

// Request Scan
function requestScan(gateway, beacon) {

	var setup = {
		url: 'pages/sistema/calibrar/database.php',
		data: {
			command: 'tracking',
			gateway: gateway,
			beacon: beacon
		},
		success: updateScan
	}

	ajaxRequest(setup);

}

// Update Scan
function updateScan(rawData) {

	if (rawData[0][0])
		var data = rawData[0][0];
	else {
		var rssi = document.getElementById('rssi');
			rssi.innerText = '--';
		var acc = document.getElementById('acc');
			acc.innerText = '--';
		return;
	}

	var datahora = document.getElementById('datahora');
		datahora.innerText = data.datahora;
	
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

	if (gateway && beacon) action = false;
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
		before: function() {
			_this.disabled = true;
		},
		after: function() {
			_this.disabled = false;
		},
		success: function() {
			_data[0][gateway.value].stabilizer = stabilizer;
		}
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
		before: function() {
			_this.disabled = true;
		},
		after: function() {
			_this.disabled = false;
		},
		success: function() {
			_data[0][gateway.value].maxrssi = rssi;
			maxrssi.innerText = rssi;
		}
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
		before: function() {
			_this.disabled = true;
		},
		after: function() {
			_this.disabled = false;
		},
		success: function() {
			_data[0][gateway.value].maxacc = acc;
			maxacc.innerText = acc;
		}
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
		before: function() {
			_this.disabled = true;
		},
		after: function() {
			_this.disabled = false;
		},
		success: function() {
			_data[1][beacon.value].power = power;
			_data[1][beacon.value].factor = factor;
		}
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