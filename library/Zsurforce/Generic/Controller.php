<?php

abstract class Zsurforce_Generic_Controller extends Zend_Controller_Action
{
    protected $registry = null;
    protected $session = null;
	protected $debug = null;

	function init()
    {
    	parent::init();     
        $this->registry = Zend_Registry::getInstance();
		$this->debug = $this->registry->get('config_sys')->debug;
        $this->session = $this->registry->get('session');
          
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->debug = $this->debug;
        $this->view->session = $this->session;
        
		/* Rutas */
        $this->view->addBasePath('./html/','');
        $this->view->addHelperPath('./library/Zsurforce/View/Helper/', 'Zsurforce_View_Helper');   		
        
        /*
         * Ejemplo para cargar por defecto las clases necesarias para el controller
         */
        // Zend_Loader::loadClass('clase');
    }
	/**
	 * Asegurando antes de "despachar" si hay autenticación o no, si es true,
	 * se registra el usuario que ingresa al sistema, y permite a través de
	 * una variable de la vista poder ocultar o mostrar información (caso de un
	 * admin)
	 */
    function preDispatch()
    {
        $session = new Zend_Session_Namespace("Autenticacion");
        Zend_Registry::set("session", $session);

        if($session){
            if(Zend_Registry::get('session')->usuarioLogueado){
                $this->view->usuarioLogueado = Zend_Registry::get('session')->usuarioLogueado;
            }
        }
        else
        $this->view->usuarioLogueado = false;
    }
}
?>