/* ================================================================================= */
/*
/* Triskelion: JS 24/10/2017
/*
/* ================================================================================= */

//=========================================================================================
// Global Variables
//=========================================================================================
MOBILE = false;
ajaxState = 0;
colFilter = '';
order = '';

//=========================================================================================
// Debug Mode
//=========================================================================================
//localStorage['debug'] = 'ON';// Dev Mode ON

function debugToggle() {

	if (localStorage['debug'] == 'OFF') {

		localStorage['debug'] = 'ON';
		console.log('DEBUG ON');

	} else {

		localStorage['debug'] = 'OFF';
		console.log('DEBUG OFF');

	}

	debug = debugMode();

}

function debugMode() {

	var btn = document.getElementById('debug');

	if (localStorage['debug'] == 'ON') {

		if (btn) btn.classList.add('active');
		return console.log.bind(window.console);

	} else {

		if (btn) btn.classList.remove('active');
		return function(){};

	}

}

debug = debugMode();

//=========================================================================================
// Mobile
//=========================================================================================
function ismobile() {

	if (navigator.userAgent) {

		var mobiles = ["Android", "iPhone", "iPad", "iPod", "Windows Phone"];

		for (var i=0; i < mobiles.length; i++) {

			if (navigator.userAgent.match(mobiles[i])) {

				return mobiles[i];

			}

		}

	}

	return false;

}

//=========================================================================================
// Remove Method for IE
//=========================================================================================
if (!('remove' in Element.prototype)) {

    Element.prototype.remove = function() {

        if (this.parentNode) this.parentNode.removeChild(this);

    }

}

//=========================================================================================
// addClass
//=========================================================================================
HTMLElement.prototype.addClass = function(className) {

	this.classList.add(className);

}

//=========================================================================================
// removeClass
//=========================================================================================
HTMLElement.prototype.removeClass = function(className) {

	this.classList.remove(className);

}

//=========================================================================================
// toggleClass
//=========================================================================================
HTMLElement.prototype.toggleClass = function(className) {

	this.classList.toggle(className);

}

//=========================================================================================
// toggleClass
//=========================================================================================
HTMLElement.prototype.hasClass = function(className) {

	return this.classList.contains(className);

}

//=========================================================================================
// Append First
//=========================================================================================
HTMLElement.prototype.appendFirst = function (obj, i) {

	var index = i || 0;

	if (obj.tagName) {
		this.insertBefore(obj, this.childNodes[0] || null);
	}

}

//=========================================================================================
// Get Element By Id
//=========================================================================================
function byid(id) {

	if (typeof id == 'string') {

		var element = document.getElementById(id);

		if (element) {

			return element;

		}

	}

}

//=========================================================================================
// Get Element By TagName
//=========================================================================================
function bytag(tag, pointer) {

	if (typeof tag == 'string') {

		var elements = document.getElementsByTagName(tag);

		if (typeof pointer == 'integer') {

			return elemensts[pointer];

		} else {

			return elements;

		}

	}

}

//=========================================================================================
// addEventListener
//=========================================================================================
document.addEventListener("DOMContentLoaded", DOMContentLoaded, false);
window.addEventListener('resize', resize, false);
window.addEventListener('touchmove', touchmove, false);
document.addEventListener('click', click, true);
window.addEventListener("submit", submit);

//=========================================================================================
// addEventListener: DOMContentLoaded
//=========================================================================================
function DOMContentLoaded() {

	debug('DOM Content Loaded');

	MOBILE = ismobile();

	resize();
	setDate();

}

//=========================================================================================
// Set Start and End Dates
//=========================================================================================
function setDate(_this) {

	var hoje = now('Y-M-D');

	if (!localStorage['set-date'] || localStorage['set-date'] != hoje) {
		localStorage.removeItem('start-date');
		localStorage.removeItem('end-date');
	}

	if (_this) {

		if (_this.id == 'start-date')
			localStorage['start-date'] = _this.value;
		else if (_this.id == 'end-date')
			localStorage['end-date'] = _this.value;
		else
			return;

		localStorage['set-date'] = hoje;
		search();

	} else {

		var startDate = byid('start-date');
		if (startDate) {
			if (!localStorage['start-date'])
				localStorage['start-date'] = hoje;
			startDate.value = localStorage['start-date'];
		}

		var endDate = byid('end-date');
		if (endDate) {
			if (!localStorage['end-date'])
				localStorage['end-date'] = hoje;
			endDate.value = localStorage['end-date'];
		}

	}

}

