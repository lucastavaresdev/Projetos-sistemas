<!-- Row -->
<div class="row center" id="row-middle">

	<!-- Col -->
	<div class="col-lg lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header -->
			<div class="box-header" id="header2">

				<i class="fa fa-map-marker"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Setores</label>
				<div class="box-headerbutton corner right" onclick="pageTab(1,2)" ajax><i class="fa fa-times"></i></div>
			</div>

			<!-- Box Content -->
			<div class="box-content">

				<form id="form2" autocomplete="off">

					<input type="hidden" id="id" name="id">
					<input type="hidden" id="command" name="command">

					<div class="row">
						<div class="col-2 formlabel lg">Nome</div>
						<div class="col-10 formcontrol lg"><input type="text" id="nome" name="nome" value="Setor 4" required /></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Sigla</div>
						<div class="col-4 formcontrol lg"><input type="text" id="sigla" name="sigla" value="S4" required /></div>
						
						<div class="col-2 formlabel lg">Andar</div>
						<div class="col-4 formcontrol lg"><input type="text" id="andar" name="andar" value="0" required /></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Capacidade</div>
						<div class="col-4 formcontrol lg"><input type="text" id="capacidade" name="capacidade" value="0" required /><label class="input-tip">Pessoas</label></div>

						<div class="col-2 formlabel lg">Permanência</div>
						<div class="col-4 formcontrol lg"><input type="text" id="permanencia" name="permanencia" value="0" required /><label class="input-tip">Minutos</label></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Tracking</div>
						<div class="col-4 formcontrol lg">
							<select id="tracking" name="tracking" required>
								<option value="Automático" selected>Automático</option>
								<option value="Manual">Manual</option>
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
						<div class="col-2 formlabel lg">Atendimentos</div>
						<div class="col-4 formcontrol lg"><input type="text" id="atendimentos" name="atendimentos" value="1" required /><label class="input-tip">Simultâneos</label></div>
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