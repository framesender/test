<?

//script for logout form admin page

session_start();
 
unset($_SESSION['u_name']);
unset($_SESSION['u_log']);
unset($_SESSION['u_stat']);
unset($_SESSION['u_denter']);
unset($_SESSION['u_lip']);
unset($_SESSION['REMOTE_ADDR']);
unset($_SESSION['HTTP_X_FORWARDED_FOR']);
unset($_SESSION['HTTP_USER_AGENT']);

header('Location:index.php');
?>