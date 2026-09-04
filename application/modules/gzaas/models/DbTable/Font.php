<?php

class Gzaas_Model_DbTable_Font extends Zend_Db_Table_Abstract {

	protected $_name = 'fonts';
	protected $_fields = 'idF, font, fontFamily, fontFace, stylesheet, cssScreenshot, size, fontServer, description, designer, urlDesigner1, urlDesigner2, featured';

	public function getFeaturedFonts() {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "inUse = 1 AND featured = 1";
		$orderMethod = "font ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$featuredFonts = $stmt->fetchAll();

		return $featuredFonts;
	}

	public function getFonts() {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "inUse = 1";
		$orderMethod = "font ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$fonts = $stmt->fetchAll();

		return $fonts;
	}

	public function getFontByHashtag($fontHashtag) {

		$columns = $this->_fields;
		$table = $this->_name;
		$condition = "inUse = 1 AND font = :font";
		$data = array('font'=>$fontHashtag);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idFont = $this->_db->fetchRow($query,$data);

		return $idFont;
	}

	public function getIdFontByHashtag($fontHashtag) {

		$columns = "idF";
		$table = $this->_name;
		$condition = "inUse = 1 AND font = :font";
		$data = array('font'=>$fontHashtag);

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idFont = $this->_db->fetchOne($query,$data);

		return $idFont;
	}

	// LIMITED (API Feature)
	public function getLimitedFeaturedFonts($numResults) {

		$select = $this->_db->select()
			->from($this->_name, array_map('trim', explode(',', $this->_fields)))
			->where('inUse = ?', 1)
			->where('featured = ?', 1)
			->order('font ASC')
			->limit($this->_normalizeLimit($numResults));

		return $this->_db->fetchAll($select);
	}

	public function getLimitedFonts($numResults) {

		$select = $this->_db->select()
			->from($this->_name, array_map('trim', explode(',', $this->_fields)))
			->where('inUse = ?', 1)
			->order('font ASC')
			->limit($this->_normalizeLimit($numResults));

		return $this->_db->fetchAll($select);
	}

	private function _normalizeLimit($numResults) {
		return max(1, min(100, (int) $numResults));
	}

	// FONT CREDITS (Blog / Project Credits Area)
	public function getFontCredits() {

		$columns = "fontFace, description, designer, urlDesigner1, urlDesigner2";
		$table = $this->_name;
		$condition = "inUse = 1";
		$orderMethod = "font ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$fontCredits = $stmt->fetchAll();

		return $fontCredits;
	}

	// Playground update Css Screenshots
	public function updateCssScreenshot($font) {

		$columns = "fontFace, description, designer, urlDesigner1, urlDesigner2";
		$table = $this->_name;
		$condition = "inUse = 1";
		$orderMethod = "font ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$fontCredits = $stmt->fetchAll();

		return $fontCredits;
	}

}
