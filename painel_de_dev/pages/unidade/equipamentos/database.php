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
    e.situacao,
	e.ativo,
	e.setor as setorid,
	s.nome as setor,
	e.ronda,
	e.calibracao
		from equipamentos e		
		left join setores s
        on s.id = e.setor
		where (
				e.nome like '%$search%' or
				e.marca like '%$search%' or
				e.modelo like '%$search%' or
				e.serie like '%$search%' or
				e.patrimonio like '%$search%' or
				e.situacao like '%$search%'
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