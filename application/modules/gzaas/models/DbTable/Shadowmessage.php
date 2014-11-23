<?php

class Gzaas_Model_DbTable_Shadowmessage extends Zend_Db_Table_Abstract {

	protected $_name = 'shadow_message';

	public function addShadowMessage($shadow,$idM) {

		$newShadowMessage = array (
			'shadow' => $shadow,
			'idM' => $idM
		);
		$this->insert($newShadowMessage);
	}

	public function getShadowsFromMessage($idMessage) {

		$columns = "shadow";
		$table = $this->_name;
		$condition = "idM = :idM";
		$data = array('idM'=>$idMessage);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$shadows = $this->_db->fetchOne($query,$data);
		return $shadows;
	}


}