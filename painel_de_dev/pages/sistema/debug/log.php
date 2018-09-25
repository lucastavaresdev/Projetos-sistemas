<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12 lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header">

				<i class="fa fa-map-marker"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Log</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>
			</div>
			<!-- Box Header-->

			<!-- Box Content-->
			<div class="box-content">

				<div id='conteudo' style='overflow-wrap: break-word;'>
					
				</div>

			</div>
			<!-- Box Content-->

			<!-- Box Footer -->
			<div class="box-footer">
				<label id="box-status1" class="box-status sm hide">Status</label>
				<button type="button" onclick="pageTab(1,2)" class="button sm" ajax><label>Fechar</label></button>				
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->