<?php
   
    require_once 'connect.php';
    define('BASEURL', '/ENGLISHECOMMERCE/');
    
    define('CART_COOKIE','ABDELAZEMFOUAD');
    define('CART_COOKIE_EXPIRE',time()+(86400*30));


    $cart_id = '';

    if(isset($_COOKIE[CART_COOKIE])) {

    	 $cart_id = $_COOKIE[CART_COOKIE];
    }
    
















