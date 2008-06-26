<?php
//+-------------------------------------+
//| Sanguine Embed Template             |
//|for zen cart v2.3.x                  |
//|(c)Sanguis Developmet 2008           |
//|josh@sanguisdevelopment.com          |
//|                                     |
//+-------------------------------------|
#$Id: config.php 24 2008-06-26 18:08:47Z sanguisdex $

//theis is the place where you tell the template where your mark up  that will have 
//the zen cart embeded in to it is located.

//examples or if you would like to use them  just remove the # at the begining of the line. AND
//BE SURE TO CHANGE "FILENAME" to the name of your file.
//and make sure that all the other lines in this section have "#" marks or "//" beofre them.

//if your mark up file is located in the same folder as this file.
#$zc_temp = DIR_FS_CATALOG . DIR_WS_TEMPLATES. 'sang_embed/common/' . 'FILENAME'; 
//if your mark up file is located in the zen cart root.
#$zc_temp = DIR_FS_CATALOG . 'FILENAME'; 
//other wise fill this in
$zc_temp = 'YOUR_MARK_UPFILE_WITH_THE_FULL_PATH';

?>