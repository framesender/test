<?
	include_once("../core/cl_seo.php");	// для сео
	$seo = new cl_seo();
	
	include_once("../modules/menu/cl_menu.php"); // класс для работи с меню сайта
	include_once("../modules/responce/cl_responce.php"); //класс для работи с отзывами
	include_once("../core/cl_navigation.php");	
	
	$r1 = new cl_responce();//$responce = new cl_responce();
	$menu = new cl_menu();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=responce&&titlem=Отзывы"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения отзывов, передаем параметр - обьект отзывов
	function showResps($r1, $url)
	{
		$navigator = new cl_navigation();
						
		if (!isset($_GET['page'])) $p = 0;
        else if ($_GET['page']!='') 
        {
            try
            {
                $p = (int)$navigator->getdriver()->PutContent($_GET['page']);
            }
            catch (Exception $e)
            {
                $p = 0;
            }
        } 
        else $p=0;
    
		if (!isset($_GET['next'])) $n = 0;
        else if ($_GET['next']!='') 
        {
            try
            {
                $n = (int)$navigator->getdriver()->PutContent($_GET['next']);
            }
            catch (Exception $e)
            {
               $n=0; 
            }
        }
     	else $n=0;
	
		// вставка для отображения списка отзывов
		$r1->SelectResponce('t_responce', '', '', '');
		$count = $r1->getdriver()->Count();
		
		$r1->getdriver()->Select('t_responce', '', '', '', 'responce_id', 'DESC', $p, '20');
		if ($count != 0)
		{	
			printf('<form id="group_1" method="POST" name="formnews" action="%s">
					<table class="tablesorter">
						<thead>
						  <tr id="t_hed" align="center">
						  <td>#</td>
						  <th>Гость</th>
						  <th>Отзыв</th>
						  <th>Дата добавления</th>
						  <th width="120">Модерация</th>
						  <td>Управление</td>
						  </tr>
						</thead>
						<tbody>', $url);
						
			while ($row = $r1->getdriver()->FetchResult())
			{
				$user = $r1->getdriver()->Strip($row["responce_user"]);
				$text = $r1->getdriver()->Strip($row["responce_text"]);
				$responce_status = $r1->getdriver()->Strip($row["responce_status"]);
				$date = $r1->getdriver()->Strip(date("d-m-Y", $row["responce_date"]));
									
			echo ('<tr>
				  <td align="center"><input type="checkbox" name="responce_id[]" value="'.$row["responce_id"].'" /></td>
				  <td>'.$user.'</td>
				  <td>'.$text.'</td>
				  <td align="center">'.$date.'</td>
				  <td align="center">'.ActiveIco($responce_status).'</td>
				  <td align="center">
				  <a href="'.$url.'&&responce_id='.$row["responce_id"].'&&update_resp=1">редактировать</a> 
				  | <a href="'.$url.'&&responce_id[]='.$row["responce_id"].'&&del_resp=1" 
				  onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} 
				  else return false;">удалить</a></td>
				</tr>');
			}
			printf('</tbody>	  
					<tr>
						<td colspan="5" align="left"><img src="../includes/img/icons/arrow.png" alt="" />
						<a rel="group_1" href="#select_all">отметить все</a>
						/ <a rel="group_1" href="#select_none">снять выделение</a></td>
						
						<td colspan="1" align="center">
						<button type="submit" name="delete_resp" 
						onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formnews.submit(); } 
						else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
						<button type="submit" name="add_resp"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
					</tr>
					<tr>
						<td colspan="6" align="right">
						Всего записей: %s &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</tr>
					<tr>
					<td colspan="9">'.$navigator->links($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,$count).'</td>
					</tr>
				</table>
				</form>', $count);
		}
		else
		{
			printf('<form method="POST" name="formnews" action="%s">
				<table class="tablesorter">
					<thead>
						<tr id="t_hed" align="center">
						<td>#</td>
						<th>Гость</th>
						<th>Отзыв</th>
						<th>Дата добавления</th>
						<th width="120">Модерация</th>
						<td>Управление</td>
						</tr>
					</thead>
				<tr>
					<td colspan="5" align="center"><h3>Извините, нет записей для отображения!</h3></td>
					<td colspan="1" align="center">
					<button type="submit" name="add_resp"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
				</tr>
				<tr>
					<td colspan="6" align="right">Всего записей: 0 &nbsp;</td>
				</tr>
			</table>
			</form>', $url);
		}
			
	}	// --------------end showResps--------------------------
	
	// функция для настройки, записываем в лист_мод айдишки выбранных отзывов, передаем параметры - обьект, обьект списка модулей, и ссылку
	function showBuildResp($r1, $url)
	{
		// вставка для отображения списка отзывов
		$r1->SelectResponce('t_responce', '', '', '');
		$count = $r1->getdriver()->Count();
		if ($count != 0)
		{	
			echo "<h3>Управление статусом отзывов</h3>";
			printf('<form id="group_1" method="POST" name="formmenu" action="%s&&menu_pop=1">
			<table class="tablesorter">
				<thead>
				<tr id="t_hed" align="center"><td>#</td><th>Имя</th><td>Статус</td><th>Очередность вывода</th></tr>
				</thead>
				<tbody>', $url);
			//главная страница			
			while ($row = $r1->getdriver()->FetchResult())
			{
				$responce_user = $r1->getdriver()->Strip($row["responce_user"]);
				$responce_status = $r1->getdriver()->Strip($row["responce_status"]);
				$responce_id = $row["responce_id"];
				echo ('<tr>
						  <td align="center"><input type="checkbox" name="responce_id[]" value="'.$responce_status.'" /></td>
						  <td>'.$responce_user.'</td>
						  <td align="center">'.ActiveIco($responce_status).'</td>
						  <td align="center">'.$responce_id.'</td>
						</tr>');
			}
			printf('</tbody>	  
					<tr>
						<td colspan="3" align="left">
						<img src="../includes/img/icons/arrow.png" alt="" />
						<a rel="group_1" href="#select_all">отметить все</a>
						/ <a rel="group_1" href="#select_none">снять выделение</a></td>
						
						<td align="center"><button type="submit" name="build_resp_form">
						<img src="../includes/img/it/apply.gif" alt="" /></button> &nbsp;&nbsp;&nbsp;
						<button type="submit" name="debuild_resp_form">
						<img src="../includes/img/it/cancel.gif" alt="" /></button></td>
					</tr>
					<tr>
						<td colspan="4" align="right">Всего записей: %s &nbsp;&nbsp;&nbsp;</td>
					</tr>	 
				</table>
				</form>', $count );
		}
		else echo "<h3>Управление статусом отзывов</h3><h4>Извините, нет записей для отображения!</h4>";
	}	// -------------- end showBuildResp --------------------------
	
	// рисование значков
	function ActiveIco ( $val )
	{
		if ($val != 0)	{return "<img src='../includes/img/icons_table/active.png' alt=''>";}
		else {return "<img src='../includes/img/icons_table/deactive.png' alt=''>";}
	}
	// вывод календаря
	function calendarEcho()
	{
		echo '<script type="text/javascript" src="../includes/scripts/js/calendar_stripped.js"></script>
		<script type="text/javascript" src="../includes/scripts/js/calendar-ru_win.js"></script>
		<script type="text/javascript" src="../includes/scripts/js/calendar-setup_stripped.js"></script>
		<script type="text/javascript">
				Calendar.setup(
				{
				inputField : "responce_date", // ID of the input field
				ifFormat : "%d-%m-%Y", // the date format
				daFormat : "%d-%m-%Y", // the date format
				firstDay : 1, // the date format
				button : "otbtn" // ID of the button
				}
				);
		</script>';
	}
	
	function noTab()
	{
		printf('<div id="menu">
					<ul>
						<li><a href="%s&&menu_pop=0">список отзывов</a></li>
						<li><a href="%s&&menu_pop=1">настройки</a></li>
					</ul>
				</div>
				<div id="under_blue_menu">&nbsp;</div>', $url, $url);
		echo "Воспользуйтесь пунктом меню!";
	}
	
	// --------- /проверка к каким пунктам главного меню привязан модуль для показа необходимого контента ------------------------------
	switch ($_GET["menu_pop"])
	{
	case 0: 
	{
		printf('<div id="menu">
				<ul>
					<li id="active"><a href="%s">список отзывов</a></li>
					<!-- <li><a href="%s&&menu_pop=1">настройки</a></li> -->
				</ul>
				</div>
				<div id="under_blue_menu">&nbsp;</div>', $url, $url);
		// форма для добавления отзывов
		if (isset($_POST["add_resp"]))
		{
			echo "<h3>Новый отзыв</h3>";		
			echo ('<form enctype="multipart/form-data" method="POST" action="'.$url.'">
				<table border="0">
					<tr><td align="left">Имя:</td><td>дата:*</td></tr>
					<tr><td><input type="text" name="responce_user" value="" size="50" /></td>
						<td><input type="text" id="responce_date" name="responce_date" value="'.date("d-m-Y").'"style="width:250px" readonly="readonly" />
						<img src="../includes/img/calendar.gif" name="otbtn" width="20" height="20" align="absmiddle" id="otbtn" />
					</td></tr>
					
					<tr><td align="left" colspan="2">модерация:*</td></tr>
					<tr><td align="left" colspan="2">
					<select name="responce_status">
						<option value="0">скрыть</option>
						<option value="1">отображать</option>
					</select></td></tr>
					
					<tr><td align="left" colspan="2">текст отзыва:*</td></tr>
					<tr><td colspan="2"><textarea name="responce_text" cols="70" rows="7"></textarea></td></tr>
					<tr><td align="center" colspan="2"><br />
					<button type="submit" name="add_resp_form"><img src="../includes/img/it/save.gif"  /></button>
					&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel">
					<img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
				</table>
			</form>');
			calendarEcho();
		}					
		// обработка добавления отзыва
		else if (isset($_POST["add_resp_form"]))
		{			
			if (($_POST["responce_user"] != '') && ($_POST['responce_text'] != '') 
			&& ($_POST['responce_date'] != '') && ($_POST['responce_date'] != 'dd-mm-yyyy'))
			{
				$user = $r1->getdriver()->PutContent($_POST['responce_user']);
				$status = $_POST['responce_status'];
				$text = $_POST['responce_text'];
				$date = $r1->getdriver()->PutContent($_POST['responce_date']);
				$user = "'".$user."'";	$text = "'".$text."'";
				$insert = array( $user, $text, $date, $status );
				$r1->InsertResponce('t_responce', $insert);
				showResps($r1, $url);
			} else {
				echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
				showResps($r1, $url);
			}
		}	
		// обработка удаления выбраных записей
		else if (isset($_POST["delete_resp"]))
		{
			if ($_POST["responce_id"] != null)
			{
				$delete = $_POST["responce_id"];
				for($i=0; $i<count($delete); $i++)
				{
					$r1->SelectResponce('t_responce', 'responce_id='.$delete[$i], '', '');
					$row = $r1->getdriver()->FetchResult();
				}				
				$r1->DeleteResponce('t_responce', $delete);
				showResps($r1, $url);
			}
			else
			{
				echo "<br /><div class='sms_error'>Вы не выбрали новости для удаления!</div>";
				//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
				showResps($r1, $url);
			}
		}			
		// форма для удаления одной новости
		else if (isset($_GET["del_resp"]))
		{
			if (($_GET["responce_id"] != null) && ($_GET["del_resp"]==1))
			{
				$delete = $_GET["responce_id"];
				$r1->SelectResponce('t_responce', 'responce_id='.$delete[0], '', '');
				$row = $r1->getdriver()->FetchResult();				
				$r1->DeleteResponce('t_responce', $delete);
				$k = $r1->getdriver()->Result();
				showResps($r1, $url);
			}
			else
			{
				echo "<br /><div class='sms_error'>Вы не выбрали отзыв для удаления!</div>";
				showResps($r1, $url);
			}
		}
		//-----------------------------------------------------------------------------------------------------------			
		// форма для редактирования новостей
		else if (isset($_GET["update_resp"]))
		{
			if (($_GET["responce_id"] != null) && ($_GET["update_resp"]==1))
			{
				$id_edit = $_GET["responce_id"];
				$r1->SelectResponce('t_responce', 'responce_id='.$id_edit.'', '', '');
				
				$row = $r1->getdriver()->FetchResult();
					$responce_id = $row["responce_id"];
					$user = $r1->getdriver()->Strip($row["responce_user"]);
					$text = $row["responce_text"];
					$date = $r1->getdriver()->Strip(date("d-m-Y", $row["responce_date"]));
									
				echo "<div><h3>Редактирование отзыва</h3>";
				echo('<form enctype="multipart/form-data" method="POST" action="'.$url.'">
						<table border="0">
							<tr><td colspan="2"><input type="hidden" name="responce_id" value="'.$responce_id.'" size="50" /></td></tr>
							<tr><td align="left">имя гостя:</td><td>дата:</td></tr>
							<tr><td><input type="text" name="responce_user" value="'.$user.'" size="50" /></td>
							<td><input type="text" id="responce_date" name="responce_date" value="'.$date.'" style="width:250px" readonly="readonly" />
							<img src="../includes/img/calendar.gif" name="otbtn" width="20" height="20" align="absmiddle" id="otbtn" /></td></tr>
							
							<tr><td align="left" colspan="2">модерация:*</td></tr>
							<tr><td align="left" colspan="2">
							<select name="responce_status">
								<option value="0">скрыть</option>
								<option value="1">отображать</option>
							</select></td></tr>
					
							<tr><td align="left" colspan="2">краткий отзыв:</td></tr>
							<tr><td colspan="2"><textarea name="responce_text" cols="70" rows="7">'.$text.'</textarea></td></tr>
							<tr><td colspan="2" align="center"><br />
							<button type="submit" name="update_resp_form"><img src="../includes/img/it/save.gif" /></button>
							&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel">
							<img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
						</table>
					</form></div>');
					calendarEcho();
			}
			else
			{
				echo "Ошибка редактирования!";
				//echo "<br /><a class='error_link' href='' OnClick='history.back();'><< вернуться</a>";
				showResps($r1, $url);
			}
		}
		// обработка редактирования отзыва
		else if (isset($_POST["update_resp_form"]))
		{
			if (($_POST["responce_id"] != '') && ($_POST["responce_user"] != '') && ($_POST["responce_text"] != '') 
			&& ($_POST["responce_date"] != '') && ($_POST['responce_date'] != 'dd-mm-yyyy'))
			{
				$responce_id = $_POST["responce_id"];
				$user = $r1->getdriver()->PutContent($_POST["responce_user"]);
				$status = $_POST["responce_status"];
				$text = $_POST["responce_text"];
				$date = $r1->getdriver()->PutContent($_POST["responce_date"]);
				
				$updt = array("'".$user."'", "'".$text."'", $date, $status );
				$r1->UpdateResponce('t_responce', $updt, 'responce_id='.$responce_id.'');
				showResps($r1, $url);				
			} else {
				echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
				showResps($r1, $url);
			}
		}
		// показ отзывов
		else{ showResps($r1, $url); }
		break;
	} //case		
/* 		case 1: {
			//будем привязывать к лист модулю пункты меню, пункты меню выводяться в таблице с чекбоксами!
			printf('<div id="menu">
						<ul>
							<li><a href="%s&&menu_pop=0">список отзывов</a></li>
							<li id="active"><a href="%s&&menu_pop=1">настройки</a></li>
						</ul>
					</div>
					<div id="under_blue_menu">&nbsp;</div>', $url, $url);
					
			// здесь будет список строк, на разрешающий статус			
			if (isset($_POST["build_resp_form"]))
			{
				if ($_POST["responce_id"] != null)
				{
					$rp_id = implode(";", $_POST["responce_id"]);
					$rp_id = array("'".$rp_id."'");
					//$rp_id = $_POST["responce_id"];
					for($i=0; $i<count($rp_id); ++$i)
					{
						echo("$rp_id[$i]");
						//$r1->SelectNews('t_responce', 'responce_id='.$rp_id[$i], '', '');
						//$row = $r1->getdriver()->FetchResult();

					//$r1->getdriver()->Update('t_responce', 'responce_status', 1, 'responce_id='.$id);
					}
					showBuildResp($r1, $url);
				}
				else
				{
					echo "<br /><div class='sms_error'>Не обозначены строки для операции!</div>";
					showBuildResp($r1, $url);
				}
			}
			else if (isset($_POST["debuild_resp_form"]))
			{
				$r1->getdriver()->Update('t_responce', 'responce_status', '0', '');
				showBuildResp($r1, $url);
			}
			else
			{
				showBuildResp($r1, $url);
			}
			break;
		} */
		default: noTab();
	}
?>