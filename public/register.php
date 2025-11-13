<?php
    /*
        Inicio una sesion para poder mover varialbles entre las paginas, luego creo una variable array que almacena usuarios (Base de datos provisional)
        cogiendo usu de la sesion y en caso de que no exista la crea vacia
    */
    include(__DIR__ . '/../includes/functions.php');
    session_start();

    $usu = $_SESSION['usu'] ?? [];          

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errores = [];
        
        /* 
        Lee el contenido de "username" y lo guarda en una variable 
            -> Comprueba que no este vacio con empty()
            -> Comprueba que email sea valido con filter_var() comparando con una constante de php
            -> Verificamos que las contraseñas coinciden
            -> Si no hay errores te redirige a index.php y se guardan en at[](provisional)
        */

        $nombre = $_POST['username'];
        if(empty($nombre)){
            $errores[] = "El campo nombre es o  bligatorio";
        }

        $email = $_POST['email'];
        if(empty($email)){
            $errores[] = "El campo email es obligatorio";
        }elseif(!verificarEmail($email)){
            $errores[] = "Email invalido";
        }



        $contra = $_POST['password'];
        if(empty($contra)){
            $errores[]= "El campo contraseña es obligatorio ";  
        }elseif(strlen($contra)<6){
            $errores[]="Contraseña muy corta";
        }



        $cContra = $_POST['confirm_password'];
        if(empty($cContra)){
            $errores[]= "Debes confirmar la contraseña";
        }elseif($cContra!=$contra){
            $errores[] ="Las contraseñas no coinciden";
        }



        $nivel = $_POST['nivel'];
        if(empty($nivel)){               
            $errores[]= "Debes selecionar un nivel";
        }



        $esp = $_POST['especialidad'];
        if(empty($esp)){
            $errores[] = "Debes añadir una especialidad";
        }


        $prov = $_POST['provincia'];
        if(empty($prov)){
            $errores[] = "Debes especificar tu provincia";
        }


        if (empty($errores)){   //Crea un array con los valores del usuario
            $newUsu = [
                "usuario" => $nombre,
                "email" => $email,
                "contraseña" => $contra,
                "nivel" => $nivel,
                "especialidad" => $esp,
                "provincia" => $prov
            ];
            $usu[] = $newUsu;           
            $_SESSION['usu'] = $usu;    //lo sube a la sesion 

            header('Location: login.php'); // Y te redirige a login.php
            exit;

        }

    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            margin-top: 15px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #6a11cb;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <form method="POST">
        <h2>Registro de Usuario</h2>
                    <!-- Usamos php para que cuando slaga error se mantengan los datos rellenados-->
        <label for="username">Nombre de usuario:</label>
        <input type="text" id="username" name="username"  value="<?php echo isset($_POST['username']) ?htmlspecialchars($_POST['username']) : ''; ?>" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ?htmlspecialchars($_POST['email']) : ''; ?>" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" minlength="6" required>

        <label for="confirm_password">Confirmar contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>

        <label for="nivel">Nivel de experiencia:</label>
        <select id="nivel" name="nivel" value="<?php echo isset($_POST['nivel']) ?> required>
            <option value="">Seleccione...</option>
            <option value="principiante">Principiante</option>
            <option value="intermedio">Intermedio</option>
            <option value="avanzado">Avanzado</option>
        </select>

        <label for="especialidad">Especialidad:</label>
        <input type="text" id="especialidad" name="especialidad" value="<?php echo isset($_POST['especialidad']) ? htmlspecialchars($_POST['especialidad']) : ''; ?>" required>

        <label for="provincia">Provincia:</label>
        <input type="text" id="provincia" name="provincia" value="<?php echo isset($_POST['provincia']) ?htmlspecialchars($_POST['provincia']) : ''; ?>" required>

        <p id="errorMensaje" class="error">
        <?php // Recorre errores y los va mostrando dentro del parrafo separandolos en lineas, haciendo una lista
            if (!empty($errores)) {
                foreach ($errores as $error) {
                    echo $error . "<br>";
                }
            }
        ?>
        </p>
        <input type="submit" value="Registrarse">

    </form>
</body>
</html>
