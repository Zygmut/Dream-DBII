-- SQLBook: Code
CREATE DATABASE IF NOT EXISTS BD213;

USE DB213;

CREATE TABLE persona(
    idPersona BIGINT PRIMARY KEY AUTO_INCREMENT,
    apellidos VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    telef VARCHAR(255) NOT NULL,
    fechaNacimiento DATETIME
);

CREATE TABLE usuario(
    idUsuario BIGINT PRIMARY KEY AUTO_INCREMENT,
    contrasena VARCHAR(255) NOT NULL,
    descripcion SMALLTEXT NOT NULL,
    numSeguidores BIGINT,
    numSeguidos BIGINT,
    fotoPerfil BLOB
);

CREATE TABLE info_usuario(
    idUsuario BIGINT,
    nombreUsuario VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE usuario_usario(
    idUsuarioSeguido BIGINT,
    IdUsuarioSeguidor BIGINT,
    FOREIGN KEY (idUsuarioSeguido) REFERENCES usuario(idUsuario),
    FOREIGN KEY (idUsuarioSeguidor) REFERENCES usuario(idUsuario)
);

CREATE TABLE mensaje(
    idMensaje BIGINT PRIMARY KEY AUTO_INCREMENT,
    idUsuario BIGINT,
    contenido SMALLTEXT NOT NULL,
    fecha DATETIME,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE historia(
    idHistoria BIGINT PRIMARY KEY AUTO_INCREMENT,
    idUsuario BIGINT,
    descripcion SMALLTEXT NOT NULL,
    fecha DATETIME,
    estado ENUM('publica', 'privada'),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE publicacion(
    idPublicacion BIGINT PRIMARY KEY AUTO_INCREMENT,
    idUsuarioAutor BIGINT,
    descripcion SMALLTEXT NOT NULL,
    contenido BLOB,
    fecha DATETIME,
    FOREIGN KEY (idUsuarioAutor) REFERENCES usuario(idUsuario)
);

CREATE TABLE historia_publicacion(
    idHistoria BIGINT,
    idPublicacion BIGINT,
    FOREIGN KEY (idHistoria) REFERENCES historia(idHistoria),
    FOREIGN KEY (idPublicacion) REFERENCES publicacion(idPublicacion)
);

CREATE TABLE usuario_publicacion_rt(
    idUsuario BIGINT,
    idPublicacion BIGINT,
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY (idPublicacion) REFERENCES publicacion(idPublicacion)
);

CREATE TABLE comentario(
    idComentario BIGINT PRIMARY KEY AUTO_INCREMENT,
    idPublicacion BIGINT,
    idUsuario BIGINT,
    contenido SMALLTEXT NOT NULL,
    fecha DATETIME,
    FOREIGN KEY (idPublicacion) REFERENCES publicacion(idPublicacion),
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario)
);
