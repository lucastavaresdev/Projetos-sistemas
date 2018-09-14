<?php
         include "./templates/header.php";
         include "./templates/menu.php";
?>


<section class="agendamento pacientes col s12 conteudo">
        
        <div class="row topo"> 
                <!-- <h1 class='center text-center titulo'>Atendimento</h1> -->
        </div> 
        
        <div class="row">
                    <div class="row">

                            <div class="col s12 l12  ">
                                <div class="cor1 bordas">
                                    <div id="tabela_conteudo" class="col s12 tabela_bg">
                                        <table id="tabela_pacientes" class="striped responsive-table">
                                            <thead>
                                                <tr>
                                                    <th>IH</th>
                                                    <th>Paciente</th>
                                                    <th>Localização</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                                <tbody id="lista_pacientes">
                                                        <tr>
                                                        <td>9171471</td>
                                                        <td>Julio Gael Osvaldo Silva</td>
                                                        <td>Ecocardiograma</td>
                                                        <td><div  class=" status-1 center-status">1</div></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>8933958</td>
                                                        <td>Heitor Rafael Lima</td>
                                                        <td>Ecocardiograma</td>
                                                        <td><div  class=" status-2 center-status">1</div></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>9171443</td>
                                                        <td>Márcia Emilly Corte Real</td>
                                                        <td>Endoscopia</td>
                                                        <td><div  class=" status-3 center-status">1</div></td>

                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>9171481</td>
                                                        <td>Natália Fernanda Lopes</td>
                                                        <td>Ultrassonografia</td>
                                                        <td><div  class=" status-3 center-status">1</div></td>
                                                        </tr>

                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col  s12 l3 info ">
                                <div class="cor2 bordas">
                                    <div class="row">
                                        <div class="col s12" id="agendamemento_card_notificacao"></div>
                                    </div>
                                </div>
                            </div>
                   </div>
        </div>

</section>


<?php
   include './templates/frameworks.html';
?>

<script src="./js/painel_pacientes.js"></script>


<script>
    $(document).ready(function () {
        $('.tabs').tabs();
    });
</script>


<script>
    $(document).ready(function () {
        $('select').formSelect();
    });
</script> 

<?php
   include './templates/footer.html';
   ?>