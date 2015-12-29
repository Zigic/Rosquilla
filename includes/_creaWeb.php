<?php
$x = $i+1;
$esqueletoSeccion ='

<?php
require "clases/class.db.php";
require "clases/class.pagina.php";
$configura = new Pagina();
$nombre = $configura->rescata("web");
$vista = $configura->rescata("vista");
$numero = $configura->rescata("numero");
$seccion = $configura->rescata("seccion'.$x.'");
$secciones = $configura->secciones($numero,'.$i.');
$social = $configura->social();
$carrusel = $configura->slider();
$noticias = $configura->noticias($vista,$seccion);

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $nombre ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<!-- Font Awesome-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	<!-- Mis estilos -->
    <link rel="stylesheet" href="css/style.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

	<body>
	<div class="container col-md-12">
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.php"><?php echo $nombre; ?></a>
		    </div>
		    <div>
		      <ul class="nav navbar-nav">
		      	<?php echo $secciones.$social; ?>
		      </ul>
		    </div>
		  </div>
		</nav>

		<div class="salvaNav"></div>

		<?php 
			echo $noticias;
		 ?>

	</div>
	<div class="salvaPie col-md-12"></div>
	<!-- Footer -->
	<div class="pie text-center navbar-fixed-bottom"><p><strong><?php echo $nombre ?></strong> glaseado <strong>X</strong> Rosquilla CMS</p></div>
	
	</body>
	</html>';

$esqueletoHome = '

<?php

require "clases/class.db.php";
require "clases/class.pagina.php";


$configura = new Pagina();
$nombre = $configura->rescata("web");
$slider = $configura->rescata("slider");
$vista = $configura->rescata("vista");
$numero = $configura->rescata("numero");
$seccion = $configura->rescata("seccion1");
$secciones = $configura->secciones($numero,0);
$social = $configura->social();
$carrusel = $configura->slider();
$noticias = $configura->noticias($vista,$seccion);

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $nombre ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	<!-- Font Awesome-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	<!-- Mis estilos -->
    <link rel="stylesheet" href="css/style.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">

</head>

	<body>
	<div class="container col-md-12">
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
			    <div class="navbar-header">
			      <a class="navbar-brand" href="index.php"><?php echo $nombre; ?></a>
			    </div>
			    <div>
			      <ul class="nav navbar-nav">
			      	<?php echo $secciones.$social; ?>
			      </ul>
			    </div>
		  </div>
		</nav>

		<?php 
			if ($slider == "si") { echo $carrusel;}
			echo $noticias;
		 ?>

	</div>
	<div class="salvaPie col-md-12"></div>
	<!-- Footer -->
	<div class="pie text-center navbar-fixed-bottom"><p><strong><?php echo $nombre ?></strong> glaseado <strong>X</strong> Rosquilla CMS</p></div>
	
	</body>
	</html>';
?>