//=========================================================================================
// setContentHeight
//=========================================================================================
function setContentHeight() {

	var pageHeight = document.body.offsetHeight;

	var pageHeader = document.getElementById('page-header');
	if (pageHeader)
		var headerHeight = pageHeader.offsetHeight;
	else
		return;
	
	var pageFooter = document.getElementById('page-footer');
	if (pageFooter)
		var footerHeight = pageFooter.offsetHeight;
	else
		return;
	
	var pageContent = document.getElementById('page-content');
	if (pageContent)
		pageContent.style.minHeight = (pageHeight - headerHeight - footerHeight) + 'px';
	else
		return;

}

//=========================================================================================
// windowWidth
//=========================================================================================
function windowWidth() {
	
	if (MOBILE)
		return window.outerWidth;
	else
		return window.innerWidth;

}

//=========================================================================================
// windowHeight
//=========================================================================================
function windowHeight() {
	
	if (MOBILE)
		return window.outerHeight;
	else
		return window.innerHeight;

}

//=========================================================================================
// setMenuWidth
//=========================================================================================
function setMenuWidth() {

	var menu = byid('menu');
	
	if (menu) {
		
		if (menu.hasClass('open')) {

			var w = windowWidth();

			if (w <= 640)
				var mw = '100%';
			else
				var mw = '320px';

			menu.style.width = mw;

		} else {

			menu.style.width = null;

		}

	}

}

//=========================================================================================
// Responsive
//=========================================================================================
function responsive(className, active) {

	if (className == 'lg') {

		var content = byid('page-content');
			
		if (content) {
				
			if (active)
				content.style.padding = "2px";
			else
				content.style.padding = null;

		}
			
	}

	var elements = document.getElementsByClassName(className);

	if (elements.length > 0) {
	
		if (active) {

			for (var i=0; i < elements.length; i++) {

				elements[i].addClass('responsive');

			}

		} else {

			for (var i=0; i < elements.length; i++) {

				elements[i].removeClass('responsive');

			}

		}

	}

}

//=========================================================================================
// addEventListener: Resize
//=========================================================================================
function resize() {

	var w = windowWidth();
	var h = windowHeight();

	setContentHeight();
	setMenuWidth();

	// Responsive
	if (w <= 1140) responsive("xs", true); else responsive("xs", false);
	if (w <= 960) responsive("lg", true); else responsive("lg", false);
	if (w <= 720) responsive("md", true); else responsive("md", false);
	if (w <= 540) responsive("sm", true); else responsive("sm", false);
	
}

//=========================================================================================
// Event Listeners: 'touchmove'
//=========================================================================================
function touchmove() {

	resize();

}

//=========================================================================================
// addEventListener: click
//=========================================================================================
function click(event) {
	
	if (event.target.hasAttribute('ajax')) {

		if (ajaxState == 1) {

			event.stopPropagation();
			debug('Waiting ajax...');

		}
		
	}

}

//=========================================================================================
// open Modal
//=========================================================================================
function openModal(id) {

	var modal = byid(id);

	if (modal) {
			
		document.body.addClass('nocroll');
		modal.style.display = 'table';

	}

}

//=========================================================================================
// close Modal
//=========================================================================================
function closeModal(id) {

	var modal = byid(id);

	if (modal) {

		modal.style.display = 'none';
		document.body.removeClass('nocroll');

	}

}

//=========================================================================================
// open Menu
//=========================================================================================
function openMenu() {

	var menu = byid('menu');

	if (menu) {

		menu.addClass('open');
		setMenuWidth();

	}

}

//=========================================================================================
// close Menu
//=========================================================================================
function closeMenu() {

	var menu = byid('menu');

	if (menu) {

		menu.removeClass('open');
		setMenuWidth();

	}

}

