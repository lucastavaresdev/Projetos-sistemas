
<?php
    include('./templates/header.php');
    include('./templates/menu.php');
    
    ?>

<link rel="stylesheet" href="./css/ativos.css">

    <div class="row">
        <div class="  col s12 dados_consolidados">
            <div class="col s12 conteudo bg-consolidado espacamento">
                <h1 class='subtitulospaginas'>Pacientes Ativos no Momento</h1>
            </div>
        </div>
    </div>

    <div class="col s12 agendamento conteudo">
        <div class="row">
            <div class="col s12">
            
                <div id="test1" class="col s12 tabela_bg">
                    <table id="tabela_ativos"  class="responsive-table tabela-cor " style="width:100%" >
                        <thead>
                            <tr>
                                <th class='ocultar'> </th>
                                <th>Paciente</th>
                                <th>Atendimento</th>
                                <th>IH Paciente</th>
                                <th>Codigo Agenda</th>
                                <th>Sexo</th>
                                <th>Médico</th>
                                <th>Exame</th>
                                <th>Data Agendamento</th>
                                <th>Checkout</th>
                                <th>Checkin</th>
                                <th>Tempo</th>
                            </tr>
                        </thead>
                        <tbody id="listadePacientes"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </di    v>


<!-- The Modal -->
<div id="elempai">

</div>

</body>

<?php
   include './templates/frameworks.html';
?>
<script src="./js/ativos.js"></script>



<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125496401-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments); }
        gtag('js', new Date());
      
        gtag('config', 'UA-125496401-1');
</script>



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
