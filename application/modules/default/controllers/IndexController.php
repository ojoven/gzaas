<?php
require_once 'Zend/Cache.php';

class IndexController extends Zend_Controller_Action {

	public function init() {

		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
		$this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper');

		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$metaTitle = utf8_encode($translate->translate('meta.title'));

		$this->view->headMeta()->setName('description', $metaDescription);
		$this->view->headMeta()->setName('keywords', $metaKeyWords);
		$this->view->headTitle()->append($metaTitle);
	}

	public function indexAction() {

		$this->view->titulo = "gzaas!";
		$languageCode = Zend_Registry::get('languageCode');
		$this->view->languageCode = $languageCode;
	}

}
