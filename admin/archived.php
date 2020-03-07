<?php
   session_start();
$pagetitle='Archived products';
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

                               WHERE deleted=1");


    $stmt1->execute();

    $products = $stmt1->fetchAll();
    $count = $stmt1->rowCount();

    // make product featured or not
  
   
 ?>


<?php



   if($do == 'manage') { 
  
       if($count>0) { ?>
             
          <h2 class="main-head text-center">Archived Products</h2>

          <div class="table-responsive">
                
                <table class="table table-bordered table-striped">
                  
                   <thead>
                      <th></th>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Category</th>
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
                                <a href="archived.php?do=Archived&product-id=<?php echo $product['id'] ?>" class='btn btn-xs btn-default'>
                                <i class="fa fa-refresh"></i>
                               </a>
                              
                              </td>

                              <td><?php echo $product['title'] ?></td>
                              <td><?php echo Money($product['price']) ?></td>
                               <td><?php echo $parent['category'].'-'.$product['category'] ?></td>
                              
                              <td>0</td>
                            </tr>


                      <?php  } ?>


                   </tbody>

                </table>
 
            
          </div>     
    
  <?php  }} elseif ($do == 'Archived') {
             


                $product_id = isset($_GET['product-id'])&& is_numeric($_GET['product-id']) ? $_GET['product-id'] : 0;

             $stmt8  = $connec->prepare("UPDATE product SET deleted=0 WHERE id=?");

            $stmt8->execute(array($product_id));

            $product = $stmt8->fetch();
            $count   = $stmt8->rowCount();

            if($count>0) {

                   echo "<div class='alert alert-success'>".$stmt8->rowCount()." record restored "."</div>";
                      
                    header('refresh:3;url=products.php');
            } 
  } else {
        echo "<div class='alert alert-success'>You Cannot browse This Page directly </div>";
                      
                    header('refresh:3;url=products.php');
  } ?>




  <?php
   
    include 'included/footer.php';
      }  else {  /////////////////////THE END ////////////////////

     header('location:login.php');
     exit();
 }
  
  
?>
