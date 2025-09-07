CREATE DATABASE IF NOT EXISTS biblioteca;
USE biblioteca;

-- CATEGORIAS
CREATE TABLE categorias (
  idcategoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

INSERT INTO categorias (nombre) VALUES
('Matemáticas'),
('Comunicación'),
('Computación');

-- SUBCATEGORIAS
CREATE TABLE subcategorias (
  idsubcategoria INT AUTO_INCREMENT PRIMARY KEY,
  idcategoria INT NOT NULL,
  nombre VARCHAR(150) NOT NULL,
  FOREIGN KEY (idcategoria) REFERENCES categorias(idcategoria)
);

INSERT INTO subcategorias (idcategoria, nombre) VALUES
(1, 'Razonamiento Lógico Matemático'),
(1, 'Álgebra'),
(1, 'Trigonometría'),
(2, 'Razonamiento verbal'),
(2, 'Composición'),
(2, 'Redacción'),
(3, 'Base de datos'),
(3, 'Sistemas operativos'),
(3, 'Lenguajes de programación');

-- EDITORIALES
CREATE TABLE editoriales (
  ideditorial INT AUTO_INCREMENT PRIMARY KEY,
  empresa VARCHAR(150) NOT NULL,
  nacionalidad VARCHAR(100) NOT NULL
);

INSERT INTO editoriales (empresa, nacionalidad) VALUES
('Santillana', 'España'),
('Norma', 'Colombia'),
('McGraw Hill', 'USA');

-- RECURSOS
CREATE TABLE recursos (
  idrecurso INT AUTO_INCREMENT PRIMARY KEY,
  idsubcategoria INT NOT NULL,
  ideditorial INT NOT NULL,
  tipo ENUM('FISICO','DIGITAL') NOT NULL,
  titulo VARCHAR(200) NOT NULL,
  apublicacion YEAR,
  isbn VARCHAR(20),
  numpaginas INT,
  rutaportada VARCHAR(200),
  rutarecurso VARCHAR(200),
  estado ENUM('BUENO','REGULAR','MALO'),
  creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  modificado TIMESTAMP NULL,
  FOREIGN KEY (idsubcategoria) REFERENCES subcategorias(idsubcategoria),
  FOREIGN KEY (ideditorial) REFERENCES editoriales(ideditorial)
);