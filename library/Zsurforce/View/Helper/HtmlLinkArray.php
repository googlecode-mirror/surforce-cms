<?php

class Zsurforce_View_Helper_HtmlLinkArray
{
    /**
     * Generates a 'link' html.
     *
     * @param  string $url
     * @param  string $text
     * @param  string $alt
     * @return string The element XHTML.
     */
    public function htmlLinkArray(array $param, $base = null )
    {    	   	
    	if( count($param) > 0){
    		$ret = '<A href="' . $base . $param['url'].
        		'" title ="' . $param['alt'] .
        		'">' . $param['text'] . '</A>'; 	
    	}else{
    		$ret = NULL;
    	}
        return $ret;
        	
    }
}
?>