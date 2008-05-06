<?php
class Admin_FaqsController extends Zcms_Generic_ControllerAdmin
{
    public function init()
    {
        parent::init();
        Zend_Loader::loadClass('Faqs');
    }
    public function indexAction()
    {
        $this->view->subtitle = $this->info->sitio->faqs->index->titulo;		        
        $this->view->faqs = Faqs::getAll(
			$this->session->sitio->id
		);
        $this->render('admin');    
    }
    public function agregarAction()
    {
        $this->view->subtitle = $this->info->sitio->faqs->agregar->titulo;

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();

            $pregunta 	= trim($filter->filter($this->_request->getPost('pregunta')));
            $respuesta 	= trim( $this->_request->getPost('respuesta') );

            if( $pregunta != '' && $respuesta != '' ) {
                $data = array(
                    'pregunta' 	=> $pregunta,
                    'respuesta' => $respuesta,
                	'id_sitio'	=> $this->session->sitio->id
                );
                $faq = new Faqs();
                $faq->insert( $data );
                $this->_redirect('/admin/faqs/');
                return;
            }
        }
        $this->view->faq = new stdClass();
        $this->view->faq->id = null;
        $this->view->faq->pregunta 	= '';
        $this->view->faq->respuesta = '';

        $this->view->action = $this->info->sitio->faqs->agregar->action;
        $this->view->buttonText = $this->info->sitio->faqs->agregar->buttonText;
        $this->render();
    }
    public function modificarAction()
    {    
        $this->view->subtitle = $this->info->sitio->faqs->modificar->titulo;

        $eFAQ = new Faqs();
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');

            $filter = new Zend_Filter_StripTags();

            $id 		= (int)$this->_request->getPost('id');
            $pregunta	= trim($filter->filter($this->_request->getPost('pregunta')));
            $respuesta 	= trim($filter->filter($this->_request->getPost('respuesta')));

            if ($id !== false) {
                if ($pregunta != '' && $respuesta != '' ) {
                    $data = array(
                        'pregunta' 	=> $pregunta,
                        'respuesta' => $respuesta,
                    	'id_sitio'	=> $this->session->sitio->id
                    );
                    $where = 'id = ' . $id;
                    $eFAQ->update($data, $where);
                    $this->_redirect('/admin/faqs/');
                    return;
                } else {
                    $this->view->faq = $eFAQ->fetchRow('id='.$id);
                }
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $this->view->faq = $eFAQ->fetchRow('id='.$id);
            }
        }
        $this->view->action = $this->info->sitio->faqs->modificar->action;
        $this->view->buttonText = $this->info->sitio->faqs->modificar->buttonText;

        $this->render();
    }
    public function eliminarAction()
    {
        $this->view->subtitle = $this->info->sitio->faqs->eliminar->titulo;
        $faq = new Faqs();

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_Alpha');
            $filter = new Zend_Filter_Alpha();

            $id 	= (int)$this->_request->getPost('id');
            $del 	= $filter->filter($this->_request->getPost('del'));

            if ($del == 'Si' && $id > 0) {
                $where = 'id = ' . $id;
                $rows_affected = $faq->delete($where);
            }
        } else {
            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
                $this->view->faq = $faq->fetchRow('id='.$id);
                if ($this->view->faq->id > 0) {
                    $this->render();
                    return;
                }
            }
        }
        $this->_redirect('/admin/faqs/');
    }
    public function verAction()
    {
        $this->view->subtitle = $this->info->sitio->faqs->ver->titulo;
        $faq = new Faqs();
        $id = (int)$this->_request->getParam('id', 0);
        if ($id > 0) {
            $this->view->faq = $faq->fetchRow('id='.$id);
        }
        $this->render();
    }
}
?>