<?php

class Zsurforce_View_Helper_HtmlTable
{
    public function htmlTable(Array $param, $htmlentities = true )
    {
    	$xhtml = '<table border="1">';
        foreach( $param as $fila){
        	$xhtml .= '<tr>';
        	foreach( $fila as $celda){
        		if($htmlentities){
        			$xhtml .= '<td>'.htmlentities($celda).'</td>';
        		}else{
        			$xhtml .= '<td>'.$celda.'</td>';
        		}        		
        	}
        	$xhtml .= '</tr>';
        }
        $xhtml .= '</table>';
        return $xhtml;
    }
}
