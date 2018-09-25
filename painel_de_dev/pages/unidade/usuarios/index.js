
//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/unidade/usuarios/database.php';

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

	var lista = document.getElementById('lista');

	if (data && data.length > 0) {

		_data = data[0];

		var html = '';

		for (var i=0; i < _data.length; i++) {
			
			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].nome);
			html += s('\t<td>$0</td>\n', _data[i].cadastro);
			html += s('\t<td>$0</td>\n', _data[i].sexo);
			html += s('\t<td>Nível $0</td>\n', _data[i].perfil);
			html += s('\t<td>$0</td>\n', _data[i].login);
			html += s('\t<td>$0</td>\n', _data[i].ativo);
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
			inputs: ['id', 'nome', 'sexo', 'cadastro', 'perfil', 'login', 'senha', 'ativo']
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
		url: _database,
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