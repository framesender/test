<?
header("Content-Type: text/html;charset=utf-8");
include_once("abstract.dbdriver.php");
include_once(dirname( __FILE__ )."/../cl_log.php");
class mysqldriver extends abstractdbdriver
{
    private $log;	
	public function __construct($dbinfo)
	{
		$this->log = new LOG();
        
        if (!empty($dbinfo['dbname']) and !empty($dbinfo['dbhost']) and !empty($dbinfo['dbuser'])) 
		{
			
            $this->connection = @mysql_connect($dbinfo['dbhost'], $dbinfo['dbuser'], $dbinfo['dbpwd']);
			
            if (!is_resource($this->connection))
            {
                 echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
                 $this->log->save_log(200);
            } 
            
            if ($dbinfo['dbprefix'] == '')
			{
				if (!@mysql_select_db($dbinfo['dbname'], $this->connection))
                {
                    echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
                    $this->log->save_log(300);
                    
                }
                
			}
			else if ($dbinfo['dbprefix'] != '')
			{
				if (!@mysql_select_db($dbinfo['dbprefix'].$dbinfo['dbname'], $this->connection))
                {
                    echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
                    $this->log->save_log(300);  
                } 
			}
			//else die("<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />");
			//@mysql_query('SET names cp1251');
			@mysql_query('SET names utf8');
		}
		else
		{
			echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
            
            if (empty($dbinfo['dbname'])) $this->log->save_log(120);
			if (empty($dbinfo['dbhost'])) $this->log->save_log(130);
			if (empty($dbinfo['dbuser'])) $this->log->save_log(140);
		}
	}
	
	function __destruct()
	{
		@mysql_free_result($this->qresult);
		
		$this->tables = '';
		$this->fields = '';
		$this->gfields = '';
		$this->ord_fields = '';
		$this->o_type = '';
		$this->condition = '';
		
		$this->Disconnect();
	}
	
	// метод проверяет соединение с базой
	public function Connect($dbinfo)
	{
		if (!empty($dbinfo['dbname']) and !empty($dbinfo['dbhost']) and !empty($dbinfo['dbuser']))
		{
			$this->connection = @mysql_connect($dbinfo['dbhost'], $dbinfo['dbuser'], $dbinfo['dbpwd']);
            
            if (!is_resource($this->connection))
            {
                 echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
                 $this->log->save_log(200);
            } 
            
			           
            if (!@mysql_select_db($dbinfo['dbname'], $this->connection))
            {
                echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
                $this->log->save_log(300);
                
            }
            
			@mysql_query('SET names utf8');
			//@mysql_query('SET names cp1251');
		}
		else
			{
                echo "<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />";
            
                if (empty($dbinfo['dbname'])) $this->log->save_log(120);
    			if (empty($dbinfo['dbhost'])) $this->log->save_log(130);
    			if (empty($dbinfo['dbuser'])) $this->log->save_log(140);
			}
	}
	
	// метод закривает соединение с базой
	public function Disconnect()
	{
		if((isset($this->connection)) && ($this->connection != null))
		{
			@mysql_close($this->connection);
		}
	}
	
	//Метод записывает в поле класса указанный перечень полей для сортировки при выборке, который используется методом Select()
	private function SetOrderFields($orderfields)
	{
		if(isset($orderfields))
		{
			$this->ord_fields = $orderfields;
		}
	}
	
	//Метод записывает в поле класса указанный перечень полей для группировки при выборке, который используется методом Select()
	private function SetGroupFields($groupfields)
	{
		if(isset($groupfields))
		{
			$this->gfields = $groupfields;
		}
	}

	//Метод записывает в поле класса указанный перечень значений полей для использования методом Insert()
	private function SetValues($value_list)
	{
		if(isset($value_list))
		{
			$this->values = $value_list;
		}
	}
	
	//Метод устанавливает тип сортировки
	private function SetOrder($ord_types)
	{
		if(isset($ord_types))
		{
			$this->o_type = ' '.$ord_types;
		}
	}
	
	//Метод записывает в поле класса указанный перечень таблиц для выборки из них, который используется методом Select()
	private function SetTables($names)
	{
		if(isset($names))
		{
			$this->tables = $names;
		}
	}

