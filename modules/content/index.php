<?
	include_once("../core/cl_seo.php");	// для сео
	$seo = new cl_seo();
	
	include_once("../modules/content/cl_content.php"); //клас для роботи с контент
	include_once("../modules/menu/cl_menu.php"); // клас для роботи с меню сайта
	include_once("../modules/menu/cl_popmenu.php"); // клас для роботи с подменю сайта
	include_once("../core/cl_navigation.php");
	
	$content = new cl_content();
	$menu = new cl_menu();
	$popmenu = new cl_popmenu();
	$modlist = new cl_list_modules();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=content&&titlem=Содержимое сайта"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения контента
	function showData($content, $menu, $popmenu, $url)
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
     	
		// вставка для отображения списка содержимого
		$content->SelectData('t_content', '', '', '');
		$count = $content->getdriver()->Count();
		
		$content->getdriver()->Select('t_content', '', '', '', 'content_date', 'DESC', $p, '20');
		if ($count != 0)
			{	
				printf('<form id="group_1" method="POST" name="formnews" id="formnews" action="%s">
								<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  <th>#</th>
									  <th>Название содержимого</th>
									  <th>Дата добавления содержимого</th>
									  <th>Показывать в меню</th>
									  <th>Показывать в подменю</th>
									  <th>Управление</th>
									  </tr>
									</thead>
									<tbody>', $url);
					while ($row = $content->getdriver()->FetchResult())
					{
						$id = $row["content_mm_id"];
						$idpop = $row["content_popmm_id"];
						$title = $content->getdriver()->Strip($row["content_title"]);
						$date = $content->getdriver()->Strip(date("d-m-Y", $row["content_date"]));
						//название меню, под которое привязываем
						$menu->SelectMenu('t_menu', 'menu_id='.$id, '', '');
						if (($menu->getdriver()->Count()) > 0)
						{
							$row_menu = $menu->getdriver()->FetchResult();
							$row_m = $row_menu["menu_name"];
						}
						else
						{
							if ($id == '0') $row_m = "главная";
							else if ($id == 'none') $row_m = "-";
						}
						//название меню, под которое привязываем
						$popmenu->SelectMenu('t_popmenu', 'popmenu_id='.$idpop, '', '');
						if (($popmenu->getdriver()->Count()) > 0)
						{
							$row_popmenu = $popmenu->getdriver()->FetchResult();
							$row_popm = $row_popmenu["popmenu_name"];
						}
						else $row_popm = "-";
						
						echo ('<tr>
								  <td align="center"><input type="checkbox" name="content_id[]" value="'.$row["content_id"].'" /></td>
								  <td>'.$title.'</td>
								  <td align="center">'.$date.'</td>
								  <td align="center">'.$row_m.'</td>
								  <td align="center">'.$row_popm.'</td>
								  <td align="center"><a href="'.$url.'&&content_id='.$row["content_id"].'&&update_data=1">редактировать</a> | <a href="'.$url.'&&content_id[]='.$row["content_id"].'&&del_data=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					printf('</tbody>	  
							<tr>
								<td colspan="5" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td colspan="1" align="center"><button type="submit" name="delete_data" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formnews.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
												<button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">
								Всего записей: %s </td>
							</tr>
							<tr>
								<td colspan="6">'.$navigator->links($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,$count).'</td>
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
									  <th>#</th>
									  <th>Название содержимого</th>
									  <th>Дата добавления содержимого</th>
									  <th>Показывать в меню</th>
									  <th>Показывать в подменю</th>
									  <th>Управление</th>
									  </tr>
								</thead>
								
							<tr>
								<td colspan="5" align="center"><h3>Извините, нет содержимого для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">Всего записей: 0 </td>
							</tr>
						</table>
						</form>', $url);
			}
	}	// --------------end showконтента --------------------------
	
	
	// -------------------------------- /проверка к каким пунктам главного меню привязан модуль для показа необходимого контента ------------------------------
	switch ($_GET["menu_pop"])
	{
		case 0:
				printf('<div id="menu">
			    			<ul>
			                    <li id="active"><a href="%s">содержимое сайта</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url);
				// форма для добавления новостей
				if (isset($_POST["add_data"]))
				{
					//выбор пункта меню
					$option = '<option value="none">- выберите меню -</option>';
					$option .= '<option value="0">главная</option>';
					$menu->SelectMenu('t_menu', 'menu_type != 3 and menu_type != 4', '', '');
					while($row = $menu->getdriver()->FetchResult())
					{
						$option .= '<option value="'.$row["menu_id"].'">'.$row["menu_name"].'</option>';
					}
					
					echo ('<script type="text/javascript" src="../includes/scripts/js/fckeditor/fckeditor.js"></script>
					<script type="text/javascript">
						window.onload = function()
						{
							var sBasePath = "../includes/scripts/js/fckeditor/";
							
							var content = new FCKeditor(\'content\');
							content.Width = "100%" ;
							content.Height = "350" ;
							content.BasePath = sBasePath;
							content.ReplaceTextarea();
						}
					</script>');
					
					echo ('<form method="POST" action="'.$url.'" id="data">
								<table border="0" width="80%">
									<tr><td colspan="2"><h3>Добавление содержимого сайта</h3></td></tr>
									<tr><td align="left">название содержимого:*</td><td>дата:*</td></tr>
									<tr><td><input type="text" name="content_title" value="" size="50" /></td><td>
									<input name="content_date" type="text" id="content_date" value="'.date("d-m-Y").'" style="width:250px" readonly="readonly" />
									<img src="../includes/img/calendar.gif" name="otbtn" width="20" height="20" align="absmiddle" id="otbtn" />
									</td></tr>');
					echo ('<tr><td align="left" colspan="2">содержимое сайта:*</td></tr>
									<tr><td colspan="2"><textarea name="content" id="content" cols="38" rows="7"></textarea></td></tr>
									<tr><td align="left" colspan="1">привязать к пункту меню:</td><td align="left" colspan="1">привязать к подпункту меню:</td></tr>
									<tr><td colspan="1">
										<select name="content_mm_id" onChange="SelectPopMenu(); return false">
											'.$option.'
						                </select>
									</td>
									<td colspan="1">
										<div id="select_popresult">
											<select name="content_popmm_id">
												<option value="none">- выберите подменю -</option>
							                </select>
										</div>
									</td></tr>
									<tr><td align="center" colspan="2"><br /><button type="submit" name="add_data_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									<tr><td colspan="2">'); $seo->FormSeo('', '', '', ''); echo ('</td></tr>
								</table>
							</form>');
							
							//--------------------------------------------------------- для календаря------------------------------------------------------------------
							echo '<script type="text/javascript" src="../includes/scripts/js/calendar_stripped.js"></script>
									<script type="text/javascript" src="../includes/scripts/js/calendar-ru_win.js"></script>
									<script type="text/javascript" src="../includes/scripts/js/calendar-setup_stripped.js"></script>
									<script type="text/javascript">
											Calendar.setup(
											{
											inputField : "content_date", // ID of the input field
											ifFormat : "%d-%m-%Y", // the date format
											daFormat : "%d-%m-%Y", // the date format
											firstDay : 1, // the date format
											button : "otbtn" // ID of the button
											}
											);
									</script>';
							//--------------------------------------------------------------------------------------------------------------------------------------------------
							
					// <script language='javascript'>	
						    // document.write("<input type='button' onclick=\"popUpCalendar(this, document.getElementById('date'), 'dd-mm-yyyy')\" value='Календарь' />");
					// </script>
			
					//<input type="text" id="date" name="date_news" value="dd-mm-yyyy" size="50" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)" />
				}
				// обработка добавления новостей
				else if (isset($_POST["add_data_form"]))
				{
					if (($_POST["content_title"] != '') && ($_POST['content'] != '') && ($_POST['content_date'] != '') && ($_POST['content_date'] != 'dd-mm-yyyy'))
					{
						$title = $content->getdriver()->PutContent($_POST['content_title']);
						//$text = $content->getdriver()->PutContent($_POST['content']);
						$text = $content->getdriver()->PutContent($_POST["content"]);
						$date = $content->getdriver()->PutContent($_POST['content_date']);
						$mm = $_POST['content_mm_id'];
						$popmm = $_POST['content_popmm_id'];
						
						$title = "'".$title."'";
						$text = "'".$text."'";
						$mm = "'".$mm."'";
						$popmm = "'".$popmm."'";
						
										$mas_seo[0] = $_POST['seo_title'];
										$mas_seo[1] = $_POST['seo_description'];
										$mas_seo[2] = $_POST['seo_keywords'];
										
						// если не привязано к меню
						if ($_POST["content_mm_id"] == 'none')
						{
										$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
										if ($res != 0)
										{
											$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
											$row = $seo->getdriver()->FetchResult();
							
											$insert = array("''", $title, $text, $date, $mm, $popmm, $row[0]);
											$content->InsertData('t_content', $insert);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
						}
						// если привязано к меню, проверяем или уже есть запись которая привязана к этому меню, если так - то переписываем
						else
						{
							// если не привязано к подменю
							if ($_POST["content_popmm_id"] == 'none')
							{
								//echo "Не пересилаем попменю";
									$content->SelectData('t_content', "content_mm_id='".$_POST["content_mm_id"]."'", '', '');
									// если есть уже запись с таким пунктом меню
									if (($content->getdriver()->Count()) > 0)
									{
										$old_record = $content->getdriver()->FetchResult();
										
										$id_old = $old_record["content_id"];
										$title_old = $old_record["content_title"];
										$text_old = $old_record["content_text"];
										$date_old = date("d-m-Y", $old_record["content_date"]);
										$mm_old = "none";
										$popmm_old = "none";
										$seo_id_old = $old_record["content_seo_id"];
										
										$title_old = "'".$title_old."'";
										$text_old = "'".$text_old."'";
										$mm_old = "'".$mm_old."'";
										$popmm_old = "'".$popmm_old."'";
										
										$updt_old = array($title_old, $text_old, $date_old, $mm_old, $popmm_old, $seo_id_old);
										$content->UpdateData('t_content', $updt_old, 'content_id='.$id_old);
										
										$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
										if ($res != 0)
										{
											$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
											$row = $seo->getdriver()->FetchResult();
							
											$insert = array("''", $title, $text, $date, $mm, $popmm, $row[0]);
											$content->InsertData('t_content', $insert);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
									// если не нашли такую запись
									else
									{
										$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
										if ($res != 0)
										{
											$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
											$row = $seo->getdriver()->FetchResult();
							
											$insert = array("''", $title, $text, $date, $mm, $popmm, $row[0]);
											$content->InsertData('t_content', $insert);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
							}
							// если привязано к подменю, проверяем или уже есть запись которая привязана к этому подменю, если так - то переписываем
							else
							{
								//echo "Пересилаем попменю";
									$content->SelectData('t_content', "content_mm_id='".$_POST["content_mm_id"]."' and content_popmm_id='".$_POST["content_popmm_id"]."'", '', '');
									// если есть уже запись с таким пунктом меню
									if (($content->getdriver()->Count()) > 0)
									{
										$old_record = $content->getdriver()->FetchResult();
										
										$id_old = $old_record["content_id"];
										$title_old = $old_record["content_title"];
										$text_old = $old_record["content_text"];
										$date_old = date("d-m-Y", $old_record["content_date"]);
										$mm_old = "none";
										$popmm_old = "none";
										$seo_id_old = $old_record["content_seo_id"];
										
										$title_old = "'".$title_old."'";
										$text_old = "'".$text_old."'";
										$mm_old = "'".$mm_old."'";
										$popmm_old = "'".$popmm_old."'";
										
										$updt_old = array($title_old, $text_old, $date_old, $mm_old, $popmm_old, $seo_id_old);
										$content->UpdateData('t_content', $updt_old, 'content_id='.$id_old);
										
										$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
										if ($res != 0)
										{
											$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
											$row = $seo->getdriver()->FetchResult();
							
											$insert = array("''", $title, $text, $date, $mm, $popmm, $row[0]);
											$content->InsertData('t_content', $insert);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
									// если не нашли такую запись
									else
									{
										$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
										if ($res != 0)
										{
											$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
											$row = $seo->getdriver()->FetchResult();
							
											$insert = array("''", $title, $text, $date, $mm, $popmm, $row[0]);
											$content->InsertData('t_content', $insert);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
							}
						}
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
						//echo "<a class='error_link' href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showData($content, $menu, $popmenu, $url);
					}
				}
				// обработка удаления выбраных
				else if (isset($_POST["delete_data"]))
				{
					if ($_POST["content_id"] != null)
					{
						$delete = $_POST["content_id"];
						for($i=0; $i<count($delete); $i++)
						{
							$content->SelectData('t_content', 'content_id='.$delete[$i], '', '');
							$row = $content->getdriver()->FetchResult();
							$seo_id = $row["content_seo_id"];
							$res = $seo->DeleteSeo($seo_id);
						}
						
						if ($res != 0)
						{
							$content->DeleteData('t_content', $delete);
							showData($content, $menu, $popmenu, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка удаления!</div>";
							showData($content, $menu, $popmenu, $url);
						}
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали содержимое для удаления!</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showData($content, $menu, $popmenu, $url);
					}
				}
				// форма для удаления одной новости
				else if (isset($_GET["del_data"]))
				{
					if (($_GET["content_id"] != null) && ($_GET["del_data"]==1))
					{
						$delete = $_GET["content_id"];
						$content->SelectData('t_content', 'content_id='.$delete[0], '', '');
						$row = $content->getdriver()->FetchResult();
						$seo_id = $row["content_seo_id"];

						$res = $seo->DeleteSeo($seo_id);
						if ($res != 0)
						{
							$content->DeleteData('t_content', $delete);
							showData($content, $menu, $popmenu, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка удаления!</div>";
							showData($content, $menu, $popmenu, $url);
						}
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали содержимое для удаления!</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showData($content, $menu, $popmenu, $url);
					}
				}
				// форма для редактирования новостей
				else if (isset($_GET["update_data"]))
				{
					if (($_GET["content_id"] != null) && ($_GET["update_data"]==1))
					{
						
						$id_edit = $_GET["content_id"];
						$content->SelectData('t_content', 'content_id='.$id_edit, '', '');
						$row = $content->getdriver()->FetchResult();
							$id = $row["content_id"];
							$title = $content->getdriver()->Strip($row["content_title"]);
							$text = stripslashes($row["content_text"]);
							$date = $content->getdriver()->Strip(date("d-m-Y", $row["content_date"]));
							$mm = $row["content_mm_id"];
							$popmm = $row["content_popmm_id"];
							$seo_id = $row["content_seo_id"];
						// зделать запрос на виборку по переданой айдишке
						
						$mas_seo = $seo->SelectSeo($seo_id);
						
						//выбор меню
						$option = '<option value="none">- выберите меню -</option>';
						if ($mm == '0') $option .= '<option value="0" selected>главная</option>';
						else $option .= '<option value="0">главная</option>';
						$menu->SelectMenu('t_menu', 'menu_type != 3 and menu_type != 4', '', '');
						while($row = $menu->getdriver()->FetchResult())
						{
							if ($row["menu_id"] == $mm) $option .= '<option value="'.$row["menu_id"].'" selected>'.$row["menu_name"].'</option>';
								else $option .= '<option value="'.$row["menu_id"].'">'.$row["menu_name"].'</option>';
						}
						//выбор подменю
						$popmenu->SelectMenu('t_popmenu', 'popmenu_mm_id='.$mm, '', '');
						while($row = $popmenu->getdriver()->FetchResult())
						{
							if ($row["popmenu_id"] == $popmm) $option1 .= '<option value="'.$row["popmenu_id"].'" selected>'.$row["popmenu_name"].'</option>';
								else $option1 .= '<option value="'.$row["popmenu_id"].'">'.$row["popmenu_name"].'</option>';
						}
						
						echo ('<script type="text/javascript" src="../includes/scripts/js/fckeditor/fckeditor.js"></script>
						<script type="text/javascript">
							window.onload = function()
							{
								//var sBasePath = document.location.href.substring(0,document.location.href.lastIndexOf(\'_samples\')) ;
								var sBasePath = "../includes/scripts/js/fckeditor/";
								
								var content = new FCKeditor(\'content\');
								content.Width = "100%" ;
								content.Height = "350" ;
								content.BasePath = sBasePath;
								content.ReplaceTextarea();
							}
						</script>');
						
						echo ('<form method="POST" action="'.$url.'" id="data">
								<table border="0" width="80%">
									<tr><td colspan="2"><h3>Редактирование содержимого</h3></td></tr>
									<tr><td colspan="2"><input type="hidden" name="content_id" value="'.$id.'" size="50" /></td></tr>
									<tr><td align="left">название содержимого:*</td><td>дата:*</td></tr>
									<tr><td><input type="text" name="content_title" value="'.$title.'" size="50" /></td><td>
									<input name="content_date" type="text" id="content_date" value="'.$date.'" style="width:250px" readonly="readonly" />
									<img src="../includes/img/calendar.gif" name="otbtn" width="20" height="20" align="absmiddle" id="otbtn" />
									</td></tr>
									<tr><td align="left" colspan="2">содержимое сайта:*</td></tr>
									<tr><td colspan="2"><textarea name="content" id="content" cols="38" rows="7">'.$text.'</textarea></td></tr>
									<tr><td align="left" colspan="1">привязать к пункту меню:</td><td align="left" colspan="1">привязать к подпункту меню:</td></tr>
									<tr><td colspan="1">
										<select name="content_mm_id" onChange="SelectPopMenu(); return false">
											'.$option.'
						                </select>
									</td>
									<td colspan="1">
										<div id="select_popresult">
											<select name="content_popmm_id">
												<option value="none">- выберите подменю -</option>
												'.$option1.'
							                </select>
										</div>
									</td></tr>
									<tr><td colspan="2" align="center"><br /><button type="submit" name="update_data_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									<tr><td colspan="2">'); $seo->FormSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]); echo ('</td></tr>
								</table>
							</form>');
							
							//--------------------------------------------------------- для календаря------------------------------------------------------------------
							echo '<script type="text/javascript" src="../includes/scripts/js/calendar_stripped.js"></script>
									<script type="text/javascript" src="../includes/scripts/js/calendar-ru_win.js"></script>
									<script type="text/javascript" src="../includes/scripts/js/calendar-setup_stripped.js"></script>
									<script type="text/javascript">
											Calendar.setup(
											{
											inputField : "content_date", // ID of the input field
											ifFormat : "%d-%m-%Y", // the date format
											daFormat : "%d-%m-%Y", // the date format
											firstDay : 1, // the date format
											button : "otbtn" // ID of the button
											}
											);
									</script>';
							//--------------------------------------------------------------------------------------------------------------------------------------------------
					}
					else
					{
						echo "Ошибка редактирования!";
						//echo "<br /><a class='error_link' href='' OnClick='history.back();'><< вернуться</a>";
						showData($content, $menu, $popmenu, $url);
					}
				}
				// обработка редактирования новостей
				else if (isset($_POST["update_data_form"]))
				{
					if (($_POST["content_id"] != '') && ($_POST["content_title"] != '') && ($_POST["content"] != '') && ($_POST["content_date"] != ''))
					{
							$id = $_POST["content_id"];
							$title = $_POST["content_title"];
							$text = $_POST["content"];
							$date = $_POST["content_date"];
							$mm = $_POST["content_mm_id"];
							$popmm = $_POST["content_popmm_id"];
							$title = $content->getdriver()->PutContent($title);
							$text = $content->getdriver()->PutContent($text);
							$date = $content->getdriver()->PutContent($date);
							
							$id = "'".$id."'";
							$title = "'".$title."'";
							$text = "'".$text."'";
							$mm = "'".$mm."'";
							$popmm = "'".$popmm."'";
							
								$mas_seo[0] = $_POST['seo_id'];
								$mas_seo[1] = $_POST['seo_title'];
								$mas_seo[2] = $_POST['seo_description'];
								$mas_seo[3] = $_POST['seo_keywords'];
								
							// если не привязано к меню
							if ($_POST["content_mm_id"] == 'none')
							{
								$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
								if ($res != 0)
								{
									$updt = array($title, $text, $date, $mm, $popmm, $mas_seo[0]);
									$content->UpdateData('t_content', $updt, 'content_id='.$id);
									showData($content, $menu, $popmenu, $url);
								}
								else
								{
									echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
									showData($content, $menu, $popmenu, $url);
								}
							}
							// если привязано к меню, проверяем или уже есть запись которая привязана к этому меню, если так - то переписываем
							else
							{
								// если не привязано к подменю
								if ($_POST["content_popmm_id"] == 'none')
								{
									//echo "Не пересилаем попменю";
									$content->SelectData('t_content', "content_mm_id='".$_POST["content_mm_id"]."' and content_popmm_id='none'", '', '');
									// если есть уже запись с таким пунктом меню
									if (($content->getdriver()->Count()) > 0)
									{
										$old_record = $content->getdriver()->FetchResult();
										
										$id_old = $old_record["content_id"];
										$title_old = $old_record["content_title"];
										$text_old = $old_record["content_text"];
										$date_old = date("d-m-Y", $old_record["content_date"]);
										$mm_old = "none";
										$popmm_old = "none";
										$seo_id_old = $old_record["content_seo_id"];
										
										$title_old = "'".$title_old."'";
										$text_old = "'".$text_old."'";
										$mm_old = "'".$mm_old."'";
										$popmm_old = "'".$popmm_old."'";
										
										$updt_old = array($title_old, $text_old, $date_old, $mm_old, $popmm_old, $seo_id_old);
										$content->UpdateData('t_content', $updt_old, 'content_id='.$id_old);
									
										
										$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
										if ($res != 0)
										{
											$updt = array($title, $text, $date, $mm, $popmm, $mas_seo[0]);
											$content->UpdateData('t_content', $updt, 'content_id='.$id);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
									// если не нашли такую запись
									else
									{
										$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
										if ($res != 0)
										{
											$updt = array($title, $text, $date, $mm, $popmm, $mas_seo[0]);
											$content->UpdateData('t_content', $updt, 'content_id='.$id);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
								}
								// если привязано к подменю, проверяем или уже есть запись которая привязана к этому подменю, если так - то переписываем
								else
								{
									//echo "Пересилаем попменю";
									$content->SelectData('t_content', "content_mm_id='".$_POST["content_mm_id"]."' and content_popmm_id='".$_POST["content_popmm_id"]."'", '', '');
									// если есть уже запись с таким пунктом меню
									if (($content->getdriver()->Count()) > 0)
									{
										$old_record = $content->getdriver()->FetchResult();
										
										$id_old = $old_record["content_id"];
										$title_old = $old_record["content_title"];
										$text_old = $old_record["content_text"];
										$date_old = date("d-m-Y", $old_record["content_date"]);
										$mm_old = "none";
										$popmm_old = "none";
										$seo_id_old = $old_record["content_seo_id"];
										
										$title_old = "'".$title_old."'";
										$text_old = "'".$text_old."'";
										$mm_old = "'".$mm_old."'";
										$popmm_old = "'".$popmm_old."'";
										
										$updt_old = array($title_old, $text_old, $date_old, $mm_old, $popmm_old, $seo_id_old);
										$content->UpdateData('t_content', $updt_old, 'content_id='.$id_old);
										
										
										$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
										if ($res != 0)
										{
											$updt = array($title, $text, $date, $mm, $popmm, $mas_seo[0]);
											$content->UpdateData('t_content', $updt, 'content_id='.$id);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
									// если не нашли такую запись
									else
									{
										$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
										if ($res != 0)
										{
											$updt = array($title, $text, $date, $mm, $popmm, $mas_seo[0]);
											$content->UpdateData('t_content', $updt, 'content_id='.$id);
											showData($content, $menu, $popmenu, $url);
										}
										else
										{
											echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
											showData($content, $menu, $popmenu, $url);
										}
									}
								}
							}
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование с формы не выполнен!</div>";
						//echo "<a class='error_link' href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showData($content, $menu, $popmenu, $url);
					}
				}
				// показ новостей
				else{ showData($content, $menu, $popmenu, $url); }
				break;
				
		default:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s">содержимое сайта</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url);
				echo "Воспользуйтесь пунктом меню!";
	}
?>
<script type="text/javascript">
function SelectPopMenu() {
  var str = $("#data").serialize();
  $.post("../modules/content/select_popmenu.php", str, function(data) {
    $("#select_popresult").html(data);
  });
}
</script>