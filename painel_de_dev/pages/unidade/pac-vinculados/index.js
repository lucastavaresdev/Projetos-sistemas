
//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/unidade/pac-vinculados/database.php';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;

function listar() {
	
	var searchBox = byid('search-box');
	var searchText = searchBox.value;

	var searchOrder = byid('order').value || 3;
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

	var lista = byid('lista');

	if (data['beacons'] && data['beacons'].length > 0) {

		_data = data['beacons'];

		var html = '';

		for (var i=0; i < _data.length; i++) {
			
			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].id);
			html += s('\t<td>$0</td>\n', _data[i].minor || '');
			html += s('\t<td>$0</td>\n', _data[i].id_vinculado || '');
			html += s('\t<td>$0</td>\n', _data[i].nome_paciente || '');
			html += s('\t<td>$0</td>\n', _data[i].dt_agendamento || '');
			// Table Buttons
			html += '\t<td>\n';
			html += s("\t\t<div class='button td' ondblclick=\"desvincular('$0', '$1')\"><i class='fa fa-chain-broken'></i></div>\n", _data[i].id_vinculado, _data[i].id);
			html += '\t</td>\n</tr>\n';

		}

		lista.innerHTML = html;
		debug(html);

	} else {

		lista.innerHTML = '';

	}

}

//=========================================================================================
// desvincular
//=========================================================================================
function desvincular(agendamento, beacon){

	var ajaxData = {
		url: _database,
		command: 'desvincular',
		tabid: '1',
		success: listar,
		agendamento: agendamento,
		beacon: beacon
	}

	ajaxQuery(ajaxData);
}

//=========================================================================================
// After Post
//=========================================================================================
function afterPost(command) {

	listar();

}

