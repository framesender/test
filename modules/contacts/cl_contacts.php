<?
class cl_contacts extends cl_db
{
	private function SelectMenu($table_names, $cond_names, $ord_names, $ord_types)
	{
		if (!empty($table_names))
		{
			$field_names = 'menu_id, menu_name, menu_sortid, menu_type, menu_seo_id';
			$group_names = '';
			$limit_from = '';
			$limit_count = '';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Ќе могу выполнить запрос на выборку меню сайта");
	}
	
	public function ShowData($link)
	{
		if ($link != '')
		{
			$this->SelectMenu('t_menu', 'menu_id='.$link.' and menu_type=3', '', '');
			$count = $this->getdriver()->Count();
			if ($count != 0)
			{				
				include_once("contacts.php");
			}
		}
	}

	
	public function ShowContactsInfo()
	{
		$this->getdriver()->Select('t_contacts', '', '', '', '', '', '', '');
		$row = $this->getdriver()->FetchResult();
		return stripslashes($row["contacts_info"]);
	}
}
?>