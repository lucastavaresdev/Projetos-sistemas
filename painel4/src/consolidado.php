<?php
    include('./templates/header.php');
    include('./templates/menu.php');
?>

<link rel="stylesheet" href="./css/consolidado.css">


<div class="col s12 conteudo espacamento">
    <div class="row">
        <div class="col s12 l3 c_centralizando">
            <h1 class="c_titulo left c_agendamento">Consolidado</h1>
        </div>
        <div class="col s12 l4 center  ">
            <h1 class="c_titulo" id="con_data_atual">--/--/--</h1>
        </div>
        <div class="col s6 l5 ">
            <h1 class="c_titulo right">
                <!-- <span>Tempo Restante 00:00:00</span> -->
            </h1>
        </div>
    </div>


    <div class="row c_linha_card_superior">

        <div class="col s12 l3">
            <div class="row c_linha_card_superior">
                <div class="col s12 m12">
                    <div class="card-panel center">
                        <span class="c_total_card">Agendados:
                            <b class="right" id="con_agendados"> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 l3">
                <div class="row c_linha_card_superior">
                    <div class="col s12 m12">
                        <div class="card-panel center">
                            <span class="c_total_card">Procedimentos:
                                <b class="right"  id="con_procedimento"> - </b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        <div class="col s12 l3">
            <div class="row c_linha_card_superior">
                <div class="col s12 m12">
                    <div class="card-panel center">
                        <span class="c_total_card">Checkin:
                            <b class="right" id="com_checkin"> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 l3">
            <div class="row c_linha_card_superior">
                <div class="col s12 m12">
                    <div class="card-panel center">
                        <span class="c_total_card">Checkout:
                            <b class="right" id="com_checkout"> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- <div class="col s12 l3">
            <div class="row">
                <div class="col s12 m12">
                    <div class="card-panel center con_padding">
                        <span class="c_total_card c_total_card_inferior">Não Iniciado:
                            <b class="right" id="con_naoIniciado"> 0 </b>
                        </span>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col s12 l3">
            <div class="row">
                <div class="col s12 m12">
                    <div class="card-panel center con_padding">
                        <span class="c_total_card c_total_card_inferior">Aguardando:
                            <b class="right" id=con_aguardando> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 l3">
            <div class="row">
                <div class="col s12 m12 ">
                    <div class="card-panel center con_padding">
                        <span class="c_total_card c_total_card_inferior">Em atendimento:
                            <b class="right" id="con_emAtendimento"> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 l3">
            <div class="row">
                <div class="col s12 m12">
                    <div class="card-panel center con_padding">
                        <span class="c_total_card c_total_card_inferior">Cancelado:
                            <b class="right" id="con_cancelado"> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 l3">
            <div class="row">
                <div class="col s12 m12">
                    <div class="card-panel center con_padding">
                        <span class="c_total_card c_total_card_inferior">Finalizado:
                            <b class="right" id="con_finalizado"> - </b>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    <div class="row" id="con_card_setores"></div>

    </div>
</div></div>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125496401-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments); }
        gtag('js', new Date());
      
        gtag('config', 'UA-125496401-1');
</script>

<?php include('./templates/frameworks.html') ?>
</body>
<script src="./js/consolidados.js"></script>
</html>