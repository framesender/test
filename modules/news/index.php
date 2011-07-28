<?
	include_once("../core/cl_seo.php");	// для сео
	$seo = new cl_seo();
	
	include_once("../modules/news/cl_news.php"); //клас для роботи с новостями
	include_once("../modules/menu/cl_menu.php"); // клас для роботи с меню сайта
	include_once("../core/cl_navigation.php");
	
	$n1 = new cl_news();
	$menu = new cl_menu();
	$modlist = new cl_list_modules();
	
	/* -------------------- переменная - ссылка для отправки даных -------------------------- */
	$url = "main.php?namem=news&&titlem=Новости"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения новостей, передаем параметр - обьект новости
	function showNews($n1, $url)
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
     	
		// вставка для отображения списка новостей
		$n1->SelectNews('t_news', '', '', '');
		$count = $n1->getdriver()->Count();
		
		$n1->getdriver()->Select('t_news', '', '', '', 'date_news', 'DESC', $p, '20');
		if ($count != 0)
			{	
				echo('<form id="group_1" method="POST" name="formnews" action="'.$url.'">
								<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  <td>#</td>
									  <th>Название новости</th>
									  <th>Дата добавления</th>
									  <th>Тип новостей</th>
									  <th width="120">Картинка</th>
									  <td>Управление</td>
									  </tr>
									</thead>
									<tbody>');
					while ($row = $n1->getdriver()->FetchResult())
					{
						$title = $n1->getdriver()->Strip($row["title_news"]);
						$type = $n1->getdriver()->Strip($row["news_type"]);
						$date = $n1->getdriver()->Strip(date("d-m-Y", $row["date_news"]));
						
						$image = $n1->getdriver()->Strip($row["news_pict"]);
						if ($image != '') $image = '<a href="../files/images/news/'.$image.'" target="_blank">'.$image.'</a>';
							else $image = '-';
						
						echo ('<tr>
								  <td align="center"><input type="checkbox" name="id_news[]" value="'.$row["id_news"].'" /></td>
								  <td>'.$title.'</td>
								  <td align="center">'.$date.'</td>
								  <td align="center">'.$type.'</td>
								  <td align="center">'.$image.'</td>
								  <td align="center"><a href="'.$url.'&&id_news='.$row["id_news"].'&&update_news=1">редактировать</a> | <a href="'.$url.'&&id_news[]='.$row["id_news"].'&&del_news=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					echo('</tbody>	  
							<tr>
								<td colspan="5" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td colspan="1" align="center"><button type="submit" name="delete_news" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formnews.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
												<button type="submit" name="add_news"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">
								Всего записей: '.$count.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</tr>
							<tr>
								<td colspan="6">'.$navigator->links($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,'',$count).'</td>
							</tr>
						</table>
						</form>');
			}
			else
			{
				printf('<form method="POST" name="formnews" action="%s">
							<table class="tablesorter">
								<thead>
									 <tr id="t_hed" align="center">
									 <td>#</td>
									 <th>Название новости</th>
									 <th>Дата добавления</th>
									 <th>Тип новостей</th>
									 <th width="120">Картинка</th>
									 <td>Управление</td>
									 </tr>
								</thead>
								
							<tr>
								<td colspan="5" align="center"><h3>Извините, нет новостей для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_news"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">Всего записей: 0 &nbsp;</td>
							</tr>
						</table>
						</form>', $url);
			}
			
	}	// --------------end showNews--------------------------
	
	// функция для настройки новостей, записываем в лист_мод айдишки выбранных пунктов меню, передаем параметры - обьект меню, обьект списка модулей, и ссилку
	function showBuildNews($menu, $modlist, $url)
	{
		// вставка для отображения списка привязываемых меню
		$menu->SelectMenu('t_menu', '', '', '');
		$count = $menu->getdriver()->Count();
		if ($count != 0)
		{	
			$kol_news = FileRead('../modules/news/news_config.php');
			
				echo "<h3>Привязка панели новостей к меню сайта</h3>";
				printf('<form id="group_1" method="POST" name="formmenu" action="%s&&menu_pop=1">
						<table>
							<tr><td>Показывать новости (на панели новостей)</td></tr>
							<tr><td><input type="text" name="kol_news_panel" size="50" value="%s" /> (количество)</td></tr>
							<tr><td>Показывать новости (на странице - новости)</td></tr>
							<tr><td><input type="text" name="kol_news_site" size="50" value="%s" /> (количество)</td></tr>
						</table>
								<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  <td>#</td>
									  <th>Название меню</th>
									  <td>Статус</td>
									  <th>Очередность вывода</th>
									  </tr>
									</thead>
									<tbody>', $url, $kol_news[0], $kol_news[1]);
						//главная страница
						echo ('<tr>
								  <td align="center"><input type="checkbox" name="menu_id[]" value="0" /></td>
								  <td>главная</td>
								  <td align="center">'.ActiveMenu('0', $modlist).'</td>
								  <td align="center">1</td>
								</tr>');			
					while ($row = $menu->getdriver()->FetchResult())
					{
						$menu_name = $menu->getdriver()->Strip($row["menu_name"]);
						$menu_sort = $menu->getdriver()->Strip($row["menu_sortid"]);
						$menu_id = $row["menu_id"];
						echo ('<tr>
								  <td align="center"><input type="checkbox" name="menu_id[]" value="'.$menu_id.'" /></td>
								  <td>'.$menu_name.'</td>
								  <td align="center">'.ActiveMenu($menu_id, $modlist).'</td>
								  <td align="center">'.$menu_sort.'</td>
								</tr>');
					}
					printf('</tbody>	  
							<tr>
								<td colspan="3" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td align="center"><button type="submit" name="build_news_form"><img src="../includes/img/it/apply.gif" alt="" /></button> &nbsp;&nbsp;&nbsp;
													<button type="submit" name="debuild_news_form"><img src="../includes/img/it/cancel.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="4" align="right">Всего записей: %s &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Показать&nbsp;
						                    <select name="scount">
											<option value="0">- -</option>
						                    <option value="5">5</option>
						                    <option value="10">10</option>
						                    <option value="20">20</option>
						                    </select>
						                    &nbsp;записей</td>
							</tr>	 
						</table>
						</form>', $count);
		}
		else echo "<h3>Привязка новостей к меню сайта</h3><h4>Извините, нет меню для отображения!</h4>";
	}	// -------------- end showBuildNews --------------------------
	
	// проверка к каким пунктам меню привязан модуль , передаем параметры - ид меню и обьект модуля
	function ActiveMenu ($menu_id, $modlist)
	{
		$modlist->getdriver()->Select('list_mod', '', "src_list_mod='news' and mm_id like '%".$menu_id."%'", '', '', '', '', '');
		$count = $modlist->getdriver()->Count();
		if ($count != 0)
		{
			return "<img src='../includes/img/icons_table/active.png' alt=''>";
		}
		else
		{
			return "<img src='../includes/img/icons_table/deactive.png' alt=''>";
		}
	}
	// --------------/проверка к каким пунктам меню привязан модуль -------------------------------------
	
	function FileSave($file, $str)
	{
		$h = @fopen($file,"w");
		if (fwrite($h,$str)) 
		  echo "<div class='sms_succses'>Запись настроек прошла успешно</div>";
		else 
		  echo "<div class='sms_error'>Ошибка при записи настроек</div>";
		fclose($h);
	}
	
	function FileRead($file)
	{
		if (file_exists($file))
		{
		  $content = file_get_contents($file);
		  return $kol_news = explode(";", $content);
		}
		else
		{
		  echo "<div class='sms_error'>Файл <b>$file</b> не найден</div>";
		}
	}
	
	// -------------------------------- /проверка к каким пунктам главного меню привязан модуль для показа необходимого контента ------------------------------
	switch ($_GET["menu_pop"])
	{
		case 0:
				printf('<div id="menu">
			    			<ul>
			                    <li id="active"><a href="%s">список новостей</a></li>
			                    <li><a href="%s&&menu_pop=1">настройки</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				// форма для добавления новостей
				if (isset($_POST["add_news"]))
				{
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
							
							var short_content = new FCKeditor(\'short_content\');
							short_content.Width = "100%";
							short_content.Height = "170";
							short_content.ToolbarSet = "Basic";
							short_content.BasePath = sBasePath;
							short_content.ReplaceTextarea();
						}
					</script>');
					
					echo "<h3>Добавление новостей</h3>";
					echo('<form enctype="multipart/form-data" method="POST" action="'.$url.'">
								<table border="0" width="80%">
									<tr><td align="left">название новости:*</td><td>дата:*</td></tr>
									<tr><td><input type="text" name="title_news" value="" size="50" /></td>
										<td><input type="text" id="date_news" name="date_news" value="'.date("d-m-Y").'" style="width:250px" readonly="readonly" />
										<img src="../includes/img/calendar.gif" name="otbtn" width="20" height="20" align="absmiddle" id="otbtn" /></td></tr>
									<tr><td align="left" colspan="2"><br />тип новости:*</td></tr>
									<tr><td align="left" colspan="2"><select name="news_type">
															<option value="новости">новости</option>
															<!--<option value="аналитика">аналитика</option>
															<option value="пресса">пресса</option>-->
															</select></td></tr>
									<tr><td align="left" colspan="2"><br />картинка:</td></tr>
									<tr><td align="left" colspan="2"><input type="file" name="image" value="" style="width: 100%;" /></td></tr>
									<tr><td align="left" colspan="2"><br />короткое описание новости:*</td></tr>
									<tr><td colspan="2"><textarea name="short_content" id="short_content" cols="70" rows="7"></textarea></td></tr>
									<tr><td align="left" colspan="2"><br />полное описание новости:*</td></tr>
									<tr><td colspan="2"><textarea name="content" id="content" cols="38" rows="7"></textarea></td></tr>
									<tr><td align="center" colspan="2"><br /><button type="submit" name="add_news_form"><img src="../includes/img/it/save.gif"  /></button>
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
											inputField : "date_news", // ID of the input field
											ifFormat : "%d-%m-%Y", // the date format
											daFormat : "%d-%m-%Y", // the date format
											firstDay : 1, // the date format
											button : "otbtn" // ID of the button
											}
											);
									</script>';
							//--------------------------------------------------------------------------------------------------------------------------------------------------
				}
				// обработка добавления новостей
				else if (isset($_POST["add_news_form"]))
				{
					if (($_POST["title_news"] != '') && ($_POST["news_type"] != '') && ($_POST['content'] != '') && ($_POST['short_content'] != '') && ($_POST['date_news'] != '') && ($_POST['date_news'] != 'dd-mm-yyyy'))
					{
						$title = $n1->getdriver()->PutContent($_POST['title_news']);
						$type = $n1->getdriver()->PutContent($_POST['news_type']);
						$short_text = $n1->getdriver()->PutContent($_POST['short_content']);
						$text = $n1->getdriver()->PutContent($_POST['content']);
						$date = $n1->getdriver()->PutContent($_POST['date_news']);
						
						$title = "'".$title."'";
						$type = "'".$type."'";
						$short_text = "'".$short_text."'";
						$text = "'".$text."'";
						$date = $date;
						
						if (!empty($_FILES["image"]["name"]))
						{
							// загрузка файла на сайт
							$uploaddir = '../files/images/news/';     
							// будем сохранять загружаемые 
							// файлы в эту директорию
							$destination = $uploaddir;
							//$name = $_FILES['image']['name'];
							$extperms = array('gif','jpg','png');
							$ext = strtolower(substr($_FILES["image"]["name"], -3, 3));
							
							$name = 'news-pict-'.time().'.'.$ext;
							$destination .= $name;
							if(in_array($ext, $extperms))
							{
								@move_uploaded_file($_FILES['image']['tmp_name'], $destination);
								$image = "'".$name."'";
							}
							else
							{
								echo "<br /><div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								showNews($n1, $url);
								break;
							}
						}
						else $image = "''";
						
						$mas_seo[0] = $_POST['seo_title'];
						$mas_seo[1] = $_POST['seo_description'];
						$mas_seo[2] = $_POST['seo_keywords'];
						$res = $seo->InsertSeo($mas_seo[0], $mas_seo[1], $mas_seo[2]);
						if ($res != 0)
						{
							$seo->getdriver()->ExecQuery("SELECT LAST_INSERT_ID()");
							$row = $seo->getdriver()->FetchResult();
							
							$insert = array($title, $short_text, $text, $date, $type, $row[0], $image);
							$n1->InsertNews('t_news', $insert);
							showNews($n1, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
							showNews($n1, $url);
						}
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
						showNews($n1, $url);
					}
				}
				// обработка удаления выбраных новостей
				else if (isset($_POST["delete_news"]))
				{
					if ($_POST["id_news"] != null)
					{
						$delete = $_POST["id_news"];
						for($i=0; $i<count($delete); $i++)
						{
							$n1->SelectNews('t_news', 'id_news='.$delete[$i], '', '');
							$row = $n1->getdriver()->FetchResult();
							$seo_id = $row["news_seo_id"];
							$pict = $n1->getdriver()->Strip($row["news_pict"]);
							$res = $seo->DeleteSeo($seo_id);
							if ($pict != '')
							{
								$file_b = '../files/images/news/'.$pict;
								if (file_exists($file_b)) { @unlink($file_b); }
							}
						}
						
						if ($res != 0)
						{
							$n1->DeleteNews('t_news', $delete);
							showNews($n1, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка удаления!</div>";
							showNews($n1, $url);
						}
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали новости для удаления!</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showNews($n1, $url);
					}
				}
				// форма для удаления одной новости
				else if (isset($_GET["del_news"]))
				{
					if (($_GET["id_news"] != null) && ($_GET["del_news"]==1))
					{
						$delete = $_GET["id_news"];
						$n1->SelectNews('t_news', 'id_news='.$delete[0], '', '');
						$row = $n1->getdriver()->FetchResult();
						$seo_id = $row["news_seo_id"];
						$pict = $n1->getdriver()->Strip($row["news_pict"]);
						
						$res = $seo->DeleteSeo($seo_id);
						if ($res != 0)
						{
							$n1->DeleteNews('t_news', $delete);
							$k = $n1->getdriver()->Result();
							if ($k != 0)
							{
								if ($pict != '')
								{
									$file_b = '../files/images/news/'.$pict;
									if (file_exists($file_b)) { @unlink($file_b); }
								}
							}
							showNews($n1, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка удаления!</div>";
							showNews($n1, $url);
						}
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали новости для удаления!</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showNews($n1, $url);
					}
				}
				// форма для редактирования новостей
				else if (isset($_GET["update_news"]))
				{
					if (($_GET["id_news"] != null) && ($_GET["update_news"]==1))
					{
						$id_edit = $_GET["id_news"];
						$n1->SelectNews('t_news', 'id_news='.$id_edit.'', '', '');
						
						$row = $n1->getdriver()->FetchResult();
							$id = $row["id_news"];
							$title = $n1->getdriver()->Strip($row["title_news"]);
							$type = $n1->getdriver()->Strip($row["news_type"]);
							$short_text = stripslashes($row["short_text_news"]);
							$text = stripslashes($row["text_news"]);
							$date = $n1->getdriver()->Strip(date("d-m-Y", $row["date_news"]));
							$seo_id = $row["news_seo_id"];
							$image_old = $n1->getdriver()->Strip($row["news_pict"]);
						 
						$mas_seo = $seo->SelectSeo($seo_id);
						
						// зделать запрос на виборку по переданой айдишке
						if ($type == 'новости')
						{
							$option =  '<option value="новости" selected>новости</option>
										<!--<option value="аналитика">аналитика</option>
										<option value="пресса">пресса</option>-->';
						}
						else if ($type == 'аналитика')
						{
							$option =  '<option value="новости">новости</option>
										<option value="аналитика" selected>аналитика</option>
										<option value="пресса">пресса</option>';
						}
						else if ($type == 'пресса')
						{
							$option =  '<option value="новости">новости</option>
										<option value="аналитика">аналитика</option>
										<option value="пресса" selected>пресса</option>';
						}
						else
						{
							$option =  '<option value="новости">новости</option>
										<option value="аналитика">аналитика</option>
										<option value="пресса">пресса</option>';
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
								
								var short_content = new FCKeditor(\'short_content\');
								short_content.Width = "100%";
								short_content.Height = "170";
								short_content.ToolbarSet = "Basic";
								short_content.BasePath = sBasePath;
								short_content.ReplaceTextarea();
							}
						</script>');
					
						echo "<div><h3>Редактирование новостей</h3>";
						echo('<form enctype="multipart/form-data" method="POST" action="'.$url.'">
								<table border="0" width="80%">
									<tr><td colspan="2"><input type="hidden" name="id_news" value="'.$id.'" size="50" /></td></tr>
									<tr><td align="left">название новостей:</td><td>дата:</td></tr>
									<tr><td><input type="text" name="title_news" value="'.$title.'" size="50" /></td>
										<td><input type="text" id="date_news" name="date_news" value="'.$date.'" style="width:250px" readonly="readonly" />
										<img src="../includes/img/calendar.gif" name="otbtn" width="20" height="20" align="absmiddle" id="otbtn" /></td></tr>
									<tr><td align="left" colspan="2">тип новости:*</td></tr>
									<tr><td align="left" colspan="2"><select name="news_type">
															'.$option.'
															</select></td></tr>
									<tr><td align="left" colspan="2">картинка:</td></tr>
									<tr><td align="left" colspan="2"><input type="file" name="image" value="" style="width: 100%;" /><br /><input type="hidden" name="image_old" value="'.$image_old.'" size="38" /></td></tr>
									<tr><td align="left" colspan="2">текущая картинка: <a href="../files/images/news/'.$image_old.'" target="_blank" alt="просмотр картинки для новостей">'.$image_old.'</a></td></tr>
									<tr><td align="left" colspan="2">короткое описание новостей:</td></tr>
									<tr><td colspan="2"><textarea name="short_content" cols="70" rows="7">'.$short_text.'</textarea></td></tr>
									<tr><td align="left" colspan="2">полное описание новостей:</td></tr>
									<tr><td colspan="2"><textarea name="content" cols="38" rows="7">'.$text.'</textarea></td></tr>
									<tr><td colspan="2" align="center"><br /><button type="submit" name="update_news_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								<tr><td colspan="2">'); $seo->FormSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]); echo ('</td></tr>
								</table>
							</form></div>');
							
							//--------------------------------------------------------- для календаря------------------------------------------------------------------
								echo '<script type="text/javascript" src="../includes/scripts/js/calendar_stripped.js"></script>
									<script type="text/javascript" src="../includes/scripts/js/calendar-ru_win.js"></script>
									<script type="text/javascript" src="../includes/scripts/js/calendar-setup_stripped.js"></script>
									<script type="text/javascript">
											Calendar.setup(
											{
											inputField : "date_news", // ID of the input field
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
						showNews($n1, $url);
					}
				}
				// обработка редактирования новостей
				else if (isset($_POST["update_news_form"]))
				{
					if (($_POST["id_news"] != '') && ($_POST["title_news"] != '') && ($_POST["news_type"] != '') && ($_POST["content"] != '') && ($_POST["short_content"] != '') && ($_POST["date_news"] != ''))
					{
						$id = $_POST["id_news"];
						$title = $_POST["title_news"];
						$short_text = $_POST["short_content"];
						$text = $_POST["content"];
						$date = $_POST["date_news"];
						$type = $_POST["news_type"];
						
						
						$title = $n1->getdriver()->PutContent($title);
						$type = $n1->getdriver()->PutContent($type);
						$short_text = $n1->getdriver()->PutContent($short_text);
						$text = $n1->getdriver()->PutContent($text);
						$date = $n1->getdriver()->PutContent($date);
						
						
						
						if (!empty($_FILES["image"]["name"]))
						{
							// загрузка файла на сайт
							$uploaddir = '../files/images/news/';     
							// будем сохранять загружаемые 
							// файлы в эту директорию
							$destination = $uploaddir;
							//$name = $_FILES['image']['name'];
							
							$extperms = array('gif','jpg','png');
							$ext = strtolower(substr($_FILES["image"]["name"], -3, 3));
							
							$name = 'news-pict-'.time().'.'.$ext;
							$destination .= $name;
							if(in_array($ext, $extperms))
							{
								@move_uploaded_file($_FILES['image']['tmp_name'], $destination);
								$image = "'".$name."'";
								
								$n1->SelectNews('t_news', 'id_news='.$id.'', '', '');
								$row = $n1->getdriver()->FetchResult();
								$pict = $n1->getdriver()->Strip($row["news_pict"]);
								if ($pict != '')
								{
									$file_b = '../files/images/news/'.$pict;
									if (file_exists($file_b)) { @unlink($file_b); }
								}
							}
							else
							{
								echo "<br /><div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								showNews($n1, $url);
								break;
							}
						}
						else $image = "'".$_POST['image_old']."'";
						
						$mas_seo[0] = $_POST['seo_id'];
						$mas_seo[1] = $_POST['seo_title'];
						$mas_seo[2] = $_POST['seo_description'];
						$mas_seo[3] = $_POST['seo_keywords'];
						$res = $seo->UpdateSeo($mas_seo[0], $mas_seo[1], $mas_seo[2], $mas_seo[3]);
						if ($res != 0)
						{
							$updt = array("'".$title."'", "'".$short_text."'", "'".$text."'", "".$date."", "'".$type."'", $mas_seo[0], $image);
							$n1->UpdateNews('t_news', $updt, 'id_news='.$id.'');
							showNews($n1, $url);
						}
						else
						{
							echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
							showNews($n1, $url);
						}
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
						showNews($n1, $url);
					}
				}
				// показ новостей
				else{ showNews($n1, $url); }
				break;
				
		case 1:
				//будем привязывать к лист модулю пункты меню которые будем привязивать, пункты меню выводяться в таблице с чекбоксами!
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">список новостей</a></li>
			                    <li id="active"><a href="%s&&menu_pop=1">настройки</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				// здесь будет список пунктов меню к каким будем привязывать, еще надо их статус			
				if (isset($_POST["build_news_form"]))
				{
					if ($_POST["menu_id"] != null)
					{
						$mm_id = implode(";", $_POST["menu_id"]);
						$mm_id = array("'".$mm_id."'");
						$modlist->getdriver()->Update('list_mod', 'mm_id', $mm_id, "src_list_mod='news'");
						
						$kol_news = $n1->getdriver()->PutContent($_POST["kol_news_panel"]).";".$n1->getdriver()->PutContent($_POST["kol_news_site"]);
						
						FileSave('../modules/news/news_config.php', $kol_news);
						
						showBuildNews($menu, $modlist, $url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали меню для привязки новостей!</div>";
						showBuildNews($menu, $modlist, $url);
					}
				}
				else if (isset($_POST["debuild_news_form"]))
				{
						$mm_id = '';
						$mm_id = array("'".$mm_id."'");
						//$mm_id = "'".$mm_id."'";
						$modlist->getdriver()->Update('list_mod', 'mm_id', $mm_id, "src_list_mod='news'");
						
						//$kol_news_panel = 0;
						//$kol_news_site = 0;
						$kol_news = $_POST["kol_news_panel"].";".$_POST["kol_news_site"];
						
						FileSave('../modules/news/news_config.php', $kol_news);
						
						showBuildNews($menu, $modlist, $url);
				}
				else
				{
					showBuildNews($menu, $modlist, $url);
				}
				
				break;
		default:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">список новостей</a></li>
			                    <li><a href="%s&&menu_pop=1">настройки</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				echo "Воспользуйтесь пунктом меню!";
	}
?>