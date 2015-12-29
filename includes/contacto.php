<?php

require '../clases/class.db.php';
require '../clases/class.pagina.php';


$configura = new Pagina();
$nombre = $configura->rescata('web');
$numero = $configura->rescata('numero');
$secciones = $configura->seccionesEspecial($numero);
$social = $configura->social();

if(isset($_POST["enviar"])) {
$configura->correo($_POST['nombre'],$_POST['email'],$_POST['texto']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $nombre ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

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

</head>

	<body>
	<div class="container col-md-12">
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
			    <div class="navbar-header">
			      <a class="navbar-brand" href="../index.php"><?php echo $nombre; ?></a>
			    </div>
			    <div>
			      <ul class="nav navbar-nav">
			      	<?php echo $secciones.$social; ?>
			      </ul>
			    </div>
		  </div>
		</nav>

		<div class="linea salvaNav col-md-6 col-md-offset-3">
			<h3>Envianos tus inquietudes ,sugrencías, formas de mejorar la web ...</h3>
		</div>

		<form role="form" method="post" action="" class="contacto col-md-6 col-md-offset-3" >
			<div class="form-group">
			    <label>Nombre:</label>
			    <input type="text" class="form-control" id="nombre" placeholder="Nombre">
			    <label>Email:</label>
			    <input type="email" class="form-control" id="email" placeholder="Email">
			    <label >Texto:</label>
			    <textarea type="textarea" class="form-control" id="texto" placeholder="Duda,sugerencia,queja....."></textarea>
			    <div class="text-center">
			      	<button type="submit" class="btn btn-default" name="enviar">Enviar</button>
			    </div>
			</div>
		</form>

		<!-- Footer -->
		<div class="pie text-center navbar-fixed-bottom"><p><strong><?php echo $nombre ?></strong> glaseado <strong>X</strong> Rosquilla CMS</p></div>

	</div>

	</body>
	</html>