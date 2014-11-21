<?php

class Gzaas_Model_Pattern
{

    public function getPatternFeatures($idPattern)
    {
        $pattern = $this->getPattern($idPattern);
        $patternFeatures['pattern'] = 'url('.PUBLIC_WEB_PATH.'/images/patterns/'.$pattern['server'].'/'.$pattern['url'].')';
        $patternFeatures['used'] = 1;
        $patternFeatures['hashtag'] = $pattern['pattern'];
        return $patternFeatures;
    }

    public function getPatternFeaturesByHashtag($patternHashtag)
    {
        $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
        $idPattern = $patternModelDbTable->getIdPatternByHashtag($patternHashtag);
        $patternFeatures = $this->getPatternFeatures($idPattern);
        return $patternFeatures;
    }

    public function checkValidPattern($pattern)
    {
        $patterns = $this->getPatterns();
        $valid = false;
        foreach ($patterns as $patternDb){
            if ($patternDb['pattern']==$pattern){
                $valid = $patternDb['idP'];
                break;
            }
        }
        return $valid;
    }

    public function getPattern($idPattern)
    {
        $patterns = $this->getPatterns();
        foreach ($patterns as $patternDb){
            if ($patternDb['idP']==$idPattern){
                $pattern = $patternDb;
                break;
            }
        }
        return $pattern;
    }

    public function getPatternByHashtag($patternHashtag)
    {
        $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
        $pattern = $patternModelDbTable->getPatternByHashtag($patternHashtag);
        return $pattern;
    }

    public function getIdPatternByHashtag($patternHashtag)
    {
        $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
        $idPattern = $patternModelDbTable->getIdPatternByHashtag($patternHashtag);
        return $idPattern;
    }

    public function getFeaturedPatterns()
    {
        $cache = My_Functions::getCache();
        $featuredPatterns = $cache->load('featured_patterns');
        if ($featuredPatterns === false) {
            $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
            $featuredPatterns = $patternModelDbTable->getFeaturedPatterns();
            $cache->save($featuredPatterns,'featured_patterns');
        }
        return $featuredPatterns;
    }

    public function getPatterns()
    {
        $cache = My_Functions::getCache();
        $patterns = $cache->load('patterns');
        if ($patterns === false) {
            $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
            $patterns = $patternModelDbTable->getPatterns();
            $cache->save($patterns,'patterns');
        }
        return $patterns;
    }

    // LIMITED (API Feature)

    public function getLimitedFeaturedPatterns($numResults)
    {
        $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
        $limitedFeaturedPatterns = $patternModelDbTable->getLimitedFeaturedPatterns($numResults);
        return $limitedFeaturedPatterns;
    }

    public function getLimitedPatterns($numResults)
    {
        $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
        $limitedPatterns = $patternModelDbTable->getLimitedPatterns($numResults);
        return $limitedPatterns;
    }

    public function getPatternCredits()
    {
        $patternModelDbTable = new Gzaas_Model_DbTable_Pattern();
        $patternCredits = $patternModelDbTable->getPatternCredits();
        return $patternCredits;
    }


}