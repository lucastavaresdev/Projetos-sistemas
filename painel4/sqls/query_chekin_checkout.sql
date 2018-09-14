select 
	count(if(cl.status = 1, 1, null)) as aguardando,
    count(if(cl.status = 2, 1, null)) as andamento,
    count(if(cl.status = 3, 1, null)) as cancelado,
    count(if(cl.status = 4, 1, null)) as finalizado
    from checklist cl
    inner join (select max(id) as id, agendamento, etapa from checklist group by agendamento, etapa) cl2
    on cl2.id = cl.id
where date(cl.checkin) = curdate();