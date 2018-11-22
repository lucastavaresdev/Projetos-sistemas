chamadas()

setInterval(function () {
    chamadas()
}, 300000);

function chamadas() {
    chamadaAjax('php/selectsJson.php?parametro=total_de_pacientes_de_todos_os_setores', total_de_pacientes_de_todos_os_setores);
    chamadaAjax('php/selectsJson.php?parametro=total_de_procedimentos_de_todos_os_setores', total_de_procedimentos_de_todos_os_setores);
    chamadaAjax('php/query_temp.php?parametro=query', card_com_informacoes_do_setores);
    chamadaAjax('php/selectsJson.php?parametro=chekin_e_checkout', checkin_checkout);
    chamadaAjax('php/selectsJson.php?parametro=status_consolidado', status_consolidado);
}


function pergarId(id_da_alteracao) {
    var id = document.getElementById(id_da_alteracao);
    return id;
}

/*
 *---------------------Cards superior 1 row---------------------------
 */

//total_de_pacientes_de_todos_os_setores
function total_de_pacientes_de_todos_os_setores(data, id_da_alteracao) {
    var id = pergarId("con_agendados");
    id.innerHTML = data[0].totaldePacientes;
}

//total_de_procedimento_de_todos_os_setores
function total_de_procedimentos_de_todos_os_setores(data) {
    var id = pergarId("con_procedimento");
    id.innerHTML = data[0].total_procedimento;
}


//Checkin Checkout
function checkin_checkout(data) {
    var id_checkin = pergarId("com_checkin");
    var id_checkout = pergarId("com_checkout");
    id_checkin.innerHTML = data[0].checkin;
    id_checkout.innerHTML = data[0].checkout;
}


/*
 *---------------------Cards superior 2 row---------------------------
 */

function status_consolidado(data) {
    var id_con_aguardando = pergarId("con_aguardando");
    var id_emAtendimento = pergarId("con_emAtendimento");
    var id_con_cancelado = pergarId("con_cancelado");
    var id_con_finalizado = pergarId("con_finalizado");

    id_con_aguardando.innerHTML = data[0].aguardando;
    id_emAtendimento.innerHTML = data[0].andamento;
    id_con_cancelado.innerHTML = data[0].cancelado;
    id_con_finalizado.innerHTML = data[0].finalizado;
    setTimeout(naoIniciado(data[0].aguardando, data[0].andamento, data[0].cancelado, data[0].finalizado), 2000)
}



// async function naoIniciado(aguardando, andamento, cancelado, finalizado) {
//     var id_con_naoIniciado = pergarId("con_naoIniciado");
//     var id_con_agendados = pergarId("con_agendados").textContent;
//     if (id_con_agendados !== undefined) {
//         todos_os_pacientes_agendados = parseInt(id_con_agendados)
//         resultado_soma_de_todos_os_Status = parseInt(aguardando) + parseInt(andamento) + parseInt(cancelado) + parseInt(finalizado)
//         resultado_soma_de_todos_os_Status = todos_os_pacientes_agendados - resultado_soma_de_todos_os_Status
//         id_con_naoIniciado.innerHTML = resultado_soma_de_todos_os_Status
//     } else {
//         window.location.reload(true);
//     }
//}

/*
 *---------Cards Inferiores com informações dos setores----------------
 */


//cards por setor
function card_com_informacoes_do_setores(data) {
    var local_do_card = document.getElementById('con_card_setores');
    var html = " ";
    for (i = 0; i < data.length; i++) {
        html += " <div class='col s12 l4' >"
                    + `<div class='cards z-depth-3'><a href="./dashboard.php?setor=${data[i].id_servico}">`
                    + `<div class='col s4  l3 imagem-img${data[i].id_servico}'></div>`
                    + "<div class='col s8 l9 c_conteudo_card'>"
                    + "<h1 class='c_titulo c_card-title'>" + data[i].servico_nome + "</h1>"
                    + "<p>Paciente:"
                    + "<b class='right' id=pacientes" + se_null(data[i].id_servico) + ">" + '0' + "</b>"
                    + "</p>"
                    + "<p>Procedimentos:"
                    + "<b class='right'  id=procedimentos" + se_null(data[i].id_servico) + ">" + '0' + "</b>"
                    + "</p>"
                    + "<p>Aguardando:"
                    + "<b class='right con_card_aguardando'>" + se_null(data[i].aguardando) + "</b>"
                    + "</p>"
                    + "<p>Em atendimento:"
                    + "<b class='right'>" + se_null(data[i].atendimento) + "</b>"
                    + "</p>"
                    + "<p>Cancelados:"
                    + "<b class='right'>" + se_null(data[i].cancelado) + "</b>"
                    + "</p>"
                    + "<p>Finalizados:"
                    + "<b class='right'>" + se_null(data[i].finalizado) + "</b>"
                    + "</p>"
                    + "</div>"
                    + "</div></a>"
            + "</div>";

        chamadaAjax('php/selectsJson.php?parametro=card_com_informacoes_do_setores', populaCardcomQtdPacienteQtdProcedimentos);
    }


    local_do_card.innerHTML = html;
    for (let i = 0; i < data.length; i++) {
        var dado = parseInt(data[i].agendamento_do_dia);
        if (dado > 0) {
            status(data[i].id)
        }
    }

    function populaCardcomQtdPacienteQtdProcedimentos(data) {
        for (i = 0; i < data.length; i++) {

            Qtdpaciente = document.getElementById('pacientes' + data[i].id);
            Qtdprocedimento = document.getElementById('procedimentos' + data[i].id);
            Qtdpaciente.innerHTML = data[i].agendamento_do_dia
            Qtdprocedimento.innerHTML = data[i].exames
        }
    }
}

function se_null(campo_do_banco) {
    campo_do_banco === null || campo_do_banco === undefined ? campo_do_banco = 0 : campo_do_banco;
    return campo_do_banco
}

dataatual()

function dataatual() {
    now = new Date();
    dia = now.getDate()
    dia = dia < 10 ? '0' + dia : dia;
    mes = now.getMonth() + 1;
    mes = mes < 10 ? '0' + mes : mes;
    data = dia + "/" + mes + "/" + now.getFullYear();
    document.getElementById('con_data_atual').innerHTML = data;
}