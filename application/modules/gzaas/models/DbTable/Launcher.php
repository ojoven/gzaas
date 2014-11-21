<?php

class Gzaas_Model_DbTable_Launcher extends Zend_Db_Table_Abstract
{
	protected $_name = 'launchers';


	public function addMessageLauncher($idM, $launcher)
	{
		$newMessageLauncher = array (
			'idM' => $idM,
			'launcher' => $launcher
		);
		$this->insert($newMessageLauncher);
	}

	public function getMessageLauncher($idMessage)
	{
		$columns = "launcher";
		$table = $this->_name;
		$condition = "idM = ".$idMessage;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$launcher = $this->_db->fetchOne($query);
		return $launcher;
	}



}