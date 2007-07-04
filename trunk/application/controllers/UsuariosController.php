<?php
class UsuariosController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('Usuarios');
	}

	function indexAction(){
		$this->view->title = "Listado de usuarios";
		$usuarios = new Usuarios();
		$this->view->usuarios = $usuarios->fetchAll();
		$this->render();
	}

}
?>
