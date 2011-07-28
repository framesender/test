<?
	error_reporting(0);
	
	include_once("core/cl_db.php");
	include_once("core/cl_seo.php");
	include_once("modules/menu/cl_menu.php");
	include_once("modules/menu/cl_popmenu.php");
	include_once("modules/content/cl_content.php");
	include_once("modules/contacts/cl_contacts.php");
	include_once("modules/responce/cl_responce.php");
	include_once("modules/galleria/cl_galleria.php");
	include_once("modules/news/cl_news.php");
    
   	
	$menu = new cl_menu();
	$popmenu = new cl_popmenu();
	$content = new cl_content();
	$contacts = new cl_contacts();
	$responce = new cl_responce();
	$galleria = new cl_galleria();
	$news = new cl_news();
	
	$link = $_GET["link"];
	$sublink = $_GET["sublink"];
	$news_id = $_GET["news"];	
	$page = $_GET["page"];
	$next = $_GET["next"];

	$mlink = $menu->LinkExist($link);
	$msublink = $popmenu->SubLinkExist($link, $sublink);
	if (($mlink == false) or ($msublink == false))
	{
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>';
		echo '<title>Страница не найдена</title>';
		echo '<meta name="description" content="Страница не найдена" />';
		echo '<meta name="keywords" content="Страница не найдена" />';
		echo '<style>
				a:link { text-decoration: underline; color: #666666;}
				a:visited { text-decoration: underline; color: #666666; }
				a:hover { text-decoration: none; color: #cccccc; }
				a:active, a:focus { text-decoration: underline; color: #666666; }
				#not-found {margin: 0 auto; padding: 30px 0; width: 700px;}
				.img {position: absolute; top: 220px; right: 30%;}
			</style>';
		echo '</head>
				<body><div id="not-found">';
				echo "<div style='color: #444444;'><h1>Страница не найдена (404-я ошибка)</h1></div>
					<div style='color: #cccccc;'><h2>page is not found</h2></div>
					<div>Извините, такой страницы не существует. Может она была удалена администратором с сервера, или её здесь никогда и не было.</div>
					<div><h2><a href='index.php'>Заблудились?</a></h2></div>	
					<div class='img'><img src='not-found.gif' alt='Страница не найдена' /></div>";
		echo '</div></body>
				</html>';
		exit;
	}
?>