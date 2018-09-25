<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header1">

				<i class="fa fa-cogs"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Equipamentos</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
				<div class="box-headerbutton right" onclick="listar('box1')" ajax><i class="fa fa-16 fa-refresh"></i></div>

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
								<th onclick="setOrder(this, 2)">Equipamento</th>
								<th onclick="setOrder(this, 3)">Fabricante</th>
								<th onclick="setOrder(this, 5)">Série e Patrimônio</th>
								<th onclick="setOrder(this, 6)">Próxima Ronda</th>
								<th onclick="setOrder(this, 6)">Próxima Calibração</th>
								<th onclick="setOrder(this, 15)">Situação</th>
								<th onclick="setOrder(this, 16)">Ativo</th>
								<th onclick="setOrder(this, 17)">Origem</th>
								<th onclick="setOrder(this, 17)">Localização</th>
								<th onclick="setOrder(this, 17)">Visto por último</th>
								<th class="center">Ação</th>
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