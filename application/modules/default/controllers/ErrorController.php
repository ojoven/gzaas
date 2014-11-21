<?php

class ErrorController extends Zend_Controller_Action
{

	public function init()
    {
    	$this->_redirector = $this->_helper->getHelper('Redirector');
    	
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->setHelperPath(LIBRARY_PATH.'/Zend/View/Helper', 'NF_View_Helper'); 
        $this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/style.css');  
        $this->view->headLink()->appendStylesheet(PUBLIC_WEB_PATH.'/css/fonts/Chewy/stylesheet.css');    
        // jQuery CDN Google
        $this->view->headScript()->appendFile('https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js','text/javascript');
        
		$translate = Zend_Registry::get('Zend_Translate');
		$metaDescription = utf8_encode($translate->translate('meta.description'));
		$metaKeyWords = utf8_encode($translate->translate('meta.keywords'));
		$metaTitle = utf8_encode($translate->translate('meta.title'));
		
    	$this->view->headMeta()->setName('description', $metaDescription);
    	$this->view->headMeta()->setName('keywords', $metaKeyWords);	
    	$this->view->headTitle()->append($metaTitle);     
    }
    
	public function indexAction() {
		$this->_redirect('error/error');
	}
	
	
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler'); 
        $baseUrl = $this->_request->getBaseUrl();
        echo $baseUrl;

		switch ($errors->type) { 
		    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
		    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
		        
		        // 404 error -- controller or action not found
		        $this->_redirect($baseUrl.'/'.ERROR_KEY);
		        /*$this->getResponse()->setHttpResponseCode(404);
		        $this->view->launcher = 'Ooops, something bad happened!';
		        $this->view->message = 'error 404 - Gzaas Not Found!';*/
		        break;
		    default:
		        // application error
		        $this->_redirect($baseUrl.'/'.ERROR_KEY);		        
		        /*$this->getResponse()->setHttpResponseCode(500);
		        $this->view->launcher = 'Ooops, something bad happened!';
		        $this->view->message = 'error 500 - Try again!';*/
		        break;
		}
		
		$this->view->exception = $errors->exception;
		$this->view->request   = $errors->request;
    }



}


