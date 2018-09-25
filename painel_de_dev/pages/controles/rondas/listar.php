<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header1">

				<i class="fa fa-eye"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Rondas</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
				<div class="box-headerbutton right" onclick="search('box1')" ajax><i class="fa fa-16 fa-refresh"></i></div>
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
								<th></th>
								<th onclick="setOrder(this, 3)">Equipamento</th>
								<th onclick="setOrder(this, 4)">Fabricante</th>
								<th onclick="setOrder(this, 6)">Série e Patrimônio</th>
								<th onclick="setOrder(this, 10)">Próxima Ronda</th>
								<th onclick="setOrder(this, 14)">Situação</th>
								<th onclick="setOrder(this, 17)">Origem</th>
								<th onclick="setOrder(this, 21)">Localização</th>
								<th onclick="setOrder(this, 25)">Visto por último</th>
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
				<div class="button red sm" onclick="search('box1')" ajax><i class="fa fa-refresh"></i><label>Atualizar</label></div>
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->