<?php
class Archivos extends Zend_Db_Table {
	
	protected $_name = 'archivos';
	public static function getAll($sitio = null, $limit = 0)
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$order = "id";
		
		$archivos = new Archivos();
		return $archivos->fetchAll($where, $order, $limit);		
	}
	public static function getArchivo($id)
	{
		$archivos = new Archivos();
		return $archivos->fetchRow('id = '.$id );		
	}
}
?>
