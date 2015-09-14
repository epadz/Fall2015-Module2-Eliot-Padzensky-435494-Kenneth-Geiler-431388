<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=2");
}
include 'config.php';

// Get the username and make sure it is valid
$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "2";
	exit;
}

// Get the filename and make sure it is valid
$filename = $_POST['fileName'];
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "2";
	exit;
}

$full_path = sprintf("../../uploads/%s/%s", $username, $filename);

if(file_exists($full_path)){
	echo "1";
}else{
	echo "0";
}
?>