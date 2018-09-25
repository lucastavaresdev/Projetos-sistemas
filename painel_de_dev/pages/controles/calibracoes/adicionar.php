<!-- Row -->
<div class="row center" id="row-middle">

	<!-- Col -->
	<div class="col-lg lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header -->
			<div class="box-header" id="header2">

				<i class="fa fa-wrench"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Calibrações</label>
				<div class="box-headerbutton corner right" onclick="pageTab(1,2)" ajax><i class="fa fa-times"></i></div>
			</div>

			<!-- Box Content -->
			<div class="box-content">

				<form id="form2" autocomplete="off">

					<input type="hidden" id="id" name="id">
					<input type="hidden" id="command" name="command">

					<div class="row">
						<div class="col-2 formlabel lg">Equipamento</div>
						<div class="col-10 formcontrol lg">
							<select id="id_equipamento" name="id_equipamento" required />
								<option value="">Nenhuma opção encontrada</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Responsável</div>
						<div class="col-10 formcontrol lg">
							<select id="id_usuario" name="id_usuario" required />
								<option value="">Nenhuma opção encontrada</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Última Calibração</div>
						<div class="col-4 formcontrol lg"><input type="datetime-local" id="calibracao_ultima" name="calibracao_ultima" value="" required /></div>

						<div class="col-2 formlabel lg">Situação</div>
						<div class="col-4 formcontrol lg">
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
						<div class="col-10 formcontrol lg"><input type="text" id="observacao" name="observacao" value="" /></div>
					</div>

				</div>
				<!-- Box Content -->

				<!-- Box Footer -->
				<div class="box-footer">
					<label id="box-status2" class="box-status sm hide">Status</label>
					<button type="button" onclick="pageTab(1,2)"class="button sm" ajax><label>Fechar</label></button>
					<button type="submit" class="button sm" ajax><i class="fa fa-save"></i><label>Salvar</label></button>
				</div>
				<!-- Box Footer -->

			</form>

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->