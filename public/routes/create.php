<?php
    /** Inicia la sesion para poder guardar la ruta creada en un array rutas, que si aun no se a creado se crea vacio
     * 
     */
    include(__DIR__ . '/../../includes/functions.php');
    session_start();
    $user = $_SESSION['user'] ?? [];
    $rutas = $_SESSION['rutas'] ?? [];  
    
    if (sesionActiva()){ 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errores = []; //una varialbe para guardar los errores del formulario

            //Creamos la variable nombre y guardamos el nombre introducido en el formulario
            //Luego verificamos que el nombre no este ya guardado
            $nombre =$_POST['nombre']; 
            if(empty($nombre)){
                $errores[]="El campo nombre es obligatorio";
            }elseif(!empty($rutas)){
                foreach($rutas as $ruta){
                    if ($ruta['nombre'] === $nombre){
                        $errores[] ="Ya existe una ruta con ese nombre";
                    }
                }
            }

            //Creamos la variable Dificultad y guardamos el dato introducido verificando que no este vacio
            $dificultad =$_POST['dificultad'];
            if(empty($dificultad)){
                $errores[]="Elige una dificultad";
            }

            //Creamos Distancia
            $distancia =$_POST['distancia'];
            if(empty($distancia)){
                $errores[]="Tienes que establecer una distancia";
            }elseif($distancia <0){
                $errores[]="El dato introducido en distancia es invalido";
            }

            //Creamos Desnivel
            $desnivel = $_POST['desnivel'];
            if(empty($desnivel)){
                $errores[]="Tienes que establecer un desnivel";
            }elseif($desnivel <0){
                $errores[]="El dato introducido en desnivel es invalido";
            }

            //Creamos Duracion
            $duracion = $_POST['duracion'];
            if(empty($duracion)){
                $errores[]="Tienes que establecer una duracion";
            }elseif($duracion <0){
                $errores[]="El dato introducido en duracion es invalido";
            }

            //Creamos Provincia
            $provincia =$_POST['provincia'];
            if(empty($provincia)){
                $errores[]="Selecciona una provincia";
            }

            //Creamos epoca
            $epoca = $_POST['epoca'];
            if(empty($epoca)){
                $errores[] = "Marca una epoca del año";
            }

            //Creamos descripcion
            $descripcion = $_POST['descripcion'];
            if(empty($descripcion)){
                $descripcion = "No hay descripcion disponible..."; // no es obligatoria pero tampoco la vamos a dejar vacia
            }

            //Creamos tecnico
            $tecnico = $_POST['nivel_tecnico'];
            if(empty($tecnico)){
                $errores[]="Seleciona tu nivel tecnico";
            }elseif($tecnico<=0){
                $errores[]="El dato introducido en nivel tecnico es invalido";
            }

            //Creamos Fisico
            $fisico = $_POST['nivel_fisico'];
            if(empty($fisico)){
                $errores[]="Selecciona tu nivel fisico";
            }elseif($fisico<=0){
                $errores[]="El dato introducido en nivel fisico es invalido";
            }

            //Creamos archivo
            if(isset($_FILES['archivos'])){
                $archivo = $_FILES['archivos'];

                //Informacion del archivo:
                    $nArch =$archivo['name'];
                    $tipo = $archivo['type'];
                    $tamaño = $archivo['size'];
                    $tmp = $archivo['tmp_name'];
                    $error = $archivo['error'];

                    //Comprobamos que no hay errores
                    if($error == UPLOAD_ERR_OK){
                        if ($tamaño<=2097152){ //Tamaño inferior a 2MB
                            $extension = pathinfo($nArch, PATHINFO_EXTENSION);  // Aislamos la extension para comprobarla
                            $permitidas = ['jpg','jpeg','png'];                 // Listamos los tipos de archivos permitidos

                            if(in_array(strtolower($extension), $permitidas)){ //Comprobamos el tipo de archivo
                                
                                $nuevo_nombre = nombreUnico($extension);                       //Creamos un nomre unico y establecemos un destino para guardar las imagenes
                                $destino =  __DIR__ . '/../../uploads/photos/'.$nuevo_nombre;   // Usamos __DIR__ para usar la ruta actual

                                if (!move_uploaded_file($tmp, $destino)){       // Y movemos el archivo a la carpeta establecida en $destino
                                    $errores[]= "Error al mover el archivo";
                                }
                            }else{
                                $errores[]= "Tipo de archivo no permitido";
                            }
                        }else{
                            $errores[]="Archivo demasiado grande";
                        }
                    }else{
                        $errores[]= "Error en la subida: ".$error;
                    }
                    
                }

            //Si no hay errores creamos la ruta y la guardamos en $rutas subiendolo al servidor
            if(empty($errores)){
                $nRuta =[
                    "nombre" => $nombre,
                    "dificultad" => $dificultad,
                    "distancia" => $distancia,
                    "desnivel" => $desnivel, 
                    "duracion" => $duracion,
                    "provincia" => $provincia,
                    "epoca" => $epoca,
                    "descripcion" => $descripcion,
                    "tecnico" => $tecnico,
                    "fisico" => $fisico,
                    "imagen" => $nuevo_nombre
                ];

                $rutas[] = $nRuta;           
                $_SESSION['rutas'] = $rutas; 

                header('Location: list.php'); // Y te redirige a list.php
                exit;
            }
        }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Crear una Ruta</title>
        <link rel="stylesheet" href="/trabajoPHP/assets/css/create.css">

    </head>
    <body>
        <?php   // Incluimos el header de header.php usando __DIR__ que nos da la ruta en la que nos encotramos y añadiendole de seguido ../ para retroceder un directorio y poder entrar en el directorio requerido
        include(__DIR__ . '/../../includes/header.php');
        ?>
        <main>
        <section class="form-ruta">
            <h1> CREAR UNA RUTA</h1>
            <form method="POST"  enctype="multipart/form-data">
                <h2>Formulario de Ruta</h2>

                <!-- Nombre de la ruta -->
                <label for="nombre">Nombre de la ruta:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>

                <!-- Dificultad -->
                <label for="dificultad">Dificultad:</label>
                <select id="dificultad" name="dificultad" required>
                    <option value="">-- Selecciona --</option>
                    <option value="facil">Fácil</option>
                    <option value="moderada">Moderada</option>
                    <option value="dificil">Difícil</option>
                    <option value="muy_dificil">Muy Difícil</option>
                </select>

                <!-- Distancia -->
                <label for="distancia">Distancia (km):</label>
                <input type="number" id="distancia" name="distancia" step="0.1" min="0" value="<?php echo isset($_POST['distancia']) ?htmlspecialchars($_POST['distancia']) : ''; ?>" required>

                <!-- Desnivel positivo -->
                <label for="desnivel">Desnivel positivo (m):</label>
                <input type="number" id="desnivel" name="desnivel" min="0" value="<?php echo isset($_POST['desnivel']) ?htmlspecialchars($_POST['desnivel']) : ''; ?>" required>

                <!-- Duración estimada -->
                <label for="duracion">Duración estimada (horas):</label>
                <input type="number" id="duracion" name="duracion" step="0.1" min="0" value="<?php echo isset($_POST['duracion']) ?htmlspecialchars($_POST['duracion']) : ''; ?>" required>

                <!-- Provincia -->
                <label for="provincia">Provincia:</label>
                <select id="provincia" name="provincia" required>
                    <option value="">-- Selecciona una provincia --</option>
                    <option value="Alava">Álava</option>
                    <option value="Albacete">Albacete</option>
                    <option value="Alicante">Alicante</option>
                    <option value="Almeria">Almería</option>
                    <option value="Asturias">Asturias</option>
                    <option value="Avila">Ávila</option>
                    <option value="Badajoz">Badajoz</option>
                    <option value="Barcelona">Barcelona</option>
                    <option value="Burgos">Burgos</option>
                    <option value="Caceres">Cáceres</option>
                    <option value="Cadiz">Cádiz</option>
                    <option value="Cantabria">Cantabria</option>
                    <option value="Castellon">Castellón</option>
                    <option value="Ciudad_real">Ciudad Real</option>
                    <option value="Cordoba">Córdoba</option>
                    <option value="Cuenca">Cuenca</option>
                    <option value="Girona">Girona</option>
                    <option value="Granada">Granada</option>
                    <option value="Guadalajara">Guadalajara</option>
                    <option value="Guipuzcoa">Guipúzcoa</option>
                    <option value="Huelva">Huelva</option>
                    <option value="Huesca">Huesca</option>
                    <option value="Jaen">Jaén</option>
                    <option value="La_coruna">La Coruña</option>
                    <option value="La_rioja">La Rioja</option>
                    <option value="Las_palmas">Las Palmas</option>
                    <option value="Leon">León</option>
                    <option value="Lleida">Lleida</option>
                    <option value="Lugo">Lugo</option>
                    <option value="Madrid">Madrid</option>
                    <option value="Malaga">Málaga</option>
                    <option value="Murcia">Murcia</option>
                    <option value="Navarra">Navarra</option>
                    <option value="Ourense">Ourense</option>
                    <option value="Palencia">Palencia</option>
                    <option value="Pontevedra">Pontevedra</option>
                    <option value="Salamanca">Salamanca</option>
                    <option value="Segovia">Segovia</option>
                    <option value="Sevilla">Sevilla</option>
                    <option value="Soria">Soria</option>
                    <option value="Tarragona">Tarragona</option>
                    <option value="Tenerife">Santa Cruz de Tenerife</option>
                    <option value="Teruel">Teruel</option>
                    <option value="Toledo">Toledo</option>
                    <option value="Valencia">Valencia</option>
                    <option value="Valladolid">Valladolid</option>
                    <option value="Vizcaya">Vizcaya</option>
                    <option value="Zamora">Zamora</option>
                    <option value="Zaragoza">Zaragoza</option>
                </select>

                <!-- Época recomendada -->
                <fieldset>
                    <legend>Época recomendada:</legend>
                    <label><input type="checkbox" name="epoca" value="Primavera"> Primavera</label><br>
                    <label><input type="checkbox" name="epoca" value="Verano"> Verano</label><br>
                    <label><input type="checkbox" name="epoca" value="Otoño"> Otoño</label><br>
                    <label><input type="checkbox" name="epoca" value="Invierno"> Invierno</label><br>
                </fieldset>

                <!-- Descripción -->
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4" ><?php echo isset($_POST['descripcion']) ?htmlspecialchars($_POST['descripcion']) : ''; ?></textarea>

                <!-- Nivel técnico -->
                <label for="nivel_tecnico">Nivel técnico (1-5):</label>
                <input type="number" id="nivel_tecnico" name="nivel_tecnico" min="1" max="5" value="<?php echo isset($_POST['nivel_tecnico']) ?htmlspecialchars($_POST['nivel_tecnico']) : ''; ?>" required>

                <!-- Nivel físico -->
                <label for="nivel_fisico">Nivel físico (1-5):</label>
                <input type="number" id="nivel_fisico" name="nivel_fisico" min="1" max="5" value="<?php echo isset($_POST['nivel_fisico']) ?htmlspecialchars($_POST['nivel_fisico']) : ''; ?>" required>

                <label for="imagen">Añade imagenes:</label>
                <input type="file" name="archivos">

                <!-- Botón -->
                <button type="submit">Guardar ruta</button>
            </form>
            <p class="error">
                <?php // Recorre errores y los va mostrando dentro del parrafo separandolos en lineas, haciendo una lista
                    if (!empty($errores)) {
                        foreach ($errores as $error) {
                            echo $error . "<br>";
                        }
                    }
                ?>
            </p>
        </section>
        </main>
        <?php // Añadimos el footer de la misma forma que el header
        include(__DIR__ . '/../../includes/footer.php');
        ?>
    </body>
    </html>
<?php
    } else{
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sesión no encontrada</title>
        <link rel="stylesheet" href="/trabajoPHP/assets/css/profile.css">
    </head>
    <body>
        <div class="container">
            <h2>Sesión no encontrada</h2>
            <p>No se ha detectado ninguna sesión activa.</p>

            <a href="/trabajoPHP/public/login.php" class="btn">Iniciar sesión</a>
            <a href="/trabajoPHP/public/register.php" class="btn">Registrarse</a>
            <a href="/trabajoPHP/public/index.php" class="btn">Home</a>
        </div>

    </body>
    </html>
<?php
    }
?>