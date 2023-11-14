<?php

class usuariosDAO{
    private mysqli $conn; //propiedad que se va a usar en el resto de la clase

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Obtiene un usuario de la BD en función del id
     * @return Usuario Devuelve un Objeto de la clase Usuario
     */
    public function getById($id):Usuario|null{
        return null;
    }

   /**
     * Obtiene un array de usuarios de la BD en función del id
     * @return array_usuarios Devuelve un array de usuarios
     */
    //OBTIENE TODOS LOS USUARIOS DE LA TABLA USUARIOS
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios")){
            echo "Error en la SQL: " . $this->conn->error;
        }
       
        $stmt->execute();     //Ejecutamos la SQL
        $result = $stmt->get_result();  //Obtener el objeto mysql_result

        $array_mensajes = array();
        
        while($usuario = $result->fetch_object(Usuario::class)){
            $array_usuarios[] = $usuario;
        }
        return $array_usuarios;
    }

    /**
     * Obtiene un usuario de la BD en función del email
     * @return Usuario Devuelve un Objeto de la clase Usuario o null si no existe
     */
    public function getByEmail($email):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$email);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Usuario, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    } 

    /**
     * Obtiene un usuario de la BD en función del id
     * @return Usuario Devuelve un Objeto de la clase Usuario o null si no existe
     */
    public function getBySid($sdi):Usuario|null {
        if(!$stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE sid = ?"))
        {
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('s',$sid);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Usuario, sino null
        if($result->num_rows >= 1){
            $usuario = $result->fetch_object(Usuario::class);
            return $usuario;
        }
        else{
            return null;
        }
    } 

    /**
     * BORRA EL USUARIO de la tabla usuarios del id pasado por parámetro
     * @return true si ha borrado el usuario y false si no lo ha borrado (por que no existia)
     */
    function delete($id):bool{
        if(!$stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id=?")){
            echo "Error en la SQL: " . $this->conn->error;
        }
                    
        $stmt->bind_param('i',$id);   //Asociar las variables a las ? 
        $stmt->execute();          //Ejecutamos la SQL

        //Comprobamos si ha borrado o no algún registro
        if($stmt->affected_rows==1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Inserta en la base de datos el usuario que recibe como parámetro
     * @return idUsuario Devuelve el id autonumérico que se le ha asignado al usuario o false en caso de error
     */
    function insert(Usuario $usuario): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO usuarios (sid, email, password, nombre, telefono, poblacion) VALUES (?,?,?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $sid = $usuario->getSid();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $nombre = $usuario->getNombre();
        $telefono = $usuario->getTelefono();
        $poblacion = $usuario->getPoblacion();
  
        $stmt->bind_param('ssssss',$sid, $email, $password, $nombre, $telefono, $poblacion);
        if($stmt->execute()){
            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }
}


?>