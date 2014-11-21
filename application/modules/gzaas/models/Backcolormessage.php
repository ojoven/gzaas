<?php

class Gzaas_Model_Backcolormessage
{

	public function addBackColorMessage($backColor,$idM)
	{
		$backColorMessageModelDbTable = new Gzaas_Model_DbTable_Backcolormessage();
		$backColorMessageModelDbTable->addBackColorMessage($backColor, $idM);
	}

	public function getBackColorFromMessage($idMessage)
	{
		$backColorMessageModelDbTable = new Gzaas_Model_DbTable_Backcolormessage();
		$backColor = $backColorMessageModelDbTable->getBackColorFromMessage($idMessage);
		return $backColor;
	}

}