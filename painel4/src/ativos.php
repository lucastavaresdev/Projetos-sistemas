<?php
    // header("Refresh:180");
     include "./templates/header.php";
    // $setor = $_GET['setor'];
?>

<?php include "./templates/menu.php"; ?>
    <div class="row">
        <div class="  col s12 dados_consolidados">
            <div class="col s12 conteudo bg-consolidado espacamento">
            </div>
        </div>
    </div>

    <div class="col s12 agendamento conteudo">
        <div class="row">
            <div class="col s12">
            
                <ul class="tabs">
                    <li class="tab col s12 l3">
                        <a id="aba_nome_setor" class="active" href="#test1"> - </a>
                    </li>
                </ul>
                <div id="test1" class="col s12 tabela_bg">
                    <table id="tabela_pacientes"  class="responsive-table tabela-cor " style="width:100%" >
                        <thead>
                            <tr>
                                <th  class="ocutarmobile"></th>
                                <th class="ocultar">id_agendamento</th>
                                <th>Hora</th>
                                <th>Atividade</th>
                                <th>IH</th>
                                <th>Paciente</th>
                                <th>Servico</th>
                                <th>Localização</th>
                                <th>Status</th>
                                <th>Obs</th>
                                <th class="ocultar">codigo_exame</th>
                                <th class="ocultar">codigo_servico</th>
                                <th class="ocultar">descricao_exame</th>
                                <th class="ocultar">anotacao</th>
                                <th class="ocultar">sexo</th>
                                <th class="ocultar">data_nascimento</th>
                                <th class="ocultar">nome_medico</th>
                                <th class="ocultar">crm</th>
                                <th class="ocultar">checkin_unidade</th>
                                <th class="ocultar">checkout_unidade</th>
                                <th class="ocultar">tempo_vinculado</th>
                                <th class="ocultar">checkin_exame</th>
                                <th class="ocultar">checkout_exame</th>
                                <th class="ocultar">tempo_exame</th>
                                <th class="ocultar">tempo_decorrido_do_exame</th>
                                <th class="ocultar">desc_status</th>
                                <th class="ocultar">tempo_espera</th>
                                <th class="ocultar">observacao</th>
                            </tr>
                        </thead>
                        <tbody id="listadePacientes"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row"><?php include './templates/status.html'; ?></div>
    </div>


<!-- The Modal -->
<div id="elempai">

</div>

</body>

<?php
   include './templates/frameworks.html';
?>
<script src="./js/index.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125496401-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments); }
        gtag('js', new Date());
      
        gtag('config', 'UA-125496401-1');
</script>


<script>
 $(document).ready(function(){
    $('.modal').modal();
  });
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
