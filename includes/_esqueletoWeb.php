<?php

$txt = '<?php

require "../clases/class.db.php";
require "../clases/class.pagina.php";


$configura = new Pagina();
$nombre = $configura->rescata("web");
$numero = $configura->rescata("numero");
$secciones = $configura->seccionesEspecial($numero);
$social = $configura->social();

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
    <link rel="stylesheet" href="../css/style.css">

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
		<div class="well col-md-10 col-md-offset-1 salvaNav text-center"><h2>'.$seccion.'<h2></div>
		<div class="col-md-10 col-md-offset-1">
			<img class="img-thumbnail" src="'.$imaName.'">
			<h2>'.$titular.'</h2>
			<h4>'.nl2br($resumen).'</h4>
			<p>'.nl2br($noticia).'<p>
		</div>

	</div>
	<div class="salvaPie col-md-12"></div>
	<!-- Footer -->
	<div class="pie text-center navbar-fixed-bottom"><p><strong><?php echo $nombre ?></strong> glaseado <strong>X</strong> Rosquilla CMS</p></div>
	  	
</body>
</html>';

?>