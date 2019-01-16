<?php

  try{

	
    $conexao = new PDO("mysql:host=itechbd.mysql.database.azure.com;dbname=hcor2", "itechflow@itechbd", "Itechm@ster_2018"); 
    }catch(PDOException $e){
        echo "Erro gerado " . $e->getMessage(); 
    }

//$parametro =$_GET['parametro'];//PARAMETRO


if (isset($_GET['setor'])) {
    $setor =$_GET['setor'];//PARAMETRO
} else {
    $setor = "";//PARAMETRO
}

if (isset($_GET['data'])) {
    $data = $_GET['data'];//PARAMETRO
} else {
    $datadoServidor = date("Y-m-d");
    $data  = $datadoServidor;//PARAMETRO
}

/*
 * ----------------------Setores----------------------
 */

$nomeTabela = '_temp'.rand();


$query = "
SET SQL_SAFE_UPDATES = 0;
CREATE  TEMPORARY TABLE  Temp$nomeTabela
SELECT
	case
    when cl2.status = 1 or cl2.status = 3 then count(cl2.id)
    end as 'aguardando',
	case
    when cl2.status = 2 then count(cl2.id)
    end as 'atendimento',
	case
    when cl2.status = 4 then count(cl2.id)
    end as 'finalizado',
	case
    when cl2.status = 5 then count(cl2.id)    
    end as 'cancelado',
	cl2.servico,
    (select servico from servicos where id =cl2.servico ) as nome_servico
FROM
    checklist cl2
        INNER JOIN
    (SELECT 
        MAX(id) AS id
    FROM
            checklist
    WHERE
        DATE(hora_agendamento) = CURDATE()
    GROUP BY agendamento , etapa) cl1 ON cl1.id = cl2.id
GROUP BY servico , status;


CREATE  TEMPORARY TABLE  tempFinal$nomeTabela
select distinct nome_servico , servico as id_servico from Temp$nomeTabela ;


select * from Temp$nomeTabela;


CREATE  TEMPORARY TABLE  TempAguardando$nomeTabela
select aguardando  ,servico,nome_servico  from Temp$nomeTabela where aguardando is not null;


CREATE  TEMPORARY TABLE  TempAtendimento$nomeTabela
select atendimento  ,servico,nome_servico  from Temp$nomeTabela where atendimento is not null;



CREATE  TEMPORARY TABLE  TempFinalizado$nomeTabela
select finalizado  ,servico,nome_servico  from Temp$nomeTabela where finalizado is not null;



CREATE  TEMPORARY TABLE  TempCancelado$nomeTabela
select cancelado  ,servico,nome_servico  from Temp$nomeTabela where cancelado is not null;


 ALTER TABLE tempFinal$nomeTabela
       ADD aguardando_final varchar(30);

 ALTER TABLE tempFinal$nomeTabela
       ADD atendimento_final varchar(30);
       

 ALTER TABLE tempFinal$nomeTabela
       ADD cancelado_final varchar(30);      
   
 ALTER TABLE tempFinal$nomeTabela
       ADD finalizado_final  varchar(30);   






update tempFinal$nomeTabela
inner join TempFinalizado$nomeTabela on TempFinalizado$nomeTabela.servico = tempFinal$nomeTabela.id_servico
set tempFinal$nomeTabela.finalizado_final = TempFinalizado$nomeTabela.finalizado;



update tempFinal$nomeTabela
inner join TempAguardando$nomeTabela on TempAguardando$nomeTabela.servico = tempFinal$nomeTabela.id_servico
set tempFinal$nomeTabela.aguardando_final = TempAguardando$nomeTabela.aguardando;



update tempFinal$nomeTabela
inner join  TempAtendimento$nomeTabela on  TempAtendimento$nomeTabela.servico = tempFinal$nomeTabela.id_servico
set tempFinal$nomeTabela.atendimento_final =  TempAtendimento$nomeTabela.atendimento;



update tempFinal$nomeTabela
inner join  TempCancelado$nomeTabela on  TempCancelado$nomeTabela .servico = tempFinal$nomeTabela.id_servico
set tempFinal$nomeTabela.cancelado_final =  TempCancelado$nomeTabela.cancelado;
";





                    $conexao->query($query);
                    

/*
 * ----------------------Comparação para gerar o json----------------------
 */

$select = "select id,servico,aguardando_final,atendimento_final,cancelado_final,finalizado_final
                from tempFinal$nomeTabela
                right join servicos on servicos.id =  tempFinal$nomeTabela.id_servico"; 


comparação( $conexao, $select); //chama a função

function comparação($conexao, $select)
{
   geraJson($select, $conexao) ;
}

/*
 * ------------------------------------------------------------------------------
 */



 
//retorna e exibe o json
function geraJson($select, $conexao)
{
    $sql = $select;
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $novo = array();
    foreach ($result as $key => $value) {
        foreach ($value as $k => $v) {
            $novo[$key][$k] = $v;
        }
    }
    $json = json_encode($novo);
    echo $json;
}
