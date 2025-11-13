<?php
    session_start();        //iniciamos la sesion y ceramos una varable iniciado que sea false, que comprueva si hay una sesion activa
    
    include(__DIR__ . '/../includes/functions.php');
    $iniciado = FALSE;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /*
            Reocje los datos del formulario y verifica que sean correctos (Una verificacion inicial para el correo  y que no esten vacios los campos)
        */
        if (isset($_SESSION['usu'])) {
            $errores = [];
            $usu = $_SESSION['usu'];

            $correo = $_POST['email'];
            if(empty($correo)){
                $errores[] = "El campo email esta vacio";
            }elseif(!verificarEmail($correo)){
                $errores[] = "Email invalido";
            }

            $contr = $_POST['password'];
            if(empty($contr)){
                $errores[]= "contraseña vacia";
            }

            /*
                Si no hay ningun error recvisa el array de usuarios buscando un usuario que contenga el correo y la contraseña
                cuando lo encuentra guarda en la sesion el usuario e iniciado = TRUE y te redirige a idnex.php.
            */
            if(empty($errores)){
                foreach($usu as $usuario){
                    if (($usuario["email"] === $correo) && ($usuario["contraseña"] === $contr)) {
                        $iniciado = TRUE;
                        $_SESSION['user'] = $usuario;
                        $_SESSION['ini'] = $iniciado;
                        header('Location: index.php');
                        exit;
                    }else{
                        $errores[] = "Datos erroneos";
                    }
                }
            }

        }else{  //si no exsite usu o esta vacio avisa que no hay usuarios registrados 
            $errores[]="No hay usuarios creados";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <style>
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
        }

        .login-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            margin-bottom: 5px;
            color: #555;
        }

        .input-group input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .input-group input:focus {
            border-color: #2575fc;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #2575fc;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6a11cb;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .signup-link a {
            color: #2575fc;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
        .error {
            padding: 5px;
            height: 50px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="login-container">

        <form method="POST">
            <h2>Iniciar Sesión</h2>
            <div class="input-group">
                                    <!-- Usamos php para que cuando slaga error se mantengan los datos rellenados-->
                <label for="email">Correo</label>
                <input type="email" id="email" name="email" placeholder="Ingresa tu correo" value="<?php echo isset($_POST['email']) ?htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <button type="submit">Entrar</button>
            <p id="errorMensaje" class="error">
                <?php               //Recorre los errores y los muestra por pantalla
                    if (!empty($errores)) {
                        foreach ($errores as $error) {
                            echo $error . "<br>";
                        }
                    }
                ?>
            </p>
            <p class="signup-link">¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
        </form>
    </div>
</body>
</html>
