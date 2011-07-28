<?
class cl_responce extends cl_db
{	
	private $url = "main.php?namem=responce&&titlem=Отзывы"; // не изменять параметры
	
	//Деструктор класа, который закрывает соединение с БД
	function __destruct()
	{
		$this->getdriver()->Disconnect();
	}
        
	//Выполня запрос на выборку, которому передаем название таблицы, условие отбора, номер записи от которой ведется отсчет (начиная с 0), количество записей
	public function SelectResponce($table_names, $cond_names, $limit_from, $limit_count)
	{
		if (!empty($table_names))
		{
			$field_names = 'responce_id, responce_user, responce_text, responce_date, responce_status';
			$group_names = '';
			$ord_names = 'responce_id';
			$ord_types = 'DESC';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку новостей");
	}
	
	public function ShowResponces($link)
	{
		$field_names = '';
		$cond_names = 'responce_status=1';
		$group_names = '';
		$ord_names = '';
		$ord_types = '';
		$limit_from = '';
		$limit_count = '';
		
		$this->getdriver()->Select('t_menu', '', 'menu_id='.$link.' and menu_type=7', '', '', '', '', '');
		$k = $this->getdriver()->Count();
		if ($k != 0)
		{
			echo '
				<table width="100%" border="0" cellspacing="0" cellpadding="20" style="background:url(images/all_top_bg.jpg) top repeat-x;">
                      <tr>
                        <td height="1679" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
                          <tr>
                            <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                              <tr>
                                <td><h1>Отзывы</h1></td>
                              </tr>
                              <tr>
                                <td valign="top"><br />
                                  Знатоки музыкального искусства, мастера оперного пения и самая взыскательная публика России, США, Италии, Германии и многих других стран мира называют талант Динары Алиевой уникальным и расценивают её голос, как неповторимое явление. Этот голос &ndash; редкостный дар.</td>
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
                                    <td width="112" bgcolor="#ddd8d2" align="center"><a href="#Stars">Звезды</a> | <a href="#Public">Публика</a></td>
                                    <td width="7" background="images/right_publ_bar.gif">&nbsp;</td>
                                  </tr>
                                </table>
                                </td>
                              </tr>
                               <tr>                                
                                <td height="48"><a id="Stars"></a><span class="sect">Звезды</span></td>
                              </tr>
                              <tr>
                                <td><table id="gallery" width="100%" border="0" cellspacing="10" cellpadding="0" class="zvezd_list">
                                  <tr>
                                    <td><a href="/images/stars/monserat.jpg" title="<b>Монсеррат Кабалье</b><br>
Это – чудо! Динара Алиева – талант от Бога, мне нечему её научить, она – певица, которой всё дано свыше.<br><br>"><img src="images/zv1.jpg"/></a><br><br><span class="zvezd_title">Монсеррат Кабалье</span></td>
                                    <td><a href="/images/stars/tereza.jpg" title="<b>Тереза Берганца</b><br>Динара Алиева – уникальное явление, блистательный сплав могучего голоса, темперамента и артистизма. У неё огромное будущее!<br><br>"><img  src="images/zv2.jpg"/></a><br><br><span class="zvezd_title">Тереза Берганца</span></td>
                                    <td><a href="/images/stars/muslim.jpg" title="<b>Муслим Магомаев</b><br>
Однажды один бакинский журналист меня спросил: в чьих руках будущее азербайджанского искусства, кто своим мастерством и высоким исполнительским уровнем соответствует стандартам экстра-класса, чтобы представлять азербайджанскую культуру на мировом уровне?.. Без сомнения, всем этим высоким критериям соответствует молодая оперная певица Динара Алиева, которая своим талантом и мастерством прославит наше отечество на весь мир. А её красота и невероятный темперамент покорит любую публику!<br><br>"><img src="images/zv3.jpg"/></a><br><br><span class="zvezd_title">Муслим Магомаев</span></td>
                                    <td><a href="/images/stars/obrazcova.jpg" title="<b>Елена Образцова</b><br>
Её голос – прекрасный, богатый нюансами и восхитительным разнообразием тембров инструмент, заслуживающий самых высоких оценок!<br><br>"><img src="images/zv4.jpg"/></a><br><br><span class="zvezd_title">Елена Образцова</span></td>
                                  </tr>
                                  <tr><td class="separ" colspan="4"></td></tr>
                                  <tr>
                                    <td><a href="/images/stars/termikanov.jpg" title="<b>Юрий Темирканов</b><br>
Выступать с такой чуткой, тонко чувствующей музыку певицей – удовольствие для дирижера, а сильный и выразительный голос этой певицы словно создан для обрамления симфоническим звучанием.<br><br>
"><img src="images/zv5.jpg"/></a><br><br><span class="zvezd_title">Юрий Темирканов</span></td>
                                    <td><a href="/images/stars/kasrashvili.jpg" title="<b>Маквала Касрашвили</b><br>Динара Алиева наследует лучшие традиции отечественной оперной школы. Её пение отражает всё лучшее, что достигнуто нашим оперным искусством, а её мастерство достойнейшим образом представляет высокую планку российской оперы на мировых сценах.<br><br>"><img src="images/zv6.jpg"/></a><br><br><span class="zvezd_title">Маквала Касрашвили</span></td>
                                    <td><a href="/images/stars/mastranzhello.jpg" title="<b>Фабио Мастранжелло</b><br>Встречи с артистами, для которых концерты – не работа, не дежурная обязанность, а служение высокому искусству – редкость в наше время. К таким редким исключениям принадлежит Динара Алиева. Выступая с ней, получаешь заряд жизнелюбия и оптимизма. Спасибо Динаре и за её искусство, и за ту положительную энергетику, которую она дарит всем окружающим.<br><br>"><img src="images/zv11.jpg"/></a><br><br><span class="zvezd_title">Фабио Мастранжелло</span></td>
                                    </td>
                                    <td><a href="/images/stars/voronova.jpg" title="<b>Иветта Воронова</b><br>Президент Фонда \'Новые имена\', Заслуженный деятель искусств Российской Федерации. Появление Динары Алиевой на исполнительском горизонте для широкой аудитории было практически внезапным – столь стремительно поразила она москвичей в течении всего лишь одного сезона, в 2007-м году, целой серией концертов в лучших залах и с лучшими коллективами и дирижерами столицы. Затем последовали столь же успешные дебюты в Санкт-Петербурге, на крупнейших сценах Нью-Йорка, Парижа, Мюнхена... Но в фонде \'Новые имена\' давно знали о таланте Динары и стремились всячески поддержать молодую артистку. Она наделена большим талантом, прекрасным, красивейшим голосом и редким человеческим достоинством, позволяющим ей развиваться и совершенствоваться не только профессионально но и в личностном плане. Всегда была уверена, что благодаря такому сплаву качеств Динару ждет большой успех, а сейчас, когда певица достигла первых высот, желаю, чтобы за этими достижениями следовали всё новые и новые, и Динара не переставала радовать, удивлять, покорять и восхищать слушателей.<br><br>"><img src="images/zv8.jpg"/></a><br><br><span class="zvezd_title">Иветта Воронова</span></td>
                                  </tr>
                                  <tr><td class="separ" colspan="4"></td></tr>
                                  <tr>
                                    <td><a href="/images/stars/popov.jpg" title="<b>Виктор Попов</b><br> В августе 2008-го* в Большом зале консерватории состоялся большой концерт Академии хорового искусства. Исполнялась разная музыка, а в завершении, по моему замыслу, должно было прозвучать нечто особенное. Выбрав «Ave Maria» Каччини – эту возвышенную, поистине неземную прекрасную мелодию, я практически сразу остановил свой выбор на Динаре Алиевой в качестве солистки – её красивый, сильный и вместе с тем гибкий голос как нельзя лучше подходит для исполнения самого проникновенного сопранового репертуара. И результат превзошел самые смелые ожидания: после одухотворённого, виртуозно спетого словно на едином дыхании, следующего малейшим нюансам партитуры исполнения зал взорвался аплодисментами. После этого я, поздравляя молодую певицу, с уверенностью констатировал: «Да, эту артистку ждёт большое будущее, она будет петь на лучших сценах мира!»

* Этот концерт стал последним выступлением Академии хорового искусства, которым дирижировал её основатель Виктор Сергеевич Попов<br><br>"><img src="images/zv9.jpg"/></a><br><br><span class="zvezd_title">Виктор Попов</span></td>
                                    <td><a href="/images/stars/macuev.jpg" title="<b>Денис Мацуев</b><br>Каждый раз выступая с Динарой Алиевой – будь то Иркутск, Москва или Париж, - я удивлялся самоотдаче, искренности и естественности, с которой певица проводит свои выступления. С Динарой невероятно приятно работать, но помимо прекрасных человеческих качеств, она наделена восхитительным талантом и артистизмом. А благодаря насыщенности тембра и широте диапазона голоса и еще одним редким качеством – способностью петь самый разный репертуар, от барокко до джаза. Эта универсальность дополняется умением певицы мгновенно перевоплощаться от одного образа к другому, что делает каждое концертное выступление Динары захватывающим и незабываемым.<br><br>"><img src="images/zv10.jpg"/></a><br><br><span class="zvezd_title">Денис Мацуев</span></td>
                                    
                                  </tr>
                                </table>
                                </td>
                              </tr>                              
                              <tr>
                              	<td>
                                	<br><br><a id="Public"></a><span class="sect">Публика<br><br></span>
                                </td>
                              </tr>
							  <tr>
                              	<td>
                                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      
			';
			
			
			$this->getdriver()->Select('t_responce', $field_names, $cond_names, $group_names, 'responce_date', 'DESC', $limit_from, $limit_count);
			while ($row = $this->getdriver()->FetchResult())
			{
			    
				$usr = explode(';', $this->getdriver()->Strip($row['responce_user']));
				
				echo '
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="10" cellpadding="0">
							  <tr>
								<td class="feed_name">'.$usr[0].'<span class="feed_name">
								&nbsp;&nbsp;'. $usr[1].'</span></td>
								<td class="feed_date">'.date("d.m.Y", $row['responce_date']).'</td>
							  </tr>
							  <tr>
								<td colspan="3"><hr>
									'.stripslashes($row['responce_text']).' 
								</td>                                        
							  </tr>
							</table>
						</td>
					  </tr>
				';				
			}
			echo '
				</table>
                                </td>
                              </tr>
							  <tr><td>&nbsp;</td></tr>
                              <tr>
                                <td>';
								if ($_GET['action']=='ok') echo '<div class="message_good">Ваш отзыв добавлен</div>';
									else if ($_GET['action']=='no') echo '<div class="message_bad">Ваш отзыв не добавлен</div>';
										else if ($_GET['action']=='bad') echo '<div class="message_bad">Необходимые поля не заполнены!</div>';
								echo '								
                                	<span class="sect">Отправьте отзыв</span>
                                </td>
                              </tr>
                              <tr>
                              	<td><form method="post" action="modules/responce/add_responce.php">
									<input type="hidden" name="link" value="'.$_SERVER['QUERY_STRING'].'" />
                                	<table width="405" border="0" cellspacing="10" cellpadding="5">
                                      <tr>
                                        <td width="35%" class="conact_fields">Имя *</td>
                                        <td width="65%"><input name="name" style="width:235px; border:#d9d5ce 1px solid;" type="text"></td>
                                      </tr>
                                      <tr>
                                        <td width="35%" class="conact_fields">Профессия</td>
                                        <td width="65%"><input name="prof" style="width:235px; border:#d9d5ce 1px solid;" type="text"></td>
                                      </tr>
                                      
                                        <td width="35%" valign="top" class="conact_fields">Сообщение *</td>
                                        <td width="65%"><textarea style="width:235px; border:#d9d5ce 1px solid;" name="msg" rows="5"></textarea></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="right"><input type="image" name="send_btn" src="images/send_btn.gif"/></td>
                                      </tr>
                                    </table>									
									</form>
                                </td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
			';
		}
	}
	
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertResponce($table_names, $list_values)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "responce_user, responce_text, responce_date, responce_status";
			preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[2], $match); //для проверки корректности даты
			
