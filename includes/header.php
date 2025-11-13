<?php
    /** usa las varaibles de la sesion para pdoer crear las varibales que comprueben que la sesion este iniciada y el usuario iniciado.
     * despues verifica si el booleano $iniciado es True y muestra el html con la sesion iniciada y el nombre d usuario,
     * en caso False muestra un html con las opciones registrarse e iniciar sesion
     */

    $user = $_SESSION['user'] ?? [];
    
    if (sesionActiva()){
?>
<link rel="stylesheet" href="/trabajoPHP/assets/css/header+footer.css">
<header>
    <img src="/trabajoPHP/assets/images/logo.png" alt="Logo">

    <h1>MountainRoutes</h1>
    <nav>
        
        |<a href="/trabajoPHP/public/index.php">Inicio</a> |
        <a href="/trabajoPHP/public/routes/create.php">Crear Ruta</a> |
        <a href="/trabajoPHP/public/routes/list.php">RUTAS</a> |
        <a href="/trabajoPHP/public/profile.php"> 👤 <?php echo $user['usuario']; ?></a> |     <!-- Muestra el nombre de usuario de $user -->
    </nav>
</header>
<?php
    }else{
?>  
    <header>
    <img src="/trabajoPHP/assets/images/logo.png" alt="Logo">
    <h1>Mi Sitio Web</h1>
    <nav>
        |<a href="/trabajoPHP/public/index.php">Inicio</a> |
        <a href="/trabajoPHP/public/routes/create.php">CREAR RUTAS</a> |
        <a href="/trabajoPHP/public/routes/list.php">RUTAS</a> |
        <a href="/trabajoPHP/public/login.php">Login</a> |
        <a href="/trabajoPHP/public/register.php">Registro</a> |

    </nav>
    </header>
<?php
    }
?>