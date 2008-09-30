<?php
//+--------------------------------------------------------+
//| Sanguine Easy Embed Template: Zen Cart                           | 
//|Support Site:                                           |
//|http://code.google.com/p/sanguineasyembedtemplatesystem |
//|Released under the GPL v2                               |
//|(c)Sanguis Developmet 2008                              |
//|PLease consider donating to:                            |
//|josh@sanguisdevelopment.com                             |
//|via Pay Pal                                       |
//+--------------------------------------------------------+
#$Id: magic.php 8 2008-09-11 00:16:37Z sanguisdex $

class sangEmbed {
	function __construct() {
		require_once (dirname(__FILE__) .'/config.php');
		//todo add and altennative if the template file is not found
		$file = fopen($this->templateFile, 'r');
		$this->template = fread($file, filesize($this->templateFile));
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
 /* not sure this is required any more *?
	$this->template=preg_replace('/<!-- START EMBED -->/si', '<!-- START EMBED -->', $this->template);
	$this->template=preg_replace('/<!-- END EMBED -->/si', '<!-- END EMBED -->', $this->template);
*/
	//grabs all code before </head>
	function insideHead() {
		$block = preg_replace('/.*<\/head>/s', '', $this->template);
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
		$block = preg_replace('/<body?.*>/si','', $pre[1]);
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