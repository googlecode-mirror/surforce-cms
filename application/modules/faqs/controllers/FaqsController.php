<?php
class Faqs_FaqsController extends Zcms_Generic_Controller
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
    }
	public function verAction()
	{
        $this->view->subtitle = $this->info->sitio->faqs->ver->titulo;
        
        $id = (int)$this->_request->getParam('id', 0);
        if ($id > 0) {
            $this->view->faq = Faqs::getFaq($id);
        }
    }
}
?>