<?php

class Api_Model_Apikeymessage extends Zend_Db_Table_Abstract {

	protected $_name = 'apikey_message';

	/* Add a new ApiKey */
	public function addApiKeyMessage($apiKey,$idMessage) {

		$newApiKeyMessage = array(
			'apiKey' => $apiKey,
			'idMessage' => $idMessage
		);

		$this->insert($newApiKeyMessage);
	}

}