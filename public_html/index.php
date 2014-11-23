<?php
/*
* Define the necessary constants to be used in the system
* Then set the library path
*
* For production release, set the include path in php.ini
* instead of setting it dynamically
*/
define('PUBLIC_WEB_PATH', substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')));
define('INDEX_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('APPLICATION_PATH', str_replace('\\', '/', realpath(INDEX_PATH . '/../application')));
define('LIBRARY_PATH', str_replace('\\', '/', realpath(INDEX_PATH . '/../library')));
set_include_path(
		LIBRARY_PATH
		. PATH_SEPARATOR
		. get_include_path()
	);

define('URL_BASE', 'http://gzaas.local.host/');

define('DEFAULT_LANGUAGE_CODE', 'ES');
define('RANDOM_GZAAS_NUM_BASE', 5);
define('ERROR_KEY', "error");
define('GZAAS_MAX_SIZE', 1024);
define('LAUNCHER_MAX_SIZE', 115);
define('GZAAS_MAX_NEW_LINES', 30);
define('MAX_HOR_VER_SHADOW', 6);
define('MAX_BLUR_SHADOW', 6);

define('HEX_REGEXP', "/([A-F|a-f|0-9]){3}(([A-F|a-f|0-9]){3})?/");
define('HEX_WITH_HASH_REGEXP', "/#([A-F|a-f|0-9]){3}(([A-F|a-f|0-9]){3})?/");
define('HOR_VER_SHAD_REGEXP', "/-?\d{1,2}(px)?/");
define('BLUR_SHAD_REGEXP', "/\d{1,2}(px)?/");

define('URL_WTF_EN', "http://localhost/gzaasproject/about/wtf-is-gzaas");
define('URL_COM_EN', "http://localhost/gzaasproject/about/the-community/");
define('URL_WTF_ES', "http://localhost/gzaasproject/es/sobre-gzaas/que-es-gzaas/");
define('URL_COM_ES', "http://localhost/gzaasproject/es/sobre-gzaas/la-comunidad/");

date_default_timezone_set('Europe/Madrid');
/**
* Salt for general hashing (security)
*/
define('GENERIC_SALT', 'definehereyourowngenericsalt');
/**
* Define application environment
*/
if( !defined('APPLICATION_ENV') ) {
	define('APPLICATION_ENV', 'development');
}
/** Zend_Application */
require_once 'Zend/Application.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
		APPLICATION_ENV,
		APPLICATION_PATH . '/configs/application.ini'
		);
$application->bootstrap()->run();

