<?php

class Pagina extends Db {

	private $direc = array();
	private $social = array("facebook","twitter","google","instagram","correo");

	public function slider(){
		$sql = "SELECT * FROM slider ";
		$resultado = $this->consulta($sql);
		$cont = 0;
		$caption = "";
		$head = '<div id="myCarousel" class="carousel slide col-md-8 col-md-offset-2 salvaNav" data-ride="carousel">
				 <ol class="carousel-indicators">';
		while ($row = mysqli_fetch_array($resultado)){
			if($cont == 0){
			$head .= '<li data-target="#myCarousel" data-slide-to="'.$cont.'" class="active"></li>';
			$caption .= '<div class="carousel-inner" role="listbox">
						    <div class="item active">
						      <img src="'.$row['imagen'].'" alt="Imagen Carrusel">
							    <div class="carousel-caption">
							        <h3>'.$row['titular'].'</h3>
							        <p>'.$row['resumen'].'</p>
							    </div>
							</div>';
			$cont++;
			}
			else{
			$head .= '<li data-target="#myCarousel" data-slide-to="'.$cont.'" ></li>';
			$caption .='<div class="item">
							<img src="'.$row['imagen'].'" alt="Imagen Carrusel">
							    <div class="carousel-caption">
							        <h3>'.$row['titular'].'</h3>
							        <p>'.$row['resumen'].'</p>
							    </div>
						</div>';
			$cont++	;		
			}
		}
		$caption .= '</div>';
		$head .= '</ol>';
		$tail = '
				  <!-- Left and right controls -->
				    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
						</a>
						  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						    <span class="sr-only">Next</span>
						  </a>
					 </div>';
		$carrusel = $head.$caption.$tail;
		return $carrusel;
	}

	public function sacaTitulo($titular){
		$titulo = $this->quitar_tildes($titular);
        $ruta = 'noticias/'; //ruta donde se guardara la noticia.
        $fichero = $ruta.$titulo.".php";
        return $fichero;
	}

	public function noticias($vista,$dato){
		//Crea cuerpo con las noticias,necesita saber la vista y la sección de la que se trata.
		$sql = "SELECT * FROM noticias ORDER BY recordDate DESC LIMIT 10";
		$resultado = $this->consulta($sql);
		$columna= "";
		$cont = 1;
		while ($row = mysqli_fetch_array($resultado)){
			$link = $this->sacaTitulo($row['titular']);
			$columna .='
						<div>
							<img class="img-thumbnail" src="images/'.$row['imagen'].'">
							<a href="'.$link.'"><h2>'.$row['titular'].'</h2></a>
						</div>';
		}
		$txt = ''; //cuerpo con noticias
		$tail = '';//columna
		if ($vista == "unaColumnaLate"){
			$txt .= '<div class="col-md-8 col-md-offset-1">';
			$tail = '<aside class="col-md-2 lateral col-md-offset-9">' .$columna.'</aside>';
		}
		if($vista == "dosColumnasLate"){
			$txt .= '<div class="col-md-10">';
			$tail = '<aside class="col-md-2 lateral col-md-offset-10">' .$columna.'</aside>';
		}
		$sql = "SELECT * FROM noticias WHERE seccion ='$dato' ORDER BY recordDate DESC";
		$resultado = $this->consulta($sql);
		while ($row = mysqli_fetch_array($resultado)){
			$link = $this->sacaTitulo($row['titular']);
			switch ($vista) {
					case 'unaColumna':
						$txt .='
								<div class="col-md-10 col-md-offset-1">
									<img class="img-thumbnail" src="'.$row['imagen'].'"></div>
									<a href="'.$link.'"><h2>'.$row['titular'].'</h2></a>
									<h4>'.nl2br($row['resumen']).'</h4>
									<p>'.substr($row['noticia'],0,1000).'<p>
								</div>';
						break;
					case 'unaColumnaLate':
						$txt .='
								<div class="col-md-8 col-md-offset-1">
									<img class="img-thumbnail" src="'.$row['imagen'].'"></div>
									<a href="'.$link.'"><h2>'.$row['titular'].'</h2></a>
									<h4>'.nl2br($row['resumen']).'</h4>
									<p>'.substr($row['noticia'],0,1000).'<p>
								</div>';
						break;
					case 'dosColumnas':
						$txt .='
								<div class="col-md-6 ">
									<img class="img-thumbnail" src="'.$row['imagen'].'"></div>
									<a href="'.$link.'"><h2>'.$row['titular'].'</h2></a>
									<h4>'.nl2br($row['resumen']).'</h4>
									<p>'.substr($row['noticia'],0,1000).'<p>
								</div>';
						break;
					case 'dosColumnasLate':
						if ($cont % 2 != 0){
							$txt .= '<div class="col-md-12">';
						}
						$txt .='
								<div class="col-md-6">
									<img class="img-thumbnail" src="images/'.$row['imagen'].'">
									<a href="'.$link.'"><h2>'.$row['titular'].'</h2></a>
									<h4>'.nl2br($row['resumen']).'</h4>
									<p>'.substr($row['noticia'],0,1000).'<p>
								</div>';
						if ($cont % 2 == 0){
							$txt .= '</div>';
						}
						$cont++;
						break;
			}
		}
		if ($vista == "unaColumnaLate"){
			$tail = '<aside class="col-md-2 lateral col-md-offset-9">' .$columna.'</aside>';
		}
		if($vista == "dosColumnasLate"){
			$txt .= '</div>';
		}
		$pagina = $txt.$tail;
		return 	$pagina;
	}

