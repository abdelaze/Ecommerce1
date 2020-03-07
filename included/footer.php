</div><br><br><br><br>
    <!-- Footer -->
      <footer class="text-center">CopyRight&copy;2018 Shantus Boutique</footer>
     <!-- End Footer -->
    
    <script>
      
      
      
         function detailsmodal(id){
      
           var data = {'id': id};
          
            jQuery.ajax({
               
                url:<?php echo BASEURL; ?>+'included/modaldetails.php',
                method:'GET',
                data:data,
                success: function (data){
                  jQuery('body').append(data);
                  jQuery('#detailsmodal').modal('toggle');

				  
                },

                error: function () {

                   alert("Some Thing Failed");
                }

          });


   // End function 

     }


     // add to cart function 

     function add_to_cart() {

         // alert('cart works');
        
         var error = '';
        var id = jQuery('#product_id').val();
        var quantity = jQuery('#quantity').val();
        var size = jQuery('#size').val();
        var available = jQuery('#available').val();

      //alert(parseInt(quantity)-parseInt(available));
        var data = jQuery('#add_product_from').serialize();

        if(quantity == '' || quantity == 0 || size == '') {
      
           error+='<p class="text-center text-danger">You should choose size and quantity</p>';

           $("#modal_errors").html(error);
           return;
            
        }

        else if (parseInt(quantity)>parseInt(available)) {
             error+='<p class="text-center text-danger">The Quantity can not be more than available</p>';
              $("#modal_errors").html(error);

              return;
        } else {

            jQuery.ajax({

                  url:'/ENGLISHECOMMERCE/admin/add_cart.php',

                  method:'GET',

                  data : data,

                  success : function (){
                     
                     location.reload();
                     
                  },

                  error : function (){

                      alert("Some Thing Goes Wrong ");
                  }



            });
        }

     }




     // make update cart function 


     function update_cart(mode,edit_id,edit_size) {

        var data = {'mode':mode,'edit_id':edit_id,'edit_size':edit_size};

        jQuery.ajax({
         
           url : '/ENGLISHECOMMERCE/admin/update_cart.php',

           method : 'POST',

           data : data,

           success : function () {

               location.reload();
        
           },

          error : function () {

              alert("Some Thing Falied");
          }

        });
     }



    </script>

     <script src='js/jquery-1.11.3.min.js'></script>

       <script src='js/bootstrap.min.js'></script>
       <script src='js/backend.js'></script>
   
</body>
</html>