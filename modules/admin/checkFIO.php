<?
session_start();
 
if (!empty($_POST['user_name']))
{
	
	if (strlen($_POST['user_name']) > 5)
	{
	//setcookie("user_n",1, time()+3600);
	$_SESSION['user_n'] = 1;
	echo ('<img src="../includes/img/icons_table/active.png" /> ');
	
	}
	else
	{
	//setcookie("user_n",1, time()-3600);
	unset($_SESSION['user_n']); 
	echo 
	('<img src="../includes/img/icons_table/deactive.png" />');
	}
	
}
else 
{

//setcookie("user_n",1, time()-3600);
unset($_SESSION['user_n']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');

}
?>