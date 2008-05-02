<?php
class Helper_FormularioSubmit
{
	public function formularioSubmit( $params )
	{
		$xhtml  = '<div id="boton_formulario">';
		$xhtml .= ' <input type="hidden" name="id" value="'.$params['value'].'"/>'; 
		$xhtml .= ' <input type="submit" name="add" value="'.$params['submit'].'" />';
		$xhtml .= '</div>'; 

		return $xhtml;
	}
}
