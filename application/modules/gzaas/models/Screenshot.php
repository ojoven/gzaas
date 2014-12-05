<?php

class Gzaas_Model_Screenshot {

	public function createScreenshotGzaas($urlKey) {
		
		$pathToScript = APPLICATION_PATH . '/bin/screenshot.sh';
		$params = $this->_getParamsScreenshot($urlKey);
		$paramsAsArgs = implode(" ", $params);
		// we must create a script that not only creates the screenshot but that it uploads it to Amazon S3, too.
		$script = "sh " . $pathToScript . " " . $paramsAsArgs . " > /dev/null 2>&1 &";
		// TODO Maybe we should retrieve results from the script or something?
		exec($script);
		
	}
	
	private function _getParamsScreenshot($urlKey) {
		
		$pathToImage = APPLICATION_PATH . '/tmp/' . $urlKey . '.png';
		$pathToPhantomJs = APPLICATION_PATH . '/bin/screenshot.js';
		$params = array(
			$urlKey,
			'http://gzaas.local.host/' . $urlKey . '?screenshot=image',
			$pathToImage,
			$pathToPhantomJs,
			1024,
			600
		);
		return $params;
	} 
	
}
