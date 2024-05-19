# Repositorio de aplicaciones PHP

En este repositorio encntrarás diversas carpetas en donde cada una de ellas contiene una aplicación usando PHP o algun framework del mismo.

## Ambiente de Desarrollo

### Requisitos Previos
Asegúrate de tener instalados los siguientes programas antes de comenzar:

- [PHP for windows](https://windows.php.net/download)
- [PHP for linux](https://www.php.net/downloads.php)
- [MySQL](https://dev.mysql.com/downloads/installer/)
- [Composer](https://getcomposer.org/download/)
- [Visual Studio Code](https://code.visualstudio.com/download/)

Nota: se puede instalar otro gestor de base de datos como mariaDB o Postgresql.

### Instalación de PHP para windows 
1. Descargar la versión deseada
2. Crear una carpeta phpVersión en el disco local C
3. Pegar la carpeta de la versión de PHP descargada en la carpeta phpVersión
4. Abrir las variables de entorno y buscar la variable del path en la sección de "variables del sistema"
5. En la variable path añadir la ruta de la carpeta de la versión de PHP que se eligió
6. Verificar la versión de PHP con el comando `php -v`

### Instalación de Composer para windows
1. Abrir el programa y ejecutarlo como administrador
2. Selecciónar con que versión de PHP deseas instalar Composer
3. verificar la correcta instalación de composer con el comando `composer` en la terminal de comandos 

### Instalación de extensiones para VS code
Algunas exteniones para este ambiente de darrollo son:
- Bootstrap 5 Quick Snippets
- Bootstrap5 Snnipet
- Code runner
- CodeSnap plus
- Database Client JDBS
- Github copilot
- live server
- MySQL
- Path intellisense
- PHP debug
- PHP server
- Theme
- Thunder Client

## Configuraciones
 
### Configuración del archivo php.init
El archivo php init es para configruar el funcionamiento de php donde podrás habilitar o deshabilitar un cierto archivo.

La siguiente lista muestra algunas extensiones para el correcto funcionameinto de php.
1. uno
2. dos
3. tres
4. cuatro
5. cinco
6. seis
7. siete
8. ocho
9. nueve
10. diez

### Configuración de la extensión server PHP
Para que esta extensión pueda funcionar se debe configurar la variable `phpserver.phpConfigPath` para esto se siguen los siguiente pasos:

1. Abrir la configuraciones de VS code (parte interior izquierda)
2. Buscar php server 
3. Localizar la parte phpserver: PHP Config path
4. Agregar el archivo php config por ejemplo `C:\phpVersion\php-7.4.32\php.ini`

## Proyecto
### Creación de un proyecto con composer
Para crear un proyecto con el gestor de depencias de Composer solo vasta con ejecutar el siguiente comando `composer init`

### Estructura de las carpetas