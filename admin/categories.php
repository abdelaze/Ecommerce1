<?php

  session_start();
  $pagetitle='Categories';
 if(isset($_SESSION['admin_user_name'])) {
   include 'core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
   include 'included/functions/function.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';


    // show all catrgories

     $stmt1 = $connec->prepare("SELECT * FROM categories WHERE parent= 0 ");

    $stmt1->execute();

    $cats = $stmt1->fetchAll();
    $count = $stmt1->rowCount();
    
 ?>





 <?php if($do == 'manage') { ?>


    <h2 class="text-center">Categories</h2>
   <div class="table-responsive">

      <table class="table table-bordered">
      	 <thead>
      	 	
      	 	<th>Category</th>
      	 	<th>Parent</th>
      	 	<th></th>

      	 </thead>


      	 <tbody>

      	    <?php foreach ($cats as  $cat) {?>
              	    
                 <tr class="bg-primary">
                 <td><?php echo $cat['category']?></td>   
                 <td>Parent</td> 
                  <td>
                  	<a href="categories.php?do=Edit&cat-id=<?php echo $cat['cat_id'] ?>" class='btn btn-xs btn-default'>
                  	   <i class="fa fa-pencil"></i>
                  	</a>
                  	<a href="categories.php?do=Delete&cat-id=<?php echo $cat['cat_id'] ?>" class='btn btn-xs btn-default'>
                  	   <i class="fa fa-remove"></i>
                  	</a>
                  </td>     
                 </tr>   

                 <?php

                   $stmt = $connec->prepare("SELECT * FROM categories WHERE parent=?");
                   $stmt->execute(array($cat['cat_id']));
                   $childcats = $stmt->fetchAll();

                  foreach ($childcats as  $child) {?>
              	    
                 <tr class="bg-info">
                 <td><?php echo $child['category']?></td>   
                 <td><?php echo $cat['category']?></td> 
                  <td>
                  	<a href="categories.php?do=Edit&cat-id=<?php echo $child['cat_id'] ?>" class='btn btn-xs btn-default'>
                  	   <i class="fa fa-pencil"></i>
                  	</a>
                  	<a href="categories.php?do=Delete&cat-id=<?php echo $child['cat_id'] ?>" class='btn btn-xs btn-default'>
                  	   <i class="fa fa-remove"></i>
                  	</a>
                  </td>     
                 </tr>   

                   
                <?php } ?>     

      	    
      	    <?php } ?>
      	 	
      	 </tbody>



      </table>

      <a href="categories.php?do=Add" class='btn btn-primary'>
                  	 New Category  <i class="fa fa-plus"></i>
     </a>

  </div>

  <!-- END MANAGE -->

<?php } elseif ($do=='Add') { ?>
	    
	     <div class="text-center">
         
           <h2 class="main-head">Add Category</h2>
           <div class="col-sm-offset-3  col-md-6 text-center">

           <form class="form-horizontal" action="?do=Insert" method="POST">

              <label class="col-sm-2">Category</label>

              <div class="col-sm-10">
                   <div class="form-group">
                     <input type="text" class="form-control form-group-lg" name="category" placeholder="Enter category" autocomplete="off" >
                   </div>
              </div>

               <label class="col-sm-2">Parent</label>

              <div class="col-sm-10">
                   <div class="form-group">
                     <select class="form-control form-group-lg" name='parent'>
                     	 <option value="0">Parent</option>

                     	 <?php foreach ($cats as $cat ) {?>
                     	 	   
                               <option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['category']; ?></option>

                     	<?php  } ?>
                     	 


                     </select>
                   </div>
              </div>


              <div class="col-sm-offset-2 col-sm-10">
                   <div class="form-group">
                     <input type="submit" class="btn btn-primary btn-block" value="Add category">
                   </div>
              </div>
           	


           </form>

        </div>
        </div>


<?php }  elseif($do=='Insert')  { 

       
           $formerrors = array(); 
   	$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
   	$parent = $_POST['parent'];

   	if(strlen($category)<3) {

   		$formerrors[] = 'The category can not be empty OR less than four chars' ;

   	}

   //	$count = checkItem('category','categories',$category);

    // check the item exist or not 

   $count == 0;
    if($parent == 0) {

        $count = checkItem('category','categories',$category);

    } else {
      $check = $connec->prepare("SELECT * FROM categories WHERE category=? AND parent=?");
      $check->execute(array($category,$parent));

      $count = $check->rowCount();
    }


   	if($count>0) {

   		   $check = $connec->prepare("SELECT * FROM categories WHERE category=? AND parent=0");
         $check->execute(array($category));

         $count = $check->rowCount();
   	}
    
    if(empty($formerrors)) {

    
          $stmt1 = $connec->prepare("INSERT INTO categories (category,parent) VALUES(:zcatname,:zparentname)");
          $stmt1->execute(array(
            
           'zcatname' => $category,
           'zparentname' => $parent           
          ));
          
          echo "<div  class='alert alert-success'>The Category Added Suuccessfully </div>";
          header('refresh:3;url=categories.php');
     }

                      
       else {


    	foreach ($formerrors as $error) {
    		 
    		echo "<div  class='alert alert-danger'>".$error. "</div>";
            header('refresh:3;url=categories.php?do=Add');

    	}
    }




 

    } elseif($do=='Delete') {

      $catid = isset($_GET['cat-id'])&&is_numeric($_GET['cat-id']) ? intval($_GET['cat-id']) : 0;
     
      $stmt3 = $connec->prepare("SELECT * FROM categories WHERE cat_id=?");
      $stmt3->execute(array($catid));
      $cat = $stmt3->fetch();
      $count = $stmt3->rowCount();

      if($count==1) {
      	  if($cat['parent'] == 0) {
                
                $stmt4 = $connec->prepare("DELETE FROM categories WHERE parent=?");
                $stmt4->execute(array($catid));


      	  }

      	  $stmt5 = $connec->prepare("DELETE FROM categories WHERE cat_id=?");
                $stmt5->execute(array($catid));

            header('Location:categories.php');
      } else {

            echo "<div class='alert alert-danger'>The Item Not Exist </div> " ;
            header('refresh:3;url=categories.php');
      }


  }  elseif($do == 'Edit') {
               
           $catid = isset($_GET['cat-id'])&&is_numeric($_GET['cat-id']) ? intval($_GET['cat-id']) : 0;
     
           $stmt6 = $connec->prepare("SELECT * FROM categories WHERE cat_id=?");
           $stmt6->execute(array($catid));
           $cat2 = $stmt6->fetch();
           $count = $stmt6->rowCount(); ?>


            <div class="text-center">
         
           <h2 class="main-head">Edit Category</h2>
           <div class="col-sm-offset-3  col-md-6 text-center">

           <form class="form-horizontal" action="?do=Update" method="POST">

              <label class="col-sm-2">Category</label>

              <div class="col-sm-10">
                   <div class="form-group">

                    <input type="hidden" class="form-control form-group-lg" name="cat-id" value="<?php echo $cat2['cat_id'] ?>" >
                     <input type="text" class="form-control form-group-lg" name="category" placeholder="Enter category" autocomplete="off" value="<?php echo $cat2['category'] ?>" >
                   </div>
              </div>

               <label class="col-sm-2">Parent</label>

              <div class="col-sm-10">
                   <div class="form-group">
                     <select class="form-control form-group-lg" name='parent'>

                     	 <option value="0">Parent</option>

                     	 <?php foreach ($cats as $cat ) {?>
                     	 	   
                               <option value="<?php echo $cat['cat_id']; ?>" <?php  if($cat['cat_id'] == $cat2['parent']) { echo 'selected';}  ?>><?php echo $cat['category']; ?></option>

                     	<?php  } ?>
                     	 


                     </select>
                   </div>
              </div>


              <div class="col-sm-offset-2 col-sm-10">
                   <div class="form-group">
                     <input type="submit" class="btn btn-primary btn-block" value="Edit category">
                   </div>
              </div>
           	


           </form>

        </div>
        </div>


  
  	<?php } elseif($do=='Update') {

                   
           $formerrors = array(); 
    $catid = $_POST['cat-id'];
   	$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
   	$parent = $_POST['parent'];

   	if(strlen($category)<3) {

   		$formerrors[] = 'The category can not be empty OR less than four chars' ;

   	}

   // check if item is exist or not 
   	$count == 0;
    if($parent == 0) {

        
          $check = $connec->prepare("SELECT * FROM categories WHERE category=? AND parent=0");
      $check->execute(array($category));

      $count = $check->rowCount();


    } else {
      $check = $connec->prepare("SELECT * FROM categories WHERE category=? AND parent=?");
      $check->execute(array($category,$parent));

      $count = $check->rowCount();
    }

   	if($count>0) {

   		$formerrors[] = 'This category is already exist ' ;
   	}
    
    if(empty($formerrors)) {

    
          $stmt1 = $connec->prepare("UPDATE categories SET category=?,parent=? WHERE cat_id=?");
          $stmt1->execute(array($category,$parent,$catid));
          
          echo "<div  class='alert alert-success'>The Category UPDATED Suuccessfully </div>";
          header('refresh:3;url=categories.php');
     }

                      
       else {


    	foreach ($formerrors as $error) {
    		 
    		echo "<div  class='alert alert-danger'>".$error. "</div>";
          header('refresh:3;url=categories.php?do=Edit&cat-id='.$catid.'');

    	}

    }

  }?>


 <?php
   
    include 'included/footer.php';

   }  else {  /////////////////////THE END ////////////////////

     header('location:login.php');
     exit();
 }
  
?>