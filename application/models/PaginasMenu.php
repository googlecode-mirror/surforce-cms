<?php
class PaginasMenu extends Zend_Db_Table
{
	protected $_name = 'paginas_menu';
	
	public static function getMenuPagina($id_pagina, $limit = 0, $order = "id_pagina")
	{	
		$PA = new PaginasMenu();
		return $PA->fetchAll('id_pagina = '.$id_pagina, $order, $limit);		
	}

}
?>