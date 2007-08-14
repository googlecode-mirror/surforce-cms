<?php
class ConfiguracionesController extends Zend_Controller_Action{

	function init(){
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		Zend_Loader::loadClass('Selectores');
		Zend_Loader::loadClass('Propiedades');
		Zend_Loader::loadClass('PropiedadesSelectores');
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
	}

	function preDispatch(){
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$this->view->usuarioLogueado = true;
		}
	}

	function indexAction(){
		$this->view->title = "Configuraciones-Styles";
		$selectores = new Selectores();
		$this->view->selectores = $selectores->fetchAll();
		$this->render();
	}

function modificarAction(){
		if( !$this->view->usuarioLogueado){
			die( "Acción no permitida ");
		}

		$this->view->title = "Editar Style";
		$eSelector = new Selectores();
		$ePropiedades = new Propiedades();
		$ePropiedadesSelectores = new PropiedadesSelectores;
		if ($this->_request->isPost()) {
			Zend_Loader::loadClass('Zend_Filter_StripTags');

			$filter = new Zend_Filter_StripTags();

			$id 			= 	(int)$this->_request->getPost('id');
			$selector	 	= trim($filter->filter($this->_request->getPost('selector')));
			$descripcion 	= trim($filter->filter($this->_request->getPost('descripcion')));
			
			if ($id !== false) {
				if ($selector != '') {
					$data = array(
						'selector' 	=> $selector,
						'descripcion' 	=> $descripcion
					);
					$where = 'id_selector = ' . $id;
					$eSelector->update($data, $where);
					
					//Recorremos todas las propiedades
					$propiedades = $ePropiedades->fetchAll();
					foreach ($propiedades as $propiedad):
						$valor 			= 	$this->_request->getPost($propiedad->id_propiedad);
						if($valor != ''):
							//Verificamos si hay que actualizar o agregar un nuevo registro
							$where = 'id_propiedad = ' . $propiedad->id_propiedad . ' and id_selector = '.$id;
							$ePropiedadSelector = $ePropiedadesSelectores->fetchRow($where);
							if($ePropiedadSelector != ''):
								$data = array(
									'valor' 	=> $valor
								);
								$ePropiedadesSelectores->update($data, $where);
							else:
								$data = array(
									'id_selector'	=> $id,
									'id_propiedad'	=> $propiedad->id_propiedad,
									'valor'			=> $valor
								);
								$ePropiedadesSelectores->insert($data);
							endif;
						endif;
					endforeach;
					//exit;
					$this->_redirect('/configuraciones/');
					return;
				} else {
					$this->view->selector = $eSelector->fetchRow('id_selector='.$id);
				}
			}
		} else {
			$id = (int)$this->_request->getParam('id', 0);
			if ($id > 0) {
			
				$this->view->selector = $eSelector->fetchRow('id_selector='.$id);
				//Mostramos todas las propiedades
				$this->view->propiedades = $ePropiedades->fetchAll();	
				//
				$this->view->pSelectores = $ePropiedadesSelectores->fetchAll('id_selector='.$id);
			}
			
			$this->view->action = 'modificar';
			$this->view->buttonText = 'Modificar';

			$this->render();
		}
		
	}
}
?>
