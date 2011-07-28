<?php

	echo '
	<div id="leftnavigation">';
		$popmenu->ShowPopMenu($link, $sublink);
		$news->ShowPanelNews($link);
	echo '
	</div>';

?>