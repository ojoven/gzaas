<?php
require_once "My/Gzaas_Base_Controller.php";

class Api_EmbedController extends Gzaas_Base_Controller {

	function init() {

		parent::init();

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