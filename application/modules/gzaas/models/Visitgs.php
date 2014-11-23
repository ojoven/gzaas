<?php

class Gzaas_Model_Visitgs {

	const URL_RESUME = "gzaas.com";

	public function addVisit($idMessage) {

		$ipUser = $_SERVER['REMOTE_ADDR'];
		if (isset($_SERVER['HTTP_REFERER'])) {
			$urlFrom = $_SERVER['HTTP_REFERER'];
		} else {
			$urlFrom = null;
		}
		$date = date("Y-m-d H:i:s");
		$gsFrom = $this->_isVisitInternalFromGzaas($urlFrom);

		$newVisit = array (
			'idM' => $idMessage,
			'date' => $date,
			'ip' => $ipUser,
			'urlFrom' => $urlFrom,
			'gsFrom' => $gsFrom
		);
		$visitGsModelDbTable = new Gzaas_Model_DbTable_Visitgs();
		$visitGsModelDbTable->addVisit($newVisit);
	}

	private function _isVisitInternalFromGzaas($urlFrom) {

		// Does the user come from outside Gzaas?
		$findme = self::URL_RESUME;
		$pos = strpos($urlFrom, $findme);
		if ($pos === false) {
			$gsFrom = 0;
		} else {
			$gsFrom = 1;
		}
		return $gsFrom;
	}

}