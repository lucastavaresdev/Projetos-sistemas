<!-- Row -->
<div class="row center" id="row-middle">

	<!-- Col -->
	<div class="col-lg lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header -->
			<div class="box-header" id="header2">

				<i class="fa fa-wifi"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Gateways</label>
				<div class="box-headerbutton corner right" onclick="pageTab(1,2)" ajax><i class="fa fa-times"></i></div>
			</div>

			<!-- Box Content -->
			<div class="box-content">

				<form id="form2" autocomplete="off">

					<input type="hidden" id="id" name="id">
					<input type="hidden" id="command" name="command">

					<div class="row">
						<div class="col-2 formlabel lg">Setor</div>
						<div class="col-10 formcontrol lg">
							<select id="id_sala" name="id_sala" required />
								<option value="">Nenhuma opção encontrada</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Mac</div>
						<div class="col-4 formcontrol lg"><input type="text" id="gateway" name="gateway" value="" required /></div>

						<div class="col-2 formlabel lg">RSSI</div>
						<div class="col-4 formcontrol lg"><input type="text" id="maxrssi" name="maxrssi" value="-70" required /></div>
					</div>

					<div class="row">
						<div class="col-2 formlabel lg">Time-In</div>
						<div class="col-4 formcontrol lg"><input type="text" id="timein" name="timein" value="10" required /><label class="input-tip">Segundos</label></div>

						<div class="col-2 formlabel lg">Time-Out</div>
						<div class="col-4 formcontrol lg"><input type="text" id="timeout" name="timeout" value="60" required /><label class="input-tip">Segundos</label></div>
					</div>

					<div class="row">

						<div class="col-2 formlabel lg">Status</div>
						<div class="col-4 formcontrol lg">
							<select id="status" name="status" required>
								<option value="1" selected>Ativo</option>
								<option value="0">Inativo</option>
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