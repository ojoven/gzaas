<?php
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Api_EmbedController extends Zend_Controller_Action {

	function init() {

		$this->_redirector = $this->_helper->getHelper('Redirector');

		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
		$this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper');
		$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/style_mob.css');
		$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/Chewy/stylesheet.css');

		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description.gzaas'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$metaTitle = utf8_encode($translate->translate('meta.title.gzaas'));

		$this->view->headMeta()->setName('description', $metaDescription);
		$this->view->headMeta()->setName('keywords', $metaKeyWords);

	}


	public function embeddedAction() {

		try {

			// Recogemos el id de la url
			$urlKey = $this->getRequest()->getParam("urlKey");
			$gzaasModel = new Gzaas_Model_Gzaas();
			$gzaas = $gzaasModel->renderGzaas($urlKey);

			$this->view->message = $gzaas['message']['message'];
			$this->view->features = $gzaas['features'];
			$this->_setFontHeadStylesheetIfFontFaceUsed($gzaas['features']['font']);
			$this->view->urlKey = $gzaas['url'];

			$this->render();

		}

		catch (Exception $e) {

			$ulll = $e->getMessage();
		}

	}

	private function _setFontHeadStylesheetIfFontFaceUsed($fontFeatures) {

		if ($fontFeatures['fontFace']==1) {
			$this->view->headLink()->appendStylesheet($fontFeatures['stylesheet']);
		}
	}

	private function setDefaultFeatures() {

		$features['fontFamily'] = 'Helvetica, Arial';
		$features['color'] = '#444';
		$features['backgroundColor'] = '#fcfcfc';
		$features['backgroundImage'] = '';
		$features['textShadow'] ='';

		return $features;
	}

	private function getFontSize($string,$fontUsedSize) {

		$numChars = strlen($string);
		if ($numChars<=6){$fontSize = 400;}
		else if ($numChars<=20){$fontSize = 300;}
		else if ($numChars<=50){$fontSize = 150;}
		else if ($numChars<=100){$fontSize = 120;}
		else if ($numChars<=200){$fontSize = 90;}
		else if ($numChars<=300){$fontSize = 70;}
		else if ($numChars<=500){$fontSize = 60;}
		else {$fontSize = 40;}
		return $fontSize;
	}

}