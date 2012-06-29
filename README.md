<b>ZendAdmin</b>

Zend_Admin is built on Zend Framework and provides an easy-to-use interface for managing your data.


<b>INSTALLATION</b>

In Zend_Admin/application/config/application.ini set your database details

In application/views/scripts/index/

index.phtml
sidebar.phtml

Please change the Tables_in_mystore in $res[$i]['Tables_in_mystore'] to Tables_in_(Your database name)


<b>REQUIREMENTS</b>

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


<b>WHAT THIS APPLICATION CONSISTS </b>

Contrellers<br/>
Models<br/>
Views<br/>

<b>SCREENSHOTS</b>

 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend_Admin/raw/master/screenshots/zendadmin1.jpg" alt="Zend-admin" title="Zend-admin">
 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend_Admin/raw/master/screenshots/zendadmin2.jpg" alt="Zend-admin" title="Zend-admin">
 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend_Admin/raw/master/screenshots/zendadmin.jpg" alt="Zend-admin" title="Zend-admin">
 <img style="max-width:100%;" src="https://github.com/fathima-nyros/Zend_Admin/raw/master/screenshots/zendadmin3.jpg" alt="Zend-admin" title="Zend-admin">
