<?php
class UsuariosController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('Usuarios');
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function preDispatch(){
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
	}

	function indexAction(){
		$info = Zend_Registry::get('personalizacion');
		$this->view->title = $info->sitio->usuarios->index->titulo;
		$usuarios = new Usuarios();
		$this->view->usuarios = $usuarios->fetchAll();
		$this->render();
	}

	function agregarAction(){
		$info = Zend_Registry::get('personalizacion');
		if( !$this->view->usuarioLogueado){
			die( $info->sitio->usuarios->agregar->msgRestringido);
		}

		$this->view->title = $info->sitio->usuarios->agregar->titulo;
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter 	= new Zend_Filter_StripTags();
			$usuario 	= trim($filter->filter($this->_request->getPost('usuario')));
			$password 	= trim($filter->filter($this->_request->getPost('password')));
			$nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
			$apellido 	= trim($filter->filter($this->_request->getPost('apellido')));
			$mail 		= trim($filter->filter($this->_request->getPost('mail')));
			$estado 	= "1";
			$creado		= date("Y-m-d H:i:s");
			if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $mail != '') {
				$data = array(
					'usuario' 	=> $usuario,
					'password' 	=> $password,
					'nombre' 	=> $nombre,
					'apellido' 	=> $apellido,
					'mail' 		=> $mail,
					'estado' 	=> $estado,
					'creado' 	=> $creado
				);
				$usuario = new Usuarios();
				$usuario->insert($data);
				$this->_redirect('/usuarios/');
				return;
			}
		}
		$this->view->usuario = new stdClass();
		$this->view->usuario->id = null;
		$this->view->usuario->usuario = '';
		$this->view->usuario->password = '';
		$this->view->usuario->nombre = '';
		$this->view->usuario->apellido = '';
		$this->view->usuario->mail = '';
		$this->view->action = $info->sitio->usuarios->agregar->action;
		$this->view->buttonText = $info->sitio->usuarios->agregar->buttonText;
		$this->render();
	}

	function modificarAction(){
		$info = Zend_Registry::get('personalizacion');
		if( !$this->view->usuarioLogueado){
			die( $info->sitio->usuarios->modificar->msgRestringido);
		}

		$this->view->title = $info->sitio->usuarios->modificar->titulo;
		$eUsuario = new Usuarios();
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter = new Zend_Filter_StripTags();
			$id = (int)$this->_request->getPost('id');
			$usuario 	= trim($filter->filter($this->_request->getPost('usuario')));
			$password 	= trim($filter->filter($this->_request->getPost('password')));
			$nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
			$apellido 	= trim($filter->filter($this->_request->getPost('apellido')));
			$mail 		= trim($filter->filter($this->_request->getPost('mail')));
			if ($id !== false) {
				if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $mail != '') {
					$data = array(
						'usuario' 	=> $usuario,
						'password' 	=> $password,
						'nombre' 	=> $nombre,
						'apellido' 	=> $apellido,
						'mail' 		=> $mail
					);
					$where = 'id = ' . $id;
					$eUsuario->update($data, $where);
					$this->_redirect('/usuarios/');
					return;
				} else {
					$this->view->usuario = $eUsuario->fetchRow('id='.$id);
				}
			}
		} else {
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
				$this->view->usuario = $eUsuario->fetchRow('id='.$id);
			}
		}
		$this->view->action = $info->sitio->usuarios->modificar->action;
		$this->view->buttonText = $info->sitio->usuarios->modificar->buttonText;

		$this->render();
	}

	function eliminarAction(){
		$info = Zend_Registry::get('personalizacion');
		if( !$this->view->usuarioLogueado){
			die( $info->sitio->usuarios->eliminar->msgRestringido);
		}

		$this->view->title = $info->sitio->usuarios->eliminar->titulo;
		$usuario = new Usuarios();
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_Alpha');
			$filter = new Zend_Filter_Alpha();
			$id = (int)$this->_request->getPost('id');
			$del = $filter->filter($this->_request->getPost('del'));
			if ($del == 'Si' && $id > 0) {
				$where = 'id = ' . $id;
				$rows_affected = $usuario->delete($where);
			}
		} else {
			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
				$this->view->usuario = $usuario->fetchRow('id='.$id);
				if ($this->view->usuario->id > 0) {
					$this->render();
					return;
				}
			}
		}
		$this->_redirect('/usuarios/');

	}

	function verAction(){
		$info = Zend_Registry::get('personalizacion');
		$this->view->title = $info->sitio->usuarios->ver->titulo;
		$usuario = new Usuarios();
		$id = (int)$this->_request->getParam('id', 0);
		if ($id > 0) {
			$this->view->usuario = $usuario->fetchRow('id='.$id);
		}
		$this->render();
	}

}
?>
