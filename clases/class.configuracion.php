<?php

class Configura extends Db {

	private $numero = "";
	private $direc = array();
	private $secciones = array("seccion1","seccion2","seccion3","seccion4","seccion5","seccion6");
	private $social = array("facebook","twitter","google","instagram","correo");
	private $datos = array('web','numero','slider','vista','admin','contrasena');
	private $definidas = array();
	private $campos = array ('web','numero','slider','vista','facebook','twitter','google','instagram','correo','admin','contrasena');
	private $ruta = "C:\\xampp\\htdocs\\git\\"; //ruta donde se guardara la web.

	public function valida (){
		$err = "";
		$cont = 0;
		for ($i=0; $i < sizeof($this->campos) ; $i++) {
			if(empty($_POST[$this->campos[$i]])){
				$err .= "<div class='alert alert-danger'>Rellena el campo " .$this->campos[$i]."</div>";
			}
			else if($this->campos[$i] == $this->social[$cont]){
				if ($_POST[$this->campos[$i]] == "si"){
					if(empty($_POST['di'.$this->social[$cont]])){
					$err .= "<div class='alert alert-danger'>Rellena la dirección de " .$this->social[$cont]."</div>";
					$cont++;
					}
				}
			}else if ($this->campos[$i] == "numero" && isset($_POST[$this->campos[1]])){ 
				for ($x=0; $x < $_POST[$this->campos[1]] ; $x++) { 
					if(empty($_POST[$this->secciones[$x]])){
					$err .= "<div class='alert alert-danger'>Rellena el campo " .$this->secciones[$x]."</div>";
					}
				}
			}
		}
		
		if ($err !== "") {
			return  $err;  
		}
		else{
			
			$this->guardaValores();
		}
	}

	public function guardaValores (){
		for ($i=0; $i < sizeof($this->datos) ; $i++) {
			$this->datos[$i] = $_POST[$this->datos[$i]];
		}
		$this->numero = $this->datos[1];
		for ($i=0; $i<$this->numero ; $i++){
			$this->definidas[$i] = $_POST[$this->secciones[$i]];
		}
		for ($i=0; $i<sizeof($this->social) ; $i++){
			if ($_POST[$this->social[$i]] == "no"){
				$this->direc[$i] = "no"; 
			}
			else{
			$this->direc[$i] = $_POST['di'.$this->social[$i]]; 
			}
		}
		$this->creaTabla();
		$this->guardaTabla($this->datos,$this->numero,$this->definidas,$this->direc) ;
		$this->creaSecciones($this->numero,$this->definidas);
		$this->creaHome($this->definidas);
	}

	public function creaTabla (){
		$sql = " CREATE TABLE configuracion ( 
    		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    		web VARCHAR(30) NOT NULL,
    		numero INT(6) NOT NULL,
    		seccion1 VARCHAR(30) NOT NULL,
    		seccion2 VARCHAR(30) NOT NULL,
    		seccion3 VARCHAR(30) NOT NULL,
    		seccion4 VARCHAR(30) NOT NULL,
    		seccion5 VARCHAR(30) NOT NULL,
    		seccion6 VARCHAR(30) NOT NULL,
    		slider VARCHAR(5) NOT NULL,
    		vista VARCHAR(15) NOT NULL,
			admin VARCHAR(25) NOT NULL,
			contrasena VARCHAR(15) NOT NULL)";
		$this->consulta($sql);
		$sql = " CREATE TABLE social (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			facebook VARCHAR(1000) NOT NULL,
			twitter VARCHAR(1000) NOT NULL,
			google VARCHAR(1000) NOT NULL,
			instagram VARCHAR(1000) NOT NULL,
			correo VARCHAR(1000) NOT NULL)";
		$this->consulta($sql);
		$sql = " CREATE TABLE noticias (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			titular VARCHAR(1000) NOT NULL,
			resumen VARCHAR(1000) NOT NULL,
			noticia VARCHAR(10000) NOT NULL,
			imagen VARCHAR(1000) NOT NULL,
			seccion VARCHAR(100) NOT NULL,
			recordDate DATETIME NOT NULL)";
		$this->consulta($sql);
		$sql = " CREATE TABLE slider (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			titular VARCHAR(1000) NOT NULL,
			resumen VARCHAR(1000) NOT NULL,
			imagen VARCHAR(1000) NOT NULL)";
		$this->consulta($sql);
	}
	
	public function guardaTabla ($dat,$num,$def,$soci){
		//crea campos de las secciones declaradas.
		$creaInto = $creaValues = "";
		for ($i=0; $i <$num ; $i++) {
			$creaInto .=$this->secciones[$i].",";
			$creaValues .= "'".$def[$i]."'".",";
		}
		$sql = "INSERT INTO configuracion (web,numero,$creaInto slider,vista,admin,contrasena) 
        VALUES ('$dat[0]',$dat[1],$creaValues '$dat[2]','$dat[3]','$dat[4]','$dat[5]')";
        $this->consulta($sql);
        $sql = "INSERT INTO social (facebook,twitter,google,instagram,correo)
        VALUES ('$soci[0]','$soci[1]','$soci[2]','$soci[3]','$soci[4]')";
        $this->consulta($sql);
	}

	public function creaSecciones ($num,$def){
		//crea las páginas con las secciones declaradas.
		for ($i=1; $i <$num ; $i++) {
			$titulo = str_replace(' ', '', $def[$i]);
	        $fichero = $this->ruta.$titulo.".php";
	        if(file_exists($fichero)){
	           echo '<div class="alert alert-danger">Comprueba que no existe un fichero con el mismo nombre,el directorio por defecto es C:\xampp\htdocs\rosquilla\ lo puedes modificar en la clase configuración .</div>';
	           exit();
	        }else {
	        $miFichero = fopen($fichero, "w") or die('<div class="alert alert-danger">No puedo crear la web.</div>'); 
	        require 'includes\_creaWeb.php';
	        fwrite($miFichero, $esqueletoSeccion);
	        fclose($miFichero);
	    	}
	    }	
	}

	public function creaHome ($def){
	    $fichero = $this->ruta."index.php";
	    if(file_exists($fichero)){
	        echo '<div class="alert alert-danger">Comprueba que no existe un fichero con el mismo nombre ,el directorio por defecto es C:\xampp\htdocs\rosquilla\ lo puedes modificar en la clase configuración .</div>';
	        exit();
	    }else {
	        $miFichero = fopen($fichero, "w") or die('<div class="alert alert-danger">No puedo crear la web.</div>'); 
	        require 'includes\_creaWeb.php';
	        fwrite($miFichero, $esqueletoHome);
	        fclose($miFichero);
	   	}
	   	echo '<div class="alert alert-success">Perfecto!.</div>';
	    $this->redirecciona($titulo);
	}

	public function redirecciona ($titulo){
		echo'<script language="javascript">window.location="index.php"</script>'; 
	}
}

?>