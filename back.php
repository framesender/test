<?php
// new my coommit

	echo '
    <div id="content">';
    	$content->ShowContent($link,$sublink);
    	$news->ShowNews($link, $sublink, $news_id, $page);
    	$contacts->ShowData($link);
    	$galleria->ShowGalleryContent($link, $sublink, $page, $next);
		$hi=true;
    	$galleria->ShowMainGalleria($link, '8');
    	
    echo '    
    </div>';
    
    /*my comment*/

?>