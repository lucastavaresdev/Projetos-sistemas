//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/controles/calibracoes/database.php';
_upload		= 'pages/controles/calibracoes/uploads/';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;

function listar() {


	var searchText = byid('search-box').value;
	var startDate = byid('start-date').value;
	var endDate = byid('end-date').value;
	var searchOrder = byid('order').value || 10;
	var orientation = 'asc';
   
	if(searchOrder < 0){
		searchOrder *= -1;
		orientation = 'desc';
	}

	var ajaxData = {
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

	if (data['calibracoes'] && data['calibracoes'].length > 0) {

		_data = data['calibracoes'];

		var html = '';

		for (var i=0; i < _data.length; i++) {

			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].nome);
			html += s('\t<td>$0 <br> $1</td>\n', _data[i].marca, _data[i].modelo);
			html += s('\t<td>$0 <br> $1</td>\n', _data[i].serie, _data[i].patrimonio);			
			html += s('\t<td>$0</td>\n', (_data[i].calibracao_proxima) ? _data[i].calibracao_proxima.date() : '-');
			html += s('\t<td>$0</td>\n', _data[i].situacao);
			html += s('\t<td>$0 <br>$1 <br> $2</td>\n', _data[i].setor_origem || '-', _data[i].predio_origem || '-', _data[i].andar_origem ? _data[i].andar_origem.andar() : '-');
			html += s('\t<td>$0 <br>$1 <br> $2</td>\n', _data[i].setor_destino || '-', _data[i].predio_destino || '-', _data[i].andar_destino ? _data[i].andar_destino.andar() : '-');
			html += s('\t<td>$0 <br>$1</td>\n', _data[i].tempo || '-', _data[i].checkout.date() || '-');
			// Table Buttons
			html += '\t<td>\n';
			html += s("\t\t<div class='button td' onclick=\"controle('3','$0')\"><i class='fa fa-wrench'></i></div>\n", i);
			html += s("\t\t<button class='button td' onclick=\"editar('2','$0')\" $1><i class='fa fa-pencil'></i></button>\n", i, (!_data[i].calibracao_proxima ? 'disabled' : ''));
			html += s("\t\t<button class='button td' onclick=\"deletar('$0')\" $1><i class='fa fa-trash'></i></button>\n", i, (!_data[i].calibracao_proxima ? 'disabled' : ''));
			html += '\t</td>\n</tr>\n';

		}

		lista.innerHTML = html;
		debug(html);

	} else {
		lista.innerHTML = '';
	}

	if (data['equipamentos']) createSelect('id_equipamento', data['equipamentos']);
	if (data['usuarios']) createSelect('id_usuario', data['usuarios']);

}

//=========================================================================================
// Relatorio
//=========================================================================================
function relatorio(){

	var searchText = byid('search-box').value;
	var startDate = byid('start-date').value;
	var endDate = byid('end-date').value;
	var searchOrder = byid('order').value || -4;
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
		tabid: '4'
	}

	ajaxQuery(ajaxData);

	if(search != relatorio){
		search = relatorio;
		pageTab(4);
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

			html += s("<tr id='$0'>\n", i);
			html += s('\t<td>$0</td>\n', i+1);
			html += s('\t<td>$0</td>\n', _data[i].calibracao_ultima);
			html += s('\t<td>$0</td>\n', _data[i].equipamento);
			html += s('\t<td>$0</td>\n', _data[i].marca);
			html += s('\t<td>$0</td>\n', _data[i].modelo);
			html += s('\t<td>$0</td>\n', _data[i].serie);
			html += s('\t<td>$0</td>\n', _data[i].patrimonio);
			html += s('\t<td>$0</td>\n', _data[i].situacao || '-');			
			html += s('\t<td>$0</td>\n', _data[i].responsavel || '-');
			html += s('\t<td>$0</td>\n', _data[i].observacao || '-');

			//Contador de anexos
			var cont = 0;
			cont += (_data[i].anexo1) ? 1 : 0;
			cont += (_data[i].anexo2) ? 1 : 0;
			cont += (_data[i].anexo3) ? 1 : 0;
			if(cont > 0)
				anexos = "<span class='uploads'>"+cont+"</span>";
			else 
				anexos = '';
			
			// Table Buttons
			html += '\t<td>\n';			
			html += s("\t\t<div class='button td' onclick=\"windowUpload('5','$0')\"><i class='fa fa-paperclip'></i> $1 </div>\n", i, anexos);
			html += s("\t\t<div class='button td' onclick=\"editar('2','$0')\"><i class='fa fa-pencil'></i></div>\n", i);
			html += s("\t\t<div class='button td' onclick=\"deletar('$0')\"><i class='fa fa-trash'></i></div>\n", i);
			html += '\t</td>\n</tr>\n';

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
			inputs: ['id', 'id_usuario', 'id_equipamento', 'calibracao_ultima', 'situacao', 'observacao']
		}

		console.log(_data[i]);

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
// Controle
//=========================================================================================
function controle(tabid, i) {
	
	var agora = now('Y-M-DTh:m');

	var title = byid('controle-title');
		if (title) title.innerHTML = s('$0 - n/s: $1 n/p: $2', _data[i].nome, _data[i].serie.small(), _data[i].patrimonio.small());
			
	var form4 = byid('form4');
		if (form4) {
			form4.datahora.value = agora;
			form4.id.value = _data[i].id_equipamento;
			form4.situacao.value = _data[i].situacao;
			form4.observacao.value = '';
		}

	pageTab(tabid);

}

//=========================================================================================
// After Post
//=========================================================================================
function afterPost(command) {

	search();

}