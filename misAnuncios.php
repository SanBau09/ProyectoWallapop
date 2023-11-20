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

//Creamos el objeto anunciosDAO para acceder a BBDD a través de este objeto
$anuncioDAO = new anunciosDAO($conn);
$anuncios = $anuncioDAO->getAllAnunUsuario($_SESSION['id']); //El id del usuario conectado (en la sesión)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Mis Anuncios</title>
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
                <a class="cerrarSesion" href="logout.php">| cerrar sesión</a>
                <a  class="boton--nav " href="insertar_anuncio.php" class="nuevoAnuncio">Subir anuncio</a>
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
        <h1>Mis Anuncios Publicados</h1>
        <div class="listado-anuncios">
            <?php foreach ($anuncios as $anuncio): ?>
                <div class="card">
                    <img src="<?=$anuncioDAO->getFotoPrincipal($anuncio->getId())?>" alt="<?=$anuncio->getTitulo()?>"/>
                    <h4 class="titulo">
                        <a href="ver_anuncio.php?id=<?=$anuncio->getId()?>"><?= $anuncio->getTitulo() ?></a>
                    </h4>
                    <p> PRECIO: <?= $anuncio->getPrecio() ?></p>

                    <div class="icono_contenedor">
                        <?php if(isset($_SESSION['email']) && $_SESSION['id']==$anuncio->getIdUsuario()): ?>
                            <span class="icono_borrar"><a href="borrar_anuncio.php?id=<?=$anuncio->getId()?>"><i class="fa-solid fa-trash color_gris"></i></a></span>
                            <span class="icono_editar"><a href="editar_anuncio.php?id=<?=$anuncio->getId()?>"><i class="fa-solid fa-pen-to-square color_gris"></i></a></span>
                        <?php endif; ?>
                    </div> 
                </div>
            <?php endforeach; ?>
        </div>
    </main>  

    <!--FOOTER-->
    <footer class="site-footer">
        <div class="grid-footer contenedor">
        <div><!--Categorias-->
                <h3>Categorías</h3>

                <nav class="footer-menu">
                    <a href="#">Coches</a>
                    <a href="#">Moda y Accesorios</a>
                    <a href="#">Móviles y Telefonía</a>
                    <a href="#">Flores</a>
                    <a href="#">Cine, Libros y Música</a>
                </nav>
            </div>

            <div><!--Sobre Nosotros-->
                <h3>Sobre Nosotros</h3>

                <nav class="footer-menu">
                    <a href="#">Nuestra Historia</a>
                    <a href="#">Misión, Visión y Valores</a>
                    <a href="#">Política de Privacidad</a>
                    <a href="#">Términos del Servicio</a>
                </nav>
            </div>

            <div><!--Soporte-->
                <h3>Soporte</h3>

                <nav class="footer-menu">
                    <a href="#">Preguntas Frecuentes</a>
                    <a href="#">Ayuda en Línea</a>
                    <a href="#">Confianza y Seguridad</a>
                </nav>
            </div>
        </div>
        <p class="copyright">Todos los derechos reservados, Wallapop</p>
    </footer>
    
</body>
</html>