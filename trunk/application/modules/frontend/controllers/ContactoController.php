<?php
class Frontend_ContactoController extends Zcms_Generic_Controller
{
    function init()
    {
        parent::init();
        Zend_Loader::loadClass('Contacto');
    }
    function indexAction()
    {
        //Obtenemos las etiquetas que necesitemos del archivo config.ini
        $this->view->buttonText = $this->info->sitio->contacto->agregar->buttonText;
        $this->view->subtitle = $this->info->sitio->contacto->agregar->titulo;     
    }
    function agregarAction()
    {
        $this->view->subtitle = $this->info->sitio->contacto->agregar->titulo;
        $this->view->contacto = new stdClass();
        $this->view->action = $this->info->sitio->usuarios->agregar->action;
        $this->view->buttonText = $this->info->sitio->contacto->agregar->buttonText;
            
        if ($this->_request->isPost()) {
            Zend_Loader::loadClass('Zend_Filter_StripTags');
            $filter 	= new Zend_Filter_StripTags();
            
            $this->view->contacto->nombre 	= trim($filter->filter($this->_request->getPost('nombre')));
            $this->view->contacto->email  	= trim($filter->filter($this->_request->getPost('email')));
            $this->view->contacto->comentario = trim($filter->filter($this->_request->getPost('comentario')));
            $this->view->contacto->telefono   = trim($filter->filter($this->_request->getPost('telefono')));
            $fecha		= date("Y-m-d H:i:s");
            
            if ($this->view->contacto->nombre != '' && 
                $this->view->contacto->email != '' && 
                $this->view->contacto->comentario != '' && 
                $this->view->contacto->telefono !='' ) {
                	
                $data = array(
                    'nombre' 	=> $this->view->contacto->nombre,
                    'email' 	=> $this->view->contacto->email,
                    'comentario'=> $this->view->contacto->comentario,
                    'telefono'  => $this->view->contacto->telefono,
                    'fecha' 	=> $fecha,
                	'id_sitio'	=> $this->session->sitio->id
                );
                $contacto = new Contacto();
                $contacto->insert($data);
                
                //Enviamos el correo.
                $destinatario   = $this->view->contacto->email;
                $asunto         = $this->info->sitio->contacto->add->asunto;
                $cuerpo         = $this->view->contacto->nombre." ".$this->view->contacto->comentario;
                $headers        = $this->info->sitio->contacto->add->sender;;
                
                mail($destinatario,$asunto,$cuerpo,$headers);

                $this->view->message = " El comentario fue enviado con exito ! Muchas gracias.";
                $this->view->buttonText = $this->info->sitio->contacto->agregar->buttonText;
                return;
            }else{
                $this->view->message = "Deben completar todos los campos";
            }
        }
        $this->render();
    }
}
?>