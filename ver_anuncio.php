<?php
session_start();

require_once 'modelos/connexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/anuncio.php';
require_once 'modelos/anunciosDAO.php';

//Crear la conexión con la BD
$connexionDB = new connexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);;
$conn = $connexionDB->getConnexion();

//Crear anunciosDAO para acceder a BBDD a través de este objeto
$anunciosDAO = new anunciosDAO($conn);


//Obtener el mensaje
$idAnuncio = htmlspecialchars($_GET['id']);
$anuncio = $anunciosDAO->getById($idAnuncio);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Anuncio</title>

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

    <main class="contenedor">
        <h1>Crea tu Anuncio</h1>
        <div class="ver_anuncio">
            <?php if($anuncio!=null): ?>
                <div class="titulo"><?= $anuncio->getTitulo() ?> </div>
                <div class="texto"><?= $anuncio->getDescripcion() ?> </div>
                <div class="fecha"><?= $anuncio->getPrecio() ?> </div>
            <?php else: ?>
                <strong>Mensaje con id <?= $id ?> no encontrado</strong>
            <?php endif; ?>
            <br><br><br>
            <a href="index.php">Volver al listado de mensajes</a>

        </div>
    </main>
</body>
</html>