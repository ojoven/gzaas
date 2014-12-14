<?php
require_once "My/Gzaas_Base_Controller.php";

class Gzaas_PreviewController extends Gzaas_Base_Controller {

	function init() {

		parent::init();

	}

	public function previewAction() {

		$this->view->headTitle(__("Preview") . " | " . __("Gzaas!"),'SET');

		$parameters = $this->_request->getParams();
		$gzaasModel = new Gzaas_Model_Gzaas();
		$previewGzaas = $gzaasModel->previewGzaas($parameters);

		$this->view->formMessage  		= $previewGzaas['formMessage'];
		$this->view->renderedMessage    = $previewGzaas['renderedMessage'];
		$this->view->features     		= $previewGzaas['features'];
		$this->view->menuOptions  		= $previewGzaas['menuOptions'];
		$this->view->from				= (isset($parameters['from'])) ? $parameters['from'] : 'home';

		$this->_setFontHeadStylesheetIfFontFaceUsed($previewGzaas['features']['font']);
		$this->_setUserLanguageCode();
	}

	private function _setFontHeadStylesheetIfFontFaceUsed($fontFeatures) {

		if ($fontFeatures['fontFace']==1) {
			$this->view->headLink()->appendStylesheet($fontFeatures['stylesheet']);
		}
	}

	private function _setUserLanguageCode() {

		$languageCode = Zend_Registry::get('languageCode');
		$this->view->languageCode = $languageCode;
	}

	public function getallfontsAction() {

		$fontModel = new Gzaas_Model_DbTable_Font();
		$fonts = $fontModel->getFonts();

		$this->view->fonts = $fonts;

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$this->render();
	}

	public function getallpatternsAction() {

		$patternModel = new Gzaas_Model_DbTable_Pattern();
		$patterns = $patternModel->getPatterns();

		$this->view->patterns = $patterns;

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$this->render();
	}

	public function getallstylesAction() {

		$styleModel = new Gzaas_Model_DbTable_Style();
		$styles = $styleModel->getStyles();

		$this->view->styles = $styles;

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$this->render();
	}

}