<?php

class IndexController extends Zend_Controller_Action{

	function indexAction(){
		$this->view->title = "Hola Mundo";
		$this->render();
	}

}

?>