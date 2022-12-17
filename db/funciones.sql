-- Procedure backup

DELIMITER //

CREATE PROCEDURE BACKUP() BEGIN 
	START TRANSACTION;
	DECLARE cursor CURSOR FOR CREATE DATABASE {bd213_fecha};
	CREATE TABLE ... 
    INSERT ... 
END; 

-- Evento backup

CREATE EVENT
    copia_seguridad ON SCHEDULE EVERY '1' DAY STARTS '2022-12-11 00:00:00'
DO
CALL backup();

-- Trigger Historia -> Notificaciones (Cuando se crea una historia, se crea un mensaje con su)
-- Crear Mensaje(Notificación).
-- Crear Enlaces (Receptores).

--Pazblo
DELIMITER //
CREATE
	TRIGGER new_history AFTER INSERT ON mensaje
	FOR EACH ROW
	BEGIN
		--le pasamos al procedure el id del nuevo mensaje creado y del autor
		call linking_receivers(NEW.id_men, NEW.id_usu);
	END
--hecho por Pazblo - el UwU Master :3 quita tus sucias manos de maricón de mi procedure, !!!!!no quiero onichan en mi vida!!!!!
//DELIMITER
CREATE PROCEDURE linking_receivers(IN idMen, IN idAutor)
BEGIN
	DECLARE var_final INTEGER DEFAULT 0;
	DECLARE follower VARCHAR(9);
	DECLARE followed VARCHAR(9);
	DECLARE cursorReceivers CURSOR FOR SELECT seguidor as idReceptor FROM usu_usu WHERE usu_usu.seguido=idAutor;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final=1;
	OPEN cursorReceivers;
	bucle:LOOP
		FETCH cursorReceivers INTO follower,followed;
		IF var_final = 1 THEN
			LEAVE bucle;
		END IF;
		INSERT INTO receptor VALUES(follower,followed)
END



DELIMITER //
CREATE PROCEDURE linking_receivers(IN idMen BIGINT, IN idAutor BIGINT)
BEGIN
    DECLARE var_final INTEGER DEFAULT 0;
    DECLARE follower VARCHAR(9);
    DECLARE cursorReceivers CURSOR FOR SELECT seguidor as idReceptor FROM usu_usu WHERE usu_usu.seguido=idAutor;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final=1;
    OPEN cursorReceivers;
    bucle:LOOP
        FETCH cursorReceivers INTO follower;
        IF var_final = 1 THEN
            LEAVE bucle;
        END IF;
        INSERT INTO notificacion VALUES(idMen,follower, 'no leido');
	END LOOP bucle;
	CLOSE cursorReceivers;
END

DELIMITER //
CREATE PROCEDURE create_test_data()
BEGIN
START TRANSACTION;
CREATE DATABASE testbd213;
USE testbd213;
CREATE TABLE PERSONA(
        dni VARCHAR(9), 
        nom_per VARCHAR(255) NOT NULL,
        apellidos VARCHAR(255) NOT NULL,
        telf VARCHAR(255) NOT NULL,
        nacimiento DATETIME NOT NULL,
        PRIMARY KEY(DNI)
);

CREATE TABLE USUARIO(
        id_usu VARCHAR(9),
        pass VARCHAR(255) NOT NULL,
        description TINYTEXT NOT NULL,
        seguidores BIGINT,
        seguidos BIGINT,
        foto_perfil BLOB,
        PRIMARY KEY(id_usu),
        FOREIGN KEY (id_usu) REFERENCES PERSONA(dni) 
);

CREATE TABLE INFO_USU(
        id_usu VARCHAR(9),
        nom_usu VARCHAR(255) NOT NULL,
        mail VARCHAR(255) NOT NULL,
        PRIMARY KEY (id_usu),
        FOREIGN KEY (id_usu) REFERENCES USUARIO(id_usu) 
);

CREATE TABLE USU_USU(
        seguidor VARCHAR(9),
        seguido VARCHAR(9),
        PRIMARY KEY (
            seguidor,
            seguido
        ),
        FOREIGN KEY (seguidor) REFERENCES USUARIO(id_usu),
        FOREIGN KEY (seguido) REFERENCES USUARIO(id_usu)
);

CREATE TABLE MENSAJE(
        id_men BIGINT AUTO_INCREMENT,
        id_usu VARCHAR(9),
        cont_men TINYTEXT NOT NULL,
        fecha_men DATETIME,
        PRIMARY KEY (id_men),
        FOREIGN KEY (id_usu) REFERENCES USUARIO(id_usu)
);

CREATE TABLE NOTIFICACION(
        id_men BIGINT,
        id_usu VARCHAR(9),
        estado_not ENUM('no leido', 'leido'),
        PRIMARY KEY (id_men, id_usu),
        FOREIGN KEY (id_usu) REFERENCES USUARIO(id_usu),
        FOREIGN KEY (id_men) REFERENCES MENSAJE(id_men)
);

CREATE TABLE HISTORIA (
        id_his BIGINT  AUTO_INCREMENT,
        id_usu VARCHAR(9),
        desc_his TINYTEXT NOT NULL,
        fecha_his DATETIME,
        estado_his ENUM('publica', 'privada'),
        cont_his LONGBLOB,
        PRIMARY KEY (id_his),
        FOREIGN KEY (id_usu) REFERENCES USUARIO(id_usu)
);

