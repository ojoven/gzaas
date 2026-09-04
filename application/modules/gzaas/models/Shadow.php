<?php

class Gzaas_Model_Shadow {

	const MAX_HORIZONTAL_VERTICAL_SHADOW = 24;
	const MAX_BLUR_RADIUS_SHADOW = 50;
	const SHADOW_HEXADECIMAL_COLOR_REGEXP = "/\A#[A-Fa-f0-9]{3}(?:[A-Fa-f0-9]{3})?\z/";
	const HORIZONTAL_VERTICAL_SHADOW_REGEXP = "/\A-?\d{1,2}(?:px)?\z/";
	const BLUR_RADIUS_SHADOW_REGEXP = "/\A\d{1,2}(?:px)?\z/";


	public function getShadowsFeatures($shadows) {

		// TODO: WARNING invalid arguments passed $shadows
		//$stringShadows = implode(",",$shadows);
		$shadowsFeatures['shadows'] = $shadows;
		$shadowsFeatures['used'] = 1;
		$shadowsFeatures['hashtag'] = $shadows;
		return $shadowsFeatures;
	}

	public function checkValidShadows($shadows) {

		$validShadows = false;
		if ($shadows != '') {
			$arrayShadows = explode(",", $shadows);
			if (count($arrayShadows) > 10) {
				return false;
			}
			$countValidShadows = 0;
			foreach ($arrayShadows as $shadow) {
				$validShadow = $this->checkValidShadow($shadow);
				if ($validShadow) {
					$countValidShadows++;
				}
			}
			if (count($arrayShadows) === $countValidShadows) {
				$validShadows = true;
			}
		}
		return $validShadows;

	}

	public function checkValidShadow($shadow) {

		$shadowExplode = preg_split('/\s+/', trim($shadow));
		if (count($shadowExplode) !== 4) {
			return false;
		}

		if (abs(intval($shadowExplode[0])) <= self::MAX_HORIZONTAL_VERTICAL_SHADOW) {
			$validHorizontalShadow = (bool) preg_match(self::HORIZONTAL_VERTICAL_SHADOW_REGEXP, $shadowExplode[0]);
		} else {
			$validHorizontalShadow = false;
		}

		if (abs(intval($shadowExplode[1])) <= self::MAX_HORIZONTAL_VERTICAL_SHADOW) {
			$validVerticalShadow = (bool) preg_match(self::HORIZONTAL_VERTICAL_SHADOW_REGEXP, $shadowExplode[1]);
		} else {
			$validVerticalShadow = false;
		}

		if (intval($shadowExplode[2]) <= self::MAX_BLUR_RADIUS_SHADOW) {
			$validBlurShadow = (bool) preg_match(self::BLUR_RADIUS_SHADOW_REGEXP, $shadowExplode[2]);
		} else {
			$validBlurShadow = false;
		}

		$validColorShadow = (bool) preg_match(self::SHADOW_HEXADECIMAL_COLOR_REGEXP, $shadowExplode[3]);

		if ($validHorizontalShadow && $validVerticalShadow && $validBlurShadow && $validColorShadow) {
			return true;
		} else {
			return false;
		}
	}

}
