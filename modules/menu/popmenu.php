<? header("Content-Type: text/html;charset=utf-8"); ?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../../includes/css/tablesorter.css" />
	<script src="../../includes/scripts/jquery/jquery.js" type="text/javascript"></script>
	<script src="../../includes/scripts/jquery/tablesorter.js" type="text/javascript"></script>
	<script type="text/javascript">
	    $(document).ready( function() {
	        // Select all
	        $("A[href='#select_all']").click( function() {
	            $("#" + $(this).attr('rel') + " INPUT[type='checkbox']").attr('checked', true);
	            return false;
	        });
	        
	        // Select none
	        $("A[href='#select_none']").click( function() {
	            $("#" + $(this).attr('rel') + " INPUT[type='checkbox']").attr('checked', false);
	            return false;
	        });
	    });
	</script>
	<script language="javascript">
			$(document).ready(function() 
			    {
			        $(".tablesorter").tablesorter({widgets: ['zebra']}); 
			    } 
			); 
	</script>
</head>
<body>
<?
include("../../core/cl_db.php");

include("cl_popmenu.php");
	
$popmenu = new cl_popmenu();

/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url2 = "main.php?namem=menu&&titlem=Меню сайта&&menu_pop=1"; // не изменять параметры
/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
if (isset($_POST['ajaxid']))
{
	$menu_id = $_POST['ajaxid'];
	//echo $menu_id;
	
		if ($menu_id != 'none')
		{
			// вставка для отображения списка меню
			$popmenu->SelectMenu('t_popmenu', 'popmenu_mm_id='.$menu_id, '', '');
			$count = $popmenu->getdriver()->Count();
			if ($count != 0)
				{	
					printf('<form id="group_1" name="formmenu" method="POST" action="%s">
									<table class="tablesorter">
										<thead>
										  <tr id="t_hed" align="center">
										  <td>#</td>
										  <th>#</th>
										  <th>Название подпункта меню</th>
										  <th>Очередность вывода</th>
										  <td>Управление</td>
										  </tr>
										</thead>
										<tbody>
										<input type="hidden" name="popmenu_mm_id" value="%s" size="50" />', $url2, $menu_id);
						while ($row = $popmenu->getdriver()->FetchResult())
						{
							$menu_id = 	$popmenu->getdriver()->Strip($row["popmenu_id"]);
							$menu_name = $popmenu->getdriver()->Strip($row["popmenu_name"]);
							$menu_sort = $popmenu->getdriver()->Strip($row["popmenu_sortid"]);
							echo ('<tr>
									  <td align="center"><input type="checkbox" name="popmenu_id[]" value="'.$row["popmenu_id"].'" /></td>
									  <td>'.$menu_id.'</td>
									  <td>'.$menu_name.'</td>			  
									  <td align="center">'.$menu_sort.'</td>			  
									  <td align="center"><a href="'.$url2.'&&popmenu_id='.$row["popmenu_id"].'&&update_popmenu=1">редактировать</a> | <a href="'.$url2.'&&popmenu_id[]='.$row["popmenu_id"].'&&del_popmenu=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
									</tr>');
						}
						printf('</tbody>	  
								<tr>
									<td colspan="4" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
									<td align="center"><button type="submit" name="delete_popmenu" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formmenu.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button> &nbsp;&nbsp;&nbsp;
										<button type="submit" name="add_popmenu"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
								</tr>
								<tr>
									<td colspan="5" align="right">Всего записей: %s </td>
								</tr>	 
							</table>
							</form>', $count);
				}
				else 
				{
					printf('<form method="POST" action="%s">
								<table class="tablesorter">
									<thead>
										 <tr id="t_hed" align="center">
										 <td>#</td>
										 <th>#</th>
										 <th>Название подпунктов меню</th>
										 <th>Очередность вывода</th>
										 <td>Управление</td>
										 </tr>
									</thead>
								<input type="hidden" name="popmenu_mm_id" value="%s" size="50" />
								<tr>
									<td colspan="4" align="center"><h3>Извините, нет подменю для отображения! Список пуст!</h3></td>
									<td colspan="1" align="center"><button type="submit" name="add_popmenu"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
								</tr>
								<tr>
									<td colspan="5" align="right">Всего записей: 0 </td>
								</tr>
							</table>
							</form>', $url2, $menu_id);
				}
		}
		else
		{
			printf('<table class="tablesorter">
									<thead>
										 <tr id="t_hed" align="center">
										 <td>#</td>
										 <th>#</th>
										 <th>Название подпунктов меню</th>
										 <th>Очередность вывода</th>
										 <td>Управление</td>
										 </tr>
									</thead>
								<tr>
									<td colspan="4" align="center"><h3>Выберите меню из списка!</h3></td>
									<td colspan="1" align="center">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="5" align="right">Всего записей: 0 </td>
								</tr>
							</table>');
		}
}
?>
</body>
</html>