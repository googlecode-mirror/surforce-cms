<?php
class Galerias extends Zend_Db_Table {

	protected $_name = 'galerias';
	protected $_dependentTables = array('paginas_archivos');
}
?>
