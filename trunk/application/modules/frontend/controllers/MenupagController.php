<?php
class Frontend_MenupagController extends Zcms_Generic_Controller {
	
	function init() 
	{
		parent::init ();
		Zend_Loader::loadClass ( 'PaginasMenu' );
	}
	function indexAction() 
	{
		$this->view->subtitle = $this->info->sitio->paginas->index->titulo;
		$menus = new PaginasMenu();
		$this->view->paginas->menu = $menus->fetchAll();
		$this->render();
	}
}
?>
