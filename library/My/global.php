<?php

function __($string) {

	$translate = Zend_Registry::get('Zend_Translate');
	$translated = $translate->translate($string);
	return $translated;

}