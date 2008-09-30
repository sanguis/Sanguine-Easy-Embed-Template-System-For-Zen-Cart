<?php
//+--------------------------------------------------------+
//| Sanguine Easy Embed Template - Zen Cart                | 
//|Support Site:                                           |
//|http://code.google.com/p/sanguineasyembedtemplatesystem |
//|Released under the GPL v2                               |
//|(c)Sanguis Developmet 2008                              |
//|PLease consider donating to:                            |
//|josh@sanguisdevelopment.com                             |
//|via paypal                                              |
//+--------------------------------------------------------+
#$Id: config.php 24 2008-06-26 18:08:47Z sanguisdex $

//For examples of how to set this see readme.txt; chaper II, step 1
$this->templateFile = '';

//content modifcatactions:
#set values to true/false to modify unless other wise 
#	noted  in for the value.
$this->options = array(
	"stripMetaData" => true,
	"stripDocType" => true,
	"stripHtmlTags" => true,
	"stripTitleTag" => true,
	//path modifiers for links and images.
	//by defualt the it is assume that the application running the easy embed templating system is in a sub diretory of a site
	"linkPath" => "",
	"imgPath" => ""
)

?>