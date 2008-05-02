<?php
class Sitios extends Zend_Db_Table_Abstract
{
	protected $_name = 'sitios';
	
	public static function getSitioDefault()
	{
		$sitios = new Sitios();
		return $sitios->fetchRow("por_defecto = 1");
	}
	public static function getAll()
	{
		$sitios = new Sitios();
		return $sitios->fetchAll(null, "id");
	}
	public static function getSitio( $nombre )
	{
		$sitios = new Sitios();
		return $sitios->fetchRow("nombre = '$nombre'");
	}
}
