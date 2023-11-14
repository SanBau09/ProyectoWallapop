<?php
    session_start();

    require_once "modelos/connexionDB.php";
    require_once 'modelos/usuario.php';
    require_once 'modelos/usuariosDAO.php';
    require_once "utils/funciones.php";

    //Creamos la conexión utilizando la clase que hemos creado
    $connexionDB = new ConnexionDB('root','','localhost','blog');
    $conn = $connexionDB->getConnexion();

    //Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
    if( !isset($_SESSION['email']) && isset($_COOKIE['sid'])){
    //Nos conectamos para obtener el id del usuario y el nombre
    $usuariosDAO = new UsuariosDAO($conn);
    //$usuario = $usuariosDAO->getByEmail($_COOKIE['email']);
    if($usuario = $usuariosDAO->getBySid($_COOKIE['sid'])){
        //Inicio sesión
        $_SESSION['email']=$usuario->getEmail();
        $_SESSION['id']=$usuario->getId();
        $_SESSION['nombre']=$usuario->getNombre();
    }
}

//Creamos el objeto AnunciosDAO para acceder a BBDD a través de este objeto
//$anuncioDAO = new AnunciosDAO($conn);
//$anuncios = $anuncioDAO->getAll();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallapop</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace navegacion__enlace--activo" href="#">Anuncios</a>
        <a class="navegacion__enlace" href="#">Mis Anuncios</a>
        <a class="navegacion__enlace" href="registrar_usuario.php">Regístrate</a>

        <?php if(isset($_SESSION['email'])): ?>
        <span class="nombreUsuario"><?= $_SESSION['nombre'] ?></span>
        <a href="logout.php">cerrar sesión</a>
        <?php else: ?>
            <form action="login.php" method="post">

                <input type="email" name="email" placeholder="email">
                <input type="password" name="password" placeholder="password">
                <input type="submit" value="login">
            </form>
        <?php endif; ?>
    </nav>

    <main class="contenedor">
        <h1>Lo mejor, al mejor precio</h1>

        
    </main>
    
</body>
</html>