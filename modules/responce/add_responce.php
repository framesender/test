<?php
	include "../../core/cl_db.php";
	include "cl_responce.php";
	$resp = new cl_responce();
		if (($_POST['name']) and ($_POST['msg']))
		{

		$resp->InsertResponceSilent('t_responce', array('"'.$resp->getdriver()->PutContent($_POST['name']).';'.$resp->getdriver()->PutContent($_POST['prof']).'"', '"'.$resp->getdriver()->PutContent($_POST['msg']).'"', date('d-m-Y')));
		if ($resp->getdriver()->Result() > 0)
		{
			header('Location: ../../index.php?'.$_POST['link'].'&action=ok');
			exit();
		}
		else
		{
			header('Location: ../../index.php?'.$_POST['link'].'&action=no');
			exit();
		}
		} else {
			header('Location: ../../index.php?'.$_POST['link'].'&action=bad');
			exit();
		}
	
	
?>