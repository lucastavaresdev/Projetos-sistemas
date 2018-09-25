<!-- Row -->
<div class="row center" id="row-middle">

	<!-- Col -->
	<div class="col-lg lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header -->
			<div class="box-header" id="header2">

				<i class="fa fa-user"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Usuários</label>
				<div class="box-headerbutton corner right" onclick="pageTab(1,2)" ajax><i class="fa fa-times"></i></div>
			</div>
			
			<form id="form2" autocomplete="off">

			<!-- Box Content -->
			<div class="box-content">

				<input type="hidden" id="id" name="id">
				<input type="hidden" id="command" name="command">

				<div class="row">
					<div class="col-2 formlabel lg">Nome</div>
					<div class="col-10 formcontrol lg"><input type="text" id="nome" name="nome" value="Usuários 4" required /></div>
				</div>

				<div class="row">
					<div class="col-2 formlabel lg">Cadastro</div>
					<div class="col-4 formcontrol lg"><input type="text" id="cadastro" name="cadastro" value="004" required /></div>
						
					<div class="col-2 formlabel lg">Sexo</div>
					<div class="col-4 formcontrol lg">
						<select id="sexo" name="sexo" required>
							<option value="Masculino" selected>Masculino</option>
							<option value="Feminino">Feminino</option>
						</select>
					</div>
				</div>
					
				<div class="row">
					<div class="col-2 formlabel lg">Login</div>
					<div class="col-4 formcontrol lg"><input type="text"id="login" name="login" maxlength="16" placeholder="Máx 16 caractéres" required /></div>
						
					<div class="col-2 formlabel lg">Senha</div>
					<div class="col-4 formcontrol lg"><input type="password"id="senha" name="senha" maxlength="16" placeholder="Máx 16 caractéres" required /></div>
				</div>
				
				<div class="row">
					<div class="col-2 formlabel lg">Perfil</div>
					<div class="col-4 formcontrol lg">
						<select id="perfil" name="perfil" required>
							<option value="1" selected>Nível 1</option>
							<option value="2">Nível 2</option>
							<option value="3">Nível 3</option>
							<option value="4">Nível 4</option>
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

			</div>
			<!-- Content -->

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