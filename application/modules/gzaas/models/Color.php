<?php

class Gzaas_Model_Color
{
	const HEXADECIMAL_COLOR_REGEXP = "/([A-F|a-f|0-9]){3}(([A-F|a-f|0-9]){3})?/";

	public function getColorFeatures($color)
	{
		$colorFeatures['color'] = '#'.$color;
		$colorFeatures['used'] = 1;
		$colorFeatures['hashtag'] = $color;
		return $colorFeatures;
	}

    public function checkValidColor($color)
    {
        preg_match(self::HEXADECIMAL_COLOR_REGEXP, $color, $validColor);
        return $validColor;
    }

}