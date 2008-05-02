<?php
class Zsurforce_Utils_Logger {

    static function log( $mensaje )
    {
        $config = Zend_Registry::get('config');
        $writer = new Zend_Log_Writer_Stream('./log/log');
        $logger = new Zend_Log($writer);
        
        if ($config->constantes->debug){
            $logger->log($mensaje, Zend_Log::INFO);
        }
        //$logger->log("constante ".$config->constantes->debug, Zend_Log::INFO);
    }
}
?>