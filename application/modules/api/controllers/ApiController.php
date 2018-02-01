<?php
// Caution: This Controller needs an important refactor
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Api_ApiController extends Zend_Controller_Action {

	function init() {

	}

	/** GET API KEY **/
	public function getapikeyAction() {

		$this->_setJsonHeader();

		$parameters = $this->_getAllParams();
		$web = (isset($parameters['web'])) ? $parameters['web'] : false;
		$web = htmlspecialchars($web, ENT_NOQUOTES);
		$web = stripSlashes($web);
		$contact = (isset($parameters['contact'])) ? $parameters['contact'] : false;
		$contact = htmlspecialchars($contact, ENT_NOQUOTES);
		$contact = stripSlashes($contact);
		$date = date("Y-m-d H:i:s");
		$deleted = 0;
		$apiKey = $this->keyGenerator(10,12,1,0,1);

		$apiKeyComplete = array(
			'apiKey' => $apiKey,
			'web' => $web,
			'contact' => $contact,
			'date' => $date,
			'deleted' => $deleted
		);

		try {
			$apiModel = new Api_Model_Apikey();
			$apiModel->addApiKey($apiKeyComplete);
			$valid = 1;
			$response['valid'] = true;
			$response['apiKey'] = $apiKey;
			echo json_encode($response);
		}

		catch (exception $e) {
			$errorMessage = 'Service unavailabe. Please try again later.';

			$response['valid'] = false;
			$response['errorMessage'] = $errorMessage;
			echo json_encode($response);
		}

		// don't render (AJAX)
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	}

	/** GET FONTS **/
	public function fontsAction() {

		$this->_setJsonHeader();

		// GET / POST
		$method = $_SERVER['REQUEST_METHOD'];

		// We take the different parameter options
		$parameters = $this->_getAllParams();
		$numResults = (isset($parameters['numResults'])) ? $parameters['numResults'] : false;
		$nowFeatured = (isset($parameters['nowFeatured'])) ? $parameters['nowFeatured'] : false;

		$fontModel = new Gzaas_Model_DbTable_Font();
		if (!$numResults) {
			if (!$nowFeatured) {
				$fonts = $fontModel->getFonts();
			} else {
				$fonts = $fontModel->getFeaturedFonts();
			}
		} else {
			if (!$nowFeatured) {
				$fonts = $fontModel->getLimitedFonts($numResults);
			} else {
				$fonts = $fontModel->getLimitedFeaturedFonts($numResults);
			}
		}

		$fontsSintaxed = new ArrayObject();

		// We return with the sintaxis of the API Documentation
		foreach ($fonts as $font) {
			$sintaxisFont = new ArrayObject();
			$sintaxisFont['id'] = (int)$font['idF'];
			$sintaxisFont['hashtag'] = $font['font'];
			$sintaxisFont['description'] = $font['description'];
			$sintaxisFont['fontFace'] = (int)$font['fontFace'];
			switch ($font['fontServer']) {
				case 1:
					// Font Squirrel / Gzaas server
					$sintaxisFont['stylesheet'] = PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css';
					break;
				case 2:
					// Google Webfonts
					$sintaxisFont['stylesheet'] = 'http://fonts.googleapis.com/css?family='.$font['stylesheet'];
					break;
				default:
					$sintaxisFont['stylesheet'] = '';
			}

			$sintaxisFont['fontFamily'] = $font['fontFamily'];
			$sintaxisFont['fontServer'] = (int)$font['fontServer'];
			$sintaxisFont['designer'] = $font['designer'];
			$sintaxisFont['urlDesigner1'] = $font['urlDesigner1'];
			$sintaxisFont['urlDesigner2'] = $font['urlDesigner2'];
			$sintaxisFont['nowFeatured'] = (int)$font['featured'];

			$fontsSintaxed->append($sintaxisFont);
		}

		$response = json_encode($fontsSintaxed);
		echo $response;
		$this->getResponse()->setHttpResponseCode(200);
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	}



	public function patternsAction() {

		$this->_setJsonHeader();

		// GET / POST
		$method = $_SERVER['REQUEST_METHOD'];

		// We take the different parameter options
		$parameters = $this->_getAllParams();
		$numResults = (isset($parameters['numResults'])) ? $parameters['numResults'] : false;
		$nowFeatured = (isset($parameters['nowFeatured'])) ? $parameters['nowFeatured'] : false;

		$patternModel = new Gzaas_Model_DbTable_Pattern();
		if (!$numResults) {
			if (!$nowFeatured) {
				$patterns = $patternModel->getPatterns();
			} else {
				$patterns = $patternModel->getFeaturedPatterns();
			}
		} else {
			if (!$nowFeatured) {
				$patterns = $patternModel->getLimitedPatterns($numResults);
			} else {
				$patterns = $patternModel->getLimitedFeaturedPatterns($numResults);
			}
		}

		$patternsSintaxed = new ArrayObject();

		// We return with the sintaxis of the API Documentation
		foreach ($patterns as $pattern) {
			$sintaxisPattern = new ArrayObject();
			$sintaxisPattern['id'] = (int)$pattern['idP'];
			$sintaxisPattern['hashtag'] = $pattern['pattern'];
			$sintaxisPattern['description'] = $pattern['description'];
			$sintaxisPattern['url'] = "http://gzaas.com/images/patterns/".$pattern['server']."/".$pattern['url'];
			$sintaxisPattern['server'] = $pattern['server'];
			$sintaxisPattern['designer'] = $pattern['designer'];
			$sintaxisPattern['urlDesigner1'] = $pattern['urlDesigner1'];
			$sintaxisPattern['urlDesigner2'] = $pattern['urlDesigner2'];
			$sintaxisPattern['nowFeatured'] = (int)$pattern['featured'];

			$patternsSintaxed->append($sintaxisPattern);
		}

		$response = json_encode($patternsSintaxed);
		echo $response;
		$this->getResponse()->setHttpResponseCode(200);

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

	}


	public function stylesAction()
	{
		$this->_setJsonHeader();

		// GET / POST
		$method = $_SERVER['REQUEST_METHOD'];

		// We take the different parameter options
		$parameters = $this->_getAllParams();
		$numResults = (isset($parameters['numResults'])) ? $parameters['numResults'] : false;
		$nowFeatured = (isset($parameters['nowFeatured'])) ? $parameters['nowFeatured'] : false;

		$styleModel = new Gzaas_Model_DbTable_Style();
		if (!$numResults) {
			if (!$nowFeatured) {
				$styles = $styleModel->getStyles();
			} else {
				$styles = $styleModel->getFeaturedStyles();
			}
		} else {
			if (!$nowFeatured) {
				$styles = $styleModel->getLimitedStyles($numResults);
			} else {
				$styles = $styleModel->getLimitedFeaturedStyles($numResults);
			}
		}

		$stylesSintaxed = new ArrayObject();

		// We return with the sintaxis of the API Documentation
		$fontModel = new Gzaas_Model_DbTable_Font();
		$patternModel = new Gzaas_Model_DbTable_Pattern();

		foreach ($styles as $style) {
			$sintaxisStyle = new ArrayObject();
			$sintaxisStyle['id'] = (int)$style['idS'];
			$sintaxisStyle['hashtag'] = $style['style'];
			$sintaxisStyle['description'] = $style['description'];

			// Font
			$font = $fontModel->getFontByHashtag($style['font']);
			$sintaxisFont = new ArrayObject();
			$sintaxisFont['id'] = (int)$font['idF'];
			$sintaxisFont['hashtag'] = $font['font'];
			$sintaxisFont['description'] = $font['description'];
			$sintaxisFont['fontFace'] = (int)$font['fontFace'];
			switch ($font['fontServer']) {
				case 1:
					// Font Squirrel / Gzaas server
					$sintaxisFont['stylesheet'] = PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css';
					break;
				case 2:
					// Google Webfonts
					$sintaxisFont['stylesheet'] = 'http://fonts.googleapis.com/css?family='.$font['stylesheet'];
					break;
				default:
					$sintaxisFont['stylesheet'] = '';
			}

			$sintaxisFont['fontFamily'] = $font['fontFamily'];
			$sintaxisFont['fontServer'] = (int)$font['fontServer'];
			$sintaxisFont['designer'] = $font['designer'];
			$sintaxisFont['urlDesigner1'] = $font['urlDesigner1'];
			$sintaxisFont['urlDesigner2'] = $font['urlDesigner2'];
			$sintaxisFont['nowFeatured'] = (int)$font['featured'];

			$sintaxisStyle['font'] = $sintaxisFont;


			// Pattern
			$pattern = $patternModel->getPatternByHashtag($style['pattern']);
			$sintaxisPattern = new ArrayObject();
			$sintaxisPattern['id'] = (int)$pattern['idP'];
			$sintaxisPattern['hashtag'] = $pattern['pattern'];
			$sintaxisPattern['description'] = $pattern['description'];
			if ($pattern['url']) {
				$sintaxisPattern['url'] = "http://gzaas.com/images/patterns/".$pattern['server']."/".$pattern['url'];
			}
			else {
				$sintaxisPattern['url'] = null;
			}
			$sintaxisPattern['server'] = $pattern['server'];
			$sintaxisPattern['designer'] = $pattern['designer'];
			$sintaxisPattern['urlDesigner1'] = $pattern['urlDesigner1'];
			$sintaxisPattern['urlDesigner2'] = $pattern['urlDesigner2'];
			$sintaxisPattern['nowFeatured'] = (int)$pattern['featured'];

			$sintaxisStyle['pattern'] = $sintaxisPattern;
			$sintaxisStyle['color'] = $style['color'];
			$sintaxisStyle['backcolor'] = $style['backColor'];
			$sintaxisStyle['shadow'] = $style['shadow'];
			$sintaxisStyle['designer'] = $style['designer'];
			$sintaxisStyle['urlDesigner'] = $style['urlBackDesigner'];
			$sintaxisStyle['nowFeatured'] = (int)$style['featured'];

			$stylesSintaxed->append($sintaxisStyle);
		}

		$response = json_encode($stylesSintaxed);
		echo $response;
		$this->getResponse()->setHttpResponseCode(200);

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

	}

	public function writeAction() {

		$this->_setJsonHeader();

		// GET / POST
		$_SERVER['REQUEST_METHOD'] = "POST";

		// We take the different parameter options
		$parameters = $this->_getAllParams();

		$apiKey = (isset($parameters['apikey'])) ? $parameters['apikey'] : false;

		$apiKeyModel = new Api_Model_Apikey();
		$validApiKey = $apiKeyModel->validApiKey($apiKey);

		if ($validApiKey) {

			$textmessage = (isset($parameters['message'])) ? $parameters['message'] : false;
			$font = (isset($parameters['font'])) ? $parameters['font'] : false;
			$color = (isset($parameters['color'])) ? $parameters['color'] : false;
			$backcolor = (isset($parameters['backcolor'])) ? $parameters['backcolor'] : false;
			$backpattern = (isset($parameters['backpattern'])) ? $parameters['backpattern'] : false;
			$shadows = (isset($parameters['shadows'])) ? $parameters['shadows'] : false;
			$style = (isset($parameters['style'])) ? $parameters['style'] : false;
			$visibilityText = (isset($parameters['visibility'])) ? $parameters['visibility'] : false;

			// Vars to check if empty fields
			$idF = false;
			$validColor = false;
			$validBackColor = false;
			$idP = false;
			$validShadows = false;
			$idS = false;

			// Sharing options

			if ($visibilityText!=0) {
				$visibility = 1; // gzaas public by default
			} else {
				$visibility = 0;
			}


			// We clean and validate
			$valid = true;

			// Number of lines overflows
			$arrayNewLines = explode("\n", $textmessage);
			if (count($arrayNewLines)>GZAAS_MAX_NEW_LINES+1){
				$errorMessage = __("Too many lines, I'm afraid");
				$valid = false;
				$this->getResponse()->setHttpResponseCode(400);
			}

			// String max size
			if (strlen($textmessage)>GZAAS_MAX_SIZE) {
				$errorMessage = __("You've used more characters than allowed");
				$valid = false;
				$this->getResponse()->setHttpResponseCode(400);
			}

			// Empty message
			if (trim($textmessage)==''){
				$errorMessage = __("Nothing to say?");
				$valid = false;
				$this->getResponse()->setHttpResponseCode(400);
			}

			// Back and font color are the same
			if (($color!='') && ($color==$backcolor)){
				$errorMessage = __("You can't use the same color for the font and the background");
				$valid = false;
				$this->getResponse()->setHttpResponseCode(400);
			}

			// No styles selected
			if (($font=='') && ($color=='') && ($backcolor=='') && ($backpattern=='') && ($style=='')){
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = __("You must give the gzaas some style");
				$valid = false;
				$this->getResponse()->setHttpResponseCode(400);
			}


			// Is it valid?
			if ($valid) {

				// We retrieve IP and date
				$date = date("Y-m-d H:i:s");
				$ip = $_SERVER['REMOTE_ADDR'];

				$gzaas['message'] = htmlspecialchars($textmessage, ENT_NOQUOTES);

				// We generate the URL
				// TODO: Why not call the generate URL from Explore / Gzaas Model?
				$repeated = 1;
				$messageModel = new Gzaas_Model_DbTable_Message();
				$keyWords = 'gzaas, gzaases, gzaascom, gzs, gzaasit, gzscom, blog, help, about, wtf, ownd, pwnd, fuck'.
				'ojoven, garcia, mikel, torres, bruno, juan, sebas, barberio'.
				'api, embed, preview, explore, embedded, font, fonts, style, styles, pattern, patterns';

				while ($repeated == 1){
					$urlKey = $this->keyGenerator(4,7,1,0,1);
					$exists = $messageModel->getMessage($urlKey);
					if ((($exists == null) || ($exists == false)) && (!strlen(strstr($keyWords,$urlKey))>0)) {
						$repeated = 0;
					}
				}

				// We're saving user's browser's language
				$languageUser = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);

				// This gzaas has been created via API, yes
				$api = 1;

				// Let's insert the data in DB
				$db = Zend_Registry::get('db');
				$db->beginTransaction();

				try{

					// Message Table
					$newMessage = array(
						'message' => $gzaas['message'],
						'visibility' => $visibility,
						'urlKey' => $urlKey,
						'date' => $date,
						'ip' => $ip,
						'languageUser' => $languageUser,
						'api' => $api,
						'status' => 1
					);

					$idMessage = $messageModel->addMessage($newMessage);

					// Message to APIKey
					$apiKeyMessageModel = new Api_Model_Apikeymessage();
					$apiKeyMessageModel->addApiKeyMessage($apiKey,$idMessage);


					// Font
					if ($font!=''){
						$fontModel = new Gzaas_Model_DbTable_Font();
						$idF = $fontModel->validFont($font);
						if ($idF){
							$fontMessageModel = new Gzaas_Model_DbTable_Fontmessage();
							$fontMessageModel->addFontMessage($idF,$idMessage);
						}
					}

					// Color
					if ($color!=''){
						preg_match(HEX_REGEXP, $color, $validColor); // regexp, is valid color?
						if ($validColor){
							$colorMessageModel = new Gzaas_Model_DbTable_Colormessage();
							$colorMessageModel->addColorMessage($color,$idMessage);
						}
					}

					// Background Color
					if ($backcolor!=''){
						preg_match(HEX_REGEXP, $backcolor, $validBackcolor); // regexp, is valid color?
						if ($validBackcolor){
							$backcolorMessageModel = new Gzaas_Model_DbTable_Backcolormessage();
							$backcolorMessageModel->addBackColorMessage($backcolor,$idMessage);
						}
					}

					// Background Pattern
					if ($backpattern!=''){
						$patternModel = new Gzaas_Model_DbTable_Pattern();
						$idP = $patternModel->validPattern($backpattern);
						if ($idP){
							$patternMessageModel = new Gzaas_Model_DbTable_Patternmessage();
							$patternMessageModel->addPatternMessage($idP,$idMessage);
						}
					}

					// Shadows
					if ($shadows!=''){
						$arrayShadows = explode(",", $shadows);
						foreach ($arrayShadows as $shadow) {
							$shadowExplode = explode(" ", trim($shadow));

							// Text shadow parameters validation
							// Horizontal Offset
							if (intval($shadowExplode[0])<=MAX_HOR_VER_SHADOW) {
								preg_match(HOR_VER_SHAD_REGEXP, $shadowExplode[0], $validHorShad);
							} else {
								$validHorShad = false;
							}
							// Vertical Offset
							if (intval($shadowExplode[1])<=MAX_HOR_VER_SHADOW) {
								preg_match(HOR_VER_SHAD_REGEXP, $shadowExplode[1], $validVerShad);
							} else {
								$validVerShad = false;
							}
							// BlurRadius
							if (intval($shadowExplode[2])<=MAX_BLUR_SHADOW) {
								preg_match(BLUR_SHAD_REGEXP, $shadowExplode[2], $validBlurShad);
							} else {
								$validBlurShad = false;
							}
							// Color Parameter
							preg_match(HEX_WITH_HASH_REGEXP, $shadowExplode[3], $validColorShad);

							// Valid for all shadow parameters?
							if ($validHorShad && $validVerShad && $validBlurShad && $validColorShad) {
								$shadowMessageModel = new Gzaas_Model_DbTable_Shadowmessage();
								$validShadow = 	$shadowExplode[0].' '.$shadowExplode[1].' '.$shadowExplode[2].' '.$shadowExplode[3];
								$shadowMessageModel->addShadowMessage($validShadow,$idMessage);
							}
						}
					}


					// Style
					if ($style!=''){
						$styleModel = new Gzaas_Model_DbTable_Style();
						$idS = $styleModel->isValidStyle($style);
						if ($idS){
							$styleMessageModel = new Gzaas_Model_DbTable_Stylemessage();
							$styleMessageModel->addStyleMessage($idS,$idMessage);
						}
					}

					// Valid parameters (Style || Color + BackColor...)
					if ((!$idF) && (!$validColor) && (!$validBackColor) && (!$idP) && (!$idS)) {
						$db->rollback();
						$translate = Zend_Registry::get('Zend_Translate');
						$errorMessage = __("You must give the gzaas some style");
						$response['valid'] = false;
						$response['errorMessage'] = $errorMessage;
						echo json_encode($buffer);
					}

					else {

						// Everything went OK

						// We build the Gzaas URL
						$urlGs = 'http://gzaas.com/'.$urlKey;
						$response['valid'] = $valid;
						$response['urlGzaas'] = $urlGs;
						$response['urlKey'] = $urlKey;
						$response['visibility'] = $visibility;
						echo json_encode($response);

						$this->getResponse()->setHttpResponseCode(201);

						// Transaction commit
						$db->commit();
					}
				}

				catch (exception $e){
					$db->rollback();
					$translate = Zend_Registry::get('Zend_Translate');
					$errorMessage = __("Something went wrong");
					$response['valid'] = false;
					$response['errorMessage'] = $errorMessage;
					echo json_encode($response);
					$this->getResponse()->setHttpResponseCode(503);
				}
			}

			else {
				$response['valid'] = false;
				$response['errorMessage'] = $errorMessage;
				echo json_encode($response);
			}
		}

		else {
			$errorMessage = 'Oops! Not a valid Api Key. Get one valid at http://gzaas.com/project/api-embed/api-key/';
			$response['valid'] = false;
			$response['errorMessage'] = $errorMessage;
			echo json_encode($response);
			$this->getResponse()->setHttpResponseCode(400);
		}

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

	}


	private function setDefaultFeatures() {

		$features['fontFamily'] = 'Helvetica, Arial';
		$features['color'] = '#444';
		$features['backgroundColor'] = '#fcfcfc';
		$features['backgroundImage'] = '';
		$features['textShadow'] ='';

		return $features;
	}


	private function setRobotVisibility($visibility) {

		if ($visibility==0){
			$this->view->headMeta()->setName('robots', 'NOINDEX,NOFOLLOW');
		}
		else {
			$this->view->headMeta()->setName('robots', 'INDEX,FOLLOW');
		}
	}


	/* PRIVATE FUNCTIONS */
	private function _setJsonHeader() {

		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
	}

	private function keyGenerator($minlength, $maxlength, $useupper, $usespecial, $usenumbers) {

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


	/* FOR THE FUTURE */
	public function gzaasesAction() {

		// We take the different parameter options
		$parameters = $this->_getAllParams();
		$gzaasIncludes = $parameters['gzaasIncludes'];
		$fonts = $parameters['fonts'];
		$colors = $parameters['colors'];
		$backcolors = $parameters['backcolors'];
		$backpatterns = $parameters['backpatterns'];
		$styles = $parameters['styles'];
		$numResults = $parameters['numResults'];
		$orderCol = $parameters['orderCol'];
		$sortBy = $parameters['sortBy'];
		$format = $parameters['format'];
		$jsonCallback = $parameters['jsonCallback'];

	}


}