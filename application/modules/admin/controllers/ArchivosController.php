<?php
class Admin_ArchivosController extends Zcms_Generic_ControllerAdmin 
{
	public function indexAction() 
	{
		Zend_Loader::loadClass('Archivos');			
		
		$this->view->subtitle = "ABM Archivos";		
		$this->view->archivos = Archivos::getAll($this->session->sitio->id);
		$this->render();	
	}
	public function agregarAction()
	{
    	$this->view->subtitle = "Agregar";
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();

            $nombre 		= trim($filter->filter($this->_request->getPost('nombre')));
            $descripcion 	= trim( $this->_request->getPost('descripcion') );

            if($nombre){
                $data = array(
                    'nombre' 		=> $nombre,
                    'descripcion' 	=> $descripcion,
                    'id_sitio' 		=> $this->session->sitio->id
                );
                $archivo = new Archivos();
                $archivo->insert( $data );
                $this->_redirect('/admin/archivos/');
                return;
            }
        }
        $this->view->archivo = new stdClass();
        $this->view->archivo->id = null;
        $this->view->archivo->nombre = '';
        $this->view->archivo->descripcion = '';
        
        $this->view->action = "agregar";
        $this->view->buttonText = "Agregar";
        $this->render();
	}
}
?>
