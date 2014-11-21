<?php

class Gzaas_Model_DbTable_Font extends Zend_Db_Table_Abstract
{
	protected $_name = 'fonts';

	public function getFeaturedFonts()
	{
		$columns = "idF, font, fontFamily, fontFace, stylesheet, size, fontServer, description, designer, urlDesigner1, urlDesigner2, featured";
		$table = $this->_name;
		$condition = "inUse = 1 AND featured = 1";
		$orderMethod = "font ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$featuredFonts = $stmt->fetchAll();

		return $featuredFonts;
	}

	public function getFonts()
	{
		$columns = "idF, font, fontFamily, fontFace, stylesheet, size, fontServer, description, designer, urlDesigner1, urlDesigner2, featured";
		$table = $this->_name;
		$condition = "inUse = 1";
		$orderMethod = "font ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$fonts = $stmt->fetchAll();

		return $fonts;
	}

	public function getIdFontByHashtag($fontHashtag)
	{
		$columns = "idF";
		$table = $this->_name;
		$condition = "inUse = 1 AND font = '".$fontHashtag."'";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$idFont = $this->_db->fetchOne($query);

		return $idFont;
	}

	// LIMITED (API Feature)

	public function getLimitedFeaturedFonts($numResults)
	{
		$columns = "idF, font, fontFamily, fontFace, stylesheet, size, fontServer, description, designer, urlDesigner1, urlDesigner2, featured";
		$table = $this->_name;
		$condition = "inUse = 1 AND featured = 1";
		$orderMethod = "font ASC";
		$limit = "0,".$numResults;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod.' LIMIT '.$limit;
		$stmt = $this->_db->query($query);
		$limitedFeaturedFonts = $stmt->fetchAll();

		return $limitedFeaturedFonts;
	}


	public function getLimitedFonts($numResults)
	{
		$columns = "idF, font, fontFamily, fontFace, stylesheet, size, fontServer, description, designer, urlDesigner1, urlDesigner2, featured";
		$table = $this->_name;
		$condition = "inUse = 1";
		$orderMethod = "font ASC";
		$limit = "0,".$numResults;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod.' LIMIT '.$limit;
		$stmt = $this->_db->query($query);
		$limitedFonts = $stmt->fetchAll();

		return $limitedFonts;
	}

	// FONT CREDITS (Blog / Project Credits Area)

	public function getFontCredits()
	{
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