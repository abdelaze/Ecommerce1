<?php
  require_once  $_SERVER['DOCUMENT_ROOT'].'/ENGLISHECOMMERCE/admin/core/connect.php';


  $parentid = isset($_GET['parentID']) ? $_GET['parentID'] : '0';

   echo $parentid;
  
  $stmt = $connec->prepare("SELECT * FROM categories WHERE parent=?");
  $stmt->execute(array($parentid));

  $cats = $stmt->fetchAll();

  ob_start();
  ?>
  <option value="0">..</option>

  <?php
   foreach ($cats as $cat) {?>
   	  
     <option value="<?php echo $cat['cat_id'];?>"><?php echo $cat['category'];?></option>


  <?php } ?>

 <?php  echo  ob_get_clean(); ?>