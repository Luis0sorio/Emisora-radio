PROCESO DE DISEÑO DEL PROYECTO.

1. La aplicacion carga la ventana de 'LOGIN'
Esta ventana consta de: 
  - Un formulario de inicio de sesion (usuario y contraseña).  un usuario puede iniciar sesion si está registrado previamente (existe en la base de datos). 
  - Un enlace/boton que te permite modificar tu contraseña cargando un nuevo formulario en la misma ventana/o en otra. Se solicita usuario (no modificable (usar js para que el campo quede disable tras escribir)),
   contraseña y nueva contraseña. Boton de aceptar te muestra mensaje si ha sido exitoso o error si el usuario no existe en la base.
  - un enlace que redirecciona a la ventana 'REGISTRO' donde registrarse como nuevo usuario con un formulario.

2. Vista de 'REGISTRO'
Esta ventana contiene: 
  - Un formulario de registro con nombre, usuario, contraseña y confirmacion de contraseña. El boton de confirmacion insertará al usuario en la base de datos.
  - Si la creacion del usuario es correcta, carga la ventana con un mensaje nuevo y no muestra el formulario.
  - Un enlace para volver atrás para poder iniciar sesion ('LOGIN') con tus datos.

3. Vista de 'PERFIL PERSONAL'
Esta ventana contiene:
  - En la parte superior de la ventana, el nombre de usuario que ha iniciado sesión y un boton de cerrar sesión que redirige a 'LOGIN'.
  - Un botón de 'ver grupos musicales'. El botón: 
    + muestra una nueva ventana 'GRUPOS MUSICALES' que muestra, formato tabla, los grupos musicales de la emisora (nombre, origen y genero). Esta vista también tendrá un buscador que filtrará por algun campo existente en la inforamcion del grupo.
    + cada grupo tendrá dos botones: 'añadir' y 'eventos'.
    + El botón 'eventos' muestra una lista de los conciertos programados de ese grupo en su gira-concierto.
    + El boton 'añadir' añadirá el grupo a la vista 'PERFIL PERSONAL', con un formato tabla de los conciertos programados para ese grupo. Además de ampliar la finformacion con los datos de sus componentes.

Estas funcionalidades son propias para un usuario normal (no-admin). 

Si te registras como admin:
- Se abre una ventana completamente nueva 'PERFIL-ADMIN' donde el admin podrá
  + borrar usuarios
  + borrar grupos, y por ende sus eventos/conciertos
  + añadir un nuevo usuario administrador. 