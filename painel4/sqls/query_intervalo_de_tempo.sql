Quantidade por periodo

SELECT  intervalo_de_horas , qtd_por_hora FROM(
        SELECT  CONCAT(HOUR(hora_servico_selecionado), ':00-', HOUR(hora_servico_selecionado)+2, ':00') as intervalo_de_horas, 
        COUNT(*) as qtd_por_hora
        FROM agendamento
        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = CURDATE() and codigo_servico_atual = '298'
        GROUP BY HOUR(intervalo_de_horas) 
) as c order by qtd_por_hora desc ;





SELECT  qtd_por_hora, intervalo_de_horas  FROM(
        SELECT  CONCAT(HOUR(hora_servico_selecionado), ':00-', HOUR(hora_servico_selecionado)+1, ':00') as intervalo_de_horas, 
        COUNT(*) as qtd_por_hora
        FROM agendamento
        where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = CURDATE() and codigo_servico_atual = '298'
        GROUP BY HOUR(intervalo_de_horas) 
) as c 



