
(function () {
    var url_atual = window.location.href;
    var parametrosDaUrl = url_atual.split("?")[1];
    chamadaAjax(`php/selectsJson.php?parametro=relatorio_de_paciente_ativos`, lista_de_pacientes);
})();



/*
 *---------------------Lista de Paciente---------------------------
 */
function lista_de_pacientes(data) {

    var tbody = document.getElementById("listadePacientes");
    if (tbody) {
        for (i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');

            var cols = '<td class="ocultar">' + ' ' + '</td>' +
                '<td>' + data[i].atendimento + '</td>' +
                '<td>' + data[i].ih_paciente + '</td>' +
                '<td>' + data[i].paciente + '</td>' +
                '<td>' + data[i].codigo_agenda + '</td>' +
                '<td>' + data[i].sexo + '</td>' +
                '<td>' + data[i].nome_medico + '</td>' +
                '<td>' + data[i].exame + '</td>' +
                '<td>' + data[i].data_agendamento + '</td>' +
                '<td>' + data[i].checkout + '</td>' +
                '<td>' + data[i].checkin + '</td>' +
                '<td>' + data[i].tempo + '</td>';

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
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                { 'data': "atendimento" },
                { 'data': "ih_paciente" },
                { 'data': "paciente" },
                { 'data': "codigo_agenda" },
                { 'data': "sexo" },
                { 'data': "nome_medico" },
                { 'data': "exame" },
                { 'data': "data_agendamento" },
                { 'data': "checkout" },
                { 'data': "checkin" },
                { 'data': "tempo" }

            ],
            // "order": [[1, 'asc']],
            // "columnDefs": [
            //     {
            //         "targets": [14],
            //         "visible": true,
            //         "searchable": false
            //     }
            // ],
        });
    });
}



/*------------------------------------------------------------------------------------------------------------------------------------*/


