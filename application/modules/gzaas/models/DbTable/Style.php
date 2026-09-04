<?php

class Gzaas_Model_DbTable_Style extends Zend_Db_Table_Abstract {

	protected $_name = 'styles';
	protected $_fields = 'idS, style, description, font, color, backColor, shadow, pattern, designer, urlBackDesigner, featured';

	public function getFeaturedStyles() {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "publicUse = 1 AND featured = 1";
		$orderMethod = "description ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$featuredStyles = $stmt->fetchAll();

		return $featuredStyles;
	}

	public function getStyles() {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "publicUse = 1";
		$orderMethod = "description ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$styles = $stmt->fetchAll();

		return $styles;
	}

	// LIMITED (API calls)
	public function getLimitedFeaturedStyles($numResults) {

		$select = $this->_db->select()
			->from($this->_name, array_map('trim', explode(',', $this->_fields)))
			->where('publicUse = ?', 1)
			->where('featured = ?', 1)
			->order('description ASC')
			->limit($this->_normalizeLimit($numResults));

		return $this->_db->fetchAll($select);
	}

	public function getLimitedStyles($numResults) {

		$select = $this->_db->select()
			->from($this->_name, array_map('trim', explode(',', $this->_fields)))
			->where('publicUse = ?', 1)
			->order('description ASC')
			->limit($this->_normalizeLimit($numResults));

		return $this->_db->fetchAll($select);
	}

	private function _normalizeLimit($numResults) {
		return max(1, min(100, (int) $numResults));
	}

	public function getIdStyles() {

		$columns = "idS";
		$table = $this->_name;
		$condition = "publicUse = 1";
		$orderMethod = "style ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$idStyles = $this->_db->fetchCol($query);

		return $idStyles;
	}

	public function isValidStyle($style) {

		$columns = "idS";
		$table = $this->_name;
		$condition = "style = :style";
		$data = array('style'=>$style);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idStyle = $this->_db->fetchOne($query,$data);

		return $idStyle;
	}

}
