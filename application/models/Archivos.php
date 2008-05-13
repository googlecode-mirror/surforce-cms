<?php
class Archivos extends Zend_Db_Table {

	protected $_name = 'archivos';
	protected $_dependentTables = array('paginas_archivos');

	/**
	 * SUPER-FIXME!
	*/
	public static function getAllAsociado($sitio = null, $pagina = null, $limit = 0, $orden = "id")
	{
	    $registry = Zend_Registry::getInstance();
    	$r = $registry->get('config');
    	$db = new Zend_Db_Adapter_Pdo_Mysql(array(
        	'host'     => $r->db->config->host,
        	'username' => $r->db->config->username,
        	'password' => $r->db->config->password,
        	'dbname'   => $r->db->config->dbname
        ));
		$sql = ' select distinct(a.id),a.*, pa.* from archivos as a left join paginas_archivos as pa ON pa.id_archivo = a.id ';

	    if( $sitio){
	    	$where = "where ";
	    	$sql_add[] = "a.id_sitio = ".$sitio." ";
	    }
	    if( $pagina ){
	    	$where = "where ";
	    	$sql_add[] = "pa.id_pagina = ".$pagina." ";
	    }
	    $where = $where . implode(' AND ', $sql_add);
	    echo $sql . $where;
	    $result = $db->query($sql . $where );
    	$archivos = $result->fetchAll();
    	return $archivos;
	}
	/*
	 * select *
from archivos as a
inner join paginas_archivos as pa ON pa.id_archivo = a.id
where a.id_sitio = 6
	 */
	/* FIXME: por algo como esto:
		 *
		$select = $table->select();
		$select->where('bug_status = ?', 'NEW')
       ->join('accounts', 'accounts.account_name = bugs.reported_by')
       ->where('accounts.account_name = ?', 'Bob');

		$rows = $table->fetchAll($select);

		select *
		from archivos as a
		left join paginas_archivos as pa ON pa.id_archivo = a.id

		*/
	/*
		$archivos->joinInner(
			'paginas_archivos',
			'archivos.id = paginas_archivos.id_archivo');
			*/
		//$select = $this->select();
    	//$select->join('paginas_archivos', 'paginas_archivos.id_archivo = archivos.id');
		//return $archivos->fetchAll($select);
	public static function getAll($sitio = null, $limit = 0, $order ="id")
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}

		$archivos = new Archivos();
		return $archivos->fetchAll($where, $order, $limit);
	}
	public static function getArchivo($id)
	{
		$archivos = new Archivos();
		return $archivos->fetchRow('id = '.$id );
	}
}
?>
