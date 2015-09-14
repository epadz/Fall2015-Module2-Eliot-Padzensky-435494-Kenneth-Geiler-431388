<?php
session_start();

$username = $_POST['username'];
$h = fopen("../../user.txt", "r");
while( !feof($h) ){
	$l = rtrim(fgets($h), "\r\n");
	if($username == $l){		
		header("Location: login.php?error=3");
		exit;
	}
}
fclose($h);

$h = fopen("../../user.txt", "a+");
fwrite($h,$username."\r\n");
fclose($h);
$_SESSION['username'] = htmlentities($username);
mkdir("../../uploads/".$username."/");
chmod("../../uploads/".$username."/", 0777);
header("Location: files.php");
exit;
?>