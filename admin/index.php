<?php
  
  session_start();
  $pagetitle='Home page';
 if(isset($_SESSION['admin_user_name'])) {
  
   include '../core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
   
?>














<?php
  
   include 'included/footer.php';


   } else {  /////////////////////THE END ////////////////////

     header('location:login.php');
     exit();
 }
  
?>