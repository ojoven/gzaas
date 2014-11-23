<?php

class Gzaas_Model_Shadowmessage {

	public function addShadowMessage($shadow,$idM) {

		$shadowMessageModelDbTable = new Gzaas_Model_DbTable_Shadowmessage();
		$shadowMessageModelDbTable->addShadowMessage($shadow, $idM);
	}

	public function getShadowsFromMessage($idMessage) {

		$shadowMessageModelDbTable = new Gzaas_Model_DbTable_Shadowmessage();
		$shadows = $shadowMessageModelDbTable->getShadowsFromMessage($idMessage);
		return $shadows;
	}

}