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
$formDataString = $_POST['username'] . '&' . $_POST['password'];

//Back End URL
$backEndURL = 'https://web.njit.edu/~cww5/resport/login/login_b.php';

//Send cURL POST Request to Back End URL
$curlBegin = curl_init($backEndURL);
curl_setopt($curlBegin, CURLOPT_POSTFIELDS, $formDataString);
$json = curl_exec($curlBegin);
curl_close($curlBegin);
?>