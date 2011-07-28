<?
/* define ("FETCH_ASSOC",1);
define ("FETCH_ROW",2);
define ("FETCH_BOTH",3);
define ("FETCH_OBJECT",3); */
	
/* абстрактний клас для драйверов БД */
abstract class abstractdbdriver
{
	private $tables = '';		// поле - список таблиц для запроса
	private $fields = '';		// поле - список полей для запроса
	private $ord_fields = '';	// поле - список полей по каким сортируем
	private $gfields = '';		// поле - список полей по каким групируем
	private $values = '';		// поле - список значений полей для запроса
	private $o_type = ' ASC';	// поле - тип сортировки, по умолчанию
	private $lmt = '';			// поле - лимит выдачи результата
	private $condition = '';	// поле - условие для запроса
	private $temp_query ='';	// поле - сюда записываем текст запроса для выполнения
	private $querytxt = '';		// поле - текст запроса для виполнения методом ExecQuery
	private $qresult = null;	// поле - результат запроса
	
	protected $connection;
	//protected $results = array();
	//protected $lasthash = "";
	
	// метод проверяет соединение с базой
	public function Connect()
	{
		
	}
	
	// метод закривает соединение с базой
	public function Disconnect()
	{

	}

	//Метод записывает в поле класса указанный перечень полей для сортировки при выборке, который используется методом Select()
	private function SetOrderFields($orderfields)
	{
		
	}
	
	//Метод записывает в поле класса указанный перечень полей для группировки при выборке, который используется методом Select()
	private function SetGroupFields($groupfields)
	{
		
	}

	//Метод записывает в поле класса указанный перечень значений полей для использования методом Insert()
	private function SetValues($value_list)
	{
		
	}

	//Метод устанавливает тип сортировки
	private function SetOrder($ord)
	{
		
	}
	
	//Метод записывает в поле класса указанный перечень таблиц для выборки из них, который используется методом Select()
	private function SetTables($names)
	{
		
	}

	//Метод записывает в поле класса указанный перечень полей для выборки, который используется методом Select()
	private function SetFields($field_names)
	{
		
	}

	//Метод записывает в поле класса указанное условие для выборки, которое будет вставленно в WHERE, используется методом Select()
	private function SetCondition($cond)
	{
		
	}
	
	//Метод задаёт границы выборки
	private function Limit($from,$cnt)
	{
		
	}
	
	//Метод возвращает результат  выполнения последнего запроса c помощью mysql_fetch_array
	public function FetchResult()
	{
		return 0;
	}
	
	//Метод возвращает результат выполнения последнего запроса
	public function Result()
	{
		return 0;
	}

	
	//Метод записывает в поле класса указаный текст SQL-запроса, который выполняется при вызове метода Exec() 
	private function SetQuery($query_text)
	{
		
	}
	
	//Метод выполняет запрос указанный в параметре и возвращает результат
	public function ExecQuery($query_text)
	{
		return 0;
	}
	
	//Метод создает таблицу с указанным именем и полями (во втором параметре поля, их типы и атребуты идут через запятую)
	public function CreateTable($name, $fields, $params)
	{
		return 0;
	}
	
	//Метод удаляет из базы данных таблицу с указанным именем
	public function DropTable($name)
	{
		return 0;
	}
	
	//Обложка для функции mysql_query с сохранением времени выполнения запроса в поле класса sqlexectime
	private function SQL($q)
	{
		
	}
	
	//Выполня запрос на выборку, который формируется методами SetFields, SetTables, SetCondition, SetGroupFields, SetOrderFields, SetOrder, Limit
	public function Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count)
	{
		return false;
	}
	
	//Выполня запрос на удаление, который формируется методами SetTables, SetCondition
	public function Delete($table_names, $cond_names)
	{
		return false;
	}
	
	//Метод вставляет в таблицу указанную методом SetTables() поля указанные методом  SetFields() значения указанные методом SetValues()
	public function Insert($table_names, $field_names, $field_values)
	{
		return false;
	}
	
	//Метод обновляет в таблице указанной методом SetTables() поля указанные методом  SetFields() ставя значения указанные методом SetValues()
	public function Update($table_names, $field_names, $field_values, $cond_names)
	{
		return false;
	}
	
	// метод возвращает количество записей выборки
	public function Count()
	{
		return 0;
	}
	
	// метод обрабатывает введеные даные перед вложением в базу
	public function PutContent($x)
	{
		return 0;
	}
	
	// метод обрабатывает  даные перед выводом на сайт
	public function Strip($x)
	{
		return 0;
	}
	
	

/* public function count()
{
return 0;
} */

/* public function execute($sql)
{
return false;
} */

/* private function prepQuery($sql)
{
return $sql;
} */

/* public function escape($sql)
{
return $sql;
} */

/* public function affectedRows()
{
return 0;
} */

/* public function insertId()
{
return 0;
} */

/* public function transBegin()
{
return false;
} */

/* public function transCommit()
{
return false;
} */

/* public function transRollback()
{
return false;
} */

/* public function getRow($fetchmode = FETCH_ASSOC)
{
return array();
} */

/* public function getRowAt($offset=null,$fetchmode = FETCH_ASSOC)
{
return array();
} */

/* public function rewind()
{
return false;
} */

/* public function getRows($start, $count, $fetchmode = FETCH_ASSOC)
{
return array();
} */
}
?>