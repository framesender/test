<?
class cl_galleria extends cl_db
{
	
	public function ShowGalleryContent($link, $sublink, $page, $next)
	{
		echo '
			<table width="100%" border="0" cellspacing="0" cellpadding="20" style="background:url(images/all_top_bg.jpg) top repeat-x;">
                      <tr>
                        <td height="1000" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                              <tr>
                                <td><h1>Фото</h1></td>
                              </tr>
                              <tr>
                                <td valign="top"><br />
                                  Пленительный голос в сочетании с эффектной внешностью &ndash; гармония таланта, мастерства и красоты в облике Динары Алиевой отнюдь не искусственно сфабрикованная. Будучи многогранной и самодостаточной личностью, эта певица действительно становится незаурядным явлением. Её стиль &ndash; достоинство и искренность</td>
                              </tr>
                              <tr>
                                <td height="8">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="center"><img src="images/separator_main.gif" /></td>
                              </tr>
							  <tr>
                              	<td align="right"><table width="400" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="24" width="7" background="images/left_publ_bar.gif">&nbsp;</td>
                                    <td bgcolor="#ddd8d2" align="center">';
									$submenu = new cl_popmenu();
									$submenu->ShowPopMenu($link, $sublink);
                                    echo '<td width="7" background="images/right_publ_bar.gif">&nbsp;</td>
                                  </tr>
                                </table>
                                </td>
                              </tr>
							  <tr>
                                <td height="48"><span class="sect">'.$submenu->GetName($sublink).'</span></td>
                              </tr>							  
		';
		echo '
			
                            <tr>
                                <td>';
								$this->ShowGalleria($link, $sublink, $page, $next, $this->edit_adres($_SERVER["QUERY_STRING"]));
								echo '
                                </td>
                              </tr>                                                          
                              <tr><td height="20">&nbsp;</td></tr>
                              <tr>
                              	<td align="right"><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="24" width="7" background="images/left_publ_bar.gif">&nbsp;</td>
                                    <td bgcolor="#ddd8d2" align="center">';
									$count_show = $this->ForRead($link, $sublink);
									$count_all = $this->CountImageMenu($link, $sublink);
									echo $this->links($page, $this->edit_adres($_SERVER["QUERY_STRING"]), $next, $count_all, $count_show);
									echo '</td>
                                    <td width="7" background="images/right_publ_bar.gif">&nbsp;</td>
                                  </tr>
                                </table>
                                </td>
                              </tr>                              
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
		';
		
		
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
	
	public function ShowGalleria($link, $sublink, $show, $next, $adress)
	{
		$link = $this->getdriver()->PutContent($link);
		$sublink = $this->getdriver()->PutContent($sublink);
		$next = $this->getdriver()->PutContent($next);
		$page = $this->getdriver()->putcontent($page);
		
		if (empty($show)) $show = 0;
		else $show = $this->getdriver()->PutContent($show);
		//$gall_show = $this->getdriver()->PutContent($gall_show);
		
		
		$this->getdriver()->Select('t_menu', '', 'menu_id='.$link.' and menu_type=4', '', '', '', '', '');
		$k = $this->getdriver()->Count();
		if ($k != 0)
		{
			$pict_show = $this->FileRead('modules/galleria/galleria_config.php');
			$this->getdriver()->Select('t_galleria', '', '', '', '', '', '', '');
			$col = $this->getdriver()->Count();
							
			if ((!empty($link)) and (empty($sublink)))
			{
				
				if ($col >= $pict_show[0])
				{
					if (empty($show)) { $show = 0;  $j = 1;}
					else { $j = ($show / 3) + 1;}
					$this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id=0', '', 'gall_sort', 'ASC', $show, $pict_show[0]);
					//$this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id=0', '', 'gall_sort', 'ASC', '', '');
					$kol = $this->getdriver()->Count();
					if ($kol != 0)
					{
						echo '<table width="100%" id="gallery" border="0" cellspacing="10" cellpadding="0" class="photo_list"><tr>';
						$i = 1; $jj = 0;
						while ($row = $this->getdriver()->FetchResult())
						{
							if (($jj != 0) and ($jj + 1) == $i) $j++; 
							if ($i % 4 != 0) echo '<td align="center"><div class="cell"><a href="../images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="../images/galleria/'.$row['gall_img_s'].'" alt="фото" title="збільшити фото"></a></div></td>';
							else if (($i % 4 == 0) and ($i != $pict_show[0])) { $jj = $i; echo '<td align="center"><div class="cell"><a href="../images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="../images/galleria/'.$row['gall_img_s'].'" alt="фото" title="збільшити фото"></a></div></td></tr><tr>'; }
							else { $jj = $i; echo '<td align="center"><div class="cell"><a href="../images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="../images/galleria/'.$row['gall_img_s'].'" alt="фото" title="збільшити фото"></a></div></td></tr>'; }
							$i++;
						}
						
						echo '</table>';
						
						//
						
					}
					else echo '<h2>Не має фото для показу</h2>';
				}	
				else echo '<h2>Фотогалерея в даний момент не доступна. Спробуйте пізніше</h2>';
			}
			else if ((!empty($link)) and (!empty($sublink)))
			{
					if (empty($show)) { $show = 0;  $j = 1;}
					else { $j = ($show / 3) + 1;}
					$this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id='.$sublink, '', 'gall_sort', 'ASC', $show, $pict_show[1]);
					//$this->getdriver()->Select('t_galleria', '', 'gall_menu_id='.$link.' and gall_popmenu_id='.$sublink, '', 'gall_sort', 'ASC', '', '');
					$kol = $this->getdriver()->Count();
					if ($kol != 0)
					{						
						
						echo '<table width="100%" border="0" id="gallery" cellspacing="10" cellpadding="0" class="photo_list"><tr>';
						$i = 1; $jj = 0;
						while ($row = $this->getdriver()->FetchResult())
						{
							if (($jj != 0) and ($jj + 1) == $i) $j++; 
							if ($i % 4 != 0) echo '<td align="center"><div class="cell"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="збільшити фото"></a></div></td>';
							else if (($i % 4 == 0) and ($i != $pict_show[0])) { $jj = $i; echo '<td align="center"><div class="cell"><a href="../images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="збільшити фото"></a></div></td></tr><tr>'; }
							else { $jj = $i; echo '<td align="center"><div class="cell"><a href="images/galleria/'.$row['gall_img_b'].'" title="'.stripslashes($row['gall_description']).'"><img src="images/galleria/'.$row['gall_img_s'].'" alt="фото" title="збільшити фото"></a></div></td></tr>'; }
							$i++;
						}
						
						echo '</table>';
						
						//
						
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