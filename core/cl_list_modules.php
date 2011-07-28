<?
//include_once("cl_db.php");

class cl_list_modules extends cl_db
{
	
	//Деструктор класа, который закрывает соединение с БД
	function __destruct()
	{
		//$this->id_news = null;
		//$this->title_news = '';
		//$this->text_news = '';
		//$this->date_news = '';
		
		$this->getdriver()->Disconnect();
	}
	
	//Выполняет запрос на выборку, которому передаем название таблицы, номер записи от которой ведется отсчет (начиная с 0), количество записей
	public function SelectListModules($table_names, $cond_names)
	{
		if (!empty($table_names))
		{
			$field_names = 'id_list_mod, title_list_mod, pic_list_mod, src_list_mod, cdat_mod, list_mod_rules';
			//$cond_names = '';
			$group_names = '';
			$ord_names = 'title_list_mod';
			$ord_types = 'ASC';
			
			$limit_from = 0;
			$limit_count = '';
			
			$this->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);
		}
			else die("<br> Не могу выполнить запрос на выборку списка модулей");
	}
}
?>