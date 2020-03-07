<?php

  
   require_once 'admin/core/init.php';
   include 'included/header.php';
   include 'included/navbar.php';
   include 'included/functions/function.php';



   
if($cart_id =='') {

	 echo "<div class='alert alert-danger'>The Cart Is Empty</div>";
}

else {

	$i = 1;
	$item_count = 0;
    $sub_total =0;
    $tax =0;
    $grand_total = 0;
  $stmt1 = $connec->prepare("SELECT * FROM cart WHERE  id = ? ");
  
   $stmt1->execute(array($cart_id));

   $cart_items  = $stmt1->fetch();
  
   
    $items = json_decode($cart_items['items'],true);




?>
  
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
       <h2 class="text-center">My Shopping cart</h2>
      <div class="table-responsive">
        <table class="table table-bordered table-striped  main-table">
        	<thead>

        	    <th>#</th>
        	    <th>Item</th>
        	    <th>Price</th>
        	    <th>Qauntity</th>
        	     <th>Size</th>
        	      <th>Sub Total</th>
        		
        	</thead>

        	<tbody>
        		

        		<?php

   //{"id":"6","size":"sm","quantity":"3"}

                  foreach ($items as $item) {
                  	   

                
                  	     $product_id = $item['id'];

                  	     $stmt2 = $connec->prepare("SELECT * FROM product WHERE id = ?");

                  	     $stmt2->execute(array($product_id));

                  	     $product = $stmt2->fetch();
                  	     $sarray = explode(',',$product['sizes']);



                  	     foreach ($sarray as $size) {

                  	     	$s = explode(':',$size);

                  	     // echo $s[1]."   ";

                  	     	if($s[0] == $item['size']){

                  	     		if(!empty($s[1])) {
                  	     	   
                  	     	    $availbale = $s[1];

                  	     	    //echo $availbale."<br>";

                  	     	}

                  	        }
                  	     } // end for2


           if(!empty($item['id'])) {
                  	     ?>

                   
                       <tr> 
                      <td><?php echo $i; ?></td>

                      <td><?php echo $product['title']; ?></td>
                      
                     <td><?php echo Money($product['price']); ?></td>
                      <td>

                      <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?php echo $product['id'];?>','<?php  echo  $item['size']; ?>')">-</button>


                      <?php echo $item['quantity'];  ?>

                      


                      <?php  if($item['quantity'] == $availbale) {  ?>


                       <span class="text-danger">Max</span>

                       
                       <?php } else { ?>

                       <button class="btn btn-xs btn-default" onclick="update_cart('addone','<?php echo $product['id'];?>','<?php  echo  $item['size']; ?>')">+</button>
                        
                          <?php } ?>

                      </td>
                     <td><?php echo $item['size']; ?></td>
                     <td><?php echo Money($product['price']*$item['quantity']); ?></td>
                     </tr>
                      


                <?php 

   
                   $i++;

                    $item_count+=$item['quantity'];

                    $sub_total+=($product['price']*$item['quantity']);
                   
                   }
                   

                       
                 }
   

          
                    $tax = (0.087 * $sub_total);

                    $tax = number_format($tax,2);

                    $grand_total = $tax + $sub_total;
  
                   
                    
        		?>


        	</tbody>

        </table>
  

         <table class="table table-bordered table-striped table-responsive text-right">
         	
         	 <legend>Totals</legend>
         	 <thead>
         	 	 <th>Total Items</th>
         	 	 <th>Sub Total</th>
         	 	 <th>Tax</th>
         	 	 <th>Grand Total</th>
         	 </thead>

            <tbody>
            	
            	<tr>
            	  <td><?php echo $item_count;?></td>
            	   <td><?php echo Money($sub_total);?></td>
            	    <td><?php echo Money($tax);?></td>
            	     <td class="bg-success"><?php echo Money($grand_total);?></td>
            	</tr>
            </tbody>
         	 <tbody>
         	 	

         	 </tbody>
         </table>

         <!-- Button trigger modal -->
<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#mycheckout">
  <i class="fa fa-shopping-cart fa-fw"></i>checkout >>
</button>

<!-- Modal -->
<div class="modal fade" id="mycheckout" tabindex="-1" role="dialog" aria-labelledby="mycheckoutLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

         
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="mycheckoutLabel">Shipping Address</h4>
      </div>
      <div class="modal-body">

              <span class="bg-danger" id="modal_errors"></span>

             <div class="row">
              

                <form action="thankyou.php" method="POST" id="payment_form">
             
                  <div id="step1">

                    
                     <div class="form-group col-md-6">
                      <label for="full_name">Full Name:</label>
                      <input type="text" name="full_name" id="full_name" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="user_email">Email:</label>
                     <input type="email" name="user_email" id="user_email" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="street">Street Address:</label>
                     <input type="text" name="street" id="street" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="street2">Street Address2:</label>
                     <input type="text" name="street2" id="street2" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group col-md-6">
                      <label for="city">City:</label>
                     <input type="text" name="city" id="city" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="state">State:</label>
                     <input type="text" name="state" id="state" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="zip_code">Zip Code:</label>
                     <input type="text" name="zip_code" id="zip_code" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="country">Country</label>
                     <input type="text" name="country" id="country" class="form-control" autocomplete="off" required>
                    </div>
                </div>
                    


                 <div id="step2">
                   
                     <div class="form-group col-md-3">
                       <label for="card_name">Card  Name: </label>
                       <input type="text" name="card_name" class="form-control" id="card_name" autocomplete="off" required="">
                     </div>

                      <div class="form-group col-md-3">
                       <label for="card_number">Card  Number: </label>
                       <input type="text" name="card_number" class="form-control" id="card_number" autocomplete="off" required="">
                     </div>

                      <div class="form-group col-md-2">
                       <label for="card_cvc">CVC:</label>
                       <input type="text" name="card_cvc" id="card_cvc"  class="form-control" autocomplete="off" required="">
                     </div>

                      <div class="form-group col-md-2">
                       <label for="exp_month">expire_month: </label>
                       <select name="exp_month" id="exp_month" class="form-control">
                          <option value="0">...</option>

                          <?php
                           for ($i=1; $i<=12 ; $i++) { ?>
                              
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>

                         
                         <?php  } ?>
                       </select>
                      
                     </div>


                     <div class="form-group col-md-2">
                       <label for="exp_month">expire_year: </label>
                       <select name="exp_month" id="exp_month" class="form-control">
                          <option value="0">...</option>

                          <?php

                          $yr = date('Y');
                           for ($i=0 ; $i<=12 ; $i++) { ?>
                              
                                <option value="<?php echo $yr+$i; ?>"><?php echo $yr+$i; ?></option>

                         
                         <?php  } ?>
                       </select>
                      
                     </div>

                 </div>

          
          

          

        
       
 
    
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="next" onclick="checkAddress();">Next >> </button>
        <button type="button" class="btn btn-primary" id="back" onclick="backAddress();" style="display: none;"> << Back </button>
        <button type="submit" class="btn btn-primary" id='check' style="display:none;"> checkout >></button>
        </form>
      </div>
    </div>


  </div>
</div>
     </div>

    
<?php }  ?>

















