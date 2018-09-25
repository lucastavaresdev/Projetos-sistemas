//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/controles/temperatura/database.php';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;

function listar() {
	
	var searchText = byid('search-box').value;
	var startDate = byid('start-date').value;
	var endDate = byid('end-date').value;
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
		startDate: startDate,
		endDate: endDate,
		order: searchOrder,
		orientation: orientation,
	}

	ajaxQuery(ajaxData);

	if(search != listar){
		search = listar;
		pageTab(1);		
	}else
		search = listar;

}

//=========================================================================================
// Gerar Lista
//=========================================================================================
function gerarLista(data) {

	var lista = byid('lista');

	if (data['temperatura'] && data['temperatura'].length > 0) {
		
		_data = data['temperatura']; 

		var html = '';

		for (var i=0; i < _data.length; i++) {

			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].mac ? _data[i].mac.mac() : '-');
			html += s('\t<td>$0</td>\n', _data[i].nome);
			html += s('\t<td>$0</td>\n', _data[i].marca);
			html += s('\t<td>$0</td>\n', _data[i].modelo);
			html += s('\t<td>$0</td>\n', _data[i].serie);
			html += s('\t<td>$0</td>\n', _data[i].patrimonio);
			html += s('\t<td>$0</td>\n', _data[i].setor_atual);
			html += s('\t<td>$0 º</td>\n', _data[i].temperatura);
			html += s('\t<td>$0 %</td>\n', _data[i].umidade);
			html += s('\t<td>$0 %</td>\n', _data[i].bateria);

		}

		lista.innerHTML = html;
		debug(html);

	} else {

		lista.innerHTML = '';

	}

	if (data['setores']) createSelect('setorid', data['setores']);

}


//=========================================================================================
// Relatorio
//=========================================================================================
function relatorio(){
	
	var searchText = byid('search-box').value;
	var startDate = byid('start-date').value;
	var endDate = byid('end-date').value;
	var searchOrder = byid('order').value || -12;
	var orientation = 'asc';
	
	if(searchOrder < 0){
		searchOrder *= -1;
		orientation = 'desc';
	}

	var ajaxData = {
		command: 'relatorio',
		success: gerarRelatorio,
		search: searchText,
		startDate: startDate,
		endDate: endDate,
		order: searchOrder,
		orientation: orientation,
		tabid: '2'
	}

	ajaxQuery(ajaxData);

	if(search != relatorio){
		search = relatorio;
		pageTab(2);
	}else
		search = relatorio;
	
}

//=========================================================================================
// Gerar Lista
//=========================================================================================
function gerarRelatorio(data) {
	
	var relatorio = byid('relatorio');

	if (data['relatorio'] && data['relatorio'].length > 0) {

		_data = data['relatorio'];

		var html = '';

		for (var i=0; i < _data.length; i++) {

			var temp = ((_data[i].temperatura > _data[i].temp_max || _data[i].temperatura < _data[i].temp_min)? 'danger': '');
			console.log(temp);
			var umid = ((_data[i].umidade > _data[i].umid_max || _data[i].umidade < _data[i].umid_min)? 'danger': '');
			console.log(umid);

			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].mac ? _data[i].mac.mac(): '-');
			html += s('\t<td>$0</td>\n', _data[i].nome);
			html += s('\t<td>$0</td>\n', _data[i].marca);
			html += s('\t<td>$0</td>\n', _data[i].modelo);
			html += s('\t<td>$0</td>\n', _data[i].serie);
			html += s('\t<td>$0</td>\n', _data[i].patrimonio);
			html += s('\t<td class="'+ temp +'">$0 º</td>\n', _data[i].temperatura);
			html += s('\t<td class="'+ umid +'">$0 %</td>\n', _data[i].umidade);
			html += s('\t<td>$0</td>\n', _data[i].log ? _data[i].log.date() : '-');

		}

		relatorio.innerHTML = html;
		debug(html);

	} else {

		relatorio.innerHTML = '';

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