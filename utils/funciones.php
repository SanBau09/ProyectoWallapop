<?php

function generarNombreArchivo (String $nombreOriginal):string{
    $nuevoNombre = md5(time()+rand());
    $partes = explode( '.', $nombreOriginal);
    $extension = $partes[count($partes)-1];
    return $nuevoNombre. '.' .$extension;

}

function imprimirMensaje(){
    if(isset($_SESSION['error'])){
        echo '<span class="error">' . $_SESSION['error'] . '</span>';
        unset($_SESSION['error']);
    }
}

function guardarMensaje($mensaje){
    $_SESSION['mensaje'] = $mensaje;

}

?>