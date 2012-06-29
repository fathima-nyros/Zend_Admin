<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Application.php';
require_once 'Zend/Config/Ini.php';
require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

//db config and connect
$params = array(
'host' => $config->resources->db->params->host,
'username' => $config->resources->db->params->username,
'password' => $config->resources->db->params->password,
'dbname' => $config->resources->db->params->dbname
); 

//Connecting to db using zend_db 

try {
   $db = Zend_Registry::set('db',Zend_Db::factory($config->resources->db->adapter, $params));
       Zend_Db_Table::setDefaultAdapter($db);
   //$db->getConnection();
} catch (Zend_Db_Adapter_Exception $e) {
   // perhaps a failed login credential, or perhaps the RDBMS is not running
       echo 'Zend_Db_Adapter_Exception Message: ' .$e->getMessage();
} catch (Zend_Exception $e) {
   // perhaps factory() failed to load the specified Adapter class
       echo 'Zend_Exception Message: ' .$e->getMessage();
}
$application->bootstrap()
            ->run();