CREATE TABLE PUBLICACION (
        id_pub BIGINT AUTO_INCREMENT,
        autor VARCHAR(9),
        desc_pub TINYTEXT NOT NULL,
        cont_pub LONGBLOB,
        fecha_pub DATETIME,
        PRIMARY KEY (id_pub),
        FOREIGN KEY (autor) REFERENCES USUARIO(id_usu)
);

CREATE TABLE CONTENIDO (
        id_his BIGINT,
        id_pub BIGINT,
        PRIMARY KEY (id_his, id_pub),
        FOREIGN KEY (id_his) REFERENCES HISTORIA(id_his),
        FOREIGN KEY (id_pub) REFERENCES PUBLICACION(id_pub)
);

CREATE TABLE RT (
        id_pub BIGINT,
        id_usu VARCHAR(9),
        PRIMARY KEY (id_pub, id_usu),
        FOREIGN KEY (id_pub) REFERENCES PUBLICACION(id_pub),
        FOREIGN KEY (id_usu) REFERENCES USUARIO(id_usu)
);

CREATE TABLE COMENTARIO (
        id_com BIGINT AUTO_INCREMENT,
        id_pub BIGINT,
        id_usu VARCHAR(9),
        cont_com TINYTEXT NOT NULL,
        fecha_com DATETIME,
        PRIMARY KEY (id_com),
        FOREIGN KEY (id_pub) REFERENCES PUBLICACION(id_pub),
        FOREIGN KEY (id_usu) REFERENCES USUARIO(id_usu)
);


DELIMITER //
CREATE PROCEDURE copia_seguridad()
BEGIN
        START TRANSACTION;
    
    DROP DATABASE IF EXISTS bd213_copia;
    CREATE DATABASE IF NOT EXISTS bd213_copia;
    
    CREATE TABLE bd213_copia.persona LIKE bd213.persona;
    CREATE TABLE bd213_copia.usuario LIKE bd213.usuario;
    CREATE TABLE bd213_copia.info_usu LIKE bd213.info_usu;
    CREATE TABLE bd213_copia.usu_usu LIKE bd213.usu_usu;
    CREATE TABLE bd213_copia.mensaje LIKE bd213.mensaje;
    CREATE TABLE bd213_copia.notificacion LIKE bd213.notificacion;
    CREATE TABLE bd213_copia.historia LIKE bd213.historia;
    CREATE TABLE bd213_copia.publicacion LIKE bd213.publicacion;
    CREATE TABLE bd213_copia.contenido LIKE bd213.contenido;
    CREATE TABLE bd213_copia.rt LIKE bd213.rt;
    CREATE TABLE bd213_copia.comentario LIKE bd213.comentario;
    
    INSERT INTO bd213_copia.persona SELECT * FROM bd213.persona;
    INSERT INTO bd213_copia.usuario SELECT * FROM bd213.usuario;
    INSERT INTO bd213_copia.info_usu SELECT * FROM bd213.info_usu;
    INSERT INTO bd213_copia.usu_usu SELECT * FROM bd213.usu_usu;
    INSERT INTO bd213_copia.mensaje SELECT * FROM bd213.mensaje;
    INSERT INTO bd213_copia.notificacion SELECT * FROM bd213.notificacion;
    INSERT INTO bd213_copia.historia SELECT * FROM bd213.historia;
   	INSERT INTO bd213_copia.publicacion SELECT * FROM bd213.publicacion;
    INSERT INTO bd213_copia.contenido SELECT * FROM bd213.contenido;
    INSERT INTO bd213_copia.rt SELECT * FROM bd213.rt;
    INSERT INTO bd213_copia.comentario SELECT * FROM bd213.comentario;
    
    COMMIT;
END;
//

BEGIN
    DECLARE var_final INTEGER DEFAULT 0;
    DECLARE follower VARCHAR(9);
    DECLARE cursorReceivers CURSOR FOR SELECT seguidor as idReceptor FROM usu_usu WHERE usu_usu.seguido=idAutor;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final=1;
    OPEN cursorReceivers;
    bucle:LOOP
        FETCH cursorReceivers INTO follower;
        IF var_final = 1 THEN
            LEAVE bucle;
        END IF;
        INSERT INTO notificacion VALUES(idMen,follower, 'no leido');
	END LOOP bucle;
	CLOSE cursorReceivers;
END

DELIMITER //
CREATE PROCEDURE linking_receivers()
BEGIN
    DECLARE var_final INTEGER DEFAULT 0;
    DECLARE follower VARCHAR(9);
    DECLARE cursorReceivers CURSOR FOR SELECT seguidor as idReceptor FROM usu_usu WHERE usu_usu.seguido=idAutor;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final=1;

    
    START TRANSACTION;
    OPEN cursorReceivers;
    bucle:LOOP
        FETCH cursorReceivers INTO follower;
        IF var_final = 1 THEN
            LEAVE bucle;
        END IF;
        INSERT INTO notificacion VALUES(idMen,follower, 'no leido');
	END LOOP bucle;
	CLOSE cursorReceivers;
    COMMIT;
	
END;
//
SET GLOBAL event_scheduler="ON"

CREATE EVENT
    copia_seguridad ON SCHEDULE EVERY '1' DAY STARTS '2022-12-11 00:00:00'
DO
    CALL copia_seguridad();
END;