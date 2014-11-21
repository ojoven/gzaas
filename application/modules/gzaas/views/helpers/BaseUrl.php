<?php
/**
 * Zend Framework Tutorial
 * 
 * Este tutorial tiene un enfoque pragmatico, lo cual indica una amplia cantidad
 * de ejemplos. Este material forma parte del Wikibook en español para ZF.
 * 
 * @author		Mario Garcia
 * @copyright	Copyright (c) 2006-2008 Oh!Studio Media Solutions (http://www.ohstudio.com.ar)
 * @license		http://www.php.net/license/3_0.txt
 */


class Zend_View_Helper_BaseUrl
{
	
    function baseUrl()
    {
        $fc = Zend_Controller_Front::getInstance();
        $request = $fc->getRequest();
        return $request->getBaseUrl();
    }
}
