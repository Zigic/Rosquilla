<?php

session_start();

require '../clases/class.db.php';
require '../clases/class.pagina.php';


$configura = new Pagina();
$nombre = $configura->rescata('web');

if(isset($_POST['login'])){
$configura->logate();
   
}

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $nombre ?> : Gestor</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Mis estilos -->
  <link rel="stylesheet" href="../css/style.css">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

  <!-- favicon -->
  <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">

  </head>

  <body>

    <div class="container">
        <div class="row">
            <div class="login">
                <div class="">
                    <form method="post" action="" id="loginForm">
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control" type="text" name='usuario' placeholder="usuario"/>          
                        </div>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input class="form-control" type="password" name='password' placeholder="password"/>     
                        </div>
                        <div class="form-group">
                             <button type="submit" class="btn btn-def btn-block" name="login" >Entrar</button>
                        </div>
                    </form>        
                </div>  
            </div>    
        </div>
    </div>
        
  </body>
</html>
