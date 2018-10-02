﻿<?php

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

    $lista_dos_setores = "SELECT id, servico AS setor FROM servicos order by servico";//lista de serviços

/*
 * --------Quantidade de pacientes por lista de agendados---------
 */

    $qtd_de_agendamentos_do_dia_por_agenda = "SELECT count(distinct(a.nome_paciente)) as qtd_paciente
                                                                                 FROM agendamento as a
                                                                                 INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
                                                                                 where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  '$data'  and codigo_servico = $setor";

/*
 * --------media de pacientes agendadados---------
 */


    $media_de_tempo_de_agendamento = "SELECT 
                                                                    time_format(sec_to_time(avg(tempo)), '%H:%i:%s') as tempo_medio
                                                                    from
                                                                    (SELECT
                                                                        cl_min.checkin,
                                                                        cl.checkout,
                                                                        time_to_sec(timediff(cl.checkout, cl_min.checkin)) as tempo
                                                                        FROM hcor.checklist cl
                                                                        left join status s 
                                                                        on s.id = cl.status
                                                                        left join (select min(id) as id, agendamento, etapa from checklist cl group by agendamento, etapa) cl2
                                                                        on cl2.agendamento = cl.agendamento and cl2.etapa = cl.etapa
                                                                        left join checklist cl_min
                                                                        on cl_min.id = cl2.id
                                                                        where cl.checkin is not null and 
                                                                        cl.checkout is not null and 
                                                                        s.tipo = 'Final' and
                                                                        cl.servico = $setor and	
                                                                        date(cl.checkin) = '$data') as checklist";
 

/*
 *-----------------Lista de Pacientes----------------
 */
 
    $lista_do_setor = "SELECT 
                                a.id_agendamento,
                                a.nome_paciente as paciente,
                                left(a.hora_servico_selecionado, 5) as hora, 
                                a.codigo_agenda as atividade,
                                a.ih_paciente as IH,
                                a.codigo_exame,
                                es.codigo_servico,
                                s.servico,
                                a.descricao_exame,
                                a.anotacao,
                                sexo_paciente as sexo,
                                data_nascimento,
                                nome_medico,
                                crm_medico as crm,
                                ch.checkin as checkin_unidade,
                                ch.checkout as checkout_unidade,
                                if( ch.checkout is null, timediff(now(), ch.checkin), null) as tempo_vinculado,
                                cl_min_c.checkin as checkin_exame,
                                cl_max_c.checkout as checkout_exame,
                                timediff(cl_max_c.checkout, cl_min_c.checkin) as tempo_exame,
                                if(cl_max_c.checkout, null, timediff(now(), cl_min_c.checkin)) as tempo_decorrido_do_exame,
                                cl_max_c.status,
                                st.descricao as desc_status,
                                if( ch.checkout is null, timediff(now(), cl_last.checkout), null) as tempo_espera,
                                se.nome as localizacao,
                                o.descricao as observacao
                                FROM agendamento as a 
                                left join exame_servico es 
                                on es.codigo_exame = a.codigo_exame
                                left join servicos s 
                                on s.id = es.codigo_servico	
                                left join (select max(id) as id, agendamento from checkin group by agendamento) ch2
                                on ch2.agendamento = a.id_agendamento
                                left join checkin ch 
                                on ch.id = ch2.id
                                left join (select min(id) as id, agendamento, etapa from checklist where (date(hora_agendamento) = '$data') group by agendamento, etapa) cl_min
                                on cl_min.agendamento = a.id_agendamento and cl_min.etapa = a.codigo_exame
                                left join checklist cl_min_c
                                on cl_min_c.id = cl_min.id
                                left join (select max(id) as id, agendamento, etapa from checklist where (date(hora_agendamento) = '$data') group by agendamento, etapa) cl_max
                                on cl_max.agendamento = a.id_agendamento and cl_max.etapa = a.codigo_exame
                                left join checklist cl_max_c
                                on cl_max_c.id = cl_max.id
                                left join (select max(checkout) as checkout, agendamento, etapa from checklist where (date(hora_agendamento) = '$data') group by agendamento) cl_last
                                on cl_last.agendamento = a.id_agendamento
                                LEFT JOIN (SELECT max(checkout) as checkout, id_vinculado from tracking_pacientes where fechado is null group by id_vinculado) tp1 
                                on tp1.id_vinculado = a.id_agendamento
                                LEFT JOIN tracking_pacientes tp 
                                on tp.checkout = tp1.checkout and tp.id_vinculado = tp1.id_vinculado
                                LEFT JOIN setores se
                                on se.id = tp.id_sala
                                LEFT JOIN status st 
                                on st.id = cl_max_c.status
                                LEFT JOIN observacoes o 
                                on o.id = cl_min_c.observacao
                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data' and
                                es.codigo_servico = $setor
                                order by hora";

