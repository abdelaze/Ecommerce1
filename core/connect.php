<?php
  
   $dsn = 'mysql:host=localhost;dbname=toturial';

   $user = 'root';

   $pass = '';

   try {


   	   $connec = new PDO($dsn,$user,$pass);
  
  }catch(PDOException $e) {

  	echo 'Failed'.$e->getMessage();

  }