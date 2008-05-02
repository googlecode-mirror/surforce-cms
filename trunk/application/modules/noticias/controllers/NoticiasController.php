<?php
class Noticias_NoticiasController extends Zcms_Generic_Controller
{
    function init()
    {
        parent::init();
        Zend_Loader::loadClass('Noticias');
    }
	function indexAction() 
	{
		$this->view->subtitle = $this->info->sitio->noticias->index->titulo;
		
		$limit = 0;
		
		if (!$this->view->usuarioLogueado) {
			$limit = 3;
		}
		$this->view->noticias = Noticias::getAll(
			$this->session->sitio->id, 
			$limit
		);
	}
    function historicoAction()
    {
        $this->view->subtitle = $this->info->sitio->noticias->index->titulo . " histórico ";
        $noticias = new Noticias();
        $where = array();
        $order = "fecha DESC";
        $this->view->noticias = $noticias->fetchAll($where, $order);
    }
   function verAction(){
        $this->view->subtitle = $this->info->sitio->noticias->ver->titulo;
        $noticia = new Noticias();
        $id = (int)$this->_request->getParam('id', 0);
        if ($id > 0) {
            $this->view->noticia = $noticia->fetchRow('id='.$id);
        }
    }
}
?>