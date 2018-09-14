SELECT data_servico_atual FROM agendamento order by date_format(data_servico_atual,'%Y%m%d');

ORDER BY DATE_FORMAT(Date, '%Y%m%d') DESC 

SELECT DATE_FORMAT(data_servico_atual, '%Y-%m-%d') as data FROM agendamento;

SELECT  count(STR_TO_DATE(data_servico_atual, '%d/%m/%Y')) as agendados_do_dia
FROM agendamento;

SELECT data_servico_atual
FROM agendamento where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() ;


SELECT distinct(nome_paciente) , data_servico_atual
FROM agendamento where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() ;


SELECT distinct(nome_paciente) as nome, count(data_servico_atual)
FROM agendamento where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE();

SELECT count(distinct(nome_paciente)) as agendamento_do_dia
FROM agendamento where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE();

