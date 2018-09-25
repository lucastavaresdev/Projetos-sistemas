
//=========================================================================================
// Onload
//=========================================================================================
window.onload = loop;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/sistema/track-equip/database.php';

//=========================================================================================
// Listar Ativos
//=========================================================================================
var search = listarAtivos;

function listarAtivos() {

	var searchBox = byid('search-box');
	var searchText = searchBox.value;

	var ajaxData = {
		url: _database,
		command: 'listarAtivos',
		success: gerarLista,
		search: searchText
	}

	ajaxQuery(ajaxData);

	if(search != listarAtivos){
		search = listarAtivos;
		pageTab('1');
	}	

}

//=========================================================================================
// Listar Fechados
//=========================================================================================
function listarFechados() {

	var searchBox = byid('search-box');
	var searchText = searchBox.value;
	var limite = (byid("limite")) ? (byid("limite").value) : '20';

	var ajaxData = {
		url: _database,
		command: 'listarFechados',
		success: gerarLista,
		search: searchText,
		limit: limite
	}

	ajaxQuery(ajaxData);

	if(search != listarFechados){
		search = listarFechados;
		pageTab('2');
	}	

}

//=========================================================================================
// Gerar Lista
//=========================================================================================
function gerarLista(data) {

	var lista = (search == listarAtivos) ? byid('ativos') : byid('fechados');	
	
	if (!lista) return;

	if (data && data.length > 0) {

		_data = data[0];

		var html = '';

		for (var i=0; i < _data.length; i++) {
			
			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0 <br> $1</td>\n', _data[i].gateway, _data[i].mac ? _data[i].mac.mac() : '-');
			html += s('\t<td>$0</td>\n', _data[i].setor);	
			html += s('\t<td>$0</td>\n', _data[i].rssi);		
			html += s('\t<td>$0</td>\n', _data[i].nm_paciente || '-'); 
			html += s('\t<td>$0</td>\n', _data[i].agendamento || '-'); 
			html += s('\t<td>$0 - $1</td>\n', _data[i].major, _data[i].minor);			
			html += s('\t<td>$0</td>\n', _data[i].checkin);
			html += s('\t<td>$0</td>\n', _data[i].checkout);
			html += s('\t<td>$0</td>\n', _data[i].tempo);
			
			//Logs fechados podem ser excluidos
			if(search == listarFechados){
				// Table Buttons
				html += '\t<td>\n';			
				html += s("\t\t<div class='button td' onclick=\"deletar('$0')\"><i class='fa fa-trash'></i></div>\n", i);
				html += '\t</td>\n</tr>\n';
			}else
				html += '</tr>\n';

		}

		lista.innerHTML = html;
		debug(html);

	} else {

		lista.innerHTML = '';

	}

}


//=========================================================================================
// Loop de Ativos
//=========================================================================================
function loop(){
	
	//Primeira execução
	listarAtivos();

	//Demais execuções, quando na tela de ativos
	setInterval(function(){

		if(search == listarAtivos){
			listarAtivos();
		}

	}, 2000);

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
			inputs: ['id', 'tipo', 'id_equipamento', 'id_usuario', 'major', 'minor', 'mac', 'ativo']
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

	search();

}

//=========================================================================================
// Select Change
//=========================================================================================
function clearSelect(id) {
	
	if (typeof id == 'string') {

		var select = byid(id);

		if (select) select.value = '';
	
	}

}