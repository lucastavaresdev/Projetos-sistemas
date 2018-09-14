<?php

require('./conexao.php');// REQUSIÇÃO DO BANCO

$parametro =$_GET['parametro'];//PARAMETRO


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
                    CREATE TEMPORARY TABLE selectGrid1$nomeTabela
                    SELECT agendamento as id_agendamento,etapa as id_exame FROM hcor.checklist group by agendamento,etapa;
                    
                    ALTER TABLE selectGrid1$nomeTabela
                    ADD statusUltimoExame varchar(30);

                    CREATE TEMPORARY TABLE tableStatusExame$nomeTabela
                    select agendamento,etapa,status,checkin   FROM hcor.checklist 
                    order by checkin desc
                    limit 1 ;

                    UPDATE selectGrid1$nomeTabela
                    INNER JOIN tableStatusExame$nomeTabela 
                    ON tableStatusExame$nomeTabela.agendamento = selectGrid1$nomeTabela.id_agendamento and selectGrid1$nomeTabela.id_exame = tableStatusExame$nomeTabela.etapa
                    SET selectGrid1$nomeTabela.statusUltimoExame = tableStatusExame$nomeTabela.status;


                    CREATE TEMPORARY TABLE selectGrid2$nomeTabela
                    select distinct  selectGrid1$nomeTabela.id_agendamento as agendamentoFinal,
                        servico_chamada_itech as servico
                    from selectGrid1$nomeTabela
                    inner join agendamento on selectGrid1$nomeTabela.id_agendamento = agendamento.id_agendamento;
                    
                    ALTER TABLE selectGrid2$nomeTabela
                    ADD aguardando varchar(30);

                    ALTER TABLE selectGrid2$nomeTabela
                    ADD cancelado varchar(30);
                    
                    ALTER TABLE selectGrid2$nomeTabela
                    ADD finalizado varchar(30);
                    
                    ALTER TABLE selectGrid2$nomeTabela
                    ADD atendimento varchar(30); 
                    
                    
                    CREATE TEMPORARY TABLE aguardando$nomeTabela
                    select count(statusUltimoExame) as qtAguardando,id_agendamento from selectGrid1$nomeTabela where statusUltimoExame=1;

                    CREATE TEMPORARY TABLE cancelado$nomeTabela
                    select count(statusUltimoExame) as qtCancelado,id_agendamento from selectGrid1$nomeTabela where statusUltimoExame=3;

                    CREATE TEMPORARY TABLE finalizado$nomeTabela
                    select count(statusUltimoExame) as qtfinalizado,id_agendamento from selectGrid1$nomeTabela where statusUltimoExame=4;

                    CREATE TEMPORARY TABLE atendimento$nomeTabela
                    select count(statusUltimoExame) as qtAtendimento,id_agendamento from selectGrid1$nomeTabela where statusUltimoExame=2;


                    UPDATE selectGrid2$nomeTabela
                    INNER JOIN aguardando$nomeTabela ON aguardando$nomeTabela.id_agendamento = selectGrid2$nomeTabela.agendamentoFinal
                    SET selectGrid2$nomeTabela.aguardando = aguardando$nomeTabela.qtAguardando;

                    UPDATE selectGrid2$nomeTabela
                    INNER JOIN finalizado$nomeTabela ON finalizado$nomeTabela.id_agendamento = selectGrid2$nomeTabela.agendamentoFinal
                    SET selectGrid2$nomeTabela.cancelado = finalizado$nomeTabela.qtfinalizado;


                    UPDATE selectGrid2$nomeTabela
                    INNER JOIN cancelado$nomeTabela ON cancelado$nomeTabela.id_agendamento = selectGrid2$nomeTabela.agendamentoFinal
                    SET selectGrid2$nomeTabela.cancelado = cancelado$nomeTabela.qtCancelado;


                    UPDATE selectGrid2$nomeTabela
                    INNER JOIN atendimento$nomeTabela ON atendimento$nomeTabela.id_agendamento = selectGrid2$nomeTabela.agendamentoFinal
                    SET selectGrid2$nomeTabela.atendimento = atendimento$nomeTabela.qtAtendimento;
                    ";

                    $conexao->query($query);
                    
                   "select sum(aguardando)as somatorio_aguardando,
                        sum(cancelado)as somatorio_cancelamento,
                        sum(finalizado)as somatorio_finalizado,
                        sum(atendimento)as somatorio_atendimento,
                        servicos.servico as setor,
                        servicos.id as id_setor
                    from selectGrid2$nomeTabela
                    right join servicos on servicos.id = selectGrid2$nomeTabela.servico
                    group by servicos.id";


                    // $file = fopen("query.txt", 'a+');
                    // fwrite($file, $query);
                    // fclose($file);

/*
 * ----------------------Comparação para gerar o json----------------------
 */

$select = "select sum(aguardando)as somatorio_aguardando,
                sum(cancelado)as somatorio_cancelamento,
                sum(finalizado)as somatorio_finalizado,
                sum(atendimento)as somatorio_atendimento,
                servicos.servico as setor,
                servicos.id as id_setor
                from selectGrid2$nomeTabela
                right join servicos on servicos.id = selectGrid2$nomeTabela.servico
                group by servicos.id"; //transforma o parametro em uma variavel

comparação($parametro, $conexao, $select); //chama a função

function comparação($parametro, $conexao, $select)
{
    $parametro == $parametro ? geraJson($select, $conexao) : var_dump("Erro de paramentro");
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