//=========================================================================================
// link Menu
//=========================================================================================
function linkMenu(url) {

	if (typeof url == 'string') {

		var arr = url.split('/');
		
		if (arr.length == 2) {

			url = '?g=' + arr[0] + '&s=' + arr[1];
			debug(url);

		}

		closeMenu();

		setTimeout(function() { location.href = url; }, 400);

	} else {

		console.warn('Nenhum url foi especificada');

	}

}

//=========================================================================================
// ajaxStatus
//=========================================================================================
function ajaxStatus(tabid, status, msg) {

	if (typeof tabid == 'string' && typeof status == 'number') {

		var header = byid('header' + tabid);

		if (header) {
			
			var title = header.children[0],
				loading = header.children[1],
				error = header.children[2];

			if (title && loading && error) {

				switch (status) {

					case 1:
						ajaxState = 1;
						title.addClass('hide');
						loading.removeClass('hide');
						error.addClass('hide');
					break;
					case 2:
						ajaxState = 0;
						title.addClass('hide');
						loading.addClass('hide');
						error.removeClass('hide');
					break;
					default:
						ajaxState = 0;
						title.removeClass('hide');
						loading.addClass('hide');
						error.addClass('hide');

				}

			}

		}

		var boxStatus = byid('box-status' + tabid);

		if (boxStatus) {

			if (msg) {

				if (status == 0) {

					boxStatus.innerText = msg;
					boxStatus.removeClass('red');
					boxStatus.addClass('green');

					boxStatus.removeClass('hide');

					setTimeout(function() {
						boxStatus.addClass('hide');
					}, 2500);

				} else if (status == 2) {

					boxStatus.innerText = msg;
					boxStatus.removeClass('green');
					boxStatus.addClass('red');

					boxStatus.removeClass('hide');

					setTimeout(function() {
						boxStatus.addClass('hide');
					}, 5000);

				}

			} else {
				
				boxStatus.addClass('hide');
				
			}

		}

	}

}

//=========================================================================================
// On Submit
//=========================================================================================
function submit(e) {

	e.preventDefault();

	var form	= e.target;

	var ajaxData = {
		url		: _database,
		command	: (form.command) ? form.command.value : '',
		tabid	: form.getAttribute('data-tabid') || '1',
		data	: $(form).serialize()
	}

	debug(ajaxData);

	ajaxPost(ajaxData);

}

//=========================================================================================
// Ajax Query
//=========================================================================================
function ajaxPost(ajaxData) {

	console.log(ajaxData);

	if (typeof ajaxData == 'object') {

		var url = ajaxData.url,
			tabid = ajaxData.tabid,
			data = ajaxData.data,
			command = ajaxData.command;

	} else {

		console.warn('ajaxData não está definido');
		return;

	}
	
	// Star Time
	var startTime = new Date();

	$.ajax({
		url: url,
		method: 'POST',
		cache: false,
		dataType: 'json',
		data: data,
		beforeSend: function() {

			ajaxStatus(tabid, 1);
			beforeSend();

		},
		error: function(data) {

			ajaxStatus(tabid, 2, 'Falha no servidor');
			afterSend();
			dataError(data, ajaxData);

		},
		success: function(data) {
			
			afterSend();
			
			// End Time
			var endTime = ((new Date() - startTime) / 1000) + " seg.";
			debug('POST: ' + endTime);

			switch (data.status) {

				case 0:
					afterPost(command);
					ajaxStatus(tabid, 0, data.msg);
					dataSuccess(data.results, ajaxData);
				break;
				case 1:
					ajaxStatus(tabid, 2, data.msg);
					dataWarning(data.msg, ajaxData);
				break;
				case 2:				
					ajaxStatus(tabid, 2, 'Falha na solicitação');
					dataError(data.msg, ajaxData);
				break;
				default:
					ajaxStatus(tabid, 2, 'Falha no servidor');
					dataInvalid(data, ajaxData);

			}

		}
	});

}

