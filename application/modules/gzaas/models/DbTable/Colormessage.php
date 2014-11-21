<?php

class Gzaas_Model_DbTable_Colormessage extends Zend_Db_Table_Abstract
{
	protected $_name = 'color_message';

	public function addColorMessage($color,$idM)
	{
		$newColorMessage = array (
			'color' => $color,
			'idM' => $idM
		);
		$this->insert($newColorMessage);
	}

	public function getColorFromMessage($idMessage)
	{
		$columns = "color";
		$table = $this->_name;
		$condition = "idM = ".$idMessage;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$color = $this->_db->fetchOne($query);

		return $color;
	}


}