<?php
  
  include_once('Zend/Gdata.php');
  
  class ZsurForce_ZGdata_Gmail extends Zend_Gdata{
      
      const CONTACTS_URI = 'http://www.google.com/m8/feeds/contacts';
      
      public function __construct($client = null, $applicationId = 'ZsurForce-ZGdata-1.0')
      {
        $this->registerPackage('Zsurforce_ZGdata_Gmail');
        //$this->registerPackage('Zsurforce_ZGdata_Gmail_Extension');
        parent::__construct($client, $applicationId);
      }
      
      public function getContactsEmail($user = null, $location = null)
    {
        if ($user !== null) {
            $uri = self::CONTACTS_URI . "/" . $user . "/base";
        } else if ($location instanceof Zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            include_once('Zsurforce/ZGdata/Gmail/EmptyArgumentException.php');
            throw new ZsurForce_ZGdata_Gmail_EmptyArgumentException('
                    Los argumenos no existen o no son v&aacute;lidos');
        }
        
        $feed = parent::getFeed($uri, 'Zend_Gdata_Feed');
        $emails = array();
        if($feed){
            foreach($feed as $entry) {
                $ExtensionElements = $entry->getExtensionElements();
                $ExtensionElements = $ExtensionElements[0];
                $ExtensionAttributes = $ExtensionElements->getExtensionAttributes();
                $emails[] .= $ExtensionAttributes['address']['value'];
            }
         } 
        return  $emails;
    }
  
  } 