// JavaScript Document
$(function() {
	$(".uploadButton").tooltip({
		position: { my: "center top+10", at: "center bottom" },
		tooltipClass: "infoTooltip"
	});
});
$(".uploadButton").tooltip("disable");
//for handling styled file picker
//i is id of file input
function filePicker(i){
	$("#" + i).click();
}
//obj is file input
//i is id of div button
//f is id of form
function filePickerUpdate(obj){
	if(obj.value != "" && obj.value != null){
		var file = obj.value;
    	var fileName = file.split("\\");
		checkFile(fileName[fileName.length-1]);
	}
}
//returns true if the file already exists
function checkFile(f){
	$.ajax({
		url: "check_file.php",
		data: {fileName: f}, 
		async: true,
		method: "POST",
		success: function(data){
			//0=good 1=exists 2=error
			if(data.length > 1){
				data = 2;
			}
        	r = parseInt(data);
			if(r == 1){
				if(window.confirm("A file with this name already exists! Overwrite?")){
					document.getElementById('overwrite').value = '1';
					$("#fileUpload").submit();
				}else{
					location.reload();
				}
			}else if(r == 2){
				alert("There seems to be an error uploading you file");
			}else if(r == 0){
				$("#fileUpload").submit();
			}			
    	},
		error: function(e){
			alert("There seems to be an error uploading your file:\n" + e);
			location.reload();
		}
	});
}

//share functionality
var fname;
function share(fn){
	document.getElementById('share').style.display = "inline";
	fname = fn;
}
function checkUser(){
	var un = document.getElementById('userSearch').value;
	$.ajax({
		url: "isUser.php",
		data: {username: un}, 
		async: true,
		method: "POST",
		success: function(data){
			//0=doesNotExist 1=exists 2=error
			if(data.length > 1){
				data = 2;
			}
        	r = parseInt(data);
			if(r == 1){
				sendFile(un);					
			}else if(r == 2 || r == 0){
				alert("User " + un + " could not be found!");
			}			
    	},
		error: function(e){
			alert("User " + un + " could not be found!");
		}
	});
}
function sendFile(un){
	$.ajax({
		url: "share.php",
		data: {to: un, fname: fname}, 
		async: true,
		method: "POST",
		success: function(data){
			//0=doesNotExist 1=exists 2=error
			if(data == 'error'){
				alert("There was an error sharing your file!");				
			}
			closeShare();	
    	},
		error: function(e){
			alert("There was an error sharing your file!");
			closeShare();
		}
	});
}
function closeShare(){
	document.getElementById('share').style.display = "none";
	document.getElementById('userSearch').value = '';
}
//returning false = username is bad
//returning true = username is good
function unIsGood(username){
	var bad = ['/','\\','?','%','*',':','|','"','<','>','.',' '];
	for(var i = 0; i < bad.length; i++){
		if(username.indexOf(bad[i]) > -1){
			return false;
		}
	}
	return true;
}