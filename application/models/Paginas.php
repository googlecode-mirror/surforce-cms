<?php
class Paginas extends Zend_Db_Table_Abstract
{
	protected $_name = 'paginas';

	public static function getAll( $sitio = null, $limit = 0, $order = "id" )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$paginas = new Paginas();
		return $paginas->fetchAll($where, $order, $limit);
	}
	public static function getPagina( $id )
	{
		$pagina = new Paginas();
		return $pagina->fetchRow("id = '$id'");
	}
}
?>