<?php
class NoticiasController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('Noticias');
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function preDispatch(){
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
	}

	function indexAction(){
		$this->view->title = "Noticias";
		$noticias = new Noticias();
		$where = array();
		$order = "fecha DESC";
		$this->view->noticias = $noticias->fetchAll($where, $order);
		$this->render();
	}

	function agregarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Agregar Noticia";
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter 	= new Zend_Filter_StripTags();

			$titulo 		= trim($filter->filter($this->_request->getPost('titulo')));
			$contenido 	= trim( $this->_request->getPost('contenido') );

			if( $titulo != '' && $contenido ) {
				$data = array(
					'titulo' 	=> $titulo,
					'contenido' 	=> $contenido
				);
				$noticia = new Noticias();
				$noticia->insert( $data );
				$this->_redirect('/noticias/');
				return;
			}
		}
		$this->view->noticia = new stdClass();
		$this->view->noticia->id = null;
		$this->view->noticia->titulo = '';
		$this->view->noticia->contenido = '';

		$this->view->action = 'agregar';
		$this->view->buttonText = 'Agregar';
		$this->render();
	}

	function modificarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Editar Noticia";
		$eNoticia = new Noticias();
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');

			$filter = new Zend_Filter_StripTags();

			$id 			= 	(int)$this->_request->getPost('id');
			$titulo	 	= trim($filter->filter($this->_request->getPost('titulo')));
			$contenido 	= trim( $this->_request->getPost('contenido') );

			if ($id !== false) {
				if ($titulo != '' && $contenido != '' ) {
					$data = array(
						'titulo' 	=> $titulo,
						'contenido' 	=> $contenido
					);
					$where = 'id = ' . $id;
					$eNoticia->update($data, $where);
					$this->_redirect('/noticias/');
					return;
				} else {
					$this->view->noticia = $eNoticia->fetchRow('id='.$id);
				}
			}
		} else {
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
				$this->view->noticia = $eNoticia->fetchRow('id='.$id);
			}
		}
		$this->view->action = 'modificar';
		$this->view->buttonText = 'Modificar';

		$this->render();
	}

	function eliminarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Eliminar Noticia";
		$noticia = new Noticias();

		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_Alpha');
			$filter = new Zend_Filter_Alpha();

			$id 	= (int)$this->_request->getPost('id');
			$del 	= $filter->filter($this->_request->getPost('del'));

			if ($del == 'Si' && $id > 0) {
				$where = 'id = ' . $id;
				$rows_affected = $noticia->delete($where);
			}
		} else {
			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
				$this->view->noticia = $noticia->fetchRow('id='.$id);
				if ($this->view->noticia->id > 0) {
					$this->render();
					return;
				}
			}
		}
		$this->_redirect('/noticias/');
	}

	function verAction(){
		$this->view->title = "Ver Noticia";
		$noticia = new Noticias();
		$id = (int)$this->_request->getParam('id', 0);
		if ($id > 0) {
			$this->view->noticia = $noticia->fetchRow('id='.$id);
		}
		$this->render();
	}
}
?>
