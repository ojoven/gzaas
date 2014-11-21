<?php 
class My_Layout extends Zend_Controller_plugin_Abstract{

	public function preDispatch(Zend_Controller_Request_Abstract $request){

        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOptions();
		$moduleName = $request->getModuleName();

        if (isset($config[$moduleName]['resources']['layout']['layout'])) {

        	$layoutScript = $config[$moduleName]['resources']['layout']['layout'];
                Zend_Layout::getMvcInstance()->setLayout($layoutScript);
        }

        if (isset($config[$moduleName]['resources']['layout']['layoutPath'])) {

              $layoutPath = $config[$moduleName]['resources']['layout']['layoutPath'];

              Zend_Layout::getMvcInstance()->setLayoutPath($layoutPath);
        }
    }
}
?>
