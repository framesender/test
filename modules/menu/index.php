<?
	include_once("../core/cl_seo.php");	// для сео
	$seo = new cl_seo();
	
	include_once("cl_menu.php");
	include_once("cl_popmenu.php");
	
	$menu = new cl_menu();
	$popmenu = new cl_popmenu();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=menu&&titlem=Меню сайта"; // не изменять параметры
	$url2 = "main.php?namem=menu&&titlem=Меню сайта&&menu_pop=1"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения меню
	function showMenu($menu, $url)
	{
		// вставка для отображения списка меню
		$menu->SelectMenu('t_menu', '', '', '');
		$count = $menu->getdriver()->Count();
		if ($count != 0)
			{	
				printf('<form id="group_1" method="POST" name="formmenu" action="%s">
								<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  <td>#</td>
									  <th>#</th>
									  <th>Название меню</th>
									  <th>Очередность вывода</th>
									  <th>Тип меню</th>
									  <td>Управление</td>
									  </tr>
									</thead>
									<tbody>', $url);
					while ($row = $menu->getdriver()->FetchResult())
					{
						$menu_id = 	$menu->getdriver()->Strip($row["menu_id"]);
						$menu_name = $menu->getdriver()->Strip($row["menu_name"]);
						$menu_sort = $menu->getdriver()->Strip($row["menu_sortid"]);
						$menu_type = $row["menu_type"];
						if ($menu_type == 1) $type="контент";
							else if ($menu_type == 2) $type="новости";
								else if ($menu_type == 3) $type="контакты";
									else if ($menu_type == 4) $type="фотогалерея";
										else if ($menu_type == 5) $type="недвижимость";
											else if ($menu_type == 6) $type="другая текстовая информация";
												else if ($menu_type == 7) $type="отзывы";
                                                    else if ($menu_type == 8) $type="записи";
											 else $type="-";
						echo ('<tr>
								  <td align="center"><input type="checkbox" name="menu_id[]" value="'.$row["menu_id"].'" /></td>
								  <td>'.$menu_id.'</td>
								  <td>'.$menu_name.'</td>			  
								  <td align="center">'.$menu_sort.'</td>			  
								  <td align="center">'.$type.'</td>			  
								  <td align="center"><a href="'.$url.'&&menu_id='.$row["menu_id"].'&&update_menu=1">редактировать</a> | <a href="'.$url.'&&menu_id[]='.$row["menu_id"].'&&del_menu=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					printf('</tbody>	  
							<tr>
								<td colspan="5" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td align="center"><button type="submit" name="delete_menu" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formmenu.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button> &nbsp;&nbsp;&nbsp;
									<button type="submit" name="add_menu"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">Всего записей: %s </td>
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
										 <th>#</th>
										 <th>Название меню</th>
										 <th>Очередность вывода</th>
										 <th>Тип меню</th>
										 <td>Управление</td>
									 </tr>
								</thead>
							<tr>
								<td colspan="5" align="center"><h3>Извините, нет меню для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_menu"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">Всего записей: 0 </td>
							</tr>
						</table>
						</form>', $url);
			}
	}
	
	// функция для отображения подпунктов меню
	function showPopMenuSelect($menu)
	{
		/* ----------------добавление подпунктов меню------------- */
					$option = '<option value="none">- выберите меню -</option>';
					$option .= '<option value="0">главная</option>';
					$menu->SelectMenu('t_menu', '', '', '');
					while($row = $menu->getdriver()->FetchResult())
					{
						$option .= '<option value="'.$row["menu_id"].'">'.$row["menu_name"].'</option>';
					}
					echo "";
					printf('<div class="padding_form"><form method="POST" id="ajaxpopmenu">
									<table border="0">
										<tr><td colspan="1" align="left">список меню:*</td></tr>
										<tr><td>
											<select name="ajaxid" id="ajaxid" onChange="FormClick(); return false">
												%s
							                </select>
										</td></tr>
									</table>
								</form></div>', $option);
								
					echo '<div id="popresult">';
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
									<td colspan="6" align="right">Всего записей: 0 </td>
								</tr>
							</table>');
					echo '</div>';
	}
	
	switch ($_GET["menu_pop"])
	{
		case 0:
				printf('<div id="menu">
			    			<ul>
			                    <li id="active"><a href="%s">список меню</a></li>
			                    <li><a href="%s&&menu_pop=1">подпункты меню</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				// форма для добавления меню
				if (isset($_POST["add_menu"]))
				{
					echo "";
					echo ('<form method="POST" action="'.$url.'">
								<table border="0"><tr><td valign="top">
									<table border="0">
										<tr><td><h3>Добавление меню</h3></td></tr>
										<tr><td align="left">название меню:*</td></tr>
										<tr><td><input type="text" name="menu_name" value="" size="50" /></td></tr>
										<tr><td align="left">позиция меню*:</td></tr>
										<tr><td><input type="text" name="menu_sortid" value="" size="50" /></td></tr>
										<tr><td align="left">тип меню*:</td></tr>
										<tr><td><select name="menu_type">
							                    <option value="0">- выберите тип меню -</option>
							                    <option value="1">контент</option>
							                    <option value="2">новости</option>
							                    <option value="3">контакты</option>
												<option value="4">фотогалерея</option>
												<option value="5">недвижимость</option>
												<option value="7">отзывы</option>
                                                <option value="8">записи</option>
												<option value="6">другая текстовая информация</option>
							                    </select></td></tr>
										<tr><td align="center"><br /><button type="submit" name="add_menu_form"><img src="../includes/img/it/save.gif"  /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									</table>
								</td><td>'); $seo->FormSeo('', '', '', ''); echo ('</td></tr></table>
							</form>');

					// <script language='javascript'>	
						    // document.write("<input type='button' onclick=\"popUpCalendar(this, document.getElementById('date'), 'dd-mm-yyyy')\" value='Календарь' />");
					// </script>
			
					//<input type="text" id="date" name="date_news" value="dd-mm-yyyy" size="50" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" />
				}
				// обработка добавления новостей
				else if (isset($_POST["add_menu_form"]))
				{
					if (($_POST["menu_name"] != '') && ($_POST["menu_sortid"] != 0) && ($_POST["menu_type"] != 0))
					{
						$name = $menu->getdriver()->PutContent($_POST['menu_name']);
						$sort = $menu->getdriver()->PutContent($_POST['menu_sortid']);
						$type = $_POST['menu_type'];
						$name = "'".$name."'";
						
						$mas_seo[0] = $_POST['seo_title'];
						$mas_seo[1] = $_POST['seo_description'];
						$mas_seo[2] = $_POST['seo_keywords'];
						$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
						if ($res != 0)
						{
							$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
							$row = $seo->getdriver()->FetchResult();
							
							$insert = array("''", $name, $sort, $type, $row[0]);
							$menu->InsertMenu('t_menu', $insert);
							showMenu($menu, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
							showMenu($menu, $url);
						}
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
						showMenu($menu, $url);
					}
				}
				// обработка удаления выбраных меню
				else if (isset($_POST["delete_menu"]))
				{
					if ($_POST["menu_id"] != null)
					{
						$delete = $_POST["menu_id"];
						for($i=0; $i<count($delete); $i++)
						{
							$menu->SelectMenu('t_menu', 'menu_id='.$delete[$i], '', '');
							$row = $menu->getdriver()->FetchResult();
							$seo_id = $row["menu_seo_id"];
							$res = $seo->DeleteSeo($seo_id);
						}
						
						if ($res != 0)
						{
							$menu->DeleteMenu('t_menu', $delete);
							showMenu($menu, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка удаления!</div>";
							showMenu($menu, $url);
						}
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали меню для удаления!</div>";
						showMenu($menu, $url);
					}
				}
				// форма для удаления одной 
				else if (isset($_GET["del_menu"]))
				{
					if (($_GET["menu_id"] != null) && ($_GET["del_menu"]==1))
					{
						$delete = $_GET["menu_id"];
						$menu->SelectMenu('t_menu', 'menu_id='.$delete[0], '', '');
						$row = $menu->getdriver()->FetchResult();
						$seo_id = $row["menu_seo_id"];

						$res = $seo->DeleteSeo($seo_id);
						if ($res != 0)
						{
							$menu->DeleteMenu('t_menu', $delete);
							showMenu($menu, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка удаления!</div>";
							showMenu($menu, $url);
						}
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали меню для удаления!</div>";
						showMenu($menu, $url);
					}
				}
				// форма для редактирования
				else if (isset($_GET["update_menu"]))
				{
					if (($_GET["menu_id"] != null) && ($_GET["update_menu"]==1))
					{
						$id_edit = $_GET["menu_id"];
						$menu->SelectMenu('t_menu', 'menu_id='.$id_edit, '', '');
						
						$row = $menu->getdriver()->FetchResult();
							$id = $row["menu_id"];
							$name = $menu->getdriver()->Strip($row["menu_name"]);	
							$sort = $menu->getdriver()->Strip($row["menu_sortid"]);	
							$type = $row["menu_type"];
							$seo_id = $row["menu_seo_id"];

						$mas_seo = $seo->SelectSeo($seo_id);
						
						//выбор типа меню
							if ($type == 1)
								$option1 = '<option value="1" selected>контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
							else if ($type == 2)
									$option1 = '<option value="1">контент</option>
						                    <option value="2" selected>новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
							else if ($type == 3)
									$option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3" selected>контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
							else if ($type == 4)
									$option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4" selected>фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
							else if ($type == 5)
									$option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5" selected>недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
							else if ($type == 6)
									$option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6" selected>другая текстовая информация</option>';
							else if ($type == 7)
									$option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7" selected>отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
                           else if ($type == 8)
									$option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7" >отзывы</option>
                                            <option value="8" selected>записи</option>
											<option value="6">другая текстовая информация</option>';
							else $option1 = '<option value="1">контент</option>
						                    <option value="2">новости</option>
						                    <option value="3">контакты</option>
						                    <option value="4">фотогалерея</option>
											<option value="5">недвижимость</option>
											<option value="7">отзывы</option>
                                            <option value="8">записи</option>
											<option value="6">другая текстовая информация</option>';
					
						echo "";
						echo ('<form method="POST" action="'.$url.'">
								<table border="0"><tr><td valign="top">
								<table border="0">
									<tr><td><div><h3>Редактирование меню</h3></td></tr>
									<tr><td colspan="1"><input type="hidden" name="menu_id" value="'.$id.'" size="50" /></td></tr>
									<tr><td align="left">название меню:*</td></tr>
									<tr><td><input type="text" name="menu_name" value="'.$name.'" size="50" /></td></tr>
									<tr><td align="left">позиция меню*:</td></tr>
									<tr><td><input type="text" name="menu_sortid" value="'.$sort.'" size="50" /></td></tr>
									<tr><td align="left">тип меню*:</td></tr>
									<tr><td><select name="menu_type">
						                    <option value="0">- выберите тип меню -</option>
						                    '.$option1.'
						                    </select></td></tr>
									<tr><td colspan="1" align="center"><br /><button type="submit" name="update_menu_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
								</td><td>'); $seo->FormSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]); echo ('</td></tr></table>
							</form>');
							//</form></div>', $url, $id, $name, $sort, $option1);
					}
					else
					{
						echo "Ошибка редактирования!";
						//echo "<br /><a class='error_link' href='' OnClick='history.back();'><< вернуться</a>";
						showMenu($menu, $url);
					}
				}
				// обработка редактирования
				else if (isset($_POST["update_menu_form"]))
				{
					if (($_POST["menu_id"] != '') && ($_POST["menu_name"] != '') && ($_POST["menu_sortid"] != 0) && ($_POST["menu_type"] != 0))
					{
						$id = $_POST["menu_id"];
						$name = $_POST["menu_name"];
						$sort = $_POST["menu_sortid"];
						$type = $_POST["menu_type"];
						
						$name = $menu->getdriver()->PutContent($name);
						$sort = $menu->getdriver()->PutContent($sort);
						
						$mas_seo[0] = $_POST['seo_id'];
						$mas_seo[1] = $_POST['seo_title'];
						$mas_seo[2] = $_POST['seo_description'];
						$mas_seo[3] = $_POST['seo_keywords'];
						$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
						if ($res != 0)
						{							
							$updt = array("'".$name."'", $sort, $type, $mas_seo[0]);
							//$updt = array($title, $short_text, $text, $date);
							$menu->UpdateMenu('t_menu', $updt, 'menu_id='.$id);
							showMenu($menu, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
							showMenu($menu, $url);
						}
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
						//echo "<a class='error_link' href='".$url."'><< вернуться</a>";
						showMenu($menu, $url);
					}
				}
				// показ
				else{ showMenu($menu, $url); }
				break;
				
		case 1:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">список меню</a></li>
			                    <li id="active"><a href="%s&&menu_pop=1">подпункты меню</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
						
				if (isset($_POST["add_popmenu"]))
				{
					if (isset($_POST["popmenu_mm_id"]))
					{
						echo "<br /><h3>Добавление подпунктов меню</h3><br />";
						printf('<form method="POST" action="%s">
									<table border="0">
										<tr><td colspan="1"><input type="hidden" name="popmenu_mm_id" value="%s" size="50" /></td></tr>
										<tr><td align="left">название подменю:*</td></tr>
										<tr><td><input type="text" name="popmenu_name" value="" size="50" /></td></tr>
										<tr><td align="left">позиция подменю*:</td></tr>
										<tr><td><input type="text" name="popmenu_sortid" value="" size="50" /></td></tr>
										<tr><td align="center"><br /><button type="submit" name="add_popmenu_form"><img src="../includes/img/it/save.gif" /></button>
												&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									</table>
								</form>', $url2, $_POST["popmenu_mm_id"]);
					}
				}
				else if (isset($_POST["add_popmenu_form"]))
				{
					if (($_POST["popmenu_name"] != '') && ($_POST["popmenu_sortid"] != ''))
					{
						$name = $popmenu->getdriver()->PutContent($_POST['popmenu_name']);
						$sort = $popmenu->getdriver()->PutContent($_POST['popmenu_sortid']);
						$popmenu_mm_id = $_POST['popmenu_mm_id'];
						
						$name = "'".$name."'";
						//$sort = "'".$sort."'";
						//$popmenu_mm_id = "'".$popmenu_mm_id."'";
		
						$insert = array("''", $name, $sort, $popmenu_mm_id);
						$popmenu->InsertMenu('t_popmenu', $insert);
						
						showPopMenuSelect($menu);
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
						showPopMenuSelect($menu);
					}
				}
				// обработка удаления выбраных подменю
				else if (isset($_POST["delete_popmenu"]))
				{
					if ($_POST["popmenu_id"] != null)
					{
						$delete = $_POST["popmenu_id"];
						$popmenu->DeleteMenu('t_popmenu', $delete);
						showPopMenuSelect($menu);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали подменю для удаления!</div>";
						showPopMenuSelect($menu);
					}
				}
				// форма для удаления одной 
				else if (isset($_GET["del_popmenu"]))
				{
					if (($_GET["popmenu_id"] != null) && ($_GET["del_popmenu"]==1))
					{
						$delete = $_GET["popmenu_id"];
						$popmenu->DeleteMenu('t_popmenu', $delete);
						showPopMenuSelect($menu);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали подменю для удаления!</div>";
						showPopMenuSelect($menu);
					}
				}
				// форма для редактирования
				else if (isset($_GET["update_popmenu"]))
				{
					if (($_GET["popmenu_id"] != null) && ($_GET["update_popmenu"]==1))
					{
						$id_edit = $_GET["popmenu_id"];
						$popmenu->SelectMenu('t_popmenu', 'popmenu_id='.$id_edit, '', '');
						while ($row = $popmenu->getdriver()->FetchResult())
						{
							$id = $row["popmenu_id"];
							$name = $popmenu->getdriver()->Strip($row["popmenu_name"]);	
							$sort = $popmenu->getdriver()->Strip($row["popmenu_sortid"]);
							$mm_id = $row["popmenu_mm_id"];
						} // зделать запрос на виборку по переданой айдишке
						echo "<div><br /><h3>Редактирование подменю</h3><br />";
						printf('<form method="POST" action="%s">
								<table border="0">
									<tr><td><input type="hidden" name="popmenu_id" value="%s" size="50" /></td></tr>
									<tr><td><input type="hidden" name="popmenu_mm_id" value="%s" size="50" /></td></tr>
									<tr><td align="left">название меню:*</td></tr>
									<tr><td><input type="text" name="popmenu_name" value="%s" size="50" /></td></tr>
									<tr><td align="left">позиция меню:</td></tr>
									<tr><td><input type="text" name="popmenu_sortid" value="%s" size="50" /></td></tr>
									<tr><td colspan="1" align="center"><br /><button type="submit" name="update_popmenu_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
							</form></div>', $url2, $id, $mm_id, $name, $sort);
					}
					else
					{
						echo "Ошибка редактирования!";
						showPopMenuSelect($menu);
					}
				}
				// обработка редактирования
				else if (isset($_POST["update_popmenu_form"]))
				{
					if (($_POST["popmenu_id"] != null) && ($_POST["popmenu_name"] != '') && ($_POST["popmenu_sortid"] != null) && ($_POST["popmenu_mm_id"] != null))
					{
						$id = $_POST["popmenu_id"];
						$name = $_POST["popmenu_name"];
						$sort = $_POST["popmenu_sortid"];
						$mm_id = $_POST["popmenu_mm_id"];
						
						$name = $popmenu->getdriver()->PutContent($name);
						$sort = $popmenu->getdriver()->PutContent($sort);
							
						$updt = array("'".$name."'", $sort, $mm_id);
						$popmenu->UpdateMenu('t_popmenu', $updt, 'popmenu_id='.$id.'');
						showPopMenuSelect($menu);
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
						showPopMenuSelect($menu);
					}
				}
				else 
				{
						showPopMenuSelect($menu);
				}
				break;
		default:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">список меню</a></li>
			                    <li><a href="%s&&menu_pop=1">подпункты меню</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				echo "Воспользуйтесь пунктом меню!";
	}
?>
<script type="text/javascript">
function FormClick() {
  var str = $("#ajaxpopmenu").serialize();
  $.post("../modules/menu/popmenu.php", str, function(data) {
    $("#popresult").html(data);
  });
}
</script>