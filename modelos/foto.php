<?php 
    class Foto {
        private $id;
        private $idAnuncio;
        private $ruta_foto;
        private $foto_principal;

    // Métodos para acceder a los atributos
        public function getId(){
            return $this->id;
        }
        public function setId($id): self{
            $this->id = $id;
            return $this;
        }

        public function getIdAnuncio(){
            return $this->idAnuncio;
        }
        public function setIdAnuncio($idAnuncio): self{
            $this->idAnuncio = $idAnuncio;
            return $this;
        }

        public function getRutaFoto(){
            return $this->ruta_foto;
        }
        public function setRutaFoto($ruta_foto): self{
            $this->ruta_foto = $ruta_foto;
            return $this;
        }

        public function getFotoPrincipal(){
            return $this->foto_principal;
        }
        public function setFotoPrincipal($foto_principal): self{
            $this->foto_principal = $foto_principal;
            return $this;
        }
    }

?>