<?
class cl_menu extends cl_db
{	
	private $url = "main.php?namem=menu&&titlem=Меню сайта"; // не изменять параметры
	
	//Деструктор класа, который закрывает соединение с БД
	function __destruct()
	{
		$this->getdriver()->Disconnect();
	}
	
	//Выполня запрос на выборку, которому передаем название таблицы, условие отбора, номер записи от которой ведется отсчет (начиная с 0), количество записей
	public function SelectMenu($table_names, $cond_names, $ord_names, $ord_types)
	{
		if (!empty($table_names))
		{
			$field_names = 'menu_id, menu_name, menu_sortid, menu_type, menu_seo_id';
			$group_names = '';
			$limit_from = '';
			$limit_count = '';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку меню сайта");
	}
	
	//Выполня запрос на удаление, первый параметр - название таблицы, второй - масив id-шек записей которих надо удалить
	public function DeleteMenu($table_names, $list)
	{
		if (!empty($table_names) && !empty($list))
		{
			$cond_names = '';
			
			//$i=0;
			for($i=0; $i<count($list); $i++)
			{
				$cond_names = '';
				$cond_names.=' menu_id='.$list[$i];
				$this->getdriver()->Delete($table_names, $cond_names);
				
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div class='sms_error'>Запрос на удаление не выполнен!</div>";
					else echo "<h3><div class='sms_succses'>Пункт меню <span class='title_name'>№".$list[$i]."</span> успешно удалён!</div></h3>";
			
			}
			
		}
			else die("Не могу выполнить запрос на удаление пукта меню");
	}
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertMenu($table_names, $list_values)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "menu_id, menu_name, menu_sortid, menu_type, menu_seo_id";
	
			$i=0;
			
			for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}
						$this->getdriver()->Insert($table_names, $field_names, $list);
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на добавление не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Пункт меню <span class='title_name'>".$list_values[1]."</span> успешно добавлен!</div></h3>";
		}
		else die("<br> Не могу выполнить запрос на добавление пункта меню!");
	}
	
	//Метод редактирует в таблице значение полей, первый параметр - название таблицы, второй - значение полей, третий - по какому условию
	public function UpdateMenu($table_names, $list_values, $cond_names)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "menu_name, menu_sortid, menu_type, menu_seo_id";
	
			//$i=0;
			
			//for($i=0; $i<count($list_values); $i++)
			//{
			//	$list = implode(", ", $list_values);
			//}
				$this->getdriver()->Update($table_names, $field_names, $list_values, $cond_names);
						
				$k = $this->getdriver()->Result();
					if ($k == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>";
						else echo "<h3><div class='sms_succses'>Пункт меню <span class='title_name'>".$list_values[0]."</span> успешно изменён!</div></h3>";
			
		}
		else die("<br> Не могу выполнить запрос на редактирование пункта меню!");
	}
	
	public function ShowMenu($server, $main_page, $link)
	{
		$this->getdriver()->PutContent($link);
		$this->SelectMenu('t_menu', '', 'menu_sortid', 'ASC');
		$lnk = $server;
		
		echo '<div id="menu"><ul>';
				if (!empty($link))
				{
					//вывод пункта меню главная
					echo ('<li><a href="'.$lnk.'">'.$main_page.'</a></li>');
				}
				else
				{
					//вывод пункта меню главная-активная
					echo ('<li id="active"><a href="'.$lnk.'">'.$main_page.'</a></li>');
				}
		
				$i = 1;
				while ($row = $this->getdriver()->FetchResult())
				{
					++$i;
					$name = $this->getdriver()->Strip($row["menu_name"]);
					$src = $row["menu_id"];
                    
					if ($row["menu_id"] == $link)
					{
						echo ('<li id="active"><a href="?link='.$src.'">'.$name.'</a></li>');
					}
					else
					{
						echo ('<li><a href="?link='.$src.'">'.$name.'</a></li>');
					}
				}
		echo '</ul></div>';
	}
	
	public function ShowOtherMenu($server, $link)
	{
		$other = new cl_menu();
		
		$other->getdriver()->PutContent($link);
		$other->SelectMenu('t_menu', 'menu_type = 6', 'menu_sortid', 'ASC');
		
		echo '<div id="menum">
				<ul>';
				while ($row = $other->getdriver()->FetchResult())
				{
					$name = $other->getdriver()->Strip($row["menu_name"]);
					$src = $row["menu_id"];
					if ($row["menu_id"] == $link)
					{
						echo ('<li id="active"><a href="'.$server.'?link='.$src.'">'.$name.'</a></li>');
					}
					else
					{
						echo ('<li><a href="'.$server.'?link='.$src.'">'.$name.'</a></li>');
					}
				}
		echo '</ul>
			</div>';
	}
	
	public function LinkExist($link)
	{
		if (!empty($link))
		{
			$link = $this->getdriver()->PutContent($link);
			
			$this->SelectMenu('t_menu', 'menu_id='.$link, 'menu_sortid', 'ASC');
			$k = $this->getdriver()->Count();
			if ($k == 0) 
			{
				return false;
			} 
			else return true;
		}
		else return true;
	}
	
	// метод для отображения сео для меню
	public function ShowSeo($link)
	{
		$link = $this->getdriver()->PutContent($link);
		$this->SelectMenu('t_menu', 'menu_id='.$link, '', '');
		if ($this->getdriver()->Count > 0)
		{
			$row = $this->getdriver()->FetchResult();
			
			$seo_id = $row["menu_seo_id"];
			$this->getdriver()->Select('t_seo', '', 'seo_id='.$seo_id, '', '', '', '', '');
			if ($this->getdriver()->Count() >0)
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
}
?>