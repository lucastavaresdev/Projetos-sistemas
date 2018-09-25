<div class="header-dock md" id="search" style="width: 580px; font-size: 15px;">
	<input id="search-box" type="text" placeholder="Pesquisar..." onkeyup="search()" style="width: 40%;" />

	<select id="filter" onchange="search()" style="width: 27%;">
		<option value="">Filtrar por data</option>
		<option value="0">Hoje</option>
		<option value="1">Amanhã</option>
		<option value="7">Próximos 7 Dias</option>
		<option value="14">Próximos 14 Dias</option>
		<option value="31">Próximos 31 Dias</option>
		<option value="60">Próximos 60 Dias</option>
		<option value="">Todos</option>
	</select>

<!--

	<div id='btnIntervalo' class='button'>
		<i class='fa fa-12 fa-calendar'></i>
	</div>
	
 	<input id="start-date" type="date" onchange="setDate(this)" style="width: 20%;" />
	<input id="end-date" type="date" onchange="setDate(this)" style="width: 20%;" />

	<div id='btnFiltro' class='button'>
		<i class='fa fa-12 fa-filter'></i>
	</div> 

	<div class='button'>
		<i class='fa fa-12 fa-print'></i>
	</div>

-->

</div>