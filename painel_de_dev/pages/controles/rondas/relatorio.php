<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header4">

				<i class="fa fa-calendar-check-o"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Relatório de Rondas</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
				<div class="box-headerbutton right" onclick="search('box1')" ajax><i class="fa fa-16 fa-refresh"></i></div>
				<div class="box-headerbutton right" onclick="listar()" ajax><i class="fa fa-16 fa-wrench"></i><label>Rondas</label></div>

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
							<th onclick="setOrder(this, 4)">Ultima Ronda</th>
							<th onclick="setOrder(this, 5)">Equipamento</th>
							<th onclick="setOrder(this, 6)">Fabricante</th>
							<th onclick="setOrder(this, 7)">Modelo</th>
							<th onclick="setOrder(this, 8)">Série</th>
							<th onclick="setOrder(this, 9)">Patrimônio</th>
							<th onclick="setOrder(this, 10)">Situação</th>
							<th onclick="setOrder(this, 11)">Responsável</th>
							<th onclick="setOrder(this, 12)">Observação</th>
							<th class="center">Ação</th>
							</tr>
						</thead>
						<tbody id="relatorio">
						</tbody>
					</table>
				</div>

			</div>
			<!-- Box Content-->

			<!-- Box Footer -->
			<div class="box-footer">
				<label id="box-status4" class="box-status sm hide">Status</label>
				<div class="button red sm" onclick="search('box1')" ajax><i class="fa fa-refresh"></i><label>Atualizar</label></div>
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->