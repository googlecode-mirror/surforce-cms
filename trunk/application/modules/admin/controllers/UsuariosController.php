<?php
class Admin_UsuariosController extends Zcms_Generic_ControllerAdmin
{
    public function init()
    {
        parent::init();
        Zend_Loader::loadClass('Usuarios');
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

        $this->view->subtitle = $this->info->sitio->usuarios->index->titulo;
        $this->view->usuarios = Usuarios::getAll(
        	$this->session->sitio->id,
        	0,
        	$orden
        );
        $this->render();
    }
    public function agregarAction()
    {
        $this->view->subtitle = $this->info->sitio->usuarios->agregar->titulo;
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();
            $usuario 	= trim($filter->filter($this->_request->getPost('usuario')));
            $password 	= trim($filter->filter($this->_request->getPost('password')));
            $nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
            $apellido 	= trim($filter->filter($this->_request->getPost('apellido')));
            $mail 		= trim($filter->filter($this->_request->getPost('mail')));
            $estado 	= "1";
            $creado		= date("Y-m-d H:i:s");
            if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $mail != '') {
                $data = array(
                    'usuario' 	=> $usuario,
                    'password' 	=> $password,
                    'nombre' 	=> $nombre,
                    'apellido' 	=> $apellido,
                    'mail' 		=> $mail,
                    'estado' 	=> $estado,
                    'creado' 	=> $creado,
                	'id_sitio'	=> $this->session->sitio->id
                );
                $usuario = new Usuarios();
                $usuario->insert($data);
                $this->_redirect('/admin/usuarios/');
                return;
            }else{
                $this->view->message = "Deben llenarse todos los campos";
            }
        }
        $this->view->usuario = new stdClass();
        $this->view->usuario->id = null;
        $this->view->usuario->usuario = '';
        $this->view->usuario->password = '';
        $this->view->usuario->nombre = '';
        $this->view->usuario->apellido = '';
        $this->view->usuario->mail = '';
        $this->view->action = $this->info->sitio->usuarios->agregar->action;
        $this->view->buttonText = $this->info->sitio->usuarios->agregar->buttonText;
        $this->render();
    }
    public function modificarAction()
    {
        $this->view->subtitle = $this->info->sitio->usuarios->modificar->titulo;
        $eUsuario = new Usuarios();
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter = new Zend_Filter_StripTags();
            $id = (int)$this->_request->getPost('id');
            $usuario 	= trim($filter->filter($this->_request->getPost('usuario')));
            $password 	= trim($filter->filter($this->_request->getPost('password')));
            $nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
            $apellido 	= trim($filter->filter($this->_request->getPost('apellido')));
            $mail 		= trim($filter->filter($this->_request->getPost('mail')));
            $estado		= trim($filter->filter($this->_request->getPost('estado')));
            if ($id !== false) {
                if ($usuario != '' && $password != '' && $nombre != '' && $apellido != '' && $mail != '') {
                    $data = array(
                        'usuario' 	=> $usuario,
                        'password' 	=> $password,
                        'nombre' 	=> $nombre,
                        'apellido' 	=> $apellido,
                        'mail' 		=> $mail,
                    	'estado' 	=> $estado
                    );
                    $where = 'id = ' . $id;
                    $eUsuario->update($data, $where);
                    $this->_redirect('/admin/usuarios/');
                    return;
                } else {
                    $this->view->usuario = $eUsuario->fetchRow('id='.$id);
                    $this->view->message = "Deben llenarse todos los campos";
                }
            }
        } else {
            $id = (int)$this->_request->getParam('id', 0);
            if ($id > 0) {
                $this->view->usuario = $eUsuario->fetchRow('id='.$id);
            }
        }
        $this->view->action = $this->info->sitio->usuarios->modificar->action;
        $this->view->buttonText = $this->info->sitio->usuarios->modificar->buttonText;

        $this->render();
    }
    public function eliminarAction()
    {
        $this->view->subtitle = $this->info->sitio->usuarios->eliminar->titulo;
        $usuario = new Usuarios();
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_Alpha');
            $filter = new Zend_Filter_Alpha();
            $id = (int)$this->_request->getPost('id');
            $del = $filter->filter($this->_request->getPost('del'));
            if ($del == 'Si' && $id > 0) {
                $where = 'id = ' . $id;
                $rows_affected = $usuario->delete($where);
            }
        } else {
            $id = (int)$this->_request->getParam('id');
            if ($id > 0) {
                $this->view->usuario = $usuario->fetchRow('id='.$id);
                if ($this->view->usuario->id > 0) {
                    $this->render();
                    return;
                }
            }
        }
        $this->_redirect('/admin/usuarios/');
    }
    public function verAction()
    {
        $this->view->subtitle = $this->info->sitio->usuarios->ver->titulo;
        $usuario = new Usuarios();
        $id = (int)$this->_request->getParam('id', 0);
        if ($id > 0) {
            $this->view->usuario = $usuario->fetchRow('id='.$id);
        }
        $this->render();
    }
}
?>
