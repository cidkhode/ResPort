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
$formDataString = $_POST['ucid'] . '&' . $_POST['name'] . '&' . $_POST['college']
				 . '&' . $_POST['title'] . '&' . $_POST['numStudents']
				 . '&' . $_POST['hours'] . '&' . $_POST['description'] . '&' . $_POST['category'];

//Back End URL
$backEndURL = 'https://web.njit.edu/~cww5/resport/faculty/create_b.php';

//Send cURL POST Request to Back End URL
$curlBegin = curl_init($backEndURL);
curl_setopt($curlBegin, CURLOPT_POSTFIELDS, $formDataString);
$json = curl_exec($curlBegin);
curl_close($curlBegin);
?>