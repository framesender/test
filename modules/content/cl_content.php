<?
class cl_content extends cl_db
{
	private $url = "main.php?namem=content&&titlem=Содержимое сайта"; // не изменять параметры
	
	//Деструктор класа, который закрывает соединение с БД
	function __destruct()
	{
		$this->getdriver()->Disconnect();
	}
	
	//Выполня запрос на выборку, которому передаем название таблицы, условие отбора,
	public function SelectData($table_names, $cond_names, $limit_from, $limit_count)
	{
		if (!empty($table_names))
		{
			$field_names = 'content_id, content_title, content_text, content_date, content_mm_id, content_popmm_id, content_seo_id';
			$group_names = '';
			$ord_names = '';
			$ord_types = '';
			//$limit_from = '';
			//$limit_count = '';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку контента");
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
				$cond_names.=' content_id='.$list[$i];
				$this->getdriver()->Delete($table_names, $cond_names);
				
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div class='sms_error'>Запрос на удаление не выполнен!</div>";
					else echo "<h3><div class='sms_succses'>Контент <span class='title_name'>№".$list[$i]."</span> успешно удален!</div></h3>";
			
			}
			
		}
			else die("Не могу выполнить запрос на удаление контента");
	}
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertData($table_names, $list_values)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = 'content_id, content_title, content_text, content_date, content_mm_id, content_popmm_id, content_seo_id';
	
			$i=0;
			
			preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[3], $match); //для проверки корректности даты
			
			$arr_date = explode('-',$list_values[3]);
			$d = $arr_date[0];		 
			$m = $arr_date[1];  
			$y = $arr_date[2];
			
			//echo $match[0];
			
			if (!empty($match[0]))
			{
				if (($d > 0) && ($d <= 31))
				{
					if (($m > 0) && ($m <= 12))
					{
						$list_values[3] = mktime(0,0,0,$m,$d,$y);
						//var_dump($list_values); 
						for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}
						//echo ($list); 
						$this->getdriver()->Insert($table_names, $field_names, $list);
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на добавление не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Контент <span class='title_name'>".strip_tags($list_values[1])."</span> успешно добавлен!</div></h3>";
			
					} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный месяц!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
				} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный день!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
			} else { echo "<br /><div class='sms_error'>Не верный формат даты!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
		}
			else die("<br> Не могу выполнить запрос на добавление контента");
	}
	
	//Метод редактирует в таблице значение полей, первый параметр - название таблицы, второй - значение полей, третий - по какому условию
	public function UpdateData($table_names, $list_values, $cond_names)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = 'content_title, content_text, content_date, content_mm_id, content_popmm_id, content_seo_id';
			
			//$i=0;
			
			preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[2], $match); //для проверки корректности даты
			
			$arr_date = explode('-',$list_values[2]);
			$d = $arr_date[0];		 
			$m = $arr_date[1];  
			$Y = $arr_date[2];
			if (!empty($match[0]))
			{
				if (($d > 0) && ($d <= 31))
				{
					if (($m > 0) && ($m <= 12))
					{
						$list_values[2] = mktime(0,0,0,$m,$d,$Y);
						//var_dump($list_values); 
						//for($i=0; $i<count($list_values); $i++)
						//{
							//$list = implode("; ", $list_values);
						//}
						//echo ($list); 
						$this->getdriver()->Update($table_names, $field_names, $list_values, $cond_names);
						
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>".mysql_error();
							else echo "<h3><div class='sms_succses'>Контент <span class='title_name'>".$list_values[0]."</span> успешно изменен!</div></h3>";
			
					} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный месяц!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
				} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный день!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
			} else { echo "<br /><div class='sms_error'>Не верный формат даты!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
		}
			else die("<br> Не могу выполнить запрос на редактирование контента");
	}
	
	// --------------------------------------------------------------------
	public function RetAllLinks()
	{		
		$field_names = 'menu_id';
		$cond_names = 'menu_type=1';
		$group_names = '';
		$ord_names = '';
		$ord_types = '';
		$limit_from = '';
		$limit_count = '';
		
		$mas_id = array();
		$this->getdriver()->Select('t_menu', $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		while ($row = $this->getdriver()->FetchResult())
		{
			$mas_id[] = $row['menu_id'];
		}
		return $mas_id;
		
	}
	
	public function ShowMultyContent($currentRec)
	{
		//echo 'id='.$currentRec;		
		if (isset($currentRec))
		{
			$this->SelectData('t_content', "content_mm_id='".$currentRec."' and content_popmm_id='none'", '', '');
			
			$k = $this->getdriver()->Result();
			if ($k == 0) echo "<br /><div>Нет контента для отображения</div>";
			else
			{
				//echo "<div>";
				while ($row = $this->getdriver()->FetchResult())
				{
					//echo ('<div class="content_site">'.stripslashes($row["content_text"]).'</div>');
					echo (stripslashes($row["content_text"]));
				}
				//echo "</div>";
			}
		}
		else die("<br> Не могу выполнить запрос на выборку контента");
	}
	
	// --------------------------------------------------------------------
	
	// метод для отображения контента на сайте, параметры - ссылка(показ на страничке с даной ссылкой)
	public function ShowContent($link, $sublink)
	{
		if (!isset($link) and !isset($sublink))
		{
			$this->SelectData('t_content', "content_mm_id='0' and content_popmm_id='none'", '', '');
			$k = $this->getdriver()->Result();
			if ($k == 0) echo "<br /><div>Нет контента для отображения</div>";
			else
			{
				//echo "<div>";
				while ($row = $this->getdriver()->FetchResult())
				{
					echo ('<div class="main_content">'.stripslashes($row["content_text"]).'</div>');
				}
				//echo "</div>";
			}
		}
		else if ((!empty($link)) && (!isset($sublink)))
		{
			$this->SelectData('t_content', "content_mm_id='".$link."' and content_popmm_id='none'", '', '');
			$k = $this->getdriver()->Result();
			if ($k == 0) echo "<br /><div>Нет контента для отображения</div>";
			else
			{
				//echo "<div>";
				while ($row = $this->getdriver()->FetchResult())
				{
					echo ('<div class="content_site">'.stripslashes($row["content_text"]).'</div>');
				}
				//echo "</div>";
			}
		}
		else if (!empty($sublink))
		{
			$this->SelectData('t_content', "content_mm_id !='none' and content_popmm_id='".$sublink."'", '', '');
			$k = $this->getdriver()->Result();
			if ($k == 0) echo "<br /><div>Нет контента для отображения</div>";
			else
			{
				//echo "<div>";
				while ($row = $this->getdriver()->FetchResult())
				{
					echo ('<div class="content_site">'.$row["content_text"].'</div>');
				}
				//echo "</div>";
			}
		}
	}
	
	// метод для отображения сео для содержимого
	public function ShowSeo($link, $sublink)
	{
		$link = $this->getdriver()->PutContent($link);
		$sublink = $this->getdriver()->PutContent($sublink);
		
		if ($link == '' && $sublink == '')
		{
			$this->SelectData('t_content', "content_mm_id=0 and content_popmm_id='none'", '', '');
			$row = $this->getdriver()->FetchResult();
			$seo_id = $row["content_seo_id"];
		}
		else if ($link != '' && $sublink == '')
		{
			$this->SelectData('t_content', "content_mm_id=".$link." and content_popmm_id='none'", '', '');
			$row = $this->getdriver()->FetchResult();
			$seo_id = $row["content_seo_id"];
		}
		else if ($sublink != '')
		{
			$this->SelectData('t_content', "content_mm_id !='none' and content_popmm_id=".$sublink, '', '');
			$row = $this->getdriver()->FetchResult();
			$seo_id = $row["content_seo_id"];
		}
		
		$this->getdriver()->Select('t_seo', '', 'seo_id='.$seo_id, '', '', '', '', '');
		if ($this->getdriver()->Count() > 0)
		{
			$row1 = $this->getdriver()->FetchResult();
			$mas_seo[0] = $this->getdriver()->Strip($row1["seo_title"]);
			$mas_seo[1] = $this->getdriver()->Strip($row1["seo_description"]);
			$mas_seo[2] = $this->getdriver()->Strip($row1["seo_keywords"]);
			return $mas_seo;
		}
		else return 0;
	}

}
?>