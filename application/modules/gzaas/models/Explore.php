<?php

class Gzaas_Model_Explore {

	// Random explore
	public function getRandomUrl() {

		$randomUrlKey = $this->_getRandomUrlKey();
		$randomUrl = URL_BASE.$randomUrlKey;
		return $randomUrl;
	}

	private function _getRandomUrlKey() {

		$messageModelDbTable = new Gzaas_Model_DbTable_Message();
		$numTotalMessages = $messageModelDbTable->getNumTotalMessages();
		$randomPosition = rand(0,$numTotalMessages-1);

		$urlKey = $messageModelDbTable->getRandomUrlKey($randomPosition);
		return $urlKey;
	}

	// New gzaas
	public function createNewUrlKey() {

		$repeated = true;
		$messageModel = new Gzaas_Model_Message();

		$gzaasProtectedWords = 'gzaas, gzaases, gzaascom, gzs, gzaasit, gzscom, blog, help, about, wtf, ownd, pwnd, fuck, ' .
								'ojoven, garcia, mikel, torres, bruno, juan, sebas, barberio, gonzalo, ayuso, webfont, ' .
								'api, embed, preview, explore, embedded, font, fonts, style, styles, pattern, patterns';

		while ($repeated) {
			$urlKey = $this->_keyGenerator(4, 7, 1, 0, 1);
			$previouslyUsedUrlKey = $messageModel->getMessage($urlKey);
			if ((!$previouslyUsedUrlKey) && (!strlen(strstr($gzaasProtectedWords, $urlKey)) > 0)) {
				$repeated = false;
			}
		}

		return $urlKey;
	}

	private function _keyGenerator($minlength, $maxlength, $useupper, $usespecial, $usenumbers) {

		$key = '';
		$charset = "abcdefghijklmnopqrstuvwxyz";
		if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		if ($usenumbers) $charset .= "0123456789";
		if ($usespecial) $charset .= "~@#$%^*()_+-={}|]["; // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";
		if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
		else $length = mt_rand ($minlength, $maxlength);
		for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
		return $key;
	}

}