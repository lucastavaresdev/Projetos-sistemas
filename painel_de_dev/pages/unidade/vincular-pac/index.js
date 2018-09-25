
//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/unidade/vincular-pac/database.php';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;

function listar() {
	
	var searchBox = byid('search-box');
	var searchText = searchBox.value;

	var searchOrder = byid('order').value || 2;
	var orientation = 'asc';
	   
	if(searchOrder < 0){
		searchOrder *= -1;
		orientation = 'desc';
	}

	var ajaxData = {
		url: _database,
		command: 'listar',
		success: gerarLista,
		search: searchText,
		order: searchOrder,
		orientation: orientation,
	}

	ajaxQuery(ajaxData);

}

//=========================================================================================
// Gerar Lista
//=========================================================================================
function gerarLista(data) {

	var lista = document.getElementById('lista');

	if (data && data.length > 0) {
		console.log(data);

		_data = data[0];

		var html = '';

		for (var i=0; i < _data.length; i++) {
			
			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].data_exame);
			html += s('\t<td>$0</td>\n', _data[i].paciente);
			html += s('\t<td>$0</td>\n', _data[i].data_nascimento);
			// Table Buttons
			html += '\t<td>\n';
			if(_data[i].beacon){
				html += s("\t\t<div class='button td' ondblclick=\"desvincular(\'$0\', \'$1\')\"><i class='fa fa-chain-broken'></i></div>\n", _data[i].agendamento, _data[i].beacon);
			}else{
				html += s("<input type='text' id=\"input$0\" style='width: 75px;' onkeydown=\"readcode(event, this, \'$1\')\">", i, _data[i].agendamento);
				//html += s("\t\t<div class='button td' onclick=\"vincular('$0')\"><i class='fa fa-chain'></i></div>\n", i);
			}
			
			html += '\t</td>\n</tr>\n';

		}

		lista.innerHTML = html;
		debug(html);

	} else {

		lista.innerHTML = '';

	}

}


//=========================================================================================
// bar code read
//=========================================================================================
function readcode(event, element, agendamento){

	var modal = document.getElementById('vinculo-modal');

	if((event.key == 'Tab' && element.value.length >= 3) || (event.key == 'Enter' && element.value.length >= 2) && agendamento){
		modal.style.display = "table";
		document.getElementById('msg').innerHTML = "Confirmar vinculo com a pulseira "+"<b>"+element.value+"</b>";
		document.getElementById('btnConfirmar').setAttribute('onclick', 'vincular(\"'+element.value+'\", \"'+agendamento+'\")');
	}
}


//=========================================================================================
// vincular
//=========================================================================================
function vincular(id, agendamento) {

	var ajaxData = {
		url: _database,
		command: 'vincular',
		tabid: '2',
		success: statusVinculo,
		agendamento: agendamento,
		beacon: id
	}

	ajaxQuery(ajaxData);

	console.log(ajaxData);

}

function statusVinculo(data){

	console.log(data);

	if(data){

		_data = data[0];

		if(data.length > 0){
			var status = document.getElementById('box-status');
			if (status){
				status.classList.remove('hide');
				status.classList.add('green');
				status.innerHTML = "Vinculo Efetuado";
			}
		}else{

			var status = document.getElementById('box-status');
			if (status){
				status.classList.remove('hide');
				status.classList.add('red');
				status.innerHTML = "Não foi possível efetuar o vinculo";
			}
		}

		setTimeout(() => {
			closeModal('vinculo-modal');
			listar();
			var status = document.getElementById('box-status');
			if (status){
				status.classList.add('hide');
				status.classList.remove('green');
				status.classList.remove('red');
			}
		}, 1000);
	}
	
}


//=========================================================================================
// desvincular
//=========================================================================================
function desvincular(agendamento, beacon){

	var ajaxData = {
		url: _database,
		command: 'pre_desvincular',		
		agendamento: agendamento,
		success: function (data){
			
			if(data.length == 0 || !data){

				var ajaxData = {
					url: _database,
					command: 'desvincular',
					tabid: '1',
					success: listar,
					agendamento: agendamento,
					beacon: beacon
				}
	
				ajaxQuery(ajaxData);

			}else{

				console.log(data);
				var modal = document.getElementById('vinculo-modal');

				if((event.key == 'Tab' && element.value.length >= 3) || (event.key == 'Enter' && element.value.length >= 2) && agendamento){
					modal.style.display = "table";
					document.getElementById('msg').innerHTML = "Paciente com exames pendentes";
					document.getElementById('btnConfirmar').style.display = "none";
				}

			}
		}		
	}

	ajaxQuery(ajaxData);
}

//=========================================================================================
// After Post
//=========================================================================================
function afterPost(command) {

	listar();

}