<?
 
include_once ("../../core/cl_db.php");
 
 
$sql = new cl_db();
$table_names = 'users';
$field_names = 'user_id, user_name, user_description, user_login, user_password, user_ip, user_denter, user_rule';


$sql->getdriver()->Select($table_names, $field_names, $cond_names, $group_names, $ord_names, $ord_types, $limit_from, $limit_count);

if (!empty($_POST['user_name']))
{
	if (strlen($_POST['user_name']) > 5) echo ('<img src="../includes/img/icons_table/active.png" />USER ');
	else echo ('<img src="../includes/img/icons_table/deactive.png" />');
	
}

if (!empty($_POST['user_login']))
{
	if (strlen($_POST['user_login']) > 5)  
	//{
	 
 	echo ('<img src="../includes/img/icons_table/active.png /> LOGIN');
 
}


?>