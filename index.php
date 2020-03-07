<?php

   require_once 'core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
    include 'included/leftsidebar.php';


    // select products from the data base

    $stmt = $connec->prepare("SELECT * FROM product WHERE featured=1");

    $stmt->execute();

    $products = $stmt->fetchAll();


?>

   

                   

     <div class="col-md-8 col-sm-12">
       <div class="features">
          <div class="row">
           <h2 class="text-center">Featured Products</h2>
          
              
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
           

           include 'included/rightsidebar.php'; 

           include 'included/footer.php';

          
          
       ?>
    




  

  