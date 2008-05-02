<?php
class Menus extends Zend_Db_Table_Abstract
{
	protected $_name = 'menus';

	public static function getAll( $sitio = null, $limit = 0 )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$order = "id";
		$menus = new Menus();
		return $menus->fetchAll($where, $order, $limit);
	}
	public static function getMenus( $id )
	{
		$menus = new Menus();		
		return $menus->fetchRow("id = '$id'");
	}
}
?>