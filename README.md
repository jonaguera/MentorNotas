MentorNotas
===========

Aplicación desarrollada durante el estudio del curso Symfon2 de Aula Mentor

Instalacion
-----------
* git clone https://github.com/jonaguera/MentorNotas.git
* wget https://raw.github.com/symfony/symfony-standard/v2.0.9/app/config/parameters.ini -O ./MentorNotas/app/config/parameters.ini
* cd MentorNotas
* php bin/vendors install
* Cambiar permisos ACL de cache y logs
sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
* php app/console cache:clear
* (si no se tiene ACL, chmod -R 777 app/cache app/logs). Descripción de uso de ACL en http://symfony.com/doc/current/book/installation.html
* php app/console assets:install web
