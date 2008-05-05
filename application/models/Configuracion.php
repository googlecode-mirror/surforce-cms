<?php
/*
 * FIXME: los Sitios deben estar asociados a sus Configuraciones.
 * Modificar el Model Sitios.
 */
class Configuracion extends Zend_Db_Table_Abstract
{
	protected $_name = 'configuracion';

	public static function getAll( $sitio = null, $limit = 0 )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$order = "id";
		$configuracion = new Configuracion();
		return $configuracion->fetchAll($where, $order, $limit);
	}
	public static function getConfiguracion( $id )
	{
		$configuracion = new Configuracion();		
		return $configuracion->fetchRow("id = '$id'");
	}
	public static function getConfiguracionDefault()
	{
		$sitio = Sitios::getSitioDefault();
		
		if( $sitio == NULL){
			$sitio = Sitios::getAll(null, 1);			
		}		
		$configuracion = new Configuracion();
		$configuracion->fetchRow("id = '$sitio->id'");
	}
}
?>