//=========================================================================================
// Ajax Query
//=========================================================================================
function ajaxQuery(ajaxData) {

	if (typeof ajaxData == 'object') {

		var url = ajaxData.url || _database;

		if (typeof url != 'string') {

			console.warn("'ajaxData.url/_database' não está definido");
			return;

		}

		if (typeof ajaxData.command != 'string') {

			console.warn("'ajaxData.command' não está definido");
			return;

		}

		var success	= (typeof ajaxData.success	== 'function') ? ajaxData.success	: dataSuccess,
		warning	= (typeof ajaxData.warning	== 'function') ? ajaxData.warning	: dataWarning,
		error	= (typeof ajaxData.error	== 'function') ? ajaxData.error		: dataError,
		invalid	= (typeof ajaxData.invalid	== 'function') ? ajaxData.invalid	: dataInvalid,

		processData	= true,
		contentType	= 'application/x-www-form-urlencoded',

		tabid = ajaxData.tabid || '1';

		ajaxData.success 	= '';
		ajaxData.warning	= '';
		ajaxData.error		= '';
		ajaxData.invalid	= '';

	} else {

		console.warn("'ajaxData' não está definido");
		return;

	}

	// For Upload
	if (ajaxData.upload) {
		
		processData = false;
		contentType	= false;

		var fileData = new FormData();
			fileData.append('file', ajaxData.file);
			fileData.append('filename', ajaxData.filename);
			fileData.append('command', ajaxData.command);
			fileData.append('id', ajaxData.id);
			fileData.append('slot', ajaxData.slot);

	}

	// Star Time
	var startTime = new Date();

	$.ajax({
		url: url,
		method: 'POST',
		cache: false,
		processData: processData,
		contentType: contentType,
		data: fileData || ajaxData,
		beforeSend: function() {

			ajaxStatus(tabid, 1);
			beforeSend();

		},
		error: function(data) {

			ajaxStatus(tabid, 2, 'Falha no servidor');
			afterSend();
			dataError(data, ajaxData);

		},
		success: function(data) {

			afterSend();

			// End Time
			var endTime = ((new Date() - startTime) / 1000) + " seg.";
			debug('RESQUEST: ' + endTime);

			switch (data.status) {

				case 0:

					if (ajaxData.remove)
						dataRemove(ajaxData.remove);

					ajaxStatus(tabid, 0, data.msg);
					success(data.results, ajaxData);
				break;
				case 1:
					ajaxStatus(tabid, 2, data.msg);
					warning(data.msg, ajaxData);
				break;
				case 2:
					ajaxStatus(tabid, 2, 'Falha na solicitação');
					error(data.msg, ajaxData);
				break;
				default:
					ajaxStatus(tabid, 2, 'Falha no servidor');
					invalid(data, ajaxData);

			}

		},
		xhr: function() {
			
			var myXhr = $.ajaxSettings.xhr();

			// For Upload
			if (ajaxData.upload) {
				
				if (myXhr.upload)
					myXhr.upload.addEventListener('progress', function() { uploadProgress(event, ajaxData.slot); }, false);
				
			}

			return myXhr;

		}
	});

}

//=========================================================================================
// Ajax Before Send
//=========================================================================================
function beforeSend() {

}

//=========================================================================================
// Ajax After Send
//=========================================================================================
function afterSend() {


}

//=========================================================================================
// Ajax Data Success
//=========================================================================================
function dataSuccess(data, ajaxData) {

	console.log(data);

}

//=========================================================================================
// Ajax Data Warning
//=========================================================================================
function dataWarning(data, ajaxData) {

	console.warn(data);

}

//=========================================================================================
// Ajax Data Error
//=========================================================================================
function dataError(data, ajaxData) {

	console.log(ajaxData);

	if (data.responseText)
		console.error(data.responseText)
	else
		console.error(data);

}

//=========================================================================================
// Ajax Data Invalid
//=========================================================================================
function dataInvalid(data, ajaxData) {

	console.error(data);

}

//=========================================================================================
// Ajax Remove HTML Element
//=========================================================================================
function dataRemove(id) {

	if (typeof id == 'string') {

		var element= document.getElementById(id);

		if (element) {

			element.remove();

		}

	}

}

//=========================================================================================
// After Post
//=========================================================================================
function afterPost(data) {

	debug(data);

}

//=========================================================================================
// Box Close
//=========================================================================================
function closeBox(_this) {
	
	if (typeof _this == 'object') {

		var box = _this.parentElement.parentElement;
		
		if (box && box.classList.contains('box')) {

			box.remove();

		}
		
	}

}