	//Метод записывает в поле класса указанный перечень полей для выборки, который используется методом Select()
	private function SetFields($field_names)
	{
		if(isset($field_names))
		{
			$this->fields = $field_names;
		}
	}
	
	//Метод записывает в поле класса указанное условие для выборки, которое будет вставленно в WHERE, используется методом Select()
	private function SetCondition($cond)
	{
		if(isset($cond))
		{
			/* $cond = mysql_escape_string($cond); */
			$this->condition = $cond;
		}
	}
	
	//Метод задаёт границы выборки
	private function Limit($from,$cnt)
	{
		if((isset($from)) && (isset($cnt)))
		{
			$this->lmt = ' '.$from.', '.$cnt;
		}
			else if(isset($cnt))
			{
				$this->lmt = ' '.$cnt;
			}
	}
	
	//Метод возвращает результат  выполнения последнего запроса c помощью mysql_fetch_array
	public function FetchResult()
	{
		// $res = htmlspecialchars($this->qresult, ENT_QUOTES);
		// return mysql_fetch_array($res, MYSQL_BOTH);
		$res = $this->qresult;
		//strip_tags($res);
		return mysql_fetch_array($res, MYSQL_BOTH);
	}
	
	//Метод возвращает результат выполнения последнего запроса
	public function Result()
	{
		//$res = $this->qresult;
		//strip_tags($res);
		// $res_count = @mysql_num_rows($this->qresult);
		// echo "<hr />".$res;
		// if ($res_count == 0)
			// echo "<br /> Запрос не выполнен!";
				// else echo "<br /> Запрос выполнен успешно!";
		
		//return $res;
		
		return $this->qresult;
	}
	
	//Метод записывает в поле класса указаный текст SQL-запроса, который выполняется при вызове метода Exec() 
	private function SetQuery($query_text)
	{
		//$query = mysql_real_escape_string($query_text);
		//$this->querytxt = $query;
		$this->querytxt = $query_text;
	}
	
	//Метод выполняет запрос указанный в параметре и возвращает результат
	public function ExecQuery($query_text)
	{
		// $this->Connect();
		if(($this->connection != null)&&($query_text != ''))
		{
			$this->SetQuery($query_text);
			$q = $this->querytxt;
			//echo '<h3>'.$q.'</h3>';
			$this->SQL($q);
			
			// $this->Disconnect();
			
			return $this->Result();
		}
		else
		{
			return null;
		}
	}
	
	//Метод создает таблицу с указанным именем и полями (во втором параметре поля, их типы и атребуты идут через запятую)
	public function CreateTable($name, $fields, $params)	// пока не работает
	{
		// $this->Connect();
		if(($this->connection != null) && ($name != ''))
		{
			$q="CREATE TABLE `".$name."` (".$fields.") ".$params.";";
			//echo $q;
			$this->SQL($q);
			// $this->Disconnect();
			
			return $this->Result();
		}
		else
		{
			return null;
		}
	}
	
	//Метод удаляет из базы данных таблицу с указанным именем
	public function DropTable($name)
	{
		// $this->Connect();
		if($this->connection != null)
		{
			$q="DROP TABLE IF EXISTS ".$name.";";
			$this->SQL($q);
			// $this->Disconnect();
			
			return $this->Result();
		}
		else
		{
			return null;
		}
	}
	
	//Обложка для функции mysql_query с сохранением времени выполнения запроса в поле класса sqlexectime
	private function SQL($q)
	{
		$this->qresult = @mysql_query($q);
		//echo "<br /> R: ".$this->qresult." LR: ".$this->last_result;
	}
	
