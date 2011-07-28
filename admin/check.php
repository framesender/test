<?
//Script for checking login and pass 

$basepath = dirname( __FILE__ );

include_once($basepath."/../core/cl_db.php");
include_once($basepath."/../core/cl_authorization.php");

$check = new cl_authorization();
$check -> authorization_check($_POST['nonce'],$_POST['login'],$_POST['pass']); 

?>