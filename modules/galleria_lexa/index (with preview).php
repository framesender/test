<?
	include_once("../modules/galleria/cl_galleria.php"); //клас для роботи с контент
	include_once("../modules/menu/cl_menu.php"); // клас для роботи с меню сайта
	include_once("../modules/menu/cl_popmenu.php"); // клас для роботи с подменю сайта
	include '../modules/galleria/myresize.php';
	include_once("../core/cl_navigation.php");
	
	require('../includes/imgresize.php');

	$galleria = new cl_galleria();
	$menu = new cl_menu();
	$popmenu = new cl_popmenu();
	$modlist = new cl_list_modules();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=galleria&&titlem=Галерея"; // не изменять параметры
	$url2 = "main.php?namem=menu&&titlem=Галерея&&menu_pop=1"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения галереи
	function showData($galleria, $menu, $popmenu, $url)
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
                 	
		// вставка для отображения информации про галерею
		$galleria->getdriver()->Select('t_galleria', '', '', '', '', '', '', '');
		$count = $galleria->getdriver()->Count();
		
		$galleria->getdriver()->Select('t_galleria', '', '', '', 'gall_sort', 'ASC', $p, '20');
		if ($count != 0)
			{	
				echo ('<div style="margin: 10px 0 10px 0;">
						<form id="group_1" method="POST" action="'.$url.'" name="formgalleria">
								<table class="tablesorter" id="example">
									<thead>
									  <tr id="t_hed" align="center">
									  <th>#</td>
									  <th>#</td>
									  <th>Картинка</th>
									  <th width="40%">Описание</th>
									  <th>Показывать в разделе галереи</th>
									  <th>Показывать в подразделе галереи</th>
									  <th colspan="2">Управление</th>
									  </tr>
									</thead>
									<tbody>');
					while ($row = $galleria->getdriver()->FetchResult())
					{
						$id = $row["gall_menu_id"];
						$idpop = $row["gall_popmenu_id"];
						$gall_sort = $row["gall_sort"];
						$img_s = $galleria->getdriver()->Strip($row["gall_img_s"]);
						$img_b = $galleria->getdriver()->Strip($row["gall_img_b"]);
						$description = $galleria->getdriver()->Strip($row["gall_description"]);
						if (empty($img_s)) $img_s = '';
						else $img_s = '<a href="../images/galleria/'.$img_b.'" target="_blank"><img src="../images/galleria/'.$img_s.'" title="увеличить" /></a>';
						
						//название меню, под которое привязываем
						$menu->SelectMenu('t_menu', 'menu_id='.$id, '', '');
						if (($menu->getdriver()->Count()) > 0)
						{
							$row_menu = $menu->getdriver()->FetchResult();
							$row_m = $row_menu["menu_name"];
						}
						else $row_m = "-";
						
						//название подменю, под которое привязываем
						$popmenu->SelectMenu('t_popmenu', 'popmenu_id='.$idpop, '', '');
						if (($popmenu->getdriver()->Count()) > 0)
						{
							$row_popmenu = $popmenu->getdriver()->FetchResult();
							$row_popm = $row_popmenu["popmenu_name"];
						}
						else $row_popm = "-";
						
						echo ('<tr align="center">
								  <td><span style="display: none;">'.$row["gall_id"].'</span><input type="checkbox" name="gall_id[]" value="'.$row["gall_id"].'" /></td>
								  <td><center>'.$gall_sort.'</center></td>
								  <td><center>'.$img_s.'</center></td>
								  <td width="40%">'.$description.'</td>
								  <td>'.$row_m.'</td>
								  <td>'.$row_popm.'</td>
								  <td colspan="2"><a href="'.$url.'&&gall_id='.$row["gall_id"].'&&update_data=1">редактировать</a> | <a href="'.$url.'&&gall_id[]='.$row["gall_id"].'&&del_data=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					echo ('</tbody>
							<tfoot>
							<tr>
								<td	colspan="6" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td colspan="1" align="center"><button type="submit" name="delete_data" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formgalleria.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
												<button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="7" align="right">
								Всего записей: '.$count.' </td>
							</tr>
							<tr>
            					<td colspan="7">'.$navigator->links($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,$count).'</td>
        					 </tr>
							</tfoot>
						</table>
						</form></div>');
			}
			else
			{
				echo ('<div style="margin: 10px 0 10px 0;">
						<form method="POST" action="'.$url.'">
							<table class="tablesorter" id="example">
								<thead>
									 <tr id="t_hed" align="center">
									  <th>#</td>
									  <th>Картинка</th>
									  <th>Описание</th>
									  <th>Показывать в меню</th>
									  <th>Показывать в подменю</th>
									  <th colspan = "2">Управление</th>
									  </tr>
								</thead>
							<tfoot>	
							<tr>
								<td colspan="6" align="center"><h3>Извините, нет картинок для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="7" align="right">Всего записей: 0 </td>
							</tr>
							</tfoot>
						</table>
						</form></div>');
			}
	}	// --------------end show галереи --------------------------
	
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
	
	function showBuild($url2)
	{
		$kol = FileRead('../modules/galleria/galleria_config.php');
		echo "<h3>Настройка галереи</h3>";
				printf('<form id="group_1" method="POST" action="%s">
						<table class="tablesorter">
							<tr><td>Сколько картинок показывать на главной странице галерея:</td></tr>
							<tr><td><input type="text" name="kol1" size="50" value="%s" /> (количество)</td></tr>
							<tr><td>Сколько картинок показывать на страницах галереи:</td></tr>
							<tr><td><input type="text" name="kol2" size="50" value="%s" /> (количество)</td></tr>
							<tr><td><button type="submit" name="build_form"><img src="../includes/img/it/apply.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
													<button type="submit" name="debuild_form"><img src="../includes/img/it/cancel.gif" alt="" /></button></td></tr>
						</table>', $url, $kol[0], $kol[1]);
	}
	
	
	// -------------------------------- /проверка к каким пунктам главного меню привязан модуль для показа необходимого контента ------------------------------
	switch ($_GET["menu_pop"])
	{
		case 0:
				printf('<div id="menu">
			    			<ul>
			                    <li id="active"><a href="%s">галерея</a></li>
								<li><a href="%s&&menu_pop=1">настройки</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				// форма для добавления
				if (isset($_POST["add_data"]))
				{
					//выбор пункта меню
					$option = '<option value="none">- выберите меню -</option>';
					$menu->SelectMenu('t_menu', 'menu_type = 4', '', '');
					while($row = $menu->getdriver()->FetchResult())
					{
						$option .= '<option value="'.$row["menu_id"].'">'.$row["menu_name"].'</option>';
					}
					
					echo ('<form enctype="multipart/form-data" method="POST" action="'.$url.'" id="data">
								<table border="0">
									<tr><td colspan="1"><h3>Добавление картинок в галерею</h3></td><td></td></tr>');
					echo ('<tr><td align="left" colspan="1">привязать к пункту меню:</td><td align="left" colspan="1">привязать к подпункту меню:</td></tr>
									<tr><td>
										<select name="gall_menu_id" onChange="SelectPopMenu(); return false">
											'.$option.'
						                </select>
									</td>
									<td>
										<div id="select_popresult">
											<select name="gall_popmenu_id">
												<option value="none">- выберите подменю -</option>
							                </select>
										</div>
									</td></tr>
									<tr><td colspan="2"><input id="col" name="col" value="0" type="hidden" />
											<div><a href="javascript:{}" onclick="add()">Добавить картинку</a><br /></div>
											<div id="100">&nbsp;</div></td></tr>
									<tr><td align="center" colspan="2"><br /><button type="submit" name="add_data_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
							</form>');
				}
				// обработка добавления
				else if (isset($_POST["add_data_form"]))
				{
					$col = $_POST['col'];
					$description = $_POST['description'];
                    $sizex = $_POST['sizex'];
					$true = false;
			
					
					for($i=0; $i<$col; $i++)
					{
						if (($_FILES['image_b']['name'][$i]) == '')
						{ $true = false; break; }
						else $true = true;
						/*if (($description[$i]) == '')
						{ $true = false; break; }
						else $true = true;*/
					}
					
					if ($true == true)
					{
						$mm = $_POST['gall_menu_id'];
						$popmm = $_POST['gall_popmenu_id'];
						//$popmm = 0;
						$mas_sort = $_POST['gallery_sort'];
						
						//к названию - код раздела
						$code = '';
						if (isset($popmm)) $code = $mm.'_'.$popmm.'_';
						else $code = $mm.'_';
						
						
						$galleria->getdriver()->ExecQuery("SELECT MAX(gall_id) FROM t_galleria");
						$max_gall_id = $galleria->getdriver()->FetchResult();
						for($i=0; $i<$col; $i++)
						{
							if (empty($max_gall_id[0])) $max_gall_id[0] = 1;
							else $max_gall_id[0] = $max_gall_id[0] + 1;
							// загрузка файла на сайт
							$uploaddir = '../images/galleria/';
                            /////////////
                            
                            
                            if ($sizex[$i]) $new_size = $sizex[$i]; else $new_size = 500;
                            
                            
                            /////////////
						
							$extperms = array('gif','jpg','png');
							$ext_b = strtolower(substr($_FILES["image_b"]["name"][$i], -3, 3));
							
							$destination_b = $uploaddir.'pict_big_'.$max_gall_id[0].'.'.$ext_b;
							$destination_t = $uploaddir.'thumb_big_'.$max_gall_id[0].'.'.$ext_b;
							//название фото
							$name_b1 = 'pict_big_'.$max_gall_id[0].'.'.$ext_b;
							$name_b = $code.'photo_'.$max_gall_id[0].'.jpg';
							$name_s = $code.'thumb_photo_'.$max_gall_id[0].'.jpg';
                            if ($sizex[$i]) $new_size = $sizex[$i]; else $new_size = 500;
                            
                            
							
							if(in_array($ext_b, $extperms))
							{    
								@move_uploaded_file($_FILES['image_b']['tmp_name'][$i], $destination_b);
                                if (empty($_FILES['image_t']['tmp_name'][$i])) $destination_t = $destination_b;
                                     else @move_uploaded_file($_FILES['image_t']['tmp_name'][$i], $destination_t);
								//$image_b = "'".$name_b."'";
								//var_dump($name_b); exit;
                                MyResize($destination_b, "../images/galleria/".$name_b, $new_size);
                                
                                //$image->new_image_name = $name_b;
                                //$image->save_folder = '../images/galleria/';
                                //$process = $image->resize();
                                //if($process['result'] && $image->save_folder)
//                                    {
//                                    echo '<div class="sms_succses">Фото ('.$process['new_file_path'].') сохранено.</div>';
//                                    } else echo '<div class="sms_error">Фото не добавлено!</div>';
//                                $image->new_image_name = $name_s;
//                                $image->new_width = 120;
//                                $image->new_height = 120;
//                                $process = $image->resize();
//                                if($process['result'] && $image->save_folder)
//                                    {
//                                    echo '<div class="sms_succses">Эскиз ('.$process['new_file_path'].') сохранен.</div>';
//                                    } else echo '<div class="sms_error">Эскиз не добавлен!</div>';
                                MyResize($destination_t, "../images/galleria/".$name_s, 120);
                                
                                $file_s1 = '../images/galleria/'.$name_b1;
								if (file_exists($file_s1)) @unlink($file_s1);
                                $image_b = "'".$name_b."'"; $image_s = "'".$name_s."'";
                                /*
								$image_b = "'".$name_b."'";
								$size = getimagesize('../images/galleria/'.$name_b1);
								if ($size[0] > $size[1]) img_resize('../images/galleria/'.$name_b1, '../images/galleria/'.$name_b, 640, 480);
								else if ($size[0] < $size[1]) img_resize('../images/galleria/'.$name_b1, '../images/galleria/'.$name_b, 480, 640);
								
								
								$size1 = getimagesize('../images/galleria/'.$name_b);
								//img_resize('../images/galleria/'.$name_b, '../images/galleria/'.$name_s, $size1[0]/6, $size1[1]/6);
								img_resize('../images/galleria/'.$name_b, '../images/galleria/'.$name_s, 120, 120);
								
								  */
                                
                                
							}
							else
							{
								echo "<div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								//showData($galleria, $menu, $popmenu, $url);
//								break;
							}
							
							$gall_sort = 100;
							if ($mas_sort[$i] != '') $gall_sort = $galleria->getdriver()->PutContent($mas_sort[$i]);
							$insert = $image_s.", ".$image_b.", '".$galleria->getdriver()->PutContent($description[$i])."', ".$mm.", ".$popmm.", ".$gall_sort;
							$galleria->getdriver()->Insert('t_galleria', 'gall_img_s, gall_img_b, gall_description, gall_menu_id, gall_popmenu_id, gall_sort', $insert);
							
							$k = $galleria->getdriver()->Result();
							if ($k == 0) echo "<div class='sms_error'>Запрос на добавление не выполнен</div>";
							else echo "<div class='sms_succses'>Картинка <span class='title_name'>".$image_b."</span> успешно добавлена в галерею</div>";
						}
						showData($galleria, $menu, $popmenu, $url);
					} else {
						echo "<div class='sms_error'>Ошибка при вводе даных. Запрос на добавление не выполнен</div>";
						showData($galleria, $menu, $popmenu, $url);
					}
				}
				// обработка удаления выбраных
				else if (isset($_POST["delete_data"]))
				{
					if ($_POST["gall_id"] != null)
					{
						$delete = $_POST["gall_id"];
						for($i=0; $i<count($delete); $i++)
						{
							$galleria->getdriver()->Select('t_galleria', '', 'gall_id='.$delete[$i], '', '', '', '', '');
							$row = $galleria->getdriver()->FetchResult();
							if ($row['gall_img_s'] != '')
							{
								$file_s = '../images/galleria/'.$row['gall_img_s'];
								if (file_exists($file_s)) { @unlink($file_s); echo "<div class='sms_succses'>Файл ".$row['gall_img_s']." успешно удален</div>"; }
								else echo "<div class='sms_error'>Файл ".$row['gall_img_s']." не найден</div>";
							}
							if ($row['gall_img_b'] != '')
							{
								$file_b = '../images/galleria/'.$row['gall_img_b'];
								if (file_exists($file_b)) { @unlink($file_b); echo "<div class='sms_succses'>Файл ".$row['gall_img_b']." успешно удален</div>"; }
								else echo "<div class='sms_error'>Файл ".$row['gall_img_b']." не найден</div>";
							}
						
								$galleria->getdriver()->Delete('t_galleria', 'gall_id='.$delete[$i]);
								$k = $galleria->getdriver()->Result();
								if ($k == 0) echo "<div class='sms_error'>Запрос на удаление не выполнен</div>";
									else echo "<div class='sms_succses'>Картинка успешно удалена</div>";
						}
						showData($galleria, $menu, $popmenu, $url);
						
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали содержимое для удаления</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showData($galleria, $menu, $popmenu, $url);
					}
				}
				// форма для удаления одной
				else if (isset($_GET["del_data"]))
				{
					if (($_GET["gall_id"] != null) && ($_GET["del_data"]==1))
					{
						$delete = $_GET["gall_id"];
						$galleria->getdriver()->Select('t_galleria', '', 'gall_id='.$delete[0], '', '', '', '', '');
						$row = $galleria->getdriver()->FetchResult();
						if ($row['gall_img_s'] != '')
						{
							$file_s = '../images/galleria/'.$row['gall_img_s'];
							if (file_exists($file_s)) { @unlink($file_s); echo "<div class='sms_succses'>Файл ".$row['gall_img_s']." успешно удален</div>"; }
							else echo "<div class='sms_error'>Файл ".$row['gall_img_s']." не найден</div>";
						}
						if ($row['gall_img_b'] != '')
						{
							$file_b = '../images/galleria/'.$row['gall_img_b'];
							if (file_exists($file_b)) { @unlink($file_b); echo "<div class='sms_succses'>Файл ".$row['gall_img_b']." успешно удален</div>"; }
							else echo "<div class='sms_error'>Файл ".$row['gall_img_b']." не найден</div>";
						}
					
							$galleria->getdriver()->Delete('t_galleria', 'gall_id='.$delete[0]);
							$k = $galleria->getdriver()->Result();
							if ($k == 0) echo "<div class='sms_error'>Запрос на удаление не выполнен</div>";
								else echo "<div class='sms_succses'>Картинка успешно удалена</div>";
							showData($galleria, $menu, $popmenu, $url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали картинки для удаления</div>";
						showData($galleria, $menu, $popmenu, $url);
					}
				}
				// форма для редактирования
				else if (isset($_GET["update_data"]))
				{
					if (($_GET["gall_id"] != null) && ($_GET["update_data"]==1))
					{
						
						$id_edit = $_GET["gall_id"];
						$galleria->getdriver()->Select('t_galleria', '', 'gall_id='.$id_edit, '', '', '', '', '');
						$row = $galleria->getdriver()->FetchResult();
							$id = $row["gall_id"];
							$description = stripslashes($row["gall_description"]);
							$img_s =  $row["gall_img_s"];
							$img_b =  $row["gall_img_b"];
							$mm = $row["gall_menu_id"];
							$popmm = $row["gall_popmenu_id"];
							$gall_sort = $row["gall_sort"];
						// зделать запрос на виборку по переданой айдишке
						
						//выбор меню
						$option = '<option value="none">- выберите меню -</option>';
						$menu->SelectMenu('t_menu', 'menu_type = 4', '', '');
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
						echo "";
						echo ('<form enctype="multipart/form-data" method="POST" action="'.$url.'" id="data">
								<table border="0">
									<tr><td colspan="1"><h3>Редактирование картинки</h3></td><td></td></tr>
									<tr><td align="left" colspan="1">привязать к пункту меню:</td><td align="left" colspan="1">привязать к подпункту меню:</td></tr>
									<tr><td>
										<select name="gall_menu_id" onChange="SelectPopMenu(); return false">
											'.$option.'
						                </select>
									</td>
									<td>
										<div id="select_popresult">
											<select name="gall_popmenu_id">
												<option value="0">- выберите подменю -</option>
												'.$option1.'
							                </select>
										</div>
									</td></tr>
									<tr><td colspan="2"><input type="hidden" name="gall_id" value="'.$id.'" size="50" /></td></tr>
									<tr><td colspan="2" align="left" valign="top">описание:<br />
											<textarea name="description" cols="38" rows="7">'.$description.'</textarea>
									</td></tr>
									<tr><td colspan="2" align="left">картинка (для просмотра)<br /><input type="file" name="image_b" value="" size="38" /><br />
                                    <input type="file" name="image_t" value="" size="38" /><br />
											<input type="hidden" name="image_b_old" value="'.$img_b.'" size="38" />
											сортировка<br /><input type="text" name="gallery_sort" value="'.$gall_sort.'" size="10" />
                                            <br>Размер: <input type="text" name="sizex" size="7" value = "400">
											<br /><a href="../images/galleria/'.$img_s.'" target="_blank" alt="просмотр картинки">текущая картинка (для просмотра)</a></span>
											<br /><input type="hidden" name="image_s_old" value="'.$img_s.'" size="38" /></td></tr>
											<tr><td colspan="2" align="center"><br /><button type="submit" name="update_data_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									</table>
							</form>');
					}
					else
					{
						echo "Ошибка редактирования";
						showData($galleria, $menu, $popmenu, $url);
					}
				}
				// обработка редактирования
				else if (isset($_POST["update_data_form"]))
				{
					if ($_POST['image_b_old'])
					{
						$gall_id = $_POST['gall_id'];
                        
						$description = $galleria->getdriver()->PutContent($_POST['description']);
						$mm = $_POST['gall_menu_id'];
						$popmm = $_POST['gall_popmenu_id'];
						//$popmm = 0;
				        $sizex = $_POST['sizex'];
                        
                        if ($sizex[$i]) $new_size = $sizex[$i]; else $new_size = 500;
                        

                        		
						$extperms = array('gif','jpg','png');
						
						if ((!empty($_FILES["image_b"]["name"])))
						{
							// загрузка файла на сайт
							//$uploaddir = '../images/galleria/';     
							// будем сохранять загружаемые 
							// файлы в эту директорию
							$ext_b = strtolower(substr($_FILES["image_b"]["name"], -3, 3));
							$destination_b = $uploaddir.$_POST['image_b_old'];
							
							$name_b = $_POST['image_b_old'];
							
							if(in_array($ext_b, $extperms))
							{
								$file_b = '../images/galleria/'.$_POST['image_b_old'];
								if (file_exists($file_b)) @unlink($file_b);
								
								
								@move_uploaded_file($_FILES['image_b']['tmp_name'], $destination_b);
                                
								
                                MyResize($destination_b, $file_b, $new_size);
                                
        
                                
                                $image_b = "'".$name_b."'"; 
							}
							else
							{
								echo "<div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								showData($galleria, $menu, $popmenu, $url);
								break;
							}
						}
						else { $image_b = "'".$_POST['image_b_old']."'";  }
						
                        if ((!empty($_FILES["image_t"]["name"]))){
                            $ext_b = strtolower(substr($_FILES["image_t"]["name"], -3, 3));
                            $destination_t = $uploaddir.$_POST['image_s_old'];
                            $name_s = $_POST['image_s_old'];
                            if(in_array($ext_b, $extperms)){
							     
                                $file_s = '../images/galleria/'.$_POST['image_s_old'];
								if (file_exists($file_s)) @unlink($file_s);
                                @move_uploaded_file($_FILES['image_t']['tmp_name'], $destination_t);
                                MyResize($destination_t, $file_s, 120);
                                 
                                $file_s1 = '../images/galleria/'.$name_b1;
								if (file_exists($file_s1)) @unlink($file_s1);
                                $image_s = "'".$name_s."'"; 
							} else
							{
								echo "<div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								showData($galleria, $menu, $popmenu, $url);
								break;
							}
                            
                        } else {  $image_s = "'".$_POST['image_s_old']."'"; } 
                        
                        
						$gall_sort = 100;
						if ($_POST['gallery_sort'] != '') $gall_sort = $galleria->getdriver()->PutContent($_POST['gallery_sort']);
						$update = array($image_s, $image_b, "'".$description."'", $mm, $popmm, $gall_sort);
						$galleria->getdriver()->Update('t_galleria', 'gall_img_s, gall_img_b, gall_description, gall_menu_id, gall_popmenu_id, gall_sort', $update, 'gall_id='.$gall_id);
						$k = $galleria->getdriver()->Result();
						if ($k == 0) echo "<div class='sms_error'>Запрос на редактирование не выполнен</div>";
						else echo "<div class='sms_succses'>Картинка/описание успешно изменёна</div>";
						showData($galleria, $menu, $popmenu, $url);
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен</div>";
						showData($galleria, $menu, $popmenu, $url);
					}
				}
				// показ
				else{ showData($galleria, $menu, $popmenu, $url); }
				break;
		case 1:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">галерея</a></li>
			                    <li id="active"><a href="%s&&menu_pop=1">настройки</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);		
				if (isset($_POST["build_form"]))
				{
					if (($_POST["kol1"] != 0) and ($_POST["kol2"] != 0))
					{						
						$kol = $galleria->getdriver()->PutContent($_POST["kol1"]).";".$galleria->getdriver()->PutContent($_POST["kol2"]);
						
						FileSave ('../modules/galleria/galleria_config.php', $kol);
						
						showBuild($url2);
					}
					else
					{
						echo "<div class='sms_error'>Нужно задать количество показуемых картинок</div>";
						showBuild($url2);
					}
				}
				else if (isset($_POST["debuild_form"]))
				{
					$kol = '0;0';
						
					FileSave ('../modules/galleria/galleria_config.php', $kol);
						
					showBuild($url2);
				}
				else
				{
					showBuild($url2);
				}
				
				break;	
		default:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s">галерея</a></li>
								<li><a href="%s&&menu_pop=1">настройки</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				echo "Воспользуйтесь пунктом меню";
	}
?>
<script type="text/javascript">
function add() {
  var id = document.getElementById("col").value;
  id++;
  $("div[id=100]").append('<div id="div-'+id+'"><table style="border: 1px solid #ffffff; padding: 10px; margin-top: 10px;"><tr><td>описание<br /></td><td>картинка (для просмотра)*<br />      <textarea name="description[]" cols="38" rows="7"></textarea><br><br>      <input type="file" name="image_b[]" value="" size="38" /><br>эскиз<br><input type="file" name="image_t[]" value="" size="38" /><br />сортировка<br /><input type="text" name="gallery_sort[]" value="" size="10" /><br><br>размер<br> <input type="text" name="sizex[]" size="7" value = "400"></td></tr></table><span id="cell"><a href="javascript:{}" onclick="removeInput(\'' + id + '\')">Удалить</a></span></div>');
  document.getElementById("col").value = id;
}

function removeInput(id) {
	$("#div-" + id).remove();
	var col = document.getElementById("col").value - 1;
	document.getElementById("col").value = col;
}
</script>
<script type="text/javascript">
function SelectPopMenu() {
  var str = $("#data").serialize();
  $.post("../modules/galleria/select_popmenu.php", str, function(data) {
    $("#select_popresult").html(data);
  });
}
</script>