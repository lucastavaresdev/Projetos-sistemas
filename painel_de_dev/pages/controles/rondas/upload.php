<!-- Row -->
<div class="row center" id="row-middle">

	<!-- Col -->
	<div class="col-lg lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header -->
			<div class="box-header" id="header5">

				<i class="fa fa-paperclip"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Anexos</label>
				<div class="box-headerbutton corner right" onclick="pageTab(1,2)" ajax><i class="fa fa-times"></i></div>
			</div>

			<!-- Box Content -->
			<div class="box-content">

				<form id="form3" autocomplete="off">

					<input type="hidden" id="id_upload" name="id">
					<input type="hidden" id="command_upload" name="command">

					<div class="row">
						<div class="col-9 formcontrol lg upload-close" id="control1">
							<input type="text" id="filename1" readonly />
							<div class="upload-bar" id="uploadbar1"></div>
						</div>
						<div class="col-3 formcontrol lg center"><button type="button" class="button td lg" style="width: 200px;" id="button1" onclick="fileBrowser(1)"><label id="label1" style="padding-right: 0px">Selecionar Arquivo</label></button></div>
						<input type="file" id="file1" name="file1" onchange="fileValidation(this, 1)" hidden />
					</div>

					<div class="row">
						<div class="col-9 formcontrol lg upload-close" id="control2">
							<input type="text" id="filename2" readonly />
							<div class="upload-bar" id="uploadbar2"></div>
						</div>
						<div class="col-3 formcontrol lg center"><button type="button" class="button td lg" style="width: 200px;" id="button2" onclick="fileBrowser(2)"><label id="label2" style="padding-right: 0px">Selecionar Arquivo</label></button></div>
						<input type="file" id="file2" name="file2" onchange="fileValidation(this, 2)" hidden />
					</div>

					<div class="row">
						<div class="col-9 formcontrol lg upload-close" id="control3">
							<input type="text" id="filename3" readonly />
							<div class="upload-bar" id="uploadbar3"></div>
						</div>
						<div class="col-3 formcontrol lg center"><button type="button" class="button td lg" style="width: 200px;" id="button3" onclick="fileBrowser(3)"><label id="label3" style="padding-right: 0px">Selecionar Arquivo</label></button></div>
						<input type="file" id="file3" name="file3" onchange="fileValidation(this, 3)" hidden />
					</div>

				</form>

			</div>
			<!-- Box Content -->

				<!-- Box Footer -->
				<div class="box-footer">
					<label id="box-status5" class="box-status sm hide">Status</label>
					<button type="button" onclick="pageTab(1,2)"class="button sm" ajax><label>Fechar</label></button>
				</div>
				<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->