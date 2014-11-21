<?php 
require_once "Zend/Controller/Action.php";
require_once "Zend/Loader.php";

class Api_EmbedController extends Zend_Controller_Action 
{ 


	function init()
    {
    	$this->_redirector = $this->_helper->getHelper('Redirector');
    	
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->baseImage = PUBLIC_WEB_PATH.'/images/';
        $this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper'); 
        $this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/style_mob.css');
        $this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/Chewy/stylesheet.css');
        // jQuery CDN Google
        $this->view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js','text/javascript');
        
		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description.gzaas'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$metaTitle = utf8_encode($translate->translate('meta.title.gzaas'));
		
		$this->_helper->layout->setLayout('mobilelayout');		
		
    	$this->view->headMeta()->setName('description', $metaDescription);
    	$this->view->headMeta()->setName('keywords', $metaKeyWords);
        
    }

	
	public function embeddedAction()
	{

		// Recogemos el id de la url
		$urlKey = $this->getRequest()->getParam("urlKey");
		$this->view->urlKey = $urlKey;
		
		/*
	    if (mobile_device_detect(true,false,true,true,true,true,true,false,false)){
			$this->_redirect('default/mobile/seegs/urlKey/'.$urlKey); 
		} */
		
		// Recogemos los datos de BD
		$messageModel = new Gzaas_Model_DbTable_DbTable_Message();
		$message = $messageModel->getMessage($urlKey);
		$idMessage = $message['id'];

		
		
		/* Estilo del mensaje */
		
		// Por defecto.
		
		$fontFaceUsed = false;
		$fontUsedSize = 1;		
	
        $features = $this->setDefaultFeatures();		


		// Flags para estilo.
		$fontUsed = 0;
		$colorUsed = 0;
		$backcolorUsed = 0;
		$patternUsed = 0;
		$shadowsUsed = 0;

		
		// Font
		$fontMessageModel = new Gzaas_Model_DbTable_Fontmessage();
		$idF = $fontMessageModel->getFontMessage($idMessage);
		
		// Si se ha definido una fuente
		if ($idF) {
			$fontModel = new Gzaas_Model_DbTable_Font();
			$font = $fontModel->getFont($idF);
			$features['fontFamily'] = $font['fontFamily'];
			if ($font['fontFace']==1){
				if ($font['fontServer']==1){
					$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css');
				}
				else if($font['fontServer']==2){
					$this->view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family='.$font['stylesheet']);
				}
				$fontFaceUsed = true; 
			}
			$fontUsedSize = $font['size'];
			$fontUsed = 1;	
		}
		
		
		// Color
		$colorMessageModel = new Gzaas_Model_DbTable_Colormessage();
		$color = $colorMessageModel->getColorMessage($idMessage);
		
		// Si se ha definido un color de fuente	
		if ($color) {
			$features['color'] = '#'.$color;
			$colorUsed = 1;
		}

		
		// Background Color
		$backcolorMessageModel = new Gzaas_Model_DbTable_Backcolormessage();
		$backcolor = $backcolorMessageModel->getBackColorMessage($idMessage);
		
		// Si se ha definido un color de fuente	
		if ($backcolor) {
			$features['backgroundColor'] = '#'.$backcolor;
			$backcolorUsed = 1;
		}	
		
		
		// Background Pattern
		$patternMessageModel = new Gzaas_Model_DbTable_Patternmessage();
		$idP = $patternMessageModel->getPatternMessage($idMessage);
		
		// Si se ha definido un pattern	
		if ($idP) {	
			$patternModel = new Gzaas_Model_DbTable_Pattern();		
			$pattern = $patternModel->getPattern($idP);
			$features['backgroundImage'] = 'url('.PUBLIC_WEB_PATH.'/images/patterns/'.$pattern['server'].'/'.$pattern['url'].')';
			$patternUsed = 1;			
		}	

		// Shadows
		$shadowMessageModel = new Gzaas_Model_DbTable_Shadowmessage();
		$shadows = $shadowMessageModel->getShadowsMessage($idMessage);
		
		// Si se han definido sombras
		if ($shadows) {
		    $stringShadows = implode(",",$shadows);
			$features['textShadow'] = $stringShadows;
			$shadowsUsed = 1;
			$loadFeatures['shadows']['hashtag'] = $stringShadows;
		}			
		
		
		
		// Rellenamos las caracter�sticas seg�n style (si existe) 
		
		$styleMessageModel = new Gzaas_Model_DbTable_Stylemessage();
		$idS = $styleMessageModel->getStyleMessage($idMessage);
		
		if ($idS){
			
			$styleModel = new Gzaas_Model_DbTable_Style();
			$style = $styleModel->getStyle($idS);
			// idHashtag, hashtag, style, font, color, backColor, shadow, pattern

			// Fuente
			// Si no hay una fuente ya asociada al mensaje, recogemos la del estilo.
			if ($fontUsed == 0) {
				$fontModel = new Gzaas_Model_DbTable_Font();
				$font = $fontModel->getFontByHashtag($style['font']);
				$features['fontFamily'] = $font['fontFamily'];
				if ($font['fontFace']==1){
					if ($font['fontServer']==1){
						$this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/'.$font['stylesheet'].'/stylesheet.css');
					}
					else if($font['fontServer']==2){
						$this->view->headLink()->appendStylesheet('//fonts.googleapis.com/css?family='.$font['stylesheet']);
					}
					$fontFaceUsed = true; 
				}
				$fontUsedSize = $font['size'];	
			}		
			
			// Color
			// Si no hay un color ya asociado al mensaje, recogemos el del estilo.
			if ($colorUsed == 0) {
				$features['color'] = '#'.$style['color'];	
			}
			
			// Background Color // Pattern
			// Si no hay un color o pattern asociado al mensaje, recogemos el del estilo.
			if (($backcolorUsed == 0) && ($patternUsed == 0)) {
				
				// Si estilo hace uso de back color
				if ($style['backColor']) {
					$features['backgroundColor'] = '#'.$style['backColor'];
				}
				
				// Si estilo hace uso de pattern
				else if ($style['pattern']){
					$patternModel = new Gzaas_Model_DbTable_Pattern();
					$pattern = $patternModel->getPatternByHashtag($style['pattern']);
					$features['backgroundImage'] = 'url('.PUBLIC_WEB_PATH.'/images/patterns/'.$pattern['server'].'/'.$pattern['url'].')';
				}

			}
	
			
		}
		

		
		// Calculamos tama�o base de fuente
		$fontSize = $this->getFontSize($message['message'],$fontUsedSize);
		$features['fontSize'] = $fontSize;
		
		// Interlineado / Espacio entre letras
		$lineHeight = $fontSize - ($fontSize/10);
		if ($fontFaceUsed){ $features['letterSpacing'] = $fontSize/40;}
		else {	$features['letterSpacing'] = $fontSize/15; 	}		
		$features['lineHeight'] = $lineHeight;
		
		
		// Guardamos en vista el estilo
		$this->view->features = $features;

		
		// Formateamos saltos de l�nea
		$message['message'] = str_replace("\n","<br>",$message['message']);
		
		// URL del mensaje
		$url = 'http://gzaas.com/'.$urlKey;
		$this->view->url = $url;
		
		
		$this->view->message = $message['message'];
		
		// Construimos mensaje para compartir en Twitter
		if (strlen($message['message']) > 109){
			$this->view->tweetText = substr($message['message'],0,106).'...';
		}
		else {
			$this->view->tweetText = $message['message'];
		}
		
		// Recogemos Launcher, si tiene
		$launcherModel = new Gzaas_Model_DbTable_Launcher();
		$launcher = $launcherModel->getMessageLauncher($idMessage);
		
		if (($launcher=='') || ($launcher==null)){
			$launcherUsed = false;
		}
		
		else {
			$launcherUsed = true;
			$this->view->launcher = $launcher;
		}
		
		$this->view->launcherUsed = $launcherUsed;
		
		// languageCode
		$languageCode = Zend_Registry::get('languageCode');
		$this->view->languageCode = $languageCode;
		$this->render();
	
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

	private function getFontSize($string,$fontUsedSize)
	{
		$numChars = strlen($string);			
		if ($numChars<=6){$fontSize = 400;}
		else if ($numChars<=20){$fontSize = 300;}
		else if ($numChars<=50){$fontSize = 150;}
		else if ($numChars<=100){$fontSize = 120;}
		else if ($numChars<=200){$fontSize = 90;}
		else if ($numChars<=300){$fontSize = 70;}
		else if ($numChars<=500){$fontSize = 60;}
		else {$fontSize = 40;}
		return $fontSize;
	}   	
	
	
}