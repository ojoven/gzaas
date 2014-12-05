<?php
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Gzaas_GzaasController extends Zend_Controller_Action {

	private $_metaTitle;

	function init() {

		$this->_redirector = $this->_helper->getHelper('Redirector');

		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
		$this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper');

		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description.gzaas'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$this->_metaTitle = utf8_encode($translate->translate('meta.title.gzaas'));

		$this->view->headMeta()->setName('description', $metaDescription);
		$this->view->headMeta()->setName('keywords', $metaKeyWords);
	}

	public function newgsAction() {

		$parameters = $this->getRequest()->getPost();
		$gzaasModel = new Gzaas_Model_Gzaas();
		$validParameters = true;
		$gzaasModel->checkValidParameters($parameters,$validParameters,$errorMessage);

		if ($validParameters) {
			$jsonResponse = $gzaasModel->addGzaasAndFeatures($parameters,$jsonResponse);
		} else {
			$jsonResponse = $gzaasModel->constructErrorJsonResponse($errorMessage);
		}

		echo $jsonResponse;

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	}


	public function seegsAction() {

		$urlKey = $this->getRequest()->getParam("urlKey");
		$menu = $this->getRequest()->getParam("menu");
		$screenshot = $this->getRequest()->getParam("screenshot");
		$this->view->screenshot = $screenshot;

		$gzaasModel = new Gzaas_Model_Gzaas();
		$gzaas = $gzaasModel->renderGzaas($urlKey);

		$visitGsModel = new Gzaas_Model_Visitgs();
		$visitGsModel->addVisit($gzaas['message']['id']);

		$this->view->message = $gzaas['message']['message'];
		$this->view->features = $gzaas['features'];
		if ($screenshot && $gzaas['features']['font']['fontServer']=="2") { // Screenshot Google Web Fonts
			$this->view->fontstyles = $this->_retrieveAndParseFontFaceCss($gzaas['features']['font']);
		} else {
			$this->_setFontHeadStylesheetIfFontFaceUsed($gzaas['features']['font']);			
		}
		$this->view->twitterMessage = $gzaas['twitterMessage'];
		$this->view->url = $gzaas['url'];
		$this->view->menu = $menu;
		$this->_setSearchEngineRobotsFromGzaasVisibility($gzaas['message']['visibility']);
		$this->_setFacebookMeta($urlKey);
		$this->_setUserLanguageCode();

		$this->render();
	}

	public function randomexploreAction() {

		$exploreModel = new Gzaas_Model_Explore();
		$randomUrl = $exploreModel->getRandomUrl();

		$this->_redirect($randomUrl);
	}

	// Private methods
	private function _setFontHeadStylesheetIfFontFaceUsed($fontFeatures) {

		if ($fontFeatures['fontFace']==1) {
			$this->view->headLink()->appendStylesheet($fontFeatures['stylesheet']);
		}
	}

	private function _retrieveAndParseFontFaceCss($font) {
		$stylesheet = $font['stylesheet'];
		$pathToStylesheet = 'http:' . $stylesheet;
		$content = file_get_contents($pathToStylesheet);
		$array = explode('src:',$content);
		$aux = explode('),',$array[count($array) - 1]);
		$newstylesheet = $array[0] . 'src:' . $aux[count($aux)-1];		
		return $newstylesheet;
	}

	private function _setSearchEngineRobotsFromGzaasVisibility($gzaasVisibility) {

		switch ($gzaasVisibility) {
			case 0:
				$this->view->headMeta()->setName('robots', 'NOINDEX,NOFOLLOW'); break;
			case 1:
				$this->view->headMeta()->setName('robots', 'INDEX,FOLLOW'); break;
		}
	}

	private function _setFacebookMeta($urlKey) {

		$metaModel = new Gzaas_Model_Meta();
		$facebookMeta = $metaModel->getFacebookMeta($urlKey);
		$this->view->facebook = $facebookMeta;
	}

	private function _setUserLanguageCode() {

		$languageCode = Zend_Registry::get('languageCode');
		$this->view->languageCode = $languageCode;
	}

}
