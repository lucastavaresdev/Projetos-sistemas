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
	case 'relatorio':
		relatorio();
	break;
	case 'atualizar':
		atualizar();
	break;
	case 'atualizar_ronda':
		atualizar_ronda();
	break;
	case 'deletar':
		deletar();
	break;
	case 'deletarUpload':
		deletarUpload();
	break;
	case 'upload':
		upload();
	break;
	case 'uploadImage':
		uploadImage();
	break;	
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Upload
function upload() {
	
	if ($_FILES) {

		$id = $_POST['id'];
		$slot = $_POST['slot'];

		$tempfile = $_FILES['file']['tmp_name'];
		$filename = $id . '_' . $slot . '_' . basename($_FILES['file']['name']);

		if (move_uploaded_file($tempfile, UPLOADS . $filename)) {

			$connection = openDB();

			$query = "update rondas set anexo$slot = '$filename' where id = '$id'";
			query($query, $connection)[0];

			closeDB($connection);

			jsonStatus(0, 'Upload Completo', $filename);

		} else {

			print_r($_FILES["file"]);

		}

	}

}

// Upload
function uploadImage() {

	$file		= $_POST['file'];
	$filename	= swapExt($_POST['filename'], 'jpg');
	$quality	= isset($_POST['quality']) ? $_POST['quality'] : 95;

	base64ToJPG($file, $filename, $quality);

}

// swapExt
function swapExt($filename, $ext) {

	if (gettype($filename) == 'string' && gettype($ext) == 'string') {

		$name = explode('.', $filename)[0];
		return "$name.$ext";

	} else {
		
		return $filename;
		
	}

}

// Save to JPG
function base64ToJPG($file, $filename, $quality) {


	$id = $_POST['id'];
	$slot = $_POST['slot'];

	if ($file && $filename && $quality) {

		$file = str_replace('data:image/png;base64,', '', $file);
		$file = str_replace(' ', '+', $file);

		$data = base64_decode($file);

		$source = imagecreatefromstring($data);
		$angle = 0;
		$rotate = imagerotate($source, $angle, 0);
		$imageName = $id . '_' . $slot . '_' . $filename;
		$imageSave = imagejpeg($rotate,UPLOADS . $imageName, $quality);
		imagedestroy($source);
		
		if (file_exists(UPLOADS . $imageName)) {

			$connection = openDB();

			$query = "update rondas set anexo$slot = '$imageName' where id = '$id'";
			query($query, $connection)[0];

			closeDB($connection);

			jsonStatus(0, 'Upload Completo', $imageName);

		} else {

			jsonStatus(2, 'Não foi possível cadastrar o upload na base de dados');

		}

	} else {

		jsonStatus(2, 'Parâmetros insuficientes');

	}

}

// Deletar Upload
function deletarUpload() {

	$id = post('id');
	$slot = post('remove');

	$connection = openDB();
	$query = "select anexo$slot from rondas where id = '$id'";
	$results = query($query, $connection)[0];

	$filename = $results[0]["anexo$slot"];

	if ($filename) {

		if (file_exists(UPLOADS . $filename)) {

			unlink(UPLOADS . $filename);

		}

		$query = "update rondas set anexo$slot = NULL where id = '$id'";
		query($query, $connection)[0];

	}
	
	closeDB($connection);

	jsonStatus(0, 'Arquivo deletado com sucesso');

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
	r.id,
	e.id as id_equipamento,
	e.nome,
	e.marca,
	e.modelo,
	e.serie,
	e.patrimonio,
	e.ronda,
	r.ronda_ultima,
	r.ronda_ultima + interval e.ronda day as ronda_proxima,
	datediff(r.ronda_ultima + interval e.ronda day, now()) as ronda_dias,
	r.id_usuario,
	r.observacao,
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
				max(id_usuario) as id_usuario,
				max(id_equipamento) as id_equipamento,
				max(ronda_ultima) as ronda_ultima,
				max(observacao) as observacao
				from rondas
				group by id_equipamento
		) r on r.id_equipamento = e.id
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
				date(r.ronda_ultima + interval e.ronda day) between '$startDate' and '$endDate' or
				r.ronda_ultima is null 
			)
		order by $order $orientation";

	$results['rondas'] = query($query, $connection)[0];

	$query = "select id, concat(nome, ' | ', serie, ' | ', patrimonio) as nome from equipamentos";
	$results['equipamentos'] = query($query, $connection)[0];
	
	$query = "select id, concat(nome, ' | ', cadastro) as nome from usuarios";
	$results['usuarios'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);

}


// Listar
function relatorio() {
	
	$search = post('search');
	$startDate = post('startDate');
	$endDate = post('endDate');
	$order = post('order');
	$orientation = post('orientation');

	$connection = openDB();

	$query = "select 
				r.id,
				r.id_usuario,
				r.id_equipamento,
				r.ronda_ultima, 
				e.nome as equipamento,
				e.marca,
				e.modelo,
				e.serie,
				e.patrimonio,
				r.situacao,
				u.nome as responsavel,
				r.observacao,                
				r.anexo1,
				r.anexo2,
				r.anexo3
				from  rondas r
					left join usuarios u
					on u.id = r.id_usuario
					left join equipamentos e
					on e.id = r.id_equipamento	
					where	(
							e.nome like '%$search%' or
							e.marca like '%$search%' or
							e.modelo like '%$search%' or
							e.serie like '%$search%' or
							e.patrimonio like '%$search%' or
							r.situacao like '%$search%' or
							u.nome like '%$search%'
						) and (
							date(r.ronda_ultima) between '$startDate' and '$endDate'
						)
						order by $order $orientation";

	$results['relatorio'] = query($query, $connection)[0];

	jsonStatus(0, '', $results);

}

// Atualizar
function atualizar() {

	$id				= post('id');
	$id_equipamento	= post('id_equipamento');
	$id_usuario		= post('id_usuario');
	$ronda_ultima	= post('ronda_ultima');
	$situacao		= post('situacao');
	$observacao		= post('observacao');

	$query = "update rondas set id_equipamento = '$id_equipamento', id_usuario = '$id_usuario', ronda_ultima = '$ronda_ultima', situacao = '$situacao', observacao = '$observacao' where id = '$id'";
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

// Deletar
function deletar() {

	$id = post('id');
	$query = "delete from rondas where id = '$id'";
	query($query)[0];

}
?>