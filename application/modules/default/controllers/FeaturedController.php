<?php
/** Used to generate featured thumbnails **/
// TODO: Refactor or delete and create a more authomatic way of creating the thumbnails
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";
require_once "My/Functions.php";

class FeaturedController extends Zend_Controller_Action {

	function init() {

		$this->_redirector = $this->_helper->getHelper('Redirector');

		$this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper');
		$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/style.css');
		$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/Chewy/stylesheet.css');
		// jQuery CDN Google
		$this->view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js','text/javascript');

		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$metaTitle = utf8_encode($translate->translate('meta.title'));

		$this->view->headMeta()->setName('description', $metaDescription);
		$this->view->headMeta()->setName('keywords', $metaKeyWords);
		$this->view->headTitle()->append($metaTitle);

	}

	public function indexAction() {

		$this->view->titulo = "Gzaas //";
		$this->render();
	}

	public function fontsAction() {

		// Featured Fonts
		$fontModel = new Gzaas_Model_Font();
		$featuredFonts = $fontModel->getFeaturedFonts();

		foreach($featuredFonts as $featuredFont) {
			if ($featuredFont['fontFace']==1){
				if ($featuredFont['fontServer']==1){
					$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/'.$featuredFont['stylesheet'].'/stylesheet.css');
				}
				else if($featuredFont['fontServer']==2){
					$this->view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family='.$featuredFont['stylesheet']);
				}
			}
		}

		$this->view->featuredFonts = $featuredFonts;


		// All fonts
		$fonts = $fontModel->getFonts();
		foreach($fonts as $font) {
			if ($font['fontFace']==1){
				if ($font['fontServer']==1){
					$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css');
				}
				else if($font['fontServer']==2){
					$this->view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family='.$font['stylesheet']);
				}
			}
		}

		$this->view->fonts = $fonts;
		$this->render();
	}

	public function patternsAction() {

		// Featured patterns
		$patternModel = new Gzaas_Model_Pattern();
		$featuredPatterns = $patternModel->getFeaturedPatterns();
		$this->view->featuredPatterns = $featuredPatterns;

		// All patterns
		$patterns = $patternModel->getPatterns();
		$this->view->patterns = $patterns;

		$this->render();
	}


	public function stylesAction() {

		// Featured styles
		$fontModel = new Gzaas_Model_Font();
		$patternModel = new Gzaas_Model_Pattern();
		$styleModel = new Gzaas_Model_Style();

		$featuredStyles = $styleModel->getFeaturedStyles();

		$completeFeaturedStyles = new ArrayObject();

		foreach($featuredStyles as $featuredStyle) {
			$completeStyle = $featuredStyle;

			// Font
			$font = $fontModel->getFontByHashtag($completeStyle['font']);
			$completeStyle['fontFamily'] = $font['fontFamily'];
			if ($font['fontFace']==1){
				if ($font['fontServer']==1){
					$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css');
				}
				else if($font['fontServer']==2){
					$this->view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family='.$font['stylesheet']);
				}
			}

			// Background
			if ($completeStyle['pattern']!=null){
				$completeStyle['pattern'] = $patternModel->getPatternByHashtag($completeStyle['pattern']);
			}

			$completeFeaturedStyles->append($completeStyle);
		}

		$this->view->featuredStyles = $completeFeaturedStyles;

		// All styles

		$styles = $styleModel->getStyles();

		$completeAllStyles = new ArrayObject();

		foreach($styles as $style) {
			$completeStyle = $style;

			// Font (this is exactly the same as for featured styles, TODO: create function to reuse code)
			$font = $fontModel->getFontByHashtag($completeStyle['font']);
			$completeStyle['fontFamily'] = $font['fontFamily'];
			if ($font['fontFace']==1){
				if ($font['fontServer']==1){
					$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css');
				}
				else if($font['fontServer']==2){
					$this->view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family='.$font['stylesheet']);
				}
			}

			if ($completeStyle['pattern']!=null){
				$completeStyle['pattern'] = $patternModel->getPatternByHashtag($completeStyle['pattern']);
			}

			$completeAllStyles->append($completeStyle);
		}

		$this->view->allStyles = $completeAllStyles;
		$this->render();
	}

}