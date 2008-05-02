<?php
class Zsurforce_View_Helper_HtmlMenuHorizontal
{
    public function htmlMenuHorizontal(array $opciones, $menu = "menu", $base = null)
    {
    	$link = new Zsurforce_View_Helper_HtmlLinkArray();
    	
    	$xhtml = '<strong>'.$menu.':&nbsp;</strong>';    	
        foreach( $opciones as $opcion){
        	$xhtml .= $link->htmlLinkArray($opcion,$base).'/&nbsp;';
        }
        return $xhtml;
    }
}
