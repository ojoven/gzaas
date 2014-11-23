<?php
// Caution: This Controller needs an important refactor
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Api_ApiController extends Zend_Controller_Action {

	function init() {


    }

	public function getapikeyAction()
	{
		$parameters = $this->_getAllParams();
		$web = $parameters['web'];
		$web = htmlspecialchars($web, ENT_NOQUOTES);
		$web = stripSlashes($web);
		$contact = $parameters['contact'];
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
			$buffer = '{
					"valid":'.$valid.',
					"apiKey":"'.$apiKey.'"
					}';
			echo $buffer;
			}

		catch (exception $e) {
			$valid = 0;
			$errorMessage = 'Service unavailabe. Try again later.';
			$buffer = '{
					"valid":'.$valid.',
					"errorMessage":"'.$apiKey.'"
					}';
			echo $buffer;
		}

		// no renderizar (AJAX)

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
	}


	public function fontsAction()
	{
	    // API call JSON FORMAT
		//header('Cache-Control: no-cache, must-revalidate');
		//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

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
	        }
	        else {
	            $fonts = $fontModel->getFeaturedFonts();
	        }
	    }
		else {
			if (!$nowFeatured) {
	            $fonts = $fontModel->getLimitedFonts($numResults);
	        }
	        else {
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

	$buffer = json_encode($fontsSintaxed);
	echo $buffer;
	$this->getResponse()->setHttpResponseCode(200);

	$this->_helper->viewRenderer->setNoRender();
	$this->_helper->layout->disableLayout();

	}



	public function patternsAction()
	{
	    // API call JSON FORMAT
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

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
	        }
	        else {
	            $patterns = $patternModel->getFeaturedPatterns();
	        }
	    }
		else {
			if (!$nowFeatured) {
	            $patterns = $patternModel->getLimitedPatterns($numResults);
	        }
	        else {
	            $patterns = $patternModel->getLimitedFeaturedPatterns($numResults);
	        }
	    }

	$patternsSintaxed = new ArrayObject();

	// We return with the sintaxis of the API Documentation

	// idP, pattern, url, idServer, server, description, designer, urlDesigner1, urlDesigner2, featured FROM gs_mt_04 ORDER BY pattern ASC LIMIT 0,".$numResults);
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

	$buffer = json_encode($patternsSintaxed);
	echo $buffer;
	$this->getResponse()->setHttpResponseCode(200);

	$this->_helper->viewRenderer->setNoRender();
	$this->_helper->layout->disableLayout();

	}


	public function stylesAction()
	{
	    // API call JSON FORMAT
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

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
	        }
	        else {
	            $styles = $styleModel->getFeaturedStyles();
	        }
	    }
		else {
			if (!$nowFeatured) {
	            $styles = $styleModel->getLimitedStyles($numResults);
	        }
	        else {
	            $styles = $styleModel->getLimitedFeaturedStyles($numResults);
	        }
	    }

	$stylesSintaxed = new ArrayObject();

	// We return with the sintaxis of the API Documentation
	$fontModel = new Gzaas_Model_DbTable_Font();
	$patternModel = new Gzaas_Model_DbTable_Pattern();

	// idP, pattern, url, idServer, server, description, designer, urlDesigner1, urlDesigner2, featured FROM gs_mt_04 ORDER BY pattern ASC LIMIT 0,".$numResults);
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

	$buffer = json_encode($stylesSintaxed);
	echo $buffer;
	$this->getResponse()->setHttpResponseCode(200);

	$this->_helper->viewRenderer->setNoRender();
	$this->_helper->layout->disableLayout();

	}

	public function writeAction()
	{
	    // API call JSON FORMAT
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

	    // GET / POST
	    $_SERVER['REQUEST_METHOD'] = "POST";

	    // We take the different parameter options
	    $parameters = $this->_getAllParams();

		$apiKey = (isset($parameters['apikey'])) ? $parameters['apikey'] : false;

		$apiKeyModel = new Api_Model_Apikey();
		$validApiKey = $apiKeyModel->validApiKey($apiKey);

		if ($validApiKey) {

			$textmessage = $parameters['message'];
			$font = $parameters['font'];
			$color = $parameters['color'];
			$backcolor = $parameters['backcolor'];
			$backpattern = $parameters['backpattern'];
			$shadows = $parameters['shadows'];
			$style = $parameters['style'];
			$visibilityText = $parameters['visibility'];
			$launcher = $parameters['launcher'];

			// Variable para controlar si mensaje vacío

			// Estilo

			$idF = false;
			$validColor = false;
			$validBackColor = false;
			$idP = false;
			$validShadows = false;
			$idS = false;

			$inblacklist = 0;

			// Sharing options

			if ($visibilityText!=0) {
				$visibility = 1; // gzaas público por defecto
				if (trim($launcher)!=''){
					$launcher = stripSlashes($launcher);
					$launcher = htmlspecialchars($launcher, ENT_NOQUOTES);

					// Controlamos tamaño máximo de Launcher
					if (strlen($launcher)>LAUNCHER_MAX_SIZE) {
						$launcher = substr($launcher,0,LAUNCHER_MAX_SIZE);
					}
				}
				else {
					$launcher = '';
				}
			}
			else {
				$visibility = 0;
			}


			/* Limpiamos y validamos */
			$valid = 'true';

			// N�mero de l�neas, sobrepasa
			$arrayNewLines = explode("\n", $textmessage);
			if (count($arrayNewLines)>GZAAS_MAX_NEW_LINES+1){
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->translate('error.max.lines'));
				$valid = 'false';
				$this->getResponse()->setHttpResponseCode(400);
			}

			// Controlamos tama�o m�ximo de String
			if (strlen($textmessage)>GZAAS_MAX_SIZE) {
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->translate('error.max.size'));
				$valid = 'false';
				$this->getResponse()->setHttpResponseCode(400);
			}

			// Si mensaje vac�o, �qu� haremos?
			if (trim($textmessage)==''){
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->translate('error.gzaas.blank'));
				$valid = 'false';
				$this->getResponse()->setHttpResponseCode(400);
			}

			// Si igual color de fondo y de fuente
			if (($color!='') && ($color==$backcolor)){
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->translate('error.same.color'));
				$valid = 'false';
				$this->getResponse()->setHttpResponseCode(400);
			}

			// Si no ha seleccionado ning�n estilo
			if (($font=='') && ($color=='') && ($backcolor=='') && ($backpattern=='') && ($style=='')){
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->translate('error.no.style'));
				$valid = 'false';
				$this->getResponse()->setHttpResponseCode(400);
			}


			// Pasa las validaciones

			if ($valid=='true') {

				// Comprobamos IP + date.
				$date = date("Y-m-d H:i:s");
				$ip = $_SERVER['REMOTE_ADDR'];



				// En gzaas[message] guardaremos el mensaje SIN los hashtags v�lidos (estilizado)
				$gzaas['message'] = htmlspecialchars($textmessage, ENT_NOQUOTES);


				// Generamos la key para la URL

				$repeated = 1;
				$messageModel = new Gzaas_Model_DbTable_Message();

				// Lista de palabras que no deben coincidir con la urlKey generada
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

				// Vamos a guardar el languageCode del navegador del usuario (como aprox. al languageCode del gzaas creado)
				// M�s adelante nos plantearemos utilizar la API de Google Translator para conocer el languageCode real
				$languageUser = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);

				// Variable que indica si estamos utilizando la API
				$api = 1;

				// Comienza la inserci�n en BD

				$db = Zend_Registry::get('db');
				$db->beginTransaction();


				try{

				// Si v�lido: A�adimos a BD

				// Tabla Message

				$newMessage = array(
				'message' => $gzaas['message'],
				'visibility' => $visibility,
				'inblacklist' => $inblacklist,
				'urlKey' => $urlKey,
				'date' => $date,
				'ip' => $ip,
				'languageUser' => $languageUser,
				'api' => $api
				);

				$idMessage = $messageModel->addMessage($newMessage);


				// Asociamos el mensaje a la API creada
				$apiKeyMessageModel = new Api_Model_Apikeymessage();
				$apiKeyMessageModel->addApiKeyMessage($apiKey,$idMessage);


				// Tabla Message Launcher

				if ($launcher!=''){
					$launcherModel = new Gzaas_Model_DbTable_Launcher();
					$launcherModel->addMessageLauncher($idMessage, $launcher);
				}

				// Tablas Hashtag Message

				// Font

				if ($font!=''){
					// Si el usuario ha seleccionado una fuente.
					$fontModel = new Gzaas_Model_DbTable_Font();
					$idF = $fontModel->validFont($font);
					// Si fuente v�lida.
					if ($idF){
						$fontMessageModel = new Gzaas_Model_DbTable_Fontmessage();
						$fontMessageModel->addFontMessage($idF,$idMessage);
					}
				}

				// Color

				if ($color!=''){
					// Si el usuario ha seleccionado una fuente.
					preg_match(HEX_REGEXP, $color, $validColor); // expresi�n regular, �es color v�lido? /
					// Si color v�lido.
					if ($validColor){
						$colorMessageModel = new Gzaas_Model_DbTable_Colormessage();
						$colorMessageModel->addColorMessage($color,$idMessage);
					}
				}

				// Background Color

				if ($backcolor!=''){
					// Si el usuario ha seleccionado una fuente.
					preg_match(HEX_REGEXP, $backcolor, $validBackcolor); // expresi�n regular, �es color v�lido? /
					// Si color v�lido.
					if ($validBackcolor){
						$backcolorMessageModel = new Gzaas_Model_DbTable_Backcolormessage();
						$backcolorMessageModel->addBackColorMessage($backcolor,$idMessage);
					}
				}

				// Background Pattern

				if ($backpattern!=''){
					// Si el usuario ha seleccionado un back pattern.
					$patternModel = new Gzaas_Model_DbTable_Pattern();
					$idP = $patternModel->validPattern($backpattern);
					// Si pattern v�lida.
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

						// Validaci�n par�metros text-shadow
						// Par�metro offset horizontal
						if (intval($shadowExplode[0])<=MAX_HOR_VER_SHADOW) {
							preg_match(HOR_VER_SHAD_REGEXP, $shadowExplode[0], $validHorShad);
						}
						else {
							$validHorShad = false;
						}
						// Par�metro offset vertical
						if (intval($shadowExplode[1])<=MAX_HOR_VER_SHADOW) {
							preg_match(HOR_VER_SHAD_REGEXP, $shadowExplode[1], $validVerShad);
						}
						else {
							$validVerShad = false;
						}
						// Par�metro blur-radius
						if (intval($shadowExplode[2])<=MAX_BLUR_SHADOW) {
							preg_match(BLUR_SHAD_REGEXP, $shadowExplode[2], $validBlurShad);
						}
						else {
							$validBlurShad = false;
						}
						// Par�metro color
						preg_match(HEX_WITH_HASH_REGEXP, $shadowExplode[3], $validColorShad);

						// Comprobamos si valida todos los par�metros
						if ($validHorShad && $validVerShad && $validBlurShad && $validColorShad) {
							$shadowMessageModel = new Gzaas_Model_DbTable_Shadowmessage();
							$validShadow = 	$shadowExplode[0].' '.$shadowExplode[1].' '.$shadowExplode[2].' '.$shadowExplode[3];
							$shadowMessageModel->addShadowMessage($validShadow,$idMessage);
						}
					}
				}


				// Style

				if ($style!=''){
					// Si el usuario ha seleccionado un estilo.
					$styleModel = new Gzaas_Model_DbTable_Style();
					$idS = $styleModel->validStyle($style);
					// Si estilo v�lido
					if ($idS){
						$styleMessageModel = new Gzaas_Model_DbTable_Stylemessage();
						$styleMessageModel->addStyleMessage($idS,$idMessage);
					}
				}

				// Controlamos que los par�metros sean v�lidos (a nivel global)
				if ((!$idF) && (!$validColor) && (!$validBackColor) && (!$idP) && (!$idS)) {
					$db->rollback();
					$translate = Zend_Registry::get('Zend_Translate');
					$errorMessage = utf8_encode($translate->translate('error.no.style'));
					$buffer = '{
						"valid":"false",
						"errorMessage":"'.$errorMessage.'"
						}';
					echo $buffer;
				}

				else {

					/* TODITO SALI� BIEN */

					// Montamos la URL del gzaas

					$urlGs = 'http://gzaas.com/'.$urlKey;
					$response['valid'] = $valid;
					$response['urlGzaas'] = $urlGs;
					$response['urlKey'] = $urlKey;
					$response['visibility'] = $visibility;
					echo $response;

					$this->getResponse()->setHttpResponseCode(201);


					// Fin de transacci�n. Todo OK.
					$db->commit();

					}
				}

				catch (exception $e){
				$db->rollback();
				$translate = Zend_Registry::get('Zend_Translate');
				$errorMessage = utf8_encode($translate->translate('error.newgs.exception'));
				$response['valid'] = false;
				$response['errorMessage'] = $errorMessage;
				echo $response;
				$this->getResponse()->setHttpResponseCode(503);
				}
			}

			else {
				$response['valid'] = false;
				$response['errorMessage'] = $errorMessage;
				echo $response;
			}
		}

		else {
			$errorMessage = 'Oops! Not a valid Api Key. Get one valid at http://gzaas.com/project/api-embed/api-key/';
			$response['valid'] = false;
			$response['errorMessage'] = $errorMessage;
			echo $response;
			$this->getResponse()->setHttpResponseCode(400);
		}

		// no renderizar

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

	}



	private function setDefaultFeatures()
	{
		$features['fontFamily'] = 'Helvetica, Arial';
		$features['color'] = '#444';
		$features['backgroundColor'] = '#fcfcfc';
		$features['backgroundImage'] = '';
		$features['textShadow'] ='';

		return $features;
	}


	private function setRobotVisibility($visibility)
	{
		if ($visibility==0){
			$this->view->headMeta()->setName('robots', 'NOINDEX,NOFOLLOW');
		}
		else {
			$this->view->headMeta()->setName('robots', 'INDEX,FOLLOW');
		}
	}


	/* FUNCIONES PRIVADAS */

	private function keyGenerator($minlength, $maxlength, $useupper, $usespecial, $usenumbers)
	{
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


	/* FUTURIBLES */

	public function gzaasesAction()
	{
	    // API call

	    // We take the different parameter options

	    $parameters = $this->_getAllParams();
	    $gzaasIncludes = $parameters['gzaasIncludes'];
	    $launcherIncluded = $parameters['launcherIncluded'];
	    $launcherIncludes = $parameters['launcherIncludes'];
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