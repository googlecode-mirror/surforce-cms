<?php
class Noticias extends Zend_Db_Table_Abstract
{
	protected $_name = 'noticias';

	public static function getAll( $sitio = null, $limit = 0 )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$order = "fecha DESC";
		$noticias = new Noticias();
		return $noticias->fetchAll($where, $order, $limit);
	}
	public static function getNoticia( $id )
	{
		$noticias = new Noticias();		
		return $noticias->fetchRow("id = '$id'");
	}
}
?>