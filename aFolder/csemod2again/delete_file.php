<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=2");
}
if(isset($_GET['file'])){
	$username = $_SESSION['username'];
    $dir    = "../../uploads/{$username}/";
	$fp = $dir . $_GET['file'];
	if(unlink($fp)){
		header("Location: files.php");
	}else{
		header("Location: files.php?error=3");
	}
	
}else{
	header("Location: files.php?error=2");
}

?>