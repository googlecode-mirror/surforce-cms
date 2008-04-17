<?php
class Admin_SitiosController extends Zcms_Generic_Controller 
{
	function indexAction() 
	{
		Zend_Loader::loadClass('Sitios');		
		$Sitios = new Sitios();
		
		$this->view->subtitle = "ABM Sitios";		
		$this->view->sitios = $Sitios->fetchAll();
		$this->render();	
	}
	function preDispatch() 
	{
		$auth = Zend_Auth::getInstance ();
		if ($auth->hasIdentity ()) {
			$this->view->usuarioLogueado = true;
		}
	}
}
?>
