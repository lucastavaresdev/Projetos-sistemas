<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header1">

				<i class="fa fa-map-marker"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label style='display: contents'>Tracking Usuários</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
				<div class="box-headerbutton right" onclick="listarFechados()"><i class="fa fa-16 fa-align-justify"></i> <label class='hide-portrait'>Fechados</label></div>

			</div>
			<!-- Box Header-->

			<!-- Box Content-->
			<div class="box-content">

				<div class="table-responsive">
					<table class="table-stripped table-hover">
					<thead>
							<tr>
								<th></th>
								<th>Gateway</th>
								<th>Setor</th>
								<th>RSSI</th>
								<th>Usuário</th>
								<th>Cadastro</th>
								<th>Major - Minor</th>								
								<th>Checkin</th>
								<th>Visto por Último</th>
								<th>Tempo</th>
							</tr>
						</thead>
						<tbody id="ativos">
						</tbody>
					</table>
				</div>

			</div>
			<!-- Box Content-->

			<!-- Box Footer -->
			<div class="box-footer">
				<label id="box-status1" class="box-status sm hide">Status</label>
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->