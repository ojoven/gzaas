<?php

class Gzaas_Model_Gzaas {

	const GZAAS_MAX_SIZE = 1024;
	const GZAAS_MAX_NEW_LINES = 30;
	const EXCEPTION_GZAAS_NOT_FOUND = 'EXCEPTION_GZAAS_NOT_FOUND';

	// New gzaas
	public function checkValidParameters($parameters,&$valid,&$errorMessage) {

		$message 	 = $parameters['message'];
		$font        = $parameters['font'];
		$color       = $parameters['color'];
		$backColor   = $parameters['backColor'];
		$pattern	 = $parameters['pattern'];
		$shadows     = $parameters['shadows'];
		$style       = $parameters['style'];
		$visibility  = $parameters['visibility'];

		$this->_checkMaxLines($message, $errorMessage, $valid);
		$this->_checkMessageMaxLength($message, $errorMessage, $valid);
		$this->_checkEmptyGzaas($message, $errorMessage, $valid);
		$this->_checkBackColorAndFontColor($color, $backColor, $errorMessage, $valid);
		$this->_checkStyle($font, $color, $backColor, $pattern, $style, $errorMessage, $valid);
		$this->_checkValidVisibility($visibility,$errorMessage,$valid);

	}

	public function addGzaasAndFeatures($parameters,&$jsonResponse) {

		$message 	 = $parameters['message'];
		$font        = $parameters['font'];
		$color       = $parameters['color'];
		$backColor   = $parameters['backColor'];
		$pattern	 = $parameters['pattern'];
		$shadows     = $parameters['shadows'];
		$style       = $parameters['style'];
		$visibility  = $parameters['visibility'];

		$idFont = $validColor = $validBackColor = $idPattern = $validShadows = $idStyle = false;

		$db = Zend_Registry::get('db');
		$db->beginTransaction();

		try {
			// Add message
			$messageModel = new Gzaas_Model_Message();
			$message = $this->_cleanMessage($message);
			$response = $messageModel->addMessage($message,$visibility);
			if (!$response) throw new Exception();
			$idMessage = $response['idMessage'];
			$urlKey = $response['urlKey'];

			// Add style features
			$this->_addFontIfFont($font, $idMessage, $idFont);
			$this->_addColorIfColor($color, $idMessage, $validColor);
			$this->_addBackColorIfBackColor($backColor, $idMessage, $validBackColor);
			$this->_addPatternIfPattern($pattern, $idMessage, $idPattern);
			$this->_addShadowsIfShadows($shadows, $idMessage, $validShadows);
			$this->_addStyleIfStyle($style, $idMessage, $idStyle);

			$anyStyleFeaturesDefined = $this->_checkAnyStyleFeaturesDefined($idFont,$validColor,$validBackColor,$idPattern,$validShadows,$idStyle);

			if ($anyStyleFeaturesDefined) {
				$db->commit();
				
				// Now, let's create screenshot for the gzaas
				$this->_createScreenshotGzaas($urlKey);
				
				$response = $this->_constructSuccessJsonResponse($urlKey, $visibility);
				return $response;
			} else {
				$db->rollback();
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->_('error.no.style'));
				$response = $this->constructErrorJsonResponse($errorMessage);
				return $response;
			}

		} catch (exception $e) {
			$db->rollback();
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.newgs.exception'));
			$response = $this->_constructErrorJsonResponse($errorMessage);
			return $response;
		}

	}

	public function previewGzaas($parameters) {

		$formMessage = $parameters['gs_form'];

		$this->_setErrorMessageIfNotValidOnPreview($formMessage);
		$this->_cleanFormMessageOnPreview($formMessage);
		$renderedMessage = $this->_setRenderedMessageFromFormMessage($formMessage);
		$this->_addSloganOnEmptyGzaas($textmessage);

		$features = $this->getGzaasFeaturesOnPreview($parameters);
		$this->_setFontFeaturesOnMessage($features, $renderedMessage);

		$previewGzaas['features'] = $features;
		$previewGzaas['formMessage'] = $formMessage;
		$previewGzaas['renderedMessage'] = $renderedMessage;
		$metaTagModel = new Gzaas_Model_Metatag();
		$previewGzaas['menuOptions'] = $metaTagModel->getMenuOptions();

		return $previewGzaas;
	}

	public function getFeaturesErrorGzaas() {

		$parameters['font'] = 'chewy';
		$parameters['color'] = '#000';
		$parameters['backColor'] = '#ffff00';

		return $parameters;
	}

	public function getGzaasFeaturesOnPreview($parameters) {

		$font        = My_Functions::getVariableFromArrayOrNullIfIndexIsNotSet($parameters,'font');
		$color       = My_Functions::getVariableFromArrayOrNullIfIndexIsNotSet($parameters,'color');
		$backColor   = My_Functions::getVariableFromArrayOrNullIfIndexIsNotSet($parameters,'backColor');
		$pattern 	 = My_Functions::getVariableFromArrayOrNullIfIndexIsNotSet($parameters,'pattern');
		$style       = My_Functions::getVariableFromArrayOrNullIfIndexIsNotSet($parameters,'style');
		$shadows     = My_Functions::getVariableFromArrayOrNullIfIndexIsNotSet($parameters,'shadows');

		$features = $this->_getDefaultFeatures();

		// Font
		if ($font) {
			$fontModel = new Gzaas_Model_Font();
			$idFont = $fontModel->checkValidFont($font);
			if ($idFont) {
				$features['font'] = $fontModel->getFontFeatures($idFont);
			}
		}

		// Color
		if ($color) {
			$colorModel = new Gzaas_Model_Color();
			$validColor = $colorModel->checkValidColor($color);
			if ($validColor) {
				$features['color'] = $colorModel->getColorFeatures($color);
			}
		}

		// BackColor
		if ($backColor) {
			$backColorModel = new Gzaas_Model_Backcolor();
			$validBackColor = $backColorModel->checkValidBackColor($backColor);
			if ($validBackColor) {
				$features['backColor'] = $backColorModel->getBackColorFeatures($backColor);
			}
		}

		// Pattern
		if ($pattern) {
			$patternModel = new Gzaas_Model_Pattern();
			$idPattern = $patternModel->checkValidPattern($pattern);
			if ($idPattern) {
				$features['pattern'] = $patternModel->getPatternFeatures($idPattern);
			}
		}

		// Shadows
		if ($shadows) {
			$shadowModel = new Gzaas_Model_Shadow();
			$validShadows = $shadowModel->checkValidShadows($shadows);
			if ($validShadows) {
				$features['shadows'] = $shadowModel->getShadowsFeatures($shadows);
			}
		}

		// Style
		if ($style) {
			$styleModel = new Gzaas_Model_Style();
			if ($style=="random") {
				$idStyle = $styleModel->getRandomIdStyle();
			} else {
				$idStyle = $styleModel->checkValidStyle($style);
			}
			if ($idStyle){
				$features['style'] = $styleModel->getStyleFeatures($idStyle, $features);
			}
		}

		// Visibility TODO
		$features['visibility'] = true;

		return $features;

	}

	private function _addSloganOnEmptyGzaas(&$textmessage) {

		if (trim($textmessage) == '') {
			$translate = Zend_Registry::get('Zend_Translate');
			$textmessage = utf8_encode($translate->_('meta.title'));
		}
	}

	private function _setErrorMessageIfNotValidOnPreview(&$formMessage) {

		// Gzaas max size
		if (strlen($formMessage) > self::GZAAS_MAX_SIZE) {
			$formMessage = substr($formMessage, 0, self::GZAAS_MAX_SIZE);
		}

		$arrayNewLines = explode("\n", $formMessage);
		if (count($arrayNewLines) > self::GZAAS_MAX_NEW_LINES + 1) {
			$translate = Zend_Registry::get('Zend_Translate');
			$formMessage = utf8_encode($translate->_('error.max.lines'));
		}
	}

	private function _cleanFormMessageOnPreview(&$formMessage) {

			$formMessage = stripSlashes($formMessage);
			$formMessage = htmlspecialchars($formMessage, ENT_NOQUOTES);
	}

	private function _setRenderedMessageFromFormMessage($formMessage) {

			$renderedMessage = str_replace("\r\n", "<br/>", $formMessage);
			return $renderedMessage;
	}

	// See gzaas
	public function renderGzaas($urlKey) {

		$messageModel = new Gzaas_Model_Message();
		$message = $messageModel->getMessage($urlKey);
		if (!$message) throw new Exception(self::EXCEPTION_GZAAS_NOT_FOUND);
		$features = $this->_getGzaasFeatures($message['id']);
		$this->_setFontFeaturesOnMessage($features, $message);

		$twitterModel = new Gzaas_Model_Twitter();
		$twitterMessage = $twitterModel->getTwitterMessageFromGzaasMessage($message['message']);
		$url = URL_BASE.$urlKey;

		$gzaas['message'] = $message;
		$gzaas['features'] = $features;
		$gzaas['twitterMessage'] = $twitterMessage;
		$gzaas['url'] = $url;

		return $gzaas;
	}

	private function _setFontFeaturesOnMessage(&$features, $message) {

		$message = (isset($message['message'])) ? $message['message'] : $message;
		$fontModel = new Gzaas_Model_Font();
		$features['font']['fontBaseSize'] = $fontModel->getFontBaseSize($message,$features['font']['size']);
		$features['font']['fontBaseLineHeight'] = $fontModel->getFontBaseLineHeightFromFontBaseSize($features['font']['fontBaseSize']);
		$features['font']['fontBaseLetterSpacing'] = $fontModel->getFontBaseLetterSpacingFromFontBaseSize($features['font']['fontBaseSize'],$features['font']['fontFace']);
	}

	public function _getGzaasFeatures($idMessage) {

		$features = $this->_getDefaultFeatures();

		// Font
		$fontMessageModel = new Gzaas_Model_Fontmessage();
		$idFont = $fontMessageModel->getIdFontFromMessage($idMessage);
		if ($idFont) {
			$fontModel = new Gzaas_Model_Font();
			$features['font'] = $fontModel->getFontFeatures($idFont);
		}

		// Color
		$colorMessageModel = new Gzaas_Model_DbTable_Colormessage();
		$color = $colorMessageModel->getColorFromMessage($idMessage);
		if ($color) {
			$colorModel = new Gzaas_Model_Color();
			$features['color'] = $colorModel->getColorFeatures($color);
		}

		// BackColor
		$backColorMessageModel = new Gzaas_Model_DbTable_Backcolormessage();
		$backColor = $backColorMessageModel->getBackColorFromMessage($idMessage);
		if ($backColor) {
			$backColorModel = new Gzaas_Model_Backcolor();
			$features['backColor'] = $backColorModel->getBackColorFeatures($backColor);
		}

		// Pattern
		$patternMessageModel = new Gzaas_Model_DbTable_Patternmessage();
		$idPattern = $patternMessageModel->getIdPatternFromMessage($idMessage);
		if ($idPattern) {
			$patternModel = new Gzaas_Model_Pattern();
			$features['pattern'] = $patternModel->getPatternFeatures($idPattern);
		}

		// Shadows
		$shadowMessageModel = new Gzaas_Model_DbTable_Shadowmessage();
		$shadows = $shadowMessageModel->getShadowsFromMessage($idMessage);
		if ($shadows) {
			$shadowModel = new Gzaas_Model_Shadow();
			$features['shadows'] = $shadowModel->getShadowsFeatures($shadows);
		}

		// Style
		$styleMessageModel = new Gzaas_Model_DbTable_Stylemessage();
		$idStyle = $styleMessageModel->getIdStyleFromMessage($idMessage);
		if ($idStyle){
			$styleModel = new Gzaas_Model_Style();
			$styleModel->getStyleFeatures($idStyle, $features);
		}

		return $features;

	}

	// PRIVATE METHODS

	// New gzaas
	private function _checkStyle($font, $color, $backColor, $pattern, $style, &$errorMessage, &$valid) {

		if (($font == '') && ($color == '') && ($backColor == '') && ($pattern == '') && ($style == '')) {
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.no.style'));
			$valid = false;
		}
	}

	private function _checkBackColorAndFontColor($color, $backcolor, &$errorMessage, &$valid) {

		if (($color != '') && ($color == $backcolor)) {
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.same.color'));
			$valid = false;
		}
	}

	private function _checkEmptyGzaas($textmessage, &$errorMessage, &$valid) {

		if (trim($textmessage) == '') {
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.gzaas.blank'));
			$valid = false;
		}
	}

	private function _checkMessageMaxLength($textmessage, &$errorMessage, &$valid) {

		if (strlen($textmessage) > self::GZAAS_MAX_SIZE) {
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.max.size'));
			$valid = false;
		}
	}

	private function _checkMaxLines($textmessage, &$errorMessage, &$valid) {

		$arrayNewLines = explode("\n", $textmessage);
		if (count($arrayNewLines) > self::GZAAS_MAX_NEW_LINES + 1) {
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.max.lines'));
			$valid = false;
		}
	}

	private function _checkValidVisibility($visibility, &$errorMessage, &$valid) {

		if (($visibility!=0) && ($visibility!=1)) {
			$translate = Zend_Registry::get('Zend_Translate');
			$errorMessage = utf8_encode($translate->_('error.no.valid.visibility'));
			$valid = false;
		}
	}

	private function _cleanMessage($message) {

		$message = stripSlashes($message);
		$message = htmlspecialchars($message, ENT_NOQUOTES);
		return $message;
	}

	private function _addFontIfFont($font, $idMessage, &$idFont) {
		if ($font != '') {
			$fontModel = new Gzaas_Model_Font();
			$idFont = $fontModel->checkValidFont($font);
			if ($idFont) {
				$fontMessageModel = new Gzaas_Model_Fontmessage();
				$fontMessageModel->addFontMessage($idFont, $idMessage);
			}
		}
	}

	private function _addColorIfColor($color, $idMessage, &$validColor) {

		if ($color != '') {
			$colorModel = new Gzaas_Model_Color();
			$validColor = $colorModel->checkValidColor($color);
			if ($validColor) {
				$colorMessageModel = new Gzaas_Model_Colormessage();
				$colorMessageModel->addColorMessage($color, $idMessage);
			}
		}
	}

	private function _addBackColorIfBackColor($backColor, $idMessage, &$validBackColor) {

		if ($backColor != '') {
			$backColorModel = new Gzaas_Model_Backcolor();
			$validBackColor = $backColorModel->checkValidBackColor($backColor);
			if ($validBackColor) {
				$backcolorMessageModel = new Gzaas_Model_Backcolormessage();
				$backcolorMessageModel->addBackColorMessage($backColor, $idMessage);
			}
		}
	}

	private function _addPatternIfPattern($pattern, $idMessage, &$idPattern) {

		if ($pattern != '') {
			$patternModel = new Gzaas_Model_Pattern();
			$idPattern = $patternModel->checkValidPattern($pattern);
			if ($idPattern) {
				$patternMessageModel = new Gzaas_Model_Patternmessage();
				$patternMessageModel->addPatternMessage($idPattern, $idMessage);
			}
		}
	}

	private function _addShadowsIfShadows($shadows, $idMessage, &$validShadows) {

		if ($shadows != '') {
			$arrayShadows = explode(",", $shadows);

			foreach ($arrayShadows as $shadow) {
				$shadowModel = new Gzaas_Model_Shadow();
				$validShadow = $shadowModel->checkValidShadow($shadow);

				if ($validShadow) {
					$shadowMessageModel = new Gzaas_Model_Shadowmessage();
					$shadowMessageModel->addShadowMessage($shadow, $idMessage);
					$validShadows = true;
				}
			}
		}
	}

	private function _addStyleIfStyle($style, $idMessage, &$idStyle) {

		if ($style != '') {
			$styleModel = new Gzaas_Model_Style();
			$idStyle = $styleModel->validStyle($style);

			if ($idStyle) {
				$styleMessageModel = new Gzaas_Model_Stylemessage();
				$styleMessageModel->addStyleMessage($idStyle, $idMessage);
			}
		}
	}

	private function _checkAnyStyleFeaturesDefined($idFont,$validColor,$validBackColor,$idPattern,$validShadows,$idStyle) {

		if ((!$idFont) && (!$validColor) && (!$validBackColor) && (!$idPattern) && (!$validShadows) && (!$idStyle)) {
			return false;
		} else {
			return true;
		}
	}

	// We call this method from the Controller.
	public function constructErrorJsonResponse($errorMessage) {

		$response['valid'] = false;
		$response['errorMessage'] = $errorMessage;
		return json_encode($response);
	}

	private function _constructSuccessJsonResponse($urlKey,$visibility) {

		$urlGs = URL_BASE . $urlKey;
		$response = array(
			'valid' => true,
			'urlGs' => $urlGs,
			'urlKey' => $urlKey,
			'visibility' => $visibility
		);

		return json_encode($response);
	}

	// See gzaas
	private function _getDefaultFeatures() {

		$features['font']['fontFamily'] = 'Helvetica, Arial';
		$features['font']['hashtag'] = 'arial';
		$features['font']['used'] = 0;
		$features['font']['size'] = 1;
		$features['font']['fontFace'] = 0;
		$features['font']['description'] = 'Arial';
		$features['color']['color'] = '#444';
		$features['color']['hashtag'] = '444444';
		$features['color']['used'] = 0;
		$features['backColor']['backColor'] = '#fcfcfc';
		$features['backColor']['hashtag'] = 'fcfcfc';
		$features['backColor']['used'] = 0;
		$features['pattern']['pattern'] = '';
		$features['pattern']['used'] = 0;
		$features['shadows']['shadows'] ='';
		$features['shadows']['hashtag'] ='';
		$features['shadows']['used'] = 0;
		$features['style']['used'] = 0;
		return $features;
	}
	
	// Private
	function _createScreenshotGzaas($urlKey) {
		$pathToPhantomJs = APPLICATION_PATH . '/bin/screenshot.js';
		$params = $this->_getParamsScreenshot($urlKey);
		$paramsAsArgs = implode(" ", $params);
		exec("phantomjs " . $pathToPhantomJs . " " . $paramsAsArgs);
	}
	
	function _getParamsScreenshot($urlKey) {
		
		$pathToImage = APPLICATION_PATH . '/tmp/' . $urlKey . '.png';
		$params = array(
			$urlKey,
			'http://gzaas.local.host/' . $urlKey . '?screenshot=image',
			$pathToImage,
			1024,
			600
		);
		return $params;
	}

}
