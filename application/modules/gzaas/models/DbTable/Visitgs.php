<?php

class Gzaas_Model_DbTable_Visitgs extends Zend_Db_Table_Abstract
{
	protected $_name = 'message_visits';

	public function addVisit($visit)
	{
		$newVisit = array (
			'idM' => $visit['idM'],
			'date' => $visit['date'],
			'ip' => $visit['ip'],
			'urlFrom' => $visit['urlFrom'],
			'gsFrom' => $visit['gsFrom']
		);
		$this->insert($newVisit);
	}

}