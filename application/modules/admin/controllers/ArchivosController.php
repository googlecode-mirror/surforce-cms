<?php
class Admin_ArchivosController extends Zcms_Generic_ControllerAdmin 
{
  	function init()
    {
        parent::init();
        Zend_Loader::loadClass('Archivos');
    }
	public function indexAction() 
	{
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
	public function modificarAction()
    {
        $this->view->subtitle = 'Modificar';
        
        $archivos = new Archivos();
        
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();
            
            $id = 		(int)$this->_request->getPost('id');
            $nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
            $descripcion= trim($filter->filter($this->_request->getPost('descripcion')));
            
            if ($id !== false) {
                if ($nombre != '') {
                    $data = array(
                        'nombre' 		=> $nombre,
                        'descripcion' 	=> $descripcion
                    );
                    $where = 'id = ' . $id;
                    $archivos->update($data, $where);
                    $this->_redirect('/admin/archivos/');
                    return;
                } else {
                    $this->view->archivo = $archivo->fetchRow('id='.$id);
                    $this->view->message = "Deben llenarse todos los campos";
                }
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $this->view->archivo = $archivos->fetchRow('id='.$id);
            }
        }
        $this->view->action = "modificar";
        $this->view->buttonText = "Modificar";
    }
 	public function eliminarAction()
    {
        $this->view->subtitle = "Eliminar";
        $archivos = new Archivos();
        
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_Alpha');
            $filter = new Zend_Filter_Alpha();
            
            $id = (int)$this->_request->getPost('id');
            $del = $filter->filter($this->_request->getPost('del'));
            
            if ($del == 'Si' && $id > 0) {
                $where = 'id = ' . $id;
                $rows_affected = $archivos->delete($where);
            }
        } else {
            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
                $this->view->archivo = $archivos->fetchRow('id='.$id);
                if ($this->view->archivo->id > 0) {
                    $this->render();
                    return;
                }
            }
        }
        $this->_redirect('/admin/archivos/');
    }
}
?>
