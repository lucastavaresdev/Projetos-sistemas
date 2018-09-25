<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">

		<title>iTechMed - Sistema/Login</title>

		<!-- CSS Files -->
		<link type="text/css" rel='stylesheet' href='css/font-awesome.css'>
		<link type="text/css" rel='stylesheet' href='css/triskelion.css'>
		<link type="text/css" rel='stylesheet' href='css/itechmed.css'>
		<!-- CSS Files -->

	</head>

	<body>

	<table class="login-container">
		<tr>
			<td>

				<div class="row">
					<div class="col-md">

					<!-- Box -->
					<div class="box">

						<!-- Box Header -->
						<div class="box-header">
							<i class="fa fa-user"></i><label>Login</label><div class="box-headerbutton corner right" onclick="closeModal('modal-login')"><i class="fa fa-16 fa-times"></i></div>
						</div>

						<!-- Box Content -->
						<div class="box-content">

							<form autocomplete="off">
							
								<input type="hidden" id="command" name="command" value="login" />
								<input type="hidden" id="page" data-g="<?php echo ($_GET["g"]) ?>" data-s="<?php echo ($_GET["s"]) ?>" data-p="<?php echo ($_GET["p"]) ?>" />
								<input type="hidden" id="sessao" name="sessao" value="login" />
								<input type="hidden" id="page" name="page" value="login" />

								<div class="row">
									<div class="col-2 formlabel md">Login</div>
									<div class="col-10 formcontrol md"><input type="text" id="login" name="login" value="" required /></div>
								</div>

								<div class="row">
									<div class="col-2 formlabel md">Senha</div>
									<div class="col-10 formcontrol md"><input type="password" id="senha" name="senha" value="" required /></div>
								</div>

						</div>
						<!-- Box Content -->

						<!-- Box Footer -->
						<div class="box-footer center">
							<label id="box-status1" class="box-status sm hide" style="display:block">Status</label>
							<button type="submit" class="button sm" onclick=""><i class="fa fa-unlock"></i><label>Logar</label></button>
						</div>
						<!-- Box Footer -->

							</form>

					</div>
					<!-- Box -->

					</div>
				</div>

			</td>
		</tr>

	</table>

		<!-- JS Files -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/triskelion.js"></script>
		<script type="text/javascript" src="pages/sistema/login/index.js"></script>
		<!-- JS Files -->

	</body>

</html>