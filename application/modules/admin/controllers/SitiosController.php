<?php
class Admin_SitiosController extends Zcms_Generic_ControllerAdmin
{
	public function init()
	{
		parent::init();
		Zend_Loader::loadClass('Sitios');
	}
	public function indexAction()
	{
		$this->view->subtitle = "ABM Sitios";
		$this->view->sitios = Sitios::getAll();
		$this->render();
	}
	public function agregarAction()
	{
		$this->view->subtitle = "Agregar";

		if (!$this->view->usuarioLogueado) {
			die ( "acceso no autorizado" );
		}
		if ( $this->_request->isPost() ){

			$filter = new Zend_Filter_StripTags ( );

			/* Parámetros enviados por el Form */
			$nombre 		= strtolower(trim( $filter->filter( $this->_request->getPost( 'nombre' ))));
			$titulo 		= trim( $this->_request->getPost ( 'titulo' ) );
			$descripcion 	= $this->_request->getPost ( 'descripcion' );
			$por_defecto 	= $this->_request->getPost ( 'por_defecto' );
			$orden 			= $this->_request->getPost ( 'orden' );
			$url_home 		= $this->_request->getPost ( 'url_home' );

			if ( $nombre != '' && $descripcion != '' ) {
				$data = array(
					'nombre' => $nombre,
					'titulo' => $titulo,
					'descripcion' => $descripcion,
					'por_defecto' => $por_defecto,
					'orden' => $orden,
					'url_home' => $url_home
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
		$this->view->sitio->titulo = '';
		$this->view->sitio->descripcion = '';
		$this->view->sitio->por_defecto = false;
		$this->view->sitio->orden = 0;
		$this->view->sitio->url_home = '';

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
		$this->view->subtitle = "Modificar";
		$Sitios = new Sitios();

		if ( $this->_request->isPost() ){
			$filter = new Zend_Filter_StripTags ( );

			$id 		 	= (int)$this->_request->getPost('id');
			$nombre 	 	= strtolower(trim($filter->filter($this->_request->getPost('nombre'))));
			$titulo 		= trim($this->_request->getPost ( 'titulo' ) );
			$descripcion 	= trim($filter->filter($this->_request->getPost('descripcion')));
			$por_defecto 	= (boolean) $filter->filter($this->_request->getPost('por_defecto'));
			$orden 			= (int) $filter->filter($this->_request->getPost('orden'));
			$url_home		= $filter->filter($this->_request->getPost('url_home'));

			if ( $id > 0){
				if ($nombre != '' && $descripcion != '') {
					$data = array(
						'nombre' 		=> $nombre,
						'titulo' 		=> $titulo,
						'descripcion' 	=> $descripcion,
						'por_defecto' 	=> $por_defecto,
						'orden' 		=> $orden,
						'url_home'		=> $url_home
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
		$this->view->subtitle = "Eliminar";
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