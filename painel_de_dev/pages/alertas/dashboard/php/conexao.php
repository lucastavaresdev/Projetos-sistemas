<?php
    try{
		
		
	//   $connectionMysql = mysqli_connect("itechbd.mysql.database.azure.com", "itechflow@itechbd", "Itechm@ster_2018", "nipo");     
	
    $conexao = new PDO("mysql:host=itechbd.mysql.database.azure.com;dbname=nipo", "itechflow@itechbd", "Itechm@ster_2018"); 
    }catch(PDOException $e){
        echo "Erro gerado " . $e->getMessage(); 
    }
?>

