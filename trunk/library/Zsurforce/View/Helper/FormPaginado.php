<?php

class Zsurforce_View_Helper_FormPaginado
{
    /**
     * form  		= nombre del formulario actual
     * cantTotal 	= cantidad de registros que devuelve la consulta
     * cantMaxima 	= la cantidad maxima de registros a mostrar por pagina
     * pagActual 	= pagina actual dentro del listado
     * estiloNro 	= estilo con el que se mostraran los numeros
     * estiloActual	= estilo con el que se mostraran el numero de la pagina
     * actual
     * estiloOtros 	= estilo de los separadores
     * separador 	= separador a mostrar entre los numeros de la paginacion
     *
     */
    function formPaginado( $form="", $cantTotal=0, $cantMaxima=10, $pagActual=0,
        $estiloNro="enlacemenu", $estiloActual="enlacemenu", $estiloOtro="", $separador="|")
    {

        $xhtml = "";

        //chequeo valores recibidos
        if($form==""){
            return "";
        }

        if($cantMaxima<=0){
            return "";
        }

        // preparación de estilos
        if ( $estiloNro=="" ){
            $estiloNroStr ="";
        }else{
            $estiloNroStr = "class='" . $estiloNro . "'";
        }

        if ($estiloOtro==""){
            $estiloOtroStr = "";
        }else{
            $estiloOtroStr="class='".$estiloOtro."'";
        }

        if ($estiloActual==""){
            $estiloActualStr="";
        }else{
            $estiloActualStr="class='".$estiloActual."'";
        }

        $pagsTotal = ceil( $cantTotal / $cantMaxima );

        if ($pagsTotal <= 1) return "";

        $separador=" <span $estiloOtroStr>$separador</span> ";

        if ($pagActual-10 <= 0){
            $limiteInferior = 0;
        }else{
            $limiteInferior = $pagActual-10;
        }

        if ($pagActual+10 >= $pagsTotal){
            $limiteSuperior = $pagsTotal;
        }else{
            $limiteSuperior = $pagActual+10;
        }

        if ($pagActual > 0){
            $pagAnterior = $pagActual-1;
        }else{
            $pagAnterior=0;
        }

        // Codigo necesario para ir a la primera pagina
        $xhtml .= "<a " . $estiloActualStr . " href='javascript:document.$form.pagActual.value=0; document.$form.submit()' >|<</a>&nbsp;\n";

        // Codigo necesario para ir a la pagina anterior
        $xhtml .= "<a " . $estiloActualStr . " href='javascript:document.$form.pagActual.value=$pagAnterior;document.$form.submit()' ><<</a>&nbsp;\n";

        for ($i=$limiteInferior;$i<$limiteSuperior;$i++){
            $pag = $i+1;
            if ($pagActual == $i){
                $xhtml .= "<span $estiloActualStr>$pag\n";
            }else{
                $xhtml .= "<a ".$estiloActualStr." href='javascript:document.$form.pagActual.value=$i;document.$form.submit()' >$pag</a>\n";
            }
            if ($i < $limiteSuperior -1){
                $xhtml .= $separador;
            }
        }

        if ($pagActual < $pagsTotal-1){
               $pagSiguiente = $pagActual+1;
        }else{
            $pagSiguiente = $pagsTotal-1;
        }

        // Agrego el codigo necesario para ir a la siguiente pagina
        $xhtml .= "&nbsp;<a ".$estiloActualStr." href='javascript:document.$form.pagActual.value=$pagSiguiente;document.$form.submit()' >>></a>\n";


        // Agrego el codigo necesario para ir a la ultima pagina
        $pagSiguiente=$pagsTotal-1;

        $pagActual++;

        $xhtml .= "&nbsp;<a ".$estiloActualStr." href='javascript:document.$form.pagActual.value=". ($pagsTotal - 1) .";document.$form.submit()'>>|</a>\n";
        $xhtml .= " <input type='hidden' name='cantTotal' id='cantTotal' value='$cantTotal'/>\n";
        $xhtml .= " <input type='hidden' name='cantMaxima' id='cantMaxima' value='$cantMaxima'/>\n";
        $xhtml .= " <input type='hidden' name='pagActual' id='pagActual' value='$pagActual'/>\n";
        $xhtml .= " <input type='hidden' name='estiloNro' id='estiloNro' value='$estiloNro'/> \n";

        if( !isset($estiloActual) ){
            $estiloActual=" ";
        }
        $xhtml .= " <input type='hidden' name='estiloAcutal' id='estiloAcutal' value='$estiloActual'/>\n";
        if( !isset($estiloOtros) ){
            $estiloOtros=" ";
        }

        $xhtml .= " <input type='hidden' name='estiloOtros' id='estiloOtros' value='$estiloOtros'/>\n";
        $xhtml .= " <input type='hidden' name='separador' id='separador' value='$separador'/>\n";

        return $xhtml;

    }
}
?>