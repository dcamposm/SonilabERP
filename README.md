Pasos a seguir desrpès de clonar el projecte:

1.- Copiar i el fitxer ".env.example" i enganxar-lo amb el nom ".env".

2.- Amb el cmd anar a la ruta del projecte i executar les comandes:
	composer install
	php artisan key:generate


Fuente: https://stackoverflow.com/questions/38602321/cloning-laravel-project-from-github

-----------------------------------------------------------------------------------------------------------------------

- Para ejecutar comandos de composer desde el instituto hay que ejecutar la siguiente línea:
	set http_proxy=http://proxy.copernic.cat:3128

Ejecutando la línea anterior tendremos habilitado el proxy.

Fuente: https://stackoverflow.com/questions/26780165/install-laravel-behind-proxy

-----------------------------------------------------------------------------------------------------------------------

- Para actualizar las referencias de composer hay que ejecutar "composer install".
- Para realizar la migración de la base de datos hay que:
	1.- Crear la base de datos.
	2.- Ejecutar el comando: php artisan migrate

-----------------------------------------------------------------------------------------------------------------------

UTILIDADES

- bcrypt online: https://www.browserling.com/tools/bcrypt
