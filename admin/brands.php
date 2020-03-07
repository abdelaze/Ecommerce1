<?php
   
  session_start();
 $pagetitle='Brands';
 if(isset($_SESSION['admin_user_name'])) {
   include 'core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
   include 'included/functions/function.php';
  
   
      $do = isset($_GET['do'])?$_GET['do']:'manage';


    $stmt = $connec->prepare("SELECT *FROM brand ORDER BY brand_name");
        $stmt->execute();
        $brands = $stmt->fetchAll();
        $brandscount = $stmt->rowCount();



    $brandvalue = '';

   if(isset($_POST['Add-brand'])) {

   
    $formerrors = array(); 
   	$brand =  filter_var($_POST['brand'],FILTER_SANITIZE_STRING);

   	if(strlen($brand)<4) {

   		$formerrors[] = 'The brand can not be empty OR less than four chars' ;

   	}

   	$count = checkItem('brand_name','brand',$brand);

   	if($count>0) {

   		$formerrors[] = 'This brand is already exist ' ;
   	}
    
    if(empty($formerrors)) {

    
          $stmt1 = $connec->prepare("INSERT INTO brand (brand_name) VALUES(:zbrandname)");
          $stmt1->execute(array(
            
           'zbrandname' => $brand
           
          ));
          
          header('Location:brands.php');
     }

                      
       else {


    	foreach ($formerrors as $error) {
    		 
    		 echo '<p class="bg-danger">'.$error.'</p>';


    	}
    }
}



   
           // Start update 

          if($do == 'Update') {
                   
              $formerrors = array();

              if($_SERVER['REQUEST_METHOD']=='POST') { 

             $brand =  filter_var($_POST['brand'],FILTER_SANITIZE_STRING);
             $brandid = $_POST['brand-id'];

           }

          if(strlen($brand)<4) {

            $formerrors[] = 'The brand can not be empty OR less than four chars' ;

          }

       $count = checkItem('brand_name','brand',$brand);

          if($count>0) {

            $formerrors[] = 'This brand is already exist ' ;
          }

           foreach ($formerrors as $error) {
             
             echo '<p class="bg-danger">'.$error.'</p>';
             
             header('refresh:3;url=brands.php?do=Edit&brand_id='.$brandid.'');
             
          }
    
        if(empty($formerrors)) {

        
              $stmt1 = $connec->prepare("UPDATE brand SET brand_name=? WHERE brand_id=?");
              $stmt1->execute(array($brand,$brandid));
               header('Location:brands.php');
            
         }

                      
          


         
            
           
       }

 
  // END UPDATE 
    



   

   // staert delete event 

   if($do == 'Delete') {

   	  $brandid = isset($_GET['brand_id'])&&is_numeric($_GET['brand_id'])?$_GET['brand_id']:0;

   	  $count = checkItem('brand_id','brand',$brandid);

   	  if($count == 1) {

   	  	  $stmt2 = $connec->prepare("DELETE FROM brand WHERE brand_id=:zbrandid");
   	  	  $stmt2->bindParam('zbrandid',$brandid);
   	  	  $stmt2->execute();
          header('Location:brands.php');
   	  	}

   	  else {
                
            echo  '<p class="bg-danger">this brand not exist </p>';

   	  }


   	 


   }


?>
  
   

      <h2 class="text-center main-head">Brands</h2>
      <hr>


     <?php if($do=='manage') { ?>
     <div class="text-center">
        <form class="form-inline" action="brands.php"  method="POST">
			  <div class="form-group">
                
               
			    <label for="brand1"> Add a brand:</label>
			    <input type="text" name='brand' class="form-control" id="brand1" placeholder="Enter Brand Name">
			  </div>

			  <input type="submit" name="Add-brand" class="btn btn-success" value="Add brand">
	   </form>
     </div>

    <?php  }  /* End ADD */ ?>

   
       
       <?php if($do=='Edit'||$do=='Update') { 

       $brandid = isset($_GET['brand_id'])&&is_numeric($_GET['brand_id'])?intval($_GET['brand_id']):0;
                  
                  $stmt4 = $connec->prepare("SELECT * FROM brand WHERE brand_id=?");
                  $stmt4->execute(array($brandid));
                  $branddata = $stmt4->fetch();
                  $brandvalue = $branddata['brand_name'];


    ?> 

     <div class="text-center">
        <form class="form-inline" action="?do=Update"  method="POST">
        <div class="form-group">
                
               
          <label for="brand1"> Edit a brand:</label>
           <input type="hidden" name="brand-id" value="<?php echo $brandid; ?>">
          <input type="text" name='brand' class="form-control" id="brand1" placeholder="Enter Brand Name"  value="<?php echo $brandvalue; ?>">
        </div>
        <a href="brands.php" class="btn btn-default">Cancel</a>
        <input type="submit" name="Edit-brand" class="btn btn-success" value="Edit brand">

     </form>
     </div>

    <?php  }  ?>

    <hr>


     <?php if($brandscount>0) {  ?>

    <div class="table table-responsive main-table">

      
       <table class="table table-bordered table-striped table-auto table-condensed">
       	<thead>
       		<th></th>
       		<th>Brand</th>
       		<th></th>

       	</thead>

       	<tbody>
       	<?php foreach ($brands as  $brand) {  ?>

       		<tr>
       		 <td><a class="btn btn-xs btn-default" href="brands.php?do=Edit&brand_id=<?php echo $brand['brand_id'];?>"><span><i class="fa fa-edit"></i></span></a></td>
       		  <td><?php echo $brand['brand_name']; ?></td>
       		 <td><a  class="btn btn-xs btn-default" href="brands.php?do=Delete&brand_id=<?php echo $brand['brand_id']; ?>"><span><i class="fa fa-remove"></i></span></a></td>
       		</tr>

       		<?php } ?>

       	</tbody>

       </table>
    </div>

    <?php } ?>







<?php
  
   include 'included/footer.php';
  }  else {  /////////////////////THE END ////////////////////

     header('location:login.php');
     exit();
 }
  
?>