<?php

abstract class Zcms_Generic_ControllerAdmin extends Zcms_Generic_Controller
{	
	public function init()
	{
		parent::init();
	}
	
	final function preDispatch() 
	{
		$auth = Zend_Auth::getInstance ();
		if ($auth->hasIdentity ()) {
			$this->view->usuarioLogueado = true;
		}else {
			die ( 'Acceso Restringido' );
		}
	}
}
?>