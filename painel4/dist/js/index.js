function dados(e){return e}function media_de_tempo(e){var a=document.getElementById("tempo_medio_de_sala");if(null!==e[0].tempo_medio&&void 0!==e[0].tempo_medio){let o=e[0].tempo_medio.substr(0,5);a.innerHTML=o}}function lista_de_pacientes(e){var a=document.getElementById("listadePacientes");if(a){for(i=0;i<e.length;i++){var o=document.createElement("tr"),t=status(e[i].checkin_unidade,e[i].checkout_unidade,e[i].checkin_exame,e[i].checkout_exame,e[i].status),n='<td  class="ocutarmobile"></td><td class="ocultar">'+se_null(e[i].id_agendamento)+"</td><td>"+se_null(e[i].hora)+"</td><td>"+se_null(e[i].atividade)+"</td><td>"+se_null(e[i].IH)+"</td><td>"+se_null(e[i].paciente)+"</td><td>"+se_null(e[i].servico)+"</td><td>"+c_localizacao(e[i].localizacao)+'</td><td><div class="status-'+t+' center-status">'+t+"</div></td>"+`<td id="${e[i].IH+e[i].atividade}" class='center' ><a><i id="${e[i].IH+e[i].atividade}botao" class="material-icons botao_modal">info_outline</i></a></td>`+'<td class="ocultar">'+se_null(e[i].codigo_exame)+'</td><td class="ocultar">'+se_null(e[i].codigo_servico)+'</td><td class="ocultar">'+se_null(e[i].descricao_exame)+'</td><td class="ocultar">'+se_null(e[i].sexo)+'</td><td class="ocultar">'+se_null(e[i].data_nascimento)+'</td><td class="ocultar">'+se_null(e[i].nome_medico)+'</td><td class="ocultar">'+se_null(e[i].crm)+'</td><td class="ocultar">'+se_null(e[i].checkin_unidade)+'</td><td class="ocultar">'+se_null(e[i].checkout_unidade)+'</td><td class="ocultar">'+se_null(e[i].tempo_vinculado)+'</td><td class="ocultar">'+se_null(e[i].checkin_exame)+'</td><td class="ocultar">'+se_null(e[i].checkout_exame)+'</td><td class="ocultar">'+se_null(e[i].tempo_exame)+'</td><td class="ocultar">'+se_null(e[i].tempo_decorrido_do_exame)+'</td><td class="ocultar">'+se_null(e[i].desc_status)+'</td><td class="ocultar">'+se_null(e[i].tempo_espera)+"</td>",d=o.innerHTML=n;a.innerHTML+=d}data_table(e),modal(e),pacientes_finalizados_e_atuais(e)}}function status(e,a,o,t,n){return nstatus="",n=parseInt(n),3===n&&null!==n?(console.log("cancelado"),nstatus=3,nstatus):!e&&null===o||null===e&&null===o?(console.log("Não iniciou o atendimento"),nstatus=6,nstatus):a?(console.log("Finalizado"),nstatus=4,nstatus):e&&!o?(console.log("Aguardando"),nstatus=1,nstatus):o&&!t?(console.log("Em antedimentos"),nstatus=2,nstatus):o&&t?(console.log("Atendido"),nstatus=5,nstatus):void 0}function se_null(e){return(null===e||void 0===e)&&(e=" "),e}function c_localizacao(e,a){return e=null===e||void 0===e?"Paciente não esta na unidade":null===e||void 0===e&&null===!a?"Paciente vinculado não esta na unidade":'<span class="negrito-informacoes">'+e+"</span>"}function modal(e){for(modal="",i=0;i<e.length;i++){var a=e[i].IH+e[i].atividade+"modal",o=e[i].IH+e[i].atividade;let t;null===e[i].anotacao?t="Não há observação":(t=e[i].anotacao,o+="botao",document.getElementById(o).style.color="#FF6347 "),modal+=`<div id="${a}" class="modal modal-index">\n                <div class="modal-index-content">\n                    <span class="fecharModal"></span>\n                    <p>${e[i].paciente}</p>\n                    <p>Obs: ${t} </p>\n                </div>\n            </div>\n        </div>`,document.getElementById("elempai").innerHTML=modal}abrirModal()}function abrirModal(){var e=document.getElementById("listadePacientes").getElementsByTagName("td");for(let a=0;a<e.length;a++)elem=e[a],elem.addEventListener("click",function(){id=this.id;var e=document.getElementById(id),a=document.getElementById(id+"modal"),o=document.getElementsByClassName("fecharModal")[0];e.onclick=function(){a.style.display="block"},o.onclick=function(){a.style.display="none"},window.onclick=function(e){e.target==a&&(a.style.display="none")}})}function format(e){console.log(e);const a=MasculinoouFeminino(e.sexo);data_de_nascimento=e.data_nascimento;const o=quebraURL(data_de_nascimento,"T"),t=quebraURL(o[0],"-"),n=`${t[2]} /${t[1]}/${t[0]} `;return vinculado=arredondarHora(e.checkin_unidade),desvinculado=arredondarHora(e.checkout_unidade),inicio_do_exame=arredondarHora(e.checkin_exame),tempo_espera=e.tempo_vinculado.substring(0,5),tempo_total=e.tempo_vinculado.substring(0,5),void 0===e.tempo_decorrido_do_exame?tempo_decorrido_do_exame="":tempo_decorrido_do_exame=e.tempo_decorrido_do_exame.substring(0,5),e.checkout_exame?(checkout_exame=arredondarHora(e.checkout_exame),tempo_decorrido_do_exame=diferenca_de_hora(inicio_do_exame,checkout_exame)+"<span class='sem_negrito-informacoes'> (Finalizado)</span> "):checkout_exame="",desvinculado&&(tempo_total=diferenca_de_hora(vinculado,desvinculado)),'<div class="row add_info"><div class=" col s4"><div class=" col s11 offset-s1"><p> Nome do Paciente:<span class="negrito-informacoes"> '+e.paciente+'</span></p><p> Atividade:<span class="negrito-informacoes"> '+e.atividade+'</span></p><p> Descrição do Exame:<span class="negrito-informacoes"> '+e.descricao_exame+'</span></p><p> Médico:<span class="negrito-informacoes"> '+e.nome_medico+' </span>CRM:<span class="negrito-informacoes"> '+e.crm+' </span></p></div> </div> <div class="col s3 "><p> IH:<span class="negrito-informacoes"> '+e.IH+'</span></p><p> Sexo:<span class="negrito-informacoes"> '+a+'</span></p><p> Data de Nascimento:<span class="negrito-informacoes"> '+n+'</span></p></div> <div class="col s3"><p> Exame: (Inicio: <span class="negrito-informacoes">'+inicio_do_exame+'</span> / Fim: <span class="negrito-informacoes">'+checkout_exame+'</span>)</p><p> Tempo de Sala:<span class="negrito-informacoes"> '+tempo_decorrido_do_exame+'</span></p><p> Tempo em Espera:<span class="negrito-informacoes"> '+tempo_espera+'</span></p></div><div class="col s2"><p> Vinculado as:<span class="negrito-informacoes"> '+vinculado+'</span></p><p> Desvinculado as:<span class="negrito-informacoes"> '+desvinculado+'</span></p><p> Tempo Total de Vinculo:<span class="negrito-informacoes"> '+tempo_total+"</span></p></div> </div> "}function arredondarHora(e){return e=e.substring(11,16)}function diferenca_de_hora(e,a){return novaHora=somaHora(e,a,!0),novaHora}function somaHora(e,a,o){return 5!=e.length||5!=a.length?"00:00":(temp=0,nova_h=0,novo_m=0,hora1=1*e.substr(0,2),hora2=1*a.substr(0,2),minu1=1*e.substr(3,2),minu2=1*a.substr(3,2),novo_m=minu2-minu1,nova_h=hora2-hora1,Math.abs(nova_h)+"h:"+Math.abs(novo_m)+"m")}function MasculinoouFeminino(e){return e="F"===e?"Feminino":"Masculino"}function data_table(e){$(document).ready(function(){var e=$("#tabela_pacientes").DataTable({responsive:!0,language:{lengthMenu:" Quantidade por Pagina _MENU_  ",zeroRecords:"Não encontrado pacientes",info:"Total de Pagina _PAGE_ de _PAGES_",infoEmpty:" ",infoFiltered:"",search:"Filtrar:",paginate:{first:" ",next:">",previous:"<",last:" "}},columns:[{className:"details-control",orderable:!1,data:null,defaultContent:""},{data:"id_agendamento"},{data:"hora"},{data:"atividade"},{data:"IH"},{data:"paciente"},{data:"servico"},{data:"setor"},{data:"status"},{data:"anotacao"},{data:"codigo_exame"},{data:"codigo_servico"},{data:"descricao_exame"},{data:"sexo"},{data:"data_nascimento"},{data:"nome_medico"},{data:"crm"},{data:"checkin_unidade"},{data:"checkout_unidade"},{data:"tempo_vinculado"},{data:"checkin_exame"},{data:"checkout_exame"},{data:"tempo_exame"},{data:"tempo_decorrido_do_exame"},{data:"desc_status"},{data:"tempo_espera"}],order:[[1,"asc"]],columnDefs:[{targets:[14],visible:!0,searchable:!1}]});$("#tabela_pacientes tbody").on("click","td.details-control",function(){var a=$(this).closest("tr"),o=e.row(a);o.child.isShown()?$("div.add_info",o.child()).slideUp(function(){o.child.hide(),a.removeClass("shown")}):(o.child(format(o.data())).show(),a.addClass("shown"),$("div.add_info",o.child()).slideDown())})})}function qtd_de_agendamentos_do_dia_por_agenda(e){var a="";if(elem=document.getElementById("agendimentos_do_dia"),elem1=document.getElementById("atendimentos_total"),elem1&&elem){var o=e[0].qtd_paciente;0===typeof o||"qtd_agendamentos_do_dia"==typeof o?console.log("verificar o json ou query nos selects.php"):a="<span>"+o+"</span>",elem.innerHTML=a,elem1.innerHTML=a}}function qtd_procedimentos(e){var a=document.getElementById("qtd_procedimentos"),o=e[0].qtd_procedimentos;a.innerHTML=o}function horarioComMaiorPacientes(e){var a=document.getElementById("fluxo"),o=" ";if(a){for(i=0;i<e.length;i++){o+=`<li> ${e[i].intervalo_de_horas} <span> (${e[i].qtd_por_hora} pacientes)</span></li > `}0===e.length?(a.innerHTML="Não ha paciente",a.classList.add("p-msg")):1===e.length?(atribuiHtml(a,o),a.classList.add("fluxo-1")):(a.innerHTML="Lista de fluxo",a.classList.add("p-msg"))}}function atribuiHtml(e,a){e.innerHTML=a}function calendario(){const e=document.querySelector(".datepicker");M.Datepicker.init(e,{format:"dd-mm-yyyy",i18n:{months:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],monthsShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],weekday:["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sabado"],weekdaysShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],weekdaysAbbrev:["D","S","T","Q","Q","S","S"],cancel:"Cancelar"}});const a=document.querySelector(".btn-flat.datepicker-done.waves-effect");window.location;a.addEventListener("click",function(){let a=e.value;a=a.split("-"),datamysql=`${a[2]}-${a[1]}-${a[0]} `;let o=window.location.href;url_dividida=quebraURL(o,"?"),resultado=url_dividida[0],parametros=quebraURL(url_dividida[1],"&"),setor=parametros[0],window.location=resultado+"?"+setor+"&data="+datamysql})}function menuclicado(){var e=document.getElementById("listadePacientes").getElementsByTagName("tr");for(let a=0;a<e.length;a++)e[a].addEventListener("click",function(){console.log(a)})}function pacientes_finalizados_e_atuais(e){elem_numero=document.getElementById("d_pacientes_finalizados"),elem_qtdAtuais=document.getElementById("qtd_pacientes_atuais"),elem_tempoMedio=document.getElementById("tempo_medio_de_sala");var a=0,o=0;e.forEach(e=>{null!==e.checkout_unidade?a++:null!==e.checkin_unidade&&"3"!==e.status&&o++}),elem_numero.innerHTML=a,elem_qtdAtuais.innerHTML=o}!function(){var e=window.location.href;console.log(e);var a=e.split("?")[1];chamadaAjax(`php/selectsJson.php?parametro=qtd_de_agendamentos_do_dia_por_agenda&${a}`,qtd_de_agendamentos_do_dia_por_agenda),chamadaAjax(`php/selectsJson.php?parametro=qtd_procedimentos&${a}`,qtd_procedimentos),chamadaAjax(`php/selectsJson.php?parametro=horario_de_maior_fluxo&${a}`,horarioComMaiorPacientes),chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${a}`,lista_de_pacientes),chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${a}`,dados),chamadaAjax(`php/selectsJson.php?parametro=media_de_tempo_de_agendamento&${a}`,media_de_tempo),calendario()}();var cord;