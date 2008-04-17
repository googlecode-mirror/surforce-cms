<?php
class Paginas_MenupagController extends Zcms_Generic_Controller {
	
	function init() {
		parent::init ();
		Zend_Loader::loadClass ( 'PaginasMenu' );
	}
	
	function preDispatch() {
		$auth = Zend_Auth::getInstance ();
		if ($auth->hasIdentity ()) {
			$this->view->usuarioLogueado = true;
		}
	}
	
	function indexAction() {
		//$info = Zend_Registry::get('personalizacion');
		$this->view->subtitle = $this->info->sitio->paginas->index->titulo;
		$menus = new PaginasMenu ( );
		$this->view->paginas->menu = $menus->fetchAll ();
		$this->render ();
	}
	
	function agregarAction() {
		//$info = Zend_Registry::get('personalizacion');
		$this->view->buttonText = $this->info->sitio->paginas->agregar->buttonText;
		
		if (! $this->view->usuarioLogueado) {
			die ( $this->info->sitio->paginas->agregar->msgRestringido );
		}
		
		$this->view->subtitle = $this->info->sitio->menus->agregar->titulo;
		$this->view->id = ( int ) $this->_request->getParam ( 'id' );
		
		if ($this->_request->isPost ()) {
			
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			
			$id_pagina = ( int ) $this->_request->getPost ( 'id_pagina' );
			$id_menu = ( int ) $this->_request->getPost ( 'id_menu' );
			$link = $this->_request->getPost ( 'link' );
			$titulo = trim ( $filter->filter ( $this->_request->getPost ( 'titulo' ) ) );
			$alt = $this->_request->getPost ( 'alt' );
			
			if ($titulo != '' && $link != '') {
				$data = array ('titulo' => $titulo, 'id_pagina' => $id_pagina, 'id_menu' => $id_menu, 'link' => $link, 'alt' => $alt );
				$menupag = new PaginasMenu ( );
				$menupag->insert ( $data );
				$this->_redirect ( '/paginas/paginas/modificar/id/' . $id_pagina );
				return;
			}
		}
		/*
         * Si no existe la clase, se crea una vacía para que 
         * el form agregar pueda trabajar tanto con la clase
         * con datos cargados o sin ellos
         */
		$this->view->menupag = new stdClass ( );
		$this->view->menupag->id_menu = null;
		//revisar $this->view->menupag->id_pagina = null;
		$this->view->menupag->titulo = '';
		$this->view->menupag->link = '';
		$this->view->menupag->alt = '';
	
	}
	
	function eliminarAction() {
		//$info = Zend_Registry::get('personalizacion');
		if (! $this->view->usuarioLogueado) {
			die ( $this->info->sitio->paginas->eliminar->msgRestringido );
		}
		
		$this->view->subtitle = $this->info->sitio->paginas->eliminar->titulo;
		$menupag = new PaginasMenu ( );
		
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_Alpha' );
			$filter = new Zend_Filter_Alpha ( );
			
			$id = ( int ) $this->_request->getPost ( 'id' );
			$id_menu = ( int ) $this->_request->getPost ( 'menu' );
			$del = $filter->filter ( $this->_request->getPost ( 'del' ) );
			
			if ($del == 'Si' && $id) {
				$where = 'id_pagina = ' . $id . ' and id_menu= ' . $id_menu;
				$rows_affected = $menupag->delete ( $where );
			}
		} else {
			$id = ( int ) $this->_request->getParam ( 'id' );
			$id_menu = ( int ) $this->_request->getParam ( 'menu' );
			if ($id) {
				$this->view->menupag = $menupag->fetchRow ( 'id_pagina=' . $id . ' and id_menu= ' . $id_menu );
				if ($this->view->menupag->id_menu) {
					$this->render ();
					return;
				}
			}
		}
		$this->_redirect ( '/paginas/paginas/modificar/id/' . $id );
	}
	
	function modificarAction() {
		//$info = Zend_Registry::get('personalizacion');
		if (! $this->view->usuarioLogueado) {
			die ( $this->info->sitio->paginas->modificar->msgRestringido );
		}
		
		$this->view->subtitle = $this->info->sitio->paginas->modificar->titulo;
		$menupag = new PaginasMenu ( );
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			
			$filter = new Zend_Filter_StripTags ( );
			
			$id_pagina = ( int ) $this->_request->getPost ( 'id_pagina' );
			$id_menu = ( int ) $this->_request->getPost ( 'id_menu' );
			$link = $this->_request->getPost ( 'link' );
			$titulo = trim ( $this->_request->getPost ( 'titulo' ) );
			$alt = $this->_request->getPost ( 'alt' );
			
			$where = 'id_pagina = ' . $id_pagina . ' AND id_menu = ' . $id_menu;
			
			if ($titulo != '' and $link != '') {
				$data = array ('titulo' => $titulo, 'id_pagina' => $id_pagina, 'id_menu' => $id_menu, 'link' => $link, 'alt' => $alt );
				$menupag->update ( $data, $where );
				$this->_redirect ( '/paginas/paginas/modificar/id/' . $id_pagina );
				return;
			} else {
				$this->view->message = "Deben llenarse todos los campos";
				$this->view->menupag = $menupag->fetchAll ( $where );
			}
		} else {
			$id_pagina = ( int ) $this->_request->getParam ( 'pagina' );
			$id_menu = ( int ) $this->_request->getParam ( 'menu' );
			$where = 'id_pagina = ' . $id_pagina . ' AND id_menu = ' . $id_menu;
			
			if ($id_pagina > 0) {
				$this->view->menupag = $menupag->fetchRow ( $where );
			}
		}
		$this->view->action = "modificar";
		$this->view->buttonText = $this->info->sitio->paginas->modificar->buttonText;
		$this->render ();
	}

}
?>
