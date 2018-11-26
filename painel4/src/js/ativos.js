

(function () {
    var url_atual = window.location.href;
    var parametrosDaUrl = url_atual.split("?")[1];
    chamadaAjax(`php/selectsJson.php?parametro=relatorio_de_paciente_ativos`, lista_de_pacientes)
})();


/*
 *---------------------Lista de Paciente---------------------------
 */
function lista_de_pacientes(data) {

    var tbody = document.getElementById("listadePacientes");
    if (tbody) {


        for (i = 0; i < data.length; i++) {

            var nstatus = status(data[i].status_final)
            var exame = ocultaDados(data[i].exame, data[i].status_final)

            var tr = document.createElement('tr');
            var cols = '<td class="ocultar">' + ' ' + '</td>' +
                '<td>' + data[i].paciente + '</td>' +
                '<td class="ocultar">' + data[i].atendimento + '</td>' +
                '<td>' + data[i].ih_paciente + '</td>' +
                '<td class="ocultar">' + data[i].cod_exame + '</td>' +
                '<td>' + data[i].sexo + '</td>' +
                '<td>' + data[i].nome_medico + '</td>' +
                '<td>' + exame + '</td>' +
                '<td class="ocultar">' + data[i].data_agendamento + '</td>' +
                '<td>' + data[i].nome_setor + '</td>';
                // '<td><div class="status-' + nstatus + ' center-status">' + nstatus + '</div></td>';
            // '<td>' + data[i].status + '</td>';

            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
        data_table(data);
    }
}


function data_table(d) {
    $(document).ready(function () {
        var table = $('#tabela_ativos').DataTable({
            //responsive: true,
            "language": {
                "lengthMenu": " Quantidade por Pagina _MENU_  ",
                "zeroRecords": "Nenhum paciente ativo no momento",
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
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                { 'data': "paciente" },
                { 'data': "atendimento" },
                { 'data': "ih_paciente" },
                { 'data': "cod_exame" },
                { 'data': "sexo" },
                { 'data': "nome_medico" },
                { 'data': "exame" },
                { 'data': "data_agendamento" },
                { 'data': "nome_setor" },
                { 'data': "status_final" },

            ],
            // "order": [[1, 'asc']],
            "columnDefs": [
                {
                    "targets": [10],
                    "visible": true,
                    //         "searchable": false
                }
            ],
        });
    });
}



/*--------------------------------------------------------------------------------------------------*/

function arredonandarString(data, inicio, fim) {
    data = data.substring(inicio, fim);
    return data;
}

/*--------------------------------------------------------------------------------------------------*/

function status(dados) {
    nstatus = '';
    dados = parseInt(dados);
    if (dados === 5) {
        console.log('cancelado')
        nstatus = 3;
        return nstatus
    } else if (dados === 1 || dados === 3) {
        console.log('Aguardando')
        nstatus = 1
        return nstatus
    } else if (dados = 2) {
        console.log('Em antedimentos')
        nstatus = 2
        return nstatus
    }
}



/*--------------------------------------------------------------------------------------------------*/


function ocultaDados(dado, status) {
    status = parseInt(status);
    if (status === 2 || status === 5) {
        return dado
    } else {
        return " "
    }
}