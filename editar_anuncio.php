<?php
session_start();

require_once 'modelos/connexionDB.php';
require_once 'modelos/config.php';
require_once 'modelos/anuncio.php';
require_once 'modelos/anunciosDAO.php';
require_once 'modelos/foto.php';

//¡¡Página privada!! Esto impide que puedan ver esta página si no han iniciado sesión
if(!isset($_SESSION['email'])){
    header("location: index.php");
    guardarMensaje("No puedes editar anuncios si no estás indentificado");
    die();
}

$titulo = $descripcion = $precio = '';
$fotosAnuncio = array();
$error ='';

//Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();

//Obtengo el id del anuncio que viene por GET
$idAnuncio = htmlspecialchars($_GET['id']);

//Obtengo el anuncio de la BD
$anunciosDAO = new anunciosDAO($conn);
$anuncio = $anunciosDAO->getById($idAnuncio);


if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['precio']) ){
        //Limpiamos los datos que vienen del usuario
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion =  htmlspecialchars($_POST['descripcion']);
        //$descripcion =  strip_tags($_POST['descripcion'],"<br>"); seria así
        $precio =  htmlspecialchars($_POST['precio']);
        $indiceFotoPrincipal = htmlspecialchars($_POST['foto_principal']);
        
        //Validamos los datos
        if(empty($titulo) || empty($descripcion)|| empty($precio)){
            $error = "Los tres campos son obligatorios";
        }        
        else{            
                         
            // Si no ha habido error previo, se guarda el anuncio en la base de datos
            if ($error == ''){ 
                if ($anuncio != null){
                                                        
                    $anuncio->setTitulo($titulo);
                    $anuncio->setDescripcion($descripcion);
                    $anuncio->setPrecio($precio);                  
                    $anuncio->establecerFotoPrincipal($indiceFotoPrincipal);

                    $anunciosDAO->update($anuncio);
                    header('location: misAnuncios.php');
                    die();
                }
            }
        }
    }      

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/jquery-te-1.4.0.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="utils/jquery-te-1.4.0.min.js"></script>
    <title>Editar Anuncio</title>
</head>
<body>
<header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <main class="contenedor sombra">
        <h1>Edita tu Anuncio</h1>
        <?= $error ?>
        <form class="formulario" action="editar_anuncio.php?id=<?= $idAnuncio ?>" method="post" enctype="multipart/form-data">

            <?php if($anuncio != null): ?>
                <div class="campo">
                    <label class="campo__label" for="titulo">Título</label>
                    <input class="campo__field" type="text" name="titulo" placeholder="Titulo" value="<?= $anuncio->getTitulo() ?>"><br>
                </div> 

                <div class="campo">
                    <label class="campo__label" for="precio">Precio</label>
                    <input class="campo__field" type="number" name="precio" placeholder="Precio" value="<?= $anuncio->getPrecio() ?>"><br>
                </div> 

                <div class="campo">
                    <label class="campo__label" for="descripcion">Añade tu descripción</label>
                    <textarea class="editor" name="descripcion" placeholder="descripcion" ><?= $anuncio->getDescripcion() ?></textarea><br>
                </div> 
            
                <div class="fotos_anuncio">
                    <?php foreach($anuncio->getFotos() as $index => $foto): ?>
                        <div class="card">
                            <img src="<?=$foto->getRutaFoto()?>" alt="<?=$anuncio->getTitulo()?>"/>

                            <label>
                            <input type="radio" name="foto_principal" value="<?= $index ?>"
                                <?php if ($foto->getFotoPrincipal()): ?>checked<?php endif; ?>> <!-- El radio está marcado si la foto es foto principal -->
                            Foto Principal
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="campo">
                <input class="boton boton--primario derecha" type="submit"name="Editar" value="Editar">
            </div>
        </form>
        <script>
            $(document).ready(function(){
            $('.editor').jqte();
            });

        </script>
</body>
</html>