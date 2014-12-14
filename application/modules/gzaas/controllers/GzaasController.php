<?php
require_once "My/Gzaas_Base_Controller.php";

class Gzaas_GzaasController extends Gzaas_Base_Controller {

	function init() {

		parent::init();

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
		if ($screenshot && isset($gzaas['features']['font']['fontServer']) &&  $gzaas['features']['font']['fontServer']=="2") { // Screenshot Google Web Fonts
			My_Functions::log('screenshot: ' . json_encode($gzaas['features']['font']));
			$this->view->fontstyles = $this->_retrieveAndParseFontFaceCss($gzaas['features']['font']);
		} else {
			$this->_setFontHeadStylesheetIfFontFaceUsed($gzaas['features']['font']);
		}
		$this->view->twitterMessage = $gzaas['twitterMessage'];
		$this->view->urlKey = $urlKey;
		$this->view->menu = $menu;
		$this->_setSearchEngineRobotsFromGzaasVisibility($gzaas['message']['visibility']);
		$this->_setFacebookMeta($gzaas);
		$this->_setTwitterMeta($gzaas);
		$this->_setUserLanguageCode();
		$this->_set404ifError($urlKey);

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

		$cssScreenshot = $font['cssScreenshot'];
		$array = explode('src:',$cssScreenshot);
		$aux = explode('),',$array[count($array) - 1]);
		$newstylesheet = $array[0] . 'src:' . $aux[count($aux)-1];

		return $newstylesheet;
	}

	private function _setSearchEngineRobotsFromGzaasVisibility($gzaasVisibility) {

		// We'll put all gzaases as public for the moment (until we better handle gzaases' visibility)
		$this->view->headMeta()->setName('robots', 'INDEX,FOLLOW');
		/**
		switch ($gzaasVisibility) {
			case 0:
				$this->view->headMeta()->setName('robots', 'NOINDEX,NOFOLLOW'); break;
			case 1:
				$this->view->headMeta()->setName('robots', 'INDEX,FOLLOW'); break;
		}
		**/
	}

	private function _setFacebookMeta($gzaas) {

		$urlKey = $gzaas['message']['urlKey'];

		// Image
		$defaultImage = "http://gzaas.com/images/gzaas_logo.png";
		$image = (!$this->_hasScreenshot($gzaas)) ? $defaultImage : "http://gzaas.s3.amazonaws.com/" . $urlKey . ".jpg";

		// Description
		$description = __("Get your friends amazed by creating easy&cool full screen messages and sending them via Facebook, Twitter, Pinterest or email!");

		// Let's assign the metas (name,content)
		$facebookMeta = array(
			array('og:type','website'),
			array('og:url','http://gzaas.com/'.$urlKey),
			array('og:description',$description),
			array('og:image',$image),
			array('og:site_name','Gzaas!'),
			array('fb:admins','578973745')
		);

		// Let's add them to the header
		foreach ($facebookMeta as $meta) {
			$this->view->headMeta()->setName($meta[0], $meta[1]);
		}

	}

	private function _setTwitterMeta($gzaas) {

		// We're using Twitter cards just for gzaases recently created that have screenshots
		if ($this->_hasScreenshot($gzaas)) {

			$urlKey = $gzaas['message']['urlKey'];
			$title = "Gzaas!";
			$description = "";
			$defaultImage = "http://gzaas.com/images/gzaas_logo.png";
			$image = "http://gzaas.s3.amazonaws.com/" . $urlKey . ".jpg";


			// Let's assign the metas (name,content)
			$twitterMeta = array(
					array('twitter:card','photo'),
					array('twitter:site','@gzaas'),
					array('twitter:title',$title),
					array('twitter:description',$description),
					array('twitter:image',$image),
					array('twitter:url','http://gzaas.com/'.$urlKey)
			);

			// Let's add them to the header
			foreach ($twitterMeta as $meta) {
				$this->view->headMeta()->setName($meta[0], $meta[1]);
			}

		}

	}

	private function _hasScreenshot($gzaas) {
		$gzaasDate = strtotime($gzaas['message']['date']);
		$firstScreenshotDate = strtotime("2014-12-05 00:00:00");

		return ($gzaasDate>$firstScreenshotDate);
	}


	private function _setUserLanguageCode() {

		$languageCode = Zend_Registry::get('languageCode');
		$this->view->languageCode = $languageCode;
	}

	private function _set404ifError($urlKey) {
		if ($urlKey==ERROR_KEY) {
			$this->_response->setHttpResponseCode(404);
		}
	}

}
