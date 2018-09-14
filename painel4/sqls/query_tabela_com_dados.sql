SELECT servico as setor FROM servicos;
SELECT * FROM hcor.agendamento;

//com cod do setor
SELECT distinct(a.nome_paciente) , a.data_servico_atual, a.codigo_servico_atual, s.servico
FROM agendamento as a INNER JOIN servicos as s on a.codigo_servico_atual = s.id
where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() order by  servico;

//sem cod

SELECT 
distinct(a.nome_paciente) as paciente,
a.hora_servico_selecionado as hora,
a.codigo_agenda as atividade,
a.ih_paciente as IH,
a.servico_atual,
s.servico as setor,
a.proximo_servico,
a.cod_cor_status
FROM agendamento as a INNER JOIN servicos as s on a.codigo_servico_atual = s.id
where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() order by  servico and servico_atual;





SELECT column_name(s)
FROM table1
INNER JOIN table2 ON table1.column_name = table2.column_name;