<?php
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
}
?>