	public function rescata($dato){
		$sql = "SELECT $dato FROM configuracion";
		$resultado = $this->consulta($sql);
		while ($row = mysqli_fetch_array($resultado)){
			$valor = $row[$dato];
		}
		return $valor;
	}

	public function rescataSecciones($numero){
		$sql = "SELECT * FROM configuracion";
		$resultado = $this->consulta($sql);
		$txt = "";
		$cont =1;
		while ($row = mysqli_fetch_array($resultado)){
                for ($i=0; $i < $numero ; $i++) { 
                	$txt .= '<option value="'.$row['seccion'.$cont].'">'.$row['seccion'.$cont].'</option>';
                	$cont++;               
                }
        }
        return $txt;      
	}	

	public function secciones($numero,$posicion){
		//secciones del nav,parámetros el total y la posición para hacer el active.
		$cont=1;
		$valor ="";
		$sql = "SELECT * FROM configuracion";
		$resultado = $this->consulta($sql);
		while ($row = mysqli_fetch_array($resultado)){
			for ($i=0; $i<$numero ; $i++) { 
				$this->secciones[$i] = $row['seccion'.$cont];
				$cont++;
				if($i == $posicion){
					if ($i == 0){
					$valor .= '<li class="active"><a href="index.php">'.$this->secciones[$i].'</a></li>';
					}else{
					$valor .= '<li class="active"><a href="#">'.$this->secciones[$i].'</a></li>';
					}
				}
				else{
					if ($i == 0){
					$valor .= '<li><a href="index.php">'.$this->secciones[$i].'</a></li>';
					}else{
					$valor .= '<li><a href="'.$this->secciones[$i].'.php">'.$this->secciones[$i].'</a></li>';
					}	
				}
			}
		}
		return $valor;
	}

	public function seccionesEspecial($numero){
		$valor ="";
		$cont=1;
		$sql = "SELECT * FROM configuracion";
		$resultado = $this->consulta($sql);
		while ($row = mysqli_fetch_array($resultado)){
			for ($i=0; $i<$numero ; $i++) { 
				$this->secciones[$i] = $row['seccion'.$cont];
				if ($i == 0) {
					$valor .= '<li><a href="../index.php">'.$this->secciones[$i].'</a></li>';
					$cont++;	
				}else{
					$valor .= '<li><a href="../'.$this->secciones[$i].'.php">'.$this->secciones[$i].'</a></li>';
					$cont++;
				}
			}	
		}
		return $valor;
	}

	public function social(){
		$sql = "SELECT * FROM social";
		$resultado = $this->consulta($sql);
		$txt = "";
		while ($row = mysqli_fetch_array($resultado)){
			for ($i=0; $i < sizeof($this->social) ; $i++) { 
			    $this->direc[$i] = $row[$this->social[$i]];
			    if($this->direc[$i] != "no"){
				    switch ($this->social[$i]) {
	    				case "facebook":
		       				$txt .= '<li><a href="https:/'.$row['facebook'].'" target="_blank"><i class="fa fa-facebook"></i></a></li>';
					        break;
					    case "twitter":
					        $txt .= '<li><a href="https:/'.$row['twitter'].'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
					        break;
					    case "google":
					        $txt .= '<li><a href="https:/'.$row['google'].'" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
					        break;
					    case "instagram":
					        $txt .= '<li><a href="https:/'.$row['instagram'].'" target="_blank"><i class="fa fa-instagram"></i></a></li>';
					        break;
					    case "correo":
					        $txt .= '<li><a href="includes/contacto.php" target="_blank"><i class="fa fa-envelope"></i></a></li>';
					        break;
					}
				}	
			}
		}	
		return $txt;
	}

	public function muestraSecciones($numero){
		$valor ='';
		$cont = 1;
		$sql = "SELECT * FROM configuracion";
		$resultado = $this->consulta($sql);
		while ($row = mysqli_fetch_array($resultado)){
			for ($i=0; $i<$numero ; $i++) { 
					$valor .= '<input type="text" class="form-control" name="seccion'.$i.'" value="'.$row['seccion'.$cont].'" >';
					$cont++;
			}
		}
		return $valor;
	}

	public function correo($nombre,$email,$texto){
		if($nombre && $email && $texto == ""){
			echo "<div class='alert alert-danger'>Rellena todos los campos.</div>";
		}else{
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
				echo "<div class='alert alert-danger'>La dirección de correo no es válida.</div>";
			}else{
				$sql = "SELECT correo FROM social";
				$resultado = $this->consulta($sql);
				$email = $resultado;
				$asunto = "Desde Donete escribe ".$nombre." ".$email;
				mail($correo,$subject,$texto);
				echo '<div class="alert alert-success">Mail enviado.</div>';
			}
		}
	}

	public function logate(){
    	if(($_POST['usuario'] != '') && ($_POST['password'] != '') ){
 			$usuario= $_POST['usuario'];
    		$pass= $_POST['password'];
    		if ($usuario == $this->rescata('admin') && $pass == $this->rescata('contrasena')){
    			$_SESSION ['usuario'] = $usuario;
    			$_SESSION ['pass'] = $pass;
    			header('Location: panel-noticias.php');
			}else{
				echo "<div class='alert alert-danger'>Los datos introducidos son incorrectos.</div>";
			}
		}else{
			echo "<div class='alert alert-danger'>Rellena todos los campos.</div>";
		}
	}

	public function seguridad($usu){
		$usuario= $this->rescata('admin');
    	$pass= $this->rescata('contrasena'); 
		if($usu != $usuario && $pas != $pass){
  			echo'<script language="javascript">window.location="index.php"</script>'; 
		}
	}

	public function quitar_tildes($cadena) {
	    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹"," ");
	    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
	    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
	    return $texto;
  }
}
?>