<?php

 class cl_records extends cl_db{
    
     public function ShowRand(){
        $this->getdriver()->ExecQuery("SELECT * FROM t_record WHERE type=1 AND lft=1 LIMIT 1;");                
        $res = $this->getdriver()->FetchResult();
        $vdata = explode('^', $res['name']); 
        return '
        	        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td style="padding:10px 0px 8px 8px;"><h2>Видео:</h2></td>
                          </tr>
                          <tr>
                            <td align="center"><div style="overflow:hidden; width:306px; position:relative; z-index:1000;">'.$res['link'].'</div></td>
                          </tr>
                          <tr>
                            <td>
                            	<table width="100%" border="0" cellspacing="10" cellpadding="0">
                                  <tr>
                                    <td><span style="font-size:14px;">'.$vdata[0].'</span></td>
                                  </tr>
                                  <tr>
                                    <td><span style="color:#999; font-size:12px;">'.$vdata[1].'</span></td>
                                  </tr>                                  
                                </table>
								<img src="images/separator.jpg">
                            </td>
                          </tr>
                        </table>
            ';
        
     }
     
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
			if ($list == '') $list = 20; // количество елементов на странице
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
    
 //------------------------------------------------------------------------------    
     public function ShowRecords($link, $video_id, $page, $next){
        $adress = $this->edit_adres($_SERVER["QUERY_STRING"]);
        
        $this->getdriver()->Select('t_menu', '', 'menu_id='.$link.' and menu_type=8', '', '', '', '', '');
		$k = $this->getdriver()->Count();
		if ($k != 0)
		{ 
        $ret = '
            <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background:url(images/all_top_bg.jpg) top repeat-x;">
                      <tr>
                        <td valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                              <tr>
                                <td><h1>Записи</h1></td>
                              </tr>
                              <tr>
                                <td valign="top"><br />
                                  Голос Динары Алиевой переливается, покоряя кристальной чистотой и завораживая нежным бархатом тембра. Но в каждой работе она стремится экспериментировать, и это неудержимое стремление к новому &ndash; редкий дар, свойственный первооткрывателям, двигающим прогресс и остающимся в истории. Динаре Алиевой свойственна смелость и постоянный творческий поиск.</td>
                              </tr>
                              <tr>
                                <td height="8">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="center"><img src="images/separator_main.gif" /></td>
                              </tr>                             
                              <tr>
                              	<td align="right"><table width="126" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="24" width="7" background="images/left_publ_bar.gif">&nbsp;</td>
                                    <td width="112" bgcolor="#ddd8d2" align="center"><a href="#audio">Аудио</a> | <a href="#video">Видео</a></td>
                                    <td width="7" background="images/right_publ_bar.gif">&nbsp;</td>
                                  </tr>
                                </table>
                                </td>
                              </tr>
                               <tr>
                                <td height="48"><a id="video"></a><span class="sect">Видео</span></td>
                              </tr>

        ';
        
        if ($video_id) {
            $this->getdriver()->ExecQuery("SELECT link FROM t_record WHERE id=".$video_id);
            if ($this->getdriver()->Count()) { $rs = $this->getdriver()->FetchResult(); 
            $ret.='
                <tr><td align="center">'.$rs['link'].'</td></tr>
            ';    }
        }
        
        
        $ret.= '
            
                              
                              <tr>
                              	<td height="35">&nbsp;</td>
                              </tr>
                              <tr>
                                <td><table width="100%" border="0" cellspacing="10" cellpadding="0" class="vid_list">';
                                
                    $this->getdriver()->Select('t_record', '', 'type=1', '', '', '', '', '');
					$kol = $this->getdriver()->Count();
                    
                    $kol_to_show = 16;
                    $this->getdriver()->Select('t_record', '', 'type=1', '', '', '', $page, $kol_to_show);
					if ($kol != 0)
					{
						$jj = 1;
						while ($row = $this->getdriver()->FetchResult())
						{
                            $names = explode('^', $row['name']);
							
                            
                            if ($jj % 4 == 1) $ret.='<tr><td><a href="index.php?'.$adress.'&video_id='.$row['id'].'"><img src="/files/images/records/'.$row['img'].'"/></a><br><br><span class="vdezd_title"></span>'.$names[0].'<br>'.$names[1].'</td>';
							if ($jj % 4 > 1) $ret .= '
                                    <td><a href="index.php?'.$adress.'&video_id='.$row['id'].'"><img src="/files/images/records/'.$row['img'].'"/></a><br><br><span class="vdezd_title"></span>'.$names[0].'<br>'.$names[1].'</td>';
							
                            if ($jj % 4 == 0) $ret.='<td><a href="index.php?'.$adress.'&video_id='.$row['id'].'"><img src="/files/images/records/'.$row['img'].'"/></a><br><br><span class="vdezd_title"></span>'.$names[0].'<br>'.$names[1].'</td></tr><tr><th class="separ" colspan="4"></th></tr>';
                           
                                  $jj++;
						}	
					}
                   
                                    
                                  
                                                                     
                               $ret .= '</table></td>
                              </tr><tr><th align = "right">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <th height="24" width="7" background="images/left_publ_bar.gif">&nbsp;</th>
                                                <th bgcolor="#ddd8d2" align="center">
                                                '.$this->links($page, $this->edit_adres($_SERVER["QUERY_STRING"]), $next, $kol, $kol_to_show).'
                                            </th>
                                                <th width="7" background="images/right_publ_bar.gif">&nbsp;</th>
                                              </tr>
                                            </table>
                               </th></tr>
                               
                                                              
                              <tr>
                              	<td>
                                	<br><br><a id="audio"></a><span class="sect">Аудио<br><br></span>
                                </td>
                              </tr>
                              <tr>
                              	<td>
                                	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="audio_list">
                                    '; 
                                    $this->getdriver()->Select('t_record', '', 'type=2', '', '', '', '', '');
					                $kol = $this->getdriver()->Count();
                                    if ($kol) {
                                      while ($row = $this->getdriver()->FetchResult())
                                        {
                                            $names = explode('^', htmlspecialchars($this->getdriver()->Strip($row['name'])));
                                            $ret .= '
                                                  <tr>
                                                    <td>'.$names[1].'&nbsp;'.$names[0].'</td>
                                                    <td width="30"><img style="cursor:pointer;" src = "/images/play.gif" onClick="open_wnd(\'/play.php?song='.$row['link'].'&artist='.$names[1].'&title='.$names[0].'\');"></td>
                                                  </tr> ';
                                        }      
                                      }
                                    
                                      
                                      
                                      $ret .= '                                     
                                    </table>
                                    <script language="javascript">
                                        function open_wnd(vr){
                                                window.open(vr,
                                                                       "INFO",
                                                                    "width=310,height=115,toolbar=no");
                                            }
                                    </script>
                                </td>
                              </tr>
                              
                              
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
        ';
        }
        return $ret;
     }          
 }
 

?>