/*
 *---------------------Procedimentos---------------------------
 */

$qtd_procedimentos = "SELECT count(a.nome_paciente) as qtd_procedimentos
                                        FROM agendamento as a
                                        INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame 
                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  '$data' and codigo_servico = $setor";




/*
 *--------------------Horario de Maior Fluxo-----------------------------
 */

$horario_de_maior_fluxo = "SELECT  qtd_por_hora, intervalo_de_horas  FROM (
                                                    SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                    COUNT(*) as qtd_por_hora
                                                    FROM agendamento as a
                                                    INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
                                                    where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and exs.codigo_servico = $setor
                                                    GROUP BY HOUR(intervalo_de_horas)	
                                                        ) as lista_geral_de_horas  where qtd_por_hora = ( 
                                                                SELECT  max(qtd_por_hora) as maior_qtd FROM(
                                                                        SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                                        COUNT(*) as qtd_por_hora
                                                                        FROM agendamento as a
                                                                        INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
                                                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and exs.codigo_servico = $setor
                                                                        GROUP BY HOUR(intervalo_de_horas)
                                                                ) as maior_valor  
                                                                
                                                                )";//intervalo com maior fluxo de pessoas no setor


/* ------------------------ Consolidado ----------------------------- */


$total_de_pacientes_de_todos_os_setores = "SELECT count(distinct(nome_paciente)) AS totaldePacientes FROM agendamento 
                                                                         WHERE STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE()";


$total_de_procedimentos_de_todos_os_setores = "SELECT COUNT(nome_paciente) AS total_procedimento FROM agendamento 
                                                                                 WHERE STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE()";




$cards_com_dados_setores = "SELECT 
                                                a.id_agendamento,
                                                a.nome_paciente as paciente,
                                                left(a.hora_servico_selecionado, 5) as hora, 
                                                a.codigo_agenda as atividade,
                                                a.ih_paciente as IH,
                                                a.codigo_exame,
                                                es.codigo_servico,
                                                s.servico,
                                                a.descricao_exame,
                                                a.anotacao,
                                                sexo_paciente as sexo,
                                                data_nascimento,
                                                nome_medico,
                                                crm_medico as crm,
                                                ch.checkin as checkin_unidade,
                                                ch.checkout as checkout_unidade,
                                                if( ch.checkout is null, timediff(now(), ch.checkin), null) as tempo_vinculado,
                                                cl_min_c.checkin as checkin_exame,
                                                cl_max_c.checkout as checkout_exame,
                                                timediff(cl_max_c.checkout, cl_min_c.checkin) as tempo_exame,
                                                if(cl_max_c.checkout, null, timediff(now(), cl_min_c.checkin)) as tempo_decorrido_do_exame,
                                                cl_max_c.status,
                                                st.descricao as desc_status,
                                                if( ch.checkout is null, timediff(now(), cl_last.checkout), null) as tempo_espera,
                                                se.nome as localizacao
                                                FROM agendamento as a 
                                                left join exame_servico es 
                                                on es.codigo_exame = a.codigo_exame
                                                left join servicos s 
                                                on s.id = es.codigo_servico	
                                                left join checkin ch 
                                                on ch.agendamento = a.id_agendamento
                                                left join (select min(id) as id, agendamento, etapa from checklist where (date(hora_agendamento) = curdate()) group by agendamento, etapa) cl_min
                                                on cl_min.agendamento = a.id_agendamento and cl_min.etapa = a.codigo_exame
                                                left join checklist cl_min_c
                                                on cl_min_c.id = cl_min.id
                                                left join (select max(id) as id, agendamento, etapa from checklist where (date(hora_agendamento) = curdate()) group by agendamento, etapa) cl_max
                                                on cl_max.agendamento = a.id_agendamento and cl_max.etapa = a.codigo_exame
                                                left join checklist cl_max_c
                                                on cl_max_c.id = cl_max.id
                                                left join (select max(checkout) as checkout, agendamento, etapa from checklist where (date(hora_agendamento) = curdate()) group by agendamento) cl_last
                                                on cl_last.agendamento = a.id_agendamento
                                                LEFT JOIN (SELECT max(checkout) as checkout, id_vinculado from tracking_pacientes where fechado is null group by id_vinculado) tp1 
                                                on tp1.id_vinculado = a.id_agendamento
                                                LEFT JOIN tracking_pacientes tp 
                                                on tp.checkout = tp1.checkout and tp.id_vinculado = tp1.id_vinculado
                                                LEFT JOIN setores se
                                                on se.id = tp.id_sala
                                                LEFT JOIN status st 
                                                on st.id = cl_max_c.status
                                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = curdate() and
                                                es.codigo_servico = $setor
                                                order by hora";

                                                


