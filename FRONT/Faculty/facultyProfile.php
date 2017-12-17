<!--
	Authors: 		Chidanand Khode
			 		Kevin Aizic
			 		- - - - - - - -
	Date: 			11/28/2017
					- - - - - - - -
	Project:		ResPort [Student Page]
					- - - - - - - -
	Description:	Portal for students and faculty 
					to access research opportunities
					within NJIT
-->

<?php 
	if(!isset($_COOKIE['facultyUser']))
	{
		header("Location: https://web.njit.edu/~crk23/resport/login/login.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<title>Welcome Faculty!</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
	</head>
	<style>
		::-webkit-input-placeholder
		{
    		opacity: 0.9;
		}
		#heartButton
		{
			margin-right:5px;
			outline:none;
		}
		
		#contactButton
		{
			margin-left:5px;
			outline:none;
		}
	</style>
	<body style="min-width: 1200px;margin: auto;
				 background-image: url('background.jpg'); background-repeat:no-repeat;
				 background-size:cover; background-attachment:fixed;" onload="loadPage()">
		<div style="position:relative;display:flex; justify-content: center; margin-bottom:-10px; margin-top:10px">
			<img src="logo.png" style = "width:100px; height:50px;">
			<button type="button" id="logout" onclick="logout()" style="right:2%; position:absolute" class="btn btn-default btn-md">Logout 
				<span class="glyphicon glyphicon-log-out" style="color: #CC2127"></span> 
			</button>
		</div>
		<hr style="border-width: 5px 0; margin-left:10px; margin-right:10px; border-color: #CC2127;">
		<div style="position:relative;display:block; margin-right:auto; margin-left:10%; text-align:center;">
			<div style="display:inline-block; margin-bottom:50px;
						height:350px;
						margin-right: auto; margin-left: auto;
						text-align:center; font-family: 'Lucida Console'; float:left;">
				<div style="margin-bottom:3.5%;">
					<label class="btn btn-default btn-file" id = "edit" style="height:35px; background-color:#CC2127; color:white">
							Edit Profile <span class="glyphicon glyphicon-pencil" style="color:white"></span>
							<input type="button" id = "editProfile" style="display:none;" onclick="editModeOn()"/>
					</label>
					<label class="btn btn-default btn-file" id = "save" style="height:35px; background-color:#CC2127; color:white">
							Save Profile <span class="glyphicon glyphicon-floppy-disk" style="color:white"></span>
							<input type="button" id = "saveProfile" style="display:none;" onclick="editModeOff()"/>
					</label>
					<button type="button" id="listStudents" class="btn btn-default btn-md"> Students That
						<span class="glyphicon glyphicon-heart" style="color: #CC2127"></span> 'ed
					</button>
				</div>
				
				<div style="margin-bottom:3.5%;">
					<label style="display:inline-block; width:250px; text-align:left">First Name: </label>
					<input disabled style="width:230px; border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="facultyFirstName" type="text" placeholder="First Name">
					</input>
				</div>
				<div style="margin-bottom:3.5%;">
					<label style="display:inline-block; width:250px; text-align:left">Last Name: </label>
					<input disabled style="width:230px; border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="facultyLastName" type="text" placeholder="Last Name">
					</input>
				</div>
				<div style="margin-bottom:3.5%;">
					<label style="display:inline-block; width:250px; text-align:left">Faculty ID: </label>
					<input disabled style="width:230px; border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="facultyID" type="text" placeholder="Faculty ID">
					</input>
				</div>
				<div style="margin-bottom:3.5%;">
					<label style="display:inline-block; width:250px; text-align:left">Faculty Email: </label>
					<input disabled style="width:230px; border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="facultyEmail" type="text" placeholder="NJIT Email">
					</input>
				</div>
				<div style="margin-bottom:3.5%;">
					<label style="display:inline-block; width:250px; text-align:left">Faculty Field Of Expertise: </label>
					<input disabled style="width:230px; border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="facultyField" type="text" placeholder="e.g. PhD Nuclear Physics">
					</input>
				</div>
				<div style="margin-bottom:3.5%;">
					<label style="display:inline-block; width:250px; text-align:left">Faculty Years of Experience: </label>
					<input disabled style="width:230px; border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="facultyExperience" type="text" placeholder="Years of Expertise">
					</input>
				</div>
				<div style="margin-bottom:3.5%;">
					<form style="display:inline-block; width:250px; text-align:left">
    					<select disabled class="selectpicker" style="opacity: 0.7; width:200px; background-color:white;text-align:center; color:#CC2127; text-align-last:center;" id="building">
        					<option disabled selected>Select Building...</option>
        					<option>Campbell Hall</option>
        					<option>Campus Center</option>
        					<option>Robert Van Houten Library (CAB)</option>
        					<option>Central King Building</option>
        					<option>Colton Hall</option>
        					<option>Council for Higher Ed.</option>
        					<option>Cullimore Hall</option>
        					<option>Cypress Residence Hall</option>
        					<option>Dorman Honors Residence Hall</option>
        					<option>Eberhardt Hall</option>
        					<option>Electrical and Computer Engineering Center</option>
        					<option>Enterprise Development Center 2</option>
							<option>Enterprise Development Center 3</option>
							<option>Faculty Memorial Hall</option>
							<option>Facilities Service Building</option>
							<option>Fenster Hall</option>
							<option>Fleischer Athletic Center</option>
							<option>Greek Way 05-07</option>
							<option>Greek Way 09-11</option>
							<option>Greek Way 13-15</option>
							<option>Greek Way 17-19</option>
							<option>Greek Way 21-23</option>
							<option>Guttenberg Information Technology Center</option>
							<option>Kupfrian Hall</option>
							<option>Laurel Residence Hall</option>
							<option>Laurel Residence Hall Extension</option>
							<option>Life Sciences and Engineering Center</option>
							<option>Mechanical Engineering Center</option>
							<option>Microelectronics Center</option>
							<option>Naimoli Family Athletic Center</option>
							<option>Oak Residence Hall</option>
							<option>Parking Deck/Student Mall</option>
							<option>Redwood Residence Hall</option>
							<option>Science and Technology Park Garage</option>
							<option>Specht Building</option>
							<option>Tiernan Hall</option>
							<option>Wellness and Events Center</option>
							<option>Weston Hall</option>
        					<option>York Center</option>
     					</select>
     				</form>
     				<input disabled style="width:230px; border-color:#CC2127; outline:none; 
							  border-radius:10px; padding-left: 10px; 
							  padding-right:10px; text-align:center; opacity: 0.7;" 
					   id="facultyOffice" type="text" placeholder="Office Number">
					</input>
				</div>
				<div style="margin-bottom:4.8%;">
					<form>
						<select class="selectpicker" disabled id="facultyCollege" style="opacity: 0.7; 
						background-color:white;text-align:center; text-align-last:center;">
							<option disabled selected>Select College...</option>
							<option>College of Architecture and Design</option>
							<option>College of Science and Liberal Arts</option>
							<option>Martin Tuchman School of Management</option>
							<option>Newark College of Engineering</option>
							<option>Ying Wu College of Computing</option>
						</select>
					</form>
				</div>
				<div id="verification" style="color:#CC2127; margin-bottom:14.3%;">
					Press the 'Edit Profile' button to make changes
				</div>
				<div id="applied" style="margin-bottom:3.5%;">
					<div>
						<h1>Students Who Hearted</h1>
					</div>
					<div style="margin-bottom:3.5%;">
						<input disabled readonly style="width:400px; border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center;" 
							   id="createdOpps" type="text" placeholder="Created Opps">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<button type="button" id="prevOpp" onclick="previousOpp()" class="btn btn-default btn-md"><span class="glyphicon glyphicon-hand-left" style="color: #CC2127"></span> 
						Previous Opp
						</button>
						<button type="button" id="nextOpp" onclick="nextOpp()" class="btn btn-default btn-md"> Next Opp
							<span class="glyphicon glyphicon-hand-right" style="color: #CC2127"></span> 
						</button>
					</div>
					<div style="margin-bottom:2%;">
						<label>List of Students:</label>
						<textarea readonly style="background-color:white;resize:none;margin-bottom:10px" 
							class="form-control" rows="12" id="applications"></textarea>
						<button type="button" id="prevApp" onclick="previousStudent()" class="btn btn-default btn-md">
							<span class="glyphicon glyphicon-chevron-up"></span> Previous Student
						</button>
						<button type="button" id="nextApp" onclick="nextStudent()" class="btn btn-default btn-md"> Next Student
							<span class="glyphicon glyphicon-chevron-down"></span>
						</button>
					</div>
					<div id="studentSwitched" style="margin-bottom:5%; color:green">
						&nbsp
					</div>
				</div>
			</div> <!--Left Side Div Ends-->
			<div style="display:inline-block; margin-bottom:50px;
						height:350px;
						margin-right: 10%; margin-left: auto; position:relative;
						text-align:center; font-family: 'Lucida Console'; float:right">
				<div>
					<h1 style="margin-top:0%;">Cr<span style="color:#CC2127">ea</span>te</h1>
				</div>
				<div style="margin-bottom:2.0%;">
					<label style="display:inline-block; width:180px; text-align:left">Name of Opportunity: </label>
					<input style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center;" 
						   id="oppName" type="text" placeholder="Name">
					</input>
				</div>
				<div style="width: 450px; margin-bottom:2.5%">
    				<!--College Filter-->
    				<div style="display:inline-block;">
    					<form>
							<select class="selectpicker" id="oppCollege" style="background-color:white;
							text-align:center; text-align-last:center;">
								<option disabled selected>Select College...</option>
								<option>College of Architecture and Design</option>
								<option>College of Science and Liberal Arts</option>
								<option>Martin Tuchman School of Management</option>
								<option>Newark College of Engineering</option>
								<option>Ying Wu College of Computing</option>
							</select>
						</form>
    				</div>
				</div>
				<div style="margin-bottom:2.5%;">
					<label style="display:inline-block; width:180px; text-align:left">Title of Candidate: </label>
					<input style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center;" 
						   id="titleOfCandidate" type="text" placeholder="e.g. Lab Assistant">
					</input>
				</div>
				<div style="margin-bottom:2.5%;">
					<label style="display:inline-block; width:180px; text-align:left">Number of Students: </label>
					<input style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center;" 
						   id="numberOfStudents" type="text" placeholder="# of Students">
					</input>
				</div>
				<div style="margin-bottom:2.5%;">
					<label style="display:inline-block; width:180px; text-align:left">Hours Per Week: </label>
					<input style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center;" 
						   id="hoursPerWeek" type="text" placeholder="# of Hours">
					</input>
				</div>
				<div style="display:inline-block; margin-bottom:2.5%">
    					<form>
							<select class="selectpicker" id="categoryOpp" style="background-color:white;
							text-align:center; text-align-last:center;">
								<option disabled selected>Select Category...</option>
								<option>Paid</option>
								<option>Work-Study</option>
								<optgroup></optgroup>
								<option>Volunteer</option>
								<option>For Credit</option>
								<option>Apprenticeship</option>
							</select>
						</form>
    				</div>
				<div style="margin-bottom:2.5%;">
					<label style="display:inline-block; text-align:left">Description / Requirements: </label>
					<textarea style="background-color:white;resize:none; margin-bottom:10px" 
						class="form-control" rows="5" placeholder = "Minumum of 10 characters" id="description"></textarea>
				</div>
				<div style="margin-bottom:2.5%">
					<button type="button" id="submitOpp" onclick="createOpp()" class="btn btn-default btn-md"> Submit
						<span class="glyphicon glyphicon-flash" style="color: #CC2127"></span> 
					</button>
				</div>
				<div id="createVerification" style="color:#CC2127; margin-bottom:4.0%;">
					&nbsp <!--Whitespace character that HTML doesn't ignore (because it ignores whitespace)-->
				</div>
				<div id= "facultyInfo">
					<div style="margin-bottom:2%">
						<h1>Student Info</h1>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student First Name: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentFirstName" type="text" placeholder="First Name">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student Last Name: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentLastName" type="text" placeholder="Last Name">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student ID: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentID" type="text" placeholder="Student ID">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student Email: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentEmail" type="text" placeholder="NJIT Email">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student GPA: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentGPA" type="text" placeholder="G.P.A">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student Major: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentMajor" type="text" placeholder="e.g. Biology">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student College: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentCollege" type="text" placeholder="College">
						</input>
					</div>
					<div style="margin-bottom:4%;">
						<label style="display:inline-block; width:230px; text-align:left">Student Class Rank: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="studentClassRank" type="text" placeholder="Class Rank">
						</input>
					</div>
					<div style="margin-bottom:2%;">
						<label style="display:inline-block; width:230px; text-align:left">Student Resume:</label>
						<a id="studentResume" style="color:green;cursor:pointer" target="">View</a>
					</div>
					<div style="margin-bottom:2%">
						<button type="button" id="acceptStudent" onclick="accept()" class="btn btn-default btn-md"> Accept
							<span class="glyphicon glyphicon-thumbs-up" style="color: green"></span> 
						</button>
						<a type="button" href="" id="infoContactButton" class="btn btn-default btn-md">
							<span class="glyphicon glyphicon-envelope" style="color: #CC2127"></span> Contact Student 
						</a>
						<button type="button" id="declineStudent" onclick="decline()" class="btn btn-default btn-md"> Decline
							<span class="glyphicon glyphicon-thumbs-down" style="color: #CC2127"></span> 
						</button>
					</div>
					<div id="statusVerification">
						&nbsp
					</div>
				</div>
			</div><!--Right Side Ends-->
		</div> <!--Container Div Ends-->
	</body>
	<script>
		$("#listStudents").click(function()
		{
			$('html,body').animate(
			{
				scrollTop: $("#applied").offset().top
			}, 'slow');
		});
		var editing=false;
		var countOfOpps = 1;
		var maxOppsInDB = 1;
		var maxOppsFound = false;
		var listOfStudents = [];
		var oppsCreatedBefore = false;
		var currStudent = 0;
		var studentsFound = false;
		var sizeOfList;
		var studentInfo = "";
		var stuArray = [];
		var profileCreated = false;
		var stuUCID = "";
		var oppTitle = "";
		function logout()
		{
			document.cookie = "facultyUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			window.open("https://web.njit.edu/~crk23/resport/login/login.php", "_self");
		}
		
		function loadPage()
		{
			var ucid = getUCID();
			var table = "Faculty";
			var xmlhttp = new XMLHttpRequest();
			var formData = 'ucid=' + ucid + '&tableCheck=' + table;
			xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/loadPage_f.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    		xmlhttp.onreadystatechange = function() 
       	 	{
       	    	if (this.readyState == 4 && this.status == 200) 
        		{
    		   		var result = this.responseText.trim('\n');
    		   	    var json = result;
   			   	    var jsonObj = JSON.parse(json);
   			   	    
   			   	    var firstName = jsonObj.first;
   			   	    var lastName = jsonObj.last;
   			   	    var id = jsonObj.facID;
   			   	    var email = jsonObj.email;
   			   	    var field = jsonObj.field;
   			   	    var experience = jsonObj.experience;
   			   	    var location = jsonObj.office;
   			   	    var building = location.split('_')[0];
   			   	    var office = location.split('_')[1];
   			   	    var college = jsonObj.college;
   			   	    var firstOpp = jsonObj.opName;
   			   	    var listStudents = jsonObj.students;
   			   	    var studentsInfo = jsonObj.studentsString;
   			   	    
   			   	    if(firstName)
   			   	    {
   			   	    	profileCreated = true;
   			   	    	document.getElementById("facultyFirstName").value = firstName;
   			   	    	document.getElementById("facultyLastName").value = lastName;
						document.getElementById("facultyID").value = id;
						document.getElementById("facultyEmail").value = email;
						document.getElementById("facultyField").value = field;
						document.getElementById("facultyExperience").value = experience;
						document.getElementById("facultyOffice").value = office;
						
						jQuery("#building option").filter(function()
						{
    						return $.trim($(this).text()) ==  building
						}).prop('selected', true);
						$('#building').selectpicker('refresh');			
								
						jQuery("#facultyCollege option").filter(function()
						{
    						return $.trim($(this).text()) ==  college
						}).prop('selected', true);
						$('#facultyCollege').selectpicker('refresh');
					}
					if(firstOpp)
					{
						document.getElementById("createdOpps").value=firstOpp;
						oppsCreatedBefore=true;
						oppTitle = firstOpp;
					}
					else
					{
						document.getElementById("createdOpps").value="N/A";
						oppsCreatedBefore=false;
						studentsFound = false;
						oppTitle = "";
					}
					if(listStudents && listStudents != 'x')
					{
						studentsFound = true;
						listOfStudents = listStudents.split("&");
						document.getElementById("applications").value = studentsInfo;
						var studentUCID = listOfStudents[currStudent];
						sizeOfList = listOfStudents.length;
						studentInfo = jsonObj.firstStudent;
						stuArray = studentInfo.split("&");
						document.getElementById("studentFirstName").value = stuArray[0];
						document.getElementById("studentLastName").value = stuArray[1];
						document.getElementById("studentID").value = stuArray[2];
						document.getElementById("studentEmail").value = stuArray[3];
						document.getElementById("infoContactButton").href = "mailto:" + stuArray[3];
						document.getElementById("studentGPA").value = stuArray[4];
						document.getElementById("studentMajor").value = stuArray[5];
						document.getElementById("studentCollege").value = stuArray[6];
						document.getElementById("studentClassRank").value = stuArray[7];
						stuUCID = stuArray[8];
						document.getElementById("statusVerification").style.color = "black";
						document.getElementById("statusVerification").innerHTML = "&nbsp"
						document.getElementById("studentResume").href = "https://docs.google.com/gview?url=https://s3.amazonaws.com/aws-resport/" + studentUCID + ".pdf";
						document.getElementById("studentResume").target="_blank";
						document.getElementById("studentSwitched").innerHTML = "Viewing: " + stuArray[0] + " " + stuArray[1];
					}
					else
					{
						studentsFound = false;
						stuUCID = "";
						document.getElementById("applications").value = "No students found!";
						document.getElementById("studentSwitched").innerHTML = "&nbsp"
					}
          		} 	
    		};
      		xmlhttp.send(formData);	
		}
		
		function createOpp()
		{
			if(profileCreated==false)
			{
				document.getElementById("createVerification").innerHTML = "You must complete your profile!";
			}
			else
			{
				var ucid = getUCID();
				var name = document.getElementById("oppName").value;
				var college = document.getElementById("oppCollege").value;
				var title = document.getElementById("titleOfCandidate").value;
				var numStudents = document.getElementById("numberOfStudents").value;
				var hours = document.getElementById("hoursPerWeek").value;
				var category = document.getElementById("categoryOpp").value;
				var description = document.getElementById("description").value;
				if(name.length == 0 ||
				   college == "Select College..." ||
				   title.length == 0 ||
				   numStudents.length == 0 ||
				   hours.length == 0 ||
				   category == "Select Category..." ||
				   description.length < 10)
				{
					document.getElementById("createVerification").innerHTML = "Please Fill Out Entire Opportunity!";
				}
				else
				{
					var xmlhttp = new XMLHttpRequest();
					var formData = 'ucid=' + ucid + '&name=' + name + '&college=' + college + '&title=' + title +
								   '&numStudents=' + numStudents + '&hours=' + hours + '&description=' + description + 
								   '&category=' + category;
					xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/create_f.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							var result = this.responseText.trim('\n');
							if(result == "Insert Successful")
							{
								document.getElementById("createVerification").style.color = "green";
								document.getElementById("createVerification").innerHTML = "Opportunity Created!";
								document.getElementById("oppName").value = "";
				
								jQuery("#oppCollege option").filter(function()
								{
									return $.trim($(this).text()) ==  "Select College..."
								}).prop('selected', true);
								$('#oppCollege').selectpicker('refresh'); 
				
								jQuery("#categoryOpp option").filter(function()
								{
									return $.trim($(this).text()) ==  "Select Category..."
								}).prop('selected', true);
								$('#categoryOpp').selectpicker('refresh'); 
								document.getElementById("titleOfCandidate").value = "";
								document.getElementById("numberOfStudents").value = "";
								document.getElementById("hoursPerWeek").value = "";
								document.getElementById("description").value = "";
				
							}
							else if(result == "Insert Unsuccessful")
							{
								document.getElementById("createVerification").style.color = "#CC2127";
								document.getElementById("createVerification").innerHTML = "Error In Creating Opportunity";
							}
							else
							{
								document.getElementById("createVerification").style.color = "#CC2127";
								document.getElementById("createVerification").innerHTML = result;
							}
						} 	
					};
					xmlhttp.send(formData);	
				}
      		}
		}
		
		function editModeOn()
		{
			editing=true;
			document.getElementById("verification").style.color = "#CC2127";
			document.getElementById("verification").innerHTML = "Profile Editing Mode";
			document.getElementById("facultyFirstName").disabled = false;
			document.getElementById("facultyLastName").disabled = false;
			document.getElementById("facultyID").disabled = false;
			document.getElementById("facultyEmail").disabled = false;
			document.getElementById("facultyOffice").disabled = false;
			document.getElementById("facultyField").disabled = false;
			document.getElementById("facultyExperience").disabled = false;
			$('#building').attr('disabled',false);
			$('#building').selectpicker('refresh');
			$('#facultyCollege').attr('disabled',false);
			$('#facultyCollege').selectpicker('refresh');
			document.getElementById("facultyFirstName").style.opacity = "1";
			document.getElementById("facultyLastName").style.opacity = "1";
			document.getElementById("facultyID").style.opacity = "1";
			document.getElementById("facultyEmail").style.opacity = "1";
			document.getElementById("facultyOffice").style.opacity = "1";
			document.getElementById("facultyField").style.opacity = "1";
			document.getElementById("facultyExperience").style.opacity = "1";
			document.getElementById("edit").style.backgroundColor = "#01D701";
			document.getElementById("building").style.opacity = "1";
			document.getElementById("saveProfile").disabled = false;
			document.getElementById("editProfile").disabled = true;
		}
		
		function editModeOff()
		{
			if(editing==true)
			{
				var facultyUCID = getUCID();
				var facultyFirstName = document.getElementById("facultyFirstName").value;
				var facultyLastName = document.getElementById("facultyLastName").value;
				var facultyID = document.getElementById("facultyID").value;
				var facultyEmail = document.getElementById("facultyEmail").value;
				var facultyField = document.getElementById("facultyField").value;
				var facultyExperience = document.getElementById("facultyExperience").value;
				var facultyBuilding = document.getElementById("building").value;
				var facultyOffice = facultyBuilding + '_' + document.getElementById("facultyOffice").value;
				var facultyCollege = document.getElementById("facultyCollege").value;
				
				if(facultyFirstName.length == 0 ||
				   facultyLastName.length == 0 ||
				   facultyID.length == 0 ||
				   facultyEmail.length == 0 ||
				   facultyField.length == 0  || 
				   facultyExperience.length == 0  || 
				   facultyOffice.length == 0 ||
				   facultyCollege == "Select College..." ||
				   facultyBuilding == "Select Building...")
			 
				{
					document.getElementById("verification").style.color = "#CC2127";
					document.getElementById("verification").innerHTML = "Please complete all fields!";
				}
				else
				{
					var xmlhttp = new XMLHttpRequest();
					var formData = 'facultyUCID=' + facultyUCID + '&facultyFirstName=' + facultyFirstName +
								   '&facultyLastName=' + facultyLastName + '&facultyID=' + facultyID +
								   '&facultyEmail=' + facultyEmail + '&facultyField=' + facultyField +
								   '&facultyExperience=' + facultyExperience + '&facultyOffice=' + facultyOffice +
								   '&facultyCollege=' + facultyCollege;
					xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/saveFProfile_f.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							var result = this.responseText.trim('\n');
							if(result == "Profile Updated")
							{
								profileCreated=true;
								document.getElementById("verification").style.color = "green";
								document.getElementById("verification").innerHTML = "Profile Successfully Updated!";
								document.getElementById("facultyFirstName").disabled = true;
								document.getElementById("facultyLastName").disabled = true;
								document.getElementById("facultyID").disabled = true;
								document.getElementById("facultyEmail").disabled = true;
								$('#building').attr('disabled',true);
								$('#building').selectpicker('refresh');
								$('#facultyCollege').attr('disabled',true);
								$('#facultyCollege').selectpicker('refresh');
								document.getElementById("facultyOffice").disabled = true;
								document.getElementById("facultyCollege").disabled = true;
								document.getElementById("facultyField").disabled = true;
								document.getElementById("facultyExperience").disabled = true;
								document.getElementById("facultyFirstName").style.opacity = ".7";
								document.getElementById("facultyLastName").style.opacity = ".7";
								document.getElementById("facultyID").style.opacity = ".7";
								document.getElementById("facultyEmail").style.opacity = ".7";
								document.getElementById("building").style.opacity = ".7";
								document.getElementById("facultyOffice").style.opacity = ".7";
								document.getElementById("facultyField").style.opacity = ".7";
								document.getElementById("facultyExperience").style.opacity = ".7";
								document.getElementById("edit").style.backgroundColor = "#CC2127";
								document.getElementById("saveProfile").disabled = true;
								document.getElementById("editProfile").disabled = false;
								editing=true;
							}
							else if(result == "Profile Not Updated")
							{
								document.getElementById("verification").style.color = "#CC2127";
								document.getElementById("verification").innerHTML = "Profile Not Updated";
							}
						}
					};
					xmlhttp.send(formData);	
				}
			}
		}
		
		function previousOpp()
		{
			if(oppsCreatedBefore==true)
			{
				var ucid = getUCID();
				countOfOpps--;
				if(countOfOpps <=1)
				{
					countOfOpps = 1;
				}
				var xmlhttp = new XMLHttpRequest();
				var formData = 'ucid=' + ucid + '&oppView='+countOfOpps;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/browseOppsF_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200) 
					{
					   var response = this.responseText.trim('\n');
						var json = response;
						var jsonObj = JSON.parse(json);
					
						var name = jsonObj.name;
						var list = jsonObj.students;
						var studentsInfo = jsonObj.studentsString;
						maxOppsInDB = parseInt(jsonObj.maxOpps);
						maxOppsFound=true;
						document.getElementById("createdOpps").value = name;
						oppTitle = name;
						if(list && list != 'x')
						{
							studentsFound = true;
							listOfStudents = list.split("&");
							var studentUCID = listOfStudents[currStudent];
							document.getElementById("applications").value = studentsInfo;
							currStudent=0;
							studentInfo = jsonObj.firstStudent;
							stuArray = studentInfo.split("&");
							document.getElementById("studentFirstName").value = stuArray[0];
							document.getElementById("studentLastName").value = stuArray[1];
							document.getElementById("studentID").value = stuArray[2];
							document.getElementById("studentEmail").value = stuArray[3];
							document.getElementById("infoContactButton").href = "mailto:" + stuArray[3];
							document.getElementById("studentGPA").value = stuArray[4];
							document.getElementById("studentMajor").value = stuArray[5];
							document.getElementById("studentCollege").value = stuArray[6];
							document.getElementById("studentClassRank").value = stuArray[7];
							stuUCID = stuArray[8];
							document.getElementById("statusVerification").style.color = "black";
							document.getElementById("statusVerification").innerHTML = "&nbsp"
							document.getElementById("studentResume").href = "https://docs.google.com/gview?url=https://s3.amazonaws.com/aws-resport/" + studentUCID + ".pdf";
							document.getElementById("studentResume").target="_blank";
							document.getElementById("studentSwitched").innerHTML = "Viewing: " + stuArray[0] + " " + stuArray[1];
						}
						else
						{
							studentsFound = false
							currStudent=0;
							studentInfo="";
							stuArray=[];
							document.getElementById("studentFirstName").value = "";
							document.getElementById("studentLastName").value = "";
							document.getElementById("studentID").value = "";
							document.getElementById("studentEmail").value = "";
							document.getElementById("infoContactButton").href = "";
							document.getElementById("studentGPA").value = "";
							document.getElementById("studentMajor").value = "";
							document.getElementById("studentCollege").value = "";
							document.getElementById("studentClassRank").value = "";
							document.getElementById("studentResume").href = "";
							document.getElementById("studentResume").target="";
							stuUCID = "";
							document.getElementById("applications").value = "No students found!";
							document.getElementById("studentSwitched").innerHTML = "&nbsp";
						}
					}
				};
				xmlhttp.send(formData);
 			}
		}
		
		function nextOpp()
		{
			if(oppsCreatedBefore==true)
			{
				var ucid = getUCID();
				countOfOpps++;
				if(countOfOpps>maxOppsInDB && maxOppsFound==true)
				{
					countOfOpps = maxOppsInDB;
				}
				var xmlhttp = new XMLHttpRequest();
				var formData = 'ucid=' + ucid + '&oppView='+countOfOpps;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/browseOppsF_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						var json = response;
						var jsonObj = JSON.parse(json);
					
						var name = jsonObj.name;
						var list = jsonObj.students;
						var studentsInfo = jsonObj.studentsString;
						maxOppsInDB = parseInt(jsonObj.maxOpps);
						maxOppsFound=true;
						document.getElementById("createdOpps").value = name;
						oppTitle = name;
						if(list && list != 'x')
						{
							listOfStudents = list.split("&");
							var studentUCID = listOfStudents[currStudent];
							document.getElementById("applications").value = studentsInfo;
							currStudent=0;
							studentsFound = true;
							studentInfo = jsonObj.firstStudent;
							stuArray = studentInfo.split("&");
							document.getElementById("studentFirstName").value = stuArray[0];
							document.getElementById("studentLastName").value = stuArray[1];
							document.getElementById("studentID").value = stuArray[2];
							document.getElementById("studentEmail").value = stuArray[3];
							document.getElementById("infoContactButton").href = "mailto:" + stuArray[3];
							document.getElementById("studentGPA").value = stuArray[4];
							document.getElementById("studentMajor").value = stuArray[5];
							document.getElementById("studentCollege").value = stuArray[6];
							document.getElementById("studentClassRank").value = stuArray[7];
							stuUCID = stuArray[8];
							document.getElementById("statusVerification").style.color = "black";
							document.getElementById("statusVerification").innerHTML = "&nbsp"
							document.getElementById("studentResume").href = "https://docs.google.com/gview?url=https://s3.amazonaws.com/aws-resport/" + studentUCID + ".pdf";
							document.getElementById("studentResume").target="_blank";
							document.getElementById("studentSwitched").innerHTML = "Viewing: " + stuArray[0] + " " + stuArray[1];
						}
						else
						{
							studentsFound = false
							currStudent=0;
							studentInfo="";
							stuArray=[];
							document.getElementById("studentFirstName").value = "";
							document.getElementById("studentLastName").value = "";
							document.getElementById("studentID").value = "";
							document.getElementById("studentEmail").value = "";
							document.getElementById("infoContactButton").href = "";
							document.getElementById("studentGPA").value = "";
							document.getElementById("studentMajor").value = "";
							document.getElementById("studentCollege").value = "";
							document.getElementById("studentClassRank").value = "";
							document.getElementById("studentResume").href = "";
							document.getElementById("studentResume").target="";
							stuUCID = "";
							document.getElementById("statusVerification").style.color = "black";
							document.getElementById("statusVerification").innerHTML = "&nbsp"
							document.getElementById("applications").value = "No students found!";
							document.getElementById("studentSwitched").innerHTML = "&nbsp";
						}
					}
				};
				xmlhttp.send(formData);
    		}
		}
		
		function getUCID()
		{
			var name = "facultyUser=";
			var nameOfCookie = "";
			var cookieDecoded = decodeURIComponent(document.cookie);
			var arrayOfCookieData = cookieDecoded.split(';');
			var lengthOfArray = arrayOfCookieData.length;
			var z=0;
			while(z<lengthOfArray)
			{
				var cookie = arrayOfCookieData[z];
				while (cookie.charAt(0) == " ") 
				{
   		    		cookie = cookie.substring(1);
			    }
				if(cookie.indexOf(name) == 0)
				{
					nameOfCookie = cookie.substring(name.length, cookie.length);
					break;
				}
				z++;
			}
			return nameOfCookie;
		}
		
		function previousStudent()
		{
			sizeOfList = listOfStudents.length;
			if(studentsFound == true && sizeOfList>1)
			{
				currStudent--;
				if(currStudent<0) currStudent=0;
				var studentUCID = listOfStudents[currStudent];
				
				var xmlhttp = new XMLHttpRequest();
				var formData = 'ucid=' + studentUCID;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/browseStudents_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						var json = response;
						var jsonObj = JSON.parse(json);
						studentInfo = jsonObj.thisStudent;
						stuArray = studentInfo.split("&");
						document.getElementById("studentFirstName").value = stuArray[0];
						document.getElementById("studentLastName").value = stuArray[1];
						document.getElementById("studentID").value = stuArray[2];
						document.getElementById("studentEmail").value = stuArray[3];
						document.getElementById("infoContactButton").href = "mailto:" + stuArray[3];
						document.getElementById("studentGPA").value = stuArray[4];
						document.getElementById("studentMajor").value = stuArray[5];
						document.getElementById("studentCollege").value = stuArray[6];
						document.getElementById("studentClassRank").value = stuArray[7];
						stuUCID = stuArray[8];
						document.getElementById("statusVerification").style.color = "black";
						document.getElementById("statusVerification").innerHTML = "&nbsp"
						document.getElementById("studentResume").href = "https://docs.google.com/gview?url=https://s3.amazonaws.com/aws-resport/" + studentUCID + ".pdf";
						document.getElementById("studentResume").target="_blank";
						document.getElementById("studentSwitched").innerHTML = "Student Switched! Viewing: " + stuArray[0] + " " + stuArray[1];
					}
				};
				xmlhttp.send(formData);
			}
		}
		
		function nextStudent()
		{
			sizeOfList = listOfStudents.length;
			if(studentsFound == true && sizeOfList>1)
			{
				currStudent++;
				if(currStudent==sizeOfList) currStudent--;
				var studentUCID = listOfStudents[currStudent];
				
				var xmlhttp = new XMLHttpRequest();
				var formData = 'ucid=' + studentUCID;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/browseStudents_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function()
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						var json = response;
						var jsonObj = JSON.parse(json);
						studentInfo = jsonObj.thisStudent;
						stuArray = studentInfo.split("&");
						document.getElementById("studentFirstName").value = stuArray[0];
						document.getElementById("studentLastName").value = stuArray[1];
						document.getElementById("studentID").value = stuArray[2];
						document.getElementById("studentEmail").value = stuArray[3];
						document.getElementById("infoContactButton").href = "mailto:" + stuArray[3];
						document.getElementById("studentGPA").value = stuArray[4];
						document.getElementById("studentMajor").value = stuArray[5];
						document.getElementById("studentCollege").value = stuArray[6];
						document.getElementById("studentClassRank").value = stuArray[7];
						stuUCID = stuArray[8];
						document.getElementById("statusVerification").style.color = "black";
						document.getElementById("statusVerification").innerHTML = "&nbsp"
						document.getElementById("studentResume").href = "https://docs.google.com/gview?url=https://s3.amazonaws.com/aws-resport/" + studentUCID + ".pdf";
						document.getElementById("studentResume").target="_blank";
						document.getElementById("studentSwitched").innerHTML = "Student Switched! Viewing: " + stuArray[0] + " " + stuArray[1];
					}
				};
				xmlhttp.send(formData);
			}
		}
		
		function accept()
		{
			if(stuUCID.length>0)
			{
				var xmlhttp = new XMLHttpRequest();
				var formData = 'status=accept' + '&ucid='+stuUCID + '&oppTitle=' + oppTitle;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/changeStatus_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						if(response == "ACCEPTED")
						{
							document.getElementById("statusVerification").style.color = "green";
							document.getElementById("statusVerification").innerHTML = "Accepted!";
						}
						else if(response == "ALREADY ACCEPTED")
						{
							document.getElementById("statusVerification").style.color = "green";
							document.getElementById("statusVerification").innerHTML = "Already Accepted";
						}
						else
						{
							document.getElementById("statusVerification").style.color = "#CC2127";
							document.getElementById("statusVerification").innerHTML = response;//"Something Went Wrong...";
						}
					}
				};
				xmlhttp.send(formData);
			}
			else
			{
				document.getElementById("statusVerification").style.color = "#CC2127";
				document.getElementById("statusVerification").innerHTML = "No Student to Accept!"
			}
		}
		
		function decline()
		{
			if(stuUCID.length>0)
			{
				var xmlhttp = new XMLHttpRequest();
				var formData = 'status=reject' + '&ucid='+stuUCID + '&oppTitle=' + oppTitle;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/faculty/changeStatus_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						if(response == "REJECTED")
						{
							document.getElementById("statusVerification").style.color = "#CC2127";
							document.getElementById("statusVerification").innerHTML = "Rejected";
						}
						else if(response == "ALREADY REJECTED")
						{
							document.getElementById("statusVerification").style.color = "#CC2127";
							document.getElementById("statusVerification").innerHTML = "Already Rejected";
						}
						else
						{
							document.getElementById("statusVerification").style.color = "#CC2127";
							document.getElementById("statusVerification").innerHTML = response;//"Something Went Wrong...";
						}
					}
				};
				xmlhttp.send(formData);
			}
			else
			{
				document.getElementById("statusVerification").style.color = "#CC2127";
				document.getElementById("statusVerification").innerHTML = "No Student to Reject!"
			}
		}
	</script>
</html>