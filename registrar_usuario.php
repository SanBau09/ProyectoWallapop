<?php
    require_once "modelos/connexionDB.php";
    require_once "modelos/usuario.php";
    require_once "modelos/usuariosDAO.php";
    require_once "modelos/config.php";
    require_once "utils/funciones.php";

    //Declaramos las variables para que no fallen en los value="" del html la primera vez que entramos
    $email = $password = $nombre = $telefono = $poblacion = '';
    $error= $msje_error_email = $msje_error_password = '';

    if($_SERVER['REQUEST_METHOD']=='POST'){ //si el formulario ha sido enviado...
    
        //Limpiamos los datos con htmlentities para prevenir inyecciones HTML en los datos recibidos del formulario
        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);
        $nombre = htmlentities($_POST['nombre']);
        $telefono = htmlentities($_POST['telefono']);
        $poblacion = htmlentities($_POST['poblacion']);
    
        //VALIDACION de campos obligatorios y otras
        $error = false;
    
        //Comprobar si el email es un email de verdad
        if(filter_var($email,FILTER_VALIDATE_EMAIL)==false){
            $error = true;
            $msje_error_email = "El email no tiene el formato correcto";
        }
        //Comprobar si el email esta vacío
        if(empty($email)){
            $error = true;
            $msje_error_email = "Debe escribir un email";
        }
        //Comprobar que el password tiene al menos 4 caracteres
        if(strlen($password)<4){
            $error = true;
            $msje_error_password = "Debe escribir un password de al menos 4 caracteres";        
        }
    
        //Conectamos con la BD
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        //Compruebo que no haya un usuario registrado con el mismo email
        $usuariosDAO = new UsuariosDAO($conn);
        if($usuariosDAO->getByEmail($email) != null){
            $error = true;
            $msje_error_email = "Ya hay un usuario con ese email";
        }
        
        if($error == ''){    //Si no hay error

            //Insertamos en la BD un nuevo usuario
            $usuario = new Usuario();

            //se establecen sus propiedades con los datos del formulario
            $usuario->setSid(sha1(rand()+time()), true);
            $usuario->setEmail($email);
            //encriptamos el password
            $passwordCifrado = password_hash($password,PASSWORD_DEFAULT);
            $usuario->setPassword($passwordCifrado);
            $usuario->setNombre($nombre);
            $usuario->setTelefono($telefono);
            $usuario->setPoblacion($poblacion);


            if($usuariosDAO->insert($usuario)){
                header("location: index.php");
                die();
            }else{
                $error = "No se ha podido insertar el usuario";
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
    <title>Registro Usuarios</title>

    <style>
        .mensaje_error{
            color:red;
            font-style: oblique;
            font-size: 0.7em;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <main class="contenedor sombra">
        <h1>Registro</h1>
        <?= $error ?>
        <form class="formulario" action="registrar_usuario.php" method="post" enctype="multipart/form-data">

            <div class="campo">
                <label class="campo__label" for="email">Email</label>
                <input class="campo__field" type="email" name="email" placeholder="Tu Email" value="<?= $email?>"><br>
                <span class="mensaje_error">* <?= $msje_error_email ?></span><br>
            </div>  
            <div class="campo">
                <label class="campo__label" for="password">Password</label>
                <input class="campo__field"  type="password" name="password" placeholder="Tu Password" value="<?= $password ?>"><br>
                <span class="mensaje_error">* <?= $msje_error_password ?></span><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="nombre">Nombre</label>
                <input class="campo__field" type="text" name="nombre" value="<?= $nombre?>"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="telefono">Telefono</label>
                <input class="campo__field" type="tel" name="telefono" value="<?= $telefono?>"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="poblacion">Poblacion</label>
                <input class="campo__field" type="text" name="poblacion" value="<?= $poblacion?>"><br>
            </div> 
            <div class="campo">
                <input type="submit" value="registrar" class="boton boton--primario derecha"><br>
            </div>

            <a class="derecha" href="index.php">volver</a>
                
        </form>
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