<?php
    session_start();

    require_once "modelos/connexionDB.php";

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
        <a href="index.html">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace navegacion__enlace--activo" href="#">Anuncios</a>
        <a class="navegacion__enlace" href="#">Mis Anuncios</a>
        <a class="navegacion__enlace" href="registrar_usuarios.php">Regístrate</a>

        <form action="login.php" method="post">

            <input type="email" name="email" placeholder="email">
            <input type="password" name="password" placeholder="password">
            <input type="submit" value="login">
                
        </form>
    </nav>

    <main class="contenedor">
        <h1>Lo mejor, al mejor precio</h1>

        
    </main>
    
</body>
</html>