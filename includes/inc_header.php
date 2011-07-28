<?
include_once("../core/cl_authorization.php");
$auth = new cl_authorization();
$auth -> authorize();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>CMS</title>
  <link rel="stylesheet" type="text/css" href="../includes/css/style.css" />
  <link rel="stylesheet" type="text/css" href="../includes/css/tablesorter.css" />
  <link rel="stylesheet" type="text/css" href="../includes/datatables/datatables.css" /> 
  <script src="../includes/scripts/jquery/jquery.js" type="text/javascript"></script>
  <style type="text/css">@import url(../includes/css/calendar-win2k-2.css);</style>
	
	<?
		//include_once("../includes/inc_tinymce.php");
		//include_once("../includes/inc_calendar.php");
	?>
	
	<script type="text/javascript">
    $(document).ready( function() {
        // Select all
        $("A[href='#select_all']").click( function() {
            $("#" + $(this).attr('rel') + " INPUT[type='checkbox']").attr('checked', true);
            return false;
        });
        
        // Select none
        $("A[href='#select_none']").click( function() {
            $("#" + $(this).attr('rel') + " INPUT[type='checkbox']").attr('checked', false);
            return false;
        });
        
        // Invert selection
      /*   $("A[href='#invert_selection']").click( function() {
            $("#" + $(this).attr('rel') + " INPUT[type='checkbox']").each( function() {
                $(this).attr('checked', !$(this).attr('checked'));
            });
            return false;
        });  */
    });
</script>

	
	<script src="../includes/scripts/jquery/tablesorter.js" type="text/javascript"></script>
	<script language="javascript">
		$(document).ready(function() 
		    {
		        $(".tablesorter").tablesorter({widgets: ['zebra']}); 
		    } 
		); 
	</script>
</head>
<body>

<!-- вся страница -->
<div id="page">

	<div id="header">
        <!-- <div id="headline"></div> -->
		<table cellpadding="0" cellspacing="0" width="100%" height="106">
		<tr><td class="head-left" width="284"><div id="logo"><a href="http://force-it.org" target="_blank"><? echo '<img src="http://www.force-it.org/on-sites/logo-cms.png" alt="FORCE_IT" title="заглядывайте на сайт!" />'; ?></a></div>
		</td><td class="head-line">
			<table style="float: right;" cellpadding="0" cellspacing="0">
				<tr>
				<td width="80"><div class="avatar"><img src="../includes/img/avatar.gif" width="70" height="64" alt="" /></div></td>
				<td width="200"><div class="userinfo">
				<?
				if ($_SESSION["u_stat"] == 1) echo ('Супер Админ');
				if ($_SESSION["u_stat"] == 2) echo ('Администратор');
				if ($_SESSION["u_stat"] == 3) echo ('Супер модератор');
				if ($_SESSION["u_stat"] == 4) echo ('Модератор');
				if ($_SESSION["u_stat"] == 5) echo ('Demo');
				?> (<a style="color: #ffffff;" href="logout.php">выйти</a>)<br />
					Последний вход: <? echo date('d-m-y',$_SESSION['u_denter']);?><br />
					IP: <? echo $_SESSION['u_lip']; ?><br />
					 <a style="color: #ffffff;" href="../" target="_blank">перейти на сайт »</a>
					</div>
				</td></tr>
			</table>
		</td><td class="head-right" width="133">&nbsp;
		</td></tr></table>
    </div>
	
	<div class="navbar">
	<!--	<div class="vnav_nb">
		<div class="mod_img_nb"><a href="#"><img src="../includes/img/icons/help.png" /></a></div><div class="mod_txt_nb"><a href="#">Помощь</a></div>
		</div>

		<div class="vnav_nb">
		<div class="mod_img_nb"><a href="#"><img src="../includes/img/icons/update.png" /></a></div><div class="mod_txt_nb"><a href="#">Обновления</a></div>
		</div>

		<div class="vnav_nb">
		<div class="mod_img_nb"><a href="#"><img src="../includes/img/icons/settings.png" /></a></div><div class="mod_txt_nb"><a href="#">Настройки</a></div>
		</div>

		<div class="vnav_nb">
		<div class="mod_img_nb"><a href="#"><img src="../includes/img/icons/trash.png" /></a></div><div class="mod_txt_nb"><a href="#">Корзина</a></div>
		</div>

		<div class="vnav_nb">
		<div class="mod_img_nb"><a href="#"><img src="../includes/img/icons/mesages.png" /></a></div><div class="mod_txt_nb"><a href="#">Сообщения</a></div>
		</div> -->
		
	</div><!-- navbar -->
	