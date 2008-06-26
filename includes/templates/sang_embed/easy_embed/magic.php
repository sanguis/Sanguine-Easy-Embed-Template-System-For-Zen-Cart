<?php
//+-------------------------------------+
//| Sanguine Embed Template             |
//|for zen cart v2.3.x                    |
//|(c)Sanguis Developmet 2008           |
//|josh@sanguisdevelopment.com              |
//||
//+-------------------------------------|
#$Id: magic.php 24 2008-06-26 18:08:47Z sanguisdex $

//geting configureation data
require_once($template->get_template_dir('embed_config.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/embed_config.php');

//todo add and altennative if the template file is not found
$file = fopen($zc_temp, 'r');
$sitetemplate = fread($file, filesize($zc_temp));

fclose($file);

ob_start();
eval ('?>' . $sitetemplate);
  $sitetemplate = ob_get_clean();


//strip some duplicate tags that zencart manages itself 
$sitetemplate=preg_replace('/<!DOCTYPE.*?>/si', '', $sitetemplate);
$sitetemplate=preg_replace('/<meta.*?>/si', '', $sitetemplate);
$sitetemplate=preg_replace('/<html.*?>/si', '', $sitetemplate);
$sitetemplate=preg_replace('/<title.*?title>/si', '', $sitetemplate);


//JTS replace hrefs to point above catalog, but not the href for the style sheet! or http links!
$sitetemplate=preg_replace('/href="/si', 'href="../', $sitetemplate);
$sitetemplate=preg_replace('/href="..\/..\//si', 'href="../', $sitetemplate);
$sitetemplate=preg_replace('/href="..\/http/si', 'href="http', $sitetemplate);

//replace last bits: img src
$sitetemplate=preg_replace('/src="images/si', 'src="../images', $sitetemplate);
$sitetemplate=preg_replace('/<!-- START EMBED -->/si', '<!-- START EMBED -->', $sitetemplate);
$sitetemplate=preg_replace('/<!-- END EMBED -->/si', '<!-- END EMBED -->', $sitetemplate);

//creates bits for the had and the body
$sitetemplate_head = preg_replace('/<\/head>.*$/s', '', $sitetemplate);
$sitetemplate_top=preg_replace('/<!-- START EMBED -->.*$/s', '', $sitetemplate);

//replicats info fot the body tag atributes
preg_match('/<body([^>]+)>/', $sitetemplate, $sitetemplate_body_pre) ;
$sitetemplate_body =  $sitetemplate_body_pre['1'];
$sitetemplate_body = preg_replace('/images/s', '../iimages', $sitetemplate_body);

//strips the head info from the body
$sitetemplate_top=preg_replace('@<head[^>]*?>.*?<body.*?>@si', '', $sitetemplate_top);
$sitetemplate_top=preg_replace("@,'images/@si", ",'/images/",  $sitetemplate_top);

//strips the head info from the body
$sitetemplate_head=preg_replace('@</head>@si', '', $sitetemplate_head);
$sitetemplate_head=preg_replace('@<head>@si', '', $sitetemplate_head);

//makes the bottom on the page
$sitetemplate_bottom = preg_replace('/^.*<!-- END EMBED -->/s', '', $sitetemplate);

?>