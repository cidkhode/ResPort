<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<title>ResPort Login</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<style>
		::-webkit-input-placeholder
		{
    		opacity: 0.9;
		}
	</style>
	<body style="min-width: 1280px;margin: auto;
				 background-image: url('background.png');
				 background-size:100% 100%; background-color: rgb(50,58,69);">
		<img src="logo.png" class="center-block" style = "width:200px; height:100px;">
		<hr style="border-width: 5px 0; margin-left:10px; margin-right:10px; border-color: #CC2127;">
		
		<div style="margin-top:-70px; display:block; margin-right:auto; margin-left:auto; text-align:center;">
			<img src="bioTech.png" style="border-radius:10px;width:300px; height:450px;margin-right: 20px; margin-left:20px;">
			<div style="border-radius:10px;display:inline-block;
						background-color: lightgrey; width:500px;
						border: 5px solid #CC2127;
						height:350px;
						margin-right: auto; margin-left: auto; position:relative; top:130px;
						text-align:center; font-family: 'Lucida Console'">
				<div style="margin-bottom:20px;" id="verification">
					Enter Credentials for Login
				</div>
				<div style="margin-bottom:20px;">
					<label style="display:inline-block; width:100px; text-align:left">NJIT UCID: </label>
					<input style="border:none; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center" 
						   id="ucid" type="text" placeholder="UCID">
					</input>
				</div>
				<div style="margin-bottom:20px;">
					<label style="display:inline-block; width:100px; text-align:left">Password:  </label>
					<input autocomplete="new-password" style="border:none; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center" 
						   id="password" type="password" placeholder="Password">
					</input>
				</div>
				<div style="margin-bottom:20px;">
					<button class="btn btn-default btn-md" id="loginButton" type="button" onclick="login()"><span>Login <span class="glyphicon glyphicon-log-in" style="color: #CC2127"></span><span></button>
				</div>
				<div style="margin-bottom:20px;">
					<a class="importantLinks" href="http://ist.njit.edu/ucid/">Forgot your UCID or Password?</a>
				</div>
				<div style="margin-bottom:20px;">
					<a class="importantLinks" href="https://www.njit.edu/research/home/">Click here for the NJIT Office of Research</a>
				</div>
				<div style="margin-bottom:20px;">
					<img src = "njitLogo.png" style = "width:70px; height:70px;">
				</div>
			</div>
			<img src="researchHexagons.png" style="border-radius:10px;width:350px; 
												   height:250px;margin-right: 20px; 
												   margin-left:20px;">
		</div>
	</body>
	<script>
		$(document).ready(function() 
		{
        	$("body").css("display", "none");
        	$("body").fadeIn(2000);
    	});
    	
    	var clicked = document.getElementById("password");
		clicked.addEventListener("keydown", function (e) 
		{
    		if (e.keyCode === 13) login();
		});

		function login()
		{
			var userNameString = document.getElementById("ucid").value.toLowerCase();
			var passwordString = document.getElementById("password").value;
			
			var xmlhttp = new XMLHttpRequest();
			var formData = 'username='+userNameString+'&password='+passwordString;
			xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/login/login_f.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    		xmlhttp.onreadystatechange = function() 
       	 	{
       	 	   	if (this.readyState == 4 && this.status == 200) 
        		{
    		   		var resultOfStudentLoginAttempt = this.responseText.trim('\n');
    		   	    var result = resultOfStudentLoginAttempt;
          		 	if(result == "GOODSTUDENT")
          		 	{
           				document.getElementById("verification").style.color = "green";
           				document.getElementById("verification").innerHTML = "WELCOME STUDENT";
           				document.cookie = "studentUser=" + userNameString + ";path=/";
           				window.open("https://web.njit.edu/~crk23/resport/student/studentProfile.php", "_self");
           			}
           			else if(result == "GOODFACULTY")
           			{
           				document.getElementById("verification").style.color = "green";
           				document.getElementById("verification").innerHTML = "WELCOME FACULTY";
           				document.cookie = "facultyUser=" + userNameString + ";path=/";
						window.open("https://web.njit.edu/~crk23/resport/faculty/facultyProfile.php", "_self");
           			}
           			else
           			{
           				document.getElementById("verification").style.color = "#CC2127";
						document.getElementById("verification").innerHTML = "ERROR! Invalid Credentials. Please Try Again!";
           		    }
       		   	}
    		};
      		xmlhttp.send(formData);
		}
	</script>
</html>