<?php
         include "./templates/header.php";
           include "./templates/menu.php";
?>

<div class="col s12 agendamento conteudo espacamento">
	<div class="row">
		<div class="col s12">
			<h6 class='titulo_agendamento'>Agendamentos</h6>
		</div>
	</div>
	<div class="row">
		<div class="col s12 l9">
			<table id="tabela_pacientes"  class="responsive-table tabela-cor " style="width:100%" >
				<thead>
					<tr>
						<th  class="ocutarmobile ocultar"></th>
						<th class="ocultar">id_agendamento</th>
						<th>hora</th>
						<th>atividade</th>
						<th>IH</th>
						<th>paciente</th>
						<th>servico</th>
						<th>Localização</th>
						<th>status</th>
						<th class="ocultar">Obs</th>
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
					</tr>
				</thead>
				<tbody id="listadePacientes"></tbody>
			</table>
			<div class="row status_agendamento"><?php include './templates/status.html';?></div>
		</div>
		<div class="col  s12 l3 info ">
			<div class="cor2 bordas">
				<div class="row">
					<div class="col s12" id="agendamemento_card_notificacao">
				</div>
			</div>
		</div>
	</div>
</div>
				 
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125496401-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments); }
        gtag('js', new Date());
      
        gtag('config', 'UA-125496401-1');
</script>



<?php
   include './templates/frameworks.html';
   ?>
   <script src="./js/agendamentos.js"></script>


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