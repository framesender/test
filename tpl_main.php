<?php

	echo '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<BASE href="http://'.$_SERVER["HTTP_HOST"].'/" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	
		$seomenu = $menu->ShowSeo($link);
		$seocontent = $content->ShowSeo($link, $sublink);
		$seonews = $news->ShowSeo($news_id);
		
		if (!empty($seonews[0]))
		{
			echo '<title>'.$seonews[0].'</title>';
			echo '<meta name="description" content="'.$seonews[1].'" />';
			echo '<meta name="keywords" content="'.$seonews[2].'" />';
		}
		else if (!empty($seocontent[0]))
		{
			echo '<title>'.$seocontent[0].'</title>';
			echo '<meta name="description" content="'.$seocontent[1].'" />';
			echo '<meta name="keywords" content="'.$seocontent[2].'" />';
		}
		else if (!empty($seomenu[0])){
			echo '<title>'.$seomenu[0].'</title>';
			echo '<meta name="description" content="'.$seomenu[1].'" />';
			echo '<meta name="keywords" content="'.$seomenu[2].'" />';
		}
		else
		{
			include_once('seo_default.php');
		}
		
	echo '
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="includes/css/jquery.lightbox-0.5.css" media="screen" />
	
	<script type="text/javascript" src="includes/scripts/jquery/jquery.js"></script>
	<script type="text/javascript" src="includes/scripts/jquery/jquery.lightbox-0.5.js"></script>
	<script type="text/javascript">
		$(function() {
			$("#gallery a").lightBox();
		});
	</script>

	</head>
	
	<body>
	<table id="all_site" width="845" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td colspan="2" height="115">';
	    
	    include_once('header.php');
	    
	echo '</td>
	  </tr>
	  <tr>
	  <td width="320" valign="top">';
	  
	  	include_once('left.php');
	  
 	echo '</td>
	 <td width="525" valign="top">';
	 
	 	include_once('page.php');
	 
	echo '</td>
		</tr>
		  <tr>
		    <td colspan="2" height="74">';
		    
    	include_once('footer.php');
		    
    echo '</td>
	  </tr>
	</table>
	
	</body>
	</html>';

?>