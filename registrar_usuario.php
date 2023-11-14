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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registro</h1>
    <?= $error ?>
    <form action="registrar_usuario.php" method="post" enctype="multipart/form-data">
        <input type="email" name="email"><br>
        <input type="password" name="password"><br>
        <input type="text" name="nombre"><br>
        <input type="tel" name="telefono"><br>
        <input type="text" name="poblacion"><br>

        <input type="submit" value="registrar_usuario">
        <a href="index.php">volver</a>
    </form>
</body>
</html>