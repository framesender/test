<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" align="left" width="220" height="500" style="background: #fff;">

<div class="leftpanel">
	
		<!-- <a href="#"> -->
		<div class="mod"><div class="mod_img"><img src="../includes/img/icons/modules.png" /></div>
		<div class="mod_txt">Модули</div></div>
		<!-- </a> -->
		
		<!-- <div><a href="add_mod.php">
			<div class="mod_links"><div class="mod_links_img"><img src="../../includes/img/icons/modules.png"/></div>
				<div class="mod_links_txt">Добавить модуль</div>
			</div>
		</a></div> -->
		<?
session_start();		
			//$basepath = dirname( __FILE__ );
			//include_once($basepath."/../core/cl_db.php");
			//include_once($basepath."/../core/cl_list_modules.php");
			
			$m1 = new cl_list_modules();
			//temporary need to change!!!!!
			$rule = $_SESSION['u_stat'];
			$m1->SelectListModules('list_mod', "list_mod_rules like '%".$rule."%'");
			while ($row = $m1->getdriver()->FetchResult())
			{
				$src_mod = $m1->getdriver()->Strip($row["src_list_mod"]);
				$pic_mod = $m1->getdriver()->Strip($row["pic_list_mod"]);
				$title_mod = $m1->getdriver()->Strip($row["title_list_mod"]);

				printf('<div class="mod_src"><a href="main.php?namem=%s&&titlem=%s">
							<div class="mod_links"><div class="mod_links_img"><img src="../includes/img/icons/%s"/></div><div class="mod_links_txt">%s</div></div>
						</a></div>', $src_mod, $title_mod, $pic_mod, $title_mod);
			}
		?>
<!-- <a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/str_sajta.gif"/></div><div class="mod_links_txt">Страницы сайта</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/novosti.gif"/></div><div class="mod_links_txt">Новости</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/stati.gif"/></div><div class="mod_links_txt">Статьи</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/catalog.png"/></div><div class="mod_links_txt">Интернет- каталог</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/prais.png"/></div><div class="mod_links_txt">Прайс листы</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/foto.png"/></div><div class="mod_links_txt">Фотогалерея</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/bibl.png"/></div><div class="mod_links_txt">Библтоека документов</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/forum.gif"/></div><div class="mod_links_txt">Форум</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/golos.gif"/></div><div class="mod_links_txt">Голосования</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/glos.gif"/></div><div class="mod_links_txt">Глоссарий</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/vopros.png"/></div><div class="mod_links_txt">Вопрос- ответ</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/admin.png"/></div><div class="mod_links_txt">Администраторы сайта</div></div></a>
<a href="users.html"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/polzov.png"/></div><div class="mod_links_txt">Пользователи сайта</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/sotrudn.png"/></div><div class="mod_links_txt">Сотрудники компании</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/vacan.png"/></div><div class="mod_links_txt">Вакансии</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/poisk.png"/></div><div class="mod_links_txt">Поисковая система</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/filov.png"/></div><div class="mod_links_txt">Файловый менеджер</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/bekap.png"/></div><div class="mod_links_txt">Бэкапы</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/banner.png"/></div><div class="mod_links_txt">Баннеры</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/rassilka.png"/></div><div class="mod_links_txt">Рассылки</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/ssilki.png"/></div><div class="mod_links_txt">Обмен ссылками</div></div></a>
<a href="#"><div class="mod_links"><div class="mod_links_img"><img src="img/icons/statist.png" /></div><div class="mod_links_txt">Система статистики</div></div></a> -->
	
	<br />	
	<br />
	<br />
	<br />
	<br />
		
	</div><!-- /leftpanel -->
	
	
</td>
<td class="leftline">&nbsp;</td>