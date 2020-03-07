<?php 
    
     session_start();
     if(isset($_SESSION['buser_name'])) {

     	 header('location:index.php');
      
     }
     $pagetitle = 'login';

     

   require_once 'core/init.php';
   include 'included/header.php';
  
    include 'included/functions/function.php';



    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    	  if(isset($_POST['login'])) {

    	$username = $_POST['username'];
    	$pass = sha1($_POST['password']);

    $stmt2 = $connec->prepare("SELECT id,user_name,user_password FROM users WHERE user_name=? AND user_password=? ");
    	$stmt2->execute(array($username,$pass));
      $get = $stmt2->fetch();
      $date = date('Y-m-d H:i:s');
    	$count = $stmt2->rowCount();

    	if($count>0)  {
    		$_SESSION['buser_name'] = $get['user_name'];
        $_SESSION['buser_id']  = $get['id'];

        $stmt3 = $connec->prepare("UPDATE  users SET last_login=? WHERE id=?");
       $stmt3->execute(array($date,$get['id']));

       

    		header('location:index.php');
    		exit();

    	} else {
         echo "<div class='alert alert-danger'>You do not Have Account</div>";
      }
    }  else {

          $formerrors = array();

          $username   = $_POST['username'];
          $password1  = $_POST['password'];
          $password2  = $_POST['password2'];
          $email      = $_POST['email'];

    	  if(isset($username)) {

             $user = filter_var($username,FILTER_SANITIZE_STRING);

             if(strlen($user)<4) {

             	$formerrors[] ="User Name Must Be Larger Than Four Characters";
             }
    	  	  
    	  }

    	  if(isset($password1) && isset($password2)) {

    	  	if(empty($password1)) {

    	  		$formerrors = "password cannot be empty";
    	  	}

          if(strlen($password1)<5) {

            $formerrors = "password cannot be less than five chars";
          }



            $pass1 = sha1($_POST['password']);
            $pass2 = sha1($_POST['password2']);

             if($pass1 !== $pass2) {

             	$formerrors[] ="Password1 Must Be Match Password2";
             }

         }
    	  	  

    	  


    	  if(isset($_POST['email'])) {

    	  	$email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    	  	if(filter_var($email,FILTER_VALIDATE_EMAIL) != true) {

    	  		$formerrors = "Email Not Valid";
    	  	}

    	  }

      
          if(empty($formerrors)) {

          	   $check =checkItem('user_name','users',$email);
          	   if($check == 1) {

          	   	   $formerrors[] = 'Sorry User Email Is Exist';
          	   }
          	   else {
                   
                    $stmt = $connec->prepare("INSERT INTO users(user_name,user_email,user_password) 

                    	                     VALUES(:zname,:zemail,:zpass)");

                    $stmt->execute(array(

                           'zname'=>$user,
                           'zemail'=>$email,
                           'zpass' =>sha1($password1)

                    	));

                    $sucess = "<div class='alert alert-danger'></div>";

                    
          	   }
          }
   

    


///////////////////////
   }
}

?>

<style type="text/css">
  body {
    background-color: #f5f5f5;
  }

</style>


 <div class="container">

		     
		      <div class="login-page">

		          <h1 class="text-center"><span id='login' style="font-weight:bold;font-size:35px;" class="selected">Login</span> | <span id='signup' style="font-weight:bold;color:#867B7B;font-size:35px;">Signup</span></h1>

		        
		         <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
		              <div class="input-container">
			              <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Enter UserName">
			          </div>

			          <div class="input-container">

			          <input type="password" name="password" class="form-control" autocomplete="new-password" required="required" placeholder="Enter Valid Password">
			          </div>

			          <div class="input-container">

			          <input type="submit" class="btn-block btn btn-primary" value="login" name='login'>

			          </div>
		        
		         </form>

		         <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

		               <div class="input-container">

		               <input pattern=".{4,}" title="Name Must Be Less Than 4 chars" type="text" name="username" class="form-control"   placeholder="Enter Your username" required="required" autocomplete="off">
			          </div>

			         

		             <div class="input-container">

		                <input type="email" name="email" class="form-control"  placeholder="Enter Your Eamil" required="required">
			          </div>

			          <div class="input-container">

			          <input minlength="4" type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Enter Valid Password" required="required">
			          </div>

			          <div class="input-container">

			            <input minlength="4"  type="password" name="password2" class="form-control" autocomplete="new-password"  placeholder="Enter Password Again" required="required">

			           </div>
			          <input type="submit" class="btn-block btn btn-success" value="signup" name="signup">
		        
		         </form>



		    </div>

   </div>

       <div class="container">

          <div class="errors text-center">
             <?php
             if(!empty($formerrors)) {

             	foreach($formerrors as $error) {

             		 echo $error."<br>";
             	}
             }


              if(isset($sucess)) {
                    
                    echo $sucess;
              }
             ?>
          </div>


       </div>





<?php
     
        include 'included/footer.php';

          
          
      
?>