//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/sistema/gateways/database.php';

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

	if (data['gateways'] && data['gateways'].length > 0) {

		_data = data['gateways'];

		var html = '';

		for (var i=0; i < _data.length; i++) {

			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].gateway);
			html += s('\t<td>$0</td>\n', _data[i].setor || '-');
			html += s('\t<td>$0</td>\n', _data[i].maxrssi || '-');			
			html += s('\t<td>In: $0 <br> Out: $1</td>\n', _data[i].timein || '-', _data[i].timeout || '-');
			html += s('\t<td>$0</td>\n', _data[i].datahora || '-');
			html += s('\t<td>$0 <br> $1</td>\n', _data[i].maxdelay || '-', _data[i].maxdelay_datahora || '-');
			html += s('\t<td>$0</td>\n', _data[i].status);

			// Table Buttons
			html += '\t<td>\n';
			html += s("\t\t<div class='button td' onclick=\"editar('2','$0')\"><i class='fa fa-pencil'></i></div>\n", i);
			html += s("\t\t<div class='button td' onclick=\"deletar('$0')\"><i class='fa fa-trash'></i></div>\n", i);
			html += '\t</td>\n</tr>\n';

		}

		lista.innerHTML = html;
		debug(html);

	} else {

		lista.innerHTML = '';

	}

	if (data['setores']) createSelect('id_sala', data['setores']);

}

//=========================================================================================
// Adicionar
//=========================================================================================
function adicionar(tabid) {

	if (tabid) {
		
		var options = {
			tabid: tabid,
			command: 'salvar',
			reset: true
		}

		setupForm(options);

		pageTab(tabid);

	}

}

//=========================================================================================
// Editar
//=========================================================================================
function editar(tabid, i) {

	if (tabid && i) {

		var options = {
			tabid: tabid,
			data: _data[i],
			command: 'atualizar',
			inputs: ['id', 'id_sala', 'gateway', 'maxrssi', 'timein', 'timeout', 'status']
		}

		setupForm(options);

		pageTab(tabid);

	}

}

//=========================================================================================
// Deletar
//=========================================================================================
function deletar(i) {

	var ajaxData = {
		command: 'deletar',
		id: _data[i].id,
		remove: i
	}

	ajaxQuery(ajaxData);

}

//=========================================================================================
// After Post
//=========================================================================================
function afterPost(command) {

	listar();

}