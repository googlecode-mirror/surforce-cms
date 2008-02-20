<?php

abstract class Zcms_Generic_Controller extends Zend_Controller_Action
{
    function init()
    {
        $this->initView();
        $this->view->baseUrl = $this->_request->getBaseUrl();
        $this->view->setScriptPath('./application/views/scripts/');
        $this->view->setHelperPath('./application/views/helpers/', 'Helper');

        Zend_Loader::loadClass('Configuracion');
        $this->view->user = Zend_Auth::getInstance()->getIdentity();
        $this->info = Zend_Registry::get('personalizacion');
        $this->view->title = $this->info->sitio->index->index->titulo;

        $configuracion = new Configuracion();
        $this->view->configuracion_array = $configuracion->fetchAll();
        /*
         * FIXME!
         */
        foreach( $this->view->configuracion_array as $c ){
            $this->view->configuracion = $c;
        }
    }
}
?>