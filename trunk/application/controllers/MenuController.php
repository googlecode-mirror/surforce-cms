<?php
class MenuController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('Menu');
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function preDispatch(){
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
	}

	function indexAction(){
		$this->view->title = "Menú";
		$menu = new Menu();
		$this->view->menu = $menu->fetchAll();
		$this->render();
	}

	function agregarAction(){
		if(!$this->view->usuarioLogueado){
			die("Accion no permitida. ");
		}

		$this->view->title = "Agregar ítem al Menú";

		$this->agregarModificar();

		$this->view->action = 'agregar';
		$this->view->buttonText = 'Agregar';
		$this->render();
	}

	function modificarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Editar ítem del Menú";

		$this->agregarModificar();

		$this->view->action = 'modificar';
		$this->view->buttonText = 'Modificar';

		$this->render();
	}

	function eliminarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Eliminar ítem del Menú";

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
		$this->_redirect('/menu/');
	}

	function verAction(){
		$this->view->title = "Ver ítem de Menú";

		$item = new Menu();

		$id = (int)$this->_request->getParam('id', 0);

		if ($id > 0) {
			$this->view->item = $item->fetchRow('id='.$id);
		}

		$this->render();
	}

	function agregarModificar(){

		$eItem = new Menu();

		if($this->_request->isPost()){
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter = new Zend_Filter_StripTags();

			$id			= $this->_request->getPost('id');

			$item		= trim($filter->filter($this->_request->getPost('item')));
			$destino	= trim($filter->filter($this->_request->getPost('destino')));
			$estado		= trim($filter->filter($this->_request->getPost('estado')));

			if($item != '' && $destino != '' && $estado != ''){
				$data = array(
					'item'		=> $item,
					'destino'	=> $destino,
					'estado'	=> $estado
				);

				if((int)$id > 0){
					$where = ' id=' . (int)$id;
					$eItem->update($data, $where);
				}else{
					$eItem->insert($data);
				}

				$this->_redirect('/menu/');
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
			$this->view->item->estado = '0';
		}
		return;
	}
}

?>
