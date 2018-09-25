	<div class="menu" id="menu">

		<div class="menuclose" onclick="closeMenu()"><i class="fa fa-bars"></i><label>Fechar Menu</label><i class="fa fa-times right"></i></div>

		<div class="menugroup top active" onclick="minimizeMenu(this, 'sistema')"><i class="fa fa-cog"></i><label>Sistema</label><i class="fa fa-12 fa-chevron-down right"></i></div>
			<div class="menulinks" id="sistema">
			<div class="menulink" onclick="linkMenu('sistema/gateways')"><i class="fa fa-wifi"></i><label>Gateways</label></div>
			<div class="menulink" onclick="linkMenu('sistema/beacons')"><i class="fa fa-bluetooth-b"></i><label>Beacons</label></div>
			<div class="menulink" onclick="linkMenu('sistema/calibrar')"><i class="fa fa fa-cog"></i><label>Calibrar</label></div>
			<!-- <div class="menulink" onclick="linkMenu('sistema/track-equip')"><i class="fa fa-map-marker"></i><label>Tracking Equipamentos</Em></label></div> -->
			<div class="menulink" onclick="linkMenu('sistema/track-user')"><i class="fa fa-map-marker"></i><label>Tracking Usuários</label></div>
			</div>

		<div class="menugroup active" onclick="minimizeMenu(this, 'unidade')"><i class="fa fa-building"></i><label>Unidade</label><i class="fa fa-12 fa-chevron-down right"></i></div>
			<div class="menulinks" id="unidade">			
			<!-- <div class="menulink" onclick="linkMenu('unidade/agendamentos')"><i class="fa fa fa-calendar"></i><label>Agendamentos</label></div> -->
			<div class="menulink" onclick="linkMenu('unidade/vincular-pac')"><i class="fa fa fa-chain"></i><label>Vincular Pacientes</label></div>			
			<!-- <div class="menulink" onclick="linkMenu('unidade/vincular-equip')"><i class="fa fa fa-chain"></i><label>Vincular Equipamentos</label></div>	 -->
			<div class="menulink" onclick="linkMenu('unidade/pac-vinculados')"><i class="fa fa fa-check"></i><label>Pacientes Vinculados</label></div>			
			<!-- <div class="menulink" onclick="linkMenu('unidade/equipamentos')"><i class="fa fa-plug"></i><label>Equipamentos</label></div> -->
			<div class="menulink" onclick="linkMenu('unidade/usuarios')"><i class="fa fa-user"></i><label>Usuários</label></div>
			<div class="menulink" onclick="linkMenu('unidade/setores')"><i class="fa fa-building"></i><label>Setores</label></div>
			</div>

		<!-- <div class="menugroup active" onclick="minimizeMenu(this, 'controles')"><i class="fa fa-file-text-o"></i><label>Controles</label><i class="fa fa-12 fa-chevron-down right"></i></div>
			<div class="menulinks" id="controles">
			<div class="menulink" onclick="linkMenu('controles/equipamentos')"><i class="fa fa-plug"></i><label>Equipamentos</label></div>
			<div class="menulink" onclick="linkMenu('controles/calibracoes')"><i class="fa fa-wrench"></i><label>Calibrações</label></div>
			<div class="menulink" onclick="linkMenu('controles/rondas')"><i class="fa fa-eye"></i><label>Rondas</label></div>
			<div class="menulink" onclick="linkMenu('controles/temperatura')"><i class="fa fa-thermometer-half"></i><label>Temperatura e Umidade</label></div>
			</div> -->

		<!-- <div class="menugroup active" onclick="minimizeMenu(this, 'alertas')"><i class="fa fa-pie-chart"></i><label>Painel de Alertas</label><i class="fa fa-12 fa-chevron-down right"></i></div>
			<div class="menulinks last" id="alertas">
			<div class="menulink" onclick="linkMenu('pages/alertas/dashboard/index.html')"><i class="fa fa-tachometer"></i><label>Dashboard</label></div>
			<div class="menulink" onclick="linkMenu('alertas/fora')"><i class="fa fa-plug"></i><label>Fora do Setor de Origem</label></div>			
			<div class="menulink" onclick="linkMenu('alertas/calibracao')"><i class="fa fa-wrench"></i><label>Calibração</label></div>
			<div class="menulink" onclick="linkMenu('alertas/ronda')"><i class="fa fa-eye"></i><label>Ronda</label></div>
			<div class="menulink" onclick="linkMenu('alertas/temperatura')"><i class="fa fa-thermometer-half"></i><label>Temperatura e Umidade</label></div>
			<div class="menulink" onclick="linkMenu('alertas/situacao')"><i class="fa fa-question-circle"></i><label>Situação</label></div>
			</div> -->

	</div>