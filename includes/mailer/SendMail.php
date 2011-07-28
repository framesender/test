<?
		
	header("Content-Type: text/html;charset=utf-8");
	session_start();
	
	require_once 'class.phpmailer.php';
	$MailSub = "К Вам сообщение с сайта";
	$BodyMsg ="Отправитель: <b>".$_POST['firstN']."</b><br />". 
	"Фамилия: "."<b>".$_POST['lastN']."</b><br />".
	"мейл отправителя: "."<b>".$_POST['email']."</b><br />".
	"текст сообщения: "."<b>".$_POST['letter']."</b>";

	$_SESSION['firstN']=$_POST['firstN'];
	$_SESSION['email']=$_POST['email'];
	$_SESSION['letter']=$_POST['letter'];
	$_SESSION['lastN']=$_POST['lastN'];
	
	if (''==trim($_POST['firstN']))
    {
    	header ('location: ../../index.php?'.$_POST["link"].'&&n_name'); 
    	exit();
    }
    if (''==trim($_POST['email']))
    {
    	header ('location: ../../index.php?'.$_POST["link"].'&&n_mail'); 
    	//header ('location: ../../contacts/index.php?n_mail'); 
    	exit();
    }
    if (''==trim($_POST['letter']))
    {
    	header ('location: ../../index.php?'.$_POST["link"].'&&n_txt'); 
    	//header('location: ../../contacts/index.php?n_txt'); 
    	exit();
    }
	
	if(!empty($_POST['email'])) 
	{
		if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email']))
		{
			header ('location: ../../index.php?'.$_POST["link"].'&&nc_mail'); 
			//header('location: ../../contacts/index.php?nc_mail');  
			exit();
		}
	}
    
    if($_SESSION['captcha_keystring'] != $_POST['key_captcha'])
    {
        header ('location: ../../index.php?'.$_POST["link"].'&&nc_cap'); 
		exit();
    } 
	
	include_once("../../core/cl_db.php");
	include_once("../../modules/contacts/cl_contacts.php");	
	$contacts = new cl_contacts();
	$mailer = new PHPMailer();
	$contacts->getdriver()->Select('t_contacts', '', '', '', '', '', '', '');
	$row = $contacts->getdriver()->FetchResult();
	$con_mails = explode(';', $row["contacts_mails"]);
	//var_dump($con_mails);
	foreach($con_mails as $key)
	{
		//echo $key."<br />";
		$mailer->AddAddress($key);
	}
	$mailer->Subject = $MailSub;
	$mailer->From = $_POST['email'];
	$mailer->FromName = $_POST['name'];
	$mailer->CharSet = "windows-1251";
	$mailer->ContentType = 'text/html';
	$mailer->Body = $BodyMsg;
	#$mailer->Send();
	//if($mailer->Send())
	
	
		if($mailer->Send())
		{		
			header ('location: ../../index.php?'.$_POST["link"].'&OK'); 
			//header('Location: ../../contacts/index.php?OK');
			unset($_SESSION['firstN']); unset($_SESSION['email']);
			unset($_SESSION['lastN']); unset($_SESSION['letter']);
		}
		else
		{			
			header ('location: ../../index.php?'.$_POST["link"].'&n_OK'); 
			//header('Location: ../../contacts/index.php?n_OK');
		}
	
	
	unset($_SESSION['captcha_keystring']);
	
		//echo($BodyMsg);
		
?>