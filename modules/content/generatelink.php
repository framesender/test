<? header("Content-Type: text/html;charset=windows-1251"); ?>
	<script src="../../includes/scripts/jquery/jquery.js" type="text/javascript"></script>
<?
include("../../core/cl_db.php");

include("../menu/cl_popmenu.php");
	
$popmenu = new cl_popmenu();

//if (isset($_POST['content_mm_id']) && !empty($_POST['content_mm_id']))
if (isset($_GET['generatelink']))
{
	if (($_GET['generatelink'] != 'none'))
	{
		//генераци€ подменю
		$popmenu->SelectMenu('t_popmenu', 'popmenu_id='.$popmenu->getdriver()->Putcontent($_GET['generatelink']), '', '');
		if (($popmenu->getdriver()->Count()) > 0)
		{
			$row = $popmenu->getdriver()->FetchResult();
			$code = '<a id="'.$popmenu->getdriver()->Strip($row['popmenu_id']).'" class="submenu" href="#">'.$popmenu->getdriver()->Strip($row['popmenu_name']).'</a>';
			echo '<input type="button" onclick="InsertCode(\''.htmlspecialchars($code).'\');" value="вставить ссылку" />';
			//echo htmlspecialchars($code);
			//echo "<div>код ссылки:</div><input name='code' value='".htmlspecialchars($code)."' readonly style='width:50%;' />";
		} 
	}
}
?>