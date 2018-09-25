
//=========================================================================================
// Onload
//=========================================================================================
window.onload = listar;

//=========================================================================================
// Database
//=========================================================================================
_database = 'pages/unidade/agendamentos/database.php';

//=========================================================================================
// Listar
//=========================================================================================
var search = listar;


//seta visible as divs
document.getElementById("search-box").hidden = true;
document.getElementById("DivFiltroData").style.visibility = "visible";

var dataJson ="";

                         
setInterval(function(){
           	
      //metodo seta valor tracking 
      retornaTracking(this,0);          
}, 2000);


function listar() {
    
	var searchBox = byid('search-box');
	var searchText = searchBox.value;
        
        var filtroData = document.getElementById("filtroData").value;

	var searchOrder = byid('order').value || 3;
	var orientation = 'asc';
   
	var ajaxData = {
		url: _database,
		command: 'listar',
		success: geraEtiquetas,
		search: searchText,
		order: searchOrder,
		orientation: orientation,
                filtroData:filtroData
	}

	ajaxQuery(ajaxData);

}


//=========================================================================================
// After Post
//=========================================================================================
function afterPost(command) {

	listar();

}

function FormataData(data){ 
try {
    var ano = data.substring(0,4);  
    var mes = data.substring(5,7);
    var dia = data.substring(8, 10);

    var dataFormatada = dia+"/"+mes+"/"+ano;
    return dataFormatada;
}
    catch(err) {

    }
}

function geraEtiquetas(data) {

document.getElementById("listaEtiquetaHtml").innerHTML="";

	if (data.length > 0) {
        
	   _data = data[0];

        var html = '';

		for (var i=0; i < _data.length; i++) {                   
                    
                    if (_data[i].anotacao == null){_data[i].anotacao="";}
                    if (_data[i].tp_sexo == "M"){_data[i].tp_sexo="Masculino";}else{_data[i].tp_sexo="Feminino"}
                     
                    //metodo seta valor tracking 
                    retornaTracking(_data[i].cd_aviso_Cirurgia,i);
                    
                          document.getElementById("listaEtiquetaHtml").innerHTML  +=
                        "<div class='row'>"+ 
                           "<div class='col-12'>"+ 
                                "<div class='box-content' style='border-radius: 12px;padding: 10px 10px;''>"+  
                                     "<p style='background-color: #d9edf7;border-radius: 8px'>"+
                                        "<label hidden><b>cd Cirugia:</b></label>"+ 
                                         "<label id='cd_aviso_Cirurgia_"+i+"' hidden>"+_data[i].cd_aviso_Cirurgia+"</label>"+
                                         "<label><b>Nome Paciente:</b></label>"+ 
                                         "<label>"+_data[i].nm_paciente+"</label>"+
                                         "<label><b>Sexo Paciente:</b></label>"+ 
                                         "<label>"+_data[i].tp_sexo+"</label>"+   
                                         "<label><b>Data Nascimento:</b></label>"+ 
                                         "<label>"+FormataData(_data[i].dt_nascimento)+"</label>"+ 
                                         "<label><b>Idade Paciente:</b></label>"+ 
                                         "<label>"+_data[i].idade+"</label>"+ 
                                         "<label><b>Convenio Paciente:</b></label>"+ 
                                         "<label>"+_data[i].convenio+"</label>"+
                                         "<button type='button' id='realizarEntrevista' class='buttonAgendamentos' style='visibility: hidden;'>Realizar Entrevista</button>" +
                                     "</p>"+
                                      "<p>"+ 
                                        "<label><b>Exame:</b></label>"+ 
                                         "<label>"+_data[i].Cirurgia+"</label>"+
                                         "<label><b>Data Agendamento:</b></label>"+ 
                                         "<label>"+_data[i].Data_cirurgia+"</label>"+  
                                         "<label><b>Primeiro Agendamento:</b></label>"+ 
                                         "<label>"+formataHora(_data[i].Hora_cirurgia)+"</label>"+ 
                                     "</p>"+ 
                                     "<pstyle='background-color: rgb(112, 179, 204);border-radius: 8px'>"+ 
                                     "<label><b>Centro Cirurgico:</b></label>"+ 
                                         "<label>"+_data[i].Centro_Cirurgico+"</label>"+
                                          "<label><b>Cirurgiao:</b></label>"+ 
                                         "<label>"+_data[i].Cirurgiao+"</label>"+
                                         "<label><b>Anestesista:</b></label>"+ 
                                         "<label>"+_data[i].Anestesista+"</label>"+
                                     "</p>"+
                                     "<p>"+  
                                         "<label><b>Observacao:</b></label>"+ 
                                         "<label>"+_data[i].Observacao+"</label>"+  
                                     "</p>"+ 
                                     "<p>"+
                                        "<table>"+
                                            "<tr>"+
                                               "<th>Setor</th>"+ 
                                               "<th>Horario Inicial</th>"+ 
                                               "<th>Horario Final</th>"+ 
                                            "</tr>"+
                                            "<tr>"+            
                                               "<td id='trackingIdSetor_"+i+"'></td>"+ 
                                               "<td id='trackingIdChekIn_"+i+"'></td>"+ 
                                               "<td id='trackingIdChekOut_"+i+"'></td>"+ 
                                            "</tr>"+
                                         "</table>"+
                                    "</p>"+
                                    
                                    "<p>"+
                                         "<label><b>Anotacao Livre :</b></label>"+
                                         "<div class='col-10'>"+ 
                                            "<input type='text' id='"+i+"' value='"+_data[i].anotacao+"'></input><br>"+
                                         "</div>"+      
                                            "<button type='button' id='botaoAnotacao"+i+"' class='buttonAgendamentos' onclick='SalvaAnotacao("+_data[i].cd_aviso_Cirurgia+","+i+")'>Salvar</button>" +
                                    "</p>"+
                                "</div>"+ 
                            "</div>"+    
                       "</div>"+               
                      "<br></br>"; 
              
              
                    
		}


	} else {

		document.getElementById("listaEtiquetaHtml").innerHTML = "";

	}
        
  dataJson = data;

}

