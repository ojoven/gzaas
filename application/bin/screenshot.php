<?php
require_once('loadzend.php');

$urlKey = $argv[1];
$screenshotModel = new Gzaas_Model_Screenshot();
$screenshotModel->uploadScreenshotToAmazon($urlKey);
