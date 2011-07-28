<?

session_start();

//class for autorization on cite

class cl_authorization extends cl_db
{
public function authorization_check($nonce,$users,$password)
{
// method for checking login and password
//variables for authorization

	$soul = '203984LKJLKpkpo_)(_)(_-092984s;dfm;lsdmfpoP:OIEkp29034imfsld;2q0934rpjc';
	$password = md5($password.$soul);
	$query = "user_login = '".$users."' and user_password = '".$password."'";
	$this ->getdriver()->Select('users','',$query,'','','','','');
	$res = $this->getdriver()->Count();	

//chek when captha on 		

if (isset($_SESSION['ban'])&& ($_SESSION['ban']>=4) && isset($_SESSION['captcha_keystring']) && ($_SESSION['captcha_keystring'] == $_POST['key_captcha']) && ($res == 1))
{
//Select all data, ganarate array	

		$row = $this->getdriver()->FetchResult();

//write this data form database to session
	 
		$uname = $_SESSION['u_name'] = $row[1];
		$_SESSION['u_log'] = $row[3];
		$_SESSION['u_stat'] = $row[7];
		$_SESSION['u_denter'] = $row[6];
		$_SESSION['u_lip'] = $row[5];
		$_SESSION['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR']; 
		$_SESSION['HTTP_X_FORWARDED_FOR']=@$_SERVER['HTTP_X_FORWARDED_FOR']; 
		$_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT']; 	

		$current_date = mktime(0,0,0, date('m,d,Y'));
		$sql_arr = array ("'".$uname."'","'".$_SESSION['REMOTE_ADDR']."'", $current_date);
		
//update data to database who come last
		
		$this->getdriver()->Update('users','user_name, user_ip, user_denter',$sql_arr, 'user_id='.$row[0]);	
		
		unset($_SESSION['ban']);
		header('Location:main.php');
		
}
	
//check when captha off

else if(($_SESSION['ban']<4)  && ($res == 1))
{
//Select all data, ganarate array		

		$row = $this->getdriver()->FetchResult();
		
//write this data form database to session	 

		$uname = $_SESSION['u_name'] = $row[1];
		$_SESSION['u_log'] = $row[3];
		$_SESSION['u_stat'] = $row[7];
		$_SESSION['u_denter'] = $row[6];
		$_SESSION['u_lip'] = $row[5];
		$_SESSION['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR']; 
		$_SESSION['HTTP_X_FORWARDED_FOR']=@$_SERVER['HTTP_X_FORWARDED_FOR']; 
		$_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT']; 	

		$current_date = mktime(0,0,0, date('m,d,Y'));
		$sql_arr = array ("'".$uname."'","'".$_SESSION['REMOTE_ADDR']."'", $current_date);

//update data to database who come last		
		
		$this->getdriver()->Update('users','user_name, user_ip, user_denter',$sql_arr, 'user_id='.$row[0]);	
		
		unset($_SESSION['ban']);
		header('Location:main.php');
		
	
}
//when login or passwird incorect
else

{
 	unset($_SESSION['HTTP_USER_AGENT']);
	
	if (empty($_SESSION['ban'])) 
	{
		$_SESSION['ban'] = 1;
	} 
	else 
	{
		$_SESSION['ban']++;
	}
	header('Location:index.php');	 
}
//end of authorization_check method
}
  
public function authorize()
{

//method for checking when you autorized

if ($_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) 
{
	die('<center><h2>У вас нет прав для просмотра данной страницы</h2></center>');
}
	
	$query = "user_login = '".$_SESSION['u_log']."' and user_name = '".$_SESSION['u_name']."'";
	$this ->getdriver()->Select('users','',$query,'','','','','');
	$res = $this->getdriver()->Count();	

	if  ($res != 1)
	{
		die('<center><h2>У вас нет прав для просмотра данной страницы </h2></center>');
	}
	
	$row = $this->getdriver()->FetchResult();
	
	if ($row[7] == 6 )
	{
		die('<center><h2>Ваш акаунт заблокирован!</h2></center>');
	}
	
//end of method
}  
//end of class
}
?>