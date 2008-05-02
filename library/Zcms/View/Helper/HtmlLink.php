<?php

class Zcms_View_Helper_HtmlLink
{
    /**
     * Generates a 'link' html.
     *
     * @param  string $name The form element name for which the label is being generated
     * @param  string $value The label text
     * @param  array $attribs Form element attributes (used to determine if disabled)
     * @return string The element XHTML.
     */
    public function htmlLink( $url, $text, $alt = '')
    {
        return '<A href="'.$url.'" ALT = "'.$alt.'">'.$text.'</A>';         
    }
}
