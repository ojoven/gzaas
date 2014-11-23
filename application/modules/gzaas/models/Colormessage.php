<?php

class Gzaas_Model_Colormessage {

	public function addColorMessage($color,$idM) {

		$colorMessageModelDbTable = new Gzaas_Model_DbTable_Colormessage();
		$colorMessageModelDbTable->addColorMessage($color, $idM);
	}

	public function getColorFromMessage($idMessage) {

		$colorMessageModelDbTable = new Gzaas_Model_DbTable_Colormessage();
		$color = $colorMessageModelDbTable->getColorFromMessage($idMessage);
		return $color;
	}

}