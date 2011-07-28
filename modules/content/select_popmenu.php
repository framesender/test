<? header("Content-Type: text/html;charset=windows-1251"); ?>
	<script src="../../includes/scripts/jquery/jquery.js" type="text/javascript"></script>
<?
include("../../core/cl_db.php");

include("../menu/cl_popmenu.php");
	
$popmenu = new cl_popmenu();

//if (isset($_POST['content_mm_id']) && !empty($_POST['content_mm_id']))
if (isset($_POST['content_mm_id']))
{
	if (($_POST['content_mm_id'] == 'none'))
	{
					$option1 = '<select name="content_popmm_id">';
					$option1 .= '<option value="none">- выберите подменю -</option>';
					$option1 .= '</select>';
					echo $option1;
	}
	else
	{
					//выбор подменю
					$option1 = '<select name="content_popmm_id">';
					$option1 .= '<option value="none">- выберите подменю -</option>';
					$popmenu->SelectMenu('t_popmenu', 'popmenu_mm_id='.$_POST['content_mm_id'], '', '');
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
						$option1 = '<select name="content_popmm_id">';
						$option1 .= '<option value="none">- выберите подменю -</option>';
						$option1 .= '</select>';
						echo $option1;
					} 
	}
} 
?>