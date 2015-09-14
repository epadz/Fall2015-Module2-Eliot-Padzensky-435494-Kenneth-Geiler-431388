<?php
session_start();
$exists = 0;
$username = $_POST['username'];
$h = fopen("../../user.txt", "r");
while( !feof($h) ){
	$l = rtrim(fgets($h), "\r\n");
	if($username == $l){
		$exists = 1;
	}
}
fclose($h);
echo $exists;
?>