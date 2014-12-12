<?php

class Gzaas_Model_Message {

	const NOT_FROM_API = 0;
	const IN_BLACK_LIST = 0;
	const DEFAULT_VISIBILITY = 1;
	const DEFAULT_STATUS_ACTIVE = 1;

	public function addMessage($message,$visibility) {

		$defaultMessageParameters = $this->_getDefaultMessageParameters();
		$exploreModel = new Gzaas_Model_Explore();
		$urlKey = $exploreModel->createNewUrlKey();
		$newMessage = array(
			'message'      => $message,
			'visibility'   => $visibility,
			'urlKey'       => $urlKey,
			'date'         => $defaultMessageParameters['date'],
			'ip'           => $defaultMessageParameters['ip'],
			'languageUser' => $defaultMessageParameters['languageUser'],
			'api'          => $defaultMessageParameters['api'],
			'status'	   => $defaultMessageParameters['status']
		);
		$messageModelDbTable = new Gzaas_Model_DbTable_Message();
		$idMessage = $messageModelDbTable->addMessage($newMessage);

		$response['idMessage'] = $idMessage;
		$response['urlKey'] = $urlKey;

		return $response;
	}

	public function getMessage($urlKey) {

		$messageModelDbTable = new Gzaas_Model_DbTable_Message();
		$message = $messageModelDbTable->getMessage($urlKey);
		$message = $this->_addLineBreaksMessage($message);
		return $message;
	}

	public function getRandomUrlKey() {

		$messageModelDbTable = new Gzaas_Model_DbTable_Message();
		$numTotalMessages = $messageModelDbTable->getNumTotalMessages();
		$randomPosition = rand(0,$numTotalMessages-1);

		$urlKey = $messageModelDbTable->getRandomUrlKey($randomPosition);
		return $urlKey;
	}

	/** GET ALL **/
	public function getAllUrlKeysMessages() {
		$messageModelDbTable = new Gzaas_Model_DbTable_Message();
		$urlKeys = $messageModelDbTable->getAllUrlKeysMessages();
		return $urlKeys;

	}

	private function _getDefaultMessageParameters() {

		$defaultMessageParameters['ip'] = $_SERVER['REMOTE_ADDR'];
		$defaultMessageParameters['languageUser'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
		$defaultMessageParameters['date'] = date("Y-m-d H:i:s");
		$defaultMessageParameters['api'] = self::NOT_FROM_API;
		$defaultMessageParameters['visibility'] = self::DEFAULT_VISIBILITY;
		$defaultMessageParameters['status'] = self::DEFAULT_STATUS_ACTIVE;

		return $defaultMessageParameters;
	}

	private function _addLineBreaksMessage($message) {

		if ($message) {
			$message['message'] = str_replace("\n","<br>",$message['message']);
		}
		return $message;
	}

}