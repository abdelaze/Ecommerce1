<?php

  session_start(); 
  $pagetitle='Products';
 if(isset($_SESSION['admin_user_name'])) {

   include 'core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
   include 'included/functions/function.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';


    // show all catrgories

     $stmt1 = $connec->prepare("SELECT product.*,categories.category,categories.parent FROM  product 

                               INNER JOIN categories

                               ON product.category_id = categories.cat_id 

                               WHERE deleted=0");


    $stmt1->execute();

    $products = $stmt1->fetchAll();
    $count = $stmt1->rowCount();

    // make product featured or not
  
    if(isset($_GET['featured'])&& $_GET['featured']=='minus') {

         $pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? intval($_GET['pid']) : 0 ;
         $stmt3 = $connec->prepare("UPDATE product SET featured=1 WHERE id=?");
         $stmt3->execute(array($pid));
         header('Location:products.php');
    }  

     if(isset($_GET['featured'])&& $_GET['featured']=='plus') {

         $pid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? intval($_GET['pid']) : 0 ;
         $stmt3 = $connec->prepare("UPDATE product SET featured=0 WHERE id=?");
         $stmt3->execute(array($pid));
          header('Location:products.php');
    }  
 ?>


<?php



   if($do == 'manage') { 
  
       if($count>0) { ?>
             
          <h2 class="main-head text-center">Products</h2>

          <div class="table-responsive">
                
                <table class="table table-bordered table-striped">
                  
                   <thead>
                      <th></th>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Category</th>
                      <th>Featured</th>
                      <th>Sold</th>
                   </thead>
                   <tbody>
                       
                      <?php foreach ($products as $product) { 

                            // select parent of each category that products  belongs to .

                            $stmt2 = $connec->prepare("SELECT * FROM  categories  WHERE cat_id=?");


                            $stmt2->execute(array($product['parent'])); 

                            $parent = $stmt2->fetch();
                            
                            ?>
                       
                            <tr>
                              <td>
                                <a href="products.php?do=Edit&product-id=<?php echo $product['id'] ?>" class='btn btn-xs btn-default'>
                                <i class="fa fa-pencil"></i>
                               </a>
                               <a href="products.php?do=Delete&product-id=<?php echo $product['id'] ?>" class='btn btn-xs btn-default'>
                               <i class="fa fa-remove"></i>
                              </a>
                              </td>

                              <td><?php echo $product['title'] ?></td>
                              <td><?php echo Money($product['price']) ?></td>
                               <td><?php echo $parent['category'].'-'.$product['category'] ?></td>
                              <td>
                          <?php
                             if($product['featured']==0) {?>
                                   
                                   <a href="products.php?featured=minus&pid=<?php echo $product['id']; ?>" class='btn btn-default btn-xs'>
                                      <i class='fa fa-minus'></i>
                                   </a>
                                    Featured product 
                            <?php }  else { ?>
                                
                                         <a href="products.php?featured=plus&pid=<?php echo $product['id']; ?>" class='btn btn-default btn-xs'>  
                                          <i class='fa fa-plus'></i>
                                          </a>   
                                 <?php } ?>
                          
                              </td>
                              <td>0</td>
                            </tr>


                      <?php  } ?>


                   </tbody>

                </table>
 
            
          </div>     
    
  <?php  } ?>  <a href="products.php?do=Add" class='btn btn-primary'>
                               
                Add Product   <i class="fa fa-plus"></i>
             </a>
 <?php }   elseif ($do == 'Add') { ?>
         
                 <h2 class='main-head text-center'>Add product </h2>

               
                 <form action="?do=Insert" method="POST" enctype="multipart/form-data">
                      
                   
                    <div class="form-group col-md-3">
                         <label for="title">title*:</label>
                         <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                    </div>
                      <div class="form-group col-md-3">
                         <label for="brand">brand*:</label>
                         <select name="brand" class="form-control" id="brand">
                            <option value="0">...</option>
                            <?php
                              
                              $stmt5 = $connec->prepare("SELECT * FROM brand ORDER BY brand_name");
                              $stmt5->execute();
                              $brands = $stmt5->fetchAll();

                              foreach ($brands as $brand) {?>
                                  
                             
                                 <option value="<?php echo $brand['brand_id'];?>"> 
                                 <?php echo $brand['brand_name'];?>
                                 </option>
                                

                           <?php } ?>
                         </select>
                    </div>


                     <div class="form-group col-md-3">
                         <label for="parent">Parent category*:</label>
                         <select name="pcategory" class="form-control" id="parent">
                            <option value="0">...</option>
                            <?php

                               
                              
                              
                              $stmt6 = $connec->prepare("SELECT * FROM categories WHERE parent=0  ORDER BY category");
                              $stmt6->execute();
                              $cats = $stmt6->fetchAll();

                              foreach ($cats as $cat) {?>
                                  
                             
                                 <option value="<?php echo $cat['cat_id'];?>"> 
                                 <?php echo $cat['category'];?>
                                 </option>
                                

                           <?php } ?>
                         </select>
                    </div>

                    <div class="form-group col-md-3">

                         <label for="childscat">Child category*:</label>
                         <select name="childcat" class="form-control" id="childscat">
                             
                               
                         </select>
                    </div>



                     <div class="form-group col-md-3">
                         <label for="price">price*:</label>
                         <input type="text" class="form-control" id="price" name="price">
                    </div>


                    <div class="form-group col-md-3">
                         <label for="price">Listprice*:</label>
                         <input type="text" class="form-control" id="listprice" name="listprice">
                    </div>

                     <div class="form-group col-md-3">
                         <label for="sizes">Sizes&Quantity</label>
                         <button class="btn btn-default form-control"  onclick="jQuery('#sizesModal').modal('toggle');return false;">Sizes&Quantity</button>
                    </div>

                    

                    <div class="form-group col-md-3">
                         <label for="sizespreview">Sizes&Quantity preview</label>
                         <input type="text" name="sizepreview" id="sizespreview" class="form-control" readonly>

                         
                    </div>

                     <div class="form-group col-md-6">
                         <label for="image">Image</label>
                         <input type="file" value="choose image" name="image" id="image" class="form-control" >

                         
                    </div>

                     <div class="form-group col-md-6">
                         <label for="desc">Description</label>
                         <textarea name="desc" id="desc" class="form-control" rows="6">

                         </textarea>                         
                    </div>

                     <div class="form-group col-md-offset-9 col-md-3">
                          
                          <input type="submit" value="Add product" class="btn btn-success form-control">
                                                 
                    </div>
                 
                 </form>

         


  <!-- Start Moal -->

    <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModal">Sizes&Quantity</h4>
      </div>
      <div class="container-fluid">
      <div class="modal-body">
          <?php
           
            for($i=1;$i<=12;$i++) { ?>
                <div class="form-group col-md-4">
                    <label for="size<?php echo $i ?>">Size:</label>
                    <input type="text" name="size<?php echo $i ?>" id="size<?php echo $i ?>" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="quantity<?php echo $i ?>">Quantity:</label>
                    <input type="number" name="quantity<?php echo $i ?>" id="quantity<?php echo $i ?>" class="form-control" min="0">
                </div>
          <?php } ?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <?php  }   elseif($do == 'Insert') {  


 

           
           if($_SERVER['REQUEST_METHOD']=='POST') {
   
               echo '<h2 class="text-center">INSERT Product</h2>';


               // recieve image data 

           // echo print_r($_FILES['avatar']);


              $avatarname = $_FILES['image']['name'];
               $avatarsize = $_FILES['image']['size'];
               $avatartype = $_FILES['image']['type'];
               $avatartmp = $_FILES['image']['tmp_name'];

               $avatarextensions = array('jpeg','jpg','gif','png');

               $extension = strtolower(end(explode('.',$avatarname)));

                $title = $_POST['title'];
                $brand = $_POST['brand'];
                $pcategory = $_POST['pcategory'];
                $childcat = $_POST['childcat'];
                $price = $_POST['price'];
                $listprice = $_POST['listprice'];
                $sizesstring = rtrim($_POST['sizepreview'],',');
                $desc = $_POST['desc'];

               
                   
                 $formerrors=array();


        
                      if(strlen($title)<5) {
                               
                               $formerrors[] = 'title cannot be less than 5';

                      }

                      if(strlen($title)>20) {
                           
                               $formerrors[] = 'title cannot be more than 20';
                      }

                      if(empty($title)) {
                               
                               $formerrors[] = 'titlecannot be empty';

                      }

                       if($brand == 0) {
                               
                               $formerrors[] = 'brand cannot be Zero';

                      }

                      
                       if($pcategory == 0) {
                               
                               $formerrors[] = 'pcategory cannot be Zero';

                      }

                       if($childcat == 0) {
                               
                               $formerrors[] = 'child category cannot be Zero';

                      }



                      if(empty($price)) {
                               
                               $formerrors[] = 'price cannot be empty';

                      }

                       if(empty($listprice)) {
                               
                               $formerrors[] = 'list cannot be empty';

                      }

                      if(!empty($avatarname) && !in_array($extension, $avatarextensions)) {

                              $formerrors[] = ' This Extension Is Not Allowed ';
                      }

                      if(empty($avatarname)) {

                          $formerrors[] = ' This Avatar Is Required ';
                      }
                      
                      if($avatarsize > 4194304) {

                            $formerrors[] = ' This Avatar cannot Be More Than 4MB ';
                      }

                      
                      

              foreach ($formerrors as  $error) {
                              
                           

                echo '<div class="alert alert-danger">'.$error."</div>";

                           
              }

              
            

                    if(empty($formerrors)) {

                      $avatar = rand(0,1000000000).'_'.$avatarname;

                    move_uploaded_file($avatartmp, "uploads\avatars\\".$avatar);

                   
                     

                      $stmt7 = $connec->prepare("INSERT INTO  product(

                                               title,price,list_price,description,image,brandid,category_id,sizes)

                                  VALUES(:ztitle,:zprice,:zlist_price,:zdesc,:zavatar,:zbrand,:zcat,:zsizes)");
                      $stmt7->execute(array(

                        ':ztitle'=>  $title,
                        ':zprice'=>  $price,
                        ':zlist_price'=>  $listprice,
                        ':zdesc'=>  $desc,
                        ':zavatar'=>  $avatar,
                        ':zbrand'=>  $brand,
                        ':zcat'=>  $childcat,
                        ':zsizes'=> $sizesstring
                        
                       
                      

                      ));

                      echo "<div class='alert alert-success'>".$stmt7->rowCount()." record insrted "."</div>";
                      
                     header('refresh:3;url=products.php');

              }
            }

          

            else {

               echo '<div class="alert alert-danger">you cannot browse directly</div>'; 
               header('refresh:3;url=products.php');
             
             } 



   } elseif($do == 'Edit') {


    $product_id = isset($_GET['product-id'])&& is_numeric($_GET['product-id']) ? $_GET['product-id'] : 0;

    $stmt8  = $connec->prepare("SELECT * FROM product WHERE id=?");

    $stmt8->execute(array($product_id));

    $product = $stmt8->fetch();



    ?>

     <h2 class='main-head text-center'>Edit product </h2>
                 <form action="?do=Update" method="POST" enctype="multipart/form-data">

                 <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                      <div class="form-group col-md-3">
                         <label for="title">title*:</label>
                         <input type="text" class="form-control" id="title" name="title" autocomplete="off" value="<?php echo $product['title'] ?>">
                    </div>
                      <div class="form-group col-md-3">
                         <label for="brand">brand*:</label>
                         <select name="brand" class="form-control" id="brand">
                            
                            <?php
                              
                              $stmt5 = $connec->prepare("SELECT * FROM brand ORDER BY brand_name");
                              $stmt5->execute();
                              $brands = $stmt5->fetchAll();

                              foreach ($brands as $brand) { ?>
                                  
                             
                                 <option value="<?php echo $brand['brand_id'];?>" <?php if($product['brandid'] == $brand['brand_id']) { echo 'selected';} ?>> 

                                 <?php echo $brand['brand_name'];?>
                                 </option>
                                

                           <?php } ?>
                         </select>
                    </div>


                     <div class="form-group col-md-3">
                         <label for="parent">Parent category*:</label>
                         <select name="pcategory" class="form-control" id="parent">
                           
                            <?php

                              $stmt9 = $connec->prepare("SELECT parent  FROM categories WHERE cat_id=?");
                              $stmt9->execute(array($product['category_id']));
                              $category = $stmt9->fetch();
                              

                              
                              $stmt6 = $connec->prepare("SELECT * FROM categories WHERE parent=0  ORDER BY category");
                              $stmt6->execute();
                              $cats = $stmt6->fetchAll();

                              foreach ($cats as $cat) {?>
                                  
                                
                                 <option value="<?php echo $cat['cat_id'];?>" <?php if($category['parent'] == $cat['cat_id']) { echo 'selected';} ?>> 
                                 <?php echo $cat['category'];?>
                                 </option>
                                

                           <?php } ?>

                         </select>
                    </div>

                    <div class="form-group col-md-3">
                         <label for="childcat">Child category*:</label>

                       <?php 
                          $stmt9 = $connec->prepare("SELECT parent  FROM categories WHERE cat_id=?");
                              $stmt9->execute(array($product['category_id']));
                              $category = $stmt9->fetch();
                              

                              
                              $stmt6 = $connec->prepare("SELECT * FROM categories WHERE parent=?");
                              $stmt6->execute(array($category['parent']));
                              $cats = $stmt6->fetchAll();
                             
                          
                          ?>

                         <select name="childcat" class="form-control" id="childscat">
                               
                                <?php 
                                  foreach ($cats as $cat) {?>

                                       <option value="<?php echo $cat['cat_id'] ?>" <?php if($product['category_id'] == $cat['cat_id']) { echo 'selected';} ?>>
                                           
                                            <?php echo $cat['category'] ?>
                                           
                                       </option>

                                <?php   }  ?>
                           
                         </select>
                    </div>

                     <div class="form-group col-md-3">
                         <label for="price">price*:</label>
                         <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']?>" value="<?php echo $product['price']?>">
                    </div>


                    <div class="form-group col-md-3">
                         <label for="price">Listprice*:</label>
                         <input type="text" class="form-control" id="listprice" name="listprice" value="<?php echo $product['list_price'];?>">
                    </div>

                     <div class="form-group col-md-3">
                         <label for="sizes">Sizes&Quantity</label>
                         <button class="btn btn-default form-control"  onclick="jQuery('#sizesModal').modal('toggle');return false;">Sizes&Quantity</button>
                    </div>


                    

                    <div class="form-group col-md-3">
                         <label for="sizespreview">Sizes&Quantity preview</label>
                         <input type="text" name="sizepreview" id="sizespreview" class="form-control" value="<?php echo $product['sizes']?>" readonly>

                         
                    </div>

                     <div class="form-group col-md-6">
                         <label for="image">Image</label>
                         <input type="hidden" name="saved_image" value="<?php echo $product['image']; ?> ">
                         <input type="file" value="choose image" name="image" id="image" class="form-control" >

                         
                    </div>

                     <div class="form-group col-md-6">
                         <label for="desc">Description</label>
                         <textarea name="desc" id="desc" class="form-control" rows="6">
                              <?php echo $product['description']; ?>
                         </textarea>                         
                    </div>

                     <div class="form-group col-md-offset-9 col-md-3">
                          
                          <input type="submit" value="Edit product" class="btn btn-success form-control">
                                                 
                    </div>
       


                 </form>




    

           <!-- Start Moal -->

    <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModal">Sizes&Quantity</h4>
      </div>
      <div class="container-fluid">
      <div class="modal-body">
          <?php
           
          

            $sizesString = $product['sizes'];

            $stringarr = explode(',',$sizesString);
            
           
            for($i=0;$i<count($stringarr);$i++) {
                 
                  $sizes2 = explode(':', $stringarr[$i]);

                  $s1 = $sizes2[0];
                  $s2 = $sizes2[1];?>

                  <div class="form-group col-md-4">
                    <label for="size<?php echo $i ?>">Size:</label>
                    <input type="text" name="size<?php echo $i ?>" id="size<?php echo $i ?>" class="form-control" value="<?php echo $s1; ?>">
                </div>
                <div class="form-group col-md-2">
                    <label for="quantity<?php echo $i ?>">Quantity:</label>
                    <input type="number" name="quantity<?php echo $i ?>" id="quantity<?php echo $i ?>" class="form-control" min="0" value="<?php echo $s2; ?>">
                </div>
  
                 
          <?php  }

            ?>

            <?php for($i=count($stringarr);$i<12;$i++) {  ?>

                <div class="form-group col-md-4">
                    <label for="size<?php echo $i ?>">Size:</label>
                    <input type="text" name="size<?php echo $i ?>" id="size<?php echo $i ?>" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="quantity<?php echo $i ?>">Quantity:</label>
                    <input type="number" name="quantity<?php echo $i ?>" id="quantity<?php echo $i ?>" class="form-control" min="0">
                </div>
          <?php } ?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes2();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>















    <?php  } elseif ($do=='Update') {
         
                echo '<h2 class="text-center">Update Product</h2>';


               // recieve image data 

           // echo print_r($_FILES['avatar']);
 
             $id = $_POST['product_id'];  

                              
              $avatarname = $_FILES['image']['name'];

               if(!empty($avatarname)) {
               $avatarsize = $_FILES['image']['size'];
               $avatartype = $_FILES['image']['type'];
               $avatartmp = $_FILES['image']['tmp_name'];

               $avatarextensions = array('jpeg','jpg','gif','png');

               $extension = strtolower(end(explode('.',$avatarname)));

                if(!empty($avatarname) && !in_array($extension, $avatarextensions)) {

                              $formerrors[] = ' This Extension Is Not Allowed ';
                      }

                     
                      
                      if($avatarsize > 4194304) {

                            $formerrors[] = ' This Avatar cannot Be More Than 4MB ';
                      }


             }

               else {

                    $avatar = $_POST['saved_image'];

                   
               } 

                $title = $_POST['title'];
                 
                $brand = $_POST['brand'];
               
                $pcategory = $_POST['pcategory'];

                
                $childcat = $_POST['childcat'];
                $price = $_POST['price'];
                $listprice = $_POST['listprice'];
                $sizesstring = rtrim($_POST['sizepreview'],',');
                $desc = $_POST['desc'];

               
                   
                 $formerrors=array();


        
                      if(strlen($title)<4) {
                               
                               $formerrors[] = 'title cannot be less than 5';

                      }

                      if(strlen($title)>20) {
                           
                               $formerrors[] = 'title cannot be more than 20';
                      }

                      if(empty($title)) {
                               
                               $formerrors[] = 'titlecannot be empty';

                      }

                       if($brand == 0) {
                               
                               $formerrors[] = 'brand cannot be Zero';

                      }

                      
                       if($pcategory == 0) {
                               
                               $formerrors[] = 'pcategory cannot be Zero';

                      }

                       if($childcat == 0) {
                               
                               $formerrors[] = 'child category cannot be Zero';

                      }



                      if(empty($price)) {
                               
                               $formerrors[] = 'price cannot be empty';

                      }

                       if(empty($listprice)) {
                               
                               $formerrors[] = 'list cannot be empty';

                      }

                     
                      
                      

              foreach ($formerrors as  $error) {
                              
                           

                echo '<div class="alert alert-danger">'.$error."</div>";

                           
              }

              
            

                    if(empty($formerrors)) {

                     if(!empty($avatarname)) {

                      $avatar = rand(0,1000000000).'_'.$avatarname;

                      move_uploaded_file($avatartmp, "uploads\avatars\\".$avatar);

                  }  

                   
                     

                      $stmt8 = $connec->prepare("UPDATE product SET title =?,price =?,list_price =?,description=?, image=?,brandid=?,category_id=?,sizes=? WHERE id=?");
                      $stmt8->execute(array( $title,$price,$listprice,$desc,$avatar,$brand,$childcat,$sizesstring,$id));

                      echo "<div class='alert alert-success'>".$stmt8->rowCount()." record Updated "."</div>";
                      
                    header('refresh:3;url=products.php');

              }
            

          

            else {

               echo '<div class="alert alert-danger">you cannot browse directly</div>'; 
               header('refresh:3;url=products.php');
             
             } 
    }  elseif ($do == 'Delete') {
          
             $product_id = isset($_GET['product-id'])&& is_numeric($_GET['product-id']) ? $_GET['product-id'] : 0;

             $stmt8  = $connec->prepare("UPDATE product SET deleted=1 WHERE id=?");

            $stmt8->execute(array($product_id));

            $product = $stmt8->fetch();
            $count   = $stmt8->rowCount();

            if($count>0) {

                   echo "<div class='alert alert-success'>".$stmt8->rowCount()." record Deleted "."</div>";
                      
                    header('refresh:3;url=products.php');
            }
    } ?>   






 



 





<?php
   
    include 'included/footer.php';

    } else {  /////////////////////THE END ////////////////////

     header('location:login.php');
     exit();
 }
  
?>



