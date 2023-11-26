<?php
session_start();

require_once 'modelos/connexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/anuncio.php';
require_once 'modelos/anunciosDAO.php';
require_once 'modelos/usuario.php';
require_once 'modelos/usuariosDAO.php';
require_once 'modelos/foto.php';

//Crear la conexión con la BD
$connexionDB = new connexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);;
$conn = $connexionDB->getConnexion();

//Crear anunciosDAO y usuariosDAO para acceder a BBDD a través de este objeto
$anunciosDAO = new anunciosDAO($conn);
$usuariosDAO = new usuariosDAO($conn);


//Obtener el anuncio
$idAnuncio = htmlspecialchars($_GET['id']);
$anuncio = $anunciosDAO->getById($idAnuncio);

//Obtener el usuario del anuncio
$idUsuario = $anuncio->getIdUsuario();
$usuario = $usuariosDAO->getById($idUsuario);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncio</title>

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <main class="contenedor sombra">
        <h1>Anuncio</h1>
        <div class="ver_anuncio">
            <?php if($anuncio != null && $usuario != null): ?>
                <div class="usuario"> <?= $usuario->getNombre() ?></div>

                <div class="fotos_anuncio">
                    <?php foreach($anuncio->getFotos() as $foto): ?>
                        <img src="<?=$foto->getRutaFoto()?>" alt="<?=$anuncio->getTitulo()?>"/>
                    <?php endforeach; ?>
                </div>

                <div class="titulo">Titulo: <?= $anuncio->getTitulo() ?></div>
                <div class="texto">Descripción: <?=  strip_tags(str_replace('&lt;br&gt', '', $anuncio->getDescripcion()))?></div>
                <div class="precio">Precio: <?= $anuncio->getPrecio() ?></div>

            <?php else: ?>
                <strong>Mensaje con id <?= $id ?> no encontrado</strong>
            <?php endif; ?>
            <br><br><br>
            <input class="boton boton--primario derecha" type="submit" value="Comprar">

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