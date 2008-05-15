<?php
class Sitios extends Zend_Db_Table_Abstract
{
	protected $_name = 'sitios';

	public static function getSitioDefault()
	{
		$sitios = new Sitios();
		$sitio_default = $sitios->fetchRow("por_defecto = 1");
		
		if( $sitio_default == NULL){
			$sitio_default = Sitios::getAll(null, 1, "orden");			
		}	
		return $sitio_default;
	}
	public static function getAll($where = null, $limit = 0, $orden = "id")
	{
		$sitios = new Sitios();

		if( $limit == 1){
			//FIXME
			$sitios_encontrados = $sitios->fetchAll($where, $orden, $limit);
			foreach( $sitios_encontrados as $sitio){
				return $sitio;
			}
		}else{
			return $sitios->fetchAll($where, $orden, $limit);
		}

	}
	public static function getSitio( $nombre )
	{
		$sitios = new Sitios();
		return $sitios->fetchRow("nombre = '".$nombre."'");
	}
	public static function setPorDefecto($id)
	{
		$Sitios = new Sitios();
		$Sitios->update( array('por_defecto' => 0));
		$Sitios->update( array('por_defecto' => 1), 'id = ' . $id);				
	}
}
