<?php
class Paginas_MenupagController extends Zcms_Generic_Controller{

	function init(){
        parent::init();
        Zend_Loader::loadClass('PaginasMenu');
    }

    function preDispatch(){
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->view->usuarioLogueado = true;
        }
    }

    function indexAction(){
        //$info = Zend_Registry::get('personalizacion');
        $this->view->subtitle = $this->info->sitio->paginas->index->titulo;
        $menus = new PaginasMenu();
        $this->view->paginas->menu = $menus->fetchAll();
        $this->render();
    }

    function agregarAction(){
        //$info = Zend_Registry::get('personalizacion');
        $this->view->buttonText = $this->info->sitio->paginas->agregar->buttonText;

        if( !$this->view->usuarioLogueado){
            die( $this->info->sitio->paginas->agregar->msgRestringido);
        }

        $this->view->subtitle = $this->info->sitio->menus->agregar->titulo;
		$this->view->id = (int)$this->_request->getParam('id');
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();
			$id_pag	= (int)$this->_request->getPost('id_pag');
			$id_menu	= (int)$this->_request->getPost('id_menu');
			$link	=	$this->_request->getPost('link');
            $titulo 	= trim($filter->filter($this->_request->getPost('titulo')));
            $alt 	= $this->_request->getPost('alt');

            if( $titulo != '' && $link ) {
                $data = array(
                    'titulo' 	=> $titulo,
                    'id_pagina' 	=> $id_pag,
                    'id_menu'	=> $id_menu,
                    'link'	=> $link,
                    'alt' => $alt
                );
                $menupag = new PaginasMenu();
                $menupag->insert( $data );
                $this->_redirect('/paginas/paginas/modificar/id/'.$id_pag);
                return;
            }
        }

	}


	function eliminarAction(){
        //$info = Zend_Registry::get('personalizacion');
        if( !$this->view->usuarioLogueado){
            die( $this->info->sitio->paginas->eliminar->msgRestringido);
        }

        $this->view->subtitle = $this->info->sitio->paginas->eliminar->titulo;
        $menupag = new PaginasMenu();

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_Alpha');
            $filter = new Zend_Filter_Alpha();

            $id 	= (int)$this->_request->getPost('id');
            $id_menu	=	(int)$this->_request->getPost('menu');
            $del 	= $filter->filter($this->_request->getPost('del'));

            if ($del == 'Si' && $id) {
                $where = 'id_pagina = ' . $id . ' and id_menu= '. $id_menu;
                $rows_affected = $menupag->delete($where);
            }
        } else {
            $id = (int)$this->_request->getParam('id');
            $id_menu	=	(int)$this->_request->getParam('menu');
            if ($id) {
                $this->view->menupag = $menupag->fetchRow('id_pagina='.$id.' and id_menu= '.$id_menu);
                if ($this->view->menupag->id_menu) {
                    $this->render();
                    return;
                }
            }
        }
        $this->_redirect('/paginas/paginas/modificar/id/'.$id);
    }

    function modificarAction(){
        //$info = Zend_Registry::get('personalizacion');
        if( !$this->view->usuarioLogueado){
            die( $this->info->sitio->paginas->modificar->msgRestringido);
        }

        $this->view->subtitle = $this->info->sitio->paginas->modificar->titulo;
        $menupag = new PaginasMenu();
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');

            $filter = new Zend_Filter_StripTags();

			$id	= (int)$this->_request->getPost('id');
			$id_menu	= (int)$this->_request->getPost('menu');
			$link	=	$this->_request->getPost('link');
            $titulo 	= trim($this->_request->getPost('titulo'));
            $alt 	= $this->_request->getPost('alt');

            if ($titulo!='' and $link) {
	            	$data = array(
	                    'titulo' 	=> $titulo,
	                    'id_pagina' 	=> $id,
	                    'id_menu'	=> $id_menu,
	                    'link'	=> $link,
	                    'alt' => $alt
	                );
                    $where = 'id_pagina = ' . $id;
                    $menupag->update($data, $where);
                    $this->_redirect('/paginas/paginas/modificar/id/'.$id);
                    return;
                } else {
                    $this->view->menupag = $menupag->fetchAll('id_pagina='.$id);

            }
        } else {
			$id	= (int)$this->_request->getParam('id');
			$id_menu	= (int)$this->_request->getParam('menu');
			$link	=	$this->_request->getParam('link');
            $titulo 	= trim($this->_request->getParam('titulo'));
            $alt 	= $this->_request->getParam('alt');


            if ($id > 0 and $link) {

            	 $data = array(
                    'titulo' 	=> $titulo,
                    'id_pagina' 	=> $id,
                    'id_menu'	=> $id_menu,
                    'link'	=> $link,
                    'alt' => $alt );

                $this->view->menupag = $menupag->fetchAll('id_pagina='.$id);
            }
        }
        $this->view->action = $this->info->sitio->paginas->modificar->action;
        $this->view->buttonText = $this->info->sitio->paginas->modificar->buttonText;

        $this->render();
    }

}
?>
