
(function () {
    var url_atual = window.location.href;


    var parametrosDaUrl = url_atual.split("?")[1];


    chamadaAjax(`php/selectsJson.php?parametro=qtd_de_agendamentos_do_dia_por_agenda&${parametrosDaUrl}`, qtd_de_agendamentos_do_dia_por_agenda);
    chamadaAjax(`php/selectsJson.php?parametro=qtd_procedimentos&${parametrosDaUrl}`, qtd_procedimentos);
    chamadaAjax(`php/selectsJson.php?parametro=horario_de_maior_fluxo&${parametrosDaUrl}`, horarioComMaiorPacientes);
    chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${parametrosDaUrl}`, lista_de_pacientes);
    chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${parametrosDaUrl}`, dados);
    chamadaAjax(`php/selectsJson.php?parametro=media_de_tempo_de_agendamento&${parametrosDaUrl}`, media_de_tempo);

    calendario();
})();

var cord;


function dados(data) {
    return data;
}


function media_de_tempo(data) {
    var elem = document.getElementById('tempo_medio_de_sala');
    if (data[0].tempo_medio !== null && data[0].tempo_medio !== undefined) {
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


            var cols = '<td  class="ocutarmobile"></td>' +
                '<td class="ocultar">' + data[i].id_agendamento + '</td>' +
                '<td>' + se_null(data[i].hora) + '</td>' +
                '<td>' + se_null(data[i].atividade) + '</td>' +
                '<td>' + se_null(data[i].IH) + '</td>' +
                '<td>' + se_null(data[i].paciente) + '</td>' +
                '<td>' + se_null(data[i].servico) + '</td>' +
                '<td >' + liberarPaciente(data[i].proximo_exame, data[i].checkin_unidade) + '</td>' +
                '<td >' + c_localizacao(data[i].localizacao) + '</td>' +
                '<td><div class="status-' + nstatus + ' center-status">' + nstatus + '</div></td>' +
                `<td id="${data[i].IH + data[i].atividade}" class='center' ><a><i id="${data[i].IH + data[i].atividade}botao" class="material-icons botao_modal">info_outline</i></a></td>` +
                '<td class="ocultar">' + data[i].codigo_exame + '</td>' +
                '<td class="ocultar">' + data[i].codigo_servico + '</td>' +
                '<td class="ocultar">' + se_null(data[i].descricao_exame) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].anotacao) + '</td>' +
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
                '<td class="ocultar">' + se_null(data[i].tempo_espera) + '</td>' +
                '<td class="ocultar">' + se_null(data[i].hora_agendamento) + '</td>';

            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
        data_table(data);
        modal(data);
        pacientes_finalizados_e_atuais(data);
    }
}

function liberarPaciente(proximo_exame, tempo_de_vinculado ){
    if(proximo_exame == null && tempo_de_vinculado){
        return msg = '<div class="negrito-informacoes" >Liberar Paciente</div>'
    }else if(proximo_exame == null){
        return  ''
    }else{
        return proximo_exame
    }
}

function ProximoSetorigual(SetorAtual, ProximoSetor) {
    if (SetorAtual === ProximoSetor || ProximoSetor === null) {
        return " "
    } else {
        return ProximoSetor
    }
}

function status(vinculado, desvinculado, inicio_do_exame, final_do_exame, status_cancelado_vindo_do_banco) {
    nstatus = '';
    status_cancelado_vindo_do_banco = parseInt(status_cancelado_vindo_do_banco);
    if (status_cancelado_vindo_do_banco === 5 && desvinculado === null) {
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
    } else if (vinculado && !inicio_do_exame || status_cancelado_vindo_do_banco === 3) {
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
        campo_do_banco = 'Paciente vinculado não esta na unidade'
    } else {
        campo_do_banco = '<span class="negrito-informacoes">' + campo_do_banco + '</span>'
    }
    return campo_do_banco
}



