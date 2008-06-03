<?php
class Admin_ConfiguracionController extends Zcms_Generic_ControllerAdmin 
{
	public function init()
	{
		parent::init();
	}
	function indexAction() 
	{
		$this->view->subtitle = "ABM Configuración";
		
		$conf = Configuracion::getConfiguracionSitio($this->session->sitio->id);
		if( $conf == null){
			Configuracion::setConfiguracion($this->session->sitio->id);
		}
		$this->view->configuracion = Configuracion::getConfiguracionSitio($this->session->sitio->id);		
		$this->render('admin');
	}	
	function modificarAction() 
	{		
		$this->view->subtitle = "Modificar Configuración";
		$configuracion = new Configuracion ( );

		if ($this->_request->isPost ()) {
					
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			
			$id = (int)$this->_request->getPost('id');
			$sitio_color_fondo = trim ( $filter->filter ( $this->_request->getPost ( 'sitio_color_fondo' ) ) );
			$sitio_color_cabezal = trim ( $filter->filter ( $this->_request->getPost ( 'sitio_color_cabezal' ) ) );
			$sitio_color_pie = trim ( $filter->filter ( $this->_request->getPost ( 'sitio_color_pie' ) ) );
			
			if ($id !== false) {
				$data = array (
					'sitio_color_fondo' => $sitio_color_fondo, 
					'sitio_color_cabezal' => $sitio_color_cabezal, 
					'sitio_color_pie' => $sitio_color_pie,
					'id_sitio' => $this->session->sitio->id 
				); 
				$where = 'id = '.$id;
				$configuracion->update($data,$where);
				$this->_redirect('/admin/configuracion/');
				return;
			}
		}else{
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
				$this->view->configuracion = Configuracion::getConfiguracionSitio($id);
			}
		}
		$this->view->action = "modificar";
		$this->view->buttonText = "Modificar";		
		$this->view->scriptJs = "mooRainbow";
	}
}
?>
