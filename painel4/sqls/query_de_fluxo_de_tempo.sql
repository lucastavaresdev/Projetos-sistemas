SELECT  qtd_por_hora, intervalo_de_horas  FROM (
    SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+1, ':00') as intervalo_de_horas, 
    COUNT(*) as qtd_por_hora
    FROM agendamento as a
    INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
    where STR_TO_DATE (data_servico_atual, '%d/%m/%Y') =  curdate() and codigo_servico = 227
    GROUP BY HOUR(intervalo_de_horas)
              ) as lista_geral_de_horas  where qtd_por_hora = ( 
					 
                     SELECT  max(qtd_por_hora) as maior_qtd FROM(
							 SELECT  CONCAT(HOUR(a.hora_servico_selecionado), ':00-', HOUR(a.hora_servico_selecionado)+1, ':00') as intervalo_de_horas, 
							 COUNT(*) as qtd_por_hora
							 FROM agendamento as a
							 INNER JOIN exame_servico as exs on a.codigo_exame = exs.codigo_exame
							 where STR_TO_DATE (data_servico_atual, '%d/%m/%Y') =  curdate() and codigo_servico = 227
							 GROUP BY HOUR(intervalo_de_horas)
					) as maior_valor

 );




SELECT  qtd_por_hora, intervalo_de_horas  FROM (
    SELECT  CONCAT(HOUR(hora_servico_selecionado), ':00-', HOUR(hora_servico_selecionado)+1, ':00') as intervalo_de_horas, 
    COUNT(*) as qtd_por_hora
    FROM agendamento
    where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data' and codigo_servico_atual = '$setor'
    GROUP BY HOUR(intervalo_de_horas) 
              ) as lista_geral_de_horas  where qtd_por_hora = ( 
                SELECT  max(qtd_por_hora) as maior_qtd FROM(
                          SELECT  CONCAT(HOUR(hora_servico_selecionado), ':00-', HOUR(hora_servico_selecionado)+2, ':00') as intervalo_de_horas, 
                          COUNT(*) as qtd_por_hora
                          FROM agendamento
                          where STR_TO_DATE(data_servico_atual, '%d/%m/%Y') = '$data' and codigo_servico_atual = '$setor'
                          GROUP BY HOUR(intervalo_de_horas)
                          ) as maior_valor
              );