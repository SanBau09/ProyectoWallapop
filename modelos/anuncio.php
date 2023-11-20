<?php 
    class Anuncio {
        private $id;
        private $idUsuario;
        private $titulo;
        private $descripcion;
        private $fecha_creacion;
        private $precio;
        private $fotos = array();

    // Métodos para acceder a los atributos
        public function getId(){
            return $this->id;
        }
        public function setId($id): self{
            $this->id = $id;
            return $this;
        }


        public function getIdUsuario(){
            return $this->idUsuario;
        }
        public function setIdUsuario($idUsuario): self{
            $this->idUsuario = $idUsuario;
            return $this;
        }


        public function getTitulo(){
            return $this->titulo;
        }
        public function setTitulo($titulo): self{
            $this->titulo = $titulo;
            return $this;
        }


        public function getDescripcion(){
            return $this->descripcion;
        }
        public function setDescripcion($descripcion): self{
            $this->descripcion = $descripcion;
            return $this;
        }


        public function getFechaCreacion(){
            return $this->fecha_creacion;
        }
        public function setFechaCreacion($fecha_creacion): self{
            $this->fecha_creacion = $fecha_creacion;
            return $this;
        }


        public function getPrecio(){
            return $this->precio;
        }
        public function setPrecio($precio): self{
            $this->precio = $precio;
            return $this;
        }

        public function getFotos(){
            return $this->fotos;
        }
        public function setFotos($fotos): self{
            $this->fotos = $fotos;            
            return $this;
        }
    }

?>