<script>

   function backAddress () {

                    jQuery('#modal_errors').html("");

                       jQuery("#step1").css("display","block");

                       jQuery("#step2").css("display","none");

                       jQuery("#next").css("display","inline-block");

                       jQuery("#back").css("display","none");

                       jQuery("#check").css("display","none");

                        jQuery("#mycheckoutLabel").html('Shipping Address');

   }


  

   function checkAddress (){

        var data = {

         'full_name' : jQuery("#full_name").val(),
         'email' : jQuery("#user_email").val(),
         'street' : jQuery("#street").val(),
         'street2' : jQuery("#street2").val(),
         'city' : jQuery("#city").val(),
         'zip_code' : jQuery("#zip_code").val(),
          'country' : jQuery("#country").val(),
          'state' : jQuery("#state").val()
        }

        jQuery.ajax({

          url : '/ENGLISHECOMMERCE/admin/checkaddress.php',
          method: 'POST',
          data : data,
          success : function (data) {
                  
                  if(data) {

                       jQuery('#modal_errors').html(data);
                  }


                else {



                
                      

                       jQuery('#modal_errors').html("");

                       jQuery("#step1").css("display","none");

                       jQuery("#step2").css("display","block");

                       jQuery("#next").css("display","none");

                       jQuery("#back").css("display","inline-block");

                       jQuery("#check").css("display","inline-block");

                        jQuery("#mycheckoutLabel").html('check Card Data');



                     
                      
                }     

                  



          },

           error : function () {

                alert("something failed ");
           }

        });
   }

</script>




<?php  
   

         
    include 'included/footer.php';



?>