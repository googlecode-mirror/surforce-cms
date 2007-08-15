<?php

class IndexController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function indexAction(){
		$this->view->title = "CMS - Home";
		//$this->render();
		$this->_redirect('/noticias/');
		return;
	}

}

?>