<?php
    /*
    Inicia la sesion y crea las variables en las que se almacen+a la sesion iniciada y el booleano que verifica que se a iniciado sesion, 
    en caso de no estar creadas se crean como False y vacio.

    De seguido comprueba $iniciado (si ha iniciado sesion) y en caso de ser True muestra el HTML con la informacion, si es False te muestra un menu con Login y Regisrtate.
    */ 
    session_start();
    include(__DIR__ . '/../includes/functions.php');
    $user = $_SESSION['user'] ?? [];
    if (sesionActiva()){ 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="/trabajoPHP/assets/css/profile.css">
</head>
<body>
    <?php   // Incluimos el header de header.php usando __DIR__ que nos da la ruta en la que nos encotramos y añadiendole de seguido ../ para retroceder un directorio y poder entrar en el directorio requerido
        include(__DIR__ . '/../includes/header.php');
    ?>
    <main>
        <div class="perfil-container">
            <div class="avatar">👤</div>
            <h2>Perfil de Usuario</h2>

            <div class="info">  <!--Usado el usuario guardado hago un echo para mostrar por pantalla los datos-->
                <p><strong>Nombre de usuario:</strong> <?php echo $user['usuario']; ?></p>
                <p><strong>Correo electrónico:</strong> <?php echo $user['email']; ?></p>
                <p><strong>Nivel de experiencia:</strong> <?php echo $user['nivel']; ?></p>
                <p><strong>Especialidad:</strong> <?php echo $user['especialidad']; ?></p>
                <p><strong>Provincia:</strong> <?php echo $user['provincia']; ?></p>
            </div>
            <?php
                include 'logout.php';   //añadimos logout.php
            ?>
        </div>
    </main>
    <?php // Añadimos el footer de la misma forma que el header
    include(__DIR__ . '/../includes/footer.php');
    ?>
</body>
</html>
<?php        
    }else{
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