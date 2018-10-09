

<!DOCTYPE html>
<?php
 session_start();

 if (isset($_SESSION["username"])) {
     header("location:./dashboard.php");
 }
   

?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/materialize.css">
    <link rel="stylesheet" href="./css/login.css">


</head>

    <body class="bgl">
        <main class="valign-wrapper" id="login-page">
            <div class="container">
                <div class="center-align">
                <div class="row">
                    <div class="col s12 l5  offset-l3">
                        <div class="card">
                            <div class="card-content">
                                    <img class="logo_login" style="max-width: 200px;" ondurationchange=""class="responsive-img" src="./img/logo.png" alt="">
                                <div class="left-align">

                                    <form id="login-form" action="./php/login.php" method="post">
                                        <div class="row">

                                            <div class="col s12 input-field">
                                                <i class="material-icons prefix">account_circle</i>
                                                <input type="text" name="usuario" id="email" value="" placeholder="Login"/>
                                            </div>

                                            <div class="col s12 input-field">
                                                <i class="material-icons prefix">lock</i>
                                                <input type="password" name="senha" id="password" value="" placeholder="senha"/>
                                            </div>

                                            <div class="col s12 input-field">
                                                <button class="btn waves-effect waves-light btn_login right" type="submit"  name="btn_entrar">Entrar</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <?php
                                                if (isset($_GET['login']) && $_GET['login'] == "true") {
                                                    echo "<h5>Usuario e senha incorretos</h5>";
                                                }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125496401-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments); }
        gtag('js', new Date());
      
        gtag('config', 'UA-125496401-1');
</script>




      </body>
</html>