<?php

class Gzaas_Model_DbTable_Pattern extends Zend_Db_Table_Abstract {

	protected $_name = 'patterns';
	protected $_fields = 'idP, pattern, url, idServer, server, description, designer, urlDesigner1, urlDesigner2, featured';

	public function getPatternByHashtag($patternHashtag) {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "pattern = :pattern";
		$data = array('pattern'=>$patternHashtag);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$pattern = $this->_db->fetchRow($query,$data);

		return $pattern;
	}

	public function getFeaturedPatterns() {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "featured = 1";
		$orderMethod = "pattern ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$featuredPatterns = $stmt->fetchAll();

		return $featuredPatterns;
	}


	public function getPatterns() {

		$columns = $this->_fields;
		$table = $this->_name;
		$orderMethod = "pattern ASC";

		$query = "SELECT ".$columns." FROM ".$table." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$patterns = $stmt->fetchAll();

		return $patterns;
	}

	public function getIdPatternByHashtag($patternHashtag) {

		$columns = "idP";
		$table = $this->_name;
		$condition = "pattern = :pattern";
		$data = array('pattern'=>$patternHashtag);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idPattern = $this->_db->fetchOne($query,$data);

		return $idPattern;
	}


	// LIMITED (API Feature)
	public function getLimitedFeaturedPatterns($numResults) {

		$select = $this->_db->select()
			->from($this->_name, array_map('trim', explode(',', $this->_fields)))
			->where('featured = ?', 1)
			->order('pattern ASC')
			->limit($this->_normalizeLimit($numResults));

		return $this->_db->fetchAll($select);
	}


	public function getLimitedPatterns($numResults) {

		$select = $this->_db->select()
			->from($this->_name, array_map('trim', explode(',', $this->_fields)))
			->order('pattern ASC')
			->limit($this->_normalizeLimit($numResults));

		return $this->_db->fetchAll($select);
	}

	private function _normalizeLimit($numResults) {
		return max(1, min(100, (int) $numResults));
	}

	public function getPatternCredits() {

		$columns = "idP, pattern, url, idServer, server, description, designer, urlDesigner1, urlDesigner2";
		$table = $this->_name;
		$orderMethod = "pattern ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$patternCredits = $stmt->fetchAll();

		return $patternCredits;
	}


}
