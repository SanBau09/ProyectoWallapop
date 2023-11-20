<?php
    session_start();

    require_once "modelos/connexionDB.php";
    require_once 'modelos/usuario.php';
    require_once 'modelos/usuariosDAO.php';
    require_once 'modelos/anuncio.php';
    require_once 'modelos/anunciosDAO.php';
    require_once 'modelos/config.php';
    require_once "utils/funciones.php";

    //Creamos la conexión utilizando la clase que hemos creado
    $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
    $conn = $connexionDB->getConnexion();  
    //Si existe la cookie le iniciamos sesión de forma automática
    if(isset($_COOKIE['sid'])){
        //Nos conectamos para obtener el id del usuario y el nombre
        $usuariosDAO = new UsuariosDAO($conn);
        //si existe el usuario asociado a la cookie 
        if($usuario = $usuariosDAO->getBySid($_COOKIE['sid'])){
            //Inicio sesión
            if (!isset($_SESSION['email'])){
                $_SESSION['email']=$usuario->getEmail();
            }
            $_SESSION['id']=$usuario->getId();
            $_SESSION['nombre']=$usuario->getNombre();

            // Renovamos la cookie para recordar 1 semana
            setcookie('sid', $usuario->getSid(), time() + 7 * 24 * 60 * 60, '/');
        }
    }
    
    //Creamos el objeto AnunciosDAO para acceder a BBDD a través de este objeto
    $anuncioDAO = new AnunciosDAO($conn);
    $anuncios = $anuncioDAO->getAll();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallapop</title>
    <link rel="stylesheet" href="css/normalize.css">

    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">
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
        <a class="navegacion__enlace navegacion__enlace--activo" href="index.php">Anuncios</a>
        <a class="navegacion__enlace" href="misAnuncios.php">Mis Anuncios</a>
        <a class="navegacion__enlace" href="registrar_usuario.php">Regístrate</a>

        <?php if(isset($_SESSION['email'])): ?>
            <div class="usuario-info">
                <span class="nombreUsuario"><?= $_SESSION['nombre'] ?></span>
                <a href="logout.php">| cerrar sesión</a>
            </div>
        <?php else: ?>
            <form action="login.php" method="post">
                <input type="email" name="email" placeholder="email">
                <input type="password" name="password" placeholder="password">
                <input type="submit" value="login">
            </form>
        <?php endif; ?>
    </nav>

    <main class="contenedor">
        <h1>Lo mejor,  al mejor precio</h1>
        <div class="listado-anuncios">
            <?php foreach ($anuncios as $anuncio): ?>
                <div class="card">
                    <img src="<?=$anuncioDAO->getFotoPrincipal($anuncio->getId())?>" alt="<?=$anuncio->getTitulo()?>"/>
                    <h4 class="titulo">
                        <a href="ver_anuncio.php?id=<?=$anuncio->getId()?>"><?= $anuncio->getTitulo() ?></a>
                    </h4>
                    <p> PRECIO: <?= $anuncio->getPrecio() ?></p>
                    <?php if(isset($_SESSION['email']) && $_SESSION['id']==$anuncio->getIdUsuario()): ?>
                        <span class="icono_borrar"><a href="borrar_anuncio.php?id=<?=$anuncio->getId()?>"><i class="fa-solid fa-trash color_gris"></i></a></span>
                        <span class="icono_editar"><a href="editar_anuncio.php?id=<?=$anuncio->getId()?>"><i class="fa-solid fa-pen-to-square color_gris"></i></a></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>


        <?php if(isset($_SESSION['email'])): ?>
            <a href="insertar_anuncio.php" class="nuevoAnuncio">Nuevo anuncio</a>
        <?php endif; ?> 
    </main>        

</body>
</html>