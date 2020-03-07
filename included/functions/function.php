<?php

include  $_SERVER['DOCUMENT_ROOT'].'/ENGLISHECOMMERCE/admin/core/connect.php';
  

 


 function checkItem($item,$table,$value)
{

	global $connec;
    
     
     $stmt = $connec->prepare("SELECT $item FROM $table WHERE $item=?");
     $stmt->execute(array($value));
     return $stmt->rowCount(); 
    
}

function displayMessage($msg,$url='null'){
  
      if($url==null) {

        	$url='index.php';
            $link = 'home page';
        }
        else {

        	if(isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTTP_REFERER'])) {

        		$url = $_SERVER['HTTP_REFERER'];
        	    $link = 'previous page';
        	}
        	else {

        		$url= 'index.php';
        		$link = 'home page';
        	}
        }
      
        echo $msg;

     echo '<p class="bg-danger">'.$msg.'</p>';
     header('refresh:3;url=$url');
     exit();
}



// function return price in right format 

function Money($number)
{
    return '$'.number_format($number,2);
}
