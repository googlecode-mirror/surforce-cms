<?php
class Admin_ArchivosController extends Zcms_Generic_Controller 
{
	function indexAction() 
	{
		Zend_Loader::loadClass('Archivos');		
		$Archivos = new Archivos();
		
		$this->view->subtitle = "ABM Archivos";		
		$this->view->archivos = $Archivos->fetchAll();
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
