<?php
class Admin_MenuController extends Zcms_Generic_ControllerAdmin
{
    public function init()
    {
        parent::init();
        Zend_Loader::loadClass('Menu');
    }
    public function indexAction()
    {
    	$orden = (string)$this->_request->getParam('orden', 0);
    	$asc = (bool)$this->_request->getParam('asc', 0);
    	if(empty($orden)){
    		$orden = "id";
    	}
		if($asc){
			$orden .= " ASC";
		}else{
			$orden .= " DESC";
		}
		$this->view->orden_asc = $asc;
    	$this->view->subtitle = $this->info->sitio->menu->index->titulo;
        $this->view->menu = Menu::getAll($this->session->sitio->id, null, $orden);
    }
    public function agregarAction()
    {
        $pagina_id = (int)$this->_request->getParam('pagina');
        if( $pagina_id ){
            Zend_Loader::loadClass('Paginas');
            $pagina = new Paginas();
            $this->view->pagina = $pagina->fetchRow('id=' . $pagina_id);
        }
        $this->view->subtitle = $this->info->sitio->menu->agregar->titulo;
        $this->agregarModificar();
        $this->view->action = $this->info->sitio->menu->agregar->action;
        $this->view->buttonText = $this->info->sitio->menu->agregar->buttonText;
        $this->render();
    }
    public function modificarAction()
    {
        $this->view->subtitle = $this->info->sitio->menu->modificar->titulo;
        $this->agregarModificar();
        $this->view->action = $this->info->sitio->menu->agregar->action;
        $this->view->buttonText = $this->info->sitio->menu->agregar->buttonText;
        $this->render();
    }
    public function eliminarAction()
    {
        $this->view->subtitle = $this->info->sitio->menu->eliminar->titulo;

        $item = new Menu();

        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_Alpha');
            $filter = new Zend_Filter_Alpha();

            $id = (int)$this->_request->getPost('id');

            $del = $filter->filter($this->_request->getPost('del'));

            if ($del == 'Si' && $id > 0) {
                $where = 'id = ' . $id;
                $rows_affected = $item->delete($where);
            }
        } else {
            $id = (int)$this->_request->getParam('id');

            if ($id > 0) {
                $this->view->item = $item->fetchRow('id='.$id);
                if ($this->view->item->id > 0) {
                    $this->render();
                    return;
                }
            }
        }
        $this->_redirect('/admin/menu/');
    }
    public function verAction()
    {
        $this->view->subtitle = $this->info->sitio->menu->ver->titulo;

        $item = new Menu();

        $id = (int)$this->_request->getParam('id', 0);

        if ($id > 0) {
            $this->view->item = $item->fetchRow('id='.$id);
        }
        $this->render();
    }
    public function agregarModificar()
    {
        $eItem = new Menu();

        if($this->_request->isPost()){
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();

            $id			= $this->_request->getPost('id');

            $item		= trim($filter->filter($this->_request->getPost('item')));
            $destino	= trim($filter->filter($this->_request->getPost('destino')));
            $posicion	= trim($filter->filter($this->_request->getPost('posicion')));
            $privado	= trim($filter->filter($this->_request->getPost('privado')));
            $estado		= trim($filter->filter($this->_request->getPost('estado')));

            if($item != '' && $destino != '' && $estado != ''){
                $data = array(
                    'item'		=> $item,
                    'destino'	=> $destino,
                    'posicion'	=> $posicion,
                    'privado'	=> $privado,
                    'estado'	=> $estado,
                	'id_sitio'	=> $this->session->sitio->id
                );

                if((int)$id > 0){
                    $where = ' id=' . (int)$id;
                    $eItem->update($data, $where);
                }else{
                    $eItem->insert($data);
                }

                $this->_redirect('/admin/menu/');
                return;
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
        }
        if(is_numeric($id) && $id > 0){
            #verificar que el item exista para no mostrar error
            $this->view->item = $eItem->fetchRow('id='.$id);
        }else{

            $this->view->item = new stdClass();
            $this->view->item->id = null;
            $this->view->item->item = '';
            $this->view->item->destino = '';
            $this->view->item->posicion = '';
            $this->view->item->privado = '0';
            $this->view->item->estado = '0';
        	if( $this->view->pagina ){
        		$this->view->item->item = $this->view->pagina->titulo;
            	$this->view->item->destino = '/frontend/paginas/ver/id/'.$this->view->pagina->id;
        	}
        }
        return;
    }
}
?>