//=========================================================================================
// Box Minimize
//=========================================================================================
function minimizeBox(_this) {

	var box = _this.parentElement.parentElement,
		hh = box.children[0].offsetHeight;

	if (box.style.height == hh + 'px') {		

		_this.firstChild.removeClass('r180');
		box.style.height = null;

	} else {
		
		_this.firstChild.addClass('r180');
		box.style.height = hh + 'px';

	}

}

//=========================================================================================
// Set Page Tab
//=========================================================================================
function pageTab(tabId) {

	if(typeof relatorio != 'undefined'){
		if (search == relatorio && tabId == 1) 
			tabId = 4;
	}

	if (tabId) {

		var tab = byid('tab' + tabId);

		if (tab) {

			var tabs = document.getElementsByClassName('page-tab');

			for (var i=0; i < tabs.length; i++) {

				tabs[i].addClass('hide');

			}

			tab.removeClass('hide');
			location.href = "#tab" + tabId;

		}

	}

}

//=========================================================================================
// Setup Form
//=========================================================================================
function setupForm(options) {
	
	if (options.tabid) {

		ajaxStatus(options.tabid, 0);

		var form = byid('form' + options.tabid),
			boxStatus = byid('box-status' + options.tabid);

		if (form) {

			if (options.reset)
				form.reset();

			if (options.command) {

				form.command.value = options.command;
				form.setAttribute('data-tabid', options.tabid);

			}

			if (options.data && options.inputs) {

				form.setAttribute('data-id' , options.data.id);

				for (var i=0; i < options.inputs.length; i++) {

					if (form[options.inputs[i]]) {

						if (form[options.inputs[i]].type == 'datetime-local' && options.data[options.inputs[i]]){
							console.log(options.data[options.inputs[i]]);
							form[options.inputs[i]].value = options.data[options.inputs[i]].datetime();
						}

						else
							form[options.inputs[i]].value = (options.data[options.inputs[i]] || '');

					} else
						console.warn("input: '" + options.inputs[i] + "' não encontrado");
				}

			}

		}

		if (boxStatus) boxStatus.addClass('hide');

	}

}

//=========================================================================================
// Create Options for Select Input
//=========================================================================================
function createSelect(selectId, options, update) {

	var select = byid(selectId);

	if (select && (select.length < 2 || update)) {

		var html;

		if (options.length > 0) {

			html = "<option value='' selected>Selecione</option>\n";

			for (var i=0; i < options.length; i++) {

				html += "<option value='" + options[i].id + "'>" + options[i].nome + "</option>\n";

			}

		} else {

			html = "<option value=''>Nenhuma opção encontrada</option>";

		}

		select.innerHTML = html;

	}

}

//=========================================================================================
// Random Integer
//=========================================================================================
function random(min, max) {

	if (min && max)	return Math.floor(Math.random() * max) + min;

}

//=========================================================================================
// Date Day Alias
//=========================================================================================
Date.prototype.dd = function() {

	var dd = this.getDate();
	return (dd < 10) ? ('0' + dd) : dd;

}

//=========================================================================================
// Date Month Alias
//=========================================================================================
Date.prototype.mm = function() {

	var mm = this.getMonth() + 1;
	return (mm < 10) ? ('0' + mm) : mm;

}

//=========================================================================================
// Date Year Alias
//=========================================================================================
Date.prototype.yyyy = function() {

	return this.getFullYear();

}

//=========================================================================================
// Date Hours Alias
//=========================================================================================
Date.prototype.h = function() {
	
	var h = this.getHours();
	return (h < 10) ? ('0' + h) : h;

}

//=========================================================================================
// Date Minutes Alias
//=========================================================================================
Date.prototype.m = function() {

	var m = this.getMinutes();
	return (m < 10) ? ('0' + m) : m;

}

//=========================================================================================
// Date Seconds Alias
//=========================================================================================
Date.prototype.s = function() {

	var s = this.getSeconds();
	return (s < 10) ? ('0' + s) : s;

}

