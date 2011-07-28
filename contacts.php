<?php

echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
            <h1>Контакты</h1>
			<h2>+38 097 364 3 776</h2>
			'.$this->ShowContactsInfo();
            
            $_SESSION['captha_conf'] = '/kcaptcha_config.php';     
            echo '<form name="contact" action="includes/mailer/SendMail.php" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3">';
                
                if (isset ($_GET['OK'])) echo '<div class="message_good">Ваше сообщение успешно отправлено!</div>';
				if (isset ($_GET['n_OK'])) echo '<div class="message_bad">Ваше сообщение не отправлено!</div>';
				if (isset($_GET['n_name']))
					{
						echo('<div class="message_bad">(!) введите имя!</div>');
					}
				   if (isset($_GET['n_mail']))
						{
							echo('<div class="message_bad">(!) введите email!</div>');
						}
							elseif (isset($_GET['nc_mail']))
						{
							echo('<div class="message_bad">(!) email некоректный!</div>');
						}
				        if (isset($_GET['n_txt']))
						{
							echo('<div class="message_bad">(!) введите текст!</div>');
						}else	
                        if (isset($_GET['nc_cap']))
						{
							echo('<div class="message_bad">(!) капча введена неверно!</div>');
						}	

                        
                echo '</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="2" width="170px;">';
                
                $menu = new cl_menu();
				$menu->SelectMenu('t_menu', 'menu_id='.$link.' and menu_type=3', '', '');
				$row = $menu->getdriver()->FetchResult();
				echo '<input type="hidden" value="link='.$row["menu_id"].'" name="link" />';
                
                
                echo '<div style="float:right;"> 
                    <div style="margin-bottom: 4px;">
                    имя*<br />
                    <input size="35" type="text" name="firstN" value="'.$_SESSION['firstN'].'" /><br />
                    </div>
                    <div style="margin-bottom: 4px;">
                    фамилия*<br />
                    <input size="35" type="text" name="lastN" value="'.$_SESSION['lastN'].'" /><br />
                    </div>
                    <div style="margin-bottom: 4px;">
                    email*<br />
                    <input size="35" type="text" name="email" value="'.$_SESSION['email'].'" /><br />
                    </div>  	
          		  </div>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                 <br />
                 Ваше письмо*:<br />
                  <textarea rows="10" style="width:99%;" name="letter">'.trim($_SESSION['letter']).'</textarea>
                </td>

              </tr>
              <tr>
              <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td valign="bottom">';
                echo '<img src="includes/kcaptcha/index.php?'.session_name().'='.session_id().'" alt="капча" title="капча" />'; 
                echo '</td>
                <td style="padding:0 3px;">
                введите символы:<br />
                <input class="contact_input" size="20" type="text" name="key_captcha" value=""/>
                </td>
                <td align="center" valign="bottom">
                <div style="padding-bottom: 5px;">
                <input class="contact_input" type="image" src="images/send.gif"/>
                </div>
                </td>
              </tr>
            </table>

            </form>
            
            
            </td>
           </tr>
        </table>
    ';


?>