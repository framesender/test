<?php
 class cl_navigation extends cl_db
 {
	//Деструктор класа, который закрывает соединение с БД
	public function __destruct()
	{
		$this->getdriver()->Disconnect();
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
	
		//Процедура для створення ссылок
	public function links ($page, $adress, $next,  $count_album)
	{
		if ($list=='') $list = 20; // количество альбомов на странице
		$ln = 10; // количкство ссылок навигатора
		$navi = ''; //ссылки навигации
		
		$page = $this->getdriver()->putcontent($page);
		
		
		$l = $count_album/$list;
		$count_page_all = round($l);
		
			
		if ($count_album!=0) 
		{
			$navi .= "<b>Отображать:</b>&nbsp;";
		
		
				if ($next>=$ln)
				{
					$prev_page = ((($page/$list) - $next) + 1)*$list;
					
					$prev_page = $page - $prev_page; 
					
					$navi .= "&nbsp;<a href = '?".$this->edit_adres($adress."&next=".($next-$ln)."&page=".$prev_page)."'><<</a>&nbsp;";
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
						if ($page == ($i*$list)) $navi .= "&nbsp;<span class = 'active-links'>[".((($n*$list)-$list)+1)."-".$z."]</span>&nbsp;";
							else						
							
							if (((($n*$list)-$list)+1)<= $z )
								$navi .= "&nbsp;<a href = '?".$adress."'>".((($n*$list)-$list)+1)."-".$z."</a>&nbsp;";
								
				}
				
				$adress = $this->edit_adres($adress."&next=".$i."&page=".($i*$list));
	
				if ($paint < $count_page_all) $navi .= "&nbsp;<a href = '?".$adress."'>>></a>&nbsp;";
			 
		} else $navi .= "<b>Отображать:</b>&nbsp;[0-0]"; 
		$navi .= "";	
		
		return $navi;
	}

	//Процедура для створення ссылок
	public function links_s ($page, $adress, $next, $list, $count_album)
	{
		if ($list=='') $list = 20; // количество альбомов на странице
		$ln = 10; // количкство ссылок навигатора
		$navi = ''; //ссылки навигации
		
		$page = $this->getdriver()->putcontent($page);
		
		
		$l = $count_album/$list;
		$count_page_all = round($l);
		
			
		if ($count_album!=0) 
		{
			$navi .= "<b>Отображать:</b>&nbsp;";
		
		
				if ($next>=$ln)
				{
					$prev_page = ((($page/$list) - $next) + 1)*$list;
					
					$prev_page = $page - $prev_page; 
					
					$navi .= "&nbsp;<a href = '?".$this->edit_adres($adress."&next=".($next-$ln)."&page=".$prev_page)."'><<</a>&nbsp;";
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
						if ($page == ($i*$list)) $navi .= "&nbsp;<span class = 'active-links'>[".((($n*$list)-$list)+1)."-".$z."]</span>&nbsp;";
							else						
							
							if (((($n*$list)-$list)+1)<= $z )
								$navi .= "&nbsp;<a href = '?".$adress."'>".((($n*$list)-$list)+1)."-".$z."</a>&nbsp;";
								
				}
				
				$adress = $this->edit_adres($adress."&next=".$i."&page=".($i*$list));
	
				if ($paint < $count_page_all) $navi .= "&nbsp;<a href = '?".$adress."'>>></a>&nbsp;";
			 
		} else $navi .= "<b>Отображать:</b>&nbsp;[0-0]"; 
		$navi .= "";	
		
		return $navi;
	}
	
 } 
?>