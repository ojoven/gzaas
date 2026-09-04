<?php

class Gzaas_Model_Backcolor {

	const HEXADECIMAL_COLOR_REGEXP = "/\A(?:[A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})\z/";

	public function getBackColorFeatures($backColor) {

		$backColor = ltrim((string) $backColor, '#');
		if (!$this->checkValidBackColor($backColor)) {
			$backColor = 'fcfcfc';
		}
		$backColorFeatures['backColor'] = '#'.$backColor;
		$backColorFeatures['used'] = 1;
		$backColorFeatures['hashtag'] = $backColor;
		return $backColorFeatures;
	}

	public function checkValidBackColor($backColor) {

		return (bool) preg_match(self::HEXADECIMAL_COLOR_REGEXP, (string) $backColor);
	}

}
