<?php
require_once "My/Gzaas_Base_Controller.php";

class ErrorController extends Gzaas_Base_Controller {

	public function init() {

		parent::init();
	}

	public function indexAction() {

		$this->_redirect('error/error');
	}


	public function errorAction() {

		$errors = $this->_getParam('error_handler');
		$baseUrl = $this->_request->getBaseUrl();
		echo $baseUrl;

		switch ($errors->type) {
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

				// 404 error -- controller or action not found
				$this->_redirect($baseUrl.'/'.ERROR_KEY);
				break;
			default:
				// application error
				$this->_redirect($baseUrl.'/'.ERROR_KEY);
				break;
		}

	}

}


