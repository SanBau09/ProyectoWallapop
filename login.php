<?php 
session_start();
require_once 'modelos/connexionDB.php';
require_once 'modelos/usuario.php';
require_once 'modelos/usuariosDAO.php';
require_once 'modelos/config.php';
require_once 'utils/funciones.php';

//Creamos la conexión utilizando la clase que hemos creado
$connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();

//limpiamos los datos que vienen del usuario
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

//Validamos el usuario
$usuariosDAO = new UsuariosDAO($conn);
if($usuario = $usuariosDAO->getByEmail($email)){
    if(password_verify($password, $usuario->getPassword())){
        //email y password correctos. Inciamos sesión
        $_SESSION['email'] = $usuario->getEmail();
        $_SESSION['id'] = $usuario->getId();
        $_SESSION['nombre']=$usuario->getNombre();
        
        //Creamos o renovamos la cookie para que nos recuerde 1 semana
        setcookie('sid',$usuario->getSid(),time()+7 *24*60*60,'/');
        //Redirigimos a index.php
        header('location: index.php');
        die();
    }
}
//email o password incorrectos, redirigir a index.php
guardarMensaje("Email o password incorrectos");
header('location: index.php');