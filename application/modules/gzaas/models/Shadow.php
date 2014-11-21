<?php

class Gzaas_Model_Shadow
{
	const MAX_HORIZONTAL_VERTICAL_SHADOW = 24;
	const MAX_BLUR_RADIUS_SHADOW = 50;
	const SHADOW_HEXADECIMAL_COLOR_REGEXP = "/#([A-F|a-f|0-9]){3}(([A-F|a-f|0-9]){3})?/";
	const HORIZONTAL_VERTICAL_SHADOW_REGEXP = "/-?\d{1,2}(px)?/";
	const BLUR_RADIUS_SHADOW_REGEXP = "/\d{1,2}(px)?/";


	public function getShadowsFeatures($shadows)
	{
		// TODO: WARNING invalid arguments passed $shadows
		//$stringShadows = implode(",",$shadows);
		$shadowsFeatures['shadows'] = $shadows;
		$shadowsFeatures['used'] = 1;
		$shadowsFeatures['hashtag'] = $shadows;
		return $shadowsFeatures;
	}

	public function checkValidShadows($shadows)
	{
		$validShadows = false;
		if ($shadows != '') {
			$arrayShadows = explode(",", $shadows);
			$countValidShadows = 0;
			foreach ($arrayShadows as $shadow) {
				$validShadow = $this->checkValidShadow($shadow);
				if ($validShadow) {
					$countValidShadows++;
				}
			}
			if (count($arrayShadows==$countValidShadows)) {
				$validShadows = true;
			}
		}
		return $validShadows;

	}

	public function checkValidShadow($shadow)
	{
		$shadowExplode = explode(" ", trim($shadow));

		if (intval($shadowExplode[0]) <= self::MAX_HORIZONTAL_VERTICAL_SHADOW) {
			preg_match(self::HORIZONTAL_VERTICAL_SHADOW_REGEXP, $shadowExplode[0], $validHorizontalShadow);
		} else {
			$validHorizontalShadow = false;
		}

		if (intval($shadowExplode[1]) <= self::MAX_HORIZONTAL_VERTICAL_SHADOW) {
			preg_match(self::HORIZONTAL_VERTICAL_SHADOW_REGEXP, $shadowExplode[1], $validVerticalShadow);
		} else {
			$validVerticalShadow = false;
		}

		if (intval($shadowExplode[2]) <= self::MAX_BLUR_RADIUS_SHADOW) {
			preg_match(self::BLUR_RADIUS_SHADOW_REGEXP, $shadowExplode[2], $validBlurShadow);
		} else {
			$validBlurShadow = false;
		}

		preg_match(self::SHADOW_HEXADECIMAL_COLOR_REGEXP, $shadowExplode[3], $validColorShadow);

		if ($validHorizontalShadow && $validVerticalShadow && $validBlurShadow && $validColorShadow) {
			return true;
		} else {
			return false;
		}
	}


}
