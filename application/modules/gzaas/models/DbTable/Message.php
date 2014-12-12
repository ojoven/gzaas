<?php

class Gzaas_Model_DbTable_Message extends Zend_Db_Table_Abstract {

	protected $_name = 'messages';
	protected $_fields = 'id, message, urlKey, visibility, languageUser, date';

	public function addMessage($message) {

		$newMessage = array (
			'message' => stripSlashes($message['message']),
			'visibility' => $message['visibility'],
			'urlKey' => $message['urlKey'],
			'date' => $message['date'],
			'ip' => $message['ip'],
			'languageUser' => $message['languageUser'],
			'api' => $message['api'],
			'status' => $message['status']
		);
		$this->insert($newMessage);
		$idMessage = $this->_db->lastInsertId();
		return $idMessage;
	}

	public function getMessage($urlKey) {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "urlKey = :urlKey";
		$data = array('urlKey' => $urlKey);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$message = $this->_db->fetchRow($query,$data);

		return $message;
	}

	public function getNumTotalMessages() {

		$columns = "COUNT(id) AS numTotalMessages";
		$table = $this->_name;
		$condition = "visibility = 1";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$numTotalMessages = $this->_db->fetchOne($query);

		return $numTotalMessages;
	}

	public function getRandomUrlKey($randomPosition) {

		$columns = "urlKey";
		$table = $this->_name;
		$condition = "visibility = 1";
		$limit = $randomPosition.",1";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." LIMIT ".$limit;
		$urlKey = $this->_db->fetchOne($query);

		return $urlKey;
	}

	public function getAllUrlKeysMessages() {

		$columns = "urlKey";
		$table = $this->_name;
		$condition = "status = 1";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$urlKeys = $this->_db->fetchCol($query);

		return $urlKeys;

	}

}