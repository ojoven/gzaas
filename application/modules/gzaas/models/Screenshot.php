<?php

class Gzaas_Model_Screenshot {
	
	const WIDTH = 1024;
	const HEIGHT = 600;

	
	/** Create Screenshot **/
	public function createScreenshotGzaas($urlKey) {
		
		$pathToScript = APPLICATION_PATH . '/bin/screenshot.sh';
		$params = $this->_getParamsScreenshot($urlKey);
		$paramsAsArgs = implode(" ", $params);
		// we must create a script that not only creates the screenshot but that it uploads it to Amazon S3, too.
		$script = "sh " . $pathToScript . " " . $paramsAsArgs . " > /dev/null 2>&1 &";
		// TODO Maybe we should retrieve results from the script or something?
		exec($script);
		
	}
	
	/** Upload to Amazon **/
	public function uploadScreenshotToAmazon($urlKey) {
		
		$filePath = APPLICATION_PATH . '/tmp/' . $urlKey . '.jpg';
		$remoteImagePath = $urlKey . '.jpg';
		$bucket = "gzaas";
		$contentType = "image/jpeg";
		$cache = true;
		
		My_AmazonFunctions::uploadToS3($filePath,$remoteImagePath,$bucket,$contentType,$cache);
		
		// Let's remove the photo once uploaded
		unlink($filePath);
		
	}
	
	private function _getParamsScreenshot($urlKey) {
		
		$pathToApplication = APPLICATION_PATH;
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$baseUrl = $request->getScheme() . '://' . $request->getHttpHost();
		
		$params = array(
			$urlKey,
			$baseUrl,
			$pathToApplication,
			self::WIDTH,
			self::HEIGHT
		);
		
		return $params;
	} 
	
}
