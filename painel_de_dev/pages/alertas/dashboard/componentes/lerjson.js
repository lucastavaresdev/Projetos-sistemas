

//chamada de funções

function localizacao(data) {
    tabela_localizacao(data, '#tabela_localizacao')
}

setInterval(function () {
    chamadaAjax('php/selectsJson.php?parametro=setor', localizacao);
    chamadaAjax('php/selectsJson.php?parametro=localizacao', tabela);
},1000);


function tabela_localizacao(data, id_da_tabela, html) {
    var html = "";

    for (let i = 0; i < data.length; i++) {
        if(data[i].qtdsala === "" || data[i].qtdsala === null){
            setor = 0;
        }else{
            setor = data[i].qtdsala
        }





        html += '<tr class="linha_pacientes"><td class="nomesetor">' + data[i].nome + '</td><td class="status qtdpaciente">' + setor + '</td>';
    }

    document.getElementById("tabela_localizacao").innerHTML = html;
    var status = document.querySelectorAll(".status_localizacao");
    coresStatus(status);


}




//rastrio de pacientes
function tabela(data) {
    var html = "";
    if (data.length === 0) {
        html += '<tr><td colspan= "2">Nao ha pacientes no momento</td></tr>';
    } else {
        for (let i = 0; i < data.length; i++) {
            html += '<tr class="linha_pacientes"><td>' + data[i].paciente + '</td><td class="status"  class="' + data[i].setor + '">' + data[i].setor + '</td></tr>';
        }
    }
    document.getElementById("tabela").innerHTML = html;
    var status = document.querySelectorAll(".status");
    // coresStatus(status);
}



function error() {
    console.log('nao esta chamando a funçao')
}



//cores de status
function coresStatus(status) {
    for (i = 0; i < status.length; i++) {
        valordoStatus = status[i].textContent;
        if (valordoStatus == "Aguardando" || valordoStatus == "Disponivel") {
            status[i].setAttribute('class', 'status disponivel');
        } else if (valordoStatus == 'Indisponivel') {
            status[i].setAttribute('class', 'status Indisponivel');
        } else if (valordoStatus == 'finalizado') {
            status[i].setAttribute('class', 'status finalizado');
        } else if (valordoStatus == 'null') {
            status[i].setAttribute('class', 'status nenhum');
        } else {
            status[i].setAttribute('class', 'status emuso');
        }
    }
}


//total de pacientes
function totaldePaciente() {
    chamadaAjax('php/selectsJson.php?parametro=qtdpacientes', exibirTotalPaciente);
}

function exibirTotalPaciente(data) {
    var numTotal = document.querySelector('#totaldePacientes').textContent = data[0]['totpacientes'];;
}
