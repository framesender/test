<? header("Content-Type: text/html;charset=windows-1251"); ?>
	<script src="../../includes/scripts/jquery/jquery.js" type="text/javascript"></script>
<?
include("../../core/cl_db.php");

include("../menu/cl_popmenu.php");
	
$popmenu = new cl_popmenu();

//if (isset($_POST['content_mm_id']) && !empty($_POST['content_mm_id']))
if (isset($_POST['content_mm_id']))
{
	$mess = '<div style="color: green;">дл€ генерации ссылки выберите подпункт меню в списке ниже*</div>';
	$error_mess = '<div style="color: red;">дл€ генерации ссылки выберите пункт меню в списке выше*</div>';
	$error_mess2 = '<div style="color: red;">к этому пункту меню нет подв€заных подпунктов*</div>';
	
	if (($_POST['content_mm_id'] == 'none'))
	{
					echo $error_mess;
	}
	else
	{
					//выбор подменю
					$option1 = '<div style="float: left;">';
					$option1 .= '<select id="generatelink" name="generatelink" onChange="GenerateLink(); return false">';
					$option1 .= '<option value="none">- выберите подменю -</option>';
					$popmenu->SelectMenu('t_popmenu', 'popmenu_mm_id='.$_POST['content_mm_id'], '', '');
					if (($popmenu->getdriver()->Count()) > 0)
					{
						while($row = $popmenu->getdriver()->FetchResult())
						{
							$option1 .= '<option value="'.$row["popmenu_id"].'">'.$row["popmenu_name"].'</option>';
						}
						$option1 .= '</select>';
						$option1 .= '</div>';
						echo $mess.$option1.' <div id="generatelinkresult"></div>';
					}
					else
					{
						echo $error_mess2;
					} 
	}
} 
?>