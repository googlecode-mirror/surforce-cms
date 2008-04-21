<?php
class Admin_ArchivosController extends Zcms_Generic_ControllerAdmin 
{
	function indexAction() 
	{
		Zend_Loader::loadClass('Archivos');		
		$Archivos = new Archivos();
		
		$this->view->subtitle = "ABM Archivos";		
		$this->view->archivos = $Archivos->fetchAll();
		$this->render();	
	}
	
}
?>
