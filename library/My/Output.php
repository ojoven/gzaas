<?php

class My_Output
{
    public static function html($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function javascript($value)
    {
        $encoded = json_encode(
            $value,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );

        return ($encoded === false) ? 'null' : $encoded;
    }

    public static function cssNumber($value, $fallback)
    {
        return is_numeric($value) ? (string) (float) $value : (string) (float) $fallback;
    }

    public static function cssColor($value, $fallback)
    {
        $value = (string) $value;
        if (preg_match('/\A#[0-9A-Fa-f]{3}(?:[0-9A-Fa-f]{3})?\z/', $value)) {
            return $value;
        }

        return $fallback;
    }

    public static function cssFontFamily($value)
    {
        $value = preg_replace('/[^A-Za-z0-9 _,\-]/', '', (string) $value);
        return ($value === '') ? 'Helvetica, Arial' : $value;
    }

    public static function cssBackgroundImage($value)
    {
        $value = (string) $value;
        if (!preg_match('/\Aurl\(([A-Za-z0-9_\.\/\-]+)\)\z/', $value, $matches)) {
            return '';
        }

        if (strpos($matches[1], '..') !== false) {
            return '';
        }

        return 'url("' . $matches[1] . '")';
    }

    public static function cssShadows($value)
    {
        $value = (string) $value;
        if ($value === '') {
            return '';
        }

        $shadows = explode(',', $value);
        if (count($shadows) > 10) {
            return '';
        }

        $clean = array();
        foreach ($shadows as $shadow) {
            $shadow = trim($shadow);
            if (!preg_match(
                '/\A-?\d{1,2}(?:px)?\s+-?\d{1,2}(?:px)?\s+\d{1,2}(?:px)?\s+#[0-9A-Fa-f]{3}(?:[0-9A-Fa-f]{3})?\z/',
                $shadow
            )) {
                return '';
            }
            $clean[] = $shadow;
        }

        return implode(', ', $clean);
    }
}
