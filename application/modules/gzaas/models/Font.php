<?php

class Gzaas_Model_Font {

	const PROPORTIONAL_LINE_HEIGHT = 10;
	const PROPORTIONAL_LETTER_SPACING_WITH_FONTFACE = 40;
	const PROPORTIONAL_LETTER_SPACING_WITHOUT_FONTFACE = 15;
	const NOT_FONT_FACE_USED = 0;

	public function getFontFeatures($idFont) {

		$font = $this->getFont($idFont);
		$fontFeatures['fontFamily'] = $font['fontFamily'];

		if ($font['fontFace']==1){
			$fontFeatures['stylesheet'] = $this->_getFontStylesheet($font['fontServer'],$font);
		}
		$fontFeatures['size'] = $font['size'];
		$fontFeatures['used'] = 1;
		$fontFeatures['hashtag'] = $font['font'];
		$fontFeatures['fontFace'] = $font['fontFace'];
		$fontFeatures['description'] = $font['description'];
		$fontFeatures['fontServer'] = $font['fontServer'];
		$fontFeatures['cssScreenshot'] = $font['cssScreenshot'];
		return $fontFeatures;
	}

	public function getFontFeaturesByFontHashtag($fontHashtag) {

		$fontModelDbTable = new Gzaas_Model_DbTable_Font();
		$idFont = $fontModelDbTable->getIdFontByHashtag($fontHashtag);
		$fontFeatures = $this->getFontFeatures($idFont);

		return $fontFeatures;
	}

	private function _getFontStylesheet($fontServer,$font) {

		if ($fontServer==1){
			$stylesheet = PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css';
		} else if($fontServer==2){
			$stylesheet = '//fonts.googleapis.com/css?family='.$font['stylesheet'];
		}
		return $stylesheet;
	}

	public function checkValidFont($font) {

		$fonts = $this->getFonts();
		$valid = false;
		foreach ($fonts as $fontDb){
				if ($fontDb['font']==$font){
						$valid = $fontDb['idF'];
						break;
				}
		}
		return $valid;
	}

	public function getFontByHashtag($fontHashtag) {

		// TODO: WTF is this. Change this shit.
		$fonts = $this->getFonts();
		foreach ($fonts as $fontDb){
			if ($fontDb['font']==$fontHashtag){
				$font = $fontDb;
				break;
			}
		}
		return $font;
	}

	public function getFont($idFont) {

		// TODO: WTF is this. Change this shit.
		$fonts = $this->getFonts();
		foreach ($fonts as $fontDb){
			if ($fontDb['idF']==$idFont){
				$font = $fontDb;
				break;
			}
		}
		return $font;
	}

	public function getIdFontByHashtag($fontHashtag) {

		$fontModelDbTable = new Gzaas_Model_DbTable_Font();
		$idFont = $fontModelDbTable->getIdFontByHashtag($fontHashtag);
		return $idFont;
	}

	public function getFeaturedFonts() {

		$cache = My_Functions::getCache();
		$featuredFonts = $cache->load('featured_fonts');
		if (!$featuredFonts) {
			$fontModelDbTable = new Gzaas_Model_DbTable_Font();
			$featuredFonts = $fontModelDbTable->getFeaturedFonts();
			$cache->save($featuredFonts,'featured_fonts');
		}

		return $featuredFonts;
	}

	public function getFonts() {

		$cache = My_Functions::getCache();
		$fonts = $cache->load('fonts');
		if (!$fonts) {
			$fontModelDbTable = new Gzaas_Model_DbTable_Font();
			$fonts = $fontModelDbTable->getFonts();
			$cache->save($fonts,'fonts');
		}

		return $fonts;
	}

	public function getFontBaseSize($string,$fontUsedSize) {

		// TODO: Mmmmm, don't like this being hardcoded
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

	public function getFontBaseLineHeightFromFontBaseSize($fontBaseSize) {

		$fontBaseLineHeight = $fontBaseSize - ($fontBaseSize/self::PROPORTIONAL_LINE_HEIGHT);
		return $fontBaseLineHeight;
	}

	public function getFontBaseLetterSpacingFromFontBaseSize($fontBaseSize, $fontFace) {

		if ($fontFace!=self::NOT_FONT_FACE_USED) {
			$fontBaseLetterSpacing = $fontBaseSize/self::PROPORTIONAL_LETTER_SPACING_WITH_FONTFACE;
		} else {
			$fontBaseLetterSpacing = $fontBaseSize/self::PROPORTIONAL_LETTER_SPACING_WITHOUT_FONTFACE;
		}

		return $fontBaseLetterSpacing;
	}

	// LIMITED (API Feature)
	public function getLimitedFeaturedFonts($numResults) {

		$fontModelDbTable = new Gzaas_Model_Font();
		$limitedFeaturedFonts = $fontModelDbTable->getLimitedFeaturedFonts($numResults);
		return $limitedFeaturedFonts;
	}

	public function getLimitedFonts($numResults) {

		$fontModelDbTable = new Gzaas_Model_Font();
		$limitedFonts = $fontModelDbTable->getLimitedFonts($numResults);
		return $limitedFonts;
	}

	// FONT CREDITS (Blog / Project Credits Area)
	public function getFontCredits() {

		$fontModelDbTable = new Gzaas_Model_Font();
		$fontCredits = $fontModelDbTable->getFontCredits();
		return $fontCredits;
	}

	// Google Webfonts
	public function getGoogleWebfonts() {

		$apiKey = My_Functions::getConfigValue('google','key');
		$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=" . $apiKey;
		$fonts = My_Functions::curl($url);
		$fonts = json_decode($fonts,true);
		return $fonts;

	}


}