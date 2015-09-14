<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log In</title>    
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/flick/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="includes/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
function subLI(){
	var inpt = document.getElementById('username').value;
	if(unIsGood(inpt)){
		document.getElementById('logInForm').setAttribute('action','check_login.php');
		document.getElementById('logInForm').submit();
	}else{
		alert("Invalid username. Usernames cannot include characters /, \\, ?, *, %, :, |, \" <, >, . or spaces");
	}
}
function subRG(){
	var inpt = document.getElementById('username').value;
	if(unIsGood(inpt)){
		document.getElementById('logInForm').setAttribute('action','register.php');
		document.getElementById('logInForm').submit();
	}else{
		alert("Invalid username. Usernames cannot include characters /, \\, ?, *, %, :, |, \" <, >, . or spaces");
	}
}
function checkForm(){
	var inpt = document.getElementById('username').value;
	if(!unIsGood(inpt)){
		alert("Invalid username. Usernames cannot include characters /, \\, ?, *, %, :, |, \" <, >, . or spaces");
		return false;
	}
	return true;
}
</script>
</head>
<body>
	<div class="loginBox">
    	<form action="check_login.php" method="POST" id="logInForm" onSubmit="return checkForm()">
        	<table>
            	<tr>
                	<td colspan="2"><h1>Log In</h1></td>
                </tr>
                <?php
				if(isset($_GET['error'])){
					if($_GET['error'] == 1){
						echo '
						<tr class="errorRow">
							<td colspan="2">incorrect username!</td>
						</tr>';
					}else if($_GET['error'] == 2){
						echo '
						<tr class="errorRow">
							<td colspan="2">you must log in to access that page!</td>
						</tr>';
					}else if($_GET['error'] == 3){
						echo '
						<tr class="errorRow">
							<td colspan="2">that username already exists!</td>
						</tr>';
					}
				}
				?>
            	<tr>
                	<td>Username</td>
                    <td><input type="text" name="username" id="username" /></td>
                </tr>
                <tr>
                	<td></td>
                    <td>
                    	<div id="logInButton" onClick="subLI()">Log In</div>
                    	<div id="regButton" onClick="subRG()">Register</div>
                    </td>
                    
                </tr>
            </table>
        </form>
    </div>
    
    <div id="footer">
    	<p>Eliot Padzensky 435494&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Kenneth Geiler 431388&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="creative.txt" title="creative txt">creative.txt</a></p>
    </div>
</body>
</html>
