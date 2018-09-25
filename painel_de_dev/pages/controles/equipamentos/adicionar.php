<!-- Row -->
<div class="row center" id="row-middle">

	<!-- Col -->
	<div class="col-lg lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header -->
			<div class="box-header" id="header2">

				<i class="fa fa-cogs"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Equipamentos</label>
				<div class="box-headerbutton corner right" onclick="pageTab(1,2)" ajax><i class="fa fa-times"></i></div>
			</div>

			<!-- Box Content -->
			<div class="box-content">

				<form id="form2" autocomplete="off">

					<input type="hidden" id="id" name="id">
					<input type="hidden" id="command" name="command">

					<div class="row">
						<div class="col-2 formlabel lg">Nome</div>
						<div class="col-10 formcontrol lg"><input type="text" id="nome" name="nome" value="Equipamento 4" required /></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Marca</div>
						<div class="col-4 formcontrol lg"><input type="text" id="marca" name="marca" value="Marca 4" required /></div>

						<div class="col-2 formlabel lg">Modelo</div>
						<div class="col-4 formcontrol lg"><input type="text" id="modelo" name="modelo" value="Modelo 4" required /></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Nº Série</div>
						<div class="col-4 formcontrol lg"><input type="text" id="serie" name="serie" value="s004" required /></div>

						<div class="col-2 formlabel lg">Nº Patrimônio</div>
						<div class="col-4 formcontrol lg"><input type="text" id="patrimonio" name="patrimonio" value="p004" required /></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Ronda</div>
						<div class="col-4 formcontrol lg"><input type="text" id="ronda" name="ronda" value="7" required /><label class="input-tip">Dias</label></div>

						<div class="col-2 formlabel lg">Calibração</div>
						<div class="col-4 formcontrol lg"><input type="text" id="calibracao" name="calibracao" value="60" required /><label class="input-tip">Dias</label></div>
					</div>
					
					<div class="row">
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
						
						<div class="col-2 formlabel lg">Ativo</div>
						<div class="col-4 formcontrol lg">
							<select id="ativo" name="ativo" required>
								<option value="Ativo" selected>Ativo</option>
								<option value="Inativo">Inativo</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Setor de Origem</div>
						<div class="col-4 formcontrol lg">
							<select id="setorid" name="setorid">
								<option value="">Nenhuma opção encontrada</option>
							</select>
						</div>

					</div>

					</div>

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