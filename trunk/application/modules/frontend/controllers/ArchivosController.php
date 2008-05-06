<?php
class Frontend_ArchivosController extends Zcms_Generic_Controller
{
    public function init()
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
	public function asociarAction(){       	
        if ($this->_request->isPost()) {
        	Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ( );
			$pagina = (int)$this->_request->getPost('pagina');
		
        	/** FIXME: ¿cómo sustituir este $_REQUEST? */
        	foreach( $_REQUEST as $key => $value){        		
        		if (substr_count($key, 'asociar') > 0 ){
        			echo $key . "=>" . $value . "<br>";
                	$data = array(
                    	'id_pagina' 	=> $pagina,
                    	'id_archivo' 	=> $value
                	);
        			if( PaginasArchivos::getAsociacion($pagina, $value) == 0 ){
        				$PaginaArchivo = new PaginasArchivos();
                		$PaginaArchivo->insert($data); 
        			}					
        		}        		
        	}
        	$this->_redirect('/admin/paginas/');
            return;
        }
	
			
		$this->view->pagina = (int)$this->_request->getParam('pagina', 0);		         
        $this->view->action = "asociar";
        $this->view->buttonText = "Asociar";
        $this->view->archivos = Archivos::getAll($this->session->sitio->id);
	}
}
?>