<?php
 
   try{

	
    $conexao = new PDO("mysql:host=itechbd.mysql.database.azure.com;dbname=hcor", "itechflow@itechbd", "Itechm@ster_2018"); 
    }catch(PDOException $e){
        echo "Erro gerado " . $e->getMessage(); 
    }
?>

