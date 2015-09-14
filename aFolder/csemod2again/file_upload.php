<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo exec('whoami');
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=2");
}
include 'config.php';

// Get the username and make sure it is valid
$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}

// Get the filename and make sure it is valid
$filename = basename($_FILES['uploadedfile']['name']);
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}
chmod($_FILES['uploadedfile']['tmp_name'], 0777);
echo $filename . '<br/>';

$full_path = sprintf("../../uploads/%s/%s", $username, $filename);

echo $full_path;

if(!is_dir("../../uploads/" . $username . "/")){
	mkdir("../../uploads/".$username."/");
}
chmod("../../uploads/".$username."/", 0777);

if(file_exists($full_path)){		//does file exist?
	if(isset($_POST['overwrite'])){		//if so, does post variable overwrite exist? 
		if($_POST['overwrite'] == 1){		//if so, should the file be overwritten
			if(unlink($full_path)){				//if so, can the old file be deleted?
				if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){		//if so, can the new file be uploaded
					chmod($full_path, 0777);
					header("Location: files.php");		//success!!
					exit;
				}else{		//otherwise, was there an error uploading the file
					header("Location: files.php?error=1");	
					exit;
				}	
			}else{		//was there an error deleting the old file?
				header("Location: files.php?error=1");
			}						
		}else{		//so the file exists but is shouldn't overwrite? Sounds like an error
			header("Location: files.php?error=5");
			exit;
		}
	}else{	//That's weird - there's no post variable for overwrite. Error!
		header("Location: files.php?error=5");
		exit;
	}
}else{//The file does not already exist
	if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
		chmod($full_path, 0777);
		header("Location: files.php");
		exit;
	}else{
		header("Location: files.php?error=1");
		exit;
	}
}
?>
