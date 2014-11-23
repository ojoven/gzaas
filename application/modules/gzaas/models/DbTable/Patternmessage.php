<?php

class Gzaas_Model_DbTable_Patternmessage extends Zend_Db_Table_Abstract {

	protected $_name = 'pattern_message';

	public function addPatternMessage($idPattern,$idMessage) {

		$newPatternMessage = array (
			'idP' => $idPattern,
			'idM' => $idMessage
		);
		$this->insert($newPatternMessage);
	}

	public function getIdPatternFromMessage($idMessage) {

		$columns = "idP";
		$table = $this->_name;
		$condition = "idM = :idM";
		$data = array('idM'=>$idMessage);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idPattern = $this->_db->fetchOne($query,$data);
		return $idPattern;
	}

}