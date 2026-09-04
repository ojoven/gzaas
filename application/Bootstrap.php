<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initSecurityHeaders()
	{
		if (headers_sent()) {
			return;
		}

		header('X-Content-Type-Options: nosniff');
		header('X-Frame-Options: SAMEORIGIN');
		header('Referrer-Policy: strict-origin-when-cross-origin');
		header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
		if (APPLICATION_ENV !== 'development') {
			header("Content-Security-Policy: default-src 'self'; base-uri 'self'; object-src 'none'; frame-ancestors 'self'; form-action 'self'; script-src 'self' 'unsafe-inline' https://ssl.google-analytics.com https://www.google-analytics.com https://platform.twitter.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' data: https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://www.google-analytics.com; frame-src 'self' https://www.facebook.com; upgrade-insecure-requests");
		}

		$isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
			|| (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);
		if ($isHttps) {
			header('Strict-Transport-Security: max-age=31536000');
		}
	}

	protected function _initAutoloader()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default',
            'basePath' => APPLICATION_PATH. '/modules/default'));
        return $autoloader;
    }

    protected function _initAutoloaderGzaas() {
    	$autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Gzaas',
            'basePath' => APPLICATION_PATH . '/modules/gzaas'));
        return $autoloader;
    }

    protected function _initAutoloaderApi() {
    	$autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Api',
            'basePath' => APPLICATION_PATH . '/modules/api'));
        return $autoloader;
    }

	protected function _initCustomAutoloader()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('My_');
	}

	protected function _initTranslate() {

		// To use a global __() function to make the translations.
		require_once LIBRARY_PATH . '/My/global.php';

		$languageCode = 'en';
		$translate = new Zend_Translate(
			'gettext', APPLICATION_PATH .'/langs/'.$languageCode.'.mo', $languageCode,
			array(
			'disableNotices' => true,
			'clear' =>true,
			'reload'=>true,
			)
		);
		Zend_Registry::set('Zend_Translate', $translate);
		Zend_Registry::set('languageCode',$languageCode);
    }


	/** Initializes Messages and Web Config **/

	protected function _initMessages() {

		//web config
		$config = new Zend_Config_Ini(
			APPLICATION_PATH . '/configs/application.ini',
			APPLICATION_ENV
		);

		//save to registry
		$registry = Zend_Registry::getInstance();
		$registry->set('config', $config);
		unset($config);
	}

	protected function _initLogging() {

		$writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/logs/gzaas.log');
		$logger = new Zend_Log($writer);

		//save to registry
		$registry = Zend_Registry::getInstance();
		$registry->set('logger', $logger);
		unset($logger);
	}


	protected function _initSession() {

		$gzaasNamespace = new Zend_Session_Namespace('Gzaas');

		if (!isset($gzaasNamespace->stop)) {
			$gzaasNamespace->stop=mt_rand(4,12);
		}

	}

	protected function _initPlugins() {

		$this->bootstrap('frontController');

		$layoutPlugin = new My_Layout();
		$this->frontController->registerPlugin($layoutPlugin);

		$auth = Zend_Auth::getInstance();
		$authorizationPlugin = new My_AuthorizationPlugin($auth);
		$this->frontController->registerPlugin($authorizationPlugin);

	}

	protected function _initDatabase() {

		$resource = $this->getPluginResource('db');
		$db = $resource->getDbAdapter();
		Zend_Db_Table::setDefaultAdapter($db);
		Zend_Registry::set('db', $db);
    }

    /** Initialized MVC and Layouts **/

	protected function _initPresentation() {

		$view = new Zend_View();
        $view->setEncoding('utf-8');

        $router = new My_Routers();
        $view->router = $router;
        $view->imgPath = PUBLIC_WEB_PATH . "/images/";

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
        return $view;
	}

}
