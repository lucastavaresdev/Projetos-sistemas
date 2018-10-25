<?php
    header("Refresh:180");
    include "./templates/header.php";
    $setor = $_GET['setor'];
?>

<?php include "./templates/menu.php"; ?>
    <div class="row">
        <div class="  col s12 dados_consolidados">
            <div class="col s12 conteudo bg-consolidado espacamento">
            <?php echo "<a  href='./agendamentos.php?setor=$setor'>"?> 
                        <div class="col s6 l2 ">
                            <div class="dash_btn_superior fade-in">
                                <p>Agendamentos</p>
                                <h4  id="agendimentos_do_dia">
                                <span>0</span>
                                </h4>
                            </div>
                        </div>
                        <?php echo "</a>"?> 
                <?php echo "<a>"?>
                    <div class="col s6 l2">
                        <div class="dash_btn_superior_sem_hover fade-in">
                            <p>Procedimentos</p>
                            <h4 id='qtd_procedimentos'>0</h4>
                        </div>
                    </div>
                    <?php echo "</a>"?>
                    <?php echo "<a>"    ?>
                <div class="col s6 l2">
                    <div class="dash_btn_superior_sem_hover fade-in">
                        <p>Atendimentos</p>
                        <h4><span id='d_pacientes_finalizados'>0</span>/<span id="atendimentos_total">0</span></h4>
                    </div>
                </div>
                <?php echo "</a>"    ?>
                <?php echo "<a  href='./maior_fluxo.php?setor=$setor'>"?> 
                    <div class="col s6 l2 tamanho_da_linha_titulo_fluxo">
                        <div class="dash_btn_superior m-fluxo fade-in">
                            <p>Fluxo de Tempo</p>
                            <ul id="fluxo"></ul>
                        </div>
                    </div>
                    <?php echo "</a>"?>
                    
                    <?php echo "<a>"    ?>
                        <div class="col s6 l2">
                            <div class=" dash_btn_superior_sem_hover fade-in">
                            <p>Qtd de pacientes atuais</p>
                            <h4><span id='qtd_pacientes_atuais'>0<span></h4>
                            </div>
                        </div>
                    <?php echo "</a>"?>
                    <?php echo "<a>"    ?>
                        <div class="col s6 l2">
                            <div class="dash_btn_superior_sem_hover fade-in">
                            <p>Tempo Medio de Sala</p>
                            <h4><span id="tempo_medio_de_sala">0</span></h4>
                            </div>
                        </div>
                    <?php echo "</a>"?>
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
                    <li class="tab col s12 l2 right input-calendario">
                            <input type="text"  id="busque_data" class="datepicker right figuras " placeholder="Busque por uma datas">
                    </li>
                </ul>
                <div id="test1" class="col s12 tabela_bg">
                    <table id="tabela_pacientes"  class="responsive-table tabela-cor " style="width:100%" >
                        <thead>
                            <tr>
                                    <th></th>
                                    <th class="ocultar">id_agendamento</th>
                                    <th>paciente</th>
                                    <th>hora</th>
                                    <th>atividade</th>
                                    <th>IH</th>
                                    <th class="ocultar">codigo_exame</th>
                                    <th class="ocultar">codigo_servico</th>
                                    <th class="ocultar">servico</th>
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
                                    <th class="ocultar">tempo_decorrido_do_exame<</th>
                                    <th class="ocultar">status</th>
                                    <th class="ocultar">desc_status</th>
                                    <th class="ocultar">tempo_espera</th>
                                    <th class="ocultar">localizacao</th>
                                    <th class="ocultar">observacao</th>
                                    <th class="ocultar">hora_agendamento</th>
                                    <th class="ocultar">proximo_exame</th>
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
