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

}
?>