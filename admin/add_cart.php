 <?php

   include 'core/init.php';
   include 'included/header.php';
   include 'included/functions/function.php';

   // receive data using ajax when click  into add to cart button 


   $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : '0';

   echo $product_id."<br>";
    $available = isset($_GET['available']) ? $_GET['available'] : '';
    $size = isset($_GET['size']) ? $_GET['size'] : '';
    $quantity = isset($_GET['quantity']) ? $_GET['quantity']: '';
    $item = array();
    $item[] = array(
     
     'id'       =>$product_id,

     'size'     => $size,

     'quantity' =>$quantity,

   );


    $domain = ($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;


// check if cookie is set or not 
if($cart_id !='') {

	echo "HELLO";
	echo $cart_id;

    $stmt1 = $connec->prepare("SELECT * FROM cart WHERE id=?");
    $stmt1->execute(array($cart_id));
    $cart_item = $stmt1->fetch();

   // echo $stmt1->rowCount();

    echo $cart_item['items'];



    $previous_items = json_decode($cart_item['items'],true);
    
    
    
   $items_match = 0;

   $new_item = array();

   foreach ($previous_items as $pitem) {

   	  if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size'] ){

   	  	   $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity']; 

   	  	if($pitem['quantity'] > $available ) {

   	  		 $pitem['quantity'] = $available; 
   	  	}


   	  	$items_match = 1;

   	  }

   	  $new_item[] = $pitem;

   } 


  if($items_match !=1) {

   	  $new_item = array_merge($item,$previous_items);
   }
   
    $item2_json = json_encode($new_item);
 
    $cart_expire = date('Y-m-d H:i:s',strtotime("+30 days")); 
   
    $stmt3 = $connec->prepare("UPDATE cart SET items=?,expire_date=? WHERE id=?");

    $stmt3->execute(array($item2_json,$cart_expire,$cart_id));

    setcookie(CART_COOKIE,'',1,'/',$domain,false);
    setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);

} 


 else {

	  // add the cart to the data base and set cookie 

	$item_json = json_encode($item);

	$cart_expire = date('Y-m-d H:i:s',strtotime("+30 days"));
	
	  $stmt2 = $connec->prepare("INSERT INTO cart(items,expire_date) VALUES(:zitem,:zexpire)");

	  $stmt2->execute(array(


	  	    'zitem'     =>$item_json,

	  	    'zexpire'   => $cart_expire

	 )); 

	  $cart_id = $stmt2->mysql_insert_id();
     


	  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}



























include 'included/footer.php';
