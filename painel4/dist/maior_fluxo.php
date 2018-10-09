<?php
         include "./templates/header.php";
           include "./templates/menu.php";
?>

<div class="col s12 agendamento conteudo ">

<div class="row espacamento">
		<div class="col s12">
			<h6 class="maior_fluxo_titulo">Fluxo de Tempo</h6>
		</div>
	</div>
	<div class="row">

		<div class="col s12 l6 ">
			<div class="cor1 bordas">
				<div id="tabela_conteudo" class="col s12 tabela_bg">
				<h6 class="maior_fluxo_subtitulo">Por procedimento</h6>
					<table id="tabela_pacientes" class="striped responsive-table tabela-cor">
						<thead>
							<tr>
								<th>Horario</th>
								<th>Quantidade por Procedimento</th>
							</tr>
						</thead>
							<tbody id="qtd_por_horario_de_procedimento"></tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col s12 l6 ">
			<div class="cor1 bordas">
				<div id="tabela_conteudo" class="col s12 tabela_bg">
				<h6 class="maior_fluxo_subtitulo">Por Paciente</h6>
					<table id="tabela_pacientes" class="striped responsive-table tabela-cor">
						<thead>
							<tr>
								<th>Horario</th>
								<th>Quantidade de Pacientes</th>
							</tr>
						</thead>
							<tbody id="qtd_por_horario_de_pacientes"></tbody>
					</table>
				</div>
			</div>
		</div>

	</div>

<?php
   include './templates/frameworks.html';
   ?>
   <script src="./js/maior_fluxo.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125496401-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments); }
        gtag('js', new Date());
      
        gtag('config', 'UA-125496401-1');
</script>


<script>
    $(document).ready(function () {
        $('select').formSelect();
    });
</script> 

<?php
   include './templates/footer.html';
   ?>