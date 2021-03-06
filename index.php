<?php
set_include_path(	'.' .
    PATH_SEPARATOR . './library/' .
    PATH_SEPARATOR . './application/' .
    PATH_SEPARATOR . './application/models/' .
    PATH_SEPARATOR . './html/' .
    PATH_SEPARATOR . get_include_path()
);

include "Zend/Loader.php";
Zend_Loader::registerAutoload();

/** CONFIGURACION **/
$registry = Zend_Registry::getInstance();

$config = new Zend_Config_Ini(
	'./application/config.ini', 
	'general'
);
$personalizacion = new Zend_Config_Ini(
	'./application/config.ini', 
	'personalizacion'
);

if($config->debug === 'on'){
	error_reporting(E_ALL|E_STRICT);	
}
date_default_timezone_set('America/Montevideo');

$registry->set('personalizacion', $personalizacion);
$registry->set('config', $config);
$registry->set('base_path', realpath('.') );
$registry->set('debug', $config->debug);

/* Start Session */ 
$session = new Zend_Session_Namespace('app');
$registry->set('session', $session);

/**
 * Zend_Layout
 */
Zend_Layout::startMvc(array(
    'layoutPath' => $registry->get('base_path') . '/application/scripts'
));
$view = Zend_Layout::getMvcInstance()->getView();

/* Menu: Hay que definir el contenido aquí, 
 * para luego ser pasado al layout y 
 * que lo renderee.
 * 
$view->menu_items = Menu::getMenuSitio();
*/

/* Setup Database */ 
$db = Zend_Db::factory(
	$config->db->adapter, 
	$config->db->config->toArray()
);
Zend_Db_Table::setDefaultAdapter($db);
Zend_Registry::set('dbAdapter', $db);

/* Setup Controller */ 
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(true);
$frontController->addModuleDirectory('./application/modules/');

/* run! */ 
try {
	$frontController->dispatch();
} catch(Exception $e) {
	echo nl2br($e->__toString());
}
// Según la documentación, no se cierra el tag PHP en el index.php porque no se necesita y así
// se previenen errores difíciles de encontrar como con la funcion header() si se deja un
// espacio en blanco al final (habría que confirmar esto).
