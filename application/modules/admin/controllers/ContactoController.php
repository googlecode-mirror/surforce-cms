<?php
class Admin_ContactoController extends Zcms_Generic_ControllerAdmin
{
    function init()
    {
        parent::init();
        Zend_Loader::loadClass('Contacto');
    }
    function indexAction()
    {
       	$this->view->subtitle = "Contactos registrados";

       	$orden = (string)$this->_request->getParam('orden', 0);
    	$asc = (bool)$this->_request->getParam('asc', 0);
    	if(empty($orden)){
    		$orden = "id";
    	}
		if($asc){
			$orden .= " ASC";
		}else{
			$orden .= " DESC";
		}
		$this->view->orden_asc = $asc;

       	$this->view->contactos = Contacto::getAll(
			$this->session->sitio->id,
			0,
			$orden
		);
        $this->render('admin');
    }
}
?>
