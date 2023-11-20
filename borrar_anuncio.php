<?php 
session_start();

require_once 'modelos/connexionDB.php';
require_once 'modelos/anuncio.php';
require_once 'modelos/anunciosDAO.php';
require_once 'utils/funciones.php';
require_once 'modelos/config.php';

//Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Creamos el objeto anunciosDAO para acceder a BBDD a través de este objeto
$anunciosDAO = new anunciosDAO($conn);

//Obtener el anuncio
$idAnuncio = htmlspecialchars($_GET['id']);
$anuncio = $anunciosDAO->getById($idAnuncio);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/normalize.css">
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

    <main>
        <!--Comprobamos que anuncio pertenece al usuario conectado -->
        <?php if($_SESSION['id']==$anuncio->getIdUsuario()):
            $anunciosDAO->delete($idAnuncio); ?>
            ANUNCIO BORRADO CORRECTAMENTE
        <?php else: ?>
            EL ANUNCIO NO SE PUEDE BORRAR
        <?php endif; ?>        

        <a href="misAnuncios.php" class="nuevoAnuncio">Volver a Mis Anuncios</a>
    </main>

</body>
</html>