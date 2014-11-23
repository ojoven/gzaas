<?php

class Gzaas_Model_Patternmessage {

	public function addPatternMessage($idPattern,$idMessage) {

		$patternMessageModelDbTable = new Gzaas_Model_DbTable_Patternmessage();
		$patternMessageModelDbTable->addPatternMessage($idPattern, $idMessage);
	}

	public function getIdPatternFromMessage($idMessage) {

		$patternMessageModelDbTable = new Gzaas_Model_DbTable_Patternmessage();
		$idPattern = $patternMessageModelDbTable->getIdPatternFromMessage($idMessage);
		return $idPattern;
	}

}