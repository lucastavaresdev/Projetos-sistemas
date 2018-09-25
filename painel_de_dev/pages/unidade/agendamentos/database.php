<?php
//=========================================================================================
//
// Sistema/Beacons: database.php 01/10/2017
//
//=========================================================================================

header('Content-Type: application/json');

//iTechBI Config & Functions
require "../../../config.php";
require "../../../main/".DEFAULT_LANGUAGE;
require "../../../main/itechflow.php";
require "../../../main/db_mysqli.php";


// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	savelog('error', REQUEST_METHOD_INVALID . " '" . $_SERVER["REQUEST_METHOD"] . "'", true);
	exit;
}

// Verifica a presença de uma query
if (!isset($_POST['command'])) {
	savelog('error', "Comando Inválido '" . $_SERVER["REQUEST_METHOD"] . "'", true);
	exit;
}

// Verifica qual é a query e direciona para a função
switch($_POST['command']) {

	case 'listar':
		listar();
	break;
        case 'SalvaAnotacao':
		SalvaAnotacao();
	break;
        case 'RetornaTracking':
		RetornaTracking();
	break;
	default:
		jsonStatus(2, 'Nenhum comando reconhecido foi encontrado');

}

// Listar
function listar() {
	
	$order = post('order');
	$orientation = post('orientation');
        $filtroData = post('filtroData');
   
      if ($filtroData ==""  || $filtroData ==null ){
           
          $query = "SELECT id,
                    Data_cirurgia,
                    Hora_cirurgia,
                    Cirurgia,
                    convenio,
                    Cod_Beneficiario,
                    nm_paciente,
                    Cirurgiao,
                    Data_Internacao,
                    Anestesista,
                    Centro_Cirurgico,
                    Registrante,
                    Sala_Cirurgia,
                    Observacao,
                    cd_cirurgia_aviso,
                    cd_aviso_Cirurgia,
                    Outras_Cirurgias,
                    idade,
                    tp_situacao,
                    tp_sexo,
                    cd_paciente,
                    dt_nascimento,
                    anotacao
                FROM agendamento
                    where date_format(Hora_cirurgia,'%Y %M %D') = date_format(now(),'%Y %M %D')
                    group by nm_paciente
                    order by $order $orientation"; 

      }else{
                   
          $query = "SELECT id,
                    Data_cirurgia,
                    Hora_cirurgia,
                    Cirurgia,
                    convenio,
                    Cod_Beneficiario,
                    nm_paciente,
                    Cirurgiao,
                    Data_Internacao,
                    Anestesista,
                    Centro_Cirurgico,
                    Registrante,
                    Sala_Cirurgia,
                    Observacao,
                    cd_cirurgia_aviso,
                    cd_aviso_Cirurgia,
                    Outras_Cirurgias,
                    idade,
                    tp_situacao,
                    tp_sexo,
                    cd_paciente,
                    dt_nascimento,
                    anotacao
                FROM agendamento 
                    where date_format(Hora_cirurgia,'%d/%m/%Y') = '$filtroData'
                    group by nm_paciente
                    order by $order $orientation";
               
      }
             
 
        query($query);

}


function SalvaAnotacao() {
	
	$cdAvisoCirurgia= post('cd_aviso_Cirurgia');
	$anotacaoTexto = post('anotacao');

        $query = "update agendamento set anotacao='$anotacaoTexto' where cd_aviso_Cirurgia = $cdAvisoCirurgia "; 
        
        query($query);

}

function RetornaTracking() {
	
	$cd_aviso_Cirurgia= post('cd_aviso_Cirurgia');
        $idTextBoxTracking = post('idTextBoxTracking');

        $query = "SELECT 
            $idTextBoxTracking as idtextBox,
            g.nome,
            b.minor,
            s.nome,
            a.nm_paciente,
            tp.id_vinculado,
            tp.categoria,
            a.checkin as checkin ,
            a.checkout as checkout
            FROM tracking_pacientes tp
            inner join gateways g 
            on g.id = tp.gateway
            inner join setores s 
            on s.id = tp.id_sala
            inner join beacons b 
            on b.id = tp.beacon
            inner join agendamento a 
            on a.cd_aviso_Cirurgia = tp.id_vinculado
            where tp.id_vinculado = $cd_aviso_Cirurgia "; 

            
        query($query);

}

?>
