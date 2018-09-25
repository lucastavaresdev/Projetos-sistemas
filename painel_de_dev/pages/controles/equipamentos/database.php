<?php
//=========================================================================================
//
// Sistema/Beacons: database.php 01/10/2017
//
//=========================================================================================
session_start();

// Json
require "../../../main/json.php";

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	jsonStatus(2, "Método deve ser 'POST'");
}

// Verifica a presença de uma query
if (!isset($_POST['command'])) {
	jsonStatus(2, 'Nenhum comando encontrado');
}

//iTechBI Config & Functions
require "../../../config.php";
require "../../../main/logs.php";
require "../../../main/getpost.php";
require "../../../main/db_mysqli.php";

// Verifica qual é a query e direciona para a função
switch($_POST['command']) {

	case 'listar':
		listar();
	break;
	case 'salvar':
		salvar();
	break;
	case 'atualizar':
		atualizar();
	break;
	case 'atualizar_ronda':
		atualizar_ronda();
	break;
	case 'atualizar_calibracao':
		atualizar_calibracao();
	break;
	case 'deletar':
		deletar();
	break;
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Listar
function listar() {
	
	$search = post('search');
	$startDate = post('startDate');
	$endDate = post('endDate');
	$order = post('order');
	$orientation = post('orientation');

	$connection = openDB();

	$query = "select
				e.id,
				e.nome,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,
				e.ronda,
				r.ronda_ultima,
				r.ronda_ultima + interval e.ronda day as ronda_proxima,
				datediff(r.ronda_ultima + interval e.ronda day, now()) as ronda_dias,
				e.calibracao,
				c.calibracao_ultima,
				c.calibracao_ultima + interval e.calibracao day as calibracao_proxima,
				datediff(c.calibracao_ultima + interval e.calibracao day, now()) as calibracao_dias,
				e.situacao,
				e.ativo,
				e.setor as setorid,
				s.sigla as setor_origem,
				s.predio as predio_origem,
				s.andar as andar_origem,    
				
				t.setor,
				s2.sigla as setor_destino,
				s2.predio as predio_destino,
				s2.andar as andar_destino,
				
				t.tempo,    
				t.checkout
				
					from equipamentos e
					left join (
						select
							max(id) as id,
							id_equipamento,
							max(ronda_ultima) as ronda_ultima
							from rondas
							group by id_equipamento
					) r on r.id_equipamento = e.id
					left join (
						select
							max(id) as id,
							id_equipamento,
							max(calibracao_ultima) as calibracao_ultima
							from calibracoes
							group by id_equipamento
					) c on c.id_equipamento = e.id
					left join setores s
					on s.id = e.setor
					left join (
						select 
							max(id_equipamento) as id_equipamento,
							timediff( max(checkout), max(checkin)) as tempo,
							max(checkout) as checkout,
							max(t.id_setor) as setor
							from tracking t
							group by id_equipamento
					) t on t.id_equipamento = e.id
					left join setores s2
					on s2.id = t.setor
					where (
							e.nome like '%$search%' or
							e.marca like '%$search%' or
							e.modelo like '%$search%' or
							e.serie like '%$search%' or
							e.patrimonio like '%$search%' or
							e.situacao like '%$search%'
						) and (
							date(c.calibracao_ultima + interval e.calibracao day) between '$startDate' and '$endDate' or
							date(r.ronda_ultima + interval e.ronda day) between '$startDate' and '$endDate' or
							r.ronda_ultima is null or
							c.calibracao_ultima is null
						)
					order by $order $orientation";

	$results['equipamentos'] = query($query, $connection)[0];

	$query = "select id, concat (sigla, ' | ', nome) as nome from setores order by nome";
	$results['setores'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);

}

// Salvar
function salvar() {

	$nome		= post('nome');
	$marca		= post('marca');
	$modelo		= post('modelo');
	$serie		= post('serie');
	$patrimonio	= post('patrimonio');
	$ronda		= post('ronda');
	$calibracao	= post('calibracao');
	$situacao	= post('situacao');
	$ativo		= post('ativo');
	$setorid	= sqlnull(post('setorid'));

	$query = "insert into equipamentos (nome, marca, modelo, serie, patrimonio, ronda, calibracao, situacao, ativo, setor) values('$nome', '$marca', '$modelo', '$serie', '$patrimonio', '$ronda', '$calibracao', '$situacao', '$ativo', $setorid)";
	query($query)[0];

}

// Atualizar
function atualizar() {

	$id 		= post('id');
	$nome		= post('nome');
	$marca		= post('marca');
	$modelo		= post('modelo');
	$serie		= post('serie');
	$patrimonio	= post('patrimonio');
	$ronda		= post('ronda');
	$calibracao	= post('calibracao');
	$situacao	= post('situacao');
	$ativo		= post('ativo');
	$setorid	= sqlnull(post('setorid'));

	$query = "update equipamentos set nome = '$nome', marca = '$marca', modelo = '$modelo', serie = '$serie', patrimonio = '$patrimonio', ronda = '$ronda', calibracao = '$calibracao', situacao = '$situacao', ativo = '$ativo', setor = $setorid where id = '$id'";
	query($query)[0];

}

// Atualizar Ronda
function atualizar_ronda() {

	$id 		= post('id');
	$id_usuario = $_SESSION['userid'];
	$datahora 	= post('datahora');
	$situacao 	= post('situacao');
	$observacao = sqlnull(post('observacao'));

	$connection = openDB();

	$query = "update equipamentos set situacao = '$situacao' where id = '$id'";
	$results['equipamentos'] = query($query, $connection)[0];

	$query = "insert into rondas (id_equipamento, id_usuario, ronda_ultima, situacao, observacao) values ('$id', '$id_usuario', '$datahora', '$situacao', $observacao)";
	$results['ronda'] = query($query, $connection)[0];
	
	closeDB($connection);

	jsonStatus(0, 'Atualizado com sucesso', $results);

}

// Atualizar Calibração
function atualizar_calibracao() {

	$id 		= post('id');
	$id_usuario = $_SESSION['userid'];
	$datahora 	= post('datahora');
	$situacao 	= post('situacao');
	$observacao = sqlnull(post('observacao'));

	$connection = openDB();

	$query = "update equipamentos set situacao = '$situacao' where id = '$id'";
	$results['equipamentos'] = query($query, $connection)[0];

	$query = "insert into calibracoes (id_equipamento, id_usuario, calibracao_ultima, situacao, observacao) values ('$id', '$id_usuario', '$datahora', '$situacao', $observacao)";
	$results['calibracao'] = query($query, $connection)[0];

	closeDB($connection);

	jsonStatus(0, 'Atualizado com sucesso', $results);

}

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from equipamentos where id = '$id'";
	query($query)[0];

}
?>