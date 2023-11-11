# Prototipo sistema monitoreo practicas
Código de sistema para monitorear prácticas (Prototipo)

En esta versión de prototipo, se presentan las siguientes funcionalidades:
·	Login (Mantiene sesión)

·	Alumno:

o	Subir archivos. (Formatos definidos: pdf, xlsx, txt. Si la carpeta del alumno no existe, se crea. Si se repite el nombre de un archivo, se agrega un contador al nombre).

o	Ver archivos. (Se muestran los archivos del alumno que inicia sesión).

o	Ver comentarios realizados por Docente. (Muestra el o los comentarios realizados por Docente).

·	Docente:

o	Ver alumnos asignados. (Se muestran los alumnos asignados al docente que inicia sesión).

o	Ver archivos de alumnos asignados. (Se muestra un listado de los archivos subidos por cada alumno asignado al Docente).

o	Realizar comentarios. (Campo de texto para realizar comentarios al archivo previamente seleccionado).

·	Coordinador:

o	Agregar Alumno. (Se agrega a la base de datos a la tabla Alumno_1, y los datos necesarios a la tabla Usuarios. Por defecto se les asigna su rol correspondiente, y la 
contraseña queda definida con la estructura a[rut]).

o	Agregar Docente. (Se agrega a la base de datos a la tabla docente, y los datos necesarios a la tabla Usuarios. Por defecto se les asigna su rol correspondiente, y la 
contraseña queda definida con la estructura d[rut]).

o	Asignar Docente a Alumno. (Se agrega la relación entre Docente y Alumno en la tabla asignacion_guia).

o	Listar, Editar Alumnos y Docentes. (Se muestran tablas con los datos de las tablas Alumno_1 y docente. Estas mismas tablas son las que se editan. Pendiente la función 
de Eliminar).
