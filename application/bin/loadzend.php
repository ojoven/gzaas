<?php
define('PUBLIC_WEB_PATH', substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')));
define('INDEX_PATH', str_replace('\\', '/', dirname(__FILE__)));
define('APPLICATION_PATH', str_replace('\\', '/', realpath(INDEX_PATH . '/../../application')));
define('CONFIGS_PATH', str_replace('\\', '/', realpath(INDEX_PATH . '/../../application/configs')));
define('LIBRARY_PATH', str_replace('\\', '/', realpath(INDEX_PATH . '/../../library')));
set_include_path(
		LIBRARY_PATH
		. PATH_SEPARATOR
		. get_include_path()
);

date_default_timezone_set('Europe/Madrid');

/**
 * Define application environmentt
 */
if( !defined('APPLICATION_ENV') ) {
	define('APPLICATION_ENV', 'production');
}

/** Zend_Application */
require_once 'Zend/Application.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
		APPLICATION_ENV,
		CONFIGS_PATH . '/application.ini'
);
$application->bootstrap();