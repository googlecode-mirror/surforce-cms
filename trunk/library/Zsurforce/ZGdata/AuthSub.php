<?php
  
  require_once('Zend/Gdata/AuthSub.php');
  
  class Zsurforce_ZGdata_AuthSub extends Zend_Gdata_AuthSub{
      
      const AUTHSUB_SCOPE = 'http://www.google.com/m8/feeds/';
  
      public static function getZGdataAuthSubTokenUri($next, $scope = self::AUTHSUB_SCOPE, $secure=0, $session=1, 
                                               $request_uri = self::AUTHSUB_REQUEST_URI){
          
          
          return parent::getAuthSubTokenUri($next,$scope,$secure,$session);
      }
      
  }
?>
