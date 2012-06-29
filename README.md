/*****************************************        Zend ADMIN APP                  ***************************************************/


ABOUT APPLICATION: ZEND ADMIN

Zend admin is a generic database solution, To Manage a database with the options as (Add, Edit, Delete, Export, Seach, history )


INSTALLATION

In Zend_Admin/application/config/application.ini set your database details

In application/views/scripts/index/

index.phtml
sidebar.phtml

Please change the Tables_in_mystore in $res[$i]['Tables_in_mystore'] to Tables_in_(Your database name)


REQUIREMENTS

You must have PHP 5.0 or greater installed

Mysql - 3.4.5

Zend version - 1.11

And you must set virtual host to set the paths

Setting Virtual host 

In your apache/config/httpd.conf file place the below lines

 <VirtualHost *:80>
   ServerName Zend Admin App
   DocumentRoot "your path to the zend_admin/public"     (Ex: C:/xampp/htdocs/zend_admin/public/)
   <Directory "your path to the zend_admin/public" >
   </Directory>
</VirtualHost>


WHAT THIS APPLICATION CONSISTS 

Contrellers
Models
Views

SCREENSHOTS

 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend-admin/raw/master/screenshots/zendadmin1.jpg" alt="Zend-admin" title="Zend-admin">
 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend-admin/raw/master/screenshots/zendadmin2.jpg" alt="Zend-admin" title="Zend-admin">
 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend-admin/raw/master/screenshots/zendadmin.jpg" alt="Zend-admin" title="Zend-admin">
 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend-admin/raw/master/screenshots/zendadmin3.jpg" alt="Zend-admin" title="Zend-admin">
