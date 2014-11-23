<?php

class Gzaas_Model_Stylemessage {

	public function addStyleMessage($idS,$idM) {

		$styleMessageModelDbTable = new Gzaas_Model_DbTable_Stylemessage();
		$styleMessageModelDbTable->addStyleMessage($idS, $idM);
	}

	public function getIdStyleFromMessage($idMessage) {

		$styleMessageModelDbTable = new Gzaas_Model_DbTable_Stylemessage();
		$idStyle = $styleMessageModelDbTable->getIdStyleFromMessage($idMessage);
		return $idStyle;
	}

}