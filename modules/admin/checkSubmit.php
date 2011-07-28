<?
session_start();

//if ((($_COOKIE['user_n']) == 1) && (($_COOKIE['user_l']) == 1) && (($_COOKIE['user_p']) == 1) && (($_COOKIE['user_rep']) == 1) && (($_COOKIE['user_rul']) == 1))
if ((($_SESSION['user_n']) == 1) && (($_SESSION['user_l']) == 1) && (($_SESSION['user_p']) == 1) && (($_SESSION['user_rep']) == 1) && (($_SESSION['user_rul']) == 1))
{
 echo ('<button type="submit" name="add_data_form"><img src="../includes/img/it/save.gif"  /></button>');
}
//else echo ('___________'.$_COOKIE['user_n']);
 

?>