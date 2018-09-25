_database = "pages/sistema/login/database.php";

function dataSuccess(data) {

	debug(data);
	
	setTimeout(function() {

		var group = byid('page').getAttribute('data-g');
		var setor = byid('page').getAttribute('data-s');
		var page = byid('page').getAttribute('data-p');

		var get = (group) ? 'g='+group : 'g='+'unidade';
		get += (setor) ? '&s='+setor : '&s='+'setores';
		get += (page) ? '&p='+page : '';
		
		window.location.replace('index.php?'+get);
		
	}, 1000);
	

}