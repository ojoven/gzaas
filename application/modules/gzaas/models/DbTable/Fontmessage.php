<?php

class Gzaas_Model_DbTable_Fontmessage extends Zend_Db_Table_Abstract {

	protected $_name = 'font_message';

	public function addFontMessage($idF,$idM) {

		$newFontMessage = array (
			'idF' => $idF,
			'idM' => $idM
		);
		$this->insert($newFontMessage);
	}

	public function getIdFontFromMessage($idMessage) {

		$columns = "idF";
		$table = $this->_name;
		$condition = "idM = :idM";
		$data = array('idM'=>$idMessage);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idFont = $this->_db->fetchOne($query,$data);
		return $idFont;
	}

}