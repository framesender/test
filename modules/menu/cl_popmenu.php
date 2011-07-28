<?
class cl_popmenu extends cl_db
{
	//private $id_news;
	//private $title_news;
	//private $text_news;
	//private $date_news;
	
	/* public function __construct()
	{
		$this->getdriver()->Connect();
	} */ 
	
	
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
			$field_names = 'popmenu_id, popmenu_name, popmenu_sortid, popmenu_mm_id';
			$group_names = '';
			$limit_from = '';
			$limit_count = '';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку подменю сайта");
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
				$cond_names.=' popmenu_id='.$list[$i];
				$this->getdriver()->Delete($table_names, $cond_names);
				
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div class='sms_error'>Запрос на удаление не выполнен!</div>";
					else echo "<h3><div class='sms_succses'>Подменю <span class='title_name'>№".$list[$i]."</span> успешно удалено!</div></h3>";
			
			}
			
		}
			else die("Не могу выполнить запрос на удаление пукта меню");
	}
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertMenu($table_names, $list_values)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "popmenu_id, popmenu_name, popmenu_sortid, popmenu_mm_id";
	
			$i=0;
			
			for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}
						$this->getdriver()->Insert($table_names, $field_names, $list);
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на добавление не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Подменю <span class='title_name'>".$list_values[1]."</span> успешно добавлено!</div></h3>";
		}
		else die("<br> Не могу выполнить запрос на добавление пункта меню!");
	}
	
	//Метод редактирует в таблице значение полей, первый параметр - название таблицы, второй - значение полей, третий - по какому условию
	public function UpdateMenu($table_names, $list_values, $cond_names)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "popmenu_name, popmenu_sortid, popmenu_mm_id";
	
			//$i=0;
			
			//for($i=0; $i<count($list_values); $i++)
			//{
			//	$list = implode(", ", $list_values);
			//}
				$this->getdriver()->Update($table_names, $field_names, $list_values, $cond_names);
						
				$k = $this->getdriver()->Result();
					if ($k == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>";
						else echo "<h3><div class='sms_succses'>Подменю <span class='title_name'>".$list_values[0]."</span> успешно изменено!</div></h3>";
			
		}
		else die("<br> Не могу выполнить запрос на редактирование пункта меню!");
	}
	
	// метод для отображения новостей на сайте: передаваемая ссылка
	public function ShowPopMenu($link, $sublink)
	{
		if (empty($link))
		{
			$mainmenu = ''; // записываем ссылку на текущюю страничку с адресной строки
			$this->SelectMenu('t_popmenu', 'popmenu_mm_id=0', 'popmenu_sortid', 'ASC');
		}
		else
		{
			$mainmenu = 'link='.$link.'&'; // записываем ссылку на текущюю страничку с адресной строки
			$this->SelectMenu('t_popmenu', 'popmenu_mm_id='.$link, 'popmenu_sortid', 'ASC');
		}
			$k = $this->getdriver()->Count();
			if ($k != 0)
			{
				echo '<div class="navi">Навигация</div>';
				echo '<div id="submenu">
					<ul>';
				while ($row = $this->getdriver()->FetchResult())
				{
					$name = $this->getdriver()->Strip($row["popmenu_name"]);
					$src = $row["popmenu_id"];
					if ($row["popmenu_id"] == $sublink)
					{
						echo ('<li id="active">'.$name.'</li>');
						
					}
					else
					{
						echo ('<li><a href="?'.$mainmenu.'sublink='.$src.'">'.$name.'</a></li>');
					}
				}
				echo '</ul>
				</div>';
			}
	}
	
	public function GetName($id)
	{
		$sql = "SELECT popmenu_name FROM t_popmenu WHERE popmenu_id=".$id;
		$this->getdriver()->ExecQuery($sql);
		if ($this->getdriver()->Result()){
			$arr = $this->getdriver()->FetchResult();				
			return $arr[0];
			} else return '';
	}
	
	public function SubLinkExist($link, $sublink)
	{
		$sublinkbool = false;
		if (!isset($link)) $link=0;
		
		if (!empty($sublink))
		{
			$link = $this->getdriver()->PutContent($link);
			$sublink = $this->getdriver()->PutContent($sublink);
			$this->SelectMenu('t_popmenu', 'popmenu_id='.$sublink.' and popmenu_mm_id='.$link, '', '');
			$k = $this->getdriver()->Count();
			if ($k == 0) 
			{
				return false;
			}
			else return true;
		}
		else return true;			
	}
}
?>