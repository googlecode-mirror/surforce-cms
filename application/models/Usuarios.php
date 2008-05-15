<?php
class Usuarios extends Zend_Db_Table_Abstract
{
	protected $_name = 'usuarios';

	public static function getAll( $sitio = null, $limit = 0, $order = "id"  )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}

		$usuarios = new Usuarios();
		return $usuarios->fetchAll($where, $order, $limit);
	}
	public static function getUsuario( $id )
	{
		$usuario = new Usuarios();
		return $usuario->fetchRow("id = '$id'");
	}
	public static function isValid( $usuario )
	{
		$Usuarios = new Usuarios();
		$result = $Usuarios->fetchRow("usuario = '".$usuario."' AND estado = 1");
		
		return $result <> NULL;
	}
}
?>