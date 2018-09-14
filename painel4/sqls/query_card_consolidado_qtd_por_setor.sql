 select 
	count(if(cl.status = 1, 1, null)) as aguardando,
    count(if(cl.status = 2, 1, null)) as andamento,
    count(if(cl.status = 3, 1, null)) as cancelado,
    count(if(cl.status = 4, 1, null)) as concluido
    from checklist cl
    inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
    on cl2.id = cl.id
	where date(cl.checkin) = curdate() and
cl.servico = 226;
                     
                                        
    
SELECT exs.codigo_servico as id, s.servico as setor ,count(distinct(a.nome_paciente)) as agendamento_do_dia, count(a.nome_paciente) as exames FROM agendamento as a
       INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
       inner join servicos as s on exs.codigo_servico = s.id
where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() group by(exs.codigo_servico)  and exs.codigo_servico in (
 select 
	cl.servico,
	count(if(cl.status = 1, 1, null)) as aguardando,
    count(if(cl.status = 2, 1, null)) as andamento,
    count(if(cl.status = 3, 1, null)) as cancelado,
    count(if(cl.status = 4, 1, null)) as concluido
    from checklist cl
    inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
    on cl2.id = cl.id
	where date(cl.checkin) = curdate())
                   