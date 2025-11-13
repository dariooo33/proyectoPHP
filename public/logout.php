<?php
    /** logout.php es un boton que aparece dentro de profile.php, 
     * unicamente cambia a FALSE el booleano $iniciado que verifica que hay sesion activa
     * y te redirige a profile.php
     * (Usa los estilos de porfile.php)
     */ 
    if (isset($_POST['logout'])) {

        $iniciado = FALSE;
        $_SESSION['ini'] = $iniciado;
        header('Location: profile.php');
        exit;
    }
?>
<form method="post">
    <button class="logout-btn" name="logout">Cerrar sesión</button>
</form>