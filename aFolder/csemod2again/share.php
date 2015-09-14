<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=2");
}
$from = $_SESSION['username'];
$to = $_POST['to'];
$fname = $_POST['fname'];

if(!file_exists('../../uploads/' . $to . '/' . $fname)){
	copy('../../uploads/' . $from . '/' . $fname, '../../uploads/' . $to . '/' . $fname) or die('error');
}else{
	echo 'success';
}

?>