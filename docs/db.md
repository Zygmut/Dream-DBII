# Dream DB II - Database

## Modelo relacional

persona(nombre, apellidos, email, telefono, fechaNacimiento)
usuario(nombreUsuario, contraseña, descripcion, numFollowers, numFollowing, fotoPerfil)
mensaje(contenido, fecha)
historia sacarla como herencia y tener dos tablas extra historia public y historia privada 
Historia(descripcion, fecha, estado??)
Publicacion(contenido, descripcion, numRT, fecha, hora)
Comentario(contenido, fecha)


persona(idPer, nombre, apellidos, telefono, fechaNacimiento) //Mirar si una persona puede tener N cuentas
usuario(idUsu, nombreUsuario, contraseña, mail, descripcion, numFollowers, numFollowing, fotoPerfil) //BNFC
usuario_usuario(idUsu, idUsu)
mensaje(idMen, contenido, fecha, hora)
Historia(idHis, descripcion, fecha, hora, estado??)
Publicacion(idPub, contenido, descripcion, numRT, fecha, hora)
Comentario(idCom, contenido, fecha, hora)

## Sql

Ver [aquí](./../db/BD213.sql)