function media_de_tempo(a){var t=document.getElementById("tempo_medio_de_sala");if(null!==a[0].tempo_medio||void 0!==a[0].tempo_medio){let e=a[0].tempo_medio.substr(0,5);t.innerHTML=e}}function lista_de_pacientes(a){var t=document.getElementById("listadePacientes");if(t){for(i=0;i<a.length;i++){var e=document.createElement("tr"),n=status(a[i].checkin_unidade,a[i].checkout_unidade,a[i].checkin_exame,a[i].checkout_exame,a[i].status),o='<td  class="ocutarmobile ocultar"></td><td class="ocultar">'+se_null(a[i].id_agendamento)+"</td><td>"+se_null(a[i].hora)+"</td><td>"+se_null(a[i].atividade)+"</td><td>"+se_null(a[i].IH)+"</td><td>"+se_null(a[i].paciente)+"</td><td>"+se_null(a[i].servico)+"</td><td>"+c_localizacao(a[i].setor)+'</td><td><div class="status-'+n+' center-status">'+n+"</div></td>"+`<td class="ocultar" id="${a[i].IH+a[i].atividade}" class='center' ><a><i id="${a[i].IH+a[i].atividade}botao" class="material-icons botao_modal">info_outline</i></a></td>`+'<td class="ocultar">'+se_null(a[i].codigo_exame)+'</td><td class="ocultar">'+se_null(a[i].codigo_servico)+'</td><td class="ocultar">'+se_null(a[i].descricao_exame)+'</td><td class="ocultar">'+se_null(a[i].sexo)+'</td><td class="ocultar">'+se_null(a[i].data_nascimento)+'</td><td class="ocultar">'+se_null(a[i].nome_medico)+'</td><td class="ocultar">'+se_null(a[i].crm)+'</td><td class="ocultar">'+se_null(a[i].checkin_unidade)+'</td><td class="ocultar">'+se_null(a[i].checkout_unidade)+'</td><td class="ocultar">'+se_null(a[i].tempo_vinculado)+'</td><td class="ocultar">'+se_null(a[i].checkin_exame)+'</td><td class="ocultar">'+se_null(a[i].checkout_exame)+'</td><td class="ocultar">'+se_null(a[i].tempo_exame)+'</td><td class="ocultar">'+se_null(a[i].tempo_decorrido_do_exame)+'</td><td class="ocultar">'+se_null(a[i].desc_status)+'</td><td class="ocultar">'+se_null(a[i].tempo_espera)+"</td>",d=e.innerHTML=o;t.innerHTML+=d}data_table(a)}}function status(a,t,e,n,o){return nstatus="",o=parseInt(o),3===o?(console.log("cancelado"),nstatus=3,nstatus):!a&&null===e||null===a&&null===e?(console.log("Não iniciou o atendimento"),nstatus=6,nstatus):t?(console.log("Finalizado"),nstatus=4,nstatus):a&&!e||5===o?(console.log("Aguardando"),nstatus=1,nstatus):e&&!n?(console.log("Em antedimentos"),nstatus=2,nstatus):e&&n?(console.log("Atendido"),nstatus=5,nstatus):void 0}function se_null(a){return(null===a||void 0===a)&&(a=" "),a}function c_localizacao(a,t){return a=null===a||void 0===a?"Paciente não esta na unidade":null===a||void 0===a&&null===!t?"Paciente vinculado  não esta na unidade":a}function arredondarHora(a){return a=a.substring(11,16)}function diferenca_de_hora(a,t){return novaHora=somaHora(a,t,!0),novaHora}function somaHora(a,t,e){return 5!=a.length||5!=t.length?"00:00":(temp=0,nova_h=0,novo_m=0,hora1=1*a.substr(0,2),hora2=1*t.substr(0,2),minu1=1*a.substr(3,2),minu2=1*t.substr(3,2),novo_m=minu2-minu1,nova_h=hora2-hora1,nhora=Math.abs(nova_h)+":"+Math.abs(novo_m),2>Math.abs(nova_h)&&hora1>=hora2?2:nhora)}function MasculinoouFeminino(a){return a="F"===a?"Feminino":"Masculino"}function data_table(a){$(document).ready(function(){var a=$("#tabela_pacientes").DataTable({responsive:!0,language:{lengthMenu:" Quantidade por Pagina _MENU_  ",zeroRecords:"Não encontrado pacientes",info:"Total de Pagina _PAGE_ de _PAGES_",infoEmpty:" ",infoFiltered:"",search:"Filtrar:",paginate:{first:" ",next:">",previous:"<",last:" "}},columns:[{className:"details-control",orderable:!1,data:null,defaultContent:""},{data:"id_agendamento"},{data:"hora"},{data:"atividade"},{data:"IH"},{data:"paciente"},{data:"servico"},{data:"setor"},{data:"status"},{data:"anotacao"},{data:"codigo_exame"},{data:"codigo_servico"},{data:"descricao_exame"},{data:"sexo"},{data:"data_nascimento"},{data:"nome_medico"},{data:"crm"},{data:"checkin_unidade"},{data:"checkout_unidade"},{data:"tempo_vinculado"},{data:"checkin_exame"},{data:"checkout_exame"},{data:"tempo_exame"},{data:"tempo_decorrido_do_exame"},{data:"desc_status"},{data:"tempo_espera"}],order:[[1,"asc"]],columnDefs:[{targets:[14],visible:!0,searchable:!1}]});$("#tabela_pacientes tbody").on("click","td.details-control",function(){var t=$(this).closest("tr"),e=a.row(t);e.child.isShown()?$("div.add_info",e.child()).slideUp(function(){e.child.hide(),t.removeClass("shown")}):(e.child(format(e.data())).show(),t.addClass("shown"),$("div.add_info",e.child()).slideDown())})})}function qtd_de_agendamentos_do_dia_por_agenda(a){var t="";if(elem=document.getElementById("agendimentos_do_dia"),elem1=document.getElementById("atendimentos_total"),elem1&&elem){var e=a[0].qtd_paciente;0===typeof e||"qtd_agendamentos_do_dia"==typeof e?console.log("verificar o json ou query nos selects.php"):t="<span>"+e+"</span>",elem.innerHTML=t,elem1.innerHTML=t}}function cards_notificação(a){function t(a){return 10>a?`0${a}`:`${a}`}console.log(a);var e="",n=document.getElementById("agendamemento_card_notificacao");for(let i=0;i<a.length;i++){var o=new Date;hora=t(o.getHours()),minutos=t(o.getMinutes());var d=`${hora}:${minutos}`,s=a[i].hora;Hora=somaHora(d,s),null===a[i].checkin_unidade&&null!==a[i].checkin_exame&&2===Hora&&(e+='<div class="card"> <div class="card-content"><div class="row"><div class="col s10"><div class="com_agendamento"><span class="card-title titulo ">'+a[i].paciente+'</span><p class="cor-aviso">Paciente sem vinculo</p></div></div><div class="col s2"><h6 class="hora_agendamento">'+a[i].hora+"</h6></div></div></div></div>"),n.innerHTML=e}}!function(){var a=window.location.href.split("?")[1];chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${a}`,lista_de_pacientes),setInterval(function(){chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${a}`,cards_notificação)},200)}();