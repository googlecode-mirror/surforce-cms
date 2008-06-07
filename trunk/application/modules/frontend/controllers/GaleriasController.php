<?php
class Frontend_GaleriasController extends Zcms_Generic_Controller
{
    public function init()
    {
        parent::init();
        Zend_Loader::loadClass('Galerias');
    }
	public function indexAction()
	{
		$this->view->subtitle = "ABM Galería";
		$this->view->archivos = Galerias::getAll($this->session->sitio->id);
		$this->render();
	}

}
?>