<?php

class IndexController extends Zcms_Generic_Controller 
{
	
	function indexAction() 
	{
		$info = Zend_Registry::get ( 'personalizacion' );
		Zend_Loader::loadClass ( 'Configuracion' );
		
		$configuracion = new Configuracion ( );
		$where = array ( );
		$order = "id";
		$conf_arr = $configuracion->fetchAll ( $where, $order );
		$this->view->title = $conf_arr->sitio_titulo;
		
		/*
		 * FIXME: se requiere que la página principal sea de 
		 * bienvenida, por consiguiente se llega a la convención
		 * de la que página "1" es siempre la "home"
		 * 
		 * Nota: ver la forma de verificar si no existe,
		 * de lo contrario redireccionar al módulo
		 * "noticias"
		 * 
		 * $this->_redirect ( '/noticias/noticias' );  
		 */
		
		$this->_redirect ( '/paginas/paginas/ver/id/1' );
		return;
	}
}
?>
