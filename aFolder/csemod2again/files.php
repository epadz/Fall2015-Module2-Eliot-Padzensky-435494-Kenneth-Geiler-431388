<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.php?error=2");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['username'] ?>'s Files</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/flick/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="includes/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
function rename(f,e){
	
	var name = prompt('What would you like to rename the file?', f + '');
	if(name != null && unIsGood(name)){
		window.location = 'rename.php?file=' + f + '&new=' + name + '&ext=' + e;
	}else{
		alert("Invalid file name. File names cannot include characters /, \\, ?, *, %, :, |, \" <, >, . or spaces");
	}
}
	<?php
	if(isset($_GET['error'])){
		$error = $_GET['error'];
		if($error == 1){
			echo 'alert("There was an error uploading your file!");';
		}else if($error == 2){
			echo 'alert("There was an error deleting your file!");';
		}else if($error == 3){
			echo 'alert("There was an error deleting your file!");';
		}else if($error == 4){
			echo 'alert("There was an error renaming your file!");';
		}else if($error == 5){
			echo 'alert("A file already exists with that name!");';
		}
		
	}
	?>
</script>
</head>

<body>
	<div class="main">
    	<h1>Hey, <?php echo htmlentities($_SESSION['username']); ?>!</h1>
        <a href="logout.php" id="logOutButton">log out</a>
        <form id="fileUpload" enctype="multipart/form-data" action="file_upload.php" method="POST">
        	<input type="hidden" name="overwrite" id="overwrite" value="0" />                
            <div onclick="filePicker('filePicker')" class="uploadButton" id="upload_btn">choose file</div>
            <div style="width:0px; height:0px; overflow:hidden"><input type="file" value="upload" id="filePicker" name="uploadedfile" onChange="filePickerUpdate(this, 'upload_btn', 'fileUpload')"></div>
        </form>
        
        <table class="fileTable">
        	<thead>
            	<tr>
                	<th></th>
                	<th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
			</thead>
            <tbody>
				<?php
                $username = $_SESSION['username'];
                $dir    = "../../uploads/{$username}/";
                if (is_dir($dir)){
					if ($dh = opendir($dir)){
						$i = 0;
						while (($file = readdir($dh)) !== false){
							if(is_file($dir . $file)){
								$i++;
								$fp = $dir . $file;
								$info = pathinfo($fp);
								
								$fn = basename($fp, '.' . $info['extension']);
								$ft = $info['extension'];
								$fs = filesize($fp);
								
								$r = rand(10000, 10000000); //puts random number in download link to avoid issues with cache
								echo'
								<tr>
									<td>' . $i . '</td>
									<td><a href="' . htmlentities($fp) . '?r=' . $r . '" target="_blank">' . htmlentities($fn) . '</a></td>
									<td>' . $ft . '</td>
									<td>' . $fs . ' bytes</td>
									<td><a class="trashBttn" href="delete_file.php?file=' . htmlentities(basename($fp)) . '" title="delete"><a class="editBttn" href="#" onclick="rename(\'' . htmlentities(basename($fn)) . '\',\'' . $ft . '\')" title="rename"></a><a class="downloadBttn" href="' . htmlentities($fp) . '?r=' . $r . '" title="download" download></a><a class="shareBttn" href="#" onclick="share(\'' . htmlentities(basename($fp)) . '\')" title="share"></a></td>
								</tr>';							
							}
						}
						closedir($dh);
						if($i == 0){
							echo '<tr><td colspan="5">No files found. Click upload to add some!</td</tr>';
						}
					}else{
						echo '<tr><td colspan="5">Directory could not be opened</td</tr>';
					}
                }else{
                    echo '<tr><td colspan="5">Directory could not be found</td</tr>';
                }
                ?>
            </tbody>
        </table>
        
        
    </div>


	<div id="share" style="display:none">
    	<a href="#" onclick="closeShare()" id="closeShare">X</a>
    	<h2>Choose a user:</h2>
        <form>
        	<input type="text" id="userSearch" />
            <div id="shareButton" onClick="checkUser()">share</div>
        </form>
    </div>
    <div id="footer">
    	<p>Eliot Padzensky 435494&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Kenneth Geiler 431388&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="creative.txt" title="creative txt">creative.txt</a></p>
    </div>
</body>
</html>
