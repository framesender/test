<?

session_start(); 

if (!empty($_POST['user_repassword']))
{
if (($_POST['user_repassword']) == ($_POST['user_password']))
{
//setcookie("user_rep",1, time()+3600);
$_SESSION['user_rep'] = 1;
 echo ('<img src="../includes/img/icons_table/active.png" /> ');
}
else 
{
//setcookie("user_rep",1, time()-3600);
unset($_SESSION['user_rep']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');
}	
}
else 
{
//setcookie("user_rep",1, time()-3600);
unset($_SESSION['user_rep']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');
}
?>