/*
 *--------------------Checkin e Checkout-----------------------------
 */

$chekin_e_checkout = "SELECT 
                                    count(checkin) as checkin,
                                    count(checkout) as checkout
                                    from checkin
                                    where date(checkin) = curdate()";
/*
 *--------------------Status Consolidado-----------------------------
 */

$status_consolidado = "SELECT 
                                            count(if(cl.status = 1, 1, null)) as aguardando,
                                            count(if(cl.status = 2, 1, null)) as andamento,
                                            count(if(cl.status = 3, 1, null)) as cancelado,
                                            count(if(cl.status = 4, 1, null)) as finalizado
                                            from checklist cl
                                            inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
                                            on cl2.id = cl.id
                                            where date(cl.checkin) = curdate()";

 /*
 *--------------------Status por setor-----------------------------
 */


$status_consolidado_por_setor = "SELECT 
                                            count(if(cl.status = 1, 1, null)) as aguardando,
                                            count(if(cl.status = 2, 1, null)) as andamento,
                                            count(if(cl.status = 3, 1, null)) as cancelado,
                                            count(if(cl.status = 4, 1, null)) as finalizado
                                            from checklist cl
                                            inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
                                            on cl2.id = cl.id
                                            where date(cl.checkin) = curdate() and
                                        cl.servico = $setor";
/*
 *--------------------Status por setor-----------------------------
 */


$card_com_informacoes_do_setores = "SELECT exs.codigo_servico as id, s.servico as setor ,count(distinct(a.nome_paciente)) as agendamento_do_dia, count(a.nome_paciente) as exames FROM agendamento as a
                                                                INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
                                                                inner join servicos as s on exs.codigo_servico = s.id
                                                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() group by(exs.codigo_servico);;";



$informacoes_com_quantidade_nos_card = "SELECT codigo_servico_atual ,cod_cor_status , count(cod_cor_status) as qtd FROM agendamento as a 
                                                                        INNER JOIN servicos as s on a.codigo_servico_atual = s.id
                                                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() group by codigo_servico_atual, cod_cor_status";
/*
 *--------------------Quandade de status da unidade-----------------------------
 */

if (isset($_GET['status'])) {
    $status = $_GET['status'];//PARAMETRO
} else {
    $status = 0;
}


 $qtd_de_status_todas_os_setores_por_procedimento = "select count(cod_cor_status) as status_por_procedimentos from (
                                                                                                SELECT
                                                                                                a.nome_paciente as paciente,
                                                                                                a.servico_atual,
                                                                                                s.servico as setor,
                                                                                                a.cod_cor_status
                                                                                                FROM agendamento as a INNER JOIN servicos as s on a.codigo_servico_atual = s.id
                                                                                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() and  cod_cor_status = $status
                                                                                            ) as contagemDePacientes";



/*
 *--------------------Quandade de status da unidade-----------------------------
 */


$qtd_por_horario_de_procedimento = " SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                                COUNT(*) as Qtd
                                                                FROM agendamento as a
                                                                INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
                                                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and exs.codigo_servico = $setor
                                                                GROUP BY HOUR(intervalo_de_horas)";

$qtd_por_horario_de_pacientes = "SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                        COUNT(distinct(nome_paciente)) as Qtd
                                                        FROM agendamento as a
                                                        INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
                                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and exs.codigo_servico = $setor
                                                        GROUP BY HOUR(intervalo_de_horas)";

/*
 *--------------------Quandade unidade-----------------------------
 */


 


/*
 * ----------------------Comparação para gerar o json----------------------
 */

$select = $$parametro; //transforma o parametro em uma variavel

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
/*
 * ------------------------------------------------------------------------------
 */