function modal(data) {

    modal = "";
    for (i = 0; i < data.length; i++) {
        var IDdoModal = data[i].IH + data[i].atividade + "modal";
        var ID = data[i].IH + data[i].atividade;
        let obs;

        if (data[i].observacao === null) {
            obs = "Não há observação"
        } else {
            obs = data[i].observacao;
            ID = ID + "botao"
            document.getElementById(ID).style.color = "#FF6347 "
        }
        modal += `<div id="${IDdoModal}" class="modal modal-index">
                <div class="modal-index-content">
                    <span class="fecharModal"></span>
                    <p>${data[i].paciente}</p>
                    <p>Obs: ${obs} </p>
                </div>
            </div>
        </div>`
        document.getElementById("elempai").innerHTML = modal;
    }
    abrirModal()
}


function abrirModal() {
    var tabela = document.getElementById('listadePacientes');
    var linhas = tabela.getElementsByTagName('td')

    for (let i = 0; i < linhas.length; i++) {
        elem = linhas[i];
        elem.addEventListener('click', function () {
            id = this.id
            var btn = document.getElementById(id);
            var modal = document.getElementById(id + 'modal');
            var span = document.getElementsByClassName("fecharModal")[0];
            btn.onclick = function () {
                modal.style.display = "block";
            }
            span.onclick = function () {
                modal.style.display = "none";
            }
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        })
    }
}

function format(d) {
    const resultadoSexo = MasculinoouFeminino(d.sexo);
    data_de_nascimento = d.data_nascimento;
    const divindodataeHora = quebraURL(data_de_nascimento, "T");
    const divididoadata = quebraURL(divindodataeHora[0], "-");
    const datadeNascimento = `${divididoadata[2]} /${divididoadata[1]}/${divididoadata[0]} `;
    vinculado = arredondarHora(d.checkin_unidade)
    desvinculado = arredondarHora(d.checkout_unidade)
    inicio_do_exame = arredondarHora(d.checkin_exame)
    tempo_espera = d.tempo_vinculado.substring(0, 5)
    tempo_total = d.tempo_vinculado.substring(0, 5)
    d.tempo_decorrido_do_exame === undefined ? tempo_decorrido_do_exame = "" : tempo_decorrido_do_exame = d.tempo_decorrido_do_exame.substring(0, 5);
    if (d.checkout_exame) {
        checkout_exame = arredondarHora(d.checkout_exame);
        tempo_decorrido_do_exame = diferenca_de_hora(inicio_do_exame, checkout_exame) + "<span class='sem_negrito-informacoes'> (Finalizado)</span> ";
    } else {
        checkout_exame = "";
    }
    if (desvinculado) {
        tempo_total = diferenca_de_hora(vinculado, desvinculado);
    }



    return '<div class="row add_info">'
        + '<div class=" col s4">'
        + '<div class=" col s11 offset-s1">'
        + '<p> Nome do Paciente:<span class="negrito-informacoes"> ' + d.paciente + '</span></p>'
        + '<p> Atividade:<span class="negrito-informacoes"> ' + d.atividade + '</span></p>'
        + '<p> Descrição do Exame:<span class="negrito-informacoes"> ' + d.descricao_exame + '</span></p>'
        + '<p> Médico:<span class="negrito-informacoes"> ' + d.nome_medico + ' </span>CRM:<span class="negrito-informacoes"> ' + d.crm + ' </span></p>'
        + '</div> '
        + '</div> '
        + '<div class="col s3 ">'
        + '<p> IH:<span class="negrito-informacoes"> ' + d.IH + '</span></p>'
        + '<p> Sexo:<span class="negrito-informacoes"> ' + resultadoSexo + '</span></p>'
        + '<p> Data de Nascimento:<span class="negrito-informacoes"> ' + datadeNascimento + '</span></p>'
        + '</div> '
        + '<div class="col s3">'
        + '<p> Exame: (Inicio: <span class="negrito-informacoes">' + inicio_do_exame + '</span> / Fim: <span class="negrito-informacoes">' + checkout_exame + '</span>)</p>'
        + '<p> Tempo de Sala:<span class="negrito-informacoes"> ' + tempo_decorrido_do_exame + '</span></p>'
        + '<p> Tempo em Espera:<span class="negrito-informacoes"> ' + tempo_espera + '</span></p>'
        + '</div>'
        + '<div class="col s2">'
        + '<p> Vinculado as:<span class="negrito-informacoes"> ' + vinculado + '</span></p>'
        + '<p> Desvinculado as:<span class="negrito-informacoes"> ' + desvinculado + '</span></p>'
        + '<p> Tempo Total de Vinculo:<span class="negrito-informacoes"> ' + tempo_total + '</span></p>'
        + '</div> '
        + '</div> '
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
    return Math.abs(nova_h) + 'h:' + Math.abs(novo_m) + 'm';
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
            "order": [[ 9, "asc" ]],
            "responsive": true,
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
                { 'data': "proximo_exame" },
                { 'data': "localizacao" },
                { 'data': "status" },
                { 'data': "observacao" },
                { 'data': "codigo_exame" },
                { 'data': "codigo_servico" },
                { 'data': "descricao_exame" },
                { 'data': "anotacao" },
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
                { 'data': "hora_agendamento" },
            ],
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
 * ----------------------Quantidade de Procedimentos----------------------
 */

