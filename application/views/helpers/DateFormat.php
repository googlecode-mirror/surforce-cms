<?php
class Helper_DateFormat 
{
	public function dateFormat( $date )
    {		    
        $fecha = explode(" ", $date);
        $hora = $fecha[1];
        $f = explode( "-", $fecha[0] );
           
        $xhtml = $f['2'] . "/" . $f['1'] ."/". $f['0'];

        return $xhtml;
    }
}
