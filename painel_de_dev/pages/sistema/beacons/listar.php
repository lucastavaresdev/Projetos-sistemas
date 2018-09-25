<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header1">

				<i class="fa fa-bluetooth-b"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Beacons</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
				<div class="box-headerbutton right" onclick="listar('box1')" ajax><i class="fa fa-16 fa-refresh"></i></div>
				<div class="box-headerbutton right" onclick="adicionar('2')" ajax><i class="fa fa-plus"></i></div>

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
								<th onclick="setOrder(this, 2)">Modelo</th>
								<th onclick="setOrder(this, 3)">Mac</th>
								<th onclick="setOrder(this, 4)">UUID</th>
								<th onclick="setOrder(this, 5)">Major</th>
								<th onclick="setOrder(this, 6)">Minor</th>								
								<th onclick="setOrder(this, 7)">Vinculo/Categoria</th>
								<th onclick="setOrder(this, 8)">Temperatura</th>
								<th onclick="setOrder(this, 9)">Umidade</th>
								<th onclick="setOrder(this, 10)">Status</th>								
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