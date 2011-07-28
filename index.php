<?php
	session_start();
 	include_once('core/core_main.php');
	
	$url = 'http://'.$_SERVER["HTTP_HOST"].'/';
	
	//include tpl mainpage or normalpage
	//if ($link == '') include_once('tpl_main.php');
	//else if ($link != '') include_once('tpl_normal.php');
	include_once('tpl_main.php');

?>