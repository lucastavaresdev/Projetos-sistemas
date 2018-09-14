//chamadas ajax

chamadaAjax('php/selectsJson.php?parametro=lista_de_setores&setor', lista_de_setores);
chamadaAjax('php/selectsJson.php?parametro=lista_de_setores&setor', alteraTitulodoSetor);


(function () {
    var url_atual = window.location.href;

    var parametrosDaUrl = url_atual.split("?")[1];

    chamadaAjax(`php/selectsJson.php?parametro=qtd_por_setor&${parametrosDaUrl}`, agendamentos_do_dia_por_setor);
    chamadaAjax(`php/selectsJson.php?parametro=horario_de_maior_fluxo&${parametrosDaUrl}`, horarioComMaiorPacientes);
    chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${parametrosDaUrl}`, lista_de_pacientes);
})();



function lista_de_pacientes(data) {
    var tbody = document.getElementById("listadePacientes");
    if (tbody) {
        for (i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');

            var cols =
                '<td>' + data[i].hora + '</td>'
                + '<td>' + data[i].atividade + '</td>'
                + '<td>' + data[i].IH + '</td>'
                + '<td>' + data[i].paciente + '</td>'
                + '<td>' + ' - ' + '</td>'
                + '<td>' + data[i].servico_atual + '</td>'
                + '<td>' + data[i].proximo_servico + '</td>'
                + `<td><div  class=" status-${data[i].cod_cor_status} center-status">${data[i].cod_cor_status}</div></td>`
                + '<td>' + ' - ' + '</td>';
            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
        data_table()
    }
}


function data_table() {
    $(document).ready(function () {
        $('#tabela_pacientes').DataTable({
            "pagingType": "full_numbers",
            // "lengthMenu": [ 10, 25, 50, 75, 100],

            "language": {
                "lengthMenu": " Quantidade por Pagina _MENU_  ",
                "zeroRecords": "Não encontrado pacientes",
                "info": "Total de Pagina _PAGE_ de _PAGES_",
                "infoEmpty": " ",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Filtrar:",
                "paginate": {
                    "first": " ",
                    "next": "Proxima",
                    "previous": "Anterior",
                    "last": " "
                }
            }
        });
    });
}



function horarioComMaiorPacientes(data) {
    var fluxodetempo = document.getElementById('fluxo');
    var html = " ";

    if (fluxodetempo) {
        for (i = 0; i < data.length; i++) {
            var j;
            j = `<li>${data[i].intervalo_de_horas} <span> (${data[i].qtd_por_hora} pacientes)</span></li>`;
            html += j;
        }

        if (data.length === 0) {
            fluxodetempo.innerHTML = "Não ha paciente";
            fluxodetempo.classList.add('p-msg');
        } else if (data.length === 1) {
            atribuiHtml(fluxodetempo, html);
            fluxodetempo.classList.add('fluxo-1');
        } else if (data.length === 2) {
            atribuiHtml(fluxodetempo, html);
            fluxodetempo.classList.add('fluxo-2');
        } else {
            fluxodetempo.innerHTML = "Ver Lista de Pacientes"
            fluxodetempo.classList.add('p-msg');
        }
    }

}

function atribuiHtml(classouid, resultado) {
    classouid.innerHTML = resultado;
}


function alteraTitulodoSetor(data) {

    var titulo = document.getElementById('titulo_do_setor');
    var titulo_aba = document.getElementById('aba_nome_setor');

    var url_atual = window.location.href;
    var id_do_setor = url_atual.split("=")[1];

    // id_do_setor = parseInt(id_do_setor);
    for (i = 0; i < data.length; i++) {
        id_do_setor_banco = data[i].id;

        if (id_do_setor === id_do_setor_banco) {
            var nome_do_setor = data[i].setor;
            if (titulo_aba) {
                titulo.innerHTML = nome_do_setor;
                titulo_aba.innerHTML = nome_do_setor;
            }
            return;
        } else {
            if (titulo_aba) {
                titulo.innerHTML = '-';
                titulo_aba.innerHTML = '-';
            } else {
                titulo.innerHTML = '-';
            }
        }
    }
}




function lista_de_setores(data) {

    var elem_drop = document.getElementById('setores_lista');

    for (i = 0; i < data.length; i++) {

        var criaLI = document.createElement('li');
        var link = document.createElement('a');

        //add os elem
        link.textContent = data[i].setor;

        criaLI.setAttribute("class", "dropli");
        link.setAttribute("href", "?setor=" + data[i].id + "");

        //cria a estrutura e adiciona
        elem_drop.appendChild(criaLI);
        criaLI.appendChild(link);
    }

}



function agendamentos_do_dia_por_setor(data) {
    var html = "";
    
    elem = document.getElementById('agendimentos_do_dia');
    elem1 = document.getElementById('atendimentos_total');
    if(elem1 && elem){
    var qtd_agendamentos_do_dia = data[0].qtd_paciente;

    if (typeof qtd_agendamentos_do_dia === 0 || typeof qtd_agendamentos_do_dia === "qtd_agendamentos_do_dia") {
        console.log("verificar o json ou query nos selects.php");
    } else {
        html += '<span>' + qtd_agendamentos_do_dia + '</span>';
    }

    elem.innerHTML = html;
    elem1.innerHTML = html;
}
}
