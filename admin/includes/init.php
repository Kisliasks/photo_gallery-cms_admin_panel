<?php 

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
// defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'Users' . DS . 'admin' . DS . '.bitnami' . DS . 'stackman' . DS . 'machines' . DS . 'xampp' . DS . 'volumes' . DS . 'root' . DS . 'htdocs' . DS . 'PHP-course' . DS . 'Edwin-OOP' . DS . 'mygallery');
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'opt' . DS . 'lampp' . DS . 'htdocs' . DS . 'PHP-course' . DS . 'Edwin-OOP' . DS . 'mygallery');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');

require_once('new_config.php');
require_once('database.php');
require_once('db_object.php');
require_once('photo.php');
require_once('user.php');
require_once('paginate.php');

require_once "functions.php";
require_once "session.php";



?>