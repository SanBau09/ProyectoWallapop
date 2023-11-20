<?php

class anunciosDAO {
    private mysqli $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Obtiene un anuncio de la BD en función del id pasado
     * @return Anuncio Devuelve el objeto Anuncio o null si no lo encuentra
     */
    public function getById($id):Anuncio|null {

        if(!$stmt = $this->conn->prepare("SELECT * FROM Anuncios WHERE id = ?")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$id);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        //Si ha encontrado algún resultado devolvemos un objeto de la clase Anuncio, sino null
        if($result->num_rows == 1){
            $anuncio = $result->fetch_object(Anuncio::class);
            return $anuncio;
        }
        else{
            return null;
        }
    }

    /**
     * Obtiene todos los anuncios de la tabla anuncios
     * @return array Devuelve un array de objetos Anuncio
     */
    public function getAll():array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM Anuncios ORDER BY fecha_creacion DESC")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_anuncios = array();
        
        while($anuncio = $result->fetch_object(Anuncio::class)){
            $array_anuncios[] = $anuncio;
        }
        return $array_anuncios;
    }


    /**
     * Obtiene todos los anuncios de la tabla anuncios con el id del usuario
     * @return array Devuelve un array de objetos Anuncio
     */
    public function getAllAnunUsuario($idUsuario):array {
        if(!$stmt = $this->conn->prepare("SELECT * FROM Anuncios WHERE idUsuario = ? ")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idUsuario);
        //Ejecutamos la SQL
        $stmt->execute();
        //Obtener el objeto mysql_result
        $result = $stmt->get_result();

        $array_anunciosUsuario = array();
        
        while($anuncio = $result->fetch_object(Anuncio::class)){
            $array_anunciosUsuario[] = $anuncio;
        }
        return $array_anunciosUsuario;
    }

    /**
     * Obtiene la foto principal del anuncio
     * @return string Devuelve la ruta de la imagen principal
     */
    public function getFotoPrincipal($idAnuncio):string{

        if(!$stmt = $this->conn->prepare("SELECT ruta_foto FROM FotosAnuncios WHERE idAnuncio = ? AND foto_principal =  1 LIMIT 1")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmt->bind_param('i',$idAnuncio);
        //Ejecutamos la SQL
        $stmt->execute();
        // Obtiene el resultado
        $stmt->bind_result($rutaFoto);

        // Obtiene la primera fila (si existe)
        $stmt->fetch();

        // Cierra la declaración
        $stmt->close();

        // Devuelve la ruta de la imagen principal o una cadena vacía si no se encuentra
        return $rutaFoto ?: "";
    }




    /**
     * borra el anuncio de la tabla anuncios del id pasado por parámetro
     * @return true si ha borrado el anuncio y false si no lo ha borrado (por que no existia)
     */
    function delete($id):bool{

        // Primero se borran las fotos de los anuncios por la integridad referencial
        if(!$stmtFotos = $this->conn->prepare("DELETE FROM FotosAnuncios WHERE idAnuncio = ?")){
            echo "Error en la SQL: " . $this->conn->error;
        }
        //Asociar las variables a las interrogaciones(parámetros)
        $stmtFotos->bind_param('i',$id);
        //Ejecutamos la SQL
        if ($stmtFotos->execute()){
            if(!$stmt = $this->conn->prepare("DELETE FROM Anuncios WHERE id = ?")){
                echo "Error en la SQL: " . $this->conn->error;
            }
            //Asociar las variables a las interrogaciones(parámetros)
            $stmt->bind_param('i',$id);
            //Ejecutamos la SQL
            $stmt->execute();
            //Comprobamos si ha borrado algún registro o no
            if($stmt->affected_rows==1){   
                return true;
            }
            else{
                return false;
            }
        } 
        else{
            return false;
        }       
    }

    /**
     * Inserta en la base de datos el anuncio que recibe como parámetro
     * @return id Devuelve el id autonumérico que se le ha asignado al anuncio o false en caso de error
     */
    function insert(Anuncio $anuncio): int|bool{
        if(!$stmt = $this->conn->prepare("INSERT INTO Anuncios (idUsuario, titulo, descripcion, precio) VALUES (?,?,?,?)")){
            die("Error al preparar la consulta insert: " . $this->conn->error );
        }
        $idUsuario = $anuncio->getIdUsuario();
        $titulo = $anuncio->getTitulo();
        $descripcion = $anuncio->getDescripcion();
        $precio = $anuncio->getPrecio();
        $fotos = $anuncio->getFotos();

        $stmt->bind_param('issd',$idUsuario, $titulo, $descripcion, $precio);
        if($stmt->execute()){
            
            // Ahora hay que guardar todas las fotos en la tabla de FotosAnuncios
            foreach($fotos as $foto){
                if(!$stmtFotos = $this->conn->prepare("INSERT INTO FotosAnuncios (idAnuncio, ruta_foto, foto_principal) VALUES (?,?,?)")){
                    die("Error al preparar la consulta insert: " . $this->conn->error );
                }
                $idAnuncio = $stmt->insert_id; // El id del anuncio es el valor incremental que devuelve la base de datos al hacer la inserción en la tabla Anuncio
                $ruta_foto = $foto->getRutaFoto();
                $foto_principal = $foto->getFotoPrincipal();

                $stmtFotos->bind_param('isi',$idAnuncio, $ruta_foto, $foto_principal);
                if (!$stmtFotos->execute()){
                    die("Error guardar las fotos: " . $this->conn->error );
                }
            }             

            return $stmt->insert_id;
        }
        else{
            return false;
        }
    }

     /**
     * Actualiza en la base de datos el anuncio que recibe como parámetro
     */
    function update($anuncio){
        if(!$stmt = $this->conn->prepare("UPDATE Anuncios SET titulo=?, descripcion=?, precio=? WHERE id=?")){
            die("Error al preparar la consulta update: " . $this->conn->error );
        }
        $id = $anuncio->getId();
        $titulo = $anuncio->getTitulo();
        $descripcion = $anuncio->getDescripcion();
        $precio = $anuncio->getPrecio();
        $fotos = $anuncio->getFotos();
        
        $stmt->bind_param('issd',$id, $titulo, $descripcion, $precio);

        if ($stmt->execute()){// Si el update de la tabla Anuncio es correcto, se hace el update de la tabla fotosAnuncio
            foreach($fotos as $foto){
                if(!$stmtFotos = $this->conn->prepare("UPDATE FotosAnuncios SET foto_principal=? WHERE id=?")){
                    die("Error al preparar la consulta insert: " . $this->conn->error );
                }
                $idFoto = $foto->getId();
                $foto_principal = $foto->getFotoPrincipal();

                $stmtFotos->bind_param('ii',$id, $foto_principal);
                if (!$stmtFotos->execute()){
                    die("Error actualizar las fotos: " . $this->conn->error );
                }
            }
            return true;
        }
        else{
            return false;
        }
    }
}
?>
