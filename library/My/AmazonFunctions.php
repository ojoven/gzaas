<?php
require_once 'Zend/Service/Amazon/S3.php';

class My_AmazonFunctions {

	const BUCKET_NAME = "gzaas";

	const PATH_TO_AMAZON = "http://gzaas.s3.amazonaws.com/";
	const JPEG_CONTENT_TYPE = "image/jpeg";
	const PUBLIC_READ_ACL = "public-read";
	
	/** Upload images to S3 **/
	public function uploadToS3($localImagePath,$remoteImagePath,$bucket,$contentType,$cache = true) {

		$client = self::_getClient();

		$params = array(
			Zend_Service_Amazon_S3::S3_ACL_HEADER => Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ,
			Zend_Service_Amazon_S3::S3_CONTENT_TYPE_HEADER => $contentType
		);

		if ($cache) { $params['CacheControl'] = "max-age=172800"; }

		try {
			
			$result = $client->putObject($bucket.'/'.$remoteImagePath, file_get_contents($localImagePath),$params);
			return $result;

		} catch (Exception $e) {
			return false;
		}

	}

	public function getImagesBucket($bucket) {

		$objects = array();
		$s3 = self::_getClient();
		
		$list = $s3->getObjectsByBucket($bucket);

		foreach ($list as $name) {
			$object = $s3->getObject($bucket.'/'.$name);
			array_push($objects,$object);
		}

		return $objects;

	}

	public function deleteObject($params) {

		$client = self::_getClient();
		$result = $client->removeObject($params['bucket'] . '/' . $params['sourceKey']);

	}

	private static function _getClient() {

		// We retrieve the keys from application.ini
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$amazon = $config->getOption('amazon');
		$client = new Zend_Service_Amazon_S3($amazon['key'], $amazon['secret']);
		return $client;
	}

}

?>