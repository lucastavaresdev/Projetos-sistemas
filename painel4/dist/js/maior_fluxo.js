var url_atual = window.location.href;

var parametrosDaUrl = url_atual.split("?")[1];

chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_procedimento&${parametrosDaUrl}`, intervaloprocedimento);
chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_pacientes&${parametrosDaUrl}`, intervalopaciente);


setInterval(function () {
    (function () {
        var url_atual = window.location.href;

        var parametrosDaUrl = url_atual.split("?")[1];

        chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_procedimento&${parametrosDaUrl}`, intervaloprocedimento);
        chamadaAjax(`php/selectsJson.php?parametro=qtd_por_horario_de_pacientes&${parametrosDaUrl}`, intervalopaciente);
    })();
}, 300000);


function intervaloprocedimento(data) {
    var tbody = document.getElementById("qtd_por_horario_de_procedimento");
    if (tbody) {
        for (i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');

            var cols =
                '<td>' + data[i].intervalo_de_horas + '</td>' +
                '<td><b>' + data[i].Qtd + '</b></td>'

            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
    }
}

function intervalopaciente(data) {
    var tbody = document.getElementById("qtd_por_horario_de_pacientes");
    if (tbody) {
        for (i = 0; i < data.length; i++) {
            var tr = document.createElement('tr');

            var cols =
                '<td>' + data[i].intervalo_de_horas + '</td>' +
                '<td><b>' + data[i].Qtd + '</b></td>'

            var linha = tr.innerHTML = cols;
            tbody.innerHTML += linha;
        }
    }
}



function data_table() {
    $(document).ready(function () {
        $('#tabela_pacientes').DataTable({
            language: {
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