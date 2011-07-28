<?
	include_once("../core/core.php");
?>
<td valign="top" align="left">
	
	<div class="main">
		<div class="patch">
			<div class="patch2"><a style="color:#ffffff; text-decoration: underline;" href="main.php">Главная страница</a><? echo " - ".$_GET["titlem"]; ?></div>
		</div>
		
		<div class="main_content">
		
<?
	/* ---------------------------------- здесь подключаем нужные файлы модулей, в зависимости от выбраного модуля --------------------------- */
	$m1->SelectListModules('list_mod','');
	$bool = false;
	while ($row = $m1->getdriver()->FetchResult())
	{
		$src = $m1->getdriver()->Strip($row["src_list_mod"]);
		if ($_GET["namem"] == $src)
		{
			include_once("../modules/".$src."/index.php");
			$bool = true;
		}
	}
	if ($bool == false)
	{
		echo "<div style='margin: 10px; '>
				<span style='font-size: 21px; color: #4a9db8;'>" .$_SESSION['u_name'].", добро пожаловать в систему управления сайтом!</span><br /><br />
				<span style='color: #444; font-size: 14px;'>Для работы воспользуйтесь меню, рaсположенным на левой панели.</span>
			  </div>";  
	}
	
		/* echo '<div id="example">
				    <a id="a1" href="#">Выполнить Ajax-запрос</a><span id="loading">Выполняется Ajax-запрос...</span>
				    <span id="message">Ajax-запрос выполнен.</span>
				</div>'; */
?>


		</div><!-- /main_content -->
		
	</div><!-- /main -->
	
	</td></tr>
	</table>
	
<?
	include_once("../includes/inc_footer.php");
?>