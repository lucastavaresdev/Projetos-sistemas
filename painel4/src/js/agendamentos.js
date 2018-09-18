
(function () {
    var url_atual = window.location.href;
    var parametrosDaUrl = url_atual.split("?")[1];
    chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${parametrosDaUrl}`, lista_de_pacientes);
    setInterval(function () {
        chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${parametrosDaUrl}`, cards_notificação);
    }, 200);
})();

function media_de_tempo(data) {
    var elem = document.getElementById('tempo_medio_de_sala');
    if (data[0].tempo_medio !== null || data[0].tempo_medio !== undefined) {
        let hora = data[0].tempo_medio.substr(0, 5);
        elem.innerHTML = hora;
    }
}


/*
 *---------------------Lista de Paciente---------------------------
 */

function lista_de_pacientes(data) {
    var tbody = document.getElementById("listadePacientes");
    if (tbody) {
        for (i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');

            var nstatus = status(data[i].checkin_unidade, data[i].checkout_unidade, data[i].checkin_exame, data[i].checkout_exame, data[i].status)

            var cols = '<td  class="ocutarmobile ocultar"></td>' +
                '<td class="ocultar">' + se_null(data[i].id_agendamento) + '</td>' +
                '<td>' + se_null(data[i].hora) + '</td>' +
                '<td>' + se_null(data[i].atividade) + '</td>' +
                '<td>' + se_null(data[i].IH) + '</td>' +
                '<td>' + se_null(data[i].paciente) + '</td>' +
                '<td>' + se_null(data[i].servico) + '</td>' +
                '<td>' + c_localizacao(data[i].setor) + '</td>' +
                '<td><div class="status-' + nstatus + ' center-status">' + nstatus + '</div></td>' +
                `<td class="ocultar" id="${data[i].IH + data[i].atividade}" class='center' ><a><i id="${data[i].IH + data[i].atividade}botao" class="material-icons botao_modal">info_outline</i></a></td>` +
                '<td class="ocultar">' + se_null(data[i].codigo_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].codigo_servico) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].descricao_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].sexo) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].data_nascimento) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].nome_medico) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].crm) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].checkin_unidade) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].checkout_unidade) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].tempo_vinculado) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].checkin_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].checkout_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].tempo_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].tempo_decorrido_do_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].desc_status) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].tempo_espera) + '</td>';

            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
        data_table(data);
    }
}

function status(vinculado, desvinculado, inicio_do_exame, final_do_exame, status_cancelado_vindo_do_banco) {
    nstatus = '';
    status_cancelado_vindo_do_banco = parseInt(status_cancelado_vindo_do_banco);
    if (status_cancelado_vindo_do_banco === 3) {
        console.log('cancelado')
        nstatus = 3;
        return nstatus
    } else if (!vinculado && inicio_do_exame === null || vinculado === null && inicio_do_exame === null) {
        console.log('Não iniciou o atendimento')
        nstatus = 6
        return nstatus
    } else if (desvinculado) {
        console.log('Finalizado')
        nstatus = 4
        return nstatus
    } else if (vinculado && !inicio_do_exame || status_cancelado_vindo_do_banco === 5) {
        console.log('Aguardando')
        nstatus = 1
        return nstatus
    } else if (inicio_do_exame && !final_do_exame) {
        console.log('Em antedimentos')
        nstatus = 2
        return nstatus
    } else if (inicio_do_exame && final_do_exame) {
        console.log('Atendido')
        nstatus = 5
        return nstatus
    }
}


function se_null(campo_do_banco) {
    campo_do_banco === null || campo_do_banco === undefined ? campo_do_banco = ' ' : campo_do_banco;
    return campo_do_banco
}

function c_localizacao(campo_do_banco, vinculado) {
    if (campo_do_banco === null || campo_do_banco === undefined) {
        campo_do_banco = 'Paciente não esta na unidade'
    } else if (campo_do_banco === null || campo_do_banco === undefined && !vinculado === null) {
        campo_do_banco = 'Paciente vinculado  não esta na unidade'
    } else {
        campo_do_banco = campo_do_banco
    }
    return campo_do_banco
}


function arredondarHora(campo) {
    campo = campo.substring(11, 16);
    return campo;
}

function diferenca_de_hora(hora_inicio, hora_fim) {
    novaHora = somaHora(hora_inicio, hora_fim, true);
    return novaHora
}


function somaHora(hrA, hrB, zerarHora) {
    if (hrA.length != 5 || hrB.length != 5) return "00:00";
    temp = 0;
    nova_h = 0;
    novo_m = 0;
    hora1 = hrA.substr(0, 2) * 1;
    hora2 = hrB.substr(0, 2) * 1;
    minu1 = hrA.substr(3, 2) * 1;
    minu2 = hrB.substr(3, 2) * 1;
    novo_m = minu2 - minu1;
    nova_h = hora2 - hora1;
    nhora = Math.abs(nova_h) + ':' + Math.abs(novo_m)
    if (Math.abs(nova_h) < 2 && hora1 >= hora2) {
        return 2
    } else {
        return nhora
    }

}

function MasculinoouFeminino(sexo) {
    if (sexo === "F") {
        return sexo = "Feminino"
    } else {
        return sexo = "Masculino"
    }
}

function data_table(d) {
    $(document).ready(function () {
        var table = $('#tabela_pacientes').DataTable({
            responsive: true,
            "language": {
                "lengthMenu": " Quantidade por Pagina _MENU_  ",
                "zeroRecords": "Não encontrado pacientes",
                "info": "Total de Pagina _PAGE_ de _PAGES_",
                "infoEmpty": " ",
                "infoFiltered": "",
                "search": "Filtrar:",
                "paginate": {
                    "first": " ",
                    "next": ">",
                    "previous": "<",
                    "last": " "
                }
            },
            "columns": [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                { 'data': "id_agendamento" },
                { 'data': "hora" },
                { 'data': "atividade" },
                { 'data': "IH" },
                { 'data': "paciente" },
                { 'data': "servico" },
                { 'data': "setor" },//localizacao
                { 'data': "status" },
                { 'data': "anotacao" },
                { 'data': "codigo_exame" },
                { 'data': "codigo_servico" },
                { 'data': "descricao_exame" },
                { 'data': "sexo" },
                { 'data': "data_nascimento" },
                { 'data': "nome_medico" },
                { 'data': "crm" },
                { 'data': "checkin_unidade" },
                { 'data': "checkout_unidade" },
                { 'data': "tempo_vinculado" },
                { 'data': "checkin_exame" },
                { 'data': "checkout_exame" },
                { 'data': "tempo_exame" },
                { 'data': "tempo_decorrido_do_exame" },
                { 'data': "desc_status" },
                { 'data': "tempo_espera" },
            ],
            "order": [[1, 'asc']],
            "columnDefs": [
                {
                    "targets": [14],
                    "visible": true,
                    "searchable": false
                }
            ],
        });

        // Add event listener for opening and closing details
        $('#tabela_pacientes tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                $('div.add_info', row.child()).slideUp(function () {
                    row.child.hide();
                    tr.removeClass('shown');
                });
            }
            else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
                $('div.add_info', row.child()).slideDown();
            }
        });
    });
}
/*------------------------------------------------------------------------------------------------------------------------------------*/

/*
 * ----------------------Quantidade de pacientes por agenda----------------------
 */
function qtd_de_agendamentos_do_dia_por_agenda(data) {
    var html = "";
    elem = document.getElementById('agendimentos_do_dia');
    elem1 = document.getElementById('atendimentos_total');

    if (elem1 && elem) {
        var qtd_agendamentos_do_dia = data[0].qtd_paciente;
        if (typeof qtd_agendamentos_do_dia === 0 || typeof qtd_agendamentos_do_dia === "qtd_agendamentos_do_dia") {
            console.log("verificar o json ou query nos selects.php");
        } else {
            html = '<span>' + qtd_agendamentos_do_dia + '</span>';
        }
        elem.innerHTML = html;
        elem1.innerHTML = html;
    }
}


/*
 * ----------------------Cards----------------------
 */


function cards_notificação(data) {
    // console.log('--------------------------');
    //debugger
    console.log(data);
    var html = ""
    var elem = document.getElementById('agendamemento_card_notificacao');
    for (let i = 0; i < data.length; i++) {
        var now = new Date

        hora = horaouminutoscolocandozero(now.getHours())
        minutos = horaouminutoscolocandozero(now.getMinutes())

        var horaAtual = `${hora}:${minutos}`;
        var horadoexame = data[i].hora


        Hora = somaHora(horaAtual, horadoexame)
        if (data[i].checkin_unidade === null && data[i].checkin_exame !== null && Hora === 2) {

            html += '<div class="card"> '
                + '<div class="card-content">'
                + '<div class="row">'
                + '<div class="col s10">'
                + '<div class="com_agendamento">'
                + '<span class="card-title titulo ">' + data[i].paciente + '</span>'
                + '<p class="cor-aviso">Paciente sem vinculo</p>'
                + '</div>'
                + '</div>'
                + '<div class="col s2">'
                + '<h6 class="hora_agendamento">' + data[i].hora + '</h6>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</div>';
        }
        elem.innerHTML = html;
    }

    function horaouminutoscolocandozero(horaouminutos) {

        if (horaouminutos < 10) {
            return `0${horaouminutos}`
        } else {
            return `${horaouminutos}`
        }
    }
}

