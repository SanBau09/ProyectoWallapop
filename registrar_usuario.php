<?php
    require_once "modelos/connexionDB.php";
    require_once "modelos/usuario.php";
    require_once "modelos/usuariosDAO.php";
    require_once "modelos/config.php";
    require_once "utils/funciones.php";

    $error='';

    if($_SERVER['REQUEST_METHOD']=='POST'){
    
        //Limpiamos los datos
        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);
        $nombre = htmlentities($_POST['nombre']);
        $telefono = htmlentities($_POST['telefono']);
        $poblacion = htmlentities($_POST['poblacion']);
    
        //Validación 
    
        //Conectamos con la BD
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();
    
        //Compruebo que no haya un usuario registrado con el mismo email
        $usuariosDAO = new UsuariosDAO($conn);
        if($usuariosDAO->getByEmail($email) != null){
            $error = "Ya hay un usuario con ese email";
        }
        
        if($error == ''){    //Si no hay error

            //Insertamos en la BD
            $usuario = new Usuario();
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
    <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo">
        </a>
    </header>

    <main class="contenedor">
        <h1>Registro</h1>
        <?= $error ?>
        <form class="formulario" action="registrar_usuario.php" method="post" enctype="multipart/form-data">

            <div class="campo">
                <label class="campo__label" for="email">Email</label>
                <input class="campo__field" type="email" name="email" placeholder="Tu Email"><br>
            </div>  
            <div class="campo">
                <label class="campo__label" for="password">Password</label>
                <input class="campo__field"  type="password" name="password" placeholder="Tu Password"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="nombre">Nombre</label>
                <input class="campo__field" type="text" name="nombre"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="telefono">Telefono</label>
                <input class="campo__field" type="tel" name="telefono"><br>
            </div> 
            <div class="campo">
                <label class="campo__label" for="poblacion">Poblacion</label>
                <input class="campo__field" type="text" name="poblacion"><br>
            </div> 
            <div class="campo">
                <input type="submit" value="registrar" class="boton boton--primario derecha"><br>
            </div>

            <a class="derecha" href="index.php">volver</a>
                
        </form>
    </main> 
</body>
</html>