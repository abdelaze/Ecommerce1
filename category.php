<?php

   require_once 'core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
    include 'included/leftsidebar.php';


    // select products from the data base

  $cat_id  = isset($_GET['catid']) &&is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

    $stmt = $connec->prepare("SELECT product.*,categories.category,categories.parent  FROM  product 

                               INNER JOIN categories 

                               ON  product.category_id  = categories.cat_id

                               WHERE product.category_id =?  AND featured=1");

    $stmt->execute(array($cat_id));

    $products = $stmt->fetchAll();

    $count = $stmt->rowCount();

 // echo $count;
 

    
  


              
    $stmt2 = $connec->prepare("SELECT c.cat_id,c.category  AS  child   ,p.cat_id, p.category AS parent  FROM                               
                              categories c

                               INNER JOIN categories p

                               ON  c.parent = p.cat_id

                       where c.cat_id=?");


    $stmt2->execute(array($cat_id));
    $category = $stmt2->fetch();
   


     
      
           



if($count>0) {

?>

   

                   

     <div class="col-md-8 col-sm-12">
       <div class="features">
          <div class="row">


 <h2 class="text-center"><?php echo  $category['parent'] .'-'. $category['child'] ;?></h2>
             
          
              
              <?php foreach ($products as $product) {?>


              
              
                 <div class="col-md-3">
                   <div class="Product">
                      <h4><?php echo $product['title']?></h4>
                      <img src="admin/uploads/avatars/<?php echo $product['image']; ?>" alt="<?php echo $product['title']?>" class="img-responsive center-block">
                      <p class="text-danger">List Price: <s>$<?php echo $product['list_price']?></s></p>
                      <p>Our Price: $<?php echo $product['price']?></p>
            <button type="button" class="btn btn-success btn-sm" onclick="detailsmodal(<?php echo $product['id'];?>)">Details</button>
                   </div>
                 </div>

                <?php } ?> 


              
               
           </div>




       </div>
       </div>

         

             
              <!-- End FEATURES-->

     
       <?php
           
           } else {

            echo "<div class='col-xs-12 col-md-8 alert alert-success'>There Is No Items To Show </div>";
       }

           include 'included/rightsidebar.php'; 

           include 'included/footer.php';

          
          
       ?>
    




  

  