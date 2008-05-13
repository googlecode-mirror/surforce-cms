<?php
class Contacto extends Zend_Db_Table{

    //Indicamos el nombre de la tabla para que la gestione.
    //Se asume que la tabla tiene una PK Autoincrementable.
	protected $_name = 'contacto';

	public static function getAll( $sitio = null, $limit = 0, $order = "id" )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}
		$Contacto = new Contacto();
		return $Contacto->fetchAll($where, $order, $limit);
	}

}
?>
