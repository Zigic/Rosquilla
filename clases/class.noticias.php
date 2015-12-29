<?php

class Noticias extends Pagina {

	

	public function guarda(){
		$titular = $_POST['titular'];
		$resumen = $_POST['resumen'];
		$noticia = $_POST['noticia'];
		$seccion = $_POST['seccion'];
		$imagen = $_FILES['imagen'];
		$imaName = "../images/noticias/".$imagen['name'];
		$this->guardaImagen($imagen,"noticias");
		$this->guardaTabla($titular,$resumen,$noticia,$imaName,$seccion);
		$this->creaWeb($titular,$resumen,$noticia,$imaName,$seccion);
	}

	public function guardaImagen($ima,$carpeta){
		$imagen = "../images/".$carpeta."/".$ima['name'];
	    if (file_exists($imagen)) {
	        echo '<div class="alert alert-danger">
  				 La imagen ya existe.
			     </div>';
	        exit();
	    }
	    $mueve = move_uploaded_file($ima["tmp_name"], $imagen);
      if ($mueve != true) {
          echo '<div class="alert alert-danger">
  				La imagen no ha subido.
			    </div>';
          exit();
      }
  }

  public function guardaTabla($titular,$resumen,$noticia,$imagen,$seccion){
    $sql = "INSERT INTO noticias (titular, resumen, noticia, imagen, seccion, recordDate)VALUES ('$titular','$resumen','$noticia','$imagen','$seccion',now())";
		$this->consulta($sql);
	}

	public function creaWeb($titular,$resumen,$noticia,$imaName,$seccion){
    $titulo = $this->quitar_tildes($titular);
    $ruta = "C:\\xampp\\htdocs\\git\\noticias\\"; //ruta donde se guardara la noticia.
    $fichero = $ruta.$titulo.".php";
    if(file_exists($fichero)){
       echo '<div class="alert alert-danger">Esta noticia ya fue creada.</div>';
       exit();
    }else {
      $myfile = fopen($fichero, "w") or die("No puedo crear la web!!!"); 
      require '..\includes\_esqueletoWeb.php';
      fwrite($myfile, $txt);
      fclose($myfile);
      $txt = '<div class="alert alert-success">Noticia guardada.</div>';
    }
    return $txt;
  }

  public function elimina($id,$titular,$imagen,$tabla){
    $sql = "DELETE FROM $tabla WHERE id='$id',titular='$titular',imagen='$imagen'";
    $this->consulta($sql);
    unlink($imagen);
  }

  public function eliminaNoticia($titular){
    $titulo = $this->quitar_tildes($titular);
    $web = "..\\noticias\\".$titulo.".php";
    unlink($web);
    echo '<div class="alert alert-success">Noticia eliminada.</div>';
  }

  public function actualiza(){
    $id = $_POST['idAct'];
    $titular = $_POST['titularAct'];
    $resumen = $_POST['resumenAct'];
    $noticia = $_POST['noticiaAct'];
    $seccion = $_POST['seccionAct'];
    if($_FILES['imagenAct']['error'] != UPLOAD_ERR_NO_FILE){
    		$imagen = $_POST['imagenAntigua'];
			  unlink($imagen);	
    		$this->guardaImagen($_FILES['imagenAct'],'noticias');
    		$imagen = $_FILES['imagenAct'];
    		$imagen = "../images/noticias/".$imagen['name'];
    }else{
    		$imagen = $_POST['imagenAntigua'];
    }	
    $sql = "UPDATE noticias SET titular='$titular',resumen='$resumen',noticia='$noticia',imagen='$imagen',seccion='$seccion',recordDate=now()  WHERE id='$id'";
    $this->consulta($sql);
    $this->eliminaNoticia($titular);
    $this->creaWeb($titular,$resumen,$noticia,$imagen,$seccion);
    echo '<div class="alert alert-success">Noticia actualizada.</div>';
  }
    	
