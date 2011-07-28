<?

session_start();

if (!empty($_POST['user_rule']))
{
if (($_POST['user_rule']) != 0) {
//setcookie("user_rul",1, time()+3600);
$_SESSION['user_rul'] = 1;
echo ('<img src="../includes/img/icons_table/active.png" /> ');
}
else 
{
//setcookie("user_rul",1, time()-3600);
unset($_SESSION['user_rul']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');
}
}
else 
{
//setcookie("user_rul",1, time()-3600);
unset($_SESSION['user_rul']);
echo ('<img src="../includes/img/icons_table/deactive.png" />');
}
 

?>