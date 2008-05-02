<?php

class Zsurforce_View_Helper_FormNumeracion
{
    /**
    * cantTotal	 = cantidad de registros que devuelve la consulta
    * cantMaxima = la cantidad maxima de registros a mostrar por pagina
    * pagActual = pagina actual dentro del listado
     */
    function formNumeracion( $cantTotal=0, $cantMaxima=10, $pagActual=0 ){
        $cantInicio = ( $pagActual * $cantMaxima ) + 1;
        $cantAux = ( $pagActual + 1 ) * $cantMaxima;
        if ( $cantAux > $cantTotal){
            $cantFinal = $cantTotal;
        }else{
            $cantFinal = $cantAux;
        }
        $xhtml = "|$cantInicio al $cantFinal de $cantTotal encontradas|";

        return $xhtml;
    }
}
?>