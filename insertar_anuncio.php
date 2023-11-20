<?php 
session_start();

require_once 'modelos/connexionDB.php';
require_once 'utils/funciones.php';
require_once 'modelos/config.php';
require_once 'modelos/anuncio.php';
require_once 'modelos/anunciosDAO.php';
require_once 'modelos/foto.php';

//¡¡Página privada!! Esto impide que puedan ver esta página si no han iniciado sesión
if(!isset($_SESSION['email'])){
    header("location: index.php");
    guardarMensaje("No puedes insertar anuncios si no estás indentificado");
    die();
}

$titulo = $descripcion = $precio = '';
$fotosAnuncio = array();
$error ='';

//Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['precio']) ){
        //Limpiamos los datos que vienen del usuario
        $titulo = htmlspecialchars($_POST['titulo']);
        $descripcion =  htmlspecialchars($_POST['descripcion']);
        $precio =  htmlspecialchars($_POST['precio']);
        
        //Validamos los datos
        if(empty($titulo) || empty($descripcion)|| empty($precio)){
            $error = "Los tres campos son obligatorios";
        }        
        else{            
            $fotosNombres = $_FILES['file']['name'];  
            $fotosTipos = $_FILES['file']['type'];
            $fotosTempNombres = $_FILES['file']['tmp_name'];        
            
            $indice = 0;
            foreach($fotosNombres as $foto){
                // Se comprueba que el formato de la foto es el correcto
                if($fotosTipos[$indice] != 'image/jpeg' &&
                $fotosTipos[$indice] != 'image/webp' &&
                $fotosTipos[$indice] != 'image/png')
                {
                    $error="la foto no tiene el formato admitido, debe ser jpg, webp o png";
                }
                else{                    
                    //Calculamos un hash para el nombre del archivo
                    $fotoNombre = generarNombreArchivo($foto);                    
                    //Si existe un archivo con ese nombre volvemos a calcular el hash
                    while(file_exists("fotosAnuncios/$fotoNombre")){
                        $fotoNombre = generarNombreArchivo($foto);
                    }
                    // Se guarda la foto en la carpeta y si no se puede salta el error
                    if(!move_uploaded_file($fotosTempNombres[$indice], "fotosAnuncios/$fotoNombre")){
                        die("Error al copiar la foto a la carpeta fotosAnuncios");
                    }
                    else{ // Todo ha ido bien, así que se genera el objeto de tipo Foto y se guarda en un array
                        $nuevaFoto = new Foto();
                        $nuevaFoto->setRutaFoto("fotosAnuncios/$fotoNombre");
                        if ($indice == 0){ // Si el array contiene fotos, se marca como principal la primera
                            $nuevaFoto->setFotoPrincipal(true);
                        }
                        array_push($fotosAnuncio, $nuevaFoto); // Se introduce la nueva foto al array de fotos
                    }
                }
                $indice ++;
            }

            // Si no ha habido error previo, se guarda el anuncio en la base de datos
            if ($error == ''){ 
                
                //Creamos el objeto anunciosDAO para acceder a BBDD a través de este objeto
                $anunciosDAO = new anunciosDAO($conn);
                $anuncio = new Anuncio();
                $anuncio->setTitulo($titulo);
                $anuncio->setDescripcion($descripcion);
                $anuncio->setPrecio($precio);
                $anuncio->setIdUsuario($_SESSION['id']); //El id del usuario conectado (en la sesión)
                $anuncio->setFotos($fotosAnuncio);

                $anunciosDAO->insert($anuncio);
                header('location: misAnuncios.php');
                die();
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
    <title>Crear Anuncio</title>
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <main class="contenedor">
        <h1>Crea tu Anuncio</h1>
        <?= $error ?>
        <form class="formulario" action="insertar_anuncio.php" method="post" enctype="multipart/form-data">
            <div class="campo">
                <label class="campo__label" for="titulo">Título</label>
                <input class="campo__field" type="text" name="titulo" placeholder="Titulo"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="precio">Precio</label>
                <input class="campo__field" type="number" name="precio" placeholder="Precio"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="descripcion">Añade tu descripción</label>
                <textarea class="editor" name="descripcion" placeholder="descripcion"></textarea><br>
            </div> 
            <div class="campo"> 
                <input type='file' name='file[]' accept="image/jpeg, image/gif, image/webp, image/png" multiple><br> 
            </div>
            <div class="campo">
                <input type="submit">
            </div>
        </form>
        <!--<script>
            $(document).ready(function(){
            $('.editor').jqte();
            });

        </script>-->
</body>

<!-- jQuery -->
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/utils/jquery-te-1.4.0.min.js"></script>-->
</html>