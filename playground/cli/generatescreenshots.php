<?php
/** Script to generate screenshots for current gzaases **/
require_once('../../application/bin/loadzend.php');

$messageModel = new Gzaas_Model_Message();
$urlKeys = $messageModel->getAllUrlKeysMessages();
echo count($urlKeys);