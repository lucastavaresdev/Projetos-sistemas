<!-- Row -->
<div class="row" hidden>

	<!-- Col -->
	<div class="col-12">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header1">

				<i class="fa fa-calendar"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Agendamentos</label>
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
								<th></th>
                                                                <th onclick="setOrder(this, 5)">Codigo Cirurgia </th>
								<th onclick="setOrder(this, 1)">Data Agendamento</th>
								<th onclick="setOrder(this, 2)">Hora Agendamento</th>
								<th onclick="setOrder(this, 3)">Nome Paciente</th>
                                                                <th onclick="setOrder(this, 6)">Nome Exame</th>
								<th onclick="setOrder(this, 5)">Observação </th>                                                               
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
				<div class="button red sm" onclick="listar('box1')" ajax><i class="fa fa-refresh"></i><label>Atualizar</label></div>
			</div>                        
                                                                     
		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>

<dialog id="modalAnotacao">Anotacao salva com sucesso</dialog>

<!--Gera etiquetas -->                      
 <div id="listaEtiquetaHtml"></div>

