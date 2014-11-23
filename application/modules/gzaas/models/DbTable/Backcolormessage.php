<?php

class Gzaas_Model_DbTable_Backcolormessage extends Zend_Db_Table_Abstract {

	protected $_name = 'back_color_message';

	public function addBackColorMessage($backColor,$idM) {

		$newBackColorMessage = array (
			'backColor' => $backColor,
			'idM' => $idM
		);
		$this->insert($newBackColorMessage);
	}

	public function getBackColorFromMessage($idMessage) {

		$columns = "backcolor";
		$table = $this->_name;
		$condition = "idM = :idM";
		$data = array('idM' => $idMessage);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$backColor = $this->_db->fetchOne($query,$data);

		return $backColor;
	}

}