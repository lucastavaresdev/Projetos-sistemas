<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header1">

				<i class="fa fa-thermometer-half"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Temperatura e Umidade</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
				<div class="box-headerbutton right" onclick="listar('box1')" ajax><i class="fa fa-16 fa-refresh"></i></div>
				<div class="box-headerbutton right" onclick="relatorio()" ajax><i class="fa fa-16 fa-calendar-check-o"></i><label>Relatório</label></div>

			</div>
			<!-- Box Header-->

			<!-- Box Content-->
			<div class="box-content">

				<div class="table-responsive">
					<table class="table-stripped table-hover">
					<input id="order" type='hidden'/>
					<thead>
							<tr>
								<th width="100px"></th>
								<th onclick="setOrder(this, 4)">MAC</th>
								<th onclick="setOrder(this, 5)">Nome</th>
								<th onclick="setOrder(this, 6)">Marca</th>
								<th onclick="setOrder(this, 7)">Modelo</th>
								<th onclick="setOrder(this, 8)">Série</th>
								<th onclick="setOrder(this, 9)">Patrimônio</th>
								<th onclick="setOrder(this, 10)">Setor Atual</th>
								<th onclick="setOrder(this, 12)">Temperatura</th>
								<th onclick="setOrder(this, 13)">Umidade</th>
								<th onclick="setOrder(this, 14)">Bateria</th>
							</tr>
						</thead>
						<tbody id="lista">
						</tbody>
					</table>
				</div>

			</div>
			<!-- Box Content-->

			<!-- Box Footer -->
			<div class="box-footer">
				<label id="box-status1" class="box-status sm hide">Status</label>
				<div class="button red sm" onclick="listar('box1')" ajax><i class="fa fa-refresh"></i><label>Atualizar</label></div>
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->