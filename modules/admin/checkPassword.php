<?

session_start();

if (!empty($_POST['user_password']))
{
	if (strlen($_POST['user_password']) >= 6) 
	{
	//setcookie("user_p",1, time()+3600);
	$_SESSION['user_p'] = 1;
	echo ('<img src="../includes/img/icons_table/active.png" /> ');
	}
	else 
	{
	//setcookie("user_p",1, time()-3600);
	unset($_SESSION['user_p']);
	echo ('<img src="../includes/img/icons_table/deactive.png" />');
	}
	
}
else 
{
//setcookie("user_p",1, time()-3600);
unset($_SESSION['user_p']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');
}
?>