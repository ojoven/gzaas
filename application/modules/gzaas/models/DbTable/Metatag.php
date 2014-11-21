<?php

class Gzaas_Model_DbTable_Metatag extends Zend_Db_Table_Abstract
{
	protected $_name = 'menu_options';

	public function getMetaTags()
	{
		$columns = "idM, metaTag, description";
		$table = $this->_name;
		$orderMethod = "idM ASC";

		$query = "SELECT ".$columns." FROM ".$table." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$metaTags = $stmt->fetchAll();

		return $metaTags;
	}

}