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
		$info = Zend_Registry::get('personalizacion');
		$this->view->title = $info->sitio->noticias->index->titulo; 
		$noticias = new Noticias();
		$where = array();
		$order = "fecha DESC";
		$this->view->noticias = $noticias->fetchAll($where, $order);
		$this->render();
	}

	function agregarAction(){
		$info = Zend_Registry::get('personalizacion');
		if( !$this->view->usuarioLogueado){
			die( $info->sitio->noticias->agregar->msgRestringido);
		}

		$this->view->title = $info->sitio->noticias->agregar->titulo;
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

		$this->view->action = $info->sitio->noticias->agregar->action;
		$this->view->buttonText = $info->sitio->noticias->agregar->buttonText;
		$this->render();
	}

	function modificarAction(){
		$info = Zend_Registry::get('personalizacion');
		if( !$this->view->usuarioLogueado){
			die( $info->sitio->noticias->modificar->msgRestringido );
		}

		$this->view->title = $info->sitio->noticias->modificar->titulo;
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
		$this->view->action = $info->sitio->noticias->modificar->action;
		$this->view->buttonText = $info->sitio->noticias->modificar->buttonText;

		$this->render();
	}

	function eliminarAction(){
		$info = Zend_Registry::get('personalizacion');
		if( !$this->view->usuarioLogueado){
			die( $info->sitio->noticias->eliminar->msgRestringido );
		}

		$this->view->title = $info->sitio->noticias->eliminar->titulo;
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
		$info = Zend_Registry::get('personalizacion');
		$this->view->title = $info->sitio->noticias->ver->titulo;
		$noticia = new Noticias();
		$id = (int)$this->_request->getParam('id', 0);
		if ($id > 0) {
			$this->view->noticia = $noticia->fetchRow('id='.$id);
		}
		$this->render();
	}
}
?>
