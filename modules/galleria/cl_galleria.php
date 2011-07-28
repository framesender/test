<?
class cl_galleria extends cl_db
{
	
	public function ShowGalleryContent($link, $sublink, $page, $next)
	{
		$this->getdriver()->Select('t_menu', '', 'menu_id='.$link.' and menu_type=4', '', '', '', '', '');
		$k = $this->getdriver()->Count();
		if ($k != 0)
		{
			echo '
				<H2>Ваша галерея картинок</H2>
	        	<div id="panelgallery">';
	        
					$this->ShowGalleria($link, $sublink, $page, $next, $this->edit_adres($_SERVER["QUERY_STRING"]));
				
					$count_show = $this->ForRead($link, $sublink);
					$count_all = $this->CountImageMenu($link, $sublink);
					echo $this->links($page, $this->edit_adres($_SERVER["QUERY_STRING"]), $next, $count_all, $count_show);
					
			echo '</div>';
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
	
	// метод возвращяет количество показуемых картинок
	public function ForRead($link, $sublink)
	{
		$link = $this->getdriver()->PutContent($link);
		$sublink = $this->getdriver()->PutContent($sublink);
		if ((!empty($link)) and (empty($sublink)))
		{
			$kol = $this->FileRead('modules/galleria/galleria_config.php');
			return $kol[0];
		}
		else if ((!empty($link)) and (!empty($sublink)))
		{
			$kol = $this->FileRead('modules/galleria/galleria_config.php');
			return $kol[1];
		}
	}
	
	// для подсчета картинок привязаных к данному меню галереи
	public function CountImageMenu($link, $sublink)
	{
		$link = $this->getdriver()->PutContent($link);
		$sublink = $this->getdriver()->PutContent($sublink);
		if ((!empty($link)) and (empty($sublink))) $this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id=""', '', '', '', '', '');
		else if ((!empty($link)) and (!empty($sublink))) $this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id='.$sublink, '', '', '', '', '');
		$k = $this->getdriver()->Count();
		return $k;
	}
	
	public function ShowMainGalleria($link, $count_to_show)
	{
		if ($link == '')
		{
			$this->getdriver()->Select('t_galleria', '', '', '', 'gall_sort', 'ASC', 0, $count_to_show);
			$kol = $this->getdriver()->Count();
			if ($kol != 0)
			{						
				echo '<H2>Ваша галерея картинок</H2>
	        	<div id="panelgallery">
				<table width="100%" border="0" id="gallery" cellspacing="3" cellpadding="3"><tr>';
				$i = 1; $jj = 0;
				while ($row = $this->getdriver()->FetchResult())
				{
					if (($jj != 0) and ($jj + 1) == $i) $j++; 
					if ($i % 4 != 0) echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td>';
					else if (($i % 4 == 0) and ($i != $pict_show[0])) { $jj = $i; echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td></tr><tr>'; }
					else { $jj = $i; echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td></tr>'; }
					$i++;
				}
				
				echo '</table></div>';
				
			}
		}
	}
	
	public function ShowGalleria($link, $sublink, $show, $next, $adress)
	{
		$link = $this->getdriver()->PutContent($link);
		$sublink = $this->getdriver()->PutContent($sublink);
		$next = $this->getdriver()->PutContent($next);
		$page = $this->getdriver()->putcontent($page);
		
		if (empty($show)) $show = 0;
		else $show = $this->getdriver()->PutContent($show);		
		
		$this->getdriver()->Select('t_menu', '', 'menu_id='.$link.' and menu_type=4', '', '', '', '', '');
		$k = $this->getdriver()->Count();
		if ($k != 0)
		{
			$pict_show = $this->FileRead('modules/galleria/galleria_config.php');
			$this->getdriver()->Select('t_galleria', '', '', '', '', '', '', '');
			$col = $this->getdriver()->Count();
							
			if ((!empty($link)) and (empty($sublink)))
			{
				
				//if ($col >= $pict_show[0])
				//{
					if (empty($show)) { $show = 0;  $j = 1;}
					else { $j = ($show / 3) + 1;}
					$this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id=0', '', 'gall_sort', 'ASC', $show, $pict_show[0]);
					$kol = $this->getdriver()->Count();
					if ($kol != 0)
					{
						echo '<table width="100%" id="gallery" border="0" cellspacing="3" cellpadding="3"><tr>';
						$i = 1; $jj = 0;
						while ($row = $this->getdriver()->FetchResult())
						{
							if (($jj != 0) and ($jj + 1) == $i) $j++; 
							if ($i % 4 != 0) echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td>';
							else if (($i % 4 == 0) and ($i != $pict_show[0])) { $jj = $i; echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td></tr><tr>'; }
							else { $jj = $i; echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td></tr>'; }
							$i++;
						}
						
						echo '</table>';						
					}
					else echo '<div class="message_bad">Фотогалерея в даний момент не доступна. Попробуйте позже.</div>';
				//}	
				//else echo '<div class="message_bad">Фотогалерея в даний момент не доступна. Попробуйте позже.</div>';
			}
			else if ((!empty($link)) and (!empty($sublink)))
			{
					if (empty($show)) { $show = 0;  $j = 1;}
					else { $j = ($show / 3) + 1;}
					$this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id='.$sublink, '', 'gall_sort', 'ASC', $show, $pict_show[1]);
					$kol = $this->getdriver()->Count();
					if ($kol != 0)
					{						
						
						echo '<table width="100%" border="0" id="gallery" cellspacing="3" cellpadding="3"><tr>';
						$i = 1; $jj = 0;
						while ($row = $this->getdriver()->FetchResult())
						{
							if (($jj != 0) and ($jj + 1) == $i) $j++; 
							if ($i % 4 != 0) echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td>';
							else if (($i % 4 == 0) and ($i != $pict_show[0])) { $jj = $i; echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td></tr><tr>'; }
							else { $jj = $i; echo '<td align="center"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="увеличить фото"></a></td></tr>'; }
							$i++;
						}
						
						echo '</table>';
						
					}
					else echo '<div class="message_bad">Фотогалерея в даний момент не доступна. Попробуйте позже.</div>';
				
			}
		}
	}
	
	//Удаление лишних даных с адресной строки переданыхметодом GET
	public function edit_adres($string)
	{
		
		$string = $this->getdriver()->putcontent($string);
		
		$ar = array();
		parse_str($string,$ar);	
		$url = '';
		
		foreach ($ar as $key => $value)
		{
		   $url .= $key.'='.$value.'&';
		}
	 	
	    $amper = strrpos($url,'&');
		$len = strlen($url);
		
		if ($amper == $len-1) $url = substr($url,0,$amper);
		
		return $url;
	
	}
	
	//Процедура для создания ссылок
	public function links($page, $adress, $next, $count_album, $list)
	{
			//$list = 20; // количество елементов на странице
			$ln = 5; // количество ссылок навигатора
			$navi = ''; //ссылки навигации
			
			
			if (empty($page)) $page = 0;
			
			if (empty($next)) $next = 0;
			
			$l = $count_album/$list;
			$count_page_all = round($l);
			
				
			if ($count_album!=0) 
			{
				
				$navi = '<div id="navigation">';
				
					if ($next>=$ln)
					{
						$prev_page = ((($page/$list) - $next) + 1)*$list;
						
						$prev_page = $page - $prev_page; 
						
						$navi .= "&nbsp;&nbsp;<a href = '?".$this->edit_adres($adress."&next=".($next-$ln)."&page=".$prev_page)."'>«</a>&nbsp;&nbsp;";
					}
					
					$n = 0;	
					$i = $next;
					
					$paint = $next + $ln;
							
					for ($i; $i<$paint; $i++)
					{
							
							if (($i*$list) > $count_album) break;
							
							$n = $i+1;
							$z = '';
							if ($n*$list > $count_album) $z = $count_album;
								else $z = $n*$list;
							
							$adress = $this->edit_adres($adress."&page=".($i*$list));
							
							if ($page == ($i*$list))
								$navi .= "&nbsp;&nbsp;<span class='active-links'>".((($n*$list)-$list)+1)."-".$z."</span>&nbsp;&nbsp;|";
								else
								if (((($n*$list)-$list)+1)<= $z )
									$navi .= "&nbsp;&nbsp;<a href = '?".$adress."'>".((($n*$list)-$list)+1)."-".$z."</a>&nbsp;&nbsp;|";
									
									
					}
					
					$adress = $this->edit_adres($adress."&next=".$i."&page=".($i*$list));
		
					if ($paint < $count_page_all) $navi .= "&nbsp;&nbsp;<a href = '?".$adress."'>»</a>&nbsp;&nbsp;";
					
					$navi .= '</div><div class="empty"></div>';
				 
			} else $navi .= '';	
			
			return $navi;
	}
}
?>