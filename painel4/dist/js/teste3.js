function lista_de_pacientes(e){var t=document.getElementById("listadePacientes");if(t){for(i=0;i<e.length;i++){var a=document.createElement("tr"),o="<td>"+e[i].hora+"</td><td>"+e[i].atividade+"</td><td>"+e[i].IH+"</td><td>"+e[i].paciente+"</td><td> - </td><td>"+e[i].servico_atual+"</td><td>"+e[i].proximo_servico+"</td>"+`<td><div  class=" status-${e[i].cod_cor_status} center-status">${e[i].cod_cor_status}</div></td>`+"<td> - </td>",n=a.innerHTML=o;t.innerHTML+=n}data_table()}}function data_table(){$(document).ready(function(){$("#tabela_pacientes").DataTable({pagingType:"full_numbers",language:{lengthMenu:" Quantidade por Pagina _MENU_  ",zeroRecords:"Não encontrado pacientes",info:"Total de Pagina _PAGE_ de _PAGES_",infoEmpty:" ",infoFiltered:"(filtered from _MAX_ total records)",search:"Filtrar:",paginate:{first:" ",next:"Proxima",previous:"Anterior",last:" "}}})})}function horarioComMaiorPacientes(e){var t=document.getElementById("fluxo"),a=" ";if(t){for(i=0;i<e.length;i++){a+=`<li>${e[i].intervalo_de_horas} <span> (${e[i].qtd_por_hora} pacientes)</span></li>`}0===e.length?(t.innerHTML="Não ha paciente",t.classList.add("p-msg")):1===e.length?(atribuiHtml(t,a),t.classList.add("fluxo-1")):2===e.length?(atribuiHtml(t,a),t.classList.add("fluxo-2")):(t.innerHTML="Ver Lista de Pacientes",t.classList.add("p-msg"))}}function atribuiHtml(e,t){e.innerHTML=t}function alteraTitulodoSetor(e){var t=document.getElementById("titulo_do_setor"),a=document.getElementById("aba_nome_setor"),o=window.location.href.split("=")[1];for(i=0;i<e.length;i++){if(id_do_setor_banco=e[i].id,o===id_do_setor_banco){var n=e[i].setor;return void(a&&(t.innerHTML=n,a.innerHTML=n))}a?(t.innerHTML="-",a.innerHTML="-"):t.innerHTML="-"}}function lista_de_setores(e){var t=document.getElementById("setores_lista");for(i=0;i<e.length;i++){var a=document.createElement("li"),o=document.createElement("a");o.textContent=e[i].setor,a.setAttribute("class","dropli"),o.setAttribute("href","?setor="+e[i].id),t.appendChild(a),a.appendChild(o)}}function agendamentos_do_dia_por_setor(e){var t="";if(elem=document.getElementById("agendimentos_do_dia"),elem1=document.getElementById("atendimentos_total"),elem1&&elem){var a=e[0].qtd_paciente;0===typeof a||"qtd_agendamentos_do_dia"==typeof a?console.log("verificar o json ou query nos selects.php"):t+="<span>"+a+"</span>",elem.innerHTML=t,elem1.innerHTML=t}}chamadaAjax("php/selectsJson.php?parametro=lista_de_setores&setor",lista_de_setores),chamadaAjax("php/selectsJson.php?parametro=lista_de_setores&setor",alteraTitulodoSetor),function(){var e=window.location.href.split("?")[1];chamadaAjax(`php/selectsJson.php?parametro=qtd_por_setor&${e}`,agendamentos_do_dia_por_setor),chamadaAjax(`php/selectsJson.php?parametro=horario_de_maior_fluxo&${e}`,horarioComMaiorPacientes),chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${e}`,lista_de_pacientes)}();