<?php
/*
 * AuthorizationPlugin.php
 * Extension de la clase Zend_Controller_Plugin_Abstract
*/
class My_AuthorizationPlugin extends Zend_Controller_Plugin_Abstract
{
	private $_auth;
 
	public function __construct(Zend_Auth $auth)
	{
        	$this->_auth = $auth;
	}
 
	public function preDispatch ( Zend_Controller_Request_Abstract $request )
	{	
		// revisa que exista una identidad
		if (!$this->_auth->hasIdentity()) {
			if(isset($_COOKIE['idUserGS']) && isset($_COOKIE['numRandGS'])){
	    		//$usuarioCookieModel = new Default_Model_Usuariocookie();
	    		$userCookieModel = new Default_Model_Usercookie();
	    		$idUser = $_COOKIE['idUserGS'];
	    		$numRand = $_COOKIE['numRandGS'];
	    		//$userCookie = $usuarioCookieModel->obtenerCookieUsuario($idUsuario,$numAleatorio);
	    		$userCookie = $userCookieModel->getUserCookie($idUser,$numRand);
	    		if($userCookie!=false){
	    			$userModel = new Default_Model_User();
	    			$user = $userModel->getUser($idUser);
	    			if($user!=false){
	    				$db = Zend_Registry::get('db');
						$authAdapter = new Zend_Auth_Adapter_DbTable($db);
						$authAdapter->setTableName('us_01');
						$authAdapter->setIdentityColumn('username');
						$authAdapter->setCredentialColumn('password');
						
						// Set the input credential values to authenticate against
						$authAdapter->setIdentity($user['username']);
						$authAdapter->setCredential($user['password']);
						
						// hace la autentificacion
						$auth = Zend_Auth::getInstance();
						$result = $auth->authenticate($authAdapter);
						
						if ($result->isValid()) 
						{
							// success: store database row to auth's storage
							// system. (Not the password though!)
							$data = $authAdapter->getResultRowObject(null,'password');
							if ($data->active)
		                    {
		                    	$auth->getStorage()->write($data);
		                    }		
	    	
	    				}
 
					}
	
	
				}
			}
		}
		
	}
	
}

?>