<?php
/* * * * * * * * * * * * * * *
 * 							 *
 * Author:  Chidanand Khode	 *
 * Role:    Front End		 *
 * Project: Resport			 *
 * Year:    2018			 *
 *						     *
 * * * * * * * * * * * * * * */

//Get AJAX Request
$formDataString = $_POST['studentUCID'] . '&' . $_POST['studentFirstName'] . '&' . $_POST['studentLastName'] . '&' .
				  $_POST['studentID'] . '&' . $_POST['studentEmail'] . '&' . $_POST['studentMajor'] . '&' . 
				  $_POST['studentGPA'] . '&' . $_POST['studentClassRank'] . '&' . $_POST['studentCollege'];

//Back End URL
$backEndURL = 'https://web.njit.edu/~cww5/resport/student/saveProfile_b.php';

//Send cURL POST Request to Back End URL
$curlBegin = curl_init($backEndURL);
curl_setopt($curlBegin, CURLOPT_POSTFIELDS, $formDataString);
$json = curl_exec($curlBegin);
curl_close($curlBegin);
?>