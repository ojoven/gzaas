<?php
class My_Routers
{
	public function __construct()
	{
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();


		//gzaas - UrlKey
		$routeGs = new Zend_Controller_Router_Route_Regex(
			'(.+)',
			array(
				'module' => 'gzaas',
				'controller' => 'gzaas',
				'action'     => 'seegs'
			),
			array(
				1 => 'urlKey'
			),
			'%s'
		);
		$router->addRoute('gzaas', $routeGs);


		//gzaas - Embedded
		$routeEmbedded = new Zend_Controller_Router_Route_Regex(
			'embedded/(.+)',
			array(
				'module' => 'api',
				'controller' => 'embed',
				'action'     => 'embedded'
			),
			array(
				1 => 'urlKey'
			),
			'embedded/%s'
		);
		$router->addRoute('embedded', $routeEmbedded);

		//gzaas - NewGS
		$routeNewGs = new Zend_Controller_Router_Route_Regex(
			'gzaas/newgs',
			array(
				'module' => 'gzaas',
				'controller' => 'gzaas',
				'action'     => 'newgs'
			),
			array(
				1 => 'textmessage'
			),
			'%s'
		);
		$router->addRoute('newGzaas', $routeNewGs);

		//gzaas - Preview
		$routePreview = new Zend_Controller_Router_Route_Regex(
			'preview/preview',
			array(
				'module' => 'gzaas',
				'controller' => 'preview',
				'action'     => 'preview'
			),
			array(
				1 => 'gs_form'
			),
			'preview/%s'
		);
		$router->addRoute('preview', $routePreview);


		/*********************/
		//gzaas - Route Parse

		$routeParse = new Zend_Controller_Router_Route_Static('parsemessages',
			array('module' => 'default','controller' => 'index', 'action' => 'parsemessages')
		);
		$router->addRoute('parse', $routeParse);

		/*********************/


		//gzaas - Tour
		$routeTour = new Zend_Controller_Router_Route_Regex(
			'tour/(\d+)/step/(\d+)',
			array(
				'module' => 'default',
				'controller' => 'tour',
				'action'     => 'tour'
			),
			array(
				1 => 'tour',
				2 => 'step'
			),
			'tour/%d/step/%d'
		);
		$router->addRoute('tour', $routeTour);

		//gzaas - Random Explore
		$routeExplore = new Zend_Controller_Router_Route_Static('explore',
			array('module' => 'gzaas','controller' => 'gzaas', 'action' => 'randomexplore')
		);
		$router->addRoute('explore', $routeExplore);

		//gzaas - Gallery
		$routeGallery = new Zend_Controller_Router_Route_Static('gallery',
			array('module' => 'gzaas','controller' => 'gzaas', 'action' => 'gallery')
		);
		$router->addRoute('gallery', $routeGallery);


		//gzaas - Credits
		$routeCredits = new Zend_Controller_Router_Route_Static('credits',
			array('module' => 'default','controller' => 'tour', 'action' => 'credits')
		);
		$router->addRoute('credits', $routeCredits);


		/* PREVIEW MENU */
		//gzaas - GetAllFonts
		$routeFonts = new Zend_Controller_Router_Route_Static('getallfonts',
			array('module' => 'gzaas','controller' => 'preview', 'action' => 'getallfonts')
		);
		$router->addRoute('fonts', $routeFonts);

		//gzaas - GetAllPatterns
		$routePatterns = new Zend_Controller_Router_Route_Static('getallpatterns',
			array('module' => 'gzaas','controller' => 'preview', 'action' => 'getallpatterns')
		);
		$router->addRoute('patterns', $routePatterns);

		//gzaas - GetAllStyles
		$routeStyles = new Zend_Controller_Router_Route_Static('getallstyles',
			array('module' => 'gzaas','controller' => 'preview', 'action' => 'getallstyles')
		);
		$router->addRoute('styles', $routeStyles);


		/* CHARGE MENU */
		//gzaas - ChargeFont
		$routeChargeFont = new Zend_Controller_Router_Route_Static('chargefont',
			array('module' => 'gzaas','controller' => 'preview', 'action' => 'chargefont')
		);
		$router->addRoute('chargefont', $routeChargeFont);


		/* INFO HOME */
		//gzaas - info
		$routeInfo = new Zend_Controller_Router_Route_Static('info',
			array('module' => 'default','controller' => 'index', 'action' => 'info')
		);
		$router->addRoute('info', $routeInfo);


		/* CSS SPRITES GENERATORS */
		//gzaas - FeaturedFonts
		$routeFeaturedFonts = new Zend_Controller_Router_Route_Static('featuredfonts',
			array('module' => 'default','controller' => 'featured', 'action' => 'fonts')
		);
		$router->addRoute('featuredFonts', $routeFeaturedFonts);

		//gzaas - FeaturedPatterns
		$routeFeaturedPatterns = new Zend_Controller_Router_Route_Static('featuredpatterns',
			array('module' => 'default','controller' => 'featured', 'action' => 'patterns')
		);
		$router->addRoute('featuredpatterns', $routeFeaturedPatterns);

		//gzaas - FeaturedStyles
		$routeFeaturedStyles = new Zend_Controller_Router_Route_Static('featuredstyles',
			array('module' => 'default','controller' => 'featured', 'action' => 'styles')
		);
		$router->addRoute('featuredstyles', $routeFeaturedStyles);



		/* CREDITS GENERATORS */
		// FontCredits
		$routeFontCredits = new Zend_Controller_Router_Route_Static('fontcredits',
			array('module' => 'default','controller' => 'tour', 'action' => 'fontcredits')
		);
		$router->addRoute('fontcredits', $routeFontCredits);

		//gzaas - PatternCredits
		$routePatternCredits = new Zend_Controller_Router_Route_Static('patterncredits',
			array('module' => 'default','controller' => 'tour', 'action' => 'patterncredits')
		);
		$router->addRoute('patterncredits', $routePatternCredits);



		// SOCIAL

		//Login - P�gina de login
		$routeLogin = new Zend_Controller_Router_Route_Static('login',
			array('module' => 'default','controller' => 'auth', 'action' => 'login')
		);
		$router->addRoute('login', $routeLogin);

		//Logout - P�gina de logout
		$routeLogout = new Zend_Controller_Router_Route_Static('logout',
			array('module' => 'default','controller' => 'auth', 'action' => 'logout')
		);
		$router->addRoute('logout', $routeLogout);

		//Registrarse - P�gina de registro
		$routeRegisterPage = new Zend_Controller_Router_Route_Static('becomeagzaaser',
			array('module' => 'default','controller' => 'auth', 'action' => 'becomeagzaaser')
		);
		$router->addRoute('becomeagzaaser', $routeRegisterPage);

		//Registrarse - Form action
		$routeRegister = new Zend_Controller_Router_Route_Static('register',
			array('module' => 'default','controller' => 'auth', 'action' => 'register')
		);
		$router->addRoute('register', $routeRegister);

		//Activar la cuenta
		$routeActivateAccount = new Zend_Controller_Router_Route(
			'activate/:idUser/:activationCode',
			array('module' => 'default',
				'controller' => 'auth',
				'action' => 'activate'
			)
		);
		$router->addRoute('activateaccount', $routeActivateAccount);

		//Registrarse - Form action
		$routeValidateMail = new Zend_Controller_Router_Route_Static('validatemail',
			array('module' => 'default','controller' => 'auth', 'action' => 'validatemail')
		);
		$router->addRoute('validatemail', $routeValidateMail);


		$frontController->setRouter($router);


		//gzaas - Profile
		$routeProfile = new Zend_Controller_Router_Route_Regex(
			'gzaaser/(.+)',
			array(
				'module' => 'social',
				'controller' => 'profile',
				'action'     => 'profile'
			),
			array(
				1 => 'gzaaser'
			),
			'gzaaser/%s'
		);
		$router->addRoute('profile', $routeProfile);


		/** API **/

		//gzaas - API GET API KEY
		$routeGetApiKey = new Zend_Controller_Router_Route_Regex(
			'getapikey',
			array(
				'module' => 'api',
				'controller' => 'api',
				'action'     => 'getapikey'
			),
			array(
				1 => 'web'
			),
			'getapikey/%s'
		);
		$router->addRoute('getapikey', $routeGetApiKey);


		//gzaas - API GET FONTS
		$routeApiFonts = new Zend_Controller_Router_Route_Regex(
			'api/v1/fonts',
			array(
				'module' => 'api',
				'controller' => 'api',
				'action'     => 'fonts'
			),
			array(
				1 => 'numResults'
			),
			'api/fonts/%s'
		);
		$router->addRoute('apifonts', $routeApiFonts);


		//gzaas - API GET PATTERNS
		$routeApiPatterns = new Zend_Controller_Router_Route_Regex(
			'api/v1/patterns',
			array(
				'module' => 'api',
				'controller' => 'api',
				'action'     => 'patterns'
			),
			array(
				1 => 'numResults'
			),
			'api/patterns/%s'
		);
		$router->addRoute('apipatterns', $routeApiPatterns);


		//gzaas - API GET STYLES
		$routeApiStyles = new Zend_Controller_Router_Route_Regex(
			'api/v1/styles',
			array(
				'module' => 'api',
				'controller' => 'api',
				'action'     => 'styles'
			),
			array(
				1 => 'numResults'
			),
			'api/styles/%s'
		);
		$router->addRoute('apistyles', $routeApiStyles);


		//gzaas - API WRITE
		$routeApiWrite = new Zend_Controller_Router_Route_Regex(
			'api/v1/write',
			array(
				'module' => 'api',
				'controller' => 'api',
				'action'     => 'write'
			),
			array(
				1 => 'message'
			),
			'api/write/%s'
		);
		$router->addRoute('apiwrite', $routeApiWrite);

	}


}