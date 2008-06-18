<?php
require_once "html/scripts/fckeditor/fckeditor.php";

class Zend_View_Helper_FormFCKeditor
{
   private $_instanceName;
   private $_sBasePath;
   private $_oFCKeditor;

	public function formFCKeditor($instanceName = null, $contentValue = null, $width = '100%', $height = '300' )
	{
   		$this->_instanceName = $instanceName ;
      	$this->_contentValue = $contentValue;
      	$sBasePath = $_SERVER['PHP_SELF'];
      	$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "index.php" ) );

      	$this->_sBasePath = $sBasePath . "public/scripts/fckeditor/";
      	$this->_oFCKeditor = new FCKeditor($this->_instanceName) ;
      	$this->_oFCKeditor->BasePath    = $this->_sBasePath ;
      	$this->_oFCKeditor->Value        =  $this->_contentValue;
      	$this->_oFCKeditor->Config['CustomConfigurationsPath'] = '../myconfig.js' ;
		$this->_oFCKeditor->Width  = $width;
		$this->_oFCKeditor->Height = $height;
		return $this->_oFCKeditor->Create();
     }
 }
?>
