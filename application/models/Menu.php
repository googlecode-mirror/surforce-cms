<?php
class Menu extends Zend_Db_Table_Abstract
{
	protected $_name = 'menu';

	public static function getAll( $sitio = null, $limit = 0 )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$order = "id";
		$menu = new Menu();
		return $menu->fetchAll($where, $order, $limit);
	}
	public static function getMenu( $id )
	{
		$menu = new Menu();		
		return $menu->fetchRow("id = '$id'");
	}
}
?>