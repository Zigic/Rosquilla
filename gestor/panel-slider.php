<?php
session_start();
if (empty($_SESSION ['usuario'])){
  echo'<script language="javascript">window.location="index.php"</script>'; 
}
require '../clases/class.db.php';
require '../clases/class.pagina.php';
require '../clases/class.noticias.php';

$configura= new Pagina();
$nombre = $configura->rescata('web');
$opcion = $configura->rescata('slider');
 
$noticias = new Noticias();

if(isset($_POST["crear"])) {
$noticias->guardaSlider();
}

if(isset($_POST["elimina"])) {
$noticias->elimina($_POST['Eliid'],$_POST['Elititular'],$_POST['Eliimagen'],'slider');
}
if(isset($_POST["actualiza"])) {
$noticias->actualizaSlider();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $nombre; ?> : Gestor</title>
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

  <!-- Font Awesome-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <!-- favicon -->
  <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="../images/favicon.ico" type="image/x-icon">

  <script type="text/javascript">

      function cambio(uno){
            document.getElementById(uno).style.display = "block" ;
        }
      function desCambio(uno){
            document.getElementById(uno).style.display = "none" ;
        }
  </script>
  </head>

  <body>
  <div class="container">
        <div class="jumbotron salvaNav">
            <h1>Panel de Administración - Slider</h1>
        </div>
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="../index.php"><?php echo $nombre; ?></a>
            </div>
            <div>
              <ul class="nav navbar-nav">
                <li><a href="panel-noticias.php">Noticias</a></li>
                <li class="active"><a href="#">Slider</a></li>
              </ul>
              <ul class="nav navbar-nav derec">
                <li><a href="../includes/cierraSesion.php">Cerrar Sesión</a></li>
              </ul>
            </div>
          </div>
        </nav>

        <?php
            if ($opcion == "si"){
              echo '
              <!--formulario subir imagen-->
              <div class="row">
                <form role="form" enctype="multipart/form-data" method="post" action="">
                    <div class="form-group">
                      <label >Tituar:</label>
                      <input type="text" class="form-control" name="titular">
                      <label >Texto:</label>
                      <input type="text" class="form-control" name="resumen">
                      <label >Imagen <span class="text-warning">(edita tus fotos y sube todas del mismo tamaño)</span>:</label>         
                      <input type="file" class="form-control" name="imagen" >          
                    </div>
                    <div class="form-group text-center">
                      <div class="">
                        <button type="submit" name ="crear" class="btn btn-default">Publica</button>
                      </div>
                    </div>  
                </form>
              </div>

              <!--Cabecera noticias-->
              <div class="col-md-9 text-center"><strong>Titular</strong></div>
              <div class="col-md-1 text-center"><strong>Imagen</strong></div>';

              $noticias->muestraSlider();
            }
            else{
              echo '<div class="alert alert-info">No tienes la opción de slider activa.</div>';
            }
        ?>



    </div>

</body>
</html>
