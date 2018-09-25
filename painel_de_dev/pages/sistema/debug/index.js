
function log(file){

    pageTab('2');
    
    var conteudo = document.getElementById('conteudo');
    
    var request = new XMLHttpRequest();
    request.open('GET', 'gateway/_logs/'+file.id);
    
    request.onreadystatechange = function() {
    
        if (request.readyState === 4) {
    
            var textfileContent = request.responseText;
            
            conteudo.innerText = textfileContent;
    
            console.log(textfileContent);
    
        }    
    }    
    request.send();

}