# Routes

## Users

```bash
{user}/ # GET perfil de usuario (nombre usuario)
{user}/edit # POST editar perfil de usuario (nombre usuario, datos personales)
{user}/update # POST actualizar perfil de usuario (nombre usuario, datos personales)
{user}/delete # POST eliminar perfil de usuario (nombre usuario)
{user}/inbox # GET mensajes recibidos de usuario (nombre usuario)
# --- Creo que no hace falta --- #
{user}/inbox/send # POST enviar mensaje a usuario (nombre usuario, nombre usuario destino, texto)
{user}/inbox/delete # POST eliminar mensaje de usuario (nombre usuario, id mensaje)
# ------------------------------ #
{user}/followers # GET seguidores usuario (nombre usuario)
{user}/following # GET seguidos por el usuario (nombre usuario)
{user}/follow # POST seguir usuario (nombre usuario, nombre usuario a seguir)
{user}/unfollow # POST dejar de seguir usuario (nombre usuario, nombre usuario a dejar de seguir)
{user}/publications # GET publicaciones de usuario (nombre usuario)
{user}/publications/following # GET publicaciones de usuarios seguidos por el usuario (nombre usuario)
{user}/publications/create # POST crear publicación (nombre usuario, texto)
{user}/publications/delete # POST eliminar publicación (nombre usuario, id publicación)
{user}/publications/share/{id} # POST compartir publicación (nombre usuario, id publicación)
{user}/publications/comments # GET comentarios de publicación (id publicación)
{user}/publications/comments/create # POST crear comentario (id publicación, nombre usuario, texto)
{user}/publications/comments/delete/{id} # POST eliminar comentario (id comentario)
{user}/publications/stories # GET historias de usuario (nombre usuario)
{user}/publications/stories/create # POST crear historia (nombre usuario, texto)
{user}/publications/stories/delete/{id} # POST eliminar historia (nombre usuario, id historia)
```

## Social Media (App)

```bash
login/ # POST login usuario (nombre usuario, contraseña y datos personales)
register/ # POST registro usuario (nombre usuario y contraseña)
```