//=========================================================================================
// Date Now
//=========================================================================================
function now(format) {

	var str = format || 'D/M/Y - h:m:s',
		d = new Date();

	str = str.replace('D', 	d.dd());
	str = str.replace('M',	d.mm());
	str = str.replace('Y',	d.yyyy());
	str = str.replace('h', 	d.h());
	str = str.replace('m', 	d.m());
	str = str.replace('s', 	d.s());

	return str;

}

//=========================================================================================
// String to 'Andar'
//=========================================================================================
String.prototype.andar = function() {

	var andar = parseInt(this);

	switch(true) {

		case andar < 0:
			return 'Sub' + this;
		break;
		case andar == 0:
			return 'Térreo';
		break;
		case andar > 0:
			return this + 'º andar';
		break;
		default:
			return this;

	}

}

//=========================================================================================
// String to Date
//=========================================================================================
String.prototype.date = function() {
	
	if (this.length == 19)
			return this.substr(8,2) + '/' + this.substr(5,2) + '/' + this.substr(0,4) + ' ' + this.substr(11,8);
	else return this;

}

//=========================================================================================
// String to Mac
//=========================================================================================
String.prototype.mac = function() {

	if (this.length == 12)
			return this.substr(0,2) + ':' + this.substr(2,2) + ':' + this.substr(4,2) + ':' + this.substr(6,2) + ':' + this.substr(8,2) + ':' + this.substr(10,2);
	else return this;

}

//=========================================================================================
// String to Datetime
//=========================================================================================
String.prototype.datetime = function() {

	if (this.length == 19)
			return this.substr(0,16).replace(' ','T');
	else return this;

}


//=========================================================================================
// Bytes to KBytes
//=========================================================================================
Number.prototype.kb = function() {
	
	return parseInt(this * 0.001) + 'KB';

}

//=========================================================================================
// String Infinite Concat
//=========================================================================================
function s() {
	
	var str, i;

	if (arguments.length > 1) {

		str = arguments[0];

		for (i=1; i < arguments.length; i++) {

			str = str.replace('$'+(i-1), arguments[i]);

		}

		return str;

	} else {

		return '';

	}

}

//=========================================================================================
// Order
//=========================================================================================
function setOrder(col, i){
	
	//Remove o indicador de ordenação
	(byid('icone'))? byid('icone').remove() : '';

	console.log(col);
	//Adiciona indicador de ordenação UP
	var icon = document.createElement('i');
	icon.id = 'icone';
	icon.classList.add("fa");
	icon.classList.add("fa-12");		
	icon.classList.add("right");
	col.appendChild(icon);
	
	//Se clicou na mesma coluna, inverter
	if(colFilter == col){

		//Verifica a orientação da ordenação
		if(order == 'up'){
			icon.classList.add("fa-chevron-down");
			order = 'down';

			//Usa o parametro i(int) como ordenador
			byid('order').value = i;
		}
		else if(order = 'down'){
			icon.classList.add("fa-chevron-up");
			order = 'up';	

			//Usa o parametro i(int) como ordenador (negativo, orientação desc)
			byid('order').value = i * -1;
		}

	}else {

		//Se for o primeiro click na coluna, orientação asc
		icon.classList.add("fa-chevron-down");
		order = 'down';	

		//Usa o parametro i(int) como ordenador
		byid('order').value = i;
	}

	//Grava a nova coluna filtrada
	colFilter = col;

	search();
   
}

function minimizeMenu(menu, id){
	
	var lista = menu.getElementsByTagName('i')[1].classList.toString();
	var atual;

	listaArr = lista.split(' ');

	for( var i=0; i < listaArr.length; i++){
		if(listaArr[i] == 'fa-chevron-down')
			atual = 'baixo';
		else if(listaArr[i] == 'fa-chevron-up')
			atual = 'cima';
	}

	if(atual == 'baixo'){
		menu.getElementsByTagName('i')[1].removeClass('fa-chevron-down');
		menu.getElementsByTagName('i')[1].addClass('fa-chevron-up');
		byid(id).style.display = (byid(id).style.display != 'none') ? 'none' : 'block';
	}else if(atual == 'cima'){
		menu.getElementsByTagName('i')[1].removeClass('fa-chevron-up');
		menu.getElementsByTagName('i')[1].addClass('fa-chevron-down');
		byid(id).style.display = (byid(id).style.display == 'none') ? 'block' : 'none';
	}

}