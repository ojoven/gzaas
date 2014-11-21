<?php

class Gzaas_Model_DbTable_Style extends Zend_Db_Table_Abstract
{
	protected $_name = 'styles';

	public function getFeaturedStyles()
	{
		$columns = "idS, style, description, font, color, backColor, shadow, pattern, designer, urlBackDesigner, featured";
		$table = $this->_name;
		$condition = "publicUse = 1 AND featured = 1";
		$orderMethod = "description ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$featuredStyles = $stmt->fetchAll();

		return $featuredStyles;
	}

	public function getStyles()
	{
		$columns = "idS, style, description, font, color, backColor, shadow, pattern, designer, urlBackDesigner, featured";
		$table = $this->_name;
		$condition = "publicUse = 1";
		$orderMethod = "description ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$stmt = $this->_db->query($query);
		$styles = $stmt->fetchAll();

		return $styles;
	}

	// LIMITED (API calls)

	public function getLimitedFeaturedStyles($numResults)
	{
		$columns = "idS, style, description, font, color, backColor, shadow, pattern, designer, urlBackDesigner, featured";
		$table = $this->_name;
		$condition = "publicUse = 1 AND featured = 1";
		$orderMethod = "description ASC";
		$limit = "0,".$numResults;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod.' LIMIT '.$limit;
		$stmt = $this->_db->query($query);
		$limitedFeaturedStyles = $stmt->fetchAll();

		return $limitedFeaturedStyles;
	}

	public function getLimitedStyles($numResults)
	{
		$columns = "idS, style, description, font, color, backColor, shadow, pattern, designer, urlBackDesigner, featured";
		$table = $this->_name;
		$condition = "publicUse = 1";
		$orderMethod = "description ASC";
		$limit = "0,".$numResults;

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod.' LIMIT '.$limit;
		$stmt = $this->_db->query($query);
		$limitedStyles = $stmt->fetchAll();

		return $limitedStyles;
	}

	public function getIdStyles()
	{
		$columns = "idS";
		$table = $this->_name;
		$condition = "publicUse = 1";
		$orderMethod = "style ASC";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." ORDER BY ".$orderMethod;
		$idStyles = $this->_db->fetchCol($query);

		return $idStyles;
	}

}