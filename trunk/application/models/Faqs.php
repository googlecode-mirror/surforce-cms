<?php
class Faqs extends Zend_Db_Table_Abstract
{
	protected $_name = 'faqs';

	public static function getAll( $sitio = null, $limit = 0 )
	{
		if($sitio){
			$where = "id_sitio = $sitio";
		}else{
			$where ="1=1";
		}
		$order = "fecha DESC";
		$faqs = new Faqs();
		return $faqs->fetchAll($where, $order, $limit);
	}
	public static function getFaq( $id )
	{
		$faq = new Faqs();		
		return $faq->fetchRow("id = '$id'");
	}
}
?>