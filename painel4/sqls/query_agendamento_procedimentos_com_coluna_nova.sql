SELECT codigo_exame  FROM hcor.exame_servico;
SELECT codigo_exame  FROM hcor.agendamento;


SELECT count(a.nome_paciente) as qtd_procedimentos
FROM agendamento as a
INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  '2018-08-30' and codigo_servico = 226;
















SELECT column_name(s)
FROM table1
INNER JOIN table2 ON table1.column_name = table2.column_name;



SELECT count(distinct(nome_paciente)) as qtd_paciente FROM agendamento where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  '2018-08-30' and codigo_servico_atual = 226