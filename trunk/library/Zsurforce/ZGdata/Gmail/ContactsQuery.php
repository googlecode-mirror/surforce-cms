<?php


require_once('Zsurforce/ZGdata/Gmail.php');

require_once('Zend/Gdata/Query.php');


class ZsurForce_ZGdata_Gmail_ContactsQuery extends Zend_Gdata_Query
{

    
    public function __construct($url = null)
    {   
        parent::__construct($url);
    }

    public function setOrderBy($value)
    {
        if ($value != null) {
            $this->_params['orderby'] = $value;
        } else {
            unset($this->_params['orderby']);
        }
        return $this;
    }

    

}