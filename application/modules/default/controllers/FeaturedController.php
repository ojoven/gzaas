<?php
/** Used to generate featured thumbnails **/
// TODO: Refactor or delete and create a more authomatic way of creating the thumbnails
require_once "My/Gzaas_Base_Controller.php";

class FeaturedController extends Gzaas_Base_Controller {

	function init() {

		parent::init();

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