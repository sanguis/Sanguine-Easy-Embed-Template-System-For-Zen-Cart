<?php
//+--------------------------------------------------------+
//| Sanguine Easy Embed Template: Zen Cart                           | 
//|Support Site:                                           |
//|http://code.google.com/p/sanguineasyembedtemplatesystem |
//|Released under the GPL v2                               |
//|(c)Sanguis Developmet 2008                              |
//|Please consider donating to:                            |
//|josh@sanguisdevelopment.com                             |
//|via Pay Pal                                             |
//+--------------------------------------------------------+
#$Id: magic.php 18 2009-05-11 15:03:59Z sanguisdex $

class sangEmbed {
	function __construct() {
		require_once (dirname(__FILE__) .'/config.php');
		//todo add and altennative if the template file is not found
		$file = fopen($this->templateFile, 'r');
		if ($file==false)
		{
			echo "Could not open the file. <br/>Please check that <br/>".$this->templateFile
			."<br/> defined as templateFile in ".dirname(__FILE__) ."/config.php  exists.";
			if (0 === strpos($this->templateFile,'http://') || 0===strpos($this->templateFile,'https://'))
			{
				echo "<br/>Please check the server has allow_url_fopen enabled in the php configuration";
			}
			die();
		}		
		if (0 === strpos($this->templateFile,'http://') || 0===strpos($this->templateFile,'https://'))
		{
			$this->template = stream_get_contents($file);
		}
		else
		{
			$this->template = fread($file, filesize($this->templateFile));
		}
		fclose($file);
		ob_start();
		eval ('?>' . $this->template);
		$this->template = ob_get_clean();
		// applying whole code modifications
		if ($this->options['stripDocType'] == true) $this->stripDocType();
		if ($this->options['stripMetaData'] == true) $this->stripMetaData();
		if ($this->options['stripHtmlTags'] == true) $this->stripHtmlTags();
		if ($this->options['stripTitleTag'] == true) $this->stripTitleTag();
		if (!empty($this->options['linkPathMod'])) $this->linkPathMod($path);
		if (!empty($this->options['imgPathMod'])) $this->imgPathMod($path);
	}  

	//striping tags
	function stripDocType() {
		$this->template=preg_replace('/<!DOCTYPE.*?>\n/si', '', $this->template);
	}
	function stripMetaData() {
		$this->template=preg_replace('/<meta.*?>\n/si', '', $this->template);
	}
	function stripHtmlTags(){
		$this->template=preg_replace('/<html.*?>\n/si', '', $this->template);
		$this->template=preg_replace('/<\/html>\n/si', '', $this->template);
	}
	function stripTitleTag(){
		$this->template=preg_replace('/<title.*?title>\n/si', '', $this->template);
	}

	//modifying link paths
	function linkPathMod($path) {
		$this->template=preg_replace('/href="\//si', 'href='.$path. '', $this->template);
		$this->template=preg_replace('/href=".*http/si', 'href="http', $this->template);
	}

	//modifying image paths
	function imgPathMod($path) {
		$this->template=preg_replace('/src="\//si', 'src="'. $path . '', $this->template);
		$this->template=preg_replace('/src=".*http/si', 'src="http', $this->template);
	}

	//grabs all code before </head>
	function insideHead() {
		preg_match('/<head>.*<\/head>/s', $this->template, $head);
    $strip = array('/<head>/', '/<\/head>/');
    $block = preg_replace($strip, '', $head[0]);
		return $block;
	}
	//Gets all code before the <!-- START EMBED -->
	function  top() {
		preg_match('/(.+)<!-- START EMBED -->/s', $this->template, $block);
		return $block[1];
	}
	
	//returns all markup bellow <body> and to the end of <!-- START EMBED -->
	function bodyTop() {
		preg_match('/<body?.*>(.+)<!-- START EMBED -->/si', $this->template , $pre);
    //print_r($pre);
		$block = preg_replace('/<body.*?>/si','', $pre[0]);
		return $block;
	}
	
	//returns all code from <!-- END EMBED --> and on
	function bottom() {
		preg_match('/<!-- END EMBED -->(.+)/s', $this->template, $block);
		return $block[1];
	}
	
	//replicats info for the body tag atributes
	function bodyAttrb(){
		preg_match('/<body([^>]+)>/', $this->template, $pre) ;
		$block =  $pre['1'];
		return $block;
	}
}
?>
