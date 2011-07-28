<?
session_start();

include_once("../modules/admin/cl_administrators.php"); //class for cite administrators
include_once("../modules/menu/cl_menu.php"); // class for working with cite menu
	
$n1 = new cl_administrators();
$menu = new cl_menu();
$modlist = new cl_list_modules();
	
	/* -------------------- переменная - ссылка для отправки даных ------------------------- */
	$url = "main.php?namem=admin&&titlem=Администраторы сайта"; // не изменять параметры
	/* -------------------- /переменная - ссылка для отправки даных ------------------------- */
	
	// функция для отображения адмигистраторов, передаем параметр - обьект новости
	function showData($n1,$url)
	{
		// вставка для отображения списка администраторов
		if ($_SESSION["u_stat"] != 1)
		{
		$query = 'user_rule !=1'; 
		$n1->SelectData('users', $query , '', '');
		}
		else
		{
		$n1->SelectData('users','', '', '');
		}
		
		
		$count = $n1->getdriver()->Count();
		if ($count != 0)
			{	
				printf('<form id="group_1" method="POST" name="formdata" action="%s">
								<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  <td>#</td>
									  <th>ФИО</th>
									  <th>Логин</th>
									  <td>Права</td>
									  <td>Дата последнего входа</td>
									  <td>Управление</td>
									  </tr>
									</thead>
									<tbody>', $url);
					while ($row = $n1->getdriver()->FetchResult())
					{
						$fio = $n1->getdriver()->Strip($row["user_name"]);
						$login = $n1->getdriver()->Strip($row["user_login"]);
						$date = $n1->getdriver()->Strip(date("d-m-Y", $row["user_denter"]));
						//
						switch($row["user_rule"])
						{
							case 1:
							$rule = "Супер администратор";
							break;
							case 2:
							$rule = "Администратор";
							break;
							case 3:
							$rule = "Супер модератор";
							break;
							case 4:
							$rule = "Модератор";
							break;
							case 5:
							$rule = "Demo";
							break;
							case 6:
							$rule = "Заблокированный";
							break;	
						}
						//
						echo ('<tr>
								  <td align="center"><input type="checkbox" name="user_id[]" value="'.$row["user_id"].'" /></td>
								  <td align="center">'.$fio.'</td>
								  <td align="center">'.$login.'</td>
								  <td align="center">'.$rule.'</td>
								  <td align="center">'.$date.'</td>
								  
								  <td align="center"><a href="'.$url.'&&user_id='.$row["user_id"].'&&update_data=1">редактировать</a> | <a href="'.$url.'&&user_id[]='.$row["user_id"].'&&del_data=1" onclick="if (confirm(\'Вы уверены что хотете удалить запись?\')) { return true;} else return false;">удалить</a></td>
								</tr>');
					}
					printf('</tbody>	  
							<tr>
								<td colspan="5" align="left"><img src="../includes/img/icons/arrow.png" alt="" /><a rel="group_1" href="#select_all">отметить все</a> / <a rel="group_1" href="#select_none">снять выделение</a></td>
								<td colspan="1" align="center"><button type="submit" name="delete_data" onclick="if (confirm(\'Вы уверены что хотете удалить выбранные записи?\')) { formdata.submit(); } else return false;"><img src="../includes/img/it/delete.gif" alt="" /></button>&nbsp;&nbsp;&nbsp;
												<button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="6" align="right">
								Всего записей: %s &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Показать&nbsp;
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
			else
			{
				printf('<form method="POST" name="formdata" action="%s">
							<table class="tablesorter">
									<thead>
									  <tr id="t_hed" align="center">
									  <td>#</td>
									  <th>ФИО</th>
									  <th>Логин</th>
									  <td>Права</td>
									  <td>Дата последнего входа</td>
									  <td>Управление</td>
									  </tr>
									</thead>
								
							<tr>
								<td colspan="3" align="center"><h3>Извините, нет администраторов для отображения!</h3></td>
								<td colspan="1" align="center"><button type="submit" name="add_data"><img src="../includes/img/it/sozdat.gif" alt="" /></button></td>
							</tr>
							<tr>
								<td colspan="4" align="right">Всего записей: 0 &nbsp;</td>
							</tr>
						</table>
						</form>',$url);
			}
	}	// --------------end showadministrators--------------------------
	
	 
	// --------------/проверка к каким пунктам ме ню привязан модуль -------------------------------------
	
	
	// -------------------------------- /проверка к каким пунктам главного меню привязан модуль для показа необходимого контента ------------------------------
	switch ($_GET["menu_pop"])
	{
		case 0:
				printf('<div id="menu">
			    			<ul>
			                    <li id="active"><a href="%s">Список администраторов</a></li>
			                     
			    			</ul>
			    		</div>
						<div id="under_blue_menu">&nbsp;</div>',$url);
				// форма для добавления админнистраторов
				if (isset($_POST["add_data"]))
				{
					echo "<h3>Новый администратор</h3>";
					printf('<form method="POST" action="%s" name="formCreateUser" id="formCreateUser" >
								<table border="0">
									<tr><td align="left">ФИО:*</td><td><input onKeyup="FormCheckFIO(); FormCheckSubmit();" type="text" name="user_name" value="" size="45" />
									<span id="checkUser" style="padding:5px;"><img src="../includes/img/icons_table/deactive.png" /> </span>
									</td></tr>
									<tr><td>логин:*</td><td><input onKeyup="FormCheckLogin(); FormCheckSubmit();" type="text" name="user_login" size="45" " />
									<span id="checkLogin" style="padding:5px;"><img src="../includes/img/icons_table/deactive.png" />  </span>
									</td></tr>
									<tr><td>пароль:*</td><td><input onKeyup="FormCheckPassword(); FormCheckSubmit();" type="password" id="date" name="user_password" size="45" " />
									<span id="checkPassword" style="padding:5px;"><img src="../includes/img/icons_table/deactive.png" />  </span>
									</td></tr>
									<tr><td>повтор пароля:*</td><td><input onKeyup="FormCheckRePassword(); FormCheckSubmit();" type="password" id="date" name="user_repassword" size="45" " />
									<span id="checkRePassword" style="padding:5px;"><img src="../includes/img/icons_table/deactive.png" />  </span>
									</td></tr>
									<tr><td>статус:*</td><td>
									<select name="user_rule" onChange="FormCheckRule(); FormCheckSubmit();" onKeyup="FormCheckRule(); FormCheckSubmit();">
									<option value="0">--Виберите права--</option>
									<option value="2">Администратор</option>
									<option value="3">Супер Модератор</option>
									<option value="4">Модератор</option>
									<option value="5">Demo</option>
									<option value="6">Заблокировать</option>
									</select>	
									<span id="checkRule" style="padding:5px;"><img src="../includes/img/icons_table/deactive.png" />  </span>
									</td></tr>
									<tr><td align="center" colspan="2"><span id="checkSubmit"> </span></td></tr>
								</table>
							</form>',$url);

					  
				}
				// обработка добавления администраторов сайта
				else if (isset($_POST["add_data_form"]))
				{
					if (($_POST["user_password"] != '')) /* && ($_POST['content'] != '') && ($_POST['short_content'] != '') && ($_POST['date_data'] != '') && ($_POST['date_data'] != 'dd-mm-yyyy')) */
					{
					
						$fio = $n1->getdriver()->PutContent($_POST['user_name']);
						$login = $n1->getdriver()->PutContent($_POST['user_login']);
						$password = $n1->getdriver()->PutContent($_POST['user_password']);
						$rule = $n1->getdriver()->PutContent($_POST['user_rule']);
						$soul = '203984LKJLKpkpo_)(_)(_-092984s;dfm;lsdmfpoP:OIEkp29034imfsld;2q0934rpjc';
						$password = md5($password.$soul);
						
						$fio = "'".$fio."'";
						$login = "'".$login."'";
						$password = "'".$password."'";
						//$rule = "'".$rule."'";
						//$rule = "'".$rule."'";
								
						$insert = array("''", $fio, $login, $password, $rule);
						//$insert = array("''", "'".$title."'", "'".$short_text."'", "'".$text."'", "".$date."");
						//echo var_dump($insert);
						//$ins = array("''", "'1'", "'1'", "21-05-1988");
						$n1->InsertData('users', $insert);

						showData($n1,$url);
					} else {
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на добавление не выполнен!</div>";
						//echo "<a class='error_link' href='main.php?namem=data&&titlem=Новости'><< вернуться</a>";
						showData($n1,$url);
					}
				}
				// обработка удаления выбраных администраторов
				else if (isset($_POST["delete_data"]))
				{
					if ($_POST["user_id"] != null)
					{
						$delete = $_POST["user_id"];
						$n1->DeleteData('users', $delete);
						
						showData($n1,$url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали новости для удаления!</div>";
						//echo "<a href='main.php?namem=data&&titlem=Новости'><< вернуться</a>";
						showData($n1,$url);
					}
				}
				// форма для удаления одной новости
				else if (isset($_GET["del_data"]))
				{
					if (($_GET["user_id"] != null) && ($_GET["del_data"]==1))
					{
						$delete = $_GET["user_id"];
						$n1->DeleteData('users', $delete);
						
						showData($n1,$url);
					}
					else
					{
						echo "<br /><div class='sms_error'>Вы не выбрали новости для удаления!</div>";
						//echo "<a href='main.php?namem=data&&titlem=Новости'><< вернуться</a>";
						showData($n1,$url);
					}
				}
				// форма для редактирования новостей
				else if (isset($_GET["update_data"]))
				{
					if (($_GET["user_id"] != null) && ($_GET["update_data"]==1))
					{
						$id_edit = $_GET["user_id"];
						$n1->SelectData('users', 'user_id='.$id_edit.'', '', '');
						while ($row = $n1->getdriver()->FetchResult())
						{
							$id = $row["user_id"];
							$fio = $n1->getdriver()->Strip($row["user_name"]);
							$login = $n1->getdriver()->Strip($row["user_login"]);
							$pass = $n1->getdriver()->Strip($row["user_password"]);
							$rule = $n1->getdriver()->Strip($row["user_rule"]);
							//$short_text = $row["short_text_data"];
							//$text = $row["text_data"];
							//$date = $n1->getdriver()->Strip(date("d-m-Y", $row["date_data"]));
						} // зделать запрос на виборку по переданой айдишке
						echo "<div><h3>Редактирование даных администратора</h3>";
						printf('<form method="POST" action="%s">
								<table border="0">
									<input type="hidden" name="user_id" value="%s" size="45" />
									<tr><td align="left">ФИО:*</td><td><input type="text" name="user_name" value="%s" size="45" />
									</td></tr>
									<tr><td>логин:*</td><td><input type="text" id="date" name="user_login" value="%s" size="45" />
									</td></tr>
									<tr><td>пароль:*</td><td><input type="password" id="date" name="user_password" size="45" />
									<input type="hidden" name="old_password" value="%s" size="45" />
									</td></tr>
									<tr><td>статус:*</td><td>
									<select name="user_rule" >
									<option value="%s">--Виберите права--</option>
									<option value="2">Администратор</option>
									<option value="3">Супер Модератор</option>
									<option value="4">Модератор</option>
									<option value="5">Demo</option>
									<option value="6">Заблокировать</option>
									</select>	
									</td></tr>
									<tr><td align="center" colspan="2"><button type="submit" name="update_data_form"><img src="../includes/img/it/save.gif"  /></button></td></tr>
								</table>
							</form>',$url,$id,$fio,$login,$pass,$rule);
					}
					else
					{
						echo "Ошибка редактирования!";
						//echo "<br /><a class='error_link' href='' OnClick='history.back();'><< вернуться</a>";
						showData($n1,$url);
					}
				}
				// обработка редактирования админимтраторов
				else if (isset($_POST["update_data_form"]))
				{
					if (($_POST["user_id"] != '') && ($_POST["user_name"] != '') && ($_POST["user_login"]!='') && ($_POST["user_rule"] != ''))
					{
						$user_id = $_POST["user_id"];
						$user_name = $_POST["user_name"];
						$user_login = $_POST["user_login"];
						$user_rule = $_POST["user_rule"];
						if (!empty($_POST["user_password"]))
						{
						$soul = '203984LKJLKpkpo_)(_)(_-092984s;dfm;lsdmfpoP:OIEkp29034imfsld;2q0934rpjc';
						//$password = md5($password.$soul);
						$user_password = md5($_POST["user_password"].$soul);
						}
						else
						{
						$user_password = $_POST["old_password"];
						}
						$user_id = $n1->getdriver()->PutContent($user_id);
						$user_name = $n1->getdriver()->PutContent($user_name);
						$user_login = $n1->getdriver()->PutContent($user_login);
						//$user_password = $n1->getdriver()->PutContent($user_password);
						$user_rule = $n1->getdriver()->PutContent($user_rule);
							
						$updt = array("'".$user_name."'", "'".$user_login."'", "'".$user_password."'", "".$user_rule."");
						//$updt = array($title, $short_text, $text, $date);
						$n1->Updatedata('users', $updt, 'user_id='.$user_id.'');
						showData($n1,$url);
					} 
					else 
					{
						echo "<br /><div class='sms_error'>Ошибка при вводе даных! Запрос на редактирование не выполнен!</div>".$user_id;
						//echo "<a class='error_link' href='main.php?namem=data&&titlem=Новости'><< вернуться</a>";
						showData($n1,$url);
					}
				}
				// показ администратора
				else{ showData($n1,$url); }
				break;
		default:
				echo "Воспользуйтесь пунктом меню!";
	}
?>
<script type="text/javascript">
function FormCheckFIO() {
  var str = $("#formCreateUser").serialize();
 // var str = document.formCreateUser.user_name.value;
  $.post("../modules/admin/checkFIO.php", str, function(data) {
    $("#checkUser").html(data);
  });
}

function FormCheckLogin() {
  var str = $("#formCreateUser").serialize();
  $.post("../modules/admin/checkLogin.php", str, function(data) {
    $("#checkLogin").html(data);
  });
}
function FormCheckPassword() {
  var str = $("#formCreateUser").serialize();
  $.post("../modules/admin/checkPassword.php", str, function(data) {
    $("#checkPassword").html(data);
  });
}
function FormCheckRePassword() {
  var str = $("#formCreateUser").serialize();
  $.post("../modules/admin/checkRePassword.php", str, function(data) {
    $("#checkRePassword").html(data);
  });
}
function FormCheckRule() {
  var str = $("#formCreateUser").serialize();
  $.post("../modules/admin/checkRule.php", str, function(data) {
    $("#checkRule").html(data);
  });
}
function FormCheckSubmit() {
  var str = $("#formCreateUser").serialize();
  $.post("../modules/admin/checkSubmit.php", str, function(data) {
    $("#checkSubmit").html(data);
  });
}

</script>