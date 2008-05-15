<?php
class Menu extends Zend_Db_Table_Abstract
{
	protected $_name = 'menu';

	public static function getAll( $sitio = null, $limit = 0, $order = "id" )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$menu = new Menu();
		return $menu->fetchAll($where, $order, $limit);
	}
	public static function getMenu( $id )
	{
		$menu = new Menu();
		return $menu->fetchRow("id = '$id'");
	}
	public static function getMenuSitio($id)
	{
		$Menu = new Menu();
		return $Menu->fetchAll('estado = 1 AND id_sitio='.$id, 'privado,posicion');
	}	
}
?>