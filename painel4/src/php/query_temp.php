<?php

  try{

	
    $conexao = new PDO("mysql:host=itechbd.mysql.database.azure.com;dbname=hcor", "itechflow@itechbd", "Itechm@ster_2018"); 
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
                SELECT count(checklist.id) as Qt_exames,
                status,
                servicos.servico ,
                servicos.id ,
                CASE 
                    WHEN status = 1 or status = 3 THEN 'Aguardando'
                    WHEN status = 2 THEN 'Em Atendimento'
                    WHEN status = 4 THEN 'Finalizado'
                    WHEN status = 5 THEN 'Cancelado'
                    ELSE '' END AS 'Status_nome'
                FROM hcor.checklist 
                inner join servicos on servicos.id = checklist.servico
                where  date(hora_agendamento) = curdate()
                group by servico,status;


                CREATE  TEMPORARY TABLE  tempFinal$nomeTabela
                select servico as servico_nome,id as id_servico from Temp$nomeTabela ;


                CREATE  TEMPORARY TABLE  TempAguardando$nomeTabela
                select qt_exames as qt_Aguardando,servico,id from Temp$nomeTabela where status_nome='Aguardando';

                CREATE  TEMPORARY TABLE  TempAtendimento$nomeTabela
                select qt_exames as qt_Atendimento,servico,id from Temp$nomeTabela where status_nome='Em Atendimento';



                CREATE  TEMPORARY TABLE  TempFinalizado$nomeTabela
                select qt_exames as qt_Finalizados,servico,id from Temp$nomeTabela where status_nome='Finalizado';

                CREATE  TEMPORARY TABLE  TempCancelado$nomeTabela
                select qt_exames as qt_Cancelado,servico,id from Temp$nomeTabela where status_nome='Cancelado';





                ALTER TABLE tempFinal$nomeTabela
                    ADD aguardando varchar(30);

                ALTER TABLE tempFinal$nomeTabela
                    ADD atendimento varchar(30);
                    

                ALTER TABLE tempFinal$nomeTabela
                    ADD cancelado varchar(30);      
                
                ALTER TABLE tempFinal$nomeTabela
                    ADD finalizado varchar(30);   
                    
                    



                update tempFinal$nomeTabela
                inner join TempFinalizado$nomeTabela on TempFinalizado$nomeTabela.id = tempFinal$nomeTabela.id_servico
                set tempFinal$nomeTabela.finalizado = TempFinalizado$nomeTabela.qt_Finalizados;



                update tempFinal$nomeTabela
                inner join TempCancelado$nomeTabela on TempCancelado$nomeTabela.id = tempFinal$nomeTabela.id_servico
                set tempFinal$nomeTabela.cancelado = TempCancelado$nomeTabela.qt_Cancelado;



                update tempFinal$nomeTabela
                inner join TempAguardando$nomeTabela on TempAguardando$nomeTabela.id = tempFinal$nomeTabela.id_servico
                set tempFinal$nomeTabela.aguardando = TempAguardando$nomeTabela.qt_Aguardando;


                update tempFinal$nomeTabela
                inner join TempAtendimento$nomeTabela on TempAtendimento$nomeTabela.id = tempFinal$nomeTabela.id_servico
                set tempFinal$nomeTabela.atendimento = TempAtendimento$nomeTabela.qt_Atendimento;


                INSERT INTO tempFinal$nomeTabela (servico_nome,id_servico)
                SELECT servicos.servico,id from servicos 
 ";

                    $conexao->query($query);
                    

/*
 * ----------------------Comparação para gerar o json----------------------
 */

$select = " select  distinct * from tempFinal$nomeTabela;"; //transforma o parametro em uma variavel


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
