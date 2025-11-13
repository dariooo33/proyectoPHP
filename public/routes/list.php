<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/trabajoPHP/assets/css/list.css">

</head>
<body>
    <?php
        session_start();
        include(__DIR__ . '/../../includes/functions.php');
        include(__DIR__ . '/../../includes/header.php');
    ?>
    <main>
    <?php
    /** El main de list.php es un script de php que genera divs con el contenido
     * 
     * Primero crea $rutas cogiendo las rutas creadas y almacenadas en la sesion, de seguido si no hay rutas muestra un mensage avisando que no hay rutas,
     * en el caso de si haver rutas hace un foreach recorriendo todas las rutas denro de el array rutas y por cada una genera un contenedor div con la indformacion de la ruta
     */
    $rutas = $_SESSION['rutas'] ?? [];

    if (empty($rutas)) {
        echo "<h1>Aun no hay rutas</h1>";   
    } else {
    foreach ($rutas as $ruta) {
        echo "<div class='ruta-container'>
                <img src='/TrabajoPHP/uploads/photos/{$ruta['imagen']}' alt='{$ruta['nombre']}'>
                <div class='ruta-info'>
                    <h2>{$ruta['nombre']}</h2>
                    <p><strong>Dificultad:</strong> {$ruta['dificultad']}</p>
                    <p><strong>Distancia:</strong> {$ruta['distancia']}</p>
                    <p><strong>Desnivel:</strong> {$ruta['desnivel']}</p>
                    <p><strong>Duración:</strong> {$ruta['duracion']}</p>
                    <p><strong>Provincia:</strong> {$ruta['provincia']}</p>
                    <p><strong>Época recomendada:</strong> {$ruta['epoca']}</p>
                    <p><strong>Descripción:</strong> {$ruta['descripcion']}</p>
                    <p><strong>Técnico:</strong> {$ruta['tecnico']}</p>
                    <p><strong>Físico:</strong> {$ruta['fisico']}</p>
                </div>
            </div>";
    }
    }
    ?>
    </main>
    <?php // Añadimos el footer de la misma forma que el header
    include(__DIR__ . '/../../includes/footer.php');
    ?>
</body>
</html>