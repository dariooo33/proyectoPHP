<?php
    session_start(); //Iniciamos la sesion para el header
    include(__DIR__ . '/../includes/functions.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="/trabajoPHP/assets/css/index.css">

</head>
<body>
    <?php   // Incluimos el header de header.php usando __DIR__ que nos da la ruta en la que nos encotramos y añadiendole de seguido ../ para retroceder un directorio y poder entrar en el directorio requerido
    include(__DIR__ . '/../includes/header.php');
    ?>

    <main>
        <div class="presentacion">
            <h1>Bienvenido a MountainsRoutes</h1>
            <p>
                Este es un espacio dedicado a ofrecerte información, recursos y servicios sobre montañismo.

                Aqui vas a poder encontrar una gran variedad de rutas de todo tipo y con un gran rango de dificultad, 
                desde desafios para los montañistas mas arriegados hasta rutas para toda la familia.

                Explora nuestras secciones para conocer más, explora las rutas o sube tus propios recorridos para compartirlos con nosotros.
            </p>
        </div>
        <div class="enlaces-container">
            <div class="enlaces">
                <h2>Comparte rutas con nosotros</h2>
                <img src="/trabajoPHP/assets/images/paisaje.jpg" alt="montaña">
                <a href="routes/create.php">CREA UNA RUTA</a>
            </div>
            
            <div class="enlaces">
                <h2>EXPLORA RUTAS NUEVAS</h2>
                <img src="/trabajoPHP/assets/images/cima.jpg" alt="cima">
                <a href="routes/list.php">RUTAS CREADAS</a>
            </div>
        </div>
        
    </main>

    <?php // Añadimos el footer de la misma forma que el header
    include(__DIR__ . '/../includes/footer.php');
    ?>
</body>
</html>
