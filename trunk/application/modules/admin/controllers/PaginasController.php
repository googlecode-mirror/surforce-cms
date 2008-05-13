<?php
class Admin_PaginasController extends Zcms_Generic_ControllerAdmin
{	
	public function init()
	{
		parent::init ();
		Zend_Loader::loadClass ( 'Paginas' );
		Zend_Loader::loadClass ( 'PaginasMenu' );
	}	
	public function indexAction() 
	{
		$orden = (string)$this->_request->getParam('orden', 0);
		
		$this->view->subtitle = $this->info->sitio->paginas->index->titulo;		
		$this->view->paginas = Paginas::getAll($this->session->sitio->id, null, $orden);
		$this->render();
	}
	public function agregarAction() 
	{
		$this->view->subtitle = "Agregar";
		
		if ($this->_request->isPost ()) {
			
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			
			$titulo = trim($filter->filter($this->_request->getPost('titulo')));
			$contenido = $this->_request->getPost('contenido');
			
			if ($titulo != '' && $contenido) {
				$data = array (
					'titulo' 	=> $titulo, 
					'contenido' => $contenido,
					'id_sitio' 	=> $this->session->sitio->id
				);
				$pagina = new Paginas();
				$pagina->insert($data);
				$this->_redirect( '/admin/paginas/' );
				return;
			}
		}		
		$this->view->pagina = new stdClass ( );
		$this->view->pagina->id = null;
		$this->view->pagina->titulo = '';
		$this->view->pagina->contenido = '';
		
		$this->view->action = "agregar";
		$this->view->buttonText = "Agregar";
		$this->render ();
	}
	public function modificarAction() 
	{
		$this->view->subtitle = "Modificar";
		$paginas = new Paginas();
		$paginasMenues = new PaginasMenu();
		
		if ($this->_request->isPost ()) {
		
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );			
			$filter = new Zend_Filter_StripTags ( );
			
			$id 		= (int)$this->_request->getPost ( 'id' );
			$titulo 	= trim($filter->filter($this->_request->getPost('titulo')));
			$contenido 	= trim($this->_request->getPost('contenido'));
			
			$menu_id 	= (int)$this->_request->getPost('id');
			$menu_titulo = (int)$this->_request->getPost('id');
			$menu_link 	= (int)$this->_request->getPost('menu_link');
			
			if ($id !== false){
				if ($titulo != '' && $contenido != '') {
					$data = array(
						'titulo' 	=> $titulo, 
						'contenido' => $contenido,
						'id_sitio'	=> $this->session->sitio->id
					);
					$where = 'id ='.$id;
					$paginas->update ( $data, $where );
					$this->_redirect('/admin/paginas/');
					return;
				} else {
					$this->view->paginas = $paginas->fetchRow('id='.$id);
					$this->view->paginasMenues = $paginasMenues->fetchAll('id_pagina='.$id);
				}
			}
		}else{
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0){
				$this->view->pagina = $paginas->fetchRow('id='.$id);
				$this->view->paginasMenues = $paginasMenues->fetchAll('id_pagina='.$id);
			}
		}
		$this->view->action = "modificar";
		$this->view->buttonText = "Modificar";		
		$this->render ();
	}	
	public function eliminarAction() 
	{
		if (! $this->view->usuarioLogueado) {
			die ( $this->info->sitio->paginas->eliminar->msgRestringido );
		}
		
		$this->view->subtitle = $this->info->sitio->paginas->eliminar->titulo;
		$pagina = new Paginas ( );
		
		if ($this->_request->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_Alpha' );
			$filter = new Zend_Filter_Alpha ( );
			
			$id = ( int ) $this->_request->getPost ( 'id' );
			$del = $filter->filter ( $this->_request->getPost ( 'del' ) );
			
			if ($del == 'Si' && $id > 0) {
				$where = 'id = ' . $id;
				$rows_affected = $pagina->delete ( $where );
			}
		} else {
			$id = ( int ) $this->_request->getParam ( 'id' );
			if ($id > 0) {
				$this->view->pagina = $pagina->fetchRow ( 'id=' . $id );
				if ($this->view->pagina->id > 0) {
					$this->render ();
					return;
				}
			}
		}
		$this->_redirect ( '/admin/paginas/' );
	}	
	public function verAction() 
	{
		$this->view->subtitle = $this->info->sitio->paginas->ver->titulo;
		$pagina = new Paginas ( );
		
		$paginasMenues = new PaginasMenu ( );
		$id = ( int ) $this->_request->getParam ( 'id', 0 );
		if ($id > 0) {
			$this->view->pagina = $pagina->fetchRow ( 'id=' . $id );
			//Creo el array con los datos de la DB de la tabla del menú de páginas
			$this->view->paginasMenues = $paginasMenues->fetchAll ( 'id_pagina=' . $id );
		}
		
		$this->render ();
	}
}
?>