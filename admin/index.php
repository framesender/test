<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>CMS</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../includes/css/main.css" />
</head>
<body>
<div id="page">
	<?
		//system('locale -a');
	?>
		<div class="forsit"><img src="../includes/img/it/logo-enter.gif" width="163" height="45" alt=""></div>
		<div>
		<div><? if  ($_SESSION["ban"] > 0) echo "<div id='pass_error'>Неверное имя пользователя или пароль </div>" ;?></div>
			<div class="main_form"><form method="post" action="check.php">
				<div>Логин:</div>
				<div><input type="text" name="login" value="" /></div>
				<div>Пароль:</div>
				<div><input type="password" name="pass" value="" /></div>
				<div>
				<?
				if  ($_SESSION["ban"] >= 4)
				{ 
				//set settings for captcha
				$_SESSION['captha_conf'] = '/kcaptcha_config_login.php';
				
				echo '<div id="captcha_msg">Введите код на рисунке*:<br> <span class="kcaptcha"><img src="../includes/kcaptcha/index.php?'.session_name().'='.session_id().'" alt="капча" title="капча" /></span> <div class="small"><input class="small" type="text" value="" name="key_captcha" size="20" /></div></div>';
				}
				?>
								
				</div>
				<div><button type="submit"><img src="../includes/img/it/button-enter.gif" alt="" /></button></div>
				
			</form>
			</div>
			
		</div>
		<div class="f"><img src="../includes/img/it/f-enter.gif" width="70" height="163" alt=""></div>
		
	<br />
	<br />
	<br />
	
		<div class="blue_footer">&nbsp;</div>
</div>
</body>
</html>