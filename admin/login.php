<?php
 
 session_start();
 $pagetitle = 'Login';
 $nonavbar = '';
 if(isset($_SESSION['admin_user_name'])) {

 	 header('location:index.php');
 }
 require_once 'core/init.php';
  include 'included/header.php';
 
 

 if($_SERVER['REQUEST_METHOD']=='POST') {

 	$username = $_POST['user'];
 	$password = $_POST['pass'];
 	$hashedpass = sha1($password);

 	 
 	 $stmt = $connec->prepare('SELECT  id,user_name,user_password FROM users where user_name=? AND user_password=? AND group_id=1 LIMIT 1');

 	 $stmt->execute(array($username,$hashedpass));
   $row=$stmt->fetch();
 	 $count = $stmt->rowCount();

      if($count>0) {
  
        $_SESSION['admin_user_name'] = $username;

        $_SESSION['admin_user_id'] =$row['id'];

       // print_r($row);

         header('location:index.php');
         exit();

      }
 
  

 }

 ?>

	 <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?> " method='POST'">

	     <h3 class="text-center">admin login</h3>

	     <input type="text" class="form-control" name="user" placeholder="username" autocomplete="off">

	     <input type="password" class="form-control" name="pass" placeholder="password" autocomplete="new-password">
	     <input type="submit" class="btn btn-success btn-block" value="login">

	 </form>

  
   

<?php  include 'included/footer.php';?>