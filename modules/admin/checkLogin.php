<?
session_start();
include_once ("../../core/cl_db.php");
$sql = new cl_db();
$table_names = 'users';
$field_names = 'user_id, user_name, user_description, user_login, user_password, user_ip, user_denter, user_rule';
 
if (!empty($_POST['user_login']))
{
 
$cond_names = "user_login='".$_POST['user_login']."'";
$sql->getdriver()->Select($table_names, $field_names, $cond_names, '', '', '', '', '');

$test = $sql->getdriver()->Count();
	
	if ((strlen($_POST['user_login']) > 3)&&($test == 0))
	{
	//setcookie("user_l",1, time()+3600);
	$_SESSION['user_l'] = 1;
	echo ('<img src="../includes/img/icons_table/active.png" /> ');
	}
	else
	{
	//setcookie("user_l",1, time()-3600);
	unset($_SESSION['user_l']);
	echo ('<img src="../includes/img/icons_table/deactive.png" />');
	}
}
else
{
//setcookie("user_l",1, time()-3600); 
unset($_SESSION['user_l']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');
}
?>