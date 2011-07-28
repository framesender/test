<?
class cl_news extends cl_db
{
	private $url = "main.php?namem=news&&titlem=Новости"; // не изменять параметры
	
	//Деструктор класа, который закрывает соединение с БД
	function __destruct()
	{
		$this->getdriver()->Disconnect();
	}
	
	//Выполня запрос на выборку, которому передаем название таблицы, условие отбора, номер записи от которой ведется отсчет (начиная с 0), количество записей
	public function SelectNews($table_names, $cond_names, $limit_from, $limit_count)
	{
		if (!empty($table_names))
		{
			$field_names = 'id_news, title_news, short_text_news, text_news, date_news, news_type, news_seo_id, news_pict';
			$group_names = '';
			$ord_names = 'date_news';
			$ord_types = 'DESC';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку новостей");
	}
	
	//Выполня запрос на удаление, первый параметр - название таблицы, второй - масив id-шек записей которих надо удалить
	public function DeleteNews($table_names, $list)
	{
		if (!empty($table_names) && !empty($list))
		{
			$cond_names = '';
			
			//$i=0;
			for($i=0; $i<count($list); $i++)
			{
				$cond_names = '';
				$cond_names.=' id_news='.$list[$i];
				$this->getdriver()->Delete($table_names, $cond_names);
				
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div class='sms_error'>Запрос на удаление не выполнен!</div>";
					else echo "<h3><div class='sms_succses'>Новость <span class='title_name'>№".$list[$i]."</span> успешно удалена!</div></h3>";
			
			}
			
		}
			else die("Не могу выполнить запрос на удаление новостей");
	}
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertNews($table_names, $list_values)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "title_news, short_text_news, text_news, date_news, news_type, news_seo_id, news_pict";
	
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
						
						for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}
						$this->getdriver()->Insert($table_names, $field_names, $list);
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на добавление не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Новость <span class='title_name'>".strip_tags($list_values[0])."</span> успешно добавлена!</div></h3>";
			
					} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный месяц!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
				} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный день!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
			} else { echo "<br /><div class='sms_error'>Не верный формат даты!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
		}
			else die("<br>Не могу выполнить запрос на добавление новостей");
	}
	
	//Метод редактирует в таблице значение полей, первый параметр - название таблицы, второй - значение полей, третий - по какому условию
	public function UpdateNews($table_names, $list_values, $cond_names)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "title_news, short_text_news, text_news, date_news, news_type, news_seo_id, news_pict";
			
			//$i=0;
			
			preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[3], $match); //для проверки корректности даты
			
			$arr_date = explode('-',$list_values[3]);
			$d = $arr_date[0];		 
			$m = $arr_date[1];  
			$Y = $arr_date[2];
			if (!empty($match[0]))
			{
				if (($d > 0) && ($d <= 31))
				{
					if (($m > 0) && ($m <= 12))
					{
						$list_values[3] = mktime(0,0,0,$m,$d,$Y);
						
						//for($i=0; $i<count($list_values); $i++)
						//{
							//$list = implode(", ", $list_values);
						//}
						$this->getdriver()->Update($table_names, $field_names, $list_values, $cond_names);
						
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>";
							else echo "<h3><div class='sms_succses'>Новость <span class='title_name'>".strip_tags($list_values[0])."</span> успешно изменена!</div></h3>";
			
					} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный месяц!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
				} else { echo "<br /><div class='sms_error'>Не верный формат даты: не верный день!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
			} else { echo "<br /><div class='sms_error'>Не верный формат даты!</div>"; echo "<a href='".$this->url."'><< вернуться</a>"; }
		}
			else die("<br> Не могу выполнить запрос на редактирование новостей");
	}
	
	// метод для отображения панели новостей на сайте, параметры - ссылка(показ на страничке с даной ссылкой), позицыя с какого елемента, сколько выбрать
	public function ShowPanelNews($link)
	{
		$kol_news = $this->FileRead('modules/news/news_config.php');
		
		$limit_from = 0;
		$limit_count = $kol_news[0];
		
		
		if (!empty($link))
		{
			$this->getdriver()->Select('list_mod', '', "src_list_mod='news' and mm_id like '%".$link."%'", '', '', '', '', '');
		}
		else if (empty($link))
		{
			$this->getdriver()->Select('list_mod', '', "src_list_mod='news' and mm_id like '%0%'", '', '', '', '', '');
		}
			$count = $this->getdriver()->Count();
			if ($count != 0)
			{
				$this->getdriver()->Select('t_menu', 'menu_id', 'menu_type=2', '', '', '', '', '');	//выбираем айди меню, тип меню у которой - новости ( menu_type=2 )
				$linknews = $this->getdriver()->FetchResult();
				$linknews["popmenu_id"] = '';
				
				
				//вывод новостей - новости
				$this->SelectNews('t_news', "news_type='новости'", $limit_from, $limit_count);
				$k = $this->getdriver()->Count();
				if ($k > 0)
					{
						
						$linknews["popmenu_id"] = '1';
						echo '
							<table id="panelnews" width="100%" border="0" cellspacing="0" cellpadding="0">
					          <tr>
					            <td colspan="2"><div class="name">Ваши новости</div></td>
					          </tr>
								  
						';
						while ($row = $this->getdriver()->FetchResult())
						{	
							if ($row["news_pict"] != '') $img = '<div class="news_img"><img src="files/images/news/'.$this->getdriver()->Strip($row["news_pict"]).'" alt="news" title="news" /></div>';
							
							echo '
							<tr>
					            <td valign="top" width="80"><a href="?link='.$linknews["menu_id"].'&news='.$row["id_news"].'">'.$img.'</a></td>
					            <td valign="top">'.date("d.m.Y", $row["date_news"]).'<p>'.stripslashes($this->getdriver()->Strip($row["short_text_news"])).'<br /><a class="details" href="?link='.$linknews["menu_id"].'&news='.$row["id_news"].'">подробнее</a></p><br />
					            </td>
					          </tr>
							';
						}
						
						echo '
							  <tr>
								  <td></td><td><a class="details" href="?link='.$linknews["menu_id"].'">читать все новости »</a></td>									  
							  </tr>
							  </table>
						';
					}				
			}
		
	}
	
	// функция для читания файла
	private function FileRead($file)
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
	
	// метод для отображения новостей на сайте, параметры -, ссылка(показ на страничке с даной ссылкой),, тип новости, ид новости, позицыя с какого елемента выбрать
	public function ShowNews($link, $sublink, $news_id, $limit)
	{	
			$kol_news = $this->FileRead('modules/news/news_config.php');
			
			if (empty($limit)) $limit_from = 0;
				else if ($limit < 0) $limit_from = 0;
					else $limit_from = $limit;
			$limit_count = $kol_news[1];
			
			if (!empty($link) && empty($news_id))
			{
				$this->getdriver()->Select('t_menu', 'menu_id', 'menu_type=2 and menu_id='.$link, '', '', '', '', '');	//выбираем айди меню, тип меню у которой - новости ( menu_type=2 ), 
				
				$count = $this->getdriver()->Count();
				if ($count != 0)
				{	
					include_once("core/cl_navigation.php");
					$linknews = $this->getdriver()->FetchResult();
					$news_type = 'новости';
					
					$this->SelectNews('t_news', '', '', ''); // для выборки всех новостей
					$col = $this->getdriver()->Count(); // количество всех новостей
						
					$this->SelectNews('t_news', "news_type='".$news_type."'", $limit_from, $limit_count);
						//$k = $this->getdriver()->Result();
						$k = $this->getdriver()->Count();
						if ($k != 0) 
							{
									echo '
										<table id="news" width="100%" border="0" cellspacing="0" cellpadding="0">
										';
                                    
                                    while ($row = $this->getdriver()->FetchResult())
									{
										if ($row["news_pict"] != '') $img = '<div class="news_img"><img src="files/images/news/'.$this->getdriver()->Strip($row["news_pict"]).'" alt="news" title="news" /></div>';
                                            
                                        echo '<tr>
								            <td valign="top" width="80"><a href="?link='.$linknews["menu_id"].'&news='.$row["id_news"].'">'.$img.'</a></td>
								            <td valign="top">'.date("d.m.Y", $row["date_news"]).'<p>'.stripslashes($this->getdriver()->Strip($row["short_text_news"])).'<br /><a class="details" href="?link='.$linknews["menu_id"].'&news='.$row["id_news"].'">подробнее</a></p><br />
								            </td>
								          </tr>'; 
     
                                            
									}
                                    
                                    
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
                                    
                                    echo '<tr>
                                      <td colspan="2">
                                      <div class="link_navi">'.
                                      $navigator->links_s($p,$navigator->edit_adres($_SERVER["QUERY_STRING"]),$n,$kol_news[1],$col).'
                                      </div>
                                      </td>
                                      </tr>';
                                    
									echo '
                                     </table>
                                    ';
									
																
							}
				}
			}
			else if (!empty($link) && !empty($news_id))
			{ 
					$this->SelectNews('t_news', 'id_news='.$news_id, '', '');
					$k = $this->getdriver()->Result();
					if ($k != 0)
						{
							$row = $this->getdriver()->FetchResult();						
							echo '
                                <table id="news" width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td valign="top">
									<H2>'.$this->getdriver()->Strip($row["title_news"]).'</H2>
									<div>'.date("d.m.Y", $row["date_news"]).'</div>                                   
                                    '. stripslashes($row["text_news"]).'
                                    <div><a class="details" href="" onClick="history.back();">« вернутся к новостям</a></div>
                                    </td>
                                  </tr>
                                </table>
                                ';
                            
						}
			}
		
	}
	
	// метод для отображения сео для новостей
	public function ShowSeo($news_id)
	{
		$news_id = $this->getdriver()->PutContent($news_id);
		$this->SelectNews('t_news', 'id_news='.$news_id, '', '');
		if ($this->getdriver()->Count() > 0)
		{
			$row = $this->getdriver()->FetchResult();
			
			$seo_id = $row["news_seo_id"];
			$this->getdriver()->Select('t_seo', '', 'seo_id='.$seo_id, '', '', '', '', '');
			if ($this->getdriver()->Count()>0)
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