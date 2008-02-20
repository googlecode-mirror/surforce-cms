<?php
class Admin_ConfiguracionController extends Zcms_Generic_Controller{

/*
    function init(){
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->setScriptPath('./application/views/scripts/');
        Zend_Loader::loadClass('Configuracion');
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
        $this->info = Zend_Registry::get('personalizacion');
         $this->view->title = $this->info->sitio->index->index->titulo;
    }
*/
    function preDispatch(){
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->usuarioLogueado = true;
        }
    }

    function indexAction(){
        $this->view->subtitle = "ABM Configuración";
        $configuracion = new Configuracion();
        $this->view->configuracion_array = $configuracion->fetchAll();
        /*
         * FIXME!
         */
        foreach( $this->view->configuracion_array as $c ){
            $this->view->configuracion = $c;
        }
        $this->render();
    }

    function modificarAction(){

        $this->view->subtitle = "Modificar Configuración";
        $configuracion = new Configuracion();
        if ($this->_request->isPost()) {

            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();

            $id = (int)$this->_request->getPost('id');
            $sitio_color_fondo 	= trim($filter->filter($this->_request->getPost('sitio_color_fondo')));
            $sitio_color_cabezal = trim($filter->filter($this->_request->getPost('sitio_color_cabezal')));
            $sitio_color_pie = trim($filter->filter($this->_request->getPost('sitio_color_pie')));

            if ($id !== false) {
                $data = array(
                    'sitio_color_fondo' 	=> $sitio_color_fondo,
                    'sitio_color_cabezal' 	=> $sitio_color_cabezal,
                    'sitio_color_pie' 	=> $sitio_color_pie,
                );
                $where = 'id = ' . $id;
                $configuracion->update($data, $where);
                $this->_redirect('/admin/configuracion/');
                return;
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $this->view->configuracion_array = $configuracion->fetchAll();
                /*
                * FIXME!
                */
                foreach( $this->view->configuracion_array as $c ){
                    $this->view->configuracion = $c;
                }
            }
        }
        $this->view->action = "Modificar";
        $this->view->buttonText = "Modificar";

        $this->render();
    }
}
?>
