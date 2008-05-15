<?php
class Admin_ArchivosController extends Zcms_Generic_ControllerAdmin
{
  	function init()
    {
        parent::init();
        Zend_Loader::loadClass('Archivos');
        Zend_Loader::loadClass('PaginasArchivos');
    }
	public function indexAction()
	{
		$this->view->subtitle = "ABM Archivos";

		$orden = (string)$this->_request->getParam('orden', '');
    	$asc = (bool)$this->_request->getParam('asc', 0);
    	
    	if(empty($orden)){
    		$orden = "id";
    	}
		if($asc){
			$orden .= " ASC";
		}else{
			$orden .= " DESC";
		}
		$this->view->orden_asc = $asc;

		$this->view->archivos = Archivos::getAll(
			$this->session->sitio->id,
			0,
			$orden
		);
		$this->view->ruta = realpath('.') . DIRECTORY_SEPARATOR  . 'userfiles' . DIRECTORY_SEPARATOR;
		$this->render();
	}
	public function agregarAction()
	{
    	$this->view->subtitle = "Agregar";
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();

            $descripcion 	= trim( $this->_request->getPost('descripcion') );

			//FIXME: tiene que venir desde la configuración
            $ruta = realpath('.') . DIRECTORY_SEPARATOR  . 'userfiles' . DIRECTORY_SEPARATOR;

            if(!move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta . $_FILES['archivo']['name'])){
            	die('error al mover archivo');
            }
            if($descripcion){
                $data = array(
                    'nombre' 		=> $_FILES['archivo']['name'],
                    'descripcion' 	=> $descripcion,
                    'id_sitio' 		=> $this->session->sitio->id
                    //  'created_on'      => new Zend_Db_Expr('CURDATE()'),
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
        $this->view->archivo->ruta = '';

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

            $id 		= (int)$this->_request->getPost('id');
            $descripcion= trim($filter->filter($this->_request->getPost('descripcion')));

            if ($id !== false) {
                if ($descripcion != '') {
                    $data = array(
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
            	$pa = new PaginasArchivos();
            	$rows_affected = $pa->delete('id_archivo ='.$id);

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
    public function asociarAction(){

        if ($this->_request->isPost()) {

        	Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );

			$pagina = (int)$this->_request->getPost('pagina');

			/* Borro todas las relaciones a esa página y reconstruyo
			a continuación */
			$pa = new PaginasArchivos();
            $rows_affected = $pa->delete('id_pagina = ' . $pagina);

        	/** FIXME: ¿cómo sustituir este $_REQUEST? */
        	foreach( $_REQUEST as $key => $value){

        		if (substr_count($key, 'asociar') > 0 ){

                	$data = array(
                    	'id_pagina' 	=> $pagina,
                    	'id_archivo' 	=> $value
                	);
       				$pa->insert($data);
        		}
        	}
        	$this->_redirect('/admin/paginas/');
            return;
        }
		$orden = (string)$this->_request->getParam('orden', 0);
    	$asc = (bool)$this->_request->getParam('asc', 0);
    	if(empty($orden)){
    		$orden = "id";
    	}
		if($asc){
			$orden .= " ASC";
		}else{
			$orden .= " DESC";
		}
		$this->view->orden_asc = $asc;

		$this->view->pagina = (int)$this->_request->getParam('pagina', 0);
        $this->view->action = "asociar";
        $this->view->buttonText = "Asociar";
        //$archivos = Archivos::getAllAsociado($this->session->sitio->id);
        $archivos = Archivos::getAll(
        	$this->session->sitio->id,
        	0,
        	$orden
        )->toArray();


        foreach($archivos as &$value){
        	$aso = PaginasArchivos::getAsociacion($this->view->pagina, $value['id']);
        	if(count($aso)>0){
        		$value['id_pagina'] = $aso->id_pagina;
        	}else{
        		$value['id_pagina'] = null;
        	}
        }
        $this->view->archivos = $archivos;
	}
}
?>