	//Выполня запрос на выборку, который формируется методами SetFields, SetTables, SetCondition, SetGroupFields, SetOrderFields, SetOrder, Limit
	public function Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count)
	{
		$this->qresult = null;
		
		// $this->Connect();
		if($this->connection != null)
		{
			if($table_names !='')
			{
				$tempq = 'SELECT ';
				if($field_names != '')
				{
					$this->SetFields($field_names);
					$tempq.=$this->fields.' '; 	
				}
				else
				{
					$tempq.= '* ';
				}
				$this->SetTables($table_names);
				$tempq.= 'FROM '.$this->tables.' ';
				if($cond_names != '')
				{
					$this->SetCondition($cond_names);
					$tempq.= 'WHERE '.$this->condition.' ';
				}
				if($group_names != '')
				{
					$this->SetGroupFields($group_names);
					$tempq.= 'GROUP BY '.$this->gfields.' ';
				}
				if($ord_names != '')
				{
					$this->SetOrderFields($ord_names);
					$tempq.= 'ORDER BY '.$this->ord_fields;
					if($ord_types != '')
					{
						if($ord_types == 'ASC')
						{
							$this->SetOrder($ord_types);
							$tempq.=$this->o_type;	
						}
							else if($ord_types == 'DESC')
							{
								$this->SetOrder($ord_types);
								$tempq.=$this->o_type;	
							}
								else $tempq.=$this->o_type;
					}
						else $tempq.=$this->o_type;
				}
				if($limit_count !='')
				{
					$this->Limit($limit_from, $limit_count);
					$tempq.=' LIMIT '.$this->lmt;	
				}
				$tempq.=';';
				$this->temp_query = $tempq;
				$q=$this->temp_query;
				
				//echo "<br> {$q}"; // текст запроса
				
				$this->SQL($q);
				// $this->Disconnect();
			}
			else
			{
				return null;
			}
			// $this->Disconnect();
		}
		else
		{
			return null;
		}
	}
	
	//Выполня запрос на удаление, который формируется методами SetTables, SetCondition
	public function Delete($table_names, $cond_names)
	{
		$this->qresult = null;
		//$this->Connect();
		if($this->connection != null)
		{
			if($table_names !='')
			{
				$this->SetTables($table_names);
				$tempq = 'DELETE FROM '.$this->tables.' ';
				if($cond_names != '')
				{
					$this->SetCondition($cond_names);
					$tempq.= 'WHERE '.$this->condition;
				}
				$tempq.=';';
				$this->temp_query = $tempq;
				$q=$this->temp_query;
				
				//echo "<br> {$q}"; // текст запроса
				
				$this->SQL($q);
				
				//$this->Result();
			}
			else
			{
				//$this->Disconnect();
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	
	//Метод вставляет в таблицу указанную методом SetTables() поля указанные методом  SetFields() значения указанные методом SetValues()
	public function Insert($table_names, $field_names, $field_values)
	{
		$this->qresult = null;
		//$this->Connect();
		if($this->connection != null)
		{
			if($table_names !='')
			{
				$this->SetTables($table_names);
				$tempq = 'INSERT INTO '.$this->tables.' ';
				if($field_names != '')
				{
					$this->SetFields($field_names);
					$tempq.='('.$this->fields.') '; 	
				}
				$tempq.= 'VALUES ';
				if($field_values !='')
				{
					$this->SetValues($field_values);
					$tempq.='('.$this->values.')';	
				}
				$tempq.=';';
				$this->temp_query = $tempq;
				$q=$this->temp_query;
				
				//echo "<br> {$q}"; // текст запроса
				
				$this->SQL($q);
				
				//$this->Disconnect();
				//$this->Result();
				
			}
			else
			{
				//$this->Disconnect();
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	
	//Метод обновляэт в таблице указанной методом SetTables() поля указанные методом  SetFields() ставя значения указанные методом SetValues()
	public function Update($table_names, $field_names, $field_values, $cond_names)
	{
		$this->qresult = null;
		//$this->Connect();
		if($this->connection != null)
		{
			if($table_names !='')
			{
				$this->SetTables($table_names);
				$tempq = 'UPDATE '.$this->tables.' SET ';
				//if(($field_names != '')&&($field_values != ''))
				if(($field_names != '')&&($field_values != null))
				{
					$this->SetFields($field_names);
					//$this->SetValues($field_values);
					$ef = explode(',', $this->fields);
					//$ev = explode(';', $this->values);
					$ev = $field_values;
					if(count($ef)==count($ev))
					{
						$i=0;
						for($i=0;$i<count($ef);$i++)
						{
							$tempq.=$ef[$i]." = ".$ev[$i].",";
						}
						$tempq = substr($tempq, 0, strlen($tempq)-1);
					}
				}
				if($cond_names != '')
				{
					$this->SetCondition($cond_names);
					$tempq.= ' WHERE '.$this->condition;
				}
				$tempq.=';';
				
				$this->temp_query = $tempq;
				$q=$this->temp_query;
				
				//echo "<br>запрос {$q}"; // текст запроса
				
				$this->SQL($q);
				//$this->Disconnect();
				
				//$this->Result();
			}
			else
			{
				//$this->Disconnect();
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	
	// метод возвращает количество записей выборки
	public function Count()
	{
		$count = $this->qresult;
		$count = @mysql_num_rows($count);
		if ($count == 0) return 0;
			else return $count;
	}
	
	// метод обрабатывает введеные даные перед вложением в базу
	public function PutContent($x)
	{
		 if (!is_numeric($x)) 
            return @mysql_real_escape_string($x);
             else return $x;
        
	}
	
	// метод обрабатывает  даные перед выводом на сайт
	public function Strip($x)
	{
		$x = stripslashes($x);
		return strip_tags($x);
	}
	
	
	
/* public function execute($sql)
{
$sql = $this->prepQuery($sql);
$parts = split(" ",trim($sql));
$type = strtolower($parts[0]);
$hash = md5($sql);
$this->lasthash = $hash;
if ("select"==$type)
{
if (isset($this->results[$hash]))
{
if (is_resource($this->results[$hash]))
return $this->results[$hash];
}
}
else if("update"==$type || "delete"==$type)
{
$this->results = array(); //clear the result cache
}
$this->results[$hash] = mysql_query($sql,$this->connection);
}
public function count()
{
//print_r($this);
$lastresult = $this->results[$this->lasthash];
//print_r($this->results);
$count = mysql_num_rows($lastresult);
if (!$count) $count = 0;
return $count;
}
private function prepQuery($sql)
{
// "DELETE FROM TABLE" returns 0 affected rows.
// This hack modifies the query so that
// it returns the number of affected rows
if (preg_match('/^\s*DELETE\s+FROM\s+(\S+)\s*$/i', $sql))
{
$sql = preg_replace("/^\s*DELETE\s+FROM\s+(\S+)\s*$/",
"DELETE FROM \\1 WHERE 1=1", $sql);
}
return $sql;
}
public function escape($sql)
{
if (function_exists('mysql_real_escape_string'))
{
return mysql_real_escape_string($sql, $this->conn_id);
}
elseif (function_exists('mysql_escape_string'))
{
return mysql_escape_string( $sql);
}
else
{
return addslashes($sql);
}
}
public function affectedRows()
{
return @mysql_affected_rows($this->connection);
}
public function insertId()
{
return @mysql_insert_id($this->connection);
}
public function transBegin()
{
$this->execute('SET AUTOCOMMIT=0');
$this->execute('START TRANSACTION'); // can also be BEGIN or
// BEGIN WORK
return TRUE;
}
public function transCommit()
{
$this->execute('COMMIT');
$this->execute('SET AUTOCOMMIT=1');
return TRUE;
}
public function transRollback()
{
$this->execute('ROLLBACK');
$this->execute('SET AUTOCOMMIT=1');
return TRUE;
}
public function getRow($fetchmode = FETCH_ASSOC)
{
$lastresult = $this->results[$this->lasthash];
if (FETCH_ASSOC == $fetchmode)
$row = mysql_fetch_assoc($lastresult);
elseif (FETCH_ROW == $fetchmode)
$row = mysql_fetch_row($lastresult);
elseif (FETCH_OBJECT == $fetchmode)
$row = mysql_fetch_object($lastresult);
else
$row = mysql_fetch_array($lastresult,MYSQL_BOTH);
return $row;
}
public function getRowAt($offset=null,$fetchmode = FETCH_ASSOC)
{
$lastresult = $this->results[$this->lasthash];
if (!empty($offset))
{
mysql_data_seek($lastresult, $offset);
}
return $this->getRow($fetchmode);
}
public function rewind()
{
$lastresult = $this->results[$this->lasthash];
mysql_data_seek($lastresult, 0);
}
public function getRows($start, $count, $fetchmode = FETCH_ASSOC)
{
$lastresult = $this->results[$this->lasthash];
mysql_data_seek($lastresult, $start);
$rows = array();
for ($i=$start; $i<=($start+$count); $i++)
{
$rows[] = $this->getRow($fetchmode);
}
return $rows;
} */

}
?>