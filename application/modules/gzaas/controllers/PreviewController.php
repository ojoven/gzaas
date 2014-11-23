<?php
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Gzaas_PreviewController extends Zend_Controller_Action {

	function init() {

		$this->_redirector = $this->_helper->getHelper('Redirector');
		$this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper');

		// Preview Javascripts
		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description.preview'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$metaTitle = utf8_encode($translate->translate('meta.title.preview'));

		$this->view->headMeta()->setName('description', $metaDescription);
		$this->view->headMeta()->setName('keywords', $metaKeyWords);
		$this->view->headTitle()->append($metaTitle);

	}

	public function previewAction() {

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