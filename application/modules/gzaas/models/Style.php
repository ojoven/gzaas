<?php

class Gzaas_Model_Style
{

    public function checkValidStyle($style)
    {
        $styles = $this->getStyles();
        $valid = false;
        foreach ($styles as $styleDb){
            if ($styleDb['style']==$style){
                $valid = $styleDb['idS'];
                break;
            }
        }
        return $valid;
    }

    public function getStyle($idStyle)
    {
        $styles = $this->getStyles();
        foreach ($styles as $styleDb){
            if ($styleDb['idS']==$idStyle){
                $style = $styleDb;
                break;
            }
        }
        return $style;
    }

    public function getFeaturedStyles()
    {
        // We get featured styles from cache
        $cache = My_Functions::getCache();
        $featuredStyles = $cache->load('featured_styles');
        if ($featuredStyles === false) {
            // They're not cached. Get them from BD and cache them.
            $styleModelDbTable = new Gzaas_Model_DbTable_Style();
            $featuredStyles = $styleModelDbTable->getFeaturedStyles();
            $cache->save($featuredStyles,'featured_styles');
        }
        return $featuredStyles;
    }


    public function getStyles()
    {
        // We get the styles from cache
        $cache = My_Functions::getCache();
        $styles = $cache->load('styles');
        if ($styles === false) {
            // They're not cached. Get them from BD and save to cache.
            $styleModelDbTable = new Gzaas_Model_DbTable_Style();
            $styles = $styleModelDbTable->getStyles();
            $cache->save($styles,'styles');
        }
        return $styles;
    }

    public function checkIfRemainingFeaturesAreUsed($features)
    {
        if (($features['font']['used']==1) || ($features['color']['used']==1) || ($features['backColor']['used'] == 1) || ($features['pattern']['used'] == 1) || ($features['shadows']['used'] == 1)) {
            return true;
        } else {
            return false;
        }
    }

    public function getRandomIdStyle()
    {
    	$idStyles = $this->getIdStyles();
        $randomNumberStyle = rand(0,count($idStyles)-1);
        $idStyle = $idStyles[$randomNumberStyle];
        return $idStyle;
    }

    public function getStyleFeatures($idStyle, &$features)
    {
        $style = $this->getStyle($idStyle);
        if (!$this->checkIfRemainingFeaturesAreUsed($features)) {
            $features['style']['used'] = 1;
            $features['style']['description'] = $style['description'];
            $features['style']['hashtag'] = $style['style'];
        }

        // Font
        // If not font directly related to the gzaas, we get it from the style selected
        if ($features['font']['used'] == 0) {
            $fontModel = new Gzaas_Model_Font();
            $features['font'] = $fontModel->getFontFeaturesByFontHashtag($style['font']);
        }

        // Color
        if ($features['color']['used'] == 0) {
        $colorModel = new Gzaas_Model_Color();
        $features['color'] = $colorModel->getColorFeatures($style['color']);
        }

        // Background Color // Pattern
        if (($features['backColor']['used'] == 0) && ($features['pattern']['used'] == 0)) {

            if ($style['backColor']) {
                $backColorModel = new Gzaas_Model_Backcolor();
                $features['backColor'] = $backColorModel->getBackColorFeatures($style['backColor']);
            }

            else if ($style['pattern']){
                $patternModel = new Gzaas_Model_Pattern();
                $features['pattern'] = $patternModel->getPatternFeaturesByHashtag($style['pattern']);
            }
        }

        // Shadows
        $shadowModel = new Gzaas_Model_Shadow();
        if (($features['shadows']['used'] == 0) && ($shadowModel->checkValidShadows($style['shadow']))) {
            $features['shadows'] = $shadowModel->getShadowsFeatures($style['shadow']);
        }
    }


    // LIMITED (API calls)

    public function getLimitedFeaturedStyles($numResults)
    {
        $styleModelDbTable = new Gzaas_Model_DbTable_Style();
        $limitedFeaturedStyles = $styleModelDbTable->getLimitedFeaturedStyles($numResults);
        return $limitedFeaturedStyles;
    }

    public function getLimitedStyles($numResults)
    {
        $styleModelDbTable = new Gzaas_Model_DbTable_Style();
        $limitedStyles = $styleModelDbTable->getLimitedStyles($numResults);
        return $limitedStyles;
    }

    public function getIdStyles()
    {
        $cache = My_Functions::getCache();
        $idStyles = $cache->load('idStyles');
        if ($idStyles === false) {
            $styleModelDbTable = new Gzaas_Model_DbTable_Style();
            $idStyles = $styleModelDbTable->getIdStyles();
            $cache->save($idStyles,'idStyles');
        }
        return $idStyles;
    }

}
