<?
header("Content-Type: text/html;charset=utf-8");
/* include_once("dbdrivers/abstract.dbdriver.php"); */
include_once("cl_log.php");
class cl_db
{
	private $dbengine; // екземпляр класа драйвера БД
	/* private $state = "development"; */
	private $log;
	// проверяем из конфига какой подключить драйвер, в параметре передаем путь к файлу конфига
	//public function __construct($fileconfig)
	public function __construct()
	{
		//$fileconfig = "../../config/config.php";
		//if (file_exists($fileconfig))
        $this->log = new LOG();
		$basepath = dirname( __FILE__ );
		if (file_exists($basepath.'/../config/config.php'))
		{ 
			//include_once($fileconfig);
			include($basepath.'/../config/config.php');
			$dbengineinfo = $config;
			if (!empty($dbengineinfo['dbtype']))
			{
				if ($dbengineinfo['dbtype']=='mysql')
				{
					$driver = $dbengineinfo['dbtype'].'driver';
					include_once($basepath."/dbdrivers/{$driver}.php");
					$dbengine = new $driver($dbengineinfo);
					$this->dbengine = $dbengine;
				}
				else
					{echo '<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />'; $this->log->save_log(400);}
			}
			else
				{echo '<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />'; $this->log->save_log(110);}
		}
			else {echo '<center><br /><br /><br /><h2>Извините, сайт временно не доступен!</h2><center><br />'; $this->log->save_log(100);}
	}
	
	// Метод для доступа к переменой dbengine
	public function getdriver()
	{
		return $this->dbengine;
	}

}
?>