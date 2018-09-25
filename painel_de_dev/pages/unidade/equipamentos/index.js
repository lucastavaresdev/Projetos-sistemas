//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/unidade/equipamentos/database.php';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;

function listar() {
	
	var searchText = byid('search-box').value;

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

	if (data['equipamentos'] && data['equipamentos'].length > 0) {
		
		_data = data['equipamentos'];

		var html = '';

		for (var i=0; i < _data.length; i++) {

			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].nome);
			html += s('\t<td>$0</td>\n', _data[i].marca);
			html += s('\t<td>$0</td>\n', _data[i].modelo);
			html += s('\t<td>$0</td>\n', _data[i].serie);
			html += s('\t<td>$0</td>\n', _data[i].patrimonio);			
			html += s('\t<td>$0</td>\n', _data[i].situacao);
			html += s('\t<td>$0</td>\n', _data[i].ativo);
			// Table Buttons
			html += '\t<td>\n';
			//html += s("\t\t<div class='button td' onclick=\"controle('3','$0')\"><i class='fa fa-wrench'></i></div>\n", i);
			html += s("\t\t<div class='button td' onclick=\"editar('2','$0')\"><i class='fa fa-pencil'></i></div>\n", i);
			html += s("\t\t<div class='button td' onclick=\"deletar('$0')\"><i class='fa fa-trash'></i></div>\n", i);
			html += '\t</td>\n</tr>\n';

		}

		lista.innerHTML = html;
		debug(html);

	} else {

		lista.innerHTML = '';

	}

	if (data['setores']) createSelect('setorid', data['setores']);

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
			inputs: ['id', 'nome', 'marca', 'modelo', 'serie', 'patrimonio', 'ronda', 'calibracao', 'situacao', 'ativo', 'setorid']
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
// Controle
//=========================================================================================
function controle(tabid, i) {
	
	var agora = now('Y-M-DTh:m');

	var title = byid('controle-title');
		if (title) title.innerHTML = s('$0 - n/s: $1 n/p: $2', _data[i].nome, _data[i].serie.small(), _data[i].patrimonio.small());
	
	var form3 = byid('form3');
		if (form3) {
			form3.datahora.value = agora;
			form3.id.value = _data[i].id;
			form3.situacao.value = _data[i].situacao;
			form3.observacao.value = '';
		}
		
	var form4 = byid('form4');
		if (form4) {
			form4.datahora.value = agora;
			form4.id.value = _data[i].id;
			form4.situacao.value = _data[i].situacao;
			form4.observacao.value = '';
		}

	pageTab(tabid);

}

//=========================================================================================
// After Post
//=========================================================================================
function afterPost(command) {

	listar();

}