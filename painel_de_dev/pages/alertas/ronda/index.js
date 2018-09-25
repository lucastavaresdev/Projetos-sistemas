
//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/alertas/ronda/database.php';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;

function listar() {
 
	var searchBox = byid('search-box');
	var searchText = searchBox.value;

	var searchOrder = byid('order').value || 10;
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
 if (data['resultados'] && data['resultados'].length > 0) {
	 
	 _data = data['resultados'];

	 var html = '';

	 for (var i=0; i < _data.length; i++) {

		html += s("<tr id='$0'>\n", i);
		html += s('\t<td>$0</td>\n', i+1);
		html += s('\t<td>$0</td>\n', _data[i].nome);
		html += s('\t<td>$0</td>\n', _data[i].marca || '-');
		html += s('\t<td>$0</td>\n', _data[i].modelo || '-');
		html += s('\t<td>$0</td>\n', _data[i].serie || '-');
		html += s('\t<td>$0</td>\n', _data[i].patrimonio || '-');
		html += s('\t<td>$0</td>\n', _data[i].ronda_proxima.date() || '-');
		html += s('\t<td>$0</td>\n', _data[i].setor_origem || '-');
		html += s('\t<td>$0</td>\n', _data[i].setor_atual || '-');
		html += s('\t<td>$0</td>\n', _data[i].checkout.date() || '-');
		html += s('\t<td>$0</td>\n', _data[i].tempo || '-');

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
		 inputs: ['id', 'nome', 'marca', 'modelo', 'serie', 'patrimonio', 'ronda', 'situacao', 'ativo']
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
 console.log(agora);

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