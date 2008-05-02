<?php

class Estadisticas_View_Helper_GoogleChart
{
    public function googleChart( $chx, $chtt, $chd, $chm = null, $chg = null )
    {
    	$chm = "D,C6D9FD,1,0,8|D,4D89F9,0,0,4";
		$chg = "20,50,1,0";

		$pars = array(
			"http://chart.apis.google.com/chart?chs=1000x300",
			"cht=ls",
			"chxt=x,y",
			"chds=1,100",
			"chxl=0:|" . $chx ,
			"chtt=" . $chtt,
			"chd=t:" . $chd,
			"chm=" . $chm,
			"chg=" . $chg
		);

		$url = implode( "&", $pars );

		$xhtml = "<table border='0' align='center'> \n";
		$xhtml .= " <tr>";
		$xhtml .= "  <td>";
		$xhtml .= "   <img src='" . $url . "' alt=''/>";
		$xhtml .= "  </td>";
		$xhtml .= " </tr>";
		$xhtml .= "</table>";

		return $xhtml;
    }
}
?>
