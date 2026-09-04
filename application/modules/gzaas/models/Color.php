<?php

class Gzaas_Model_Color {

	const HEXADECIMAL_COLOR_REGEXP = "/\A(?:[A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})\z/";

	public function getColorFeatures($color) {

		$color = ltrim((string) $color, '#');
		if (!$this->checkValidColor($color)) {
			$color = '444';
		}
		$colorFeatures['color'] = '#'.$color;
		$colorFeatures['used'] = 1;
		$colorFeatures['hashtag'] = $color;
		return $colorFeatures;
	}

	public function checkValidColor($color) {

		return (bool) preg_match(self::HEXADECIMAL_COLOR_REGEXP, (string) $color);
	}

}
