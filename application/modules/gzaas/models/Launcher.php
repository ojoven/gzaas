<?php

class Gzaas_Model_Launcher
{

	public function addMessageLauncher($idM, $launcher)
	{
		$launcherModelDbTable = new Gzaas_Model_DbTable_Launcher();
		$launcherModelDbTable->addMessageLauncher($idM, $launcher);
	}

	public function getMessageLauncher($idMessage)
	{
		$launcher['used'] = false;
	}

}