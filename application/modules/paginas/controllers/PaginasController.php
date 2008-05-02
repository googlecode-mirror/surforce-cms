<?php
class Paginas_PaginasController extends Zcms_Generic_Controller 
{
	public function init() 
	{
		parent::init ();
		Zend_Loader::loadClass ( 'Paginas' );
		Zend_Loader::loadClass ( 'PaginasMenu' );
		// FIXME: hace un join en el modelo
		Zend_Loader::loadClass ( 'PaginasArchivos' );
	}	
	public function verAction() 
	{
		$this->view->subtitle = $this->info->sitio->paginas->ver->titulo;
		
		$pagina = new Paginas();		
		$paginasMenues = new PaginasMenu ();
		
		$id = (int)$this->_request->getParam ( 'id', 0 );
		
		if ($id > 0) {
			$this->view->pagina = $pagina->fetchRow ( 'id=' . $id );
			$this->view->paginasMenues = $paginasMenues->fetchAll('id_pagina='.$id);
			$this->view->archivos = PaginasArchivos::getArchivos($id);
		}		
		
	}
}
?>
