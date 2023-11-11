<?php 
    class Usuario {
        private $id;
        private $sid;
        private $email;
        private $password;
        private $nombre;
        private $telefono;
        private $poblacion;

    // Métodos para acceder a los atributos
        public function getId(){
            return $this->id;
        }
        public function setId($id): self{
            $this->id = $id;
            return $this;
        }


        public function getSid(){
            return $this->sid;
        }
        public function setSid($sid): self{
            $this->sid = $sid;
            return $this;
        }


        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email): self{
            $this->email = $email;
            return $this;
        }


        public function getPassword(){
            return $this->password;
        }
        public function setPassword($password): self{
            $this->password = $password;
            return $this;
        }


        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre): self{
            $this->nombre = $nombre;
            return $this;
        }


        public function getTelefono(){
            return $this->telefono;
        }
        public function setTelefono($telefono): self{
            $this->telefono = $telefono;
            return $this;
        }

        public function getPoblacion(){
            return $this->poblacion;
        }
        public function setPoblacion($poblacion): self{
            $this->poblacion = $poblacion;
            return $this;
        }
    }

?>