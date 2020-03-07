<?php

include  $_SERVER['DOCUMENT_ROOT'].'/ENGLISHECOMMERCE/admin/core/connect.php';
  

 


 function checkItem($item,$table,$value)
{

	global $connec;
    
     
     $stmt = $connec->prepare("SELECT $item FROM $table WHERE $item=?");
     $stmt->execute(array($value));
     return $stmt->rowCount(); 
    
}

function Redirect($msg,$url=null,$seconds=5) {
        
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

        echo "<div class='alert alert-info'>you will be redirected to $link in $seconds seconds </div>";

        header("refresh:$seconds;url=$url");
        exit();
 }


// function return price in right format 

function Money($number)
{
    return '$'.number_format($number,2);
}
