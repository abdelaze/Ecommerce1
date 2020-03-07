<?php
  include 'core/init.php';


  $mode = isset($_POST['mode']) ? $_POST['mode'] : '';



  $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : '';
  $edit_size = isset($_POST['edit_size']) ? $_POST['edit_size'] : '';

  $stmt1 = $connec->prepare("SELECT * FROM cart where id = ? ");

  $stmt1->execute(array($cart_id));

  $cart_items = $stmt1->fetch();

  $items = json_decode($cart_items['items'],true);
  
   $updated_items = array();
  if($mode == 'addone') {

  	   foreach ($items as $item) {
  	   	   if($item['id'] == $edit_id && $item['size'] == $edit_size) {
                
                $item['quantity'] = $item['quantity'] + 1;
  	   	   }

  	   	   $updated_items[] = $item;
  	 
  	   }
  }



  if($mode == 'removeone') {

  	   foreach ($items as $item) {
  	   	   if($item['id'] == $edit_id && $item['size'] == $edit_size) {
                
                $item['quantity'] = $item['quantity'] - 1;
  	   	   }

  	   	   if($item['quantity'] > 0 ) {

  	   	      $updated_items[] = $item;

  	   	   }
  	   }
  }


  if(!empty($updated_items)) {
  	 
  	   $updated_json =  json_encode($updated_items);
       $stmt2 = $connec->prepare("UPDATE cart SET items=? WHERE id=?");
       $stmt2->execute(array($updated_json,$cart_id));

  }

  if(empty($updated_items)) {

  	   $stmt3 = $connec->prepare("DELETE FROM cart WHERE id=?");

  	   $stmt3->execute(array($cart_id));

  	   setcookie(CART_COOKIE,'',1,"/",localhost,false);
  }
?>














<?php
  include 'included/footer.php';
?>