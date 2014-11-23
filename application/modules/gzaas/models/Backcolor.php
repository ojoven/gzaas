<?php

class Gzaas_Model_Backcolor {

	const HEXADECIMAL_COLOR_REGEXP = "/([A-F|a-f|0-9]){3}(([A-F|a-f|0-9]){3})?/";

	public function getBackColorFeatures($backColor) {

		$backColorFeatures['backColor'] = '#'.$backColor;
		$backColorFeatures['used'] = 1;
		$backColorFeatures['hashtag'] = $backColor;
		return $backColorFeatures;
	}

	public function checkValidBackColor($backColor) {

		preg_match(self::HEXADECIMAL_COLOR_REGEXP, $backColor, $validBackColor);
		return $validBackColor;
	}

}