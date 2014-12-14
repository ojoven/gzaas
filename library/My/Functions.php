<?php
class My_Functions {

	public static function getVariableFromArrayOrNullIfIndexIsNotSet($array,$index) {

		if (isset($array[$index])) {
			return $array[$index];
		} else {
			return null;
		}
	}

	public static function getCache() {

		$frontendOptions = array(
			'lifeTime' => NULL,
			'automatic_serialization' => true
		);
		$backendOptions = array('cacheDir' => './tmp/');
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		return $cache;
	}

	public static function curl($url) {

		$ch = curl_init();
		$curlConfig = array(
			CURLOPT_URL            => $url,
			CURLOPT_POST           => false,
			CURLOPT_RETURNTRANSFER => true,
		);
		curl_setopt_array($ch, $curlConfig);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;

	}

	public static function log($message, $priority = Zend_Log::INFO) {

		$logger = Zend_Registry::get('logger');
		$logger->log($message, $priority);

	}

	public static function getConfigValue($key,$index = false) {

		global $application;
		$config = $application->getBootstrap();
		$value = $config->getOption($key);

		$value = ($index && isset($value[$index])) ? $value[$index] : $value;

		return $value;
	}

}