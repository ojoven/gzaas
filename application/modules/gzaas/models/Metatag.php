<?php

class Gzaas_Model_Metatag {

	public function getMetaTags() {

		$metaTagModelDbTable = new Gzaas_Model_DbTable_Metatag();
		$metaTags = $metaTagModelDbTable->getMetaTags();
		return $metaTags;
	}

	public function getMenuOptions() {

		$metaTagModel = new Gzaas_Model_Metatag();
		$metaTags = $metaTagModel->getMetaTags();

		$menuOptions = new ArrayObject();
		for ($i=0; $i < count($metaTags); $i++) {
			$newMenuOption = new ArrayObject();
			$infoMenuOption = array(
				'metaTag' => $metaTags[$i]['metaTag'],
				'idM' => $metaTags[$i]['idM'],
				'description' => $metaTags[$i]['description']
			);
			$newMenuOption->append($infoMenuOption);
			switch ($metaTags[$i]['idM']) {
				case 1:
					$fontModel = new Gzaas_Model_Font();
					$featuredOptions = $fontModel->getFeaturedFonts();
					break;
				case 4:
					$patternModel = new Gzaas_Model_Pattern();
					$featuredOptions = $patternModel->getFeaturedPatterns();
					break;
				case 50:
					$styleModel = new Gzaas_Model_Style();
					$featuredOptions = $styleModel->getFeaturedStyles();
					break;
			}
			$newMenuOption->append($featuredOptions);
			$newMenuOption->append(count($featuredOptions));

			$menuOptions->append($newMenuOption);
		}

		$this->_orderMenuAsAppearInTheInterface($menuOptions);
		return $menuOptions;
	}

	private function _orderMenuAsAppearInTheInterface(&$menuOptions) {

		$arrayMenuOptions = (array)$menuOptions;
		$styles = array_pop($arrayMenuOptions);
		array_unshift($arrayMenuOptions, $styles);

		$menuOptions = new ArrayObject($arrayMenuOptions);
		return $menuOptions;
	}

}