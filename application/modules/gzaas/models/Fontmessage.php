<?php

class Gzaas_Model_Fontmessage {

	public function addFontMessage($idFont,$idMessage)
	{
		$fontMessageModelDbTable = new Gzaas_Model_DbTable_Fontmessage();
		$fontMessageModelDbTable->addFontMessage($idFont,$idMessage);
	}

	public function getIdFontFromMessage($idMessage) {
		$fontMessageModelDbTable = new Gzaas_Model_DbTable_Fontmessage();
		$idFont = $fontMessageModelDbTable->getIdFontFromMessage($idMessage);
		return $idFont;
	}

}