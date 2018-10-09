function chamadaAjax(urldoSelect, funcao) {
    if (typeof urldoSelect == 'string' && typeof funcao == 'function') {
        $.ajax({
            dataType: "json", // tipo de arquivo
            url: urldoSelect,// local do json
            data: 'linha', // linha
            success: function (data) {//se funcionar execulta essa função
                funcao(data);
            }//fim funcao
        });//fim do ajax
    } else {
        console.log('Erro de paramentro')
    }
}
