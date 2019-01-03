<ul id="setores_lista" class="dropdown-content"></ul>
<?php
    if (isset($_GET['setor'])) {
        $setor =$_GET['setor'];//PARAMETRO
    } else {
        $setor = "";//PARAMETRO
    }
?>
<nav>
    <div class="nav-wrapper a1">
        <div class="row">
            <div class="col s4">
                <div class="logo">
                    <?php
                    echo "<a href='./dashboard.php?setor=$setor'>Work
                        <b>Flow</b>
                    </a>";
                    ?>
                </div>
            </div>
            <div class="col s4 center titulo_mobile_estrutura">
                <div id="titulo_do_setor" class="titulo_consolidado"></div>
            </div>
            <div class="col s1 offset-s3 setor_espacamento setor_mobile_estrutura">
                <ul id="setores">
                    <div>
                        <a class="drop_topo mobile" href="#!" data-target="setores_lista">Setores
                            <i class="material-icons right icon_mobile_menu">arrow_drop_down</i>
                        </a>
                        <a class="drop_topo mobile2 " href="#!" data-target="setores_lista">
                            <i class="material-icons right icon_mobile_menu icon">more_vert </i>
                        </a>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!--Sidenav-->
<ul id="slide-out" class="sidenav">
    <div class="row">
        <div class="grid">
            <div class="col s10 conteudo_side">
                <li>
                    <div class="user-view">
                        <div class="background bg_nav">
                            <img class="bg_nav" src="img/nav_bg.jpg">
                        </div>
                        <img class="logo-sidenav" src="img/logo.png">
                        </a>
                        <span class="name"></span>
                        </a>
                        <span class=" email"></span>
                        </a>
                    </div>
                </li>
                <li>
                    <a href="dashboard.php?setor=92">
                        <i class="material-icons">dashboard</i>Dashboard</a>
                </li>
                <li>
                    <a href="consolidado.php">
                        <i class="material-icons">grid_on</i>Consolidado</a>
                </li>
                <li>
                    <a href="ativos.php">
                       <i class="material-icons">blur_linear</i>Pacientes Ativos</a>
                </li>
                <!-- <li>
                    <a href="localizacao.php">
                        <i class="material-icons">blur_on</i>Localizacao</a>
                </li> -->
                <!-- <li>
                    <a href="painel_pacientes.php">
                        <i class="material-icons">clear_all</i>Paciente</a>
                </li> -->
             
                <!-- <li>
                    <a class="subheader">Relatórios</a>
                </li>
              
                <li>
                    <a class="waves-effect" href="#!">Fluxo de Paciente</a>
                </li> -->
                <li class="sair">
                    <a href="./php/logout.php">
                        <i class="material-icons">clear</i>Sair
                    </a>
                </li>
            </div>
            <div class="col s1">
                <div class="sidenav-trigger right close" data-target="slide-out" id="close-navbar">
                    <div class="icon-center">
                        <i class="material-icons">keyboard_arrow_left </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</ul>



<!-- <a href="#" data-target="slide-out" class="sidenav-trigger">
                <i class="material-icons">menu</i>
            </a> -->

<div class="row">
    <div class="sidenav-trigger tamanho-barra left open" id="open-navbar" data-target="slide-out">
        <div class="icon-center">
            <i class="material-icons">keyboard_arrow_right </i>
        </div>
    </div>