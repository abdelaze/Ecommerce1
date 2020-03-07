
  

<!-- Detils Modal -->

 
  <?php
    
      require_once '../core/init.php';
      
      $id = $_GET['id'];
      $id = (int)$id;
      $stmt = $connec->prepare("SELECT  product.*,brand.brand_name AS brand_name FROM product

                                 INNER JOIN brand

                                ON  product.brandid = brand.brand_id 

                                WHERE product.id=?");

      $stmt->execute(array($id));

      $details = $stmt->fetch();  

      $sizesarr = explode(',',$details['sizes']); 
 

   
  ?>

 <?php  ob_start(); ?>
  
  <div class="modal fade" id="detailsmodal" tab-index="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
  
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
    <div class="modal-header">
         <button type="button" class="close" onclick="closeModal()" aria-label="Close"><span aria-hidden="true">&times;</span></button>

       <h4 class="modal-title text-center"><?php echo $details['title']?></h4>
       
    </div>
    
     <div class="modal-body">
       <div class="container-fluid">
         <div class="row">
            <span id="modal_errors" class="bg-danger"></span>
           <div class="col-sm-6">
             

             <img src="/ENGLISHECOMMERCE/admin/uploads/avatars/<?php echo $details['image']?>" class="img-responsive center-block details">
            
           </div>
           <div class="col-sm-6">
             <h4>Details</h4>
             <p><?php echo $details['description']?></p>
             <hr>
             <p>Price:$<?php echo $details['price']?></p>
             <p>Brand:<?php echo $details['brand_name']?></p>
             
             <form action="add_cart.php" method="POST" id="add_product_from">

             <input type="hidden" name="product_id" id='product_id' value="<?php echo $details['id']; ?>">
             <input type="hidden" name="available" id="available">
             <div class="form-group">
               
               <label for="quantity">Quantity:</label>
               <input type="number" min="0" id="quantity" name="quantity" class="form-control">
               
             </div>
          
             
             <div class="form-group">
               <label for="size">Sizes</label>
               <select class="form-control" id="size" name="size">
               <option value=""></option>

               <?php
                  foreach ($sizesarr as $string) {
                      
                      $stringarr = explode(':', $string);

                      $size =  $stringarr[0];
                      $available = $stringarr[1];



                    echo   '<option value="'.$size.'" data-available="'.$available.'">'.$size.'(available '.$available.')</option>';
                  }
               ?>


                
                  
                
                 
                 
               </select>
             </div>

             </form>
             
             
           </div>
         </div>
       </div>
            
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="closeModal()">Close</button>
        <button type="button" onclick="add_to_cart(); return false;" class="btn btn-warning"> <i class='fa fa-shopping-cart'></i>ADD TO CART</button>
      </div>
    
   </div>
   </div>

 
  
    </div>

    <script>


      jQuery('#size').change(function(){

           var available = jQuery('#size option:selected').data('available');
           $("#available").val(available);

        //   alert(available);

      });
      
        function closeModal() {
             
            jQuery("#detailsmodal").modal('hide');

            setTimeout(function(){
                jQuery("#detailsmodal").remove();

            },500)
        }

    </script>

        
 


  <?php echo ob_get_clean(); ?>

