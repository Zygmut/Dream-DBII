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
		call linking_receivers(OLD.id_men, OLD.id_usu);
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
    DECLARE followed VARCHAR(9);
    DECLARE cursorReceivers CURSOR FOR SELECT seguidor as idReceptor FROM usu_usu WHERE usu_usu.seguido=idAutor;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET var_final=1;
    OPEN cursorReceivers;
    bucle:LOOP
        FETCH cursorReceivers INTO follower,followed;
        IF var_final = 1 THEN
            LEAVE bucle;
        END IF;
        INSERT INTO receptor(receptor.id_men, receptor.id_usu) VALUES(idMen,follower);
	END LOOP bucle;
	CLOSE cursorReceivers;
END