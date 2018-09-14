(function () {
    var url_atual = window.location.href;

    var parametrosDaUrl = url_atual.split("?")[1];

    chamadaAjax(`php/selectsJson.php?parametro=lista_do_setor&${parametrosDaUrl}`, lista_de_pacientes);
})();


/*================================================================================= */
//tabela

function lista_de_pacientes(data) {
    var tbody = document.getElementById("lista_pacientes");
    if (tbody) {
        for (i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');

            var cols =
                '<td>' + data[i].IH + '</td>' +
                '<td>' + data[i].paciente + '</td>' +
                '<td>' + '-' + '</td>' +
                '<td>' + '-' + '</td>';
            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
        data_table()
    }
}


function data_table() {
    $(document).ready(function () {
        $('#tabela_pacientes').DataTable({
            "paging": false,
            "bFilter": false,
            language: {
                "lengthMenu": " Quantidade por Pagina _MENU_  ",
                "zeroRecords": "Não encontrado pacientes",
                "info": "Total de Pagina _PAGE_ de _PAGES_",
                "infoEmpty": " ",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Filtrar:",
                // "paginate":  {
                //     "first": " ",
                //     "next": "Proxima",
                //     "previous": "Anterior",
                //     "last": " "
                // }
            }
        });
    });
}