			$arr_date = explode('-',$list_values[2]);
			$d = $arr_date[0];		 
			$m = $arr_date[1];  
			$y = $arr_date[2];
			
			if (!empty($match[0]))
			{
				if (($d > 0) && ($d <= 31))
				{
					if (($m > 0) && ($m <= 12))
					{
						$list_values[2] = mktime(0,0,0,$m,$d,$y);
						
						for($i=0; $i<count($list_values); $i++)
						{
							$list = implode(", ", $list_values);
						}
						$this->getdriver()->Insert($table_names, $field_names, $list);
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на добавление не выполнен!</div>";
						else echo "<h3><div class='sms_succses'>Новость 
						<span class='title_name'>".$list_values[1]."</span> успешно добавлена!</div></h3>";			
					} 
					else 
					{ 
						echo "<br /><div class='sms_error'>Неверный формат даты: неверный месяц!</div>"; 
						echo "<a href='".$this->url."'><< вернуться</a>"; 
					}
				} 
				else 
				{ 
					echo "<br /><div class='sms_error'>Неверный формат даты: неверный день!</div>"; 
					echo "<a href='".$this->url."'><< вернуться</a>"; 
				}
			} 
			else 
			{ 
				echo "<br /><div class='sms_error'>Неверный формат даты!</div>"; 
				echo "<a href='".$this->url."'><< вернуться</a>"; 
			}
		}
		else die("<br> Не могу выполнить запрос на добавление отзыва");
	}
	
	//Выполня запрос на удаление, первый параметр - название таблицы, второй - масив id-шек записей которих надо удалить
	public function DeleteResponce($table_names, $list)
	{
		if (!empty($table_names) && !empty($list))
		{
			$cond_names = '';
			for($i=0; $i<count($list); $i++)
			{
				$cond_names = '';
				$cond_names.=' responce_id='.$list[$i];
				$this->getdriver()->Delete($table_names, $cond_names);
				
				$k = $this->getdriver()->Result();
				if ($k == 0) echo "<br /><div class='sms_error'>Запрос на удаление не выполнен!</div>";
				else echo "<h3><div class='sms_succses'>Отзыв <span class='title_name'>№".$list[$i]."</span> успешно удалена!</div></h3>";
			}	
		}
		else die("Не могу выполнить запрос на удаление новостей");
	}
	
	//Метод редактирует в таблице значение полей, первый параметр - название таблицы, второй - значение полей, третий - по какому условию
	public function UpdateResponce($table_names, $list_values, $cond_names)
	{
		if (!empty($table_names) && !empty($list_values))
		{
			$field_names = "responce_user, responce_text, responce_date, responce_status";
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
						$this->getdriver()->Update($table_names, $field_names, $list_values, $cond_names);
						
						$k = $this->getdriver()->Result();
						if ($k == 0) echo "<br /><div class='sms_error'>Запрос на редактирование не выполнен!</div>";
						else echo "<h3><div class='sms_succses'>Отзыв 
						<span class='title_name'>".$list_values[0]."</span> успешно изменен!</div></h3>";			
					} 
					else 
					{ 
						echo "<br /><div class='sms_error'>Неверный формат даты: неверный месяц!</div>"; 
						echo "<a href='".$this->url."'><< вернуться</a>"; 
					}
				} 
				else 
				{ 
					echo "<br /><div class='sms_error'>Неверный формат даты: неверный день!</div>"; 
					echo "<a href='".$this->url."'><< вернуться</a>"; 
				}
			} 
			else 
			{ 
				echo "<br /><div class='sms_error'>Неверный формат даты!</div>"; 
				echo "<a href='".$this->url."'><< вернуться</a>"; 
			}
		}
		else die("<br> Не могу выполнить запрос на редактирование новостей");
	}

	private function Utf8ToWin($fcontents) {
            $out = $c1 = '';
            $byte2 = false;
            for ($c = 0;$c < strlen($fcontents);$c++) {
                $i = ord($fcontents[$c]);
                if ($i <= 127) {
                    $out .= $fcontents[$c];
                }
                if ($byte2) {
                    $new_c2 = ($c1 & 3) * 64 + ($i & 63);
                    $new_c1 = ($c1 >> 2) & 5;
                    $new_i = $new_c1 * 256 + $new_c2;
                    if ($new_i == 1025) {
                        $out_i = 168;
                    } else {
                        if ($new_i == 1105) {
                            $out_i = 184;
                        } else {
                            $out_i = $new_i - 848;
                        }
                    }
                    // UKRAINIAN fix
                    switch ($out_i){
                        case 262: $out_i=179;break;// і
                        case 182: $out_i=178;break;// І 
                        case 260: $out_i=186;break;// є
                        case 180: $out_i=170;break;// Є
                        case 263: $out_i=191;break;// ї
                        case 183: $out_i=175;break;// Ї
                        case 321: $out_i=180;break;// ґ
                        case 320: $out_i=165;break;// Ґ
                    }
                    $out .= chr($out_i);
                    
                    $byte2 = false;
                }
                if ( ( $i >> 5) == 6) {
                    $c1 = $i;
                    $byte2 = true;
                }
            }
            return $out;
        }
        
	public function outAddResponce($user, $date, $text, $captcha) {
		
		if (empty($captcha))
		{	
			$this->outAddResponceError('введите код');
			return;
		}
		if (!isset($_SESSION['captcha_keystring']) or ($captcha != $_SESSION['captcha_keystring']))
		{
			$this->outAddResponceError('неверный код');
			return;
		}
		
		if (($user != '') && ($text != '') && ($date != '') && ($date != 'dd-mm-yyyy'))
		{
			$user = "'".$this->Utf8ToWin($user)."'";	$text = "'".$this->Utf8ToWin($text)."'";
			$insert = array($user, $text, $date);
			$this->InsertResponceSilent('t_responce', $insert);
		} else {
			$this->outAddResponceError();
		}		
	}
	
	public function outAddResponceError( $errorText = '' ) {
		echo ('<div class="searchform-close">
			<div class="searchform-header"><img src="img/info.jpg" /> Извините!</div><br />
			<div class="searchform-text">Запрос на добавление не выполнен!  '.$errorText); echo ('</div>
			<div class="follow" id="follow"></div>
			<div class="follow" ><a href="#"><img src="img/close-button-resp.gif" alt="Закрыть" /></a></div>
			</div>');
	}
	
	public function outAddResponceFine( $argText = '' ) {
		echo ('<div class="searchform-close">
			<div class="searchform-header"><img src="img/info.jpg" /> Спасибо.</div><br />
			<div class="searchform-text">Ваш отзыв добавлен.'.$argText); echo ('</div>
			<div class="follow" id="follow"></div>
			<div class="follow" ><a href="#"><img src="img/close-button-resp.gif" alt="Закрыть" /></a></div>
			</div>');
	}	
	
	//Метод вставляет в таблицу поля, первый параметр - название таблицы, второй - значение полей
	public function InsertResponceSilent($table_names, $list_values)
	{
			$field_names = "responce_user, responce_text, responce_date";
			preg_match("/^\d{2}-\d{2}-\d{4}$/", $list_values[2], $match); //для проверки корректности даты
			
			$arr_date = explode('-',$list_values[2]);
			$d = $arr_date[0];		 
			$m = $arr_date[1];  
			$y = $arr_date[2];
			
			$list_values[2] = mktime(0,0,0,$m,$d,$y);
			
			for($i=0; $i<count($list_values); $i++)
			{
				$list = implode(", ", $list_values);
			}
			
			$this->getdriver()->Insert($table_names, $field_names, $list);
	}
}
?>