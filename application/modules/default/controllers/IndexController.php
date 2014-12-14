<?php
require_once "My/Gzaas_Base_Controller.php";

class IndexController extends Gzaas_Base_Controller {

	public function init() {

		parent::init();

	}

	public function indexAction() {

		$this->view->headTitle(__("Gzaas!") . " | " . __("My full screen messages"),'SET');
		$languageCode = Zend_Registry::get('languageCode');
		$this->view->languageCode = $languageCode;
	}

}
