<?php
class Admin_IndexController extends Zcms_Generic_Controller 
{	
	function indexAction() 
	{
		Zend_Loader::loadClass ( 'Configuracion' );
		
		$this->view->title = "Menú Admin";	
		$this->render('admin');
	}
}
?>
