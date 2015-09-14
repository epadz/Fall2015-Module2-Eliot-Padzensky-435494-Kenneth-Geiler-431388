<?php
session_start();
session_unset();
session_destroy();
session_start();
$username = $_POST['username'];
if($username == null || strlen($username) <2){
	header("Location: login.php?error=1");
}
$h = fopen("../../user.txt", "r");
while( !feof($h) ){
	$l = rtrim(fgets($h), "\r\n");
	if($username == $l){
		$_SESSION['username'] = htmlentities($username);
		header("Location: files.php");
		exit;
	}
}
header("Location: login.php?error=1");
fclose($h);
?>
