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

    $lista_dos_setores = "SELECT id, servico AS setor FROM servicos order by servico";//lista de serviços

/*
 * --------Quantidade de pacientes por lista de agendados---------
 */

    $qtd_de_agendamentos_do_dia_por_agenda = "SELECT count(distinct(a.nome_paciente)) as qtd_paciente
                                                                                 FROM agendamento as a
                                                                                 INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
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
    o.descricao as observacao,
    cl_min_c.hora_agendamento,
    (SELECT s.servico FROM checklist where agendamento = a.id_agendamento and checkin is null order by hora_agendamento asc limit 1) as proximo_exame
    FROM agendamento as a 
    left join exame_servico es 
    on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
    left join servicos s 
    on s.id = es.codigo_servico	
    left join (select max(id) as id, agendamento from checkin group by agendamento) ch2
    on ch2.agendamento = a.id_agendamento
    left join checkin ch 
    on ch.id = ch2.id
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
    LEFT JOIN observacoes o 
    on o.id = cl_min_c.observacao
    left join (select * from checklist where (date(hora_agendamento) ) = curdate() group by agendamento, etapa order by hora_agendamento limit 1) ck_prox
    on ck_prox.agendamento = a.id_agendamento and timediff(ck_prox.hora_agendamento, cl_min_c.hora_agendamento) > 0
    where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  '$data' and
    es.codigo_servico = $setor
    order by hora";
/*
 *---------------------Procedimentos---------------------------
 */

$qtd_procedimentos = "SELECT count(a.nome_paciente) as qtd_procedimentos
                                        FROM agendamento as a
                                        INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data' and codigo_servico = $setor";




/*
 *--------------------Horario de Maior Fluxo-----------------------------
 */

$horario_de_maior_fluxo = "SELECT  qtd_por_hora, intervalo_de_horas  FROM (
                                                    SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                    COUNT(*) as qtd_por_hora
                                                    FROM agendamento as a
                                                    INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
                                                    where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and es.codigo_servico = $setor
                                                    GROUP BY HOUR(intervalo_de_horas)	
                                                        ) as lista_geral_de_horas  where qtd_por_hora = ( 
                                                                SELECT  max(qtd_por_hora) as maior_qtd FROM(
                                                                        SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                                        COUNT(*) as qtd_por_hora
                                                                        FROM agendamento as a
                                                                        INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
                                                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and es.codigo_servico = $setor
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
                                                on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
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
        count(if(cl.status = 1 or cl.status = 3, 1, null)) as aguardando,
        count(if(cl.status = 2, 1, null)) as andamento,
        count(if(cl.status = 4, 1, null)) as finalizado,
        count(if(cl.status = 5, 1, null)) as cancelado
        from checklist cl
        inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
        on cl2.id = cl.id
        where date(cl.checkin) = curdate()";

 /*
 *--------------------Status por setor-----------------------------
 */

$status_consolidado_por_setor = "SELECT 
                                            count(if(cl.status = 1 or cl.status = 3, 1, null)) as aguardando,
                                            count(if(cl.status = 2, 1, null)) as andamento,                                            
                                            count(if(cl.status = 4, 1, null)) as finalizado,
                                            count(if(cl.status = 5, 1, null)) as cancelado
                                            from checklist cl
                                            inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
                                            on cl2.id = cl.id
                                            where date(cl.checkin) = curdate() and
                                        cl.servico = $setor";
/*
 *--------------------Status por setor-----------------------------
 */

$card_com_informacoes_do_setores = "SELECT es.codigo_servico as id, s.servico as setor ,count(distinct(a.nome_paciente)) as agendamento_do_dia, count(a.nome_paciente) as exames FROM agendamento as a
                                                                INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
                                                                inner join servicos as s on es.codigo_servico = s.id
                                                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() group by(es.codigo_servico);";

$informacoes_com_quantidade_nos_card = "SELECT count(checklist.id) as Qt_exames,
                                                                        status,
                                                                        servicos.servico ,
                                                                        servicos.id ,
                                                                        CASE 
                                                                            WHEN status = 1 THEN 'Arguadando'
                                                                            WHEN status = 2 THEN 'Cancelado'
                                                                            WHEN status = 3 THEN 'Arguadando'
                                                                            WHEN status = 4 THEN 'Em Atendimento'
                                                                            WHEN status = 5 THEN 'Cancelado'
                                                                            ELSE '' END AS 'Status_nome'
                                                                        FROM hcor.checklist 
                                                                        inner join servicos on servicos.id = checklist.servico
                                                                        where  date(hora_agendamento) = curdate()
                                                                        group by servico,status;";



/*
 *--------------------Quandade de status da unidade-----------------------------
 */

if (isset($_GET['status'])) {
    $status = $_GET['status'];//PARAMETRO
} else {
    $status = 0;
}


 $qtd_de_status_todas_os_setores_por_procedimento = "SELECT count(cod_cor_status) as status_por_procedimentos from (
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
                                                                INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
                                                                where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and es.codigo_servico = $setor
                                                                GROUP BY HOUR(intervalo_de_horas)";

$qtd_por_horario_de_pacientes = "SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+ 1 , ':00') as intervalo_de_horas, 
                                                        COUNT(distinct(nome_paciente)) as Qtd
                                                        FROM agendamento as a
                                                        INNER JOIN exame_servico as es on es.codigo_exame = a.codigo_exame or (a.codigo_exame REGEXP '[0-9]' = 0 and es.codigo_servico = 232)
                                                        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data'  and es.codigo_servico = $setor
                                                        GROUP BY HOUR(intervalo_de_horas)";


/*
 *--------------------Relatorios-----------------------------
 *----------- Relatório de Paciente Ativos -----------
 */


$relatorio_de_paciente_ativos = 'SELECT
                                                    distinct(a.id_agendamento) as atendimento,
                                                    a.ih_paciente ,
                                                    a.nome_paciente as paciente,
                                                    a.sexo_paciente as sexo,
                                                    a.nome_medico ,
                                                    a.data_agendamento,
													tp.id_sala as sala_id,
                                                    (SELECT nome FROM  setores where id = sala_id )  as nome_setor,
                                                    (SELECT ds_etapa FROM  checklist where  agendamento = atendimento order by checkin desc limit 1) as exame,
                                                    (SELECT abrev_etapa FROM  checklist where   agendamento = atendimento order by checkin desc limit 1) as cod_exame,
                                                    (SELECT status FROM  checklist where agendamento = atendimento  order by checkin desc limit 1) as status_final,
                                                    timediff(tp.checkout, tp.checkin) as tempo
                                                    FROM agendamento a
                                                    left join checklist c
                                                    on c.agendamento = a.id_agendamento
                                                    left join agendamento cu
                                                    on cu.id_agendamento = c.tipo_checkup
                                                    left join checkin ch
                                                    on ch.agendamento = a.id_agendamento
                                                    left join (select max(checkin) as checkin, id, id_vinculado, categoria from tracking_pacientes group by id_vinculado) tp2
                                                    on tp2.id_vinculado = a.id_agendamento and tp2.categoria = "Paciente"
                                                    left join tracking_pacientes tp
                                                    on tp.checkin = tp2.checkin and tp.id_vinculado = tp2.id_vinculado
                                                    left join setores s 
                                                    on s.id = tp.id_sala
                                                    inner join beacons b
                                                    on b.id_vinculado = a.id_agendamento
                                                    where date(a.data_agendamento)  = curdate()  and  s.nome is not null and  
                                                    a.nome_paciente like "%%"
                                                    group by a.id_agendamento
                                                    order by a.nome_paciente asc';
 


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
