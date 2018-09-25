<div class="header-dock sm" id="search" style="width: 320px;">
	<input id="search-box" type="text" placeholder="Pesquisar..." onkeyup="search()" style="width: 100%;" />
        <!-- Começa dessa div-->
            <div id="DivFiltroData" style="visibility: hidden;"> 
                    <div class='col-1'> 
                       <label><i><b>Pesquisar Por Data:</b></i></label>
                    </div>
                    <div class='col-7'> 
                        <input type='text' id="filtroData" placeholder="dia/mes/ano" onkeyup="
                        var valorTextBox = this.value;
                        if (valorTextBox.match(/^\d{2}$/) !== null) {
                            this.value = valorTextBox + '/';
                        } else if (valorTextBox.match(/^\d{2}\/\d{2}$/) !== null) {
                            this.value = valorTextBox + '/';
                        }" ></input>
                    </div>
                    <div class='col-1'> 
                        <button type="button" id="filtroData" class="buttonAgendamentos" style="background-color:rgb(170,170,170);" onclick="listar()" >Pesquisar</button>
                    </div>
           </div> 
</div>