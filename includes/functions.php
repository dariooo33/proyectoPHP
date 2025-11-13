<?php
function verificarEmail($email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return FALSE;
    }else{
        return TRUE;
    }

}

function nombreUnico($extension){
    return uniqid() .".".$extension;
}

function sesionActiva(){
    $iniciado = $_SESSION['ini'] ?? FALSE;
    return $iniciado;
}
?>
