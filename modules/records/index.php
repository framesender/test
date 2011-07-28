<?
	include_once("../modules/records/cl_records.php"); //клас для роботи с контент
	include_once("../modules/menu/cl_menu.php"); // клас для роботи с меню сайта
	include_once("../modules/menu/cl_popmenu.php"); // клас для роботи с подменю сайта
	
	include_once("../core/cl_navigation.php");
	
	require('../includes/imgresize.php');

	$rec = new cl_records();
	$menu = new cl_menu();
	$popmenu = new cl_popmenu();
	$modlist = new cl_list_modules();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=records&&titlem=Записи"; // не изменять параметры
	$url2 = "main.php?namem=records&&titlem=Записи&&menu_pop=1"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения галереи
    
    
    
	function showData($rec, $url)
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
                 	
		// вставка для отображения информации про Записи
		$rec->getdriver()->Select('t_record', '', 'type=1', '', '', '', '', '');
		$count = $rec->getdriver()->Count();
		
		$rec->getdriver()->Select('t_record', '', 'type=1', '', 'id', 'ASC', $p, '20');
		if ($count != 0)
			{	
				echo ('<div style="margin: 10px 0 10px 0;">
						<form id="group_1" method="POST" action="'.$url.'" name="formgalleria">
								<table class="tablesorter" id="example">
									<thead>
									  <tr id="t_hed" align="center">
									  <th>#</th>
									  <th>#</th>
                                      <th>Картинка</th>
                                      <th>Название</th>
                                      <th colspan="2">Управление</th>
									  </tr>
									</thead>
									<tbody>');
					while ($row = $rec->getdriver()->FetchResult())
					{
						$id = $row["id"];
						$img_s = $rec->getdriver()->Strip($row["img"]);						
						$nam = $rec->getdriver()->Strip($row["name"]);                        
						$mas_nam = explode('^', $nam);
											
						echo ('<tr align="center">
								  <td><span style="display: none;">'.$row["id"].'</span><input type="checkbox" name="id[]" value="'.$row["id"].'" /></td>
								  <td><center>'.$id.'</center></td>
                                  <td><center><img src="../files/images/records/'.$img_s.'"></center></td>
                                  <td>'.$mas_nam[0].'<br>'.$mas_nam[1].'</td>
								  <td colspan="2"><a href="'.$url.'&id='.$row["id"].'&update_data=1">редактировать</a> | <a href="'.$url.'&id[]='.$row["id"].'&del_data=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					echo ('</tbody>
							<tfoot>
							<tr>
								<td	colspan="5" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td colspan="1" align="center"><button type="submit" name="delete_data" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formgalleria.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
												<button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">
								Всего записей: '.$count.' </td>
							</tr>
							<tr>
            					<td colspan="6">'.$navigator->links($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,$count).'</td>
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
									  <th>#</th>
									  <th>#</th>
                                      
                                      <th>Название</th>									  
									  <th colspan="2">Управление</th>
									  </tr>
								</thead>
							<tfoot>	
							<tr>
								<td colspan="5" align="center"><h3>Извините, нет записей для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">Всего записей: 0 </td>
							</tr>
							</tfoot>
						</table>
						</form></div>');
			} 
	}	// --------------end show галереи --------------------------
	
    function showAudio($rec, $url2)
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
                 	
		// вставка для отображения информации про Записи
		$rec->getdriver()->Select('t_record', '', 'type=2', '', '', '', '', '');
		$count = $rec->getdriver()->Count();
		
		$rec->getdriver()->Select('t_record', '', 'type=2', '', 'id', 'ASC', $p, '20');
		if ($count != 0)
			{	
				echo ('<div style="margin: 10px 0 10px 0;">
						<form id="group_1" method="POST" action="'.$url2.'" name="formgalleria">
								<table class="tablesorter" id="example">
									<thead>
									  <tr id="t_hed" align="center">
									  <th>#</th>
									  <th>#</th>
                                      
                                      <th>Название</th>
                                      <th colspan="3">Управление</th>
									  </tr>
									</thead>
									<tbody>');
					while ($row = $rec->getdriver()->FetchResult())
					{
						$id = $row["id"];												
						$nam = $rec->getdriver()->Strip($row["name"]);                        
						$mas_nam = explode('^', $nam);
											
						echo ('<tr align="center">
								  <td><span style="display: none;">'.$row["id"].'</span><input type="checkbox" name="id[]" value="'.$row["id"].'" /></td>
								  <td><center>'.$id.'</center></td>                                  
                                  <td>'.$mas_nam[0].'<br>'.$mas_nam[1].'</td>
								  <td colspan="3"><a href="'.$url2.'&id='.$row["id"].'&update_data=1">редактировать</a> | <a href="'.$url2.'&id[]='.$row["id"].'&del_data=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					echo ('</tbody>
							<tfoot>
							<tr>
								<td	colspan="4" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td colspan="1" align="center"><button type="submit" name="delete_data" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formgalleria.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
												<button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="5" align="right">
								Всего записей: '.$count.' </td>
							</tr>
							<tr>
            					<td colspan="5">'.$navigator->links($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,$count).'</td>
        					 </tr>
							</tfoot>
						</table>
						</form></div>');
			}
			else
			{    echo $url2;
				echo ('<div style="margin: 10px 0 10px 0;">
						<form method="POST" action="'.$url2.'">
							<table class="tablesorter" id="example">
								<thead>
									 
									  <tr id="t_hed" align="center">
									  <th>#</th>
									  <th>#</th>                                      
                                      <th>Название</th>									  
									  <th colspan="3">Управление</th>
									  </tr>
								</thead>
							<tfoot>	
							<tr>
								<td colspan="5" align="center"><h3>Извините, нет записей для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">Всего записей: 0 </td>
							</tr>
							</tfoot>
						</table>
						</form></div>');
			} 
	}
    
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
			                    <li id="active"><a href="%s">Видео</a></li>
								<li><a href="%s&&menu_pop=1">Аудио</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				// форма для добавления
				if (isset($_POST["add_data"]))
				{  
					//add video  
					echo ('<form enctype="multipart/form-data" method="POST" action="'.$url.'" id="data">
								<table border="0">
									<tr><td colspan="1"><h3>Добавление видео</h3></td><td></td></tr>');
                                    
                                    echo '<tr><td colspan="2">
                                    <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                      <tr>
                                        <td>Название* :</td>
                                        <td><input type="text" name="title" style="width:320px;"></td>
                                      </tr>
                                      <tr>
                                        <td>Автор:</td>
                                        <td><input type="text" name="auth" style="width:320px;"></td>
                                      </tr>
                                      <tr>
                                        <td>Ссылка* :</td>
                                        <td><input type="text" name="link" style="width:320px;"></td>
                                      </tr>
                                      <tr>
                                        <td>Эскиз* :</td>
                                        <td><input type="file" name="img" style="width:320px;"></td>
                                      </tr>
                                      <tr>
                                        <td>Сортировка :</td>
                                        <td><input type="text" name="sort" style="width:35px;" value="100"></td>
                                      </tr>
                                      <tr>
                                        <td>В блоке новостей :</td>
                                        <td><input type="checkbox" name="left" value="1"></td>
                                      </tr>
                                    </table>
                                    </td></tr>
                                    ';
					echo'
									<tr><td align="center" colspan="2"><br /><button type="submit" name="add_data_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
							</form>';
				}
				// обработка добавления
				else if (isset($_POST["add_data_form"]))
				{
				    
				    $post = $_POST;
                    
                   //var_dump($_POST); exit;
                    
                    $v_name = $post['title']; 
                    echo $vlink = $_POST['link']; 
                    
                    $pattern = '/.*width="(\d{0,})"/';
                    preg_match($pattern, $vlink, $mas);
                    
                    $w = $mas[1];
                    $v_link = str_replace($w,'306',$vlink);
                    
                    $pattern = '/.*height="(\d{0,})"/';
                    preg_match($pattern, $v_link, $mas);
                    
                    $h = $mas[1]; 
                    $v_link = str_replace($h,'255',$v_link);
                    
                    $v_auth = $post['auth'];
                    $v_sort = $post['sort']; if ($_POST['left']) $v_left = 1; else $v_left = 0; 
                    
                    if ((!$_FILES['img']['name']) or (!$v_name) or (!$v_link))
                            $true = false; else $true = true;
                    	
					if ($true == true)
					{
						
						$rec->getdriver()->ExecQuery("SELECT MAX(id) FROM t_record WHERE type=1");
						$max_id = $rec->getdriver()->FetchResult();
						
							if (empty($max_id[0])) $max_id[0] = 1;
							else $max_id[0] = $max_id[0] + 1;
							// загрузка файла на сайт
							$uploaddir = '../files/images/records/';
						
							$extperms = array('gif','jpg','png');
							$ext_b = strtolower(substr($_FILES["img"]["name"], -3, 3));
							
							$destination_b = $uploaddir.'picts_'.$max_id[0].'.'.$ext_b;
							
							//название фото
							$name_b1 = 'picts_'.$max_id[0].'.'.$ext_b;
							$name_b = 'vd'.$max_id[0].'.'.$ext_b;
							
							
							if(in_array($ext_b, $extperms))
							{
 
                                @move_uploaded_file($_FILES['img']['tmp_name'], $destination_b);
								
								$image = "'".$name_b."'";
								$size = getimagesize('../files/images/records/'.$name_b1);
								if ($size[0] > $size[1]) img_resize('../files/images/records/'.$name_b1, '../files/images/records/'.$name_b, 120, 120);
								else if ($size[0] < $size[1]) img_resize('../files/images/records/'.$name_b1, '../files/images/records/'.$name_b, 120, 120);
																
								$file_s1 = '../files/images/records/'.$name_b1;
								if (file_exists($file_s1)) @unlink($file_s1);
							}
							else
							{
								echo "<div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								showData($rec, $url);
								break;
							}
                            
							$insert = "'".$v_name."^".$v_auth."', ".$image.", '".$v_link."', 1, ".$v_sort.", ".$v_left;
							$rec->getdriver()->Insert('t_record', 'name, img, link, type, sort, lft', $insert);
							
							$k = $rec->getdriver()->Result();
							if ($k == 0) echo "<div class='sms_error'>Запрос на добавление не выполнен</div>";
							else echo "<div class='sms_succses'>Видео <span class='title_name'>".$v_name."</span> успешно добавлено</div>";
						
						showData($rec, $url);
					} else {
						echo "<div class='sms_error'>Ошибка при вводе даных. Запрос на добавление не выполнен</div>";
						showData($rec, $url);
					}
				}
				// обработка удаления выбраных
				else if (isset($_POST["delete_data"]))
				{
					if ($_POST["id"] != null)
					{
						$delete = $_POST["id"];
						for($i=0; $i<count($delete); $i++)
						{
							$rec->getdriver()->Select('t_record', '', 'id='.$delete[$i], '', '', '', '', '');
							$row = $rec->getdriver()->FetchResult();
							if ($row['img'] != '')
							{
								$file_s = '../files/images/records/'.$row['img'];
								if (file_exists($file_s)) { @unlink($file_s); echo "<div class='sms_succses'>Эскиз ".$row['img']." успешно удален</div>"; }
								else echo "<div class='sms_error'>Эскиз ".$row['img']." не найден</div>";
							}
													
								$rec->getdriver()->Delete('t_record', 'id='.$delete[$i]);
								$k = $rec->getdriver()->Result();
								if ($k == 0) echo "<div class='sms_error'>Запрос на удаление не выполнен</div>";
									else echo "<div class='sms_succses'>Запись успешно удалена</div>";
						}
						showData($rec, $url);
						
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали запись для удаления</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showData($rec, $url);
					}
				}
				// форма для удаления одной
				else if (isset($_GET["del_data"]))
				{
					if (($_GET["id"] != null) && ($_GET["del_data"]==1))
					{
						$delete = $_GET["id"];
						$rec->getdriver()->Select('t_record', '', 'id='.$delete[0], '', '', '', '', '');
						$row = $rec->getdriver()->FetchResult();
						if ($row['img'] != '')
						{
							$file_s = '../files/images/records/'.$row['img'];
							if (file_exists($file_s)) { @unlink($file_s); echo "<div class='sms_succses'>Эскиз ".$row['img']." успешно удален</div>"; }
							else echo "<div class='sms_error'>Эскиз ".$row['img']." не найден</div>";
						}
						
							$rec->getdriver()->Delete('t_record', 'id='.$delete[0]);
							$k = $rec->getdriver()->Result();
							if ($k == 0) echo "<div class='sms_error'>Запрос на удаление не выполнен</div>";
								else echo "<div class='sms_succses'>Запись успешно удалена</div>";
							showData($rec, $url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали запись для удаления</div>";
						showData($rec, $url);
					}
				}
				// форма для редактирования
				else if (isset($_GET["update_data"]))
				{
					if (($_GET["id"] != null) && ($_GET["update_data"]==1))
					{
						
						$id_edit = $_GET["id"];
						$rec->getdriver()->Select('t_record', '', 'id='.$id_edit, '', '', '', '', '');
						$row = $rec->getdriver()->FetchResult();
							$id = $row["id"];
							$v_name = $rec->getdriver()->Strip(htmlspecialchars($row["name"]));
                            $mas_name = explode('^', $v_name);
							$v_img =  $row["img"]; if ($row['lft']) $ch = "checked"; else $ch = "";
                            $v_sort = $row['sort'];
                            							
						echo ('<form enctype="multipart/form-data" method="POST" action="'.$url.'" id="data">
								<table border="0">
									<tr><td colspan="1"><h3>Редактирование видео</h3></td><td></td></tr>
									<tr><td colspan="2">
                                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                          <tr>
                                            <td width="9%">Название:</td>
                                            <td width="91%"><input type="text" name="title" value="'.$mas_name[0].'"></td>
                                          </tr>
                                          <tr>
                                            <td>Автор:</td>
                                            <td><input type="text" name="auth" value="'.$mas_name[1].'"></td>
                                          </tr>                                          
                                          <tr>
                                            <td>Эскиз</td>
                                            <td><input type="file" name="img"></td>                                            
                                          </tr>
                                          <tr>
                                        <td>Сортировка :</td>
                                        <td><input type="text" name="sort" style="width:35px;" value="'.$v_sort.'"></td>
                                      </tr>
                                      <tr>
                                        <td>В блоке новостей :</td>
                                        <td><input type="checkbox" name="left" value="1" '.$ch.'></td>
                                      </tr>
                                        </table>

                                    </td></tr>
                                    <tr><td colspan="2"><input type="hidden" name="img_old" value="'.$v_img.'"><input type="hidden" name="id" value="'.$id.'" size="50" /></td></tr>
									<tr><td colspan="2" align="center"><br /><button type="submit" name="update_data_form"><img src="../includes/img/it/save.gif" /></button>
									 &nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									</table>
							</form>');
					}
					else
					{
						echo "Ошибка редактирования";
						showData($rec, $url);
					}
				}
				// обработка редактирования
				else if (isset($_POST["update_data_form"]))
				{
						$id = $_POST['id'];
						$v_name = $rec->getdriver()->PutContent($_POST['title']);
						$v_auth = $rec->getdriver()->PutContent($_POST['auth']);
						$extperms = array('gif','jpg','png'); $v_left = $_POST['left'];
                        $v_sort = $_POST['sort']; if ($_POST['left']) $v_left = 1; else $v_left = 0;
						
						if (!empty($_FILES["img"]["name"]))
						{
							// загрузка файла на сайт
							$uploaddir = '../files/images/records/';     
							// будем сохранять загружаемые 
							// файлы в эту директорию
							$ext_b = strtolower(substr($_FILES["img"]["name"], -3, 3));
							$destination_b = $uploaddir.$_POST['img_old'];
							
							$name_old = $_POST['img_old'];
							
							if(in_array($ext_b, $extperms))
							{
								$file_b = '../files/images/records/'.$name_old;
								if (file_exists($file_b)) @unlink($file_b);
								
								@move_uploaded_file($_FILES['img']['tmp_name'], $destination_b);
								
							
								$image_b = "'".$name_old."'";
								$size = getimagesize('../files/images/records/'.$name_old);
								if ($size[0] > $size[1]) img_resize('../files/images/records/'.$name_old, '../files/images/records/'.$name_old, 120, 120);
								else if ($size[0] < $size[1]) img_resize('../files/images/records/'.$name_old, '../files/images/records/'.$name_old, 120, 120);
							}
							else
							{
								echo "<div class='sms_error'>Ошибка! Картинка должна быть формата: gif, jpg, png</div>";
								showData($rec, $url);
								break;
							}
						}
						else { $image_b = "'".$_POST['img_old']."'"; }
						
						$update = array("'".$v_name."^".$v_auth."'", $image_b, $v_sort, $v_left);
						$rec->getdriver()->Update('t_record', 'name, img, sort, lft', $update, 'id='.$id);
						$k = $rec->getdriver()->Result();
						if ($k == 0) echo "<div class='sms_error'>Запрос на редактирование не выполнен</div>";
						else echo "<div class='sms_succses'>Запись успешно изменёна</div>";
						showData($rec, $url);
                        
					
				}
				// показ
				else{ showData($rec, $url); }
				break;
		case 1:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">Видео</a></li>
			                    <li id="active"><a href="%s&&menu_pop=1">Аудио</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url2, $url2);
                if (isset($_POST["add_data"]))
				{
					//add audio 
					echo ('<form enctype="multipart/form-data" method="POST" action="'.$url2.'" id="data">
								<table border="0">
									<tr><td colspan="1"><h3>Добавление видео</h3></td><td></td></tr>');
                                    
                                    echo '<tr><td colspan="2">
                                    <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                      <tr>
                                        <td>Название* :</td>
                                        <td><input type="text" name="title" style="width:320px;"></td>
                                      </tr>
                                      <tr>
                                        <td>Автор:</td>
                                        <td><input type="text" name="auth" style="width:320px;"></td>
                                      </tr>                                      
                                      <tr>
                                        <td>Файл* :</td>
                                        <td><input type="file" name="link" style="width:320px;"></td>
                                      </tr>
                                      <tr>
                                        <td>Сортировка :</td>
                                        <td><input type="text" name="sort" style="width:35px;" value="100"></td>
                                      </tr>
                                    </table>
                                    </td></tr>
                                    ';
					echo'
									<tr><td align="center" colspan="2"><br /><button type="submit" name="add_data_form"><img src="../includes/img/it/save.gif" /></button>
											&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
							</form>';
				}
				// обработка добавления
				else if (isset($_POST["add_data_form"]))
				{
				    
				    $post = $_POST;
                    
                   //var_dump($_POST); exit;
                    
                    $v_name = $rec->getdriver()->PutContent($post['title']);
                    $v_link = $_FILES['link']['name'];
                    $v_auth = $rec->getdriver()->PutContent($post['auth']);
                    $v_sort = $post['sort'];
                    if ((!$_FILES['link']['name']) or (!$v_name))
                            $true = false; else $true = true;
                    	
					if ($true == true)
					{
						
						$rec->getdriver()->ExecQuery("SELECT MAX(id) FROM t_record WHERE type=2");
						$max_id = $rec->getdriver()->FetchResult();
						
							if (empty($max_id[0])) $max_id[0] = 1;
							else $max_id[0] = $max_id[0] + 1;
							// загрузка файла на сайт
							$uploaddir = '../files/media/';
						
							$extperms = array('mp3');
							$ext_b = 'mp3';
							
							$destination_b = $uploaddir.'song_'.$max_id[0].'.'.$ext_b;
							
							//название фото
							
							$name_b = 'song_'.$max_id[0].'.'.$ext_b;
							
							
							if(in_array($ext_b, $extperms))
						
								@move_uploaded_file($_FILES['link']['tmp_name'], $destination_b);
						
							else
							{
								echo "<div class='sms_error'>Ошибка! Звук должен быть формата: mp3</div>";
								showAudio($rec, $url2);
								break;
							}
							$insert = "'".$v_name."^".$v_auth."', '".$name_b."', 2, ".$v_sort;
							$rec->getdriver()->Insert('t_record', 'name, link, type, sort', $insert);
							
							$k = $rec->getdriver()->Result();
							if ($k == 0) echo "<div class='sms_error'>Запрос на добавление не выполнен</div>";
							else echo "<div class='sms_succses'>Аудио <span class='title_name'>".$v_name."</span> успешно добавлено</div>";
						
						showAudio($rec, $url2); 
					} else {
						echo "<div class='sms_error'>Ошибка при вводе даных. Запрос на добавление не выполнен</div>";
						showAudio($rec, $url2);
					}
				}
				// обработка удаления выбраных
				else if (isset($_POST["delete_data"]))
				{
					if ($_POST["id"] != null)
					{
						$delete = $_POST["id"];
						for($i=0; $i<count($delete); $i++)
						{
							$rec->getdriver()->Select('t_record', '', 'id='.$delete[$i], '', '', '', '', '');
							$row = $rec->getdriver()->FetchResult();
							if ($row['img'] != '')
							{
								$file_s = '../files/media/'.$row['link'];
								if (file_exists($file_s)) { @unlink($file_s); echo "<div class='sms_succses'>Эскиз ".$row['img']." успешно удален</div>"; }
								else echo "<div class='sms_error'>Эскиз ".$row['img']." не найден</div>";
							}
													
								$rec->getdriver()->Delete('t_record', 'id='.$delete[$i]);
								$k = $rec->getdriver()->Result();
								if ($k == 0) echo "<div class='sms_error'>Запрос на удаление не выполнен</div>";
									else echo "<div class='sms_succses'>Запись успешно удалена</div>";
						}
						showAudio($rec, $url2); 
						
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали запись для удаления</div>";
						//echo "<a href='main.php?namem=news&&titlem=Новости'><< вернуться</a>";
						showAudio($rec, $url2);
					}
				}
				// форма для удаления одной
				else if (isset($_GET["del_data"]))
				{
					if (($_GET["id"] != null) && ($_GET["del_data"]==1))
					{
						$delete = $_GET["id"];
						$rec->getdriver()->Select('t_record', '', 'id='.$delete[0], '', '', '', '', '');
						$row = $rec->getdriver()->FetchResult();
						if ($row['img'] != '')
						{
							$file_s = '../files/media/'.$row['link'];
							if (file_exists($file_s)) { @unlink($file_s); echo "<div class='sms_succses'>Эскиз ".$row['img']." успешно удален</div>"; }
							else echo "<div class='sms_error'>Эскиз ".$row['img']." не найден</div>";
						}
						
							$rec->getdriver()->Delete('t_record', 'id='.$delete[0]);
							$k = $rec->getdriver()->Result();
							if ($k == 0) echo "<div class='sms_error'>Запрос на удаление не выполнен</div>";
								else echo "<div class='sms_succses'>Запись успешно удалена</div>";
							showAudio($rec, $url2); 
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали запись для удаления</div>";
						showAudio($rec, $url2); 
					}
				}
				// форма для редактирования
				else if (isset($_GET["update_data"]))
				{
					if (($_GET["id"] != null) && ($_GET["update_data"]==1))
					{
						
						$id_edit = $_GET["id"];
						$rec->getdriver()->Select('t_record', '', 'id='.$id_edit, '', '', '', '', '');
						$row = $rec->getdriver()->FetchResult();
							$id = $row["id"];
							$v_name = $rec->getdriver()->Strip(htmlspecialchars($row["name"]));
                            $mas_name = explode('^', $v_name);
							$v_img =  $row["img"];
                            $v_sort = $row['sort'];							
						echo ('<form enctype="multipart/form-data" method="POST" action="'.$url2.'" id="data">
								<table border="0">
									<tr><td colspan="1"><h3>Редактирование аудио</h3></td><td></td></tr>
									<tr><td colspan="2">
                                        <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                          <tr>
                                            <td width="9%">Название:</td>
                                            <td width="91%"><input type="text" name="title" value="'.$mas_name[0].'"></td>
                                          </tr>
                                          <tr>
                                            <td>Автор:</td>
                                            <td><input type="text" name="auth" value="'.$mas_name[1].'"></td>
                                          </tr>
                                          <tr>
                                        <td>Сортировка :</td>
                                        <td><input type="text" name="sort" style="width:35px;" value="'.$v_sort.'"></td>
                                      </tr>
                                        </table>

                                    </td></tr>
                                    <tr><td colspan="2"><input type="hidden" name="img_old" value="'.$v_img.'"><input type="hidden" name="id" value="'.$id.'" size="50" /></td></tr>
									<tr><td colspan="2" align="center"><br /><button type="submit" name="update_data_form"><img src="../includes/img/it/save.gif" /></button>
									 &nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
									</table>
							</form>');
					}
					else
					{
						echo "Ошибка редактирования";
						showAudio($rec, $url2);
					}
				}
				// обработка редактирования
				else if (isset($_POST["update_data_form"]))
				{
						$id = $_POST['id'];
						$v_name = $rec->getdriver()->PutContent($_POST['title']);
						$v_auth = $rec->getdriver()->PutContent($_POST['auth']);
						$v_sort = $_POST['sort'];
						$update = array("'".$v_name."^".$v_auth."'", $v_sort);
						$rec->getdriver()->Update('t_record', 'name, sort', $update, 'id='.$id);
						$k = $rec->getdriver()->Result();
						if ($k == 0) echo "<div class='sms_error'>Запрос на редактирование не выполнен</div>";
						else echo "<div class='sms_succses'>Запись успешно изменёна</div>";
						showAudio($rec, $url2); 
					
				}
				// показ
				else{ showAudio($rec, $url2);  }
				break;        		
			
					
		default:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s">Видео</a></li>
								<li><a href="%s&&menu_pop=1">Аудио</a></li>
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
  $("div[id=100]").append('<div id="div-'+id+'"><table style="border: 1px solid #ffffff; padding: 10px; margin-top: 10px;"><tr><td>описание<br /><textarea name="description[]" cols="38" rows="7"></textarea></td><td>картинка (для просмотра)*<br /><input type="file" name="image_b[]" value="" size="38" /><br />сортировка<br /><input type="text" name="gallery_sort[]" value="" size="10" /></td></tr></table><span id="cell"><a href="javascript:{}" onclick="removeInput(\'' + id + '\')">Удалить</a></span></div>');
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