<?php

class Gzaas_Model_DbTable_Stylemessage extends Zend_Db_Table_Abstract {

	protected $_name = 'style_message';

	public function addStyleMessage($idS,$idM) {

		$newStyleMessage = array (
			'idS' => $idS,
			'idM' => $idM
		);
		$this->insert($newStyleMessage);
	}

	public function getIdStyleFromMessage($idMessage) {

		$columns = "idS";
		$table = $this->_name;
		$condition = "idM = :idM";
		$data = array('idM'=>$idMessage);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idStyle = $this->_db->fetchOne($query);
		return $idStyle;
	}

}