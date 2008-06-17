<?php
/**
 * Controller Genérico para definir un comportamiento común a
 * todos los controllers de una aplicación.
 * 
 * @category SURFORCE
 * @package SURFORCE-LIBRARY 
 * @license GPL v2
 */
abstract class Zsurforce_Generic_Controller extends Zend_Controller_Action
{
	/**
	 * Se obtiene del bootstrap (index.php) 
	 * para acceder a las variables que serán compartidas desde  
	 * el arranque (no es igual a una sesión, no persiste).
	 */
    protected $_registry = null;
    /**
     * Atributo que contiene la sesión que debe haber iniciado
     * en el bootstrap (index.php).  
     */
    protected $_session = null;
    /**
     * Desde el archivo de configuración (config_sys.ini) se define
     * el valor boolean para poder hacer revisiones durante la 
     * ejecución de la aplicación.
     */
	protected $_debug = null;

	/**
	 * Define inicio del controller
     * 
     * Carga de atributos, configuración base 
     */
	public function init()
    {
    	parent::init();     
    	/*
    	 * Carga información desde el bootstrap (index.php).
    	 */
        $this->_registry 	= Zend_Registry::getInstance();
		$this->_debug 		= $this->_registry->get('config_sys')->debug;
        $this->_session 	= $this->_registry->get('session');
          
        /*
         * Carga información para las vistas del sistema
         */
        $this->initView();
        $this->view->basePath 	= $this->registry->get('base_path');
        $this->view->baseUrl 	= $this->_request->getBaseUrl();        
        $this->view->debug 		= $this->_debug;
        $this->view->session 	= $this->_session;
        $this->view->user 		= Zend_Auth::getInstance ()->getIdentity ();
        
		/* Ruta para acceder a toda la información pública y compartida del sistema: 
		 * - estilos
		 * - layout 
		 * - imagenes
		 * - scripts / js / etc
		 */
        $this->view->addBasePath('./html/','');
        
        $this->view->addHelperPath('./library/Zsurforce/View/Helper/', 'Zsurforce_View_Helper');   		
        
        /*
         * Ejemplo para cargar por defecto las clases necesarias para el controller,
         * como puede ser también un Modelo
         */
        // Zend_Loader::loadClass('clase');
        // Zend_Loader::loadClass('Configuracion');
    }
	/**
	 * Asegurando antes de "despachar" si hay autenticación o no, si es true,
	 * se registra el usuario que ingresa al sistema, y permite a través de
	 * una variable de la vista poder ocultar o mostrar información (caso de un
	 * admin).
	 * 
	 * Para este caso no tranca el acceso al módulo, ya que este controller es 
	 * para los módulos públicos.
	 */
    public function preDispatch()
    {
    	$auth = Zend_Auth::getInstance ();
		if ($auth->hasIdentity ()) {
			$this->view->usuarioLogueado = true;	
		}
    }
}
?>