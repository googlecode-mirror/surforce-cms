<?php
class Helper_HtmlLinkOrder
{
	public function htmlLinkOrder( $url, $orden, $asc, $text )
	{
		$xhtml = "<a href=".$url.'/orden/'.$orden.'/asc/'.!$asc.">".$text."</a>";
		return $xhtml;
	}
}
