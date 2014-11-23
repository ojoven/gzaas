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

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "featured = 1";
		$orderMethod = "pattern ASC";
		$limit = "0,".$numResults;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod.' LIMIT '.$limit;
		$stmt = $this->_db->query($query);
		$limitedFeaturedPatterns = $stmt->fetchAll();

		return $limitedFeaturedPatterns;
	}


	public function getLimitedPatterns($numResults) {

		$columns = $this->_fields;
		$table = $this->_name;
		$orderMethod = "pattern ASC";
		$limit = "0,".$numResults;

		$query = "SELECT ".$columns." FROM ".$table." ORDER BY ".$orderMethod.' LIMIT '.$limit;
		$stmt = $this->_db->query($query);
		$limitedPatterns = $stmt->fetchAll();

		return $limitedPatterns;
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