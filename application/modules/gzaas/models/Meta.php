<?php

class Gzaas_Model_Meta {

	public function getFacebookMeta($urlKey) {

		$facebookMeta = "";
		$metaproperty = '<meta property="';
		$metacontent = 'content="';
		$facebookMeta = $facebookMeta.$metaproperty.'og:type'.'" '.$metacontent.'website'.'"/>';
		$facebookMeta = $facebookMeta.$metaproperty.'og:url'.'" '.$metacontent.'http://gzaas.com/'.$urlKey.'"/>';
		$facebookMeta = $facebookMeta.$metaproperty.'og:image'.'" '.$metacontent.'http://gzaas.com/images/gzaas_logo.png'.'"/>';
		$facebookMeta = $facebookMeta.$metaproperty.'og:site_name'.'" '.$metacontent.'gzaas!'.'"/>';
		$facebookMeta = $facebookMeta.$metaproperty.'fb:admins'.'" '.$metacontent.'578973745'.'"/>';

		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description.gzaas'));
		$facebookMeta = $facebookMeta.$metaproperty.'og:description'.'" '.$metacontent.$metaDescription.'"/>';

		return $facebookMeta;
	}

}