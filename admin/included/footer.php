</div><br><br>
    <!-- Footer -->
      <footer class="text-center">CopyRight&copy;2018 Shantus Boutique</footer>
     <!-- End Footer -->
     

          <script src='js/jquery-1.11.3.min.js'></script>
         <!--<script src='js/jquery-ui.min.js'></script>
         <script src='js/jquery.selectBoxIt.min.js'></script>-->
         <script src='js/bootstrap.min.js'></script>
         <script src='js/backend.js'></script>
        


            <script>

            function getChild() {
                 var parentID  = jQuery("#parent").val();
                 
                  var data = {'parentID' : parentID};
               jQuery.ajax({
                   
                   url:'/ENGLISHECOMMERCE/admin/parser/childs.php',
                   method:'GET',
                   data: data,
                   success:function (data) {
                    
                        jQuery('#childscat').html(data);


                    },
                    error:function (){
                      alert("something failed");
                    }

               });
            }  

            jQuery("select[name='pcategory']").change(getChild);
          
       
             

              function updateSizes() {
                 
                   //alert("sizes updated");
                  var sizestring = '';
                   for(var i=1;i<=12;i++) {
                      if(jQuery('#size'+i).val()!='') {
                          
                         sizestring+=jQuery('#size'+i).val() + ':' +jQuery('#quantity'+i).val()+','; 
                      }
                      
                   }

                   jQuery('#sizespreview').val(sizestring);
              }



              function updateSizes2() {
                 
                   //alert("sizes updated");
                  var sizestring = '';
                   for(var i=0;i<12;i++) {
                      if(jQuery('#size'+i).val()!='') {
                          
                         sizestring+=jQuery('#size'+i).val() + ':' +jQuery('#quantity'+i).val()+','; 
                      }
                      
                   }

                   jQuery('#sizespreview').val(sizestring);
              }



         </script>



   
      

</body>
</html>