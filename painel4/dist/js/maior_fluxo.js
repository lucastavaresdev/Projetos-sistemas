function intervaloprocedimento(e){var a=document.getElementById("qtd_por_horario_de_procedimento");if(a)for(i=0;i<e.length;i++){var t=document.createElement("tr"),n="<td>"+e[i].intervalo_de_horas+"</td><td><b>"+e[i].Qtd+"</b></td>",r=t.innerHTML=n;a.innerHTML+=r}}function intervalopaciente(e){var a=document.getElementById("qtd_por_horario_de_pacientes");if(a)for(i=0;i<e.length;i++){var t=document.createElement("tr"),n="<td>"+e[i].intervalo_de_horas+"</td><td><b>"+e[i].Qtd+"</b></td>",r=t.innerHTML=n;a.innerHTML+=r}}function data_table(){$(document).ready(function(){$("#tabela_pacientes").DataTable({language:{lengthMenu:" Quantidade por Pagina _MENU_  ",zeroRecords:"Não encontrado pacientes",info:"Total de Pagina _PAGE_ de _PAGES_",infoEmpty:" ",infoFiltered:"(filtered from _MAX_ total records)",search:"Filtrar:",paginate:{first:" ",next:"Proxima",previous:"Anterior",last:" "}}})})}var url_atual=window.location.href,parametrosDaUrl=url_atual.split("?")[1];chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_procedimento&${parametrosDaUrl}`,intervaloprocedimento),chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_pacientes&${parametrosDaUrl}`,intervalopaciente),setInterval(function(){!function(){var e=window.location.href.split("?")[1];chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_procedimento&${e}`,intervaloprocedimento),chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_pacientes&${e}`,intervalopaciente)}()},3e5);