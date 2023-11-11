-- Tabla de Usuarios
CREATE TABLE Usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  nombre VARCHAR(255),
  telefono VARCHAR(20),
  poblacion VARCHAR(255)
);

-- Tabla de Anuncios
CREATE TABLE Anuncios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  precio DECIMAL(10, 2),
  foto_principal VARCHAR(255),
  FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

-- Tabla de Fotos de Anuncios
CREATE TABLE FotosAnuncios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  anuncio_id INT,
  ruta_foto VARCHAR(255),
  foto_principal BOOLEAN,
  FOREIGN KEY (anuncio_id) REFERENCES Anuncios(id)
);