  public function muestra(){
    $sql = "SELECT id,titular,resumen, noticia, imagen,seccion FROM noticias ORDER BY recordDate DESC";
    $consulta = $this->consulta($sql);
    $txt ="";
      while ($row = mysqli_fetch_array($consulta)){ 
                     echo "	 <div class='row'>
	                             <div class='col-md-8'><p>".substr($row['titular'],0,100)."</p></div>
	                             <div class='col-md-1'><img class='img-thumbnail' src='".$row['imagen']."'></div>
	                             <div class='col-md-1'><p>".$row['seccion']."</p></div>

	                             <!--Formulario Elimina,recoge valores para eliminar noticia-->
	                             <form method='post' action=''>
	                                <div class='form-group'>
	                                  <input type='hidden' name='id' value='".$row["id"]."'>
	                                  <input type='hidden' name='imagen' value='".$row["imagen"]."'>
	                                  <input type='hidden' name='titular' value='".$row["titular"]."'>
	                                  <button type='submit' class='btn btn-default col-md-1' name ='elimina'><span class='glyphicon glyphicon-trash'></span></button>
	                                </div>
	                             </form>
	                             <!--Llama al script para que se despliegue el formulario de modificacion-->
	                             <button class='btn btn-default col-md-1' type='submit'  value='Actualizar' onclick='cambio(&#39;".$row["id"]."&#39;)'><span class='glyphicon glyphicon-pencil'></span></button>
                             </div>

                             <div class='row'>
                             <!--Formulario modifica,´muestra valores para el update-->
	                             <form method='post' action='' enctype='multipart/form-data' id='".$row["id"]."' style='display:none'>
	                                   <div class='form-group'>
	                                      <input type='hidden' class='form-control' name='idAct' value='".$row["id"]."'>
	                                      <label >Tituar:</label>
	                                      <input type='text' class='form-control' name='titularAct' value='".$row["titular"]."'>
	                                      <label >Resumen:</label>
	                                      <input type='textarea' class='form-control' name='resumenAct' value='".nl2br($row["resumen"])."'>
	                                      <label >Noticia:</label>
	                                      <textarea class='form-control' name='noticiaAct'>".$row["noticia"]."</textarea>
	                                      <label >Seccion:</label>
	                                      <select class='form-control' name='seccionAct'>".$this->rescataSecciones($this->rescata('numero'))."</select>
	                                      <label >Cambiar Imagen:</label>
	                                      <input type='file' class='form-control' name='imagenAct' >
                                        <label >Imagen actual:</label>
	                                      <input type='text' class='form-control' name='imagenAntigua' value='".$row["imagen"]."'>
                                      </div>
                                      <div class='form-group text-center'> 
    	                                  <button class='btn btn-default' type='submit'  value='Cancela' onclick='desCambio(&#39;".$row["id"]."&#39;)'><span class='glyphicon glyphicon-remove'></span></button>
    	                                  <button class='btn btn-default' type='submit' name = 'actualiza' value='Actualizar'><span class='glyphicon glyphicon-ok'></span></button>
	                                   </div>
	                              </form>
                              </div>";
      }
  }

  public function guardaSlider(){
    $titular = $_POST['titular'];
		$resumen = $_POST['resumen'];
		$imagen = $_FILES['imagen'];
		$imaName = "images/slider/".$imagen['name'];
		$this->guardaImagen($imagen,"slider");
    $sql = "INSERT INTO slider (titular, resumen, imagen)VALUES ('$titular','$resumen','$imaName')";
		$this->consulta($sql);
  }  

  public function muestraSlider(){
    //muestra desde el gestor las fotos subidas al slider.
    $sql = "SELECT id,titular,resumen,imagen FROM slider";
    $consulta = $this->consulta($sql);
    while ($row = mysqli_fetch_array($consulta)){
        		echo " <div class='row'>
                             <div class='col-md-9'><p>".substr($row['titular'],0,100)."</p></div>
                             <div class='col-md-1'><img class='img-thumbnail' src='../".$row['imagen']."'></div>

                             <!--Formulario Elimina,recoge valores para eliminar imagen-->
                             <form method='post' action=''>
                                <div class='form-group'>
                                  <input type='hidden' name='Eliid' value='".$row["id"]."'>
                                  <input type='hidden' name='Eliimagen' value='".$row["imagen"]."'>
                                  <input type='hidden' name='Elititular' value='".$row["titular"]."'>
                                  <button type='submit' class='col-md-1 btn btn-default' name ='elimina'><span class='glyphicon glyphicon-trash'></span></button>
                                </div>
                             </form>

                             <!--Llama al script para que se despliegue el formulario de modificacion-->
                             <button class='btn btn-default col-md-1' type='submit'  value='Actualizar' onclick='cambio(&#39;".$row["id"]."&#39;)'><span class='glyphicon glyphicon-pencil'></span></button>
                             
                             <!--Formulario modifica,´muestra valores para el update-->
                             <form method='post' action='' enctype='multipart/form-data' id='".$row["id"]."' style='display:none'>
                                   <div class='form-group'>
                                      <input type='hidden' class='form-control' name='idAct' value='".$row["id"]."'>
                                      <label >Tituar:</label>
                                      <input type='text' class='form-control' name='titularAct' value='".$row["titular"]."'>
                                      <label >Texto:</label>
                                      <input type='textarea' class='form-control' name='resumenAct' value='".$row["resumen"]."'>
                                      <label >Imagen:</label>
                                      <input type='file' name='imagenAct' >
                                      <input type='textarea' class='form-control' name='imagenAntigua' value='".$row["imagen"]."'>
                                    </div>  
                                    <div class='form-group text-center'> 
                                        <button class='btn btn-default' type='submit'  value='Cancela' onclick='desCambio(&#39;".$row["id"]."&#39;)'><span class='glyphicon glyphicon-remove'></span></button>
                                        <button class='btn btn-default' type='submit' name = 'actualiza' value='Actualizar'><span class='glyphicon glyphicon-ok'></span></button>
                                    </div>
                             </form>
                         </div>";
        }
    }

  public function actualizaSlider(){
    $id = $_POST['idAct'];
    $titular = $_POST['titularAct'];
    $resumen = $_POST['resumenAct'];
    if($_FILES['imagenAct']['error'] != UPLOAD_ERR_NO_FILE){
    		$imagen = $_POST['imagenAntigua'];
			  unlink($imagen);	
    		$this->guardaImagen($_FILES['imagenAct'],'noticias');
    		$imagen = $_FILES['imagenAct'];
    		$imagen = "../images/noticias/".$imagen['name'];
    }else{
    		$imagen = $_POST['imagenAntigua'];
    }	
    $sql = "UPDATE slider SET titular='$titular',resumen='$resumen',imagen='$imagen' WHERE id='$id'";
    $this->consulta($sql);
    echo '<div class="alert alert-success">Noticia actualizada.</div>';
  }

  public function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹"," ");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
  }

}