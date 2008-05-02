<?php

abstract class Zcms_Generic_Controller extends Zend_Controller_Action 
{
 	protected $registry = null;
    protected $session = null;
	protected $debug = null;
	
	public function init() 
	{
		parent::init();
		$this->registry = Zend_Registry::getInstance();
		        
		$this->initView ();

		
		$this->view->setScriptPath( './application/views/scripts/' );
		$this->view->setHelperPath( './application/views/helpers/', 'Helper' );
		$this->view->addHelperPath( './library/Zcms/View/helper/', 'Zcms_View_Helper' );
        $this->view->addHelperPath('./library/Zsurforce/View/Helper/', 'Zsurforce_View_Helper');   		
        $this->view->addBasePath('./public/','');
		$this->view->baseUrl = $this->_request->getBaseUrl ();
		        
		Zend_Loader::loadClass ( 'Configuracion' );
		$this->view->user = Zend_Auth::getInstance ()->getIdentity ();
		$this->info = $this->registry->get('personalizacion');
		$this->view->title = $this->info->sitio->index->index->titulo;

		$this->session = $this->registry->get('session');
        $this->view->session = $this->session;
        
        $this->debug = $this->registry->get('debug');
        $this->view->debug = $this->debug;
        
		/* información de sitios y subsitios */
		$this->view->sitios = Sitios::getAll()->toArray();
		$this->view->configuracion = Configuracion::getConfiguracion($this->session->sitio->id);
		
		$this->registrarSitio();
		$this->cargarMenuHorizontal();   
		
	}
	protected function registrarSitio()
	{
		$sitio = $this->_request->getParam ('sitio', NULL);
		
		if(!$sitio OR $sitio == "default"){			
			if(!$this->session->sitio){
				$this->session->sitio = Sitios::getSitioDefault();			
			}										
		}else{
			$this->session->sitio = Sitios::getSitio($sitio);
		}
		$this->view->sitio_actual = $this->session->sitio;
	}
	protected function cargarMenuHorizontal()
	{
		$opciones = array();
		
		/*
    	 * FIXME: eliminar los tildes para las urls ( url => nombre)
    	 */
		
		foreach( Sitios::getAll()->toArray() as $op ){
			$opciones[] = array(
				'url' => '/default/index/index/sitio/'.strtolower($op['nombre']),
				'alt' =>  strtolower($op['nombre']),
				'text' => ucfirst($op['titulo'])
			);
		}		
		$this->view->menuHorizontalOpciones = $opciones;		
	}
}
?>