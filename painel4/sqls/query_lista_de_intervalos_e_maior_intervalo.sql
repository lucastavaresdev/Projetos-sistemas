SELECT count(hora_servico_selecionado) as maior_periodo
FROM agendamento where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE()
and TIME(hora_servico_selecionado) BETWEEN time('9:00:00') AND TIME('9:59:00'); 


SELECT * FROM hcor.agendamento;


//lista de intervalos
SELECT  CONCAT(HOUR(hora_servico_selecionado), ':00-', HOUR(hora_servico_selecionado)+1, ':00')  intervalo_de_horas, COUNT(*) as `usage`
FROM agendamento
where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') =  CURDATE()
GROUP BY HOUR(hora_servico_selecionado)

//maior intervalo em 2h
SELECT intervalo_de_horas ,qtd_por_hora FROM(
	SELECT  CONCAT(HOUR(hora_servico_selecionado), ':00-', HOUR(hora_servico_selecionado)+2, ':00')  intervalo_de_horas, 
	COUNT(*) as qtd_por_hora
	FROM agendamento
	where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = CURDATE()
	GROUP BY HOUR(hora_servico_selecionado)
) as c order by qtd_por_hora desc limit 1;


