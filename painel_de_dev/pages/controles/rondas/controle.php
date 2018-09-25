<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-10 col-offset-1 lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header3">

				<i class="fa fa-wrench"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Controle</label>
				<div class="box-headerbutton corner right" onclick="pageTab('1')" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>

			</div>
			<!-- Box Header-->

			<!-- Box Content-->
			<div class="box-content">

				<div class="col-12 center">
					<label class="controle-title" id="controle-title">Controle Title</label>
				</div>

				<div class="row">

					<div class="col-12 xs">
						<div class="controle-box xs">
							<label class="controle-subtitle">Ronda</label>
							
							<form id="form3" data-tabid="3" autocomplete="off">
							
							<input type="hidden" id="command" name="command" value="atualizar_ronda" />
							<input type="hidden" id="id" name="id" value="" />
							
							<div class="row">
								<div class="col-2 formlabel lg">Data/Hora</div>
								<div class="col-10 formcontrol lg"> <input type="datetime-local" id="datahora" name="datahora" required /> </div>
							</div>

							<div class="row">
								<div class="col-2 formlabel lg">Situação</div>
								<div class="col-10 formcontrol lg">
									<select id="situacao" name="situacao" required>
										<option value="Disponível" selected>Disponível</option>
										<option value="Utilizado">Utilizado</option>
										<option value="Reservado">Reservado</option>
										<option value="Necessita Higienizar">Necessita Higienizar</option>
										<option value="Em Higienização">Em Higienização</option>
										<option value="Necessita Manutenção">Necessita Manutenção</option>
										<option value="Em Manutenção">Em Manutenção</option>
										<option value="Não Encontrado">Não Encontrado</option>
									</select>
								</div>
							</div>
							
							<div class="row">
								<div class="col-2 formlabel lg">Observação</div>
								<div class="col-10 formcontrol lg"> <input type="text" id="observacao" name="observacao" /> </div>
							</div>
							
							<button type="submit" class="button controle-button"><label>Atualizar Ronda</label></button>
							<label id="box-status3" class="box-status sm hide" style="display:block">Status</label>

							</form>

						</div>
					</div>

				</div>

			</div>
			<!-- Box Content-->

			<!-- Box Footer -->
			<div class="box-footer">
				<label id="box-status3" class="box-status sm hide">Status</label>
				<div class="button sm" onclick="pageTab('1')" ajax><i class="fa fa-times"></i><label>Fechar</label></div>
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->
	
</div>
<!-- Row -->