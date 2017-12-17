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
	if(!isset($_COOKIE['studentUser']))
	{
		header("Location: https://web.njit.edu/~crk23/resport/login/login.php");
	}
?>
<?php 
	if(!isset($_COOKIE['studentUser']))
	{
		header("Location: https://web.njit.edu/~crk23/resport/login/login.php");
	}

    $access_key         = "accesskey"; //Access Key
	$secret_key         = "secretkey"; //Secret Key
	$my_bucket          = "aws-resport"; //bucket name
	$region             = "us-east-1"; //bucket region
	$success_redirect   = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $allowd_file_size   = "1048579"; //1 MB allowed Size (~20 pages worth of pdf)
	
	//dates
	$short_date         = gmdate('Ymd'); //short date
	$iso_date           = gmdate("Ymd\THis\Z"); //iso format date
	$expiration_date    = gmdate('Y-m-d\TG:i:s\Z', strtotime('+1 hours')); //policy expiration 1 hour from now
	$policy = utf8_encode(json_encode(array(
	                    'expiration' => $expiration_date,  
	                    'conditions' => array(
	                        array('acl' => 'public-read'),  
	                        array('bucket' => $my_bucket), 
   	                    	//array('success_action_redirect' => $success_redirect),
                            //array('success_action_status' => '204'),
   	                    	array('eq', '$key', $_COOKIE[studentUser].'.pdf'),
                            //array('starts-with', '$Content-Type', 'application/pdf'),
   	                    	array('content-length-range', '1', $allowd_file_size), 
   	                    	array('x-amz-credential' => $access_key.'/'.$short_date.'/'.$region.'/s3/aws4_request'),
   	                    	array('x-amz-algorithm' => 'AWS4-HMAC-SHA256'),
                        	array('X-amz-date' => $iso_date)
                        )))); 

	//Signature calculation (AWS Signature Version 4)   
	//For more info http://docs.aws.amazon.com/AmazonS3/latest/API/sig-v4-authenticating-requests.html  
	$kDate = hash_hmac('sha256', $short_date, 'AWS4' . $secret_key, true);
	$kRegion = hash_hmac('sha256', $region, $kDate, true);
	$kService = hash_hmac('sha256', "s3", $kRegion, true);
	$kSigning = hash_hmac('sha256', "aws4_request", $kService, true);
	$signature = hash_hmac('sha256', base64_encode($policy), $kSigning);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<title>Welcome Student!</title>
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
		}
		
		#unheartButton
		{
			margin-left:5px;
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
				<div style="margin-bottom:2%;">
					<label class="btn btn-default btn-file" id = "edit" style="height:35px; background-color:#CC2127; color:white">
							Edit Profile <input type="button" id = "editProfile" style="display:none;" onclick="editModeOn()"/>
					</label>
					<label class="btn btn-default btn-file" id = "save" style="height:35px; background-color:#CC2127; color:white">
							Save Profile <input type="button" disabled id = "saveProfile" style="display:none;" onclick="editModeOff()"/>
					</label>
					<button type="button" id="heartedOpps" class="btn btn-default btn-md">
						<span class="glyphicon glyphicon-folder-open" style="color: #CC2127"></span> Hearted Opps 
					</button>
				</div>
				<div style="margin-bottom:1.5%;">
					<label style="display:inline-block; width:150px; text-align:left">First Name: </label>
					<input disabled style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="studentFirstName" type="text" placeholder="First Name">
					</input>
				</div>
				<div style="margin-bottom:1.5%;">
					<label style="display:inline-block; width:150px; text-align:left">Last Name: </label>
					<input disabled style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="studentLastName" type="text" placeholder="Last Name">
					</input>
				</div>
				<div style="margin-bottom:1.5%;">
					<label style="display:inline-block; width:150px; text-align:left">Student ID: </label>
					<input disabled style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="studentID" type="text" placeholder="Student ID">
					</input>
				</div>
				<div style="margin-bottom:1.5%;">
					<label style="display:inline-block; width:150px; text-align:left">Student Email: </label>
					<input disabled style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="studentEmail" type="text" placeholder="NJIT Email">
					</input>
				</div>
				<div style="margin-bottom:1.5%;">
					<label style="display:inline-block; width:150px; text-align:left">Student Major: </label>
					<input disabled style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="studentMajor" type="text" placeholder="e.g. Biology">
					</input>
				</div>
				<div style="margin-bottom:1.5%;">
					<label style="display:inline-block; width:150px; text-align:left">Student GPA: </label>
					<input disabled style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center; opacity: 0.7;" 
						   id="studentGPA" type="text" placeholder="G.P.A">
					</input>
				</div>
				<div style="margin-bottom:1.5%;">
					<form>
						<select class="selectpicker" disabled id="studentClassRank" style="opacity: 0.7; 
						background-color:white;text-align:center; text-align-last:center;">
							<option selected disabled>Select Class Standing...</option>
							<optgroup>
								<option>[B] Senior 91-130 C</option>
								<option>[B] Junior 57-90 C</option>
								<option>[B] Sophomore 29-56 C</option>
								<option>[B] Freshman 0-28 C</option>
							</optgroup>
							<optgroup>
								<option>[M] 1st Year 0-7 C</option>
								<option>[M] 2nd Year 8-15 C</option>
								<option>[M] 3rd Year 16-22 C</option>
								<option>[M] 4th Year 22-30 C</option>
							</optgroup>
							<optgroup>
								<option>PhD</option>
							</optgroup>
						</select>
					</form>
				</div>
				<div style="margin-bottom:1.5%;">
					<form>
						<select class="selectpicker" disabled id="studentCollege" style="opacity: 0.7; 
						background-color:white;text-align:center; text-align-last:center;">
							<option selected disabled>Select College...</option>
							<option>College of Architecture and Design</option>
							<option>College of Science and Liberal Arts</option>
							<option>Martin Tuchman School of Management</option>
							<option>Newark College of Engineering</option>
							<option>Ying Wu College of Computing</option>
						</select>
					</form>
				</div>
				<div id="verification" style="color:#CC2127; margin-bottom:2%;">
					Press the 'Edit Profile' button to make changes
				</div>
				<hr style="margin-bottom:10px; border-color:rgb(50,58,69); border-width: 2px;">
				<div style="margin-bottom:10px;">
					<label>Please select a resumé to upload (ext: PDF)<br>
						   You must name your document (<?php echo $_COOKIE["studentUser"];?>.PDF)
					</label>
				</div>
				<div style="margin-bottom:10px;">
					<form action="http://<?= $my_bucket ?>.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
						<input type="hidden" name="key" value="${filename}" />
						<input type="hidden" name="acl" value="public-read" />
						<input type="hidden" name="X-Amz-Credential" value="<?= $access_key; ?>/<?= $short_date; ?>/<?= $region; ?>/s3/aws4_request" />
						<input type="hidden" name="X-Amz-Algorithm" value="AWS4-HMAC-SHA256" />
						<input type="hidden" name="X-Amz-Date" value="<?=$iso_date ; ?>" />
						<input type="hidden" name="Policy" value="<?=base64_encode($policy); ?>" />
						<input type="hidden" name="X-Amz-Signature" value="<?=$signature ?>" />
						<label class="btn btn-default btn-file" style="height:35px; background-color:#CC2127; color:white">
    						Select File... <input id="fileToUpload" type="file" name="file" style="display:none; margin: 0 auto; width:171px; margin-bottom:10px;" onchange="validFile()"/>
    					</label>
    					<label class="btn btn-default btn-file" style="height:35px; background-color:#CC2127; color:white">
							Upload File <input id="submitter" disabled type="submit" style="display:none;" value="Upload File" onclick="getFileName()"/>
						</label>
					</form>
				</div>
				<div id="fileUploaded" style="margin-bottom:9.3%">
					File Unselected...
				</div>
				<div id="applied" style="margin-bottom:3.5%;">
					<div>
						<h1>Submitted Applications</h1>
					</div>
					<div style="margin-bottom:1.5%;">
						<label style="display:inline-block; width:180px; text-align:left">Filter By Faculty: </label>
						<input style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center;" 
							   id="professorAppUCID" type="text" placeholder="Professor UCID">
						</input>
					</div>
					<div style="width: 450px;">
    					<!--College Filter-->
    					<div style="display:inline-block">
    						<form>
								<select class="selectpicker" id="studentCollegeAppFilter" style="opacity: 0.7; 
								background-color:white;text-align:center; text-align-last:center;">
									<option selected disabled>Filter College By...</option>
									<option>College of Architecture and Design</option>
									<option>College of Science and Liberal Arts</option>
									<option>Martin Tuchman School of Management</option>
									<option>Newark College of Engineering</option>
									<option>Ying Wu College of Computing</option>
								</select>
							</form>
						</div>
    					<div style="display:inline-block; margin-left:3%;margin-bottom:3.5%;">
    						<label class="btn btn-default btn-file" style="height:35px; background-color:#CC2127; color:white">
									Filter <input type="button" onclick = "setAppFilter()" id = "setAppFilters" style="display:none;" onclick="filter()"/>
							</label>
							<label class="btn btn-default btn-file" style="height:35px; background-color:#CC2127; color:white">
									Clear <input type="button" onclick = "clearAppFilter()" id = "clearAppFilters" style="display:none;" onclick="filter()"/>
							</label>
						</div>
					</div>
					<div id="appFilterVerification" style="margin-top:-2%;margin-bottom:1%; color:#CC2127">
						No Filter Set
					</div>
					<div style="margin-bottom:25px;">
						<label id="status">Status: </label>
						<textarea readonly style="background-color:white;resize:none;margin-bottom:10px" 
							class="form-control" rows="13" id="applications"></textarea>
						<button type="button" id="prevApp" onclick = "prevAppliedOpp()" class="btn btn-default btn-md">
							<span class="glyphicon glyphicon-chevron-left"></span> Previous
						</button>
						<button type="button" id="nextApp" onclick = "nextAppliedOpp()" class="btn btn-default btn-md"> Next
							<span class="glyphicon glyphicon-chevron-right"></span>
						</button>
					</div>
				</div>
			</div> <!--Left Side Div Ends-->
			<div style="display:inline-block; margin-bottom:50px;
						height:350px;
						margin-right: 10%; margin-left: auto; position:relative;
						text-align:center; font-family: 'Lucida Console'; float:right">
				<div style="margin-bottom:2%;">
					<label style="display:inline-block; width:180px; text-align:left">Filter By Faculty: </label>
					<input style="border-color:#CC2127; outline:none; 
								  border-radius:10px; padding-left: 10px; 
								  padding-right:10px; text-align:center;" 
						   id="professorUCID" type="text" placeholder="Professor UCID">
					</input>
				</div>
				<div style="width: 450px">
    				<!--College Filter-->
    				<div style="display:inline-block">
    					<form>
							<select class="selectpicker" id="studentCollegeFilter" style="opacity: 0.7; 
							background-color:white;text-align:center; text-align-last:center;">
								<option selected disabled>Filter College By...</option>
								<option>College of Architecture and Design</option>
								<option>College of Science and Liberal Arts</option>
								<option>Martin Tuchman School of Management</option>
								<option>Newark College of Engineering</option>
								<option>Ying Wu College of Computing</option>
							</select>
						</form>
					</div>
    				<div style="display:inline-block; margin-left:3%;margin-bottom:1%;">
    					<label class="btn btn-default btn-file"  style="height:35px; background-color:#CC2127; color:white">
								Filter <input type="button" id = "setFilters" style="display:none;" onclick="setFilter()"/>
						</label>
						<label class="btn btn-default btn-file" style="height:35px; background-color:#CC2127; color:white">
								Clear <input type="button" id = "clearFilters" style="display:none;" onclick="clearFilter()"/>
						</label>
					</div>
				</div>
				<div id="filterVerification" style="color:#CC2127">
					No Filter Set
				</div>
				<div style="margin-bottom:1.6%;">
					<label>Opportunities:</label>
					<textarea readonly style="background-color:white;resize:none; margin-bottom:10px" 
						class="form-control" rows="13" id="opportunity"></textarea>
					<button type="button" id="prevOpp" onclick="previousOpp()" class="btn btn-default btn-md">
						<span class="glyphicon glyphicon-chevron-left"></span> Previous
					</button>
					<button type="button" id="nextOpp" onclick="nextOpp()" class="btn btn-default btn-md"> Next
						<span class="glyphicon glyphicon-chevron-right"></span>
					</button>
				</div>
				<div style="margin-bottom:2%">
					<button type="button" onclick="heart()" id="heartButton" class="btn btn-default btn-md">
						<span class="glyphicon glyphicon-heart" style="color: #CC2127"></span> Heart 
					</button>
					<button type="button" id="unheartButton" id="unheartButton" onclick="unHeart()" class="btn btn-default btn-md">
						<span class="glyphicon glyphicon-heart-empty" style="color: #CC2127"></span> Un-Heart 
					</button>
				</div>
				<div id="heartVerification" style="color:green; margin-bottom:10%">
					&nbsp
				</div>
				<div id= "facultyInfo">
					<div style="margin-bottom:2%">
						<h1>Faculty Info</h1>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty First Name: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyFirstName" type="text" placeholder="First Name">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty Last Name: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyLastName" type="text" placeholder="Last Name">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty Email: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyEmail" type="text" placeholder="NJIT Email">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty Field of Expertise: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyExpertise" type="text" placeholder="Field Expertise">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty Experience (Years): </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyExperience" type="text" placeholder="Field Experience">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty College: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyCollege" type="text" placeholder="College">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty Building: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyBuilding" type="text" placeholder="Building">
						</input>
					</div>
					<div style="margin-bottom:3.5%;">
						<label style="display:inline-block; width:230px; text-align:left">Faculty Office Number: </label>
						<input disabled style="border-color:#CC2127; outline:none; 
									  border-radius:10px; padding-left: 10px; 
									  padding-right:10px; text-align:center; opacity: 0.7;" 
							   id="facultyRoom" type="text" placeholder="Office Number">
						</input>
					</div>
					<div style="margin-bottom:1%;">
						<a type="button" id="infoContactButton" class="btn btn-default btn-lg">
						<span class="glyphicon glyphicon-envelope" style="color: #CC2127"></span> Contact Faculty 
					</a>
					</div>
				</div>
			</div><!--Right Side Ends-->
		</div> <!--Container Div Ends-->
	</body>
	<script>
		var countOfOpps = 1;
		var maxOppsInDB = 1;
		var countOfAppOpps = 0;
		var maxAppOppsInDB = 0;
		var collegeFilter = "none";
		var facFilter = "none";
		var collegeAppFilter = "none";
		var facAppFilter = "none";
		var maxOppsFound = false;
		var maxAppOppsFound = false;
		var oppID = "";
		var profileCreated = false;
		var filterCleared = false;
		var appFilterCleared = false;
		var appOppId = "";
		var appliedBefore = false;
		var teacherEmail = "";
		var status = "";
		function logout()
		{
			document.cookie = "studentUser=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			window.open("https://web.njit.edu/~crk23/resport/login/login.php", "_self");
		}
		
		function loadPage()
		{
			var ucid = getUCID();
			var table = "Student";
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
   			   	    
   			   	    oppID = jsonObj.id;
   			   	    var firstName = jsonObj.first;
   			   	    var lastName = jsonObj.last;
   			   	    var id = jsonObj.stuID;
   			   	    var email = jsonObj.email;
   			   	    var major = jsonObj.major;
   			   	    var gpa = jsonObj.gpa;
   			   	    var college = jsonObj.college;
   			   	    var classRank = jsonObj.classStanding;
   			   	    var opp = jsonObj.opp;
   			   	    var firstOpp = jsonObj.firstOpp;
   			   	    var facInfo = jsonObj.facInfo;
   			   	    
   			   	    if(firstName)
   			   	    {
   			   	    	profileCreated = true;
   			   	    	document.getElementById("studentFirstName").value = firstName;
   			   	    	document.getElementById("studentLastName").value = lastName;
						document.getElementById("studentID").value = id;
						document.getElementById("studentEmail").value = email;
						document.getElementById("studentMajor").value = major;
						document.getElementById("studentGPA").value = gpa;
						jQuery("#studentClassRank option").filter(function()
						{
    						return $.trim($(this).text()) ==  classRank
						}).prop('selected', true);
						$('#studentClassRank').selectpicker('refresh');
								
						jQuery("#studentCollege option").filter(function()
						{
    						return $.trim($(this).text()) ==  college
						}).prop('selected', true);
						$('#studentCollege').selectpicker('refresh');
					}
					document.getElementById("opportunity").value = opp;
					if(firstOpp.length>129)
					{
						document.getElementById("applications").value = firstOpp;
						appOppId = jsonObj.firstID;
						status = jsonObj.status;
						if(status.includes("Accepted"))
						{
							document.getElementById("status").style.color = "green";
						}
						else if(status.includes("Rejected"))
						{
							document.getElementById("status").style.color = "#CC2127";
						}
						else if(status.includes("Pending"))
						{
							document.getElementById("status").style.color = "black";
						}
						document.getElementById("status").innerHTML = "Status: " + status;
						appliedBefore = true;
						var faculty = facInfo.split("&");
						document.getElementById("facultyFirstName").value = faculty[0];
						document.getElementById("facultyLastName").value = faculty[1];
						document.getElementById("facultyEmail").value = faculty[2];
						document.getElementById("facultyExpertise").value = faculty[3];
						document.getElementById("facultyExperience").value = faculty[4];
						document.getElementById("facultyCollege").value = faculty[5];
						var facBuilding = faculty[6].split("_");
						document.getElementById("facultyBuilding").value = facBuilding[0];
						document.getElementById("facultyRoom").value = facBuilding[1];
						teacherEmail = faculty[2];
						document.getElementById("infoContactButton").href = "mailto:" + teacherEmail;
						countOfAppOpps = 1;
						maxAppOppsInDB = 1;	
					}
					else
					{
						document.getElementById("applications").value = "Did not apply to any!";
						appliedBefore = false;
						appOppId = "";
						teacherEmail = "";
						status = "";
						document.getElementById("status").style.color = "black";
						document.getElementById("infoContactButton").href = "";
					}
          		} 	
    		};
      		xmlhttp.send(formData);	
		}
		
		function prevAppliedOpp()
		{
			if(appliedBefore==true)
			{
				var ucid = getUCID();
				countOfAppOpps--;
				if(countOfAppOpps <=1)
				{
					countOfAppOpps = 1;
				}
				
				var xmlhttp = new XMLHttpRequest();
				var formData = 'collegeFilter=' + collegeAppFilter + '&oppView='+countOfAppOpps + '&facFilter=' + facAppFilter + '&ucid=' + ucid;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/subApps_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						var json = response;
						var jsonObj = JSON.parse(json);
						var result = jsonObj.opp;
					
						appOppID = jsonObj.id;
						maxAppOppsInDB = parseInt(jsonObj.maxOpps);
						maxAppOppsFound=true;
						if(result.length == 129)
						{
							document.getElementById("applications").value = "No opportunities found!";
							document.getElementById("facultyFirstName").value = "";
							document.getElementById("facultyLastName").value = "";
							document.getElementById("facultyEmail").value = "";
							document.getElementById("facultyExpertise").value = "";
							document.getElementById("facultyExperience").value = "";
							document.getElementById("facultyCollege").value = "";
							document.getElementById("facultyBuilding").value = "";
							document.getElementById("facultyRoom").value = "";
							status = "";
							document.getElementById("status").style.color = "black";
							document.getElementById("status").innerHTML = "Status: ";
							teacherEmail = "";
							document.getElementById("infoContactButton").href = "";
						}
						else
						{
							document.getElementById("applications").value = result;
							var facInfo = jsonObj.facInfo;
							var faculty = facInfo.split("&");
							status = jsonObj.status;
							if(status.includes("Accepted"))
							{
								document.getElementById("status").style.color = "green";
							}
							else if(status.includes("Rejected"))
							{
								document.getElementById("status").style.color = "#CC2127";
							}
							else if(status.includes("Pending"))
							{
								document.getElementById("status").style.color = "black";
							}
							document.getElementById("status").innerHTML = "Status: " + status;
							document.getElementById("facultyFirstName").value = faculty[0];
							document.getElementById("facultyLastName").value = faculty[1];
							document.getElementById("facultyEmail").value = faculty[2];
							document.getElementById("facultyExpertise").value = faculty[3];
							document.getElementById("facultyExperience").value = faculty[4];
							document.getElementById("facultyCollege").value = faculty[5];
							var facBuilding = faculty[6].split("_");
							document.getElementById("facultyBuilding").value = facBuilding[0];
							document.getElementById("facultyRoom").value = facBuilding[1];
							teacherEmail = faculty[2];
							document.getElementById("infoContactButton").href = "mailto:" + teacherEmail;
						}
					}
				};
				xmlhttp.send(formData);
			}
		}
		
		function nextAppliedOpp()
		{
			if(appliedBefore==true)
			{
				var ucid = getUCID();
				countOfAppOpps++;
				if(countOfAppOpps>maxAppOppsInDB && maxAppOppsFound==true)
				{
					countOfAppOpps = maxAppOppsInDB;
				}
				var xmlhttp = new XMLHttpRequest();
				var formData = 'collegeFilter=' + collegeAppFilter + '&oppView='+countOfAppOpps + '&facFilter=' + facAppFilter + '&ucid=' + ucid;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/subApps_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						var response = this.responseText.trim('\n');
						var json = response;
						var jsonObj = JSON.parse(json);
					
						appOppID = jsonObj.id;
						var result = jsonObj.opp;
						maxAppOppsInDB = parseInt(jsonObj.maxOpps);
						maxAppOppsFound=true;
						if(result.length == 129)
						{
							document.getElementById("applications").value = "No opportunities found!";
							document.getElementById("facultyFirstName").value = "";
							document.getElementById("facultyLastName").value = "";
							document.getElementById("facultyEmail").value = "";
							document.getElementById("facultyExpertise").value = "";
							document.getElementById("facultyExperience").value = "";
							document.getElementById("facultyCollege").value = "";
							document.getElementById("facultyBuilding").value = "";
							document.getElementById("facultyRoom").value = "";
							status = "";
							document.getElementById("status").style.color = "black";
							document.getElementById("status").innerHTML = "Status: ";
							teacherEmail = "";
							document.getElementById("infoContactButton").href = "";
						}
						else
						{
							document.getElementById("applications").value = result;
							var facInfo = jsonObj.facInfo;
							var faculty = facInfo.split("&");
							status = jsonObj.status;
							if(status.includes("Accepted"))
							{
								document.getElementById("status").style.color = "green";
							}
							else if(status.includes("Rejected"))
							{
								document.getElementById("status").style.color = "#CC2127";
							}
							else if(status.includes("Pending"))
							{
								document.getElementById("status").style.color = "black";
							}
							document.getElementById("status").innerHTML = "Status: " + status;
							document.getElementById("facultyFirstName").value = faculty[0];
							document.getElementById("facultyLastName").value = faculty[1];
							document.getElementById("facultyEmail").value = faculty[2];
							document.getElementById("facultyExpertise").value = faculty[3];
							document.getElementById("facultyExperience").value = faculty[4];
							document.getElementById("facultyCollege").value = faculty[5];
							var facBuilding = faculty[6].split("_");
							document.getElementById("facultyBuilding").value = facBuilding[0];
							document.getElementById("facultyRoom").value = facBuilding[1];
							teacherEmail = faculty[2];
							document.getElementById("infoContactButton").href = "mailto:" + teacherEmail;
						}
					}
				};
				xmlhttp.send(formData);
			}
		}
		
		function setAppFilter()
		{
			countOfAppOpps=1;			
			var ucid = getUCID();
			facAppFilter = document.getElementById("professorAppUCID").value;
			if(facAppFilter.length == 0)
			{
				facAppFilter="none";
			}
			
			collegeAppFilter = document.getElementById("studentCollegeAppFilter").value;
			if(collegeAppFilter == "Filter College By...")
			{
				collegeAppFilter = "none";
			}
			else if(collegeAppFilter == "College of Architecture and Design")
			{
				collegeAppFilter = "College of Architecture and Design";
			}
			else if(collegeAppFilter == "College of Science and Liberal Arts")
			{
				collegeAppFilter = "College of Science and Liberal Arts";
			}
			else if(collegeAppFilter == "Martin Tuchman School of Management")
			{
				collegeAppFilter = "Martin Tuchman School of Management";
			}
			else if(collegeAppFilter == "Newark College of Engineering")
			{
				collegeAppFilter = "Newark College of Engineering";
			}
			else if(collegeAppFilter == "Ying Wu College of Computing")
			{
				collegeAppFilter = "Ying Wu College of Computing";
			}
			
			var xmlhttp = new XMLHttpRequest();
			var formData = 'collegeFilter=' + collegeAppFilter + '&oppView='+countOfAppOpps + '&facFilter=' + facAppFilter + '&ucid=' + ucid;
			xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/subApps_f.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.onreadystatechange = function() 
       		{
   			   	if (this.readyState == 4 && this.status == 200) 
   			   	{
   	  		  	    var response = this.responseText.trim('\n');
    		   	 	var json = response;
   			   	  	var jsonObj = JSON.parse(json);
					var result = jsonObj.opp;
					appOppID = jsonObj.id;
					maxAppOppsInDB = parseInt(jsonObj.maxOpps);
           			if((collegeAppFilter.length > 4 || facAppFilter!="none") && result.length > 129)
           			{
           				document.getElementById("applications").value = result;
           				document.getElementById("appFilterVerification").style.color = "green";
           				document.getElementById("appFilterVerification").innerHTML = "Filter Set!";
           				var facInfo = jsonObj.facInfo;
						var faculty = facInfo.split("&");
						status = jsonObj.status;
						if(status.includes("Accepted"))
						{
							document.getElementById("status").style.color = "green";
						}
						else if(status.includes("Rejected"))
						{
							document.getElementById("status").style.color = "#CC2127";
						}
						else if(status.includes("Pending"))
						{
							document.getElementById("status").style.color = "black";
						}
						document.getElementById("status").innerHTML = "Status: " + status;
						document.getElementById("facultyFirstName").value = faculty[0];
						document.getElementById("facultyLastName").value = faculty[1];
						document.getElementById("facultyEmail").value = faculty[2];
						document.getElementById("facultyExpertise").value = faculty[3];
						document.getElementById("facultyExperience").value = faculty[4];
						document.getElementById("facultyCollege").value = faculty[5];
						var facBuilding = faculty[6].split("_");
						document.getElementById("facultyBuilding").value = facBuilding[0];
						document.getElementById("facultyRoom").value = facBuilding[1];
						teacherEmail = faculty[2];
						document.getElementById("infoContactButton").href = "mailto:" + teacherEmail;
           			}
           			else if((collegeAppFilter.length > 4 || facAppFilter!="none") && result.length == 129)
           			{
           				appOppID="";
           				document.getElementById("applications").value = "No opportunities found!";
           				document.getElementById("appFilterVerification").style.color = "green";
           				document.getElementById("appFilterVerification").innerHTML = "Filter Set!";
           				document.getElementById("facultyFirstName").value = "";
						document.getElementById("facultyLastName").value = "";
						document.getElementById("facultyEmail").value = "";
						document.getElementById("facultyExpertise").value = "";
						document.getElementById("facultyExperience").value = "";
						document.getElementById("facultyCollege").value = "";
						document.getElementById("facultyBuilding").value = "";
						document.getElementById("facultyRoom").value = "";
						status = "";
						document.getElementById("status").style.color = "black";
						document.getElementById("status").innerHTML = "Status: ";
						teacherEmail = "";
						document.getElementById("infoContactButton").href = "";
           			}
           			else if(collegeAppFilter == "none" && facAppFilter == "none" && result.length > 129 && appFilterCleared==true)
           			{
           				document.getElementById("applications").value = result;
           				document.getElementById("appFilterVerification").style.color = "green";
           				document.getElementById("appFilterVerification").innerHTML = "Filter Set!";
           				appFilterCleared = false;
           				var facInfo = jsonObj.facInfo;
						var faculty = facInfo.split("&");
						status = jsonObj.status;
						if(status.includes("Accepted"))
						{
							document.getElementById("status").style.color = "green";
						}
						else if(status.includes("Rejected"))
						{
							document.getElementById("status").style.color = "#CC2127";
						}
						else if(status.includes("Pending"))
						{
							document.getElementById("status").style.color = "black";
						}
						document.getElementById("status").innerHTML = "Status: " + status;
						document.getElementById("facultyFirstName").value = faculty[0];
						document.getElementById("facultyLastName").value = faculty[1];
						document.getElementById("facultyEmail").value = faculty[2];
						document.getElementById("facultyExpertise").value = faculty[3];
						document.getElementById("facultyExperience").value = faculty[4];
						document.getElementById("facultyCollege").value = faculty[5];
						var facBuilding = faculty[6].split("_");
						document.getElementById("facultyBuilding").value = facBuilding[0];
						document.getElementById("facultyRoom").value = facBuilding[1];
						teacherEmail = faculty[2];
						document.getElementById("infoContactButton").href = "mailto:" + teacherEmail;
           			}
           			else
           			{
           				document.getElementById("appFilterVerification").style.color = "#CC2127";
           				document.getElementById("appFilterVerification").innerHTML = "Please Select Filter!";
           			}
   			   	}
    		};
    		xmlhttp.send(formData);
		}
		
		function setFilter()
		{
			document.getElementById("heartVerification").innerHTML = "&nbsp";
			countOfOpps=1;			
			
			facFilter = document.getElementById("professorUCID").value;
			if(facFilter.length == 0)
			{
				facFilter="none";
			}
			
			collegeFilter = document.getElementById("studentCollegeFilter").value;
			if(collegeFilter == "Filter College By...")
			{
				collegeFilter = "none";
			}
			else if(collegeFilter == "College of Architecture and Design")
			{
				collegeFilter = "College of Architecture and Design";
			}
			else if(collegeFilter == "College of Science and Liberal Arts")
			{
				collegeFilter = "College of Science and Liberal Arts";
			}
			else if(collegeFilter == "Martin Tuchman School of Management")
			{
				collegeFilter = "Martin Tuchman School of Management";
			}
			else if(collegeFilter == "Newark College of Engineering")
			{
				collegeFilter = "Newark College of Engineering";
			}
			else if(collegeFilter == "Ying Wu College of Computing")
			{
				collegeFilter = "Ying Wu College of Computing";
			}
			
			var xmlhttp = new XMLHttpRequest();
			var formData = 'collegeFilter=' + collegeFilter + '&oppView='+countOfOpps + '&facFilter=' + facFilter;
			xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/browseOpps_f.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.onreadystatechange = function() 
       		{
   			   	if (this.readyState == 4 && this.status == 200) 
   			   	{
   	  		  	    var response = this.responseText.trim('\n');
    		   	 	var json = response;
   			   	  	var jsonObj = JSON.parse(json);
					var result = jsonObj.opp;
					oppID = jsonObj.id;
					maxOppsInDB = parseInt(jsonObj.maxOpps);
           			if((collegeFilter.length > 4 || facFilter!="none") && result.length > 129)
           			{
           				document.getElementById("opportunity").value = result;
           				document.getElementById("filterVerification").style.color = "green";
           				document.getElementById("filterVerification").innerHTML = "Filter Set!";
           			}
           			else if((collegeFilter.length > 4 || facFilter!="none") && result.length == 129)
           			{
           				oppID="";
           				document.getElementById("opportunity").value = "No opportunities found!";
           				document.getElementById("filterVerification").style.color = "green";
           				document.getElementById("filterVerification").innerHTML = "Filter Set!";
           			}
           			else if(collegeFilter == "none" && facFilter == "none" && result.length > 129 && filterCleared==true)
           			{
           				document.getElementById("opportunity").value = result;
           				document.getElementById("filterVerification").style.color = "green";
           				document.getElementById("filterVerification").innerHTML = "Filter Set!";
           				filterCleared = false;
           			}
           			else
           			{
           				document.getElementById("filterVerification").style.color = "#CC2127";
           				document.getElementById("filterVerification").innerHTML = "Please Select Filter!";
           			}
   			   	}
    		};
    		xmlhttp.send(formData);
		}
		
		function clearFilter()
		{
			filterCleared=true;
			document.getElementById("professorUCID").value = "";
			document.getElementById("studentCollegeFilter").value = "Filter College By...";
			jQuery("#studentCollegeFilter option").filter(function()
			{
				return $.trim($(this).text()) ==  "Filter College By...";
			}).prop('selected', true);
			$('#studentCollegeFilter').selectpicker('refresh');
			setFilter();
		}
		
		function clearAppFilter()
		{
			appFilterCleared=true;
			document.getElementById("professorAppUCID").value = "";
			document.getElementById("studentCollegeAppFilter").value = "Filter College By...";
			jQuery("#studentCollegeAppFilter option").filter(function()
			{
				return $.trim($(this).text()) ==  "Filter College By...";
			}).prop('selected', true);
			$('#studentCollegeAppFilter').selectpicker('refresh');
			setAppFilter();
		}
		
		function previousOpp()
		{
			countOfOpps--;
			if(countOfOpps <=1)
			{
				countOfOpps = 1;
			}
			
			var xmlhttp = new XMLHttpRequest();
			var formData = 'collegeFilter=' + collegeFilter + '&oppView='+countOfOpps + '&facFilter=' + facFilter;
			xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/browseOpps_f.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       		xmlhttp.onreadystatechange = function() 
       		{
       	   		if (this.readyState == 4 && this.status == 200) 
       	   		{
       	   		    var response = this.responseText.trim('\n');
       	   		 	var json = response;
       	   		    var jsonObj = JSON.parse(json);
					var result = jsonObj.opp;
					
					oppID = jsonObj.id;
					maxOppsInDB = parseInt(jsonObj.maxOpps);
					maxOppsFound=true;
					document.getElementById("heartVerification").innerHTML = "&nbsp";
       				if(result.length == 129)
           			{
           				document.getElementById("opportunity").value = "No opportunities found!";
           			}
           			else
           			{
           				document.getElementById("opportunity").value = result;
           			}
       	   		}
			};
 			xmlhttp.send(formData);
		}
		
		function nextOpp()
		{
			countOfOpps++;
			if(countOfOpps>maxOppsInDB && maxOppsFound==true)
			{
				countOfOpps = maxOppsInDB;
			}
			var xmlhttp = new XMLHttpRequest();
			var formData = 'collegeFilter=' + collegeFilter + '&oppView='+countOfOpps + '&facFilter=' + facFilter;
			xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/browseOpps_f.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.onreadystatechange = function() 
       		{
   			   	if (this.readyState == 4 && this.status == 200) 
   			   	{
   	  		  	    var response = this.responseText.trim('\n');
    		   	 	var json = response;
   			   	    var jsonObj = JSON.parse(json);
   			   	    
   			   	    oppID = jsonObj.id;
					var result = jsonObj.opp;
					maxOppsInDB = parseInt(jsonObj.maxOpps);
					maxOppsFound=true;
					document.getElementById("heartVerification").innerHTML = "&nbsp";
					if(result.length == 129)
           			{
           				document.getElementById("opportunity").value = "No opportunities found!";
           			}
           			else
           			{
           				document.getElementById("opportunity").value = result;
           			}
   			   	}
    		};
    		xmlhttp.send(formData);
		}
		
		$("#heartedOpps").click(function()
		{
			$('html,body').animate(
			{
				scrollTop: $("#applied").offset().top
			}, 'slow');
		});
		
		function enabler()
        {
        	document.getElementById("submitter").removeAttribute("disabled"); //enable submit
        }
        
        function validFile()
        {
            var filename = document.getElementById("fileToUpload").value;	//file select button
			if (filename == "")
                return;
            var nameOfCookie = getUCID();
			var actualFileName = filename.split("fakepath\\")[1];
			var fileBrokenDown = actualFileName.split(".");
			var ucid = fileBrokenDown[0];
			var extension = fileBrokenDown[1].toUpperCase();
			var acceptedExtensions = ["PDF"];
			if(ucid == nameOfCookie && acceptedExtensions.includes(extension))
			{
                enabler();
                document.getElementById("fileUploaded").style.color = "green";
				document.getElementById("fileUploaded").innerHTML = "Looking good!"
            }
            else
            {
                document.getElementById("fileUploaded").style.color = "#CC2127";
				document.getElementById("fileUploaded").innerHTML = "Improper filename or extension";
            }
        }
		
		function editModeOn()
		{
			document.getElementById("verification").style.color = "#CC2127";
			document.getElementById("verification").innerHTML = "Edit Mode On";
			document.getElementById("studentFirstName").disabled = false;
			document.getElementById("studentLastName").disabled = false;
			document.getElementById("studentID").disabled = false;
			document.getElementById("studentEmail").disabled = false;
			document.getElementById("studentGPA").disabled = false;
			document.getElementById("studentMajor").disabled = false;
			$('#studentClassRank').attr('disabled',false);
			$('#studentClassRank').selectpicker('refresh');
			$('#studentCollege').attr('disabled',false);
			$('#studentCollege').selectpicker('refresh');
			document.getElementById("studentFirstName").style.opacity ="1";
			document.getElementById("studentLastName").style.opacity ="1";
			document.getElementById("studentID").style.opacity ="1";
			document.getElementById("studentEmail").style.opacity ="1";
			document.getElementById("studentGPA").style.opacity ="1";
			document.getElementById("studentMajor").style.opacity = "1";
			document.getElementById("edit").style.backgroundColor = "#01D701";
			document.getElementById("saveProfile").disabled = false;
			document.getElementById("editProfile").disabled = true;
		}
		
		function editModeOff()
		{	
			var studentUCID = getUCID();
			var studentFirstName = document.getElementById("studentFirstName").value;
			var studentLastName = document.getElementById("studentLastName").value;
			var studentID = document.getElementById("studentID").value;
			var studentEmail = document.getElementById("studentEmail").value;
			var studentMajor = document.getElementById("studentMajor").value;
			var studentGPA = document.getElementById("studentGPA").value;
			var studentClassRank = document.getElementById("studentClassRank").value;
			var studentCollege = document.getElementById("studentCollege").value;
			if(studentFirstName.length == 0 ||
			   studentLastName.length == 0 ||
			   studentID.length == 0 ||
			   studentEmail.length == 0 ||
			   studentMajor.length == 0  || 
			   studentGPA.length == 0  || 
			   studentClassRank == "Select Class Standing..." ||
			   studentCollege == "Select College...")
			 
			{
				document.getElementById("verification").style.color = "#CC2127";
				document.getElementById("verification").innerHTML = "Please complete all fields!";
			}
			else
			{
				var xmlhttp = new XMLHttpRequest();
				var formData = 'studentUCID=' + studentUCID + '&studentFirstName=' + studentFirstName +
							   '&studentLastName=' + studentLastName + '&studentID=' + studentID +
							   '&studentEmail=' + studentEmail + '&studentMajor=' + studentMajor +
							   '&studentGPA=' + studentGPA + '&studentClassRank=' + studentClassRank +
							   '&studentCollege=' + studentCollege;
				xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/saveProfile_f.php", true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    			xmlhttp.onreadystatechange = function() 
       	 		{
       	 	   		if (this.readyState == 4 && this.status == 200) 
        			{
    		   			var result = this.responseText.trim('\n');
    			   	    document.getElementById("verification").innerHTML = result;
          			 	if(result == "Profile Updated")
          			 	{
          			 		profileCreated = true;
           					document.getElementById("verification").style.color = "green";
           					document.getElementById("verification").innerHTML = "Profile Successfully Updated!";
							document.getElementById("studentFirstName").disabled = true;
							document.getElementById("studentLastName").disabled = true;
							document.getElementById("studentID").disabled = true;
							document.getElementById("studentEmail").disabled = true;
							document.getElementById("studentGPA").disabled = true;
							document.getElementById("studentMajor").disabled = true;
							$('#studentClassRank').attr('disabled',true);
							$('#studentClassRank').selectpicker('refresh');
							$('#studentCollege').attr('disabled',true);
							$('#studentCollege').selectpicker('refresh');
							document.getElementById("studentFirstName").style.opacity =".7";
							document.getElementById("studentLastName").style.opacity =".7";
							document.getElementById("studentID").style.opacity =".7";
							document.getElementById("studentEmail").style.opacity =".7";
							document.getElementById("studentGPA").style.opacity =".7";
							document.getElementById("studentMajor").style.opacity = ".7";
							document.getElementById("edit").style.backgroundColor = "#CC2127";
							document.getElementById("saveProfile").disabled = true;
							document.getElementById("editProfile").disabled = false;
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
		
		function getFileName()
		{
			document.getElementById("fileUploaded").style.color = "green";
			document.getElementById("fileUploaded").innerHTML = "Selected file was uploaded!";
		}
		
		function getUCID()
		{
			var name = "studentUser=";
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
		
		function heart()
		{
			if(profileCreated == false)
			{
				document.getElementById("heartVerification").innerHTML = "You must complete your profile!";
			}
			else
			{
				if(oppID.length==0)
				{
					document.getElementById("heartVerification").style.color = "#CC2127";
					document.getElementById("heartVerification").innerHTML = "Cannot Heart!";
				}
				else
				{
					var ucid=getUCID();
					var xmlhttp = new XMLHttpRequest();
					var formData = 'studentID=' + ucid + '&oppID='+oppID;
					xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/heart_f.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							var response = this.responseText.trim('\n');
							if(response == "HEARTED OPP") 
							{
								document.getElementById("heartVerification").style.color = "green";
								document.getElementById("heartVerification").innerHTML = "Wish you the best of luck!";
							}
							else if(response == "ALREADY HEARTED") 
							{
								document.getElementById("heartVerification").style.color = "#CC2127";
								document.getElementById("heartVerification").innerHTML = "You already hearted this one! Pick something else!";
							}
						}
					};
					xmlhttp.send(formData);
    			}
			}
		}
		
		function unHeart()
		{
			if(profileCreated == false)
			{
				document.getElementById("heartVerification").innerHTML = "You must complete your profile!";
			}
			else
			{
				if(oppID.length==0)
				{
					document.getElementById("heartVerification").style.color = "#CC2127";
					document.getElementById("heartVerification").innerHTML = "Cannot Un-Heart!";
				}
				else
				{
					var ucid=getUCID();
					var xmlhttp = new XMLHttpRequest();
					var formData = 'studentID=' + ucid + '&oppID='+oppID;
					xmlhttp.open("POST", "https://web.njit.edu/~crk23/resport/student/unheart_f.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.onreadystatechange = function() 
					{
						if (this.readyState == 4 && this.status == 200) 
						{
							var response = this.responseText.trim('\n');
							if(response == "UNHEARTED")
							{
								document.getElementById("heartVerification").style.color = "green";
								document.getElementById("heartVerification").innerHTML = "Successfully Unhearted!";
							}
							else if(response == "ERROR")
							{
								document.getElementById("heartVerification").style.color = "#CC2127";
								document.getElementById("heartVerification").innerHTML = "You need to heart the opportunity first!";
							}
						}
					};
					xmlhttp.send(formData);
    			}
			}
		}
	</script>
</html>