<?php
 
    include 'core/init.php';
  
   include 'included/functions/function.php';


   $name = isset($_POST['full_name']) ? $_POST['full_name'] : '';

   $email = isset($_POST['email']) ? $_POST['email'] : '';

   $street1 = isset($_POST['street']) ? $_POST['street'] : '';

   $street2 =  isset($_POST['street2']) ? $_POST['street2'] : '';

    $state =  isset($_POST['state']) ? $_POST['state'] : '';

    $zip_code =  isset($_POST['zip_code']) ? $_POST['zip_code'] : '';

    $city  =  isset($_POST['city']) ? $_POST['city'] : '';
   
   $country =  isset($_POST['country']) ? $_POST['country'] : '';

   $errors = array();

   if(empty($name) || strlen($name) < 3 ) {
 

          $formerrors[] = "The Name cant not be empty";

   }

    if(empty($email)) {
 

          $formerrors[] = "The email cant not be empty";

   }

   if(empty($street1) || strlen($name) < 10 ) {
 

          $formerrors[] = "The street cant not be empty or than 10 chars";

   }


   if(empty($city) || strlen($city) < 4 ) {
 

          $formerrors[] = "The City Name cant not be empty or less than four chars ";

   }

    if(empty($zip_code) || strlen($zip_code) < 3 ) {
 

          $formerrors[] = "The zip_code  cant not be empty or less than three chars ";

   }

   if(empty($country) || strlen($country) < 4 ) {
 

          $formerrors[] = "The Country Name cant not be empty or less than four chars ";

   }


   if(!empty($formerrors)) {

	   	   foreach ($formerrors as $error) {
	   	   
	   	
	   	     echo "<p class='bg-danger'>".$error."</p>";

	   	}

   }

   else {

   	   //echo 'passed';
       return true;
   }




?>





