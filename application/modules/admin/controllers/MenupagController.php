<?php
class Admin_MenupagController extends Zcms_Generic_ControllerAdmin
{	
	const RETORNO = '/admin/menupag/index/pagina/';
	
	public function init() 
	{
		parent::init ();
		Zend_Loader::loadClass ( 'PaginasMenu' );
	}	
	public function indexAction() 
	{
		$id_pagina 	= (int)$this->_request->getParam('pagina');		
		$orden 		= (string)$this->_request->getParam('orden',"");
    	$asc 		= (bool)$this->_request->getParam('asc', 0);
    	
		if(empty($orden)){
    		$orden = "id_pagina";
    	}
		if($asc){
			$orden .= " ASC";
		}else{
			$orden .= " DESC";
		}
		$this->view->orden_asc = $asc;

		$this->view->id_pagina = $id_pagina;				
		$this->view->subtitle = $this->info->sitio->paginas->index->titulo;		
		$this->view->paginasMenues = PaginasMenu::getMenuPagina(
			$id_pagina,
			0,
			$orden
		);		
		$this->render();
	}	
	public function agregarAction() 
	{
		$this->view->buttonText = $this->info->sitio->paginas->agregar->buttonText;
		$this->view->subtitle 	= $this->info->sitio->menus->agregar->titulo;
		$this->view->id_pagina 	= (int)$this->_request->getParam ( 'pagina' );
		
		if ($this->_request->isPost ()) {
			
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			
			$id_pagina 	= ( int ) $this->_request->getPost ( 'id_pagina' );
			$id_menu 	= ( int ) $this->_request->getPost ( 'id_menu' );
			$link 		= $this->_request->getPost ( 'link' );
			$titulo 	= trim ( $filter->filter ( $this->_request->getPost ( 'titulo' ) ) );
			$alt 		= $this->_request->getPost ( 'alt' );
			
			if ($titulo != '' && $link != '') {
				$data = array (
					'titulo' 	=> $titulo, 
					'id_pagina' => $id_pagina, 
					'id_menu' 	=> $id_menu, 
					'link' 		=> $link, 
					'alt' 		=> $alt 
				);
				$menupag = new PaginasMenu();
				$menupag->insert($data);
				$this->_redirect(self::RETORNO.$id_pagina);
				return;
			}
		}
		$this->view->menupag = new stdClass();
		
		$this->view->menupag->id_menu = null;
		$this->view->menupag->id_pagina = $this->view->id_pagina;
		$this->view->menupag->titulo = '';
		$this->view->menupag->link = '';
		$this->view->menupag->alt = '';
		
		$this->view->action = "agregar";
	}
	function eliminarAction()
	{
		
		$this->view->subtitle = "Eliminar ítem del Menú de la Página";
		$menupag = new PaginasMenu();
		
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass ( 'Zend_Filter_Alpha' );
			$filter = new Zend_Filter_Alpha ( );
			
			$id 		= (int)$this->_request->getPost('id');
			$id_menu 	= (int)$this->_request->getPost('menu');
			$del 		= $filter->filter($this->_request->getPost('del'));
			
			if ($del == 'Si' && $id) {
				$where = 'id_pagina = '.$id.' AND id_menu= '.$id_menu;				
				$rows_affected = $menupag->delete($where);
			}
		} else {
			$id 		= (int)$this->_request->getParam('pagina');
			$id_menu 	= (int)$this->_request->getParam ('menu');
			
			if ($id){
				$this->view->menupag = $menupag->fetchRow ( 'id_pagina='.$id.' AND id_menu = '.$id_menu);
				if ($this->view->menupag->id_menu) {
					$this->render();
					return;
				}
			}
		}
		$this->_redirect ( self::RETORNO.$id );
	}	
	function modificarAction() 
	{
		$this->view->subtitle = $this->info->sitio->paginas->modificar->titulo;
		$menupag = new PaginasMenu();
		
		if ($this->_request->isPost()){
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			
			$filter = new Zend_Filter_StripTags ( );
			
			$id_pagina 	= (int)$this->_request->getPost('id_pagina');
			$id_menu 	= (int)$this->_request->getPost('id_menu');
			$link 		= $this->_request->getPost('link');
			$titulo 	= trim($this->_request->getPost('titulo'));
			$alt 		= $this->_request->getPost('alt');
			
			$where 		= 'id_pagina = '.$id_pagina.' AND id_menu = '.$id_menu;
			
			if ($titulo != '' && $link != '') {
				$data = array (
					'titulo' 	=> $titulo, 
					'id_pagina' => $id_pagina, 
					'id_menu' 	=> $id_menu, 
					'link' => $link, 
					'alt' => $alt 
				);
				$menupag->update($data, $where);
				$this->_redirect(self::RETORNO.$id_pagina);
				return;
			} else {
				$this->view->message = "Deben llenarse todos los campos";
				$this->view->menupag = $menupag->fetchAll($where);
			}
		} else {
			$id_pagina 	= (int)$this->_request->getParam('pagina');
			$id_menu 	= (int)$this->_request->getParam('menu');
			$where 		= 'id_pagina = '.$id_pagina.' AND id_menu = '.$id_menu;
			
			if ($id_pagina > 0) {
				$this->view->menupag = $menupag->fetchRow($where);
			}
		}
		$this->view->action = "modificar";
		$this->view->buttonText = $this->info->sitio->paginas->modificar->buttonText;
		$this->render();
	}
}
?>