function SalvaAnotacao(cd_aviso_Cirurgia,idTexboxAnotacao) {

   var anotacao = document.getElementById(idTexboxAnotacao).value;
    
    var ajaxData = {
		url: _database,
		command: 'SalvaAnotacao',
		success: /*document.getElementById("modalAnotacao").showModal()*/alert("anotacao salvo com sucesso"),
                cd_aviso_Cirurgia: cd_aviso_Cirurgia,
                anotacao:anotacao
	}

	ajaxQuery(ajaxData);
        
        location.reload();
        
}


function retornaTracking(cd_aviso_Cirurgia,idTextBoxTracking) { 
 
 try{
if( dataJson ==""){
    var ajaxData = {
                    url: _database,
                    command: 'RetornaTracking',                 
                    success: retornaTrackingHtml,
                    cd_aviso_Cirurgia:cd_aviso_Cirurgia,
                    idTextBoxTracking: idTextBoxTracking
            }

            ajaxQuery(ajaxData);
}else{
    
    for (var i=0; i < dataJson.length; i++) {  
  
         var cd_aviso_Cirurgia= dataJson[0][i].cd_aviso_Cirurgia;
        
            var ajaxData = {
                        url: _database,
                        command: 'RetornaTracking',                 
                        success: retornaTrackingHtml,
                        cd_aviso_Cirurgia:cd_aviso_Cirurgia,
                        idTextBoxTracking: i
                }

                ajaxQuery(ajaxData);

            }        
}
} catch(err) {

    } 

}

function retornaTrackingHtml(data) { 
    try {    
      
        document.getElementById("trackingIdSetor_"+data[0][0].idtextBox).innerHTML = data[0][0].nome;
        document.getElementById("trackingIdChekIn_"+data[0][0].idtextBox).innerHTML = formataHora(data[0][0].checkin);
        document.getElementById("trackingIdChekOut_"+data[0][0].idtextBox).innerHTML = formataHora(data[0][0].checkout);
        
               
    }
    catch(err) {

    }   
       
}

function formataHora(dataHora) {      
try {
    var hora = dataHora.substring(11,16);  

    return hora;
}
    catch(err) {

    }
    
}

