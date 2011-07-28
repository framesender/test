<? header("Content-Type: text/html;charset=utf-8"); ?>
	<script src="../../includes/scripts/jquery/jquery.js" type="text/javascript"></script>
<?
include("../../core/cl_db.php");

include("../menu/cl_popmenu.php");
	
$popmenu = new cl_popmenu();

//if (isset($_POST['content_mm_id']) && !empty($_POST['content_mm_id']))
if (isset($_POST['gall_menu_id']))
{
	if (($_POST['gall_menu_id'] == 'none'))
	{
					$option1 = '<select name="gall_popmenu_id">';
					$option1 .= '<option value="0">- выберите подменю -</option>';
					$option1 .= '</select>';
					echo $option1;
	}
	else
	{
					//выбор подменю
					$option1 = '<select name="gall_popmenu_id">';
					$option1 .= '<option value="0">- выберите подменю -</option>';
					$popmenu->SelectMenu('t_popmenu', 'popmenu_mm_id='.$_POST['gall_menu_id'], '', '');
					if (($popmenu->getdriver()->Count()) > 0)
					{
						while($row = $popmenu->getdriver()->FetchResult())
						{
							$option1 .= '<option value="'.$row["popmenu_id"].'">'.$row["popmenu_name"].'</option>';
						}
						$option1 .= '</select>';
						echo $option1;
					}
					else
					{
						$option1 = '<select name="gall_popmenu_id">';
						$option1 .= '<option value="0">- выберите подменю -</option>';
						$option1 .= '</select>';
						echo $option1;
					} 
	}
} 
?>