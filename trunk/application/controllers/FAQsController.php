<?php
class FAQsController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('FAQs');
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function preDispatch(){
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
	}

	function indexAction(){
		$this->view->title = "FAQ";
		$faqs = new FAQs();
		$this->view->faqs = $faqs->fetchAll();
		$this->render();
	}

	function agregarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Agregar FAQ";
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');
			$filter 	= new Zend_Filter_StripTags();

			$pregunta 	= trim($filter->filter($this->_request->getPost('pregunta')));
			$respuesta 	= trim($filter->filter($this->_request->getPost('respuesta')));

			if( $pregunta != '' && $respuesta != '' ) {
				$data = array(
					'pregunta' 	=> $pregunta,
					'respuesta' => $respuesta
				);
				$faq = new FAQs();
				$faq->insert( $data );
				$this->_redirect('/faqs/');
				return;
			}
		}
		$this->view->faq = new stdClass();
		$this->view->faq->id = null;
		$this->view->faq->pregunta = '';
		$this->view->faq->respuesta = '';

		$this->view->action = 'agregar';
		$this->view->buttonText = 'Agregar';
		$this->render();
	}

	function modificarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Editar FAQ";
		$eFAQ = new FAQs();
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
						'respuesta' => $respuesta
					);
					$where = 'id = ' . $id;
					$eFAQ->update($data, $where);
					$this->_redirect('/faqs/');
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
		$this->view->action = 'modificar';
		$this->view->buttonText = 'Modificar';

		$this->render();
	}

	function eliminarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Eliminar FAQ";
		$faq = new FAQs();

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
		$this->_redirect('/faqs/');
	}

	function verAction(){
		$this->view->title = "Ver FAQ";
		$faq = new FAQs();
		$id = (int)$this->_request->getParam('id', 0);
		if ($id > 0) {
			$this->view->faq = $faq->fetchRow('id='.$id);
		}
		$this->render();
	}
}
?>