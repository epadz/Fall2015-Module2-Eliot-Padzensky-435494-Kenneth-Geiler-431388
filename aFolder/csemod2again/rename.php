<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=2");
}
if(isset($_GET['file']) && isset($_GET['new']) && isset($_GET['ext'])){
	$username = $_SESSION['username'];
    $dir    = "../../uploads/" . $username ."/";
	$old = $dir . $_GET['file'] . '.' . $_GET['ext'];
	$new = $dir . $_GET['new']  . '.' . $_GET['ext'];
	//echo $old . '\n';
	//echo $new;
	if(rename($old, $new)){
		header("Location: files.php");
	}else{
		header("Location: files.php?error=4");
	}
}


?>