<?php
class IndexController extends Zcms_Generic_Controller 
{	
	function indexAction() 
	{
		//$info = Zend_Registry::get ('personalizacion');
		Zend_Loader::loadClass ( 'Configuracion' );
		
		$configuracion = new Configuracion ( );
		$where = array();
		$order = "id";
		$conf_arr = $configuracion->fetchAll( $where, $order );
		
		if( isset($conf_arr->sitio_titulo)){
			$this->view->title = $conf_arr->sitio_titulo;	
		}
		
		if ( $this->session->sitio->url_home <> '' ) {
			$this->_redirect( $this->session->sitio->url_home );
		}
		return;
	}
}
?>
