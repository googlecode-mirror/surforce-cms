<?php
class Frontend_AutenticacionController extends Zcms_Generic_Controller 
{
    function indexAction()
    {
        $this->_redirect('/');
    }
    function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
    function loginAction()
    {
        $info = Zend_Registry::get('personalizacion');
        $this->view->message = '';
        
        if ($this->_request->isPost()) {

            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $f = new Zend_Filter_StripTags();
            
            $usuario 	= $f->filter($this->_request->getPost('usuario'));
            $password 	= $f->filter($this->_request->getPost('password'));

            if (empty($usuario)) {
                $this->view->message = $info->sitio->autenticacion->login->msgNombreVacio;
            } else {

                Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
                
                $dbAdapter = Zend_Registry::get('dbAdapter');
                $autAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
                
                $autAdapter->setTableName('usuarios');
                $autAdapter->setIdentityColumn('usuario');
                $autAdapter->setCredentialColumn('password');
				
                
                $autAdapter->setIdentity($usuario);                
                /*
                 * Habilitar el login solo si 
                 * el usuario es estado = 1 
                 */
                if( Usuarios::isValid($usuario) ){
                	$autAdapter->setCredential(md5($password));
                }else{
                	$autAdapter->setCredential('');
                }

                $aut = Zend_Auth::getInstance();
                $result = $aut->authenticate($autAdapter);

                if ($result->isValid()) {
                	Usuarios::isValid();
                    $data = $autAdapter->getResultRowObject(null, 'password');
                    $aut->getStorage()->write($data);
                    $this->_redirect('/');
                } else {
                    $this->view->message = $info->sitio->autenticacion->login->msgUserPassIncorrectos;
                }
            }
        }
        $this->view->title = $info->sitio->autenticacion->login->titulo;
        $this->view->scriptJs = "scriptaculous";
        $this->render();
    }
}
?>