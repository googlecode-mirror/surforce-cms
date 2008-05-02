<?php
class MenusItems extends Zend_Db_Table_Abstract
{
	protected $_name = 'menus_items';

	public static function getAll( $sitio = null, $limit = 0 )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$order = "id";
		$items = new MenusItems();
		return $items->fetchAll($where, $order, $limit);
	}
	public static function getMenuItem( $id_item )
	{
		$items = new MenusItems();		
		return $items->fetchRow("id = '$id_item'");
	}
}
?>