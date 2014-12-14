<?php
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Gzaas_Base_Controller extends Zend_Controller_Action {

	protected $translator;

	function init() {

		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
		$this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper');

		$translate = Zend_Registry::get('Zend_Translate');
		$this->translator = $translate;

		$uri = Zend_Controller_Front::getInstance()->getRequest()->getParams();
		$this->view->action = $uri['action'];

		$this->view->headTitle(__("Gzaas!"));
	}

}