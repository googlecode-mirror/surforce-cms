<?php
class AutenticacionController extends Zend_Controller_Action {

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
	}

	function indexAction(){
		$this->_redirect('/');
	}

	function logoutAction(){
		Zend_Auth::getInstance()->clearIdentity();
		$this->_redirect('/');
	}

	function loginAction(){
		$this->view->message = '';
		if ($this->_request->isPost()) {

			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$f = new Zend_Filter_StripTags();
			$usuario = $f->filter($this->_request->getPost('usuario'));
			$password = $f->filter($this->_request->getPost('password'));

			if (empty($usuario)) {
				$this->view->message = 'Ingrese un nombre de usuario.';
			} else {

				Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
				$dbAdapter = Zend_Registry::get('dbAdapter');
				$autAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
				$autAdapter->setTableName('usuarios');
				$autAdapter->setIdentityColumn('usuario');
				$autAdapter->setCredentialColumn('password');

				$autAdapter->setIdentity($usuario);
				$autAdapter->setCredential($password);

				$aut = Zend_Auth::getInstance();
				$result = $aut->authenticate($autAdapter);

				if ($result->isValid()) {
					$data = $autAdapter->getResultRowObject(null, 'password');
					$aut->getStorage()->write($data);
					$this->_redirect('/');
				} else {
					$this->view->message = 'Nombre de usuario y/o clave incorrectos.';
				}
			}
		}

		$this->view->title = "Inicio de sesión";
		$this->render();

	}


}
?>
