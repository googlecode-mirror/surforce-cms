<?php
class Admin_IndexController extends Zcms_Generic_ControllerAdmin
{	
	function indexAction() 
	{
		Zend_Loader::loadClass ( 'Configuracion' );
		
		$this->view->title = 'Administración General';	
		$this->render('admin');
	}
}
?>
