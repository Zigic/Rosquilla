<?php



if(isset($_POST["crear"])) {

require 'clases/class.db.php';
require 'clases/class.configuracion.php';

$configura= new Configura();
$errores =$configura->valida();
echo $errores;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Mis estilos -->
    <link rel="stylesheet" href="css/style.css">

    <script type='text/javascript'>
        function addFields(){
            // Number of inputs to create
            var number = document.getElementById("otra").value;
            // Container <div> where dynamic content will be placed
            var container = document.getElementById("conta");
            // Clear previous contents of the container
            while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
            for (i=0;i<number;i++){
                // Append a node with a random text
				container.appendChild(document.createTextNode("Nombre de la sección " + (i+1)));
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");
                input.type = "text";
                input.className ="form-control"
                input.name = "seccion" + (i+1);
                container.appendChild(input);
                // Append a line break
                container.appendChild(document.createElement("br"));
            }
        }

        function socialAct(web){
            document.getElementById(web).disabled = false;
        }

        function socialDesac(web){
            document.getElementById(web).disabled = true;
        }


    </script>
</head>
<body>

    <div class="container espa">
        <div class="jumbotron">
            <h1>Rosquilla CMS</h1>
            <p>Bienvenido a la página de configuarción de RosquillaCMS aquí podras configurar y personalizar tu portal.</p>
            <p>Asegurate de haber creado una BBDD con el nombre <code>rosquilla</code> donde se irán creando las tablas.</p>
          </div>

        <form method="post" action="" >
            <div class="form-group">
            <fieldset>
                <legend>General</legend>
                    <label >Nombre del sitio</label>
                    <input type="text" class="form-control" name="web">

                    <label >Secciones</label>
                    <select class="form-control" id="otra" name="numero" onchange="addFields()">
                    		<option value="0"></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                    </select>
                    <div id="conta"></div>

                    <label >Slider en pagina Principal</label>
                    <label class="radio-inline"><input type="radio" name="slider" value="si" >Si</label>
                    <label class="radio-inline"><input type="radio" name="slider" value="no" >No</label>
                    	<br>
                    <label>Formato Secciones :</label>
                    <select class="form-control" id="otra" name="vista" >
                            <option value="unaColumna">1 Columna</option>
                            <option value="unaColumnaLate">1 Columna + lateral </option>
                            <option value="dosColumnas">2 Columnas</option>
                            <option value="dosColumnasLate">2 Columnas + lateral </option>
                    </select>


            </fieldset>
            </div>

            <div class="form-group">
            <fieldset>
                    <legend>Social</legend>
                    <label>Facebook</label>
                    <label class="radio-inline"><input type="radio" name="facebook" value="si" onclick="socialAct('facebook')" >Si</label>
                    <label class="radio-inline"><input type="radio" name="facebook" value="no" onclick="socialDesac('facebook')">No</label>
                    <input type="text" class="form-control" id="facebook" name="difacebook" disabled placeholder="Dirección">

                    <label>Twitter</label>
                    <label class="radio-inline"><input type="radio" name="twitter" value="si" onclick="socialAct('twitter')" >Si</label>
                    <label class="radio-inline"><input type="radio" name="twitter" value="no" onclick="socialDesac('twitter')">No</label>
                    <input type="text" class="form-control" id="twitter" name="ditwitter" disabled placeholder="Dirección">

                    <label>Google +</label>
                    <label class="radio-inline"><input type="radio" name="google" value="si" onclick="socialAct('google')" >Si</label>
                    <label class="radio-inline"><input type="radio" name="google" value="no" onclick="socialDesac('google')">No</label>
                    <input type="text" class="form-control" id="google" name="digoogle" disabled placeholder="Dirección">

                    <label>Instagram</label>
                    <label class="radio-inline"><input type="radio" name="instagram" value="si" onclick="socialAct('instagram')" >Si</label>
                    <label class="radio-inline"><input type="radio" name="instagram" value="no" onclick="socialDesac('instagram')">No</label>
                    <input type="text" class="form-control" id="instagram" name="diinstagram" disabled placeholder="Dirección">

                    <label>Formulario de Contacto</label>
                    <label class="radio-inline"><input type="radio" name="correo" value="si" onclick="socialAct('correo')" >Si</label>
                    <label class="radio-inline"><input type="radio" name="correo" value="no" onclick="socialDesac('correo')">No</label>
                    <input type="text" class="form-control" id="correo" name="dicorreo" disabled placeholder="Dirección de correo donde quieres que te lleguen los correos">
            </fieldset>
            </div>

            <div class="form-group">
            <fieldset>
                <legend>Administración</legend>
                <label>Nombre usuario</label>
                <input type="text" class="form-control" name="admin">

                <label>Contraseña</label>
                <input type="password" class="form-control" name="contrasena">
            </fieldset>
            </div>

            <div class="form-group">
                <div class="col-md-offset-5 col-md-2">
                  <button type="submit" name ="crear" class="btn btn-default">Crear</button>
                </div>
            </div>

        </div>
</form>
</div>
</body>
</html>

