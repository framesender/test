<?
//include_once("cl_db.php");

class cl_administrators extends cl_db
{
	
	
	//Деструктор класа, который закрывает соединение с БД
	function __destruct()
	{
		$this->getdriver()->Disconnect();
	}
		
	//Выполня запрос на выборку, которому передаем название таблицы, условие отбора, номер записи от которой ведется отсчет (начиная с 0), количество записей
	public function SelectData($table_names, $cond_names, $limit_from, $limit_count)
	{
		if (!empty($table_names))
		{
			$field_names = 'user_id, user_name, user_description, user_login, user_password, user_ip, user_denter, user_rule';
			$group_names = '';
			$ord_names = 'user_login';
			$ord_types = 'DESC';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку новостей");
	}
	
	//Выполня запрос на удаление, первый параметр - название таблицы, второй - масив id-шек записей которих надо удалить
	public function DeleteData($table_names, $list)
	{
		if (!empty($table_names) && !empty($list))
		{
			$cond_names = '';
			
			//$i=0;
			for($i=0; $i<count($list); $i++)
			{
				$cond_names = '';
				$cond_names.=' user_id='.$list[$i];
				$this->getdriver()->Delete($table_names, $cond_names);
				
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div class='sms_error'>Запрос на удаление не выполнен!</div>";
					else echo "<h3><div class='sms_succses'>Администратор(ры) <span class='title_name'>№".$list[$i]."</span> успешно удален(ны)!</div></h3>";
			
			}
			
		}
			else die("Не могу выполнить запрос на удаление новостей");
	}
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertData($table_names, $list_values)
	{
		//var_dump($list_values);
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "user_id, user_name, user_login, user_password, user_rule";
	
			$i=0;
			
			// preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[4], $match); //для проверки корректности даты
			
			// $arr_date = explode('-',$list_values[4]);
			// $d = $arr_date[0];		 
			// $m = $arr_date[1];  
			// $y = $arr_date[2];
			
			//echo $match[0];
			
			/*  if (!empty($match[0]))
			{
				if (($d > 0) && ($d <= 31))
				{
					if (($m > 0) && ($m <= 12))
					{
						$list_values[4] = mktime(0,0,0,$m,$d,$y); */ 
						
						for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}
						$this->getdriver()->Insert($table_names, $field_names, $list);
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на добавление не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Администратор сайта с логином <span class='title_name'>".$list_values[2]."</span> успешно добавлен в базу!</div></h3>";
			
					//} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный месяц!</div>"; echo "<a href='main.php'><< вернуться</a>"; }
				//} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный день!</div>"; echo "<a href='main.php'><< вернуться</a>"; }
			//} else { echo "<br /><div class='sms_error'>Не верный формат даты!</div>"; echo "<a href='main.php'><< вернуться</a>"; }
		}
			else die("<br> Не могу выполнить запрос на добавление ");
	}
	
	//Метод редактирует в таблице значение полей, первый параметр - название таблицы, второй - значение полей, третий - по какому условию
	public function Updatedata($table_names, $list_values, $cond_names)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "user_name, user_login, user_password, user_rule";
			/*
			$i=0;
			
			preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[3], $match); //для проверки корректности даты
			
			$arr_date = explode('-',$list_values[3]);
			$d = $arr_date[0];		 
			$m = $arr_date[1];  
			$Y = $arr_date[2];*/
			/*
			if (!empty($match[0]))
			{
				if (($d > 0) && ($d <= 31))
				{
					if (($m > 0) && ($m <= 12))
					{
						$list_values[3] = mktime(0,0,0,$m,$d,$Y);
						
						for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}*/
						$this->getdriver()->Update($table_names, $field_names, $list_values, $cond_names);
						
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Информация об администраторе <span class='title_name'>".$list_values[0]."</span> успешно изменена!</div></h3>";
			
					//}// else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный месяц!</div>"; echo "<a href='main.php'><< вернуться</a>"; }
				//}// else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный день!</div>"; echo "<a href='main.php'><< вернуться</a>"; }
			//} //else { echo "<br /><div class='sms_error'>Не верный формат даты!</div>"; echo "<a href='main.php'><< вернуться</a>"; }
		}
			else die("<br> Не могу выполнить запрос на редактирование информации об администраторе");
	}
	
	//Метод возвращает результат  выполнения последнего запроса c помощью mysql_fetch_array
	// public function FetchResultdata()
	// {
		// return $this->getdriver()->FetchResult();
	// }
	
	//Метод возвращает результат  выполнения последнего запроса
	// public function Resultdata()
	// {
		// return $this->getdriver()->Result();
	// }
	
	// метод для отображения новостей на сайте, параметры - позицыя с какого елемента, сколько выбрать, ссылка(показ на страничке с даной ссылкой)
	/* - my comment*/
	public function Showdata($limit_from, $limit_count, $link, $query_string)
	{
		if (!empty($link))
		{
			$this->getdriver()->Select('list_mod', '', "src_list_mod='data' and mm_id like '%".$link."%'", '', '', '', '', '');
			$count = $this->getdriver()->Count();
			if ($count != 0)
			{
				$this->Selectdata('t_data', '', $limit_from, $limit_count);
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div>Нет новостей для отображения</div>";
					else
					{
						echo "<div><ul>";
						while ($row = $this->getdriver()->FetchResult())
						{
							echo ('<li class="data"><div class="title_data">'.$row["title_data"].'</div>
									<div class="date_data">'.date("d-m-Y", $row["date_data"]).'</div>
									  
									<div class="short_data">'.$row["short_text_data"].'</div>
									<div class="src_data"><a href="?'.$query_string.'&&data_id='.$row["id_data"].'">подробнее</a></div></li>');
									
									//echo ('<li><table class="data" border="0"><tr><td align="left"><div class="title_data">'.$row["title_data"].'</div></td></tr>
									//<tr><td align="left"><div class="date_data">'.date("d-m-Y", $row["date_data"]).'</div></td></tr>
									  
									//<tr><td align="left"><div class="short_data">'.$row["short_text_data"].'</div></td></tr>
									//<tr><td><div class="src_data"><a href="?'.$query_string.'&&data_id='.$row["id_data"].'">подробнее</a></div></td></tr></table></li>');
						}
						echo "</ul></div>";
					}
			}
		}
	}
	
	// метод для отображения выбраной новости на сайте, параметры -, ссылка(показ на страничке с даной ссылкой), ид новости
	
	public function ShowOnedata($link, $data_id)
	{
	
		if (!empty($link))
		{
			$this->getdriver()->Select('list_mod', '', "src_list_mod='data' and mm_id like '%".$link."%'", '', '', '', '', '');
			$count = $this->getdriver()->Count();
			if ($count != 0)
			{
				$this->Selectdata('t_data', "id_data='".$data_id."'", '', '');
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div>Нет администраторов для отображения</div>";
					else
					{
						while ($row = $this->getdriver()->FetchResult())
						{
							echo ('<div><table class="one_data" border="0"><tr><td align="left"><div class="one_title_data">'.$row["title_data"].'</div></td></tr>
									<tr><td align="left"><div class="one_date_data">'.date("d-m-Y", $row["date_data"]).'</div></td></tr>
									<tr><td align="left"><div class="one_text_data">'.$row["text_data"].'</div></td></tr></table></div>');
						}
					}
			}
		}
	}

}
?>