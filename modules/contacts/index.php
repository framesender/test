<?

/// slkfdslkjf lkasdjf ls;dakjf ;slag js;lkfj sl;ad jf;lskdjj ;a
	include_once("cl_contacts.php");
	
	$contacts = new cl_contacts();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=contacts&&titlem=Контакты"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения контактов
	function showData($contacts, $url)
	{
		$contacts->getdriver()->Select('t_contacts', '', '', '', '', '', '', '');
		$count = $contacts->getdriver()->Count();
		if ($count != 0)
			{	
			
				printf('<form id="group_1" method="POST" name="formnews" action="%s">
								<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  
										  <th>Контактная информация</th>
										  <th>Список e-mail</th>
										  <th>Управление</th>
									  </tr>
									</thead>
									<tbody>', $url);
					while ($row = $contacts->getdriver()->FetchResult())
					{
						$info = strip_tags($contacts->getdriver()->Strip($row["contacts_info"]));
						$mails = $contacts->getdriver()->Strip($row["contacts_mails"]);
						echo ('<tr>
								
								  <td>'.$info.'</td>
								  <td align="center">'.$mails.'</td>
								  
								  <td align="center"><a href="'.$url.'&&contacts_id='.$row["contacts_id"].'&&update_data=1">редактировать</a> | <a href="'.$url.'&contacts_id[]='.$row["contacts_id"].'&&del_data=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					printf('</tbody>
							<tr>
								<td colspan="3" align="right">
								Всего записей: %s </td>
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
										<th>Контактная информация</th>
										<th>Список e-mail</th>
										<th>Управление</th>
									 </tr>
								</thead>
								
							<tr>
								<td colspan="2" align="center"><h3>Извините, нет контактов для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="4" align="right">Всего записей: 0 </td>
							</tr>
						</table>
						</form>', $url);
			}
	}	// --------------end showContacts--------------------------
	
	switch ($_GET["menu_pop"])
	{
		case 0:            
				printf('<div id="menu">
			    			<ul>
			                    <li id="active"><a href="%s">контакты</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url);
				
				if (isset($_POST["add_data"]))
				{
					echo ('<script type="text/javascript" src="../includes/scripts/js/fckeditor/fckeditor.js"></script>
					<script type="text/javascript">
						window.onload = function()
						{
							var sBasePath = "../includes/scripts/js/fckeditor/";
							
							var info = new FCKeditor(\'info\');
							info.Width = "100%" ;
							info.Height = "300" ;
							
							info.BasePath = sBasePath;
							info.ReplaceTextarea();
						}
					</script>');
					
					echo "<br /><h3>Добавление контакта</h3>";
					echo('<form method="POST" action="'.$url.'">
								<table border="0" width="80%">
									<tr><td align="left">контактная информация:*</td></tr>
									<tr><td colspan="1"><textarea name="info" id="info" cols="38" rows="7"></textarea></td></tr>
									<tr><td align="left">список e-mail(через точку с запятой)*:</td></tr>
									<tr><td><font color="red">(Пример: support@gmail.com;mail@mail.ru)</font><td></tr>
									<tr><td colspan="1"><input type="text" name="mails" size="70" value="" /></td></tr>
									<tr><td align="center"><br /><button type="submit" name="add_data_form"><img src="../includes/img/it/save.gif"  /></button>
										&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
							</form>');
				}
				else if (isset($_POST["add_data_form"]))
				{
					if (($_POST["info"] != '') and ($_POST["mails"] != ''))			
					{
						$info = $_POST["info"];
						$mails = $_POST["mails"];
						$info = $contacts->getdriver()->PutContent($info);
						
						$info = "'".$info."'";
						$mails = "'".$mails."'";
						
						$insert_names = "contacts_id, contacts_info, contacts_mails";
						$insert_values = "'', ".$info.", ".$mails;
						
						$contacts->getdriver()->Insert('t_contacts', $insert_names, $insert_values);
						
						ShowData($contacts, $url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
						ShowData($contacts, $url);
					}
				}
				else if (isset($_GET["del_data"]))
				{
					if (($_GET["contacts_id"] != null) && ($_GET["del_data"]==1))
					{
						$delete = $_GET["contacts_id"][0];
						$contacts->getdriver()->Delete('t_contacts', 'contacts_id='.$delete);
						
						ShowData($contacts, $url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали контакт для удаления!</div>";
						ShowData($contacts, $url);
					}
				}
				else if (isset($_GET["update_data"]))
				{
					if (($_GET["contacts_id"] != null) && ($_GET["update_data"]==1))
					{
						$id_edit = $_GET["contacts_id"];
						$contacts->getdriver()->Select('t_contacts', '', 'contacts_id='.$id_edit, '', '', '', '', '');
						$row = $contacts->getdriver()->FetchResult();
						
						echo ('<script type="text/javascript" src="../includes/scripts/js/fckeditor/fckeditor.js"></script>
							<script type="text/javascript">
								window.onload = function()
								{
									var sBasePath = "../includes/scripts/js/fckeditor/";
									
									var info = new FCKeditor(\'info\');
									info.Width = "100%" ;
									info.Height = "300" ;
									
									info.BasePath = sBasePath;
									info.ReplaceTextarea();
								}
							</script>');
					
						echo "<br /><h3>Редактирование контакта</h3>";
						echo('<form method="POST" action="'.$url.'">
								<table border="0" width="80%">
									<tr><td align="left"><input type="hidden" name="id" value="'.$row["contacts_id"].'"></td></tr>
									<tr><td align="left">контактная информация:*</td></tr>
									<tr><td colspan="1"><textarea name="info" id="info" cols="38" rows="7">'.stripslashes($row["contacts_info"]).'</textarea></td></tr>
									<tr><td align="left"><br />список e-mail(через точку с запятой)*:</td></tr>
									<tr><td><font color="red">(Пример: support@gmail.com;mail@mail.ru)</font><td></tr>
									<tr><td colspan="1"><input type="text" name="mails" size="70" value="'.$row["contacts_mails"].'" /></td></tr>
									<tr><td align="center"><br /><button type="submit" name="update_data_form"><img src="../includes/img/it/save.gif"  /></button>
										&nbsp;&nbsp;&nbsp;<button type="submit" name="cancel"><img src="../includes/img/it/cancel_form.gif" alt="" /></button></td></tr>
								</table>
							</form>');
					}
					else
					{
						echo "Ошибка редактирования!";
						ShowData($contacts, $url);
					}
				}
				else if (isset($_POST["update_data_form"]))
				{
					if (($_POST["id"] != '') && ($_POST["info"] != '') && ($_POST["mails"] != ''))
					{
						$updt_names = "contacts_info, contacts_mails";
						$info = $contacts->getdriver()->PutContent($_POST["info"]);
						$updt_values = array("'".$info."'", "'".$_POST["mails"]."'");
						$contacts->getdriver()->Update('t_contacts', $updt_names, $updt_values, 'contacts_id='.$_POST["id"]);
						$true = $contacts->getdriver()->Result();
						if ($true == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Контакт успешно изменен!</div></h3>";
						ShowData($contacts, $url);
					}
					else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>";
						ShowData($contacts, $url);
					}
				}
				else
				{
					ShowData($contacts, $url);
				}
				
				break;
		default:
				printf('<div id="menu">
			    			<ul>
			                    <li><a href="%s&&menu_pop=0">контакты</a></li>
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>', $url, $url);
				echo "Воспользуйтесь пунктом меню!";
	}
?>