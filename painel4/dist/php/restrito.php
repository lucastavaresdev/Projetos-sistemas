<?php
 //login_success.php  
 session_start();  

 if(isset($_SESSION["username"]))  
 {  
    $setor = $_SESSION['servicos'];
     header("location:../dashboard.php?setor=$setor");
    }  
    else  
    {  
        header("location:./index.php");  
 }  