<?php
class PaginasController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('Paginas');
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function preDispatch(){
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
	}

	function indexAction(){
		$this->view->title = "Paginas";
		$paginas = new Paginas();
		$this->view->paginas = $paginas->fetchAll();
		$this->render();
	}

	function agregarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Accion no permitida ");
		}

		$this->view->title = "Agregar Pagina";

		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter 	= new Zend_Filter_StripTags();

			$titulo 	= trim($filter->filter($this->_request->getPost('titulo')));
			$contenido 	= $this->_request->getPost('contenido');

			if( $titulo != '' && $contenido ) {
				$data = array(
					'titulo' 	=> $titulo,
					'contenido' 	=> $contenido
				);
				$pagina = new Paginas();
				$pagina->insert( $data );
				$this->_redirect('/paginas/');
				return;
			}
		}

		$this->view->pagina = new stdClass();
		$this->view->pagina->id = null;
		$this->view->pagina->titulo = '';
		$this->view->pagina->contenido = '';

		$this->view->action = 'agregar';
		$this->view->buttonText = 'Agregar';
		$this->render();
	}

	function modificarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Editar Pagina";
		$eNoticia = new Paginas();
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');

			$filter = new Zend_Filter_StripTags();

			$id 			= 	(int)$this->_request->getPost('id');
			$titulo	 	= trim($filter->filter($this->_request->getPost('titulo')));

			$contenido	= trim( $this->_request->getPost('contenido'));

			if ($id !== false) {
				if ($titulo != '' && $contenido != '' ) {
					$data = array(
						'titulo' 	=> $titulo,
						'contenido' 	=> $contenido
					);
					$where = 'id = ' . $id;
					$eNoticia->update($data, $where);
					$this->_redirect('/paginas/');
					return;
				} else {
					$this->view->paginas = $eNoticia->fetchRow('id='.$id);
				}
			}
		} else {
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
				$this->view->pagina = $eNoticia->fetchRow('id='.$id);
			}
		}
		$this->view->action = 'modificar';
		$this->view->buttonText = 'Modificar';

		$this->render();
	}

	function eliminarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acciï¿½n no permitida ");
		}

		$this->view->title = "Eliminar Pagina";
		$pagina = new Paginas();

		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_Alpha');
			$filter = new Zend_Filter_Alpha();

			$id 	= (int)$this->_request->getPost('id');
			$del 	= $filter->filter($this->_request->getPost('del'));

			if ($del == 'Si' && $id > 0) {
				$where = 'id = ' . $id;
				$rows_affected = $pagina->delete($where);
			}
		} else {
			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
				$this->view->pagina = $pagina->fetchRow('id='.$id);
				if ($this->view->pagina->id > 0) {
					$this->render();
					return;
				}
			}
		}
		$this->_redirect('/paginas/');
	}

	function verAction(){
		$this->view->title = "Ver Noticia";
		$pagina = new Paginas();
		$id = (int)$this->_request->getParam('id', 0);
		if ($id > 0) {
			$this->view->pagina = $pagina->fetchRow('id='.$id);
		}
		$this->render();
	}
}
?>
