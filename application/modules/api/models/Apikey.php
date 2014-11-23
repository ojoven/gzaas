<?php

class Api_Model_Apikey extends Zend_Db_Table_Abstract
{
    protected $_name = 'apikeys';

    /* Add a new ApiKey */
  	public function addApiKey($apiKey)
    {
		$newApiKey = array(
		'apiKey' => $apiKey['apiKey'],
		'web' => $apiKey['web'],
		'contact' => $apiKey['contact'],
		'date' => $apiKey['date'],
		'deleted' => $apiKey['deleted']
		);
    	$this->insert($newApiKey);
    }

    /* Get valid ApiKey */
  	public function validApiKey($apiKey)
    {
    	$apiKey = $this->_db->fetchOne("SELECT apiKey FROM apikeys where apiKey = '".$apiKey."'");
		return $apiKey;
    }


}