function qtd_procedimentos(data) {
    var elem = document.getElementById('qtd_procedimentos');
    var qtd_procedimentos = data[0].qtd_procedimentos;
    elem.innerHTML = qtd_procedimentos;
}

/*
 * ----------------------Fluxo de tempo----------------------
 */


function horarioComMaiorPacientes(data) {
    var fluxodetempo = document.getElementById('fluxo');
    var html = " ";

    if (fluxodetempo) {
        for (i = 0; i < data.length; i++) {
            var j;
            j = `<li> ${data[i].intervalo_de_horas} <span> (${data[i].qtd_por_hora} pacientes)</span></li > `;
            html += j;
        }

        if (data.length === 0) {
            fluxodetempo.innerHTML = "Não ha paciente";
            fluxodetempo.classList.add('p-msg');
        } else if (data.length === 1) {
            atribuiHtml(fluxodetempo, html);
            fluxodetempo.classList.add('fluxo-1');
        } else {
            fluxodetempo.innerHTML = "Lista de fluxo"
            fluxodetempo.classList.add('p-msg');
        }
    }

}

function atribuiHtml(classouid, resultado) {
    classouid.innerHTML = resultado;
}

/*
 * ----------------------Calendario----------------------
 */

function calendario() {
    const Calender = document.querySelector('.datepicker');
    M.Datepicker.init(Calender, {
        format: 'dd-mm-yyyy',
        //autoClose: true,
        i18n: {
            months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            weekday: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
            cancel: 'Cancelar'
        }
    });

    const btn_ok = document.querySelector('.btn-flat.datepicker-done.waves-effect');
    var urlAtual = window.location; // pega a url da pagina

    btn_ok.addEventListener('click', function () {

        let dataescolhida = Calender.value; //pega a data
        dataescolhida = dataescolhida.split('-');
        datamysql = `${dataescolhida[2]}-${dataescolhida[1]}-${dataescolhida[0]} `;


        let url = window.location.href
        url_dividida = quebraURL(url, "?")

        resultado = url_dividida[0]
        parametros = quebraURL(url_dividida[1], "&")

        setor = parametros[0];
        window.location = resultado + '?' + setor + '&data=' + datamysql;

    })
}



function menuclicado() {
    var tabela = document.getElementById('listadePacientes');
    var linhas = tabela.getElementsByTagName('tr')

    for (let i = 0; i < linhas.length; i++) {
        linhas[i].addEventListener('click', function () {
        })
    }
}

/*
 *--------------------- Finalizados e Quantidade de Pacientes Atuais ---------------------------
 */



function pacientes_finalizados_e_atuais(data) {
    elem_numero = document.getElementById('d_pacientes_finalizados');
    elem_qtdAtuais = document.getElementById('qtd_pacientes_atuais');
    elem_tempoMedio = document.getElementById('tempo_medio_de_sala');


    var resultado = 0;
    var resultado_qtdAtuais = 0;
    data.forEach((obj) => {

        if (obj.checkout_unidade !== null) {
            resultado++
        } else if (obj.checkin_unidade !== null && obj.status !== "3") {
            resultado_qtdAtuais++
        }
    });

    elem_numero.innerHTML = resultado
    elem_qtdAtuais.innerHTML = resultado_qtdAtuais
}


