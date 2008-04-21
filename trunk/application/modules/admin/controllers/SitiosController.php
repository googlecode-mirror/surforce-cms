<?php
class Admin_SitiosController extends Zcms_Generic_ControllerAdmin  
{		
	public function indexAction() 
	{		
		Zend_Loader::loadClass('Sitios');		
		$Sitios = new Sitios();
		
		$this->view->subtitle = "ABM Sitios";		
		$this->view->sitios = $Sitios->fetchAll();
		$this->render();	
	}
	public function agregarAction() 
	{
		if (!$this->view->usuarioLogueado) {
			die ( "acceso no autorizado" );
		}		
		if ( $this->_request->isPost() ){
			
			$filter = new Zend_Filter_StripTags ( );
			
			/* Parámetros enviados por el Form */
			$nombre = trim( $filter->filter( $this->_request->getPost( 'nombre' ) ) );			
			$descripcion = $this->_request->getPost ( 'descripcion' );
			
			if ( $nombre != '' && $descripcion != '' ) {
				$data = array(
					'nombre' => $nombre, 
					'descripcion' => $descripcion 
				);
				Zend_Loader::loadClass('Sitios');		
				$Sitios = new Sitios();				
				$Sitios->insert( $data );
				
				$this->_redirect ( '/admin/sitios/' );
				return;
			}else{
				$this->view->message = "Deben llenarse todos los campos";
			}
		}		
		$this->view->sitio = new stdClass ( );
		$this->view->sitio->id = null;
		$this->view->sitio->nombre = '';
		$this->view->sitio->descripcion = '';
		
		$this->view->action = "agregar";
		$this->view->buttonText = "Agregar";
		$this->render ();
	}
	public function verAction() 
	{
		$this->view->subtitle = "Ver Sitio";			
		$this->view->buttonText = "Agregar";
			
		Zend_Loader::loadClass('Sitios');	
		$Sitios = new Sitios();
		
		$id = (int)$this->_request->getParam ( 'id', 0 );
		
		if ($id > 0){
			$this->view->sitio = $Sitios->fetchRow( 'id='.$id );
		}
		$this->render ();
	}
	public function modificarAction() 
	{
		Zend_Loader::loadClass('Sitios');	
		$Sitios = new Sitios();		

		if ( $this->_request->isPost() ){
			$filter = new Zend_Filter_StripTags ( );
			
			$id 		 = (int)$this->_request->getPost('id');
			$nombre 	 = trim($filter->filter($this->_request->getPost('nombre')));
			$descripcion = trim($filter->filter($this->_request->getPost('descripcion')));
			
			if ( $id > 0){
				if ($nombre != '' && $descripcion != '') {
					$data = array(
						'nombre' => $nombre, 
						'descripcion' => $descripcion
					);
					$where = 'id = ' . $id;
					$Sitios->update($data, $where);
					$this->_redirect('/admin/sitios/');
					return;
				}else{
					$this->view->sitio = $Sitios->fetchRow('id='.$id);
					$this->view->message = "Deben llenarse todos los campos";
				}
			}
		}else{
			$id = (int)$this->_request->getParam('id',0);
			if ($id > 0){
				$this->view->sitio = $Sitios->fetchRow('id='.$id);
			}
		}
		$this->view->action = $this->info->sitio->usuarios->modificar->action;
		$this->view->buttonText = $this->info->sitio->usuarios->modificar->buttonText;
		
		$this->render ();
	}
	public function eliminarAction() {
		Zend_Loader::loadClass('Sitios');	
		$Sitios = new Sitios();		
		
		if ($this->_request->isPost ()) {
			$filter = new Zend_Filter_Alpha ( );
			
			$id = (int)$this->_request->getPost('id');
			$del = $filter->filter($this->_request->getPost('del'));
			
			if ($del == 'Si' && $id > 0) {
				$where = 'id = ' . $id;
				$rows_affected = $Sitios->delete ( $where );
			}
		}else{
			$id = (int)$this->_request->getParam('id');
			if ($id > 0) {
				$this->view->sitio = $Sitios->fetchRow('id='.$id);
				if ($this->view->sitio->id > 0) {
					$this->render ();
					return;
				}
			}
		}
		$this->_redirect ( '/admin/sitios/' );
	}
}
?>
