# plantilla-php
 Caja de herramientas de PHP lista para comenzar a programar


## Modo de uso:

### Clonar proyecto

Clona el proyecto o usa Composer para crear un proyecto. Así:

`composer create-project parzibyte/framework-php nombre_de_tu_proyecto`


En mi caso hice lo siguiente:

`composer create-project parzibyte/framework-php acortadores-paste-php`


### Configurar env

Ahora abre la carpeta y luego la carpeta /app, ahí crea un archivo llamado *env.php*, copia y pega lo que hay en *env.ejemplo.php*, cambia las credenciales y sobre todo la URL_BASE (que en mi caso con el proyecto que acabo de crear es http://localhost/acortadores-paste-php/) y listo, ahora visita la web y debería estar funcionando sin mayor complicaciones

### El esquema de la base de datos
En la carpeta app vas a encontrar un archivo llamado esquema.sql, impórtalo o pega su contenido en tu base de datos que configuraste previamente

Más información:
https://parzibyte.me/blog/2019/07/29/mi-caja-herramientas-php/

Paquete en packagist: https://packagist.org/packages/parzibyte/framework-php
