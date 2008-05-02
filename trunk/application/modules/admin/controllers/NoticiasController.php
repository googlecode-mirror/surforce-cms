<?php
class Admin_NoticiasController extends Zcms_Generic_ControllerAdmin
{
    function init()
    {
        parent::init();
        Zend_Loader::loadClass('Noticias');
    }
    function indexAction()
    {
    	$this->view->noticias = Noticias::getAll($this->session->sitio->id);
        $this->view->subtitle = $this->info->sitio->noticias->index->titulo;
        $this->render('admin');
    }
    function agregarAction(){
        //$info = Zend_Registry::get('personalizacion');
        if( !$this->view->usuarioLogueado){
            die( $this->info->sitio->noticias->agregar->msgRestringido);
        }
        $this->view->subtitle = $this->info->sitio->noticias->agregar->titulo;
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();

            $titulo 		= trim($filter->filter($this->_request->getPost('titulo')));
            $contenido 	= trim( $this->_request->getPost('contenido') );
            $contenido_ext 	= trim( $this->_request->getPost('contenido_ext') );

            if( $titulo != '' && $contenido ) {
                $data = array(
                    'titulo' 		=> $titulo,
                    'contenido' 	=> $contenido,
                    'contenido_ext' => $contenido_ext,
                	'id_sitio'		=> $this->session->sitio->id
                );
                $noticia = new Noticias();
                $noticia->insert( $data );
                $this->_redirect('/admin/noticias/');
                return;
            }
        }
        $this->view->noticia = new stdClass();
        $this->view->noticia->id = null;
        $this->view->noticia->titulo = '';
        $this->view->noticia->contenido = '';
        $this->view->noticia->contenido_ext = '';

        $this->view->action = $this->info->sitio->noticias->agregar->action;
        $this->view->buttonText = $this->info->sitio->noticias->agregar->buttonText;
        $this->render();
    }
    function modificarAction()
    {
        //$info = Zend_Registry::get('personalizacion');
        if( !$this->view->usuarioLogueado){
            die( $this->info->sitio->noticias->modificar->msgRestringido );
        }
        $this->view->subtitle = $this->info->sitio->noticias->modificar->titulo;
        $eNoticia = new Noticias();
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');

            $filter = new Zend_Filter_StripTags();

            $id 		= (int)$this->_request->getPost('id');
            $titulo	 	= trim($filter->filter($this->_request->getPost('titulo')));
            $contenido 	= trim( $this->_request->getPost('contenido') );
            $contenido_ext 	= trim( $this->_request->getPost('contenido_ext') );

            if ($id !== false) {
                if ($titulo != '' && $contenido != '' ) {
                    $data = array(
                        'titulo' 	=> $titulo,
                        'contenido' 	=> $contenido,
                        'contenido_ext' 	=> $contenido_ext,
                    );
                    $where = 'id = ' . $id;
                    $eNoticia->update($data, $where);
                    $this->_redirect('/admin/noticias/');
                    return;
                } else {
                    $this->view->noticia = $eNoticia->fetchRow('id='.$id);
                }
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $this->view->noticia = $eNoticia->fetchRow('id='.$id);
            }
        }
        $this->view->action = $this->info->sitio->noticias->modificar->action;
        $this->view->buttonText = $this->info->sitio->noticias->modificar->buttonText;

        $this->render();
    }
    function eliminarAction()
    {
        //$info = Zend_Registry::get('personalizacion');
        if( !$this->view->usuarioLogueado){
            die( $this->info->sitio->noticias->eliminar->msgRestringido );
        }

        $this->view->subtitle = $this->info->sitio->noticias->eliminar->titulo;
        $noticia = new Noticias();

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_Alpha');
            $filter = new Zend_Filter_Alpha();

            $id 	= (int)$this->_request->getPost('id');
            $del 	= $filter->filter($this->_request->getPost('del'));

            if ($del == 'Si' && $id > 0) {
                $where = 'id = ' . $id;
                $rows_affected = $noticia->delete($where);
            }
        } else {
            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
                $this->view->noticia = $noticia->fetchRow('id='.$id);
                if ($this->view->noticia->id > 0) {
                    $this->render();
                    return;
                }
            }
        }
        $this->_redirect('/admin/noticias/');
    }
    function verAction(){
        $this->view->subtitle = $this->info->sitio->noticias->ver->titulo;
        $noticia = new Noticias();
        $id = (int)$this->_request->getParam('id', 0);
        if ($id > 0) {
            $this->view->noticia = $noticia->fetchRow('id='.$id);
        }
        $this->render();
    }
}
?>