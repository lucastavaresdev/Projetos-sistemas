SELECT  
	exs.codigo_servico as setor,
    count(distinct(a.nome_paciente)) as qtd_pacientes_agendados,
    count(a.nome_paciente)  as qtd_procedimentos,
    count(c.agendamento)
from agendamento as a 
INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
left JOIN checkin as c on a.id_agendamento = c.agendamento
where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE() group by(exs.codigo_servico)


SELECT * FROM hcor.agendados;