function chamadaAjax(a,n){"string"==typeof a&&"function"==typeof n?$.ajax({dataType:"json",url:a,data:"linha",success:function(a){n(a)}}):console.log("Erro de paramentro")}