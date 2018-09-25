<!-- Row -->
<div class="row">

	<!-- Col -->
	<div class="col-12 lg">

		<!-- Box -->
		<div class="box">

			<!-- Box Header-->
			<div class="box-header" id="header">

				<i class="fa fa-map-marker"></i><i class="fa fa-spinner fa-spin hide"></i><i class="fa fa-exclamation-triangle hide"></i>
				<label>Gateways</label>
				<div class="box-headerbutton corner right" onclick="closeBox(this)" ajax><i class="fa fa-16 fa-times"></i></div>
				<div class="box-headerbutton right" onclick="minimizeBox(this)"><i class="fa fa-16 fa-chevron-up"></i></div>

			</div>
			<!-- Box Header-->

			<!-- Box Content-->
			<div class="box-content">

				<div class="table-responsive">
					<table class="table-stripped table-hover">
					<thead>
                        <tr>
                            <th></th>
                            <th>Gateway</th>
                        </tr>
                    </thead>
                    <tbody id="lista">
                        <?php
                            
                            $dir = "gateway/logs";
                            $dh  = opendir($dir);
                            $i = 1;
                            while (false !== ($filename = readdir($dh))) {
                                if($filename != '.' && $filename != '..'){
                                    $files[] = $filename;
                                    echo '<tr>';
                                    echo '<td>'.$i.'</td>';
									echo '<td onclick="log(this)" id="'.$filename.'">'.substr($filename, 0, 12).'</td> </a>';              
									echo "<td style='width: 20%;'>".date("d/m/Y H:i:s", filemtime($dir.'/'.$filename))."</td>";                                                          
                                    echo '</tr>';
                                    $i++; 
                                }                                                                   
                            }
                            //var_dump($files);
                        ?>
                    </tbody>
					</table>
				</div>

			</div>
			<!-- Box Content-->

			<!-- Box Footer -->
			<div class="box-footer">
				<label id="box-status1" class="box-status sm hide">Status</label>
			</div>
			<!-- Box Footer -->

		</div>
		<!-- Box -->

	</div>
	<!-- Col -->

</div>
<!-- Row -->