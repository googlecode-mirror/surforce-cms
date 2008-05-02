<?php
class PaginasArchivos extends Zend_Db_Table {
	
	protected $_name = 'paginas_archivos';

	public static function getArchivos( $id_pagina)
	{
		$archivos = new PaginasArchivos();
		return $archivos->fetchAll('id_pagina = '.$id_pagina);		
	}
	public static function getPaginas( $id_archivo)
	{
		$archivos = new PaginasArchivos();
		return $archivos->fetchAll('id_archivo = '.$id_archivo